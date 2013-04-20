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
 * Parses path info
 * 
 * Parses a path info and sets page/params accordingly.
 * This file is used by the main engine and might be better explained by looking at the code for that. 
 *  
 * @param string $string Path info/get string.
 * @return array Return values ("page", "param")      
 * @since v1.0 
 */  

function parsePathinfo($string) {

    // explode the query string.
    $xe_query = explode('/', $string, 6); // TODO: Maybe inccrease this limit or remove altogether?    
    // clear loop values 
    $url_finished = false;
    $url_parsectr = 0;
    // Loop here...
    while($url_finished === false)
    {
        // first off the regular parser
        switch($url_parsectr)
        {
            case 0: // module
				$returns["page"] = $xe_query[$url_parsectr];
            break;
            // Less switching around, allows for dynamic pathinfo lengths
            default: // argument 3
                $returns["param".$url_parsectr] = $xe_query[$url_parsectr];
            break;
        }    
        $url_parsectr++;
        // No queries left?
        if ((isset($xe_query[$url_parsectr])) == false)
        {
            // we're done.
            $url_finished = true;
        }
    } // Loop End    
    return($returns);

}

// because parsePathInfo is a buggy mess
function prettyExplode($string) {
	$xe_query = array();
	$xe_query = explode('/',$string,6);
	return $xe_query;
}

