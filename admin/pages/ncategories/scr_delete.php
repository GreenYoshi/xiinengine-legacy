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
if (!in_array("Administrator",XiinEngine::$user->PermArray) && !in_array("ROOT",XiinEngine::$user->PermArray) && !in_array("Xiin Networks Developer",XiinEngine::$user->PermArray) && !in_array("Journalist",XiinEngine::$user->PermArray))
	$this->redirectPage = "/home";

$moduleDebug = false;
extract($_POST); // Get all form information
// Grab info
$pplquery = "SELECT * FROM XE_NCategories WHERE NCatID = '".XiinEngine::$input[2]."'";
$dbresult = $this->database->query($pplquery) or die($this->database->error);
$perm = $dbresult->fetch_assoc();


{
	$this->database->query("DELETE FROM XE_NCategories WHERE NCatID = ".$perm['NCatID']) or die ($this->database->error);
	$this->database->query("DELETE FROM XE_News_Categories WHERE NCatID = ".$perm['NCatID']) or die ($this->database->error);
	header("location:".sysBaseURL."/ncategories");
}
        
 ?>