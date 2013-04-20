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
if (!in_array("ROOT",XiinEngine::$user->PermArray))
	$this->redirectPage = "/home";

$moduleDebug = false;
extract($_POST); // Get all form information
// Grab info
$pplquery = "SELECT * FROM XE_Permissions WHERE PermID = '".XiinEngine::$input[2]."'";
$dbresult = $this->database->query($pplquery) or die($this->database->error);
$perm = $dbresult->fetch_assoc();

if ($perm['PermID'] == 1)
{
	echo "This permission cannot be deleted";
}
else
{
	if (!in_array("Administrator",XiinEngine::$user->PermArray) && !in_array("ROOT",XiinEngine::$user->PermArray))
		$this->redirectPage = "/home";
	else
	{
		$this->database->query("DELETE FROM XE_Permissions WHERE PermID = ".$perm['PermID']) or die ($this->database->error);
		$this->database->query("DELETE FROM XE_PPL_Permissions WHERE PermID = ".$perm['PermID']) or die ($this->database->error);
		header("location:".sysBaseURL."/permissions");
	}
}
        
 ?>