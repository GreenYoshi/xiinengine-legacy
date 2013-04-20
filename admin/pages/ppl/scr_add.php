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

	extract($_GET);
	extract($_POST); // Get all form information
	// Error Checking Process. By default, data is ok
	$okdata = true;
	$error = "No errors occurred";
	// Null check
	//$nulls = explode(",",$notnulls);
	//foreach ($nulls as $nullcheck)
	//{
	//	if (${$nullcheck} == NULL)
	//	{
	//		$okdata = false;
	//		$error = "Error in null checking";
	//	}
	//}

	$firstentry = true;
	// Fetch field names
	// Loop non-nulls for insertion to table
	$dbvars = $this->database->query("DESCRIBE XE_PPL") or die($this->database->error);
	$ppl = $dbvars->fetch_assoc();

	while ($ppl = $dbvars->fetch_assoc())
	{
		//if (isset($ppl['Field']))
		//if (${$ppl['Field']} != NULL)
		
		//echo "Currently parsing: ".$ppl['Field']."<br />";
		
		if (isset(${$ppl['Field']}) && $ppl['Field'] != "PPLBanDate")
			${$ppl['Field']} = $this->database->real_escape_string(${$ppl['Field']});

		switch ($ppl['Field'])
		{
			case "PPLPass":
				if ($PPLNewPass == $PPLNewPass2)
				{
					if ($firstentry)
					{
						$insertvarset = $ppl['Field'];
						$insertvalset = "'".hash("sha512",XE_SALT_L.$PPLNewPass.XE_SALT_R)."'";
						$firstentry = false;
					}
					else
					{
						$insertvarset .= ",".$ppl['Field'];
						$insertvalset .= ",'".hash("sha512",XE_SALT_L.$PPLNewPass.XE_SALT_R)."'";
					}
				}
				break;
			case 'PPLAlias': //Regenerate the pretty url if the alias has changed
				if ($firstentry)
				{
					$insertvarset = $ppl['Field'];
					$insertvalset =  "'".${$ppl['Field']}."'";
					$firstentry = false;
				}
				else
				{
					$insertvarset .= ",".$ppl['Field'];
					$insertvalset .=  ",'".${$ppl['Field']}."'";
				}
				$pretty = preg_replace("/[^a-zA-Z0-9\s]/", "", $PPLAlias);
				$pretty = str_replace(" ","-",$pretty);
				$pretty = substr($pretty,0,50);
				$insertvarset .= ", PPLPretty";
				$insertvalset .= ",'".$pretty."'";
				break;
			case 'PPLBanDate':
				if (!empty(${$ppl['Field']}[2]))
				{
					$date = date("Y-m-d H:i:s", mktime(0,0,0,${$ppl['Field']}[1],${$ppl['Field']}[0],${$ppl['Field']}[2]));
					//$date = mktime(0,0,0,${$id["month"]},${$id["day"]},${$id["year"]});
					//echo $date;
					if ($firstentry)
					{
						$insertvarset = $ppl['Field'];
						$insertvalset =  "'".$date."'";
						$firstentry = false;
					}
					else
					{
						$insertvarset .= ",".$ppl['Field'];
						$insertvalset .=  ",'".$date."'";
					}
				}
				break;
			case 'PPLCreationDate':
				$date = date("Y-m-d H:i:s");
				//$date = mktime(0,0,0,${$id["month"]},${$id["day"]},${$id["year"]});
				//echo $date;
				if ($firstentry)
				{
					$insertvarset = $ppl['Field'];
					$insertvalset =  "'".$date."'";
					$firstentry = false;
				}
				else
				{
					$insertvarset .= ",".$ppl['Field'];
					$insertvalset .=  ",'".$date."'";
				}
				break;
			case 'PPLID': //the 'do nothing'/uneditable fields
			case 'PPLPretty':
			case 'PPLLastLogin':
			case 'PPLLastIP':
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
			case 'PPLNewPass': 
			case 'PPLNewPass2': 
			case 'PermID_list':
				break;
			default:
				if ($firstentry)
				{
					$insertvarset = $ppl['Field'];
					$insertvalset = "'".${$ppl['Field']}."'";
					$firstentry = false;
				}
				else
				{
					$insertvarset .= ",".$ppl['Field'];
					$insertvalset .= ",'".${$ppl['Field']}."'";
				}
				break;
		}
	}

	if ($moduleDebug)
	{
		echo "Insert Variable Set: ".$insertvarset."<br>";
		echo "Insert Value Set: ".$insertvalset."<br>";
		echo "Permissions Array: ".print_r($PermID_list)."<br>";
	}
	else
	{
		// If data is fine, insert into the table. Else, display the error
		if (!$okdata)
		{
			die($error);
		}
		else
		{
			$this->database->query("INSERT INTO XE_PPL (".$insertvarset.") VALUES(".$insertvalset.")") or die ($this->database->error);
			$pplid = mysqli_insert_id($this->database);
			for ($i = 0; $i < count($PermID_list); $i++)
			{
				$this->database->query("INSERT INTO XE_PPL_Permissions (PPLID,PermID) VALUES(".$pplid.",".$PermID_list[$i].")") or die ($this->database->error);
			}
			header("location:".sysBaseURL."/ppl");
		}
	}
}
?>