<?
/**
 * XiinEngine
 *
 * * XiinEngine is supplied under the MIT license. Please read license.md  in the root directory
 *
 * @package XiinEngine Legacy
 * @author Ian Karlsson <ian.karlsson@xiinet.com>
 * @author Philip Whitehall <philip.whitehall@xiinet.com> 
 * @copyright Copyright 2006-2013 Xiin Networks <http://xiinet.com/>
 * @link http://xiinengine.com/
 * @since v1.2
 */   

$pageNumber = 1;
$result = $this->database->query("SELECT COUNT(NewsID) FROM `XE_News`");  
$array = $result->fetch_array();
$totalPosts = $array[0];

$newsquery = "SELECT NewsID, NewsTitle, NewsDate, NewsHighlight, NewsPublished, NewsContent, NewsPretty "
			."FROM `XE_News` "
			."WHERE NewsPublished = 1 "
			."ORDER BY NewsDate DESC LIMIT 5";

$newsresult = $this->database->query($newsquery) or die(mysql_error());

?>
<div class="news_outer">
    <?php
    
    while($news = $newsresult->fetch_assoc())
    {
        // Todo: Show date in user's local time
        //       Implement authors
        $authorquery = "SELECT PPLFName "
                    ."FROM `XE_PPL` ppl, `XE_News_Author` plink "
                    ."WHERE plink.NewsID = ".$news['NewsID']." "
                    ."AND plink.PPLID = ppl.PPLID "
                    ."ORDER BY PPLFName ASC";
                    
        $authorresult = $this->database->query($authorquery) or die($this->database->error);
		$authorOut = '';
		$firstAuthor = true;
		while($author = $authorresult->fetch_assoc())
        {
			if ($firstAuthor) {
				$authorOut = $author['PPLFName'];
				$firstAuthor = false;
			} else {
				$authorOut .= ', '.$author['PPLFName'];
			}
            
        }
        
		echo '<br /><div class="news_entry_outer">';
        echo '<div class="news_header_outer">';
		echo '<a href="'.sysBaseURL."/news/".$news['NewsPretty'].'" target="_self">'.$news['NewsTitle'].'</a>';
		echo '</div>';
		echo '<div class="news_info_outer">';
		echo date("jS M Y",strtotime($news['NewsDate'])).' by '.$authorOut;
		echo '</div>';
                $socialLink = sysBaseURL."news/".$news['NewsPretty'];
               echo '<fb:like href="'.$socialLink.'" send="true" layout="button_count" width="450" show_faces="false"></fb:like>';
                echo '&nbsp;&nbsp;<a href="https://twitter.com/share" class="twitter-share-button" data-url="'.$socialLink.'" data-lang="en">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> ';
                echo '<g:plusone href="'.$socialLink.'"></g:plusone>';
                echo '<div class="news_content_outer">'.substr(stripslashes(strip_tags($news['NewsContent'])),0,300).'...</div>';
		echo '<div class="xe_clear"></div>';
		echo '<div class="news_view_button_outer"><a href="'.sysBaseURL."/news/".$news['NewsPretty'].'" target="_self">READ IN FULL</a></div>';
		echo '<div class="xe_clear"></div>';
		echo '</div>';
		
        
        
    }
    
    echo '<div class="news_header_outer">';
    $pagenumbers = ceil($totalPosts / 5);

    if($pageNumber < $pagenumbers)
    {
        $page = $pageNumber+1;
        echo '<a href="'.sysBaseURL.'/news/'.$page.'">Older news &gt</a>';
    }
    echo '</div>';
    
    if ($newsresult->num_rows == 0) {
        echo 'Sorry, there are no news posts to display';
    }
    ?>

</div>