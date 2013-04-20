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
$moduleDebug = false;

$okdata = true;
$error = "all ok";

$permquery = "SELECT * FROM XE_Switchboard";
$dbresult = $this->database->query($permquery) or die($this->database->error);
while ($setting = $dbresult->fetch_assoc())
{
	$name = $setting['SwitchName'];
	if(isset($_POST[$setting['SwitchName']]))
	{
		$value = $this->database->real_escape_string($_POST[$setting['SwitchName']]);
		$abortquery = false;
		//$settings[$setting['SwitchName']] = $setting['SwitchValue'];
		switch($name)
		{
			case 'site_name':
			case 'site_description':
			case 'public_site_theme':
				if(empty($value))
				{
					$abortquery = true;
					$okdata = false;
					$error = "A required field is empty.";
				}
			break;
			default:
				//...
			break;
		}
		if($abortquery === false)
		{
			$query = "UPDATE XE_Switchboard SET SwitchValue = '$value' WHERE SwitchName = '$name'";
			if($moduleDebug)
			{
				echo $query."<br />\n";
			}
			else
			{
				$this->database->query($query) or die($this->database->error);
			}
		}
	}
}

if ($okdata == true && $moduleDebug == false)
	header("location:".sysBaseURL."/settings");
else
	echo($error);
        
 ?>