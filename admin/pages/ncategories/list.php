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
if (!in_array("Administrator",XiinEngine::$user->PermArray) && !in_array("ROOT",XiinEngine::$user->PermArray) && !in_array("Xiin Networks Developer",XiinEngine::$user->PermArray) && !in_array("Journalist",XiinEngine::$user->PermArray))
	$this->redirectPage = "/home";
	
?>

<div class="result_button add"><a href="<?php echo sysBaseURL; ?>/ncategories/add" target="_self">Add Category</a></div><br />

<?php
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
	
	$result = $this->database->query("SELECT COUNT(NCatID) FROM `XE_NCategories`");  
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
				echo "<div class='result_button pageno'><a href='".sysBaseURL."/ncategories/".$i."' target='_self'>".$i."</a></div>";
			}
		}
		echo '<table class="result_list">';
		echo '<tr>';
		echo '	<td>Category Name</td>';
		echo '	<td>Color</td>';
		echo '	<td>&nbsp;</td>';
		echo '</tr>';
		

		$permquery = "SELECT * "
				. "FROM `XE_NCategories` "
				. "ORDER BY NCatID ASC LIMIT 10 OFFSET $listOffset;";
			   
		$permresult = $this->database->query($permquery) or die($this->database->error);
		
		while($perm = $permresult->fetch_assoc())
		{
			$editorPerms = "<div class='result_button edit'><a href='".sysBaseURL."/ncategories/edit/".$perm['NCatID']."' target='_self'>Edit</a></div><div class='result_button delete'><a href='".sysBaseURL."/ncategories/scr_delete/".$perm['NCatID']."' onclick='return confirmdelete()'>X</a></div>";
			
			$colour = '<span style="color:'.$perm['NCatColor'].'">Color</span>';
			echo "<tr>";
			echo "<td>".$perm['NCatName']."</td>";
			echo "<td>".$colour."</td>";
			echo "<td class='result_actions'>".$editorPerms."</td>";
			echo "</tr>";
						
		}
		
		echo "</table>";
		
		   
	}
	else
	{
		echo "There's no categories to display";
	}


?>