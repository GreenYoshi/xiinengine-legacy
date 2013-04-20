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
if (!in_array("Administrator",XiinEngine::$user->PermArray) && !in_array("ROOT",XiinEngine::$user->PermArray))
	$this->redirectPage = "/home";
?>

<div class="result_button add"><a href="<?php echo sysBaseURL.'/'.XiinEngine::$input[0]; ?>/forms/add" target="_self">+ Add Permission</a></div><br />
<?php

$typearray = array('Audio - Podcast' => 'Audio - Podcast',
				   'Image - News' => 'Image - News',
				   'Image - Profile' => 'Image - Profile'
				   );

require_once (sysClassPath."XeForm.php");
$formObject = new XeForm($this->database,XiinEngine::$input[0].'/add','XE_Block',0);
$formOutput = $formObject->openForm();
$formOutput .= $formObject->row('Asset Type',
								'What type of media are you uploading?',
								'dropdown',
								'',
								'',
								$typearray
								);
$formOutput .= $formObject->row('File Upload',
								'Point to the file on your computer that you wish to upload',
								'fileupload',
								'VariableRowData',
								''
								);
$formOutput .= $formObject->closeTable();
$formOutput .= '<div class="result_nav"><div class="result_nav_left"><input type="submit" class="result_button submit" name="action" value="Upload" class="button_submit_add" /></div></div>';
$formOutput .= $formObject->closeForm();


echo $formOutput;
?>