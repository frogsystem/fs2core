<?php
/**
 * @file StringCutter.php
 * @author Moritz Kornher <mail@sweil.de>
 * @version 0.1
 * 
 * @section DESCRIPTION
 *
 * This class provides static methods to cut strings with word, html
 * or bbcode awareness.
 * 
 */
 

class StringCutter {
    
    /* TODO: doxygen
     * Note: regex format
     * 
     * */
    
    const HTML_STANDALONE = "area|base|basefont|br|col|frame|hr|img|input|isindex|link|meta|param";
    const BBCODE_STANDALONE = "\*";

    
    /**
     * Like cut() but word, html, or bbcode aware and some other options
     * 
     * @param $text Text to be truncated
     * @param $length Max length of text
     * @param $extension Extend given string by this if truncated
     * @param $awareness Setting awareness: (boolean) word, html, bbcode
     * @param $options Options: (boolean) count_html, count_bbcode, below
     * 
     * @return Text truncated with awareness
     * */
    static public function truncate ($text, $length, $extension, $awareness = array(), $options = array()) {
		// check awarness & options
		if (!isset($awareness))
			$awareness = array();
		if (!isset($options))
			$options = array();
		
		if (!isset($awareness['word']))
			$awareness['word'] = false;
		if (!isset($awareness['html']))
			$awareness['word'] = false;
		if (!isset($awareness['bbcode']))
			$awareness['word'] = false;
			
		if (!isset($options['count_html']))
			$options['count_html'] = false;
		if (!isset($options['count_bbcode']))
			$options['count_bbcode'] = false;
		if (!isset($options['below']))
			$options['below'] = true;
			
		
        // set count to false, if not html/bbcode aware
        $options['count_html'] = !$awareness['html'] || $options['count_html'];
        $options['count_bbcode'] = !$awareness['bbcode'] || $options['count_bbcode'];

        // Do we have to cut?
        if (strlen(StringCutter::strip($text, !$options['count_html'], !$options['count_bbcode'])) <= $length)
            return $text;
            
        // truncated html/bbcode aware?
        if (!($awareness['html'] || $awareness['bbcode'])) {
            return StringCutter::cut_wordaware($text, $length, $extension, $options['below']);
        }

        // create stripped text for text-only length
        $stripped_text = StringCutter::strip($text, $awareness['html'], $awareness['bbcode']);

        // Create function to get absolut length of splitted text, wordaware or not
        $calcLength_params = '$l, $t="'.$stripped_text.'", $e="'.$extension.'", $w='.($awareness['word']?'true':'false').', $b='.($options['below']?'true':'false');
        $calcLength_code = 'return StringCutter::calc_truncated_length($t,$l,$e,$w,$b);';
        $calcLength = create_function($calcLength_params, $calcLength_code);
        $textonly_length = $calcLength($length);
    
        // Split Text into parts with 0 or 1 html/bbcode-tag
        $html_regex = '(<\/?[\w]+[^>]*?>)?([^<]*)';
        $bbcode_regex = '(\[\/?[\w]+[^\]]*?\])?([^\[]*)';
        $html_regex = '(<\/?[\w]+[^>]*?>)?([^<]*)';
        $bbcode_regex = '(\[\/?[\w]+[^\]]*?\])?([^\[]*)';
        $regex = '((?:<\/?[\w]+[^>]*?>)|(?:\[\/?[\w]+[^\]]*?\]))?([^<\[]*)';
        $text_parts = array();
        preg_match_all("#$regex#s", $text, $text_parts, PREG_SET_ORDER);
        
        // init some data
        $tags_to_close = array();
        $tag_type = null;
        $compiled_text = "";
        $compiled_counter = 0;
        $htmlbbcode_length = 0;

        // now walk through text parts
        foreach ($text_parts as $part) {
            
            // save old length of html/bbcode contents
            $htmlbbcode_old_length = $htmlbbcode_length;
            
            // check for tags, so we may auto-close them later
            if (!empty($part[1])) {
                
                // which type is the tag?
                $bbtag = ("[" === substr($part[1], 0, 1));

                // check if corresponding awarness is set
                if (($bbtag && $awareness['bbcode']) || (!$bbtag && $awareness['html'])) {
                
                    // calculate real count
                    $count_tag = ($options['count_html'] && !$bbtag)
                        || ($options['count_bbcode'] && $bbtag);

                    // set some data depending on tag is html or bbcode
                    if ($bbtag) { // tag is bbcode
                        $standalone = '#(\[('.StringCutter::BBCODE_STANDALONE.')[^\]]*?\])#i';
                        $closing = '#\[\/([\w]+[^\]]*?)\]#';
                        $opening = '#\[([\w]+)[^\]]*?\]#';
                        list($closing_pre, $closing_post) = array("[/", "]");
                    } else { // tag is html
                        $standalone = '#(<('.StringCutter::HTML_STANDALONE.')[^>]*?>)#i';
                        $closing = '#<\/([\w]+[^>]*?)>#';
                        $opening = '#<([\w]+)[^>]*?>#';  
                        list($closing_pre, $closing_post) = array("</", ">");
                    }
 
                    // init tag_match array
                    $tag_match = array();
                
                    // standalone-tag?
                    if (preg_match($standalone, $part[0], $tag_match)) {
                        // set tag type
                        $tag_type = "self";
                    
                        // count tag?
                        if ($count_tag) {
                            $htmlbbcode_length += strlen($part[1]);
                        }
                    }
                    
                    // closing tag?
                    elseif(preg_match($closing, $part[0], $tag_match)) {                        
                        // set tag type
                        $tag_type = "closing";
                        
                        //remove from open tag list
                        $closing_tag = $closing_pre.$tag_match[1].$closing_post;
                        if (false !== ($tag_index = array_search($closing_tag, $tags_to_close))) {
                            unset($tags_to_close[$tag_index]);
                        }
                        
                        // unocunt previously counted closing tag
                        if ($count_tag) {
                            $htmlbbcode_length += strlen($part[1]);
                            $htmlbbcode_length -= strlen($closing_tag);
                        }
                    }
                    
                    // opening tag?
                    elseif (preg_match($opening, $part[0], $tag_match)) {
                        // set tag type
                        $tag_type = "opening";
                        
                        //add to $tags_to_close list
                        $closing_tag = $closing_pre.$tag_match[1].$closing_post;
                        array_unshift($tags_to_close, $closing_tag);
                        
                        // precount upcoming closing tag
                        if ($count_tag) {
							$htmlbbcode_length += strlen($part[1].$closing_tag);
                        }
                    }
                }
            }

            // Recalculate textonly length if length of html/bbcode contents changed
            if ($htmlbbcode_old_length != $htmlbbcode_length)
                $textonly_length = $calcLength($length-$htmlbbcode_length);

            // string fits in?
            if ($compiled_counter + strlen($part[2]) <= $textonly_length) {
                // add part to compiled text
                $compiled_text .= $part[0];
                
                // raise counter
                $compiled_counter += strlen($part[2]);
                
                // text is full, no need for another round
                if ($compiled_counter >= $textonly_length) {
                    break;
                }

            // string doesnt fit => we have to cut!
            } else {

                // calculate lenght of the rest string
                $part_length = $textonly_length - strlen(StringCutter::strip($compiled_text, $awareness['html'], $awareness['bbcode']));

                // Get rest of text if avaiable or if we want to stay above the border
                if ($part_length >= 0 || !$options['below']) {
                    
                    // truncate the text part
                    $part_length = ($part_length < 0) ? 0 : $part_length;
                    if ($awareness['word'])
                        $cutted_text = StringCutter::cut_wordaware($part[2], $part_length, "", $options['below']);
                    else
                        $cutted_text = StringCutter::cut($part[2], $part_length, "");
                        
                    // concat truncated part to compiled text
                    $compiled_text .= $part[1].rtrim($cutted_text, " ");
                
                // we dont want an empty tag
                } elseif ($tag_type == "opening") {
                    array_shift($tags_to_close);
                }

                // now text is full
                break;
            }

        }

        // add all unclosed tags
        $compiled_text .= implode("", $tags_to_close);

        // remove space at end of text
        $compiled_text = rtrim($compiled_text, " ");

        return $compiled_text.$extension; 
    }
    
    
    /**
     * Cuts $text after $len chars and extends with $ext if truncated
     * 
     * @param $text Text to shorten
     * @param $len Max length of text
     * @param $ext Extends $text by this if truncated
     * 
     * */
    static public function cut ($text, $len, $ext = "") {
        // Do we have to cut?
        if (strlen($text) > $len) {
            return substr($text, 0, $len-strlen($ext)).$ext;
        }
        
        return $text;
    }


    /**
     * Like cut() but wordaware 
     * 
     * @param $text Text to shorten
     * @param $length Max length of text
     * @param $extension Extends $text by this if truncated
     * @param $below Stay below the $len limit (true) or get closest result above the border (false)
     * 
     * @return Truncated text
     * */
    static public function cut_wordaware ($text, $length, $extension = "", $below = true) {
        
        // remove space at end of text
        $text = rtrim($text, " ");
        
        // Do we have to cut?
        if (strlen($text) > $length) {

            // Get relevant substring
            $sub = substr($text, 0, $length-strlen($extension)+1);
        
            // stay below the border
            if ($below) {
                // search for break from the end of string
                $length = (int) strrpos($sub, " ");
                
            // Take the first break above the border
            } else {
                $length = strpos($text, " ", strlen($sub)-1);
                $length = ($length === false) ? strlen($text) : $length;
            }
            
            return substr($text, 0, $length).$extension;
        }
        
        return $text;
    } 
     
       
    /**
     * Strips bbcode from text
     * 
     * @param $str Text to be stripped
     * @param $allowable_tags Comma separated string of allowable tags
     * 
     * @return BBCode free text
     * */
    static public function strip_bbcode ($str, $allowable_tags = "") {
        $allowable_tags = array_map("strtolower", explode(",", $allowable_tags));
        
        // search for tags
        $matches = array();
        preg_match_all('#\[\/?([\w]+)[^\]]*?\]#', $str, $tags, PREG_PATTERN_ORDER);
        
        foreach ($tags[1] as $tag) {
            // is tag allowable?
            if (!in_array(strtolower($tag), $allowable_tags))
                $str = preg_replace('#(\[\/?'.$tag.'[^\]]*?\])#i', '', $str);
        }
        return $str;
    }
    
    
    /**
     * Strips html and bbcode from text
     * 
     * @param $str Text to be stripped
     * @param $html Strip HTML tags
     * @param $bbcode Strip BBCode tags
     * 
     * @return Stripped text
     * */    
    static private function strip ($str, $html, $bbcode) {
        if ($html)
            $str = strip_tags($str);
        if ($bbcode)
            $str = StringCutter::strip_bbcode($str);
            
        return $str;
    }
    
    
    /**
     * Calculates the new text length for any truncated text
     * 
     * @param $text Text to be truncated
     * @param $length Max length of text
     * @param $extension Extend given string by this if truncated
     * @param $word_awareness Setting word awareness.
     * @param $below Stay below the $len limit (true) or get closest result above the border (false)
     * 
     * @return Returns the length of truncated pure text 
     * */     
    static public function calc_truncated_length ($text, $length, $extension, $word_awareness, $below) {
        // Truncate word aware?
        if ($word_awareness) {
            $text = StringCutter::cut_wordaware($text, $length, $extension, $below);
        } else {
            $text = StringCutter::cut($text, $length, $extension);
        } 
        return strlen($text)-strlen($extension);
    }    
}

?>
