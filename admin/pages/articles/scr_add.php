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
$dbvars = $this->database->query("DESCRIBE XE_News") or die($this->database->error);
$ppl = $dbvars->fetch_assoc();

while ($ppl = $dbvars->fetch_assoc())
{
	//if (isset($ppl['Field']))
	//if (${$ppl['Field']} != NULL)
	
	if (isset(${$ppl['Field']}))
		${$ppl['Field']} = $this->database->real_escape_string(${$ppl['Field']});

	switch ($ppl['Field'])
	{
		case 'NewsTitle': //Regenerate the pretty url if the alias has changed
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
			$pretty = preg_replace("/[^a-zA-Z0-9\s]/", "", $NewsTitle);
			$pretty = str_replace(" ","-",$pretty);
			$pretty = substr($pretty,0,50);
			$insertvarset .= ", NewsPretty";
			$insertvalset .= ",'".$pretty."'";
			break;
		case 'NewsID': //the 'do nothing'/uneditable fields
		case 'NewsPretty':
		case 'PPLID_list':
		case 'NCatID_list':
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
	echo "Authors Array: ";
	print_r($PPLID_list);
	echo "<br>";
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
		$this->database->query("INSERT INTO XE_News (".$insertvarset.") VALUES(".$insertvalset.")") or die ($this->database->error);
		$newsid = mysqli_insert_id($this->database);
		for ($i = 0; $i < count($PPLID_list); $i++)
		{
			if(!empty($PPLID_list[$i]))
				$this->database->query("INSERT INTO XE_News_Author (NewsID,PPLID) VALUES(".$newsid.",".$PPLID_list[$i].")") or die ($this->database->error);
		}
		for ($i = 0; $i < count($NCatID_list); $i++)
		{
			$this->database->query("INSERT INTO XE_News_Categories (NewsID,NCatID) VALUES(".$newsid.",".$NCatID_list[$i].")") or die ($this->database->error);
		}
		header("location:".sysBaseURL."/articles");
	}
}
		
		
?>