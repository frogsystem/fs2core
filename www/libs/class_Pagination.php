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
    private $numAtStart = 1;
    private $numAtEnd = 1;
    private $numBeforeSelected = 2;
    private $numAfterSelected = 2;
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
        
        // Create Lang Object
        $lang = new lang(false, "admin/pagination");
        
        // Load Template Object
        $template = new adminpage("pagination.tpl");
        $template->setLang($lang);

        // get list of all pages
        $page_list = array();
        for ($i=1; $i<=$this->numOfPages; $i++) {
            $page_list[$i] = $this->getPageTemplate($i);
        }
        
        // get seperator
        $seperator = $template->get("seperator");
        
        // get selected page
        $selected_page = $this->getPageTemplate($this->selectedPage, true);
        
        // get pages
        initstr($pages);
        $front_seperator = $back_seperator = false;
        foreach ($page_list as $page => $string) {
			
			// Pages before selected
			if ($page < $this->selectedPage) {
				
				// Pages
				if ($page <= $this->numAtStart || $page >= $this->selectedPage-$this->numBeforeSelected){
					$pages .= $string;
					
				// front seperator
				} elseif (!$front_seperator) {
					$pages .= $seperator;
					$front_seperator = true;
				}				
			}
			
			// Selected Pages
			elseif ($page == $this->selectedPage) {
				$pages .= $selected_page;
			}
			
			// Pages after selected
			elseif ($page > $this->selectedPage) {
				
				// Pages
				if ($page > $this->numOfPages-$this->numAtEnd || $page <= $this->selectedPage+$this->numAfterSelected) {
					$pages .= $string;
					
				// Back seperator
				} elseif (!$back_seperator) {
					$pages .= $seperator;
					$back_seperator = true;
				}
				
			}
		}		
        
        
        //get prev page link
        if ($this->selectedPage-1 >= 1) {
            $template->addText("page-number", 1);
            $template->addText("url", $this->getUrl($this->selectedPage-1));
            $template->addText("page", sprintf($lang->get("page"), $this->numOfPages, $this->selectedPage-1)); 
            $template->addText("entries", sprintf($lang->get("entries"), $this->totalEntries, $this->getFirstPageEntryNumber($this->selectedPage-1), $this->getLastPageEntryNumber($this->selectedPage-1))); 
            $prev = $template->get("prev");
        } else {
            $prev = "";
        }
        
        //get next page link
        if ($this->selectedPage+1 <= $this->numOfPages) {
            $template->addText("page-number", $this->selectedPage+1);
            $template->addText("url", $this->getUrl($this->selectedPage+1));
            $template->addText("page", sprintf($lang->get("page"), $this->numOfPages, $this->selectedPage+1)); 
            $template->addText("entries", sprintf($lang->get("entries"), $this->totalEntries, $this->getFirstPageEntryNumber($this->selectedPage+1), $this->getLastPageEntryNumber($this->selectedPage+1))); 
            $next = $template->get("next");
        } else {
            $next = "";
        }       
        
        
        //get first page link
        $template->addText("page-number", 1);
        $template->addText("url", $this->getUrl(1));
        $template->addText("page", sprintf($lang->get("page"), $this->numOfPages, 1)); 
        $template->addText("entries", sprintf($lang->get("entries"), $this->totalEntries, $this->getFirstPageEntryNumber(1), $this->getLastPageEntryNumber(1))); 
        $first = $template->get("first");
        
        //get last page link
        $template->addText("page-number", $this->numOfPages);
        $template->addText("url", $this->getUrl($this->numOfPages));
        $template->addText("page", sprintf($lang->get("page"), $this->numOfPages, $this->numOfPages)); 
        $template->addText("entries", sprintf($lang->get("entries"), $this->totalEntries, $this->getFirstPageEntryNumber($this->numOfPages), $this->getLastPageEntryNumber($this->numOfPages))); 
        $last = $template->get("last");
        

        // Return main template
        $template->addText("pages", $pages);
        $template->addText("prev", $prev);
        $template->addText("next", $next);
        $template->addText("first", $first);        
        $template->addText("last", $last);        

        return $template->get("main");
    }
    
    // get a page template
    public function getPageTemplate($page, $selected = false) {
        // Create Lang Object
        $lang = new lang(false, "admin/pagination");
        
        // Load Template Object
        $template = new adminpage("pagination.tpl");
        $template->setLang($lang);
		
		$template->addText("page-number", $page);
		$template->addText("url", $this->getUrl($page));
		$template->addText("page", sprintf($lang->get("page"), $this->numOfPages, $page)); 
		$template->addText("entries", sprintf($lang->get("entries"), $this->totalEntries, $this->getFirstPageEntryNumber($page), $this->getLastPageEntryNumber($page))); 
		
		if ($selected)
			return $template->get("selected-page");
		else
			return $template->get("page");
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
