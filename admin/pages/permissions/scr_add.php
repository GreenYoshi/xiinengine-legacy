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
if (!in_array("ROOT", XiinEngine::$user->PermArray))
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
$dbvars = $this->database->query("DESCRIBE XE_Permissions") or die($this->database->error);
$perm = $dbvars->fetch_assoc();

while ($perm = $dbvars->fetch_assoc()) {
    //if (isset($ppl['Field']))
    //if (${$ppl['Field']} != NULL)

    ${$perm['Field']} = $this->database->real_escape_string(${$perm['Field']});

    switch ($perm['Field']) {
        case 'PermAccessName':
            if (empty(${$perm['Field']})) {
                $okdata = false;
                $error = "Permission Name field cannot be empty!";
            } else {
                if ($firstentry) {
                    $insertvarset = $perm['Field'];
                    $insertvalset = "'" . ${$perm['Field']} . "'";
                    $firstentry = false;
                } else {
                    $insertvarset .= "," . $perm['Field'];
                    $insertvalset .= ",'" . ${$perm['Field']} . "'";
                }
            }
            break;
        case 'PermID': //the 'do nothing'/uneditable fields
            break;
        default:
            if ($firstentry) {
                $insertvarset = $perm['Field'];
                $insertvalset = "'" . ${$perm['Field']} . "'";
                $firstentry = false;
            } else {
                $insertvarset .= "," . $perm['Field'];
                $insertvalset .= ",'" . ${$perm['Field']} . "'";
            }
            break;
    }
}

if ($moduleDebug) {
    echo "Insert Variable Set: " . $insertvarset . "<br>";
    echo "Insert Value Set: " . $insertvalset . "<br>";
    echo $error;
} else {
    // If data is fine, insert into the table. Else, display the error
    if (!$okdata) {
        echo $error;
    } else {
        $this->database->query("INSERT INTO XE_Permissions (" . $insertvarset . ") VALUES(" . $insertvalset . ")") or die(mysql_error());
        header("location:" . sysBaseURL . "/permissions");
    }
}
?>