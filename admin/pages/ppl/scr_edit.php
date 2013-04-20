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
	// Allow if owner if account
	if (XiinEngine::$user->Pretty != XiinEngine::$input[2])
		$this->redirectPage = "/home";
}
	  
  $moduleDebug = false;
  extract($_POST); // Get all form information
  // Grab info
  $pplquery = "SELECT * FROM XE_PPL WHERE PPLPretty = '".XiinEngine::$input[2]."'";
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
		  case 'PPLPass':
			  if ($PPLNewPass != "" || $PPLNewPass != NULL)
			  {
				  if ($info == hash("sha512",XE_SALT_L.$PPLPass.XE_SALT_R))
				  {
					  if ($firstentry)
					  {
						  $updateset = $id." = '".hash("sha512",XE_SALT_L.$PPLNewPass.XE_SALT_R)."'";
						  $firstentry = false;
					  }
					  else
					  {
						  $updateset .= ", ".$id." = '".hash("sha512",XE_SALT_L.$PPLNewPass.XE_SALT_R)."'";
					  }
				  }
			  }
			  break;
		  case 'PPLAlias': //Regenerate the pretty url if the alias has changed
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
			  $pretty = preg_replace("/[^a-zA-Z0-9\s]/", "", $PPLAlias);
			  $pretty = str_replace(" ","-",$pretty);
			  $pretty = substr($pretty,0,50);
			  $updateset .= ", PPLPretty = '".$pretty."'";
			  break;
		  case 'PPLBanDate':
			  if (!empty(${$id}[2]))
			  {
				  $date = date("Y-m-d H:i:s", mktime(0,0,0,${$id}[1],${$id}[0],${$id}[2]));
				  //$date = mktime(0,0,0,${$id["month"]},${$id["day"]},${$id["year"]});
				  //echo $date;
				  if ($firstentry)
				  {
					  $updateset = $id." = '".$date."'";
					  $firstentry = false;
				  }
				  else
				  {
					  $updateset .= ", ".$id." = '".$date."'";
				  }
			  }
			  else
			  {
				  if ($firstentry)
				  {
					  $updateset = $id." = NULL";
					  $firstentry = false;
				  }
				  else
				  {
					  $updateset .= ", ".$id." = NULL";
				  }
			  }
			  break;
		  case 'PPLID': //the 'do nothing'/uneditable fields
		  case 'PPLPretty':
		  case 'PPLLastLogin':
		  case 'PPLLastIP':
		  case 'PPLCreationDate':
		  case 'PPLDisqus':
		  case 'PPLRememberPassKey':
		  case 'PPLPubFacebook':
		  case 'PPLKey1Facebook':
		  case 'PPLPubTwitter':
		  case 'PPLKey1Twitter':
		  case 'PPLPubGPlus':
		  case 'PPLKey1GPlus':
		  case 'PPLPubDisqus':
		  case 'PPLDSNumber':		// why this?
		  //case 'PPLWiiUNumber':
		  case 'PPLNewPass2': 
		  case 'PermID_list':
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
	  if (!empty($updateset))
	  {
		  // Store all changes back into the database.
		  //mysql_query("UPDATE ".$table." SET ".$updateset." WHERE ".$primaryID." = '".$IDValue."'") or die (mysql_error());
		  $this->database->query("UPDATE XE_PPL SET ".$updateset." WHERE PPLID = '".$ppl['PPLID']."'") or die($this->database->error);
		  
		  if (in_array("ROOT",XiinEngine::$user->PermArray) || in_array("Administrator",XiinEngine::$user->PermArray))
		  {
			  //Clear and reload permissions
			  if (isset($PermID_list) && !empty($PermID_list))
			  {
				  $this->database->query("DELETE FROM XE_PPL_Permissions WHERE PPLID = ".$ppl['PPLID']) or die ($this->database->error);
				  for ($i = 0; $i < count($PermID_list); $i++)
				  {
					  $this->database->query("INSERT INTO XE_PPL_Permissions (PPLID,PermID) VALUES(".$ppl['PPLID'].",".$PermID_list[$i].")") or die ($this->database->error);
				  }
			  }
		  }
	  }
	  header("location:".sysBaseURL."/ppl");
  }
 ?>