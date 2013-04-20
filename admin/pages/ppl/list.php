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
?>

<div class="result_button add"><a href="<?php echo sysBaseURL; ?>/ppl/add" target="_self">+ Add User</a></div>

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
	
	$result = $this->database->query("SELECT COUNT(PPLID) FROM `XE_PPL`");  
	$array = $result->fetch_array();
	$totalPosts = $array[0];
	
	if($listOffset < $totalPosts)
	{
		if ($totalPosts > 10)
		{
			echo "| Pages: ";
			$pagenumbers = ceil($totalPosts / 10);
			for($i = 1; $i <= $pagenumbers; $i++)
			{
				$pagelink = $i + 1;
				echo "<div class='result_button pageno'><a href='".sysBaseURL."/ppl/".$i."' target='_self'>".$i."</a></div>";
			}
		}
		echo '<table class="result_list">';
		echo '<tr>';
		echo '	<td class="result_header">Name</td>';
		echo '	<td class="result_header">Alias</td>';
		echo '	<td class="result_header">Permissions</td>';
		echo '	<td class="result_header">&nbsp;</td>';
		echo '</tr>';
		

		$pplquery = "SELECT PPLID, PPLFName, PPLSName, PPLAlias, PPLPretty "
				. "FROM `XE_PPL` "
				. "WHERE PPLID != 1 "
				. "ORDER BY PPLID ASC LIMIT 10 OFFSET $listOffset;";
			   
		$pplresult = $this->database->query($pplquery) or die($this->database->error);
		
		while($ppl = $pplresult->fetch_assoc())
		{
			// Todo: Show date in user's local time
			//       Implement authors
			$pplquery = "SELECT PermAccessName "
						. "FROM `XE_Permissions` perm, `XE_PPL_Permissions` plink "
						. "WHERE plink.PPLID = ".$ppl['PPLID']
						. " AND plink.PermID = perm.PermID "
						. "ORDER BY PermAccessName ASC";
			   
			$permresult = $this->database->query($pplquery) or die($this->database->error);
			if ($ppl['PPLID'] == 1)
			{
				$editorPerms = "<div class='result_button edit'><a href='".sysBaseURL."/ppl/edit/".$ppl['PPLPretty']."' target='_self'>Edit</a></div>";
			}
			else
			{
				$editorPerms = "<div class='result_button edit'><a href='".sysBaseURL."/ppl/edit/".$ppl['PPLPretty']."' target='_self'>Edit</a></div><div class='result_button delete'><a href='".sysBaseURL."/ppl/scr_delete/".$ppl['PPLPretty']."' onclick='return confirmdelete()'>X</a></div><div class='result_button edit'><a href='".sysBaseURL."/ppl/passreset/".$ppl['PPLPretty']."' target='_self'>Reset Password</a></div>";
			}
			echo "<tr>";
			echo "<td>".$ppl['PPLFName']." ".$ppl['PPLSName']."</td>";
			echo "<td>".$ppl['PPLAlias']."</td>";
			echo "<td>";
			while($perm = $permresult->fetch_assoc())
			{
				echo $perm['PermAccessName']."<br>";
			}
			echo "</td>";
			echo "<td class='result_actions'>".$editorPerms."</td>";
			echo "</tr>";
						
		}
		
		echo "</table>";
		
		   
	}
	else
	{
		echo "There's no posts to display";
	}


?>