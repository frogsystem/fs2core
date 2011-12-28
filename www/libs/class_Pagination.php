<?php
/**
 * @file     class_Pagination.php
 * @folder   /libs
 * @version  0.1
 * @author   Sweil
 *
 * this class presents the Pagination of any data
 */

class Pagination
{
    // Dynamic Data
    private $totalEntries;
    private $selectedPage;
    
    // Calculated Data
    private $startPage;
    private $numOfPages;
    
    // Settings
    private $perPage = 15;
    private $numAtStart = 3;
    private $numAtEnd = 3;
    private $numBeforeSelected = 3;
    private $numAfterSelected = 3;
    private $urlFormat = "?page=%d";
    
    // Der Konstruktur
    public function  __construct ($totalEntries, $selectedPage, $settings = array()) {
        // Set Dynamic Data
        $this->totalEntries = $totalEntries;
        $this->selectedPage = $selectedPage;

        // Set Settings
        $this->setSettings($settings);
    }
    
    //Calculate Data based on dynamic Data
    private function calculateData() {
        $this->numOfPages = ceil($this->totalEntries/$this->perPage);
    }
   
    // get url for linked page
    public function getUrl($page) {
        return sprintf($this->urlFormat, $page);
    }   
   
    // get the number of the first entry per page
    public function getFirstPageEntryNumber($page) {
        return ($page-1)*$this->perPage + 1;
    }
    
    // get the number of the last entry per page
    public function getLastPageEntryNumber($page) {
        $lastNumber = $page*$this->perPage;
        // return page*perPage or total entries if it is lower
        return ($lastNumber > $this->totalEntries ?  $this->totalEntries : $lastNumber);
    }

    
    // get Admin Template
    public function getAdminTemplate() {
        global $FD;
        
        // calculate Data
        $this->calculateData();
        
        // Load Template Object
        $template = new adminpage("pagination.tpl");
        
        // get pages
        $pages = "[".$this->selectedPage."]";
        
        
        //get prev page link
        if ($this->selectedPage-1 >= 1) {
            $template->addText("page-number", 1);
            $template->addText("url", $this->getUrl($this->selectedPage-1));
            $template->addText("pages", sprintf($FD->text("page", "pages"), $this->selectedPage-1, 1)); 
            $template->addText("entries", sprintf($FD->text("page", "entries"), $this->totalEntries, $this->getFirstPageEntryNumber($this->selectedPage-1), $this->getLastPageEntryNumber($this->selectedPage-1))); 
            $prev = $template->get("prev");
        } else {
            $prev = "";
        }
        
        //get next page link
        if ($this->selectedPage+1 <= $this->numOfPages) {
            $template->addText("page-number", $this->selectedPage+1);
            $template->addText("url", $this->getUrl($this->selectedPage+1));
            $template->addText("pages", sprintf($FD->text("page", "pages"), $this->numOfPages, $this->selectedPage+1)); 
            $template->addText("entries", sprintf($FD->text("page", "entries"), $this->totalEntries, $this->getFirstPageEntryNumber($this->selectedPage+1), $this->getLastPageEntryNumber($this->selectedPage+1))); 
            $next = $template->get("next");
        } else {
            $next = "";
        }       
        
        
        //get first page link
        $template->addText("page-number", 1);
        $template->addText("url", $this->getUrl(1));
        $template->addText("pages", sprintf($FD->text("page", "pages"), $this->numOfPages, 1)); 
        $template->addText("entries", sprintf($FD->text("page", "entries"), $this->totalEntries, $this->getFirstPageEntryNumber(1), $this->getLastPageEntryNumber(1))); 
        $first = $template->get("first");
        
        //get last page link
        $template->addText("page-number", $this->numOfPages);
        $template->addText("url", $this->getUrl($this->numOfPages));
        $template->addText("entries", sprintf($FD->text("page", "pages"), $this->numOfPages, $this->numOfPages)); 
        $template->addText("entries", sprintf($FD->text("page", "entries"), $this->totalEntries, $this->totalEntries, $this->getFirstPageEntryNumber($this->numOfPages), $this->getLastPageEntryNumber($this->numOfPages))); 
        $last = $template->get("last");
        

        // Return main template
        $template->addText("pages", $pages);
        $template->addText("prev", $prev);
        $template->addText("next", $next);
        $template->addText("first", $first);        
        $template->addText("last", $last);        

        return $template->get("main");
    }
    
    
    // setter
    public function setSelectedPage($data) {
        $this->selectedPage = (integer) $data;
    }
    public function setTotalEntries($data) {
        $this->totalEntries = (string) $data;
    }
    public function setSettings($settings) {
        foreach ($settings as $setting => $value) {
            if (!property_exists($this, $setting)) {
                throw new Exception("Invalid property");
            }            
            $this->$setting = $value;
        }
    }
    
    // getter
    public function getPerPage() {
        return $this->perPage;
    }
        
}
?>
