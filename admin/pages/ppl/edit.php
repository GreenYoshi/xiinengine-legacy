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
if (!in_array("Administrator",XiinEngine::$user->PermArray) && !in_array("ROOT",XiinEngine::$user->PermArray) && !in_array("Xiin Networks Developer",XiinEngine::$user->PermArray))
{
	// Might not be administrator, but allow if owner of account
	if (XiinEngine::$user->Pretty != XiinEngine::$input[2])
		$this->redirectPage = "/home";
}
?>

<div class="result_button cancel"><a href="<?php echo sysBaseURL; ?>/ppl/" target="_self">Cancel</a></div>

<?php 
$this->pageScripts = "";
// Security measures here when needed
$pplPretty = substr(XiinEngine::$input[2],0,50);

$pplquery = "SELECT * FROM XE_PPL WHERE PPLPretty = '".$pplPretty."'";
$dbresult = $this->database->query($pplquery) or die($this->database->error);
$ppl = $dbresult->fetch_assoc();

$this->titleData = "Editing PPL - " . stripslashes($ppl["PPLAlias"]);

$this->generateEditForm($ppl,$pplPretty);


?>
