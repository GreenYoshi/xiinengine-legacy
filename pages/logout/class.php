<?php
/**
 * XiinEngine
 *
 * * XiinEngine is supplied under the MIT license. Please read license.md  in the root directory
 *
 * @package XiinEngine Legacy
 * @author Ian Karlsson <ian.karlsson@xiinet.com>
 * @author Philip Whitehall <philip.whitehall@xiinet.com> 
 * @copyright Copyright 2006-2013 Xiin Networks <http://xiinet.com/>
 * @link http://xiinengine.com/
 * @since v1.2
 */   
/**
 *  This page handles logouts. There's no page.php here because this page doesn't
 *  actually display anything. 
 */ 
class page_logout extends XePage
{
    private $redirectLocation;
    
    public function runPage()
    {
		session_unset();
		$this->redirectLocation = "/";
		  
    }
    public function getVars()
    {
		return array(
			"redirectPage" => $this->redirectLocation,
			//"pageTitle" => "XiinEngine",
			//"pageMeta" => "",
		);
	}
}

?>