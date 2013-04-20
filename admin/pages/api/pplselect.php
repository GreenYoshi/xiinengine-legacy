<?
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
/*
	PPL selector for RN AdminCP

		Takes following GET inputs:
			id OR term
			page_limit (optional, defaults to 10)
				
		and outputs an JSON array in following format
		{
			"results": [
				{
					"id": "6",
					"alias": "GreenYoshi"
				}
				{
					"id": "2",
					"alias": "Test Administrator"
				}	
			]
		}	
		
		If JS doesn't send cookies with this request, then we'll have to find another way to get XE to know that we're authorized
		
	original code at https://github.com/ivaynberg/select2/wiki/PHP-Example

	Changelog:
	2012-11-03/2012-11-04 midnight	File created
	
*/
$row = array();
$return_arr = array();
$row_array = array();
$total = 0;

if((isset($_GET['term']) && strlen($_GET['term']) > 0) || (isset($_GET['id']) && is_numeric($_GET['id'])))
{

    if(isset($_GET['term']))
    {
        $getVar = $this->database->real_escape_string($_GET['term']);
        $whereClause =  " PPLAlias LIKE '%" . $getVar ."%' OR PPLFName LIKE '%" . $getVar ."%' OR PPLSName LIKE '%" . $getVar ."%' ";
    }
    elseif(isset($_GET['id']))
    {
		$getVar = intval($this->database->real_escape_string($_GET['id'])); // yay for redundant security
        $whereClause =  " PPLID = $getVar ";
    }
    /* limit with page_limit get */

	if(!isset($_GET["page_limit"]))
		$limit = 10;
	else
		$limit = intval($_GET['page_limit']);
	
	if(!isset($_GET["page"]))
		$page = 0;
	else
		$page = $limit * (intval($_GET["page"]) - 1);
	
    $sql = "SELECT PPLID, PPLAlias, PPLFName, PPLSName FROM XE_PPL WHERE $whereClause ORDER BY PPLAlias LIMIT $page, $limit";

    /** @var $result MySQLi_result */
    $result = $this->database->query($sql);
	
		$total = $result->num_rows;

        if($result->num_rows > 0)
        {

            while($row = $result->fetch_array())
            {
				if($row['PPLID'] != 1) // hide root user
				{
					$row_array['id'] = $row['PPLID'];
					$row_array['text'] = stripslashes(utf8_encode($row['PPLFName']." ".$row['PPLSName']." (".$row['PPLAlias'].")"));
					array_push($return_arr,$row_array);
				}
				else
				{
					$total = $total - 1; // hack!
				}
            }
        }
}
else
{
    $row_array['id'] = 0;
    $row_array['text'] = utf8_encode('Start typing ...');
    array_push($return_arr,$row_array);

}

$ret = array();
/* this is the return for a single result needed by select2 for initSelection */
if(isset($_GET['id']))
{
    $ret = $row_array;
}
/* this is the return for a multiple results needed by select2
* Your results in select2 options needs to be data.result
*/
else
{
	$ret['total'] = $total;
    $ret['results'] = $return_arr;
}

echo json_encode($ret);
$this->contentType = "application/json";

?>