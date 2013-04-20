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
// SECURITY, Reroutes non admins/roots to homepage
if (!in_array("Administrator",XiinEngine::$user->PermArray) && !in_array("ROOT",XiinEngine::$user->PermArray) && !in_array("Xiin Networks Developer",XiinEngine::$user->PermArray) && !in_array("Journalist",XiinEngine::$user->PermArray))
	$this->redirectPage = "/home";
	
?>

<div class="result_button cancel"><a href="<?php echo sysBaseURL; ?>/articles/" target="_self">CANCEL</a></div><br />

<?php 
$this->titleData = "Edit - Article Administration";
$this->pageScripts = "";
// Security measures here when needed
$newsPretty = substr(XiinEngine::$input[2],0,50);

$newsquery = "SELECT * FROM XE_News WHERE NewsPretty = '".$newsPretty."'";
$dbresult = $this->database->query($newsquery) or die($this->database->error);
$news = $dbresult->fetch_assoc();

$this->generateEditForm($news,$newsPretty);


?>