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
	
?>

<div class="result_button add"><a href="<?php echo sysBaseURL; ?>/articles/add" target="_self">Add Article</a></div>

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
	
	$result = $this->database->query("SELECT COUNT(NewsID) FROM `XE_News`");  
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
				echo "<div class='result_button pageno'><a href='".sysBaseURL."/articles/".$i."' target='_self'>".$i."</a></div>";
			}
		}
		echo '<table class="result_list">';
		echo '<tr>';
		echo '	<td class="result_header">Title</td>';
		echo '	<td class="result_header">Date</td>';
		echo '	<td class="result_header">Authors</td>';
		echo '	<td class="result_header">&nbsp;</td>';
		echo '</tr>';
		

		$newsquery = "SELECT NewsID, NewsTitle, NewsDate, NewsHighlight, NewsPublished, NewsPretty "
				. "FROM `XE_News` "
				. "ORDER BY NewsDate DESC LIMIT 10 OFFSET $listOffset;";
			   
		$newsresult = $this->database->query($newsquery) or die($this->database->error);
		
		while($news = $newsresult->fetch_assoc())
		{
			// Todo: Show date in user's local time
			//       Implement authors
			$authorquery = "SELECT PPLFName "
						. "FROM `XE_PPL` ppl, `XE_News_Author` plink "
						. "WHERE plink.NewsID = ".$news['NewsID']
						. " AND plink.PPLID = ppl.PPLID "
						. "ORDER BY PPLFName ASC";
			   
			$authorresult = $this->database->query($authorquery) or die($this->database->error);
			$flags = "";
				
			if ($news["NewsPublished"])
				$flags .= "<div class='result_button published'>P</div>";
			else
				$flags .= "<div class='result_button not_published'>P</div>";	
				
			if ($news["NewsHighlight"])
				$flags .= "&nbsp;<div class='result_button highlighted'>H</div>";
			else
				$flags .= "&nbsp;<div class='result_button not_highlighted'>H</div>";
			
			$editorPerms = "<div class='result_button edit'><a href='".sysBaseURL."/articles/edit/".$news['NewsPretty']."' target='_self'>Edit</a></div>";
			echo "<tr>";
			echo "<td>".$flags." ".stripslashes($news['NewsTitle'])." <div class='result_button view'><a href='".sysBaseURL."/articles/view/".$news['NewsPretty']."' target='_self'>VIEW</a></div></td>";
			echo "<td>";
//			echo '<script language="javascript" type="text/javascript">';
			echo date("jS M Y",strtotime($news['NewsDate']));
//			echo 'var newsTimeF = newsDate.format("g:ia");';
//			echo 'var newsDateF = newsDate.format("D/m/Y");';
//			echo 'document.write(newsDateF);';
//			echo '< /script>';
			echo ('</td>');
			echo "</td>";		// Todo: Show this in user's local time
			echo "<td>";
			while($author = $authorresult->fetch_assoc())
			{
				echo stripslashes($author['PPLFName'])."<br>";
				if (XiinEngine::$user->FName == $author['PPLFName'])
					$editorPerms .= "<div class='result_button delete'><a href='".sysBaseURL."/articles/scr_delete/".$news['NewsPretty']."' onclick='return confirmdelete()'>X</a></div>";
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