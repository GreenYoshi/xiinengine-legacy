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
if (!in_array("Administrator",XiinEngine::$user->PermArray) && !in_array("ROOT",XiinEngine::$user->PermArray) && !in_array("Xiin Networks Developer",XiinEngine::$user->PermArray))
	$this->redirectPage = "/home";
	
?>

<div class="result_button cancel"><a href="<?php echo sysBaseURL; ?>/" target="_self">CANCEL</a></div><br />

<?php 

$settings = array();

$permquery = "SELECT * FROM XE_Switchboard";
$dbresult = $this->database->query($permquery) or die($this->database->error);
while ($setting = $dbresult->fetch_assoc())
{
	$settings[$setting['SwitchName']] = $setting['SwitchValue'];
}

require_once (sysClassPath."XeForm.php");
$formObject = new XeForm($this->database,'settings/edit','XE_Switchboard',1);
$formOutput = $formObject->openForm();
$formOutput .= $formObject->row('Site Name','The name of your site.','text','site_name',$settings["site_name"]);
$formOutput .= $formObject->row('Site Description','Your site description. This must be reader friendly for public search engines. Max 140 chars','textarea','site_description',$settings["site_description"]);
$formOutput .= $formObject->row('Meta tags','Used by public search engines. Max 140 chars.','textarea','public_site_tags',$settings["public_site_tags"]);
$formOutput .= $formObject->row('Public Site Enabled','Site will be closed for public if set to false','bool','public_enabled',$settings["public_enabled"]);
$formOutput .= $formObject->row('Site Closed Message','Optional message that appears when the site is closed. Max 140 chars.','text','public_closed_message',$settings["public_closed_message"]);
$formOutput .= $formObject->row('Site Announcement Enabled','If true, an announcement banner appears at the top of the public site','bool','public_announcement_enabled',$settings["public_announcement_enabled"]);
$formOutput .= $formObject->row('Site Announcement','Content of the announcement banner. HTML is allowed, but ensure any tags are closed. Max 140 chars.','textarea','public_announcement',$settings["public_announcement"]);
$formOutput .= $formObject->row('Site Theme','The theme that appears on the public site.','text','public_site_theme',$settings["public_site_theme"]); // TODO: Make this array

$formOutput .= $formObject->closeTable();
$formOutput .= $formObject->buttons();
$formOutput .= $formObject->closeForm();


echo $formOutput;

?>