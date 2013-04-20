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
	
?>

<div class="result_button cancel"><a href="<?php echo sysBaseURL; ?>/ncategories/" target="_self">CANCEL</a></div><br />

<?php 
//include sysPagePath.'permissions/permform.php'; 
// Security measures here when needed
$permid = substr(XiinEngine::$input[2],0,50);

$permquery = "SELECT * FROM XE_NCategories WHERE NCatID = '".$permid."'";
$dbresult = $this->database->query($permquery) or die($this->database->error);
$perm = $dbresult->fetch_assoc();

$this->generateEditForm($perm,$permid);

?>