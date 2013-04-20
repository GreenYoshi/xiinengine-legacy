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

require_once(sysLibraryPath."htmlpurifier/HTMLPurifier.standalone.php");

if(!empty(XiinEngine::$input[1]) && XiinEngine::$input[1] != "page" && (strlen(XiinEngine::$input[1]) < 20))
{
	$pageSelect = XiinEngine::$input[1];
}
else
{
	// Maybe later I'll a nice comment overview page or something.
	$pageSelect = "nope";
}
	$reply = false;
// guess why i added tihs
if(XiinEngine::$input[1] == "addreply")
{
	$reply = true;
	$pageSelect = "add";
}

$loadFile = sysPagePath.XiinEngine::$input[0]."/".$pageSelect.".php";

if(is_readable($loadFile))
{
	include $loadFile;
}
else
{
	echo "Sorry, this page does not exist.";
	echo "<br />Attempted to load: <b>$loadFile</b>";
}
?>