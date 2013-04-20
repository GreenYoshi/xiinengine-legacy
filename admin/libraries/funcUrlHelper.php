<?php
/**
 * XiinEngine
 *
 * * XiinEngine is supplied under the MIT license. Please read license.md  in the root directory
 *
 * @package XiinEngine Legacy AdminCP
 * @author Ian Karlsson <ian.karlsson@xiinet.com>
 * @author Philip Whitehall <philip.whitehall@xiinet.com> 
 * @copyright Copyright 2006-2013 Xiin Networks <http://xiinet.com/>
 * @link http://xiinengine.com/
 * @since v1.2
 */   

/**
 * Generates a local link.
 * 
 * This function will generate a local link. There is one reason to use this function
 * instead of just writing links manually. This function will generate
 * the link using correct settings (for pretty URLs, etc).
 * Examples:
 * createLink("blah") = http://example.com/?q=blah/
 * createLink("blah", "etc") = http://example.com/q=blah/etc/
 * createLink("","","","","","lala=3") = http://example.com/?q=   
 * 
 * @param string $module First part of link
 * @param string $param1 Second part of link and first module param. Should be left blank ("") if not used.
 * @param string $param2 Third part of link and second module param. Should be left blank ("") if not used.
 * @param string $param3 Fourth part of link and third module param. Should be left blank ("") if not used.
 * @param string $param4 Fifth part of link and fourth module param. Should be left blank ("") if not used.
 * @param string $get Here goes any $_GET parameters. Should not be entered if not used.
 * @return string URL
 * @since v1.0         
 */  
function createLink($module = "", $param1 = "", $param2 = "", $param3 = "", $param4 = "", $get = "")
{
    // adds slashes if needed
    if ($param1 != "" && $module != "") {    
        if ($param2 != "") {
            if ($param3 != "") {
                if ($param4 != "") {
                    $param4 .= "/";
                }
                $param3 .= "/";
            }
            $param2 .= "/";        
        }
        $param1 .= "/";            
    }
    $params = $param1.$param2.$param3.$param4;    
    // prepends & to the GET string 
    if ($get != "" && $module)
        $get = "&" . $get;
	$string = XE_URL . $module."/".$params.$get;
    return $string;
}
/**
 * Escapes string for URL complience
 * 
 * Will escape punctuation for URL links. Good for parsing user input, as an example.   
 * 
 * @param string $string string to escape
 * @output string escaped string.
 * @since v1.0   
 */ 

function escapeURL($string) {

    $url_escapes = array(
        "%20","%3C","%3E","%23","%25","%7B","%7D","%7C","%5C","%5E","%7E","%5B",
        "%5D","%60","%3B","%2F","%3F","%3A","%40","%3D","%26","%24", 
    );
    $url_replace = array(
        " ","<",">","#","%","{","}","|","\\","^","~","[","]","`",";","/","?",":",
        "@","=","&","$",
    );

    $string = str_replace($url_replace, $url_escapes, $string);
    return $string;
}

/**
 * Unescapes URLs.
 * 
 * Will convert URL strings to normal human readable strings with punctuation.
 * 
 * @param string $string string to unescape
 * @output string strings with human readable punctuation.
 * @since v1.0   
 */ 

function unescapeURL($string) {
    $url_escapes = array(
        "%20","%3C","%3E","%23","%25","%7B","%7D","%7C","%5C","%5E","%7E","%5B",
        "%5D","%60","%3B","%2F","%3F","%3A","%40","%3D","%26","%24", 
    );
    $url_replace = array(
        " ","<",">","#","%","{","}","|","\\","^","~","[","]","`",";","/","?",":",
        "@","=","&","$",
    );
    $string = str_replace($url_escapes, $url_replace, $string);
    return $string;
}

?>
