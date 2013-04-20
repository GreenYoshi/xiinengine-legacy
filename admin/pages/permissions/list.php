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
	$this->redirectPage = "/home";
	
	
 if (in_array("ROOT",XiinEngine::$user->PermArray)) {
	 ?>
	<div class="result_button add"><a href="<?php echo sysBaseURL.'/'.XiinEngine::$input[0]; ?>/forms/add" target="_self">+ Add Permission</a></div><br />

<?php
 	}
	$this->pageScripts .= '<script type="text/javascript">'
						.'function confirmdelete() {'
						.' var conText = "Delete this entry? This cannot be reversed.";'
						.'	return confirm(conText);'
						.'}'
						.'</script>';
	// Get page number
	if(isset(XiinEngine::$input[1]))
		$pageNumber = XiinEngine::$input[1];
	else
		$pageNumber = 1;

	// Security		
	if (!is_numeric($pageNumber))
		$pageNumber = 1;
		
	$listOffset = $pageNumber * 10 - 10;
	
	$result = $this->database->query("SELECT COUNT(PermID) FROM `XE_Permissions`");  
	$array = $result->fetch_array();
	$totalPosts = $array[0];
	
	if($listOffset < $totalPosts)
	{
		if ($totalPosts > 10)
		{
			$pagenumbers = ceil($totalPosts / 10);
			for($i = 1; $i <= $pagenumbers; $i++)
			{
				$pagelink = $i + 1;
				echo "<div class='result_button pageno'><a href='".sysBaseURL."/".XiinEngine::$input[0]."/".$i."' target='_self'>".$i."</a></div>";
			}
		}
		echo '<table class="result_list">';
		echo '<tr>';
		echo '	<td class="result_header">Permission Name</td>';
		echo '	<td class="result_header">&nbsp;</td>';
		echo '</tr>';
		

		$permquery = "SELECT * "
				. "FROM `XE_Permissions` "
				. "ORDER BY PermAccessName ASC LIMIT 10 OFFSET $listOffset;";
			   
		$permresult = $this->database->query($permquery) or die($this->database->error);
		
		while($perm = $permresult->fetch_assoc())
		{
			if ($perm['PermID'] != 1)
			{
				$editorPerms = '';
				if (in_array("ROOT",XiinEngine::$user->PermArray)) {
					$editorPerms = "<div class='result_button edit'><a href='".sysBaseURL."/".XiinEngine::$input[0]."/forms/edit/".$perm['PermID']."' target='_self'>Edit</a></div><div class='result_button delete'><a href='".sysBaseURL."/".XiinEngine::$input[0]."/scr_delete/".$perm['PermID']."' onclick='return confirmdelete()'>X</a></div>";
					
				}
				
				echo "<tr>";
				echo "<td>".$perm['PermAccessName']."</td>";
				echo "<td class='result_actions'>".$editorPerms."</td>";
				echo "</tr>";
			}		
		}
		
		echo "</table>";
		
		   
	}
	else
	{
		echo "There's no posts to display";
	}


?>