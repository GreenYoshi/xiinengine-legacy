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
function generateAddForm()
{
	// Generate the form
	// PHIL IS STILL WORKING ON THE XE_PERMISSIONS SIDE
	// ^ Will be using AJAX. I have the code for it to work, i think
	// Per-line permissions will be worked on when more permissions are in the system
	require_once (sysClassPath."XeForm.php");
	$formObject = new XeForm('ppl/add','PPL','');
	$formOutput = $formObject->openForm();
	$formOutput .= $formObject->row('First Name','','text','PPLFName','');
	$formOutput .= $formObject->row('Surname','','text','PPLSName','');
	$formOutput .= $formObject->row('Email','','text','PPLEmail','');
	$formOutput .= $formObject->row('Alias','','text','PPLAlias','');
	$formOutput .= $formObject->ajaxrow('Permission Groups','','dropdown','XE_Permissions','PPLAlias','');
	$formOutput .= $formObject->row('Icon URL','Test Description','text','PPLIcon','');
	$formOutput .= $formObject->row('Title','','text','PPLTitle','');
	$formOutput .= $formObject->row('Bio','','textarea','PPLBio','');
	$formOutput .= $formObject->row('URL','Personal website link','text','PPLURL','');
	$formOutput .= $formObject->row('New Password','','password','PPLNewPass','');
	$formOutput .= $formObject->row('Verify Password','','password','PPLNewPass2','');
	$formOutput .= $formObject->row('Security Question','Not decided if this is a dropdown fixed thing or anyone can type anything they want','text','PPLSecurityQuestion','');
	$formOutput .= $formObject->row('Security Answer','','text','PPLSecurityAnswer','');
	$formOutput .= $formObject->row('Facebook Link','Public link, not for App','text','PPLFacebook','');
	$formOutput .= $formObject->row('Twitter Link','Public link, not for App','text','PPLTwitter','');
	$formOutput .= $formObject->row('GPlus','Public link, not for App','text','PPLGPlus','');
	// DISQUS FIELD PURPOSELY NOT HERE YET 
	$formOutput .= $formObject->row('3DS Friend Code','','text','PPL3DSNumber','');
	$formOutput .= $formObject->row('Wii Friend Code','','text','PPLWiiNumber','');
	// WiiU FIELD PURPOSELY NOT HERE YET 
	$formOutput .= $formObject->closeTable();
	$formOutput .= $formObject->buttons();
	$formOutput .= $formObject->closeForm();
	
	
	echo $formOutput;
}

function generateEditForm($ppl,$pplPretty)
{
	// Generate the form
	// PHIL IS STILL WORKING ON THE XE_PERMISSIONS SIDE
	// ^ Will be using AJAX. I have the code for it to work, i think
	// Per-line permissions will be worked on when more permissions are in the system
	require_once (sysClassPath."XeForm.php");
	$formObject = new XeForm('ppl/edit','PPL',$pplPretty);
	$formOutput = $formObject->openForm();
	$formOutput .= $formObject->row('First Name','','text','PPLFName',$ppl['PPLFName']);
	$formOutput .= $formObject->row('Surname','','text','PPLSName',$ppl['PPLSName']);
	$formOutput .= $formObject->row('Email','','text','PPLEmail',$ppl['PPLEmail']);
	$formOutput .= $formObject->row('Alias','','text','PPLAlias',$ppl['PPLAlias']);
	$formOutput .= $formObject->row('Icon URL','Test Description','text','PPLIcon',$ppl['PPLIcon']);
	$formOutput .= $formObject->row('Title','','text','PPLTitle',$ppl['PPLTitle']);
	$formOutput .= $formObject->row('Bio','','textarea','PPLBio',$ppl['PPLBio']);
	$formOutput .= $formObject->row('URL','Personal website link','text','PPLURL',$ppl['PPLURL']);
	$formOutput .= $formObject->row('Old Password','','password','PPLPass','');
	$formOutput .= $formObject->row('New Password','','password','PPLNewPass','');
	$formOutput .= $formObject->row('Verify Password','','password','PPLNewPass2','');
	$formOutput .= $formObject->row('Security Question','Not decided if this is a dropdown fixed thing or anyone can type anything they want','text','PPLSecurityQuestion',$ppl['PPLSecurityQuestion']);
	$formOutput .= $formObject->row('Security Answer','','text','PPLSecurityAnswer',$ppl['PPLSecurityAnswer']);
	$formOutput .= $formObject->row('Facebook Link','Public link, not for App','text','PPLFacebook',$ppl['PPLFacebook']);
	$formOutput .= $formObject->row('Twitter Link','Public link, not for App','text','PPLTwitter',$ppl['PPLTwitter']);
	$formOutput .= $formObject->row('GPlus','Public link, not for App','text','PPLGPlus',$ppl['PPLGPlus']);
	// DISQUS FIELD PURPOSELY NOT HERE YET 
	$formOutput .= $formObject->row('3DS Friend Code','','text','PPL3DSNumber',$ppl['PPL3DSNumber']);
	$formOutput .= $formObject->row('Wii Friend Code','','text','PPLWiiNumber',$ppl['PPLWiiNumber']);
	// WiiU FIELD PURPOSELY NOT HERE YET 
	$formOutput .= $formObject->closeTable();
	$formOutput .= $formObject->buttons();
	$formOutput .= $formObject->closeForm();
	
	
	echo $formOutput;
}

?>