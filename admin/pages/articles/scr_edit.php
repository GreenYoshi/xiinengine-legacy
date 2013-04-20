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

$moduleDebug = false;
extract($_POST); // Get all form information
// Grab info
$pplquery = "SELECT * FROM XE_News WHERE NewsPretty = '".XiinEngine::$input[2]."'";
$dbresult = $this->database->query($pplquery) or die($this->database->error);
$ppl = $dbresult->fetch_assoc();

// Check for any changes between the database and forms
//$keyvar = array_keys($engine);
//$checkcount = 0;
//print_r($keyvar);

// Token for the comma in update string
$firstentry = true;
foreach ($ppl as $id => $info)
{
	$id = $this->database->real_escape_string($id);
	$info = $this->database->real_escape_string($info);
	switch ($id)
	{
		case 'NewsTitle': //Regenerate the pretty url if the alias has changed
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
			$pretty = preg_replace("/[^a-zA-Z0-9\s]/", "", $NewsTitle);
			$pretty = str_replace(" ","-",$pretty);
			$pretty = substr($pretty,0,50);
			$updateset .= ", NewsPretty = '".$pretty."'";
			break;
		case 'NewsID': //the 'do nothing'/uneditable fields
		case 'NewsPretty':
		case 'PPLID_list':
		case 'NCatID_list':
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
		$this->database->query("UPDATE XE_News SET ".$updateset." WHERE NewsID = '".$ppl['NewsID']."'") or die($this->database->error);
		
		//Clear and reload permissions
		$this->database->query("DELETE FROM XE_News_Author WHERE NewsID = ".$ppl['NewsID']) or die ($this->database->error);
		for ($i = 0; $i < count($PPLID_list); $i++)
		{
			if(!empty($PPLID_list[$i]))
				$this->database->query("INSERT INTO XE_News_Author (NewsID,PPLID) VALUES(".$ppl['NewsID'].",".$PPLID_list[$i].")") or die ($this->database->error);
		}
		
		$this->database->query("DELETE FROM XE_News_Categories WHERE NewsID = ".$ppl['NewsID']) or die ($this->database->error);
		for ($i = 0; $i < count($NCatID_list); $i++)
		{
			$this->database->query("INSERT INTO XE_News_Categories (NewsID,NCatID) VALUES(".$ppl['NewsID'].",".$NCatID_list[$i].")") or die ($this->database->error);
		}
	}
	header("location:".sysBaseURL."/articles");
}
        
 ?>