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
	$formObject = new XeForm('permissions/add','XE_Permissions','');
	$formOutput = $formObject->openForm();
	$formOutput .= $formObject->row('Permission Name','','text','PermAccessName','');
	$formOutput .= $formObject->row('Lock Permission?','Giving access to modify this only by ROOT account','bool','PermAccessBool','');
	// WiiU FIELD PURPOSELY NOT HERE YET 
	$formOutput .= $formObject->closeTable();
	$formOutput .= $formObject->buttons();
	$formOutput .= $formObject->closeForm();
	
	
	echo $formOutput;
}

function generateEditForm($perm,$permid)
{
	// Generate the form
	// PHIL IS STILL WORKING ON THE XE_PERMISSIONS SIDE
	// ^ Will be using AJAX. I have the code for it to work, i think
	// Per-line permissions will be worked on when more permissions are in the system
	require_once (sysClassPath."XeForm.php");
	$formObject = new XeForm('permissions/edit','XE_Permissions',$permid);
	$formOutput = $formObject->openForm();
	$formOutput .= $formObject->row('Permission Name','','text','PermAccessName',$perm['PermAccessName']);
	$formOutput .= $formObject->row('Lock Permission?','Giving access to modify this only by ROOT account','bool','PermAccessBool',$perm['PermAccessBool']);
	// WiiU FIELD PURPOSELY NOT HERE YET 
	$formOutput .= $formObject->closeTable();
	$formOutput .= $formObject->buttons();
	$formOutput .= $formObject->closeForm();
	
	
	echo $formOutput;
}

?>