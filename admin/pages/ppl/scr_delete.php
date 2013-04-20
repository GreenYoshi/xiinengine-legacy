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
	$this->redirectPage = "/home";
}
else
{
	
  $moduleDebug = false;
  extract($_POST); // Get all form information
  // Grab info
  $pplquery = "SELECT * FROM XE_PPL WHERE PPLPretty = '".XiinEngine::$input[2]."'";
  $dbresult = $this->database->query($pplquery) or die($this->database->error);
  $ppl = $dbresult->fetch_assoc();
  
  if ($ppl['PPLID'] == 1)
  {
	echo "This account cannot be deleted";
  }
  else
  {
	if (!in_array("Administrator",XiinEngine::$user->PermArray) && !in_array("ROOT",XiinEngine::$user->PermArray))
		$this->redirectPage = "/home";
	$this->database->query("DELETE FROM XE_PPL WHERE PPLID = ".$ppl['PPLID']) or die ($this->database->error);
	$this->database->query("DELETE FROM XE_PPL_Permissions WHERE PPLID = ".$ppl['PPLID']) or die ($this->database->error);
	header("location:".sysBaseURL."/ppl");
  }

}

 ?>