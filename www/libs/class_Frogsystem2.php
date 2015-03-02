<?php
/**
 * @file     class_Frogsystem2.php
 * @folder   /libs
 * @version  0.1
 * @author   Sweil
 *
 * The main class and entrypoint for all scripts.
 * Requires nothing but may consider predefined constants.
 * 
 */

use Frogsystem2\Event\EventLoader;
use Frogsystem2\Event\EventManager;
use Frogsystem2\Event\EventManagerInterface;

class Frogsystem2 {

    const EVENT_STARTUP = 'eventStartUp';
    const EVENT_ADMIN = 'eventAdmin';
    const EVENT_REGULAR_PAGE = 'eventRegularPage';
    const EVENT_RENDER = 'eventRender';
    const EVENT_SHUTDOWN = 'eventShutdown';
    
    private $root;
    
    public function __construct($root = null) {
        // Set internal root and FS2SOURCE fallback
        if (!$root) {
             $root = realpath(__DIR__.'/../');
        }
        $this->root = $root;
        @define('FS2SOURCE', $this->root);

        // include functions and Exceptions
        require_once(FS2SOURCE . '/libs/functions.php');
        
        // Init the class
        $this->init();
    }
    
    public function init() {
        // Set constants
        define('FS2ADMIN', FS2SOURCE.'/admin');
        
        // Content Constants
        @define('FS2CONFIG', $this->root.'/config');
        @define('FS2LANG', FS2SOURCE.'/lang');
        @define('FS2CONTENT', $this->root);
        @define('FS2APPLETS', FS2CONTENT.'/applets');
        @define('FS2MEDIA', FS2CONTENT.'/media');
        @define('FS2STYLES', FS2CONTENT.'/styles');
        @define('FS2UPLOAD', FS2CONTENT.'/upload');
        @define('FS2EVENTS', FS2CONTENT.'/event');

        // Defaults for other constants
        @define('IS_SATELLITE', false);
        @define('FS2_DEBUG', false);
        @define('FS2_ENV', 'production');
        
        // Disable error_reporting
        if (!FS2_DEBUG) {
            error_reporting(0);
        }

        // Disable magic_quotes_runtime
        if (get_magic_quotes_gpc() || get_magic_quotes_runtime()) {
            ini_set('magic_quotes_gpc', 0);
            ini_set('magic_quotes_runtime', 0);
        }

        // Register autoloader: libloader
        spl_autoload_register(array($this, 'libloader'));
        spl_autoload_register(array($this, 'namespaceLibLoader'));

        // Set default include path
        set_include_path(FS2SOURCE);

        // init event-manager
        $globalEventManager = new EventManager();

        $this->loadEvents($globalEventManager);
        
        // init global data object
        global $FD;
        $FD = new GlobalData();
        $FD->setSystemEventManager($globalEventManager);

        $startupResult = $FD->getSystemEventManager()->trigger(self::EVENT_STARTUP, $FD);

        if($startupResult->hasStopped())
        {
            $result = $startupResult->last();
            if(!($result instanceof \Exception))
            {
                $result = new \Exception(sprintf('Undefined result of type %s', gettype($result)));
            }

            $this->fail($result);
        }

        return $this;
    }

    public function loadEvents(EventManagerInterface $eventManager)
    {
        $eventLoader = new EventLoader($eventManager);

        $eventList = $eventLoader->loadEvents(FS2EVENTS, 'Event');

        $eventLoader->attachEvents($eventList);
    }

    
    public function initSession() {
        // Start Session
        session_start();
        
        // Init some Session values
        $_SESSION['user_level'] = !isset($_SESSION['user_level']) ? 'unknown' : $_SESSION['user_level'];
        
        //TODO: Session Init Hook
        
        return $this;
    }
    
    public function deploy($admin = false) {
        if (@constant('INDEX_NO_DEPLOYMENT')) {
            return;
        }

        /** @var GlobalData $FD */
        global $FD;
        
        // Deploy AdminCP
        if ($admin || isset($_GET['admin']))
        {
            $FD->getSystemEventManager()->trigger(self::EVENT_ADMIN);

            include(FS2ADMIN.'/admin.php');
            $this->__destruct();
            return;
        }
        /** @var GlobalData $FD */
        // Deploy main page
        global $APP;

        $this->initSession();

        $FD->getSystemEventManager()->trigger(self::EVENT_REGULAR_PAGE, $this);

        // Constructor Calls

        $this->get_goto();
        userlogin();
        setTimezone($FD->cfg('timezone'));
        run_cronjobs();
        count_all($FD->cfg('goto'));
        save_visitors();
        if (!$FD->configExists('main', 'count_referers') || $FD->cfg('main', 'count_referers')==1) {
          save_referer();
        }
        set_style();
        $APP = load_applets();

        // Get Body-Template
        $theTemplate = new template();
        $theTemplate->setFile('0_main.tpl');
        $theTemplate->load('MAIN');
        $theTemplate->tag('content', get_content($FD->cfg('goto')));
        $theTemplate->tag('copyright', get_copyright());

        $renderedTemplate = $FD->getSystemEventManager()->trigger(self::EVENT_RENDER, $theTemplate);

        echo $renderedTemplate->last();

        $FD->getSystemEventManager()->trigger(self::EVENT_SHUTDOWN, $this);

        // Shutdown System
        $this->__destruct();
    }
    
    public function __destruct() {
        global $FD;
        unset($FD);  
    }

    /**
     * @param Exception $exception
     */
    private function fail($exception) {
        // log connection error
        error_log($exception->getMessage(), 0);

        // Set header
        $this->header(http_response_text(503), true, 503);
        $this->header('Retry-After: '.(string)(60*15)); // 15 Minutes

        // Include lang-class
        require_once(FS2SOURCE . '/libs/class_lang.php');

        // get language
        $lang = $this->detectUserLanguage();
        $TEXT = new lang($lang, 'frontend');

        // No-Connection-Page Template
        $template = '
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html>
        <head>
            <title>'.$TEXT->get("no_connection").'</title>
        </head>
        <body>
            <p>
                <b>'.$TEXT->get("no_connection_to_the_server").'</b>
            </p>
        </body>
    </html>
        ';

        // Display No-Connection-Page
        echo $template;
        $this->__destruct();
        exit;
    }
    
    
    public function header($content, $replace = false, $http_response_code = null) {
        header($content, $replace, $http_response_code);
        return $this;
    }
    
    
    private function libloader($classname) {
        $class = explode("\\", $classname);

        if(count($class) > 1)
        {
            return false;
        }

        $class = array_pop($class);

        $filepath = FS2SOURCE.'/libs/class_'.$class.'.php';
        
        if (file_exists($filepath)) {
            include_once($filepath);
        } else if (strtolower(substr($class, -9)) === 'exception') {
            include_once(FS2SOURCE.'/libs/exceptions.php');
        } else {
            return false;
        }
    }

    protected function namespaceLibLoader($className)
    {
        $class = explode('\\', $className);

        switch(array_shift($class))
        {
            case 'Frogsystem2':
                $filePath = '/libs/' . implode('/', $class). '.php';
                break;
            case 'Event':
                $filePath = '/event/' . implode('/', $class) . '.php';
                break;
            default:
                return false;
        }

        $filePath = FS2SOURCE . $filePath;

        if(file_exists($filePath))
        {
            include_once $filePath;

            return true;
        }

        return false;
    }
    
    private function detectUserLanguage($default = 'de_DE') {
        $langs = array();
        unset($_SESSION['user_lang']);
        if (!isset($_SESSION['user_lang']) && isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            // break up string into pieces (languages and q factors)
            preg_match_all('/([a-z]{1,8}(?:-([a-z]{1,8}))?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang_parse);
            //~ var_dump($lang_parse);
            if (count($lang_parse[1])) {
                // create a list like "en" => 0.8
                $langs = array_combine($lang_parse[1], $lang_parse[4]);
                
                // set default to 1 for any without q factor
                foreach ($langs as $lang => $val) {
                    if ($val === '') $langs[$lang] = 1;
                }

                // sort list based on value	
                arsort($langs, SORT_NUMERIC);
            }
        }

        foreach ($langs as $lang => $p) {
            switch ($lang) {
                case 'en':
                    return 'en_US';
                case 'de':
                    return 'de_DE';
            }
        }
        
        return $default;
    }


    ///////////////////
    //// get $goto ////
    ///////////////////
    private function get_goto ()
    {
        /** @var GlobalData $FD */
        global $FD;

        //check seo
        if ($FD->cfg('url_style') == 'seo') {
            get_seo();
        }

        // Check $_GET['go']
        $FD->setConfig('env', 'get_go_raw', isset($_GET['go'])?$_GET['go']:null);
        $goto = empty($_GET['go']) ? $FD->cfg('home_real') : $_GET['go'];
        $FD->setConfig('env', 'get_go', $goto);

        // Forward Aliases
        $goto = $this->forward_aliases($goto);

        // write $goto into $global_config_arr['goto']
        $FD->setConfig('goto', $goto);
        $FD->setConfig('env', 'goto', $goto);
    }


    /////////////////////////
    //// forward aliases ////
    /////////////////////////
    private function forward_aliases ( $GOTO )
    {
        /** @var GlobalData $FD */
        global $FD;

        $aliases = $FD->db()->conn()->prepare(
                         'SELECT alias_go, alias_forward_to FROM '.$FD->env('DB_PREFIX').'aliases
                          WHERE `alias_active` = 1 AND `alias_go` = ?');
        $aliases->execute(array($GOTO));
        $aliases = $aliases->fetchAll(PDO::FETCH_ASSOC);

        foreach ($aliases as $alias) {
            if ($GOTO == $alias['alias_go']) {
                $GOTO = $alias['alias_forward_to'];
            }
        }

        return $GOTO;
    }

}

