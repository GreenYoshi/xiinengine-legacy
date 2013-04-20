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
$okdata = true;
$error = "No errors occurred";
// Grab info
$requestID = $this->database->real_escape_string(substr(XiinEngine::$input[2],0,50));
$permquery = "SELECT * FROM XE_Permissions WHERE PermID = '".$requestID."'";
$dbresult = $this->database->query($permquery) or die($this->database->error);
$perm = $dbresult->fetch_assoc();

// Check for any changes between the database and forms
//$keyvar = array_keys($engine);
//$checkcount = 0;
//print_r($keyvar);

// Token for the comma in update string
$firstentry = true;
foreach ($perm as $id => $info)
{
	$id = $this->database->real_escape_string($id);
	$info = $this->database->real_escape_string($info);
	switch ($id)
	{
		case 'PermAccessName': //Regenerate the pretty url if the alias has changed
			if (empty($info))
			{
				$okdata = false;
				$error = "Permission Name field cannot be empty!";
			}
			else
			{
				$escaped = $this->database->real_escape_string(${$id});
				if ($firstentry)
				{
					$updateset = $id." = '".$escaped."'";
					$firstentry = false;
				}
				else
				{
					$updateset .= ", ".$id." = '".$escaped."'";
				}
			}
			break;
		case 'PermID': //the 'do nothing'/uneditable fields
			break;
		default:
			$escaped = $this->database->real_escape_string(${$id});
			if ($firstentry)
			{
				$updateset = $id." = '".$escaped."'";
				$firstentry = false;
			}
			else
			{
				$updateset .= ", ".$id." = '".$escaped."'";
			}
			break;
	}
}

if ($moduleDebug)
{
	echo $updateset;
}
else
{
	if ($updateset != "")
	{
		// Store all changes back into the database.
		//mysql_query("UPDATE ".$table." SET ".$updateset." WHERE ".$primaryID." = '".$IDValue."'") or die (mysql_error());
		$this->database->query("UPDATE XE_Permissions SET ".$updateset." WHERE PermID = '".$perm['PermID']."'") or die($this->database->error);
	}
	header("location:".sysBaseURL."/permissions");
}
        
 ?>