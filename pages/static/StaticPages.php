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

$singlepost = true;

$newsquery = "SELECT PageID, PageTitle, PageDate, PagePublished, PageContent, PagePretty "
		. "FROM `XE_Pages` "
		. "WHERE PagePublished = 1 "
		. "AND PagePretty = '" . $this->database->real_escape_string(XiinEngine::$input[0]) . "' "
		. "ORDER BY PageID DESC LIMIT 1";

$newsresult = $this->database->query($newsquery) or die($this->database->error);
?>
<div class="news_outer">
    <?php
    while ($news = $newsresult->fetch_assoc()) {
        $headerOut = '';
        $newsOut = '';
		$headerOut = $news['PageTitle'];
		$newsOut = stripslashes($news['PageContent']);
		$this->titleData = '' . $news['PageTitle'] . '';
		$this->metaData = '' . substr(strip_tags($news['PageContent']), 0, 152) . '...';

        echo '<br /><div class="news_entry_outer">';
        echo '<div class="news_header_outer">';
        echo $headerOut;
        echo '</div>';
        echo '<div class="news_info_outer">';
        echo date("jS M Y", strtotime($news['PageDate']));
        echo '</div>';
        $socialLink = sysBaseURL . "/" . $news['PagePretty'];
        echo '<fb:like href="' . $socialLink . '" send="true" layout="button_count" width="450" show_faces="false"></fb:like>';
        echo '&nbsp;&nbsp;<a href="https://twitter.com/share" class="twitter-share-button" data-url="' . $socialLink . '" data-lang="en">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> ';
        echo '<div class="news_content_outer">' . $newsOut . '</div>';
        echo '<g:plusone href="' . $socialLink . '"></g:plusone>';
        echo '<div class="xe_clear"></div>';
        echo '</div>';
    }
    
    if ($newsresult->num_rows == 0) {
        header('Location: '.sysBaseURL.'/404');
		echo 'fail';
    }
    ?>

</div>