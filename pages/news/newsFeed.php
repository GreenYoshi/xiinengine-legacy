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

// Get page number
if (isset(XiinEngine::$input[1]) && is_numeric(XiinEngine::$input[1]))
    $pageNumber = XiinEngine::$input[1];

$listOffset = $pageNumber * 5 - 5;

$result = $this->database->query("SELECT COUNT(NewsID) FROM `XE_News`");
$array = $result->fetch_array();
$totalPosts = $array[0];

$singlepost = false;

if (!empty(XiinEngine::$input[1]) && is_numeric(XiinEngine::$input[1])) {
    $newsquery = "SELECT NewsID, NewsTitle, NewsDate, NewsHighlight, NewsPublished, NewsContent, NewsPretty "
            . "FROM `XE_News` "
            . "WHERE NewsPublished = 1 "
            . "ORDER BY NewsDate DESC LIMIT 5 OFFSET $listOffset";
} else if (!empty(XiinEngine::$input[1])) {
    $newsquery = "SELECT NewsID, NewsTitle, NewsDate, NewsHighlight, NewsPublished, NewsContent, NewsPretty "
            . "FROM `XE_News` "
            . "WHERE NewsPublished = 1 "
            . "AND NewsPretty = '" . $this->database->real_escape_string(XiinEngine::$input[1]) . "' "
            . "ORDER BY NewsDate DESC LIMIT 1";
    $singlepost = true;
} else {
    $newsquery = "SELECT NewsID, NewsTitle, NewsDate, NewsHighlight, NewsPublished, NewsContent, NewsPretty "
            . "FROM `XE_News` "
            . "WHERE NewsPublished = 1 "
            . "ORDER BY NewsDate DESC LIMIT 5";
}

$newsresult = $this->database->query($newsquery) or die(mysql_error());
?>
<div class="news_outer">
    <?php
    while ($news = $newsresult->fetch_assoc()) {
        $headerOut = '';
        $newsOut = '';
        if ($singlepost) {
            $headerOut = $news['NewsTitle'];
            $newsOut = stripslashes($news['NewsContent']);
            $this->titleData = '' . $news['NewsTitle'] . '';
            $this->metaData = '' . substr(strip_tags($news['NewsContent']), 0, 152) . '...';
        } else {
            $headerOut = '<a href="' . sysBaseURL . "/news/" . $news['NewsPretty'] . '" target="_self">' . $news['NewsTitle'] . '</a>';
            $newsOut = substr(stripslashes(strip_tags($news['NewsContent'])), 0, 300) . "...";
        }
        // Todo: Show date in user's local time
        //       Implement authors
        $authorquery = "SELECT PPLFName "
                . "FROM `XE_PPL` ppl, `XE_News_Author` plink "
                . "WHERE plink.NewsID = " . $news['NewsID'] . " "
                . "AND plink.PPLID = ppl.PPLID "
                . "ORDER BY PPLFName ASC";

        $authorresult = $this->database->query($authorquery) or die($this->database->error);
        $authorOut = '';
        $firstAuthor = true;
        while ($author = $authorresult->fetch_assoc()) {
            if ($firstAuthor) {
                $authorOut = $author['PPLFName'];
                $firstAuthor = false;
            } else {
                $authorOut .= ", " . $author['PPLFName'] . "";
            }
        }

        echo '<br /><div class="news_entry_outer">';
        echo '<div class="news_header_outer">';
        echo $headerOut;
        echo '</div>';
        echo '<div class="news_info_outer">';
        echo date("jS M Y", strtotime($news['NewsDate'])) . ' by ' . $authorOut;
        echo '</div>';
        $socialLink = sysBaseURL . "news/" . $news['NewsPretty'];
        echo '<fb:like href="' . $socialLink . '" send="true" layout="button_count" width="450" show_faces="false"></fb:like>';
        echo '&nbsp;&nbsp;<a href="https://twitter.com/share" class="twitter-share-button" data-url="' . $socialLink . '" data-lang="en">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> ';
        echo '<div class="news_content_outer">' . $newsOut . '</div>';
        echo '<g:plusone href="' . $socialLink . '"></g:plusone>';
        if ($singlepost == false) {
            echo '<div class="news_view_button_outer"><a href="' . sysBaseURL . "/news/" . $news['NewsPretty'] . '" target="_self">READ IN FULL</a></div>';
        }
        echo '<div class="xe_clear"></div>';
        echo '</div>';

        if ($singlepost) {
            // COMMENTS BOXES!
            $query = "SELECT `CommentID`, p.`PPLID` AS `PPLID`, p.`PPLAlias` AS `PPLAlias`, p.`PPLIconURL` AS `PPLIconURL`, `CommentDate`, `CommentContent` FROM XE_NComments c LEFT JOIN XE_PPL p ON p.PPLID = c.PPLID WHERE c.`NewsID` = '" . $news["NewsID"] . "' AND c.`CommentReplyID` IS NULL";
            $result = $this->database->query($query) or die($this->database->error);

            if ($result->num_rows > 0) {
                while ($comment = $result->fetch_assoc()) {
                    $commentID = stripslashes($comment['CommentID']);
                    $pplID = stripslashes($comment['PPLID']);
                    $pplAlias = stripslashes($comment['PPLAlias']);
                    $pplIcon = stripslashes($comment['PPLIconURL']);
                    $date = stripslashes(date("jS M Y", strtotime($comment['CommentDate'])));
                    $content = stripslashes($comment['CommentContent']);

                    //Start styling here
                    $actions = '<div class="news_view_button_outer"><a href="#" onclick="$(\'#replybox_' . $commentID . '\').toggle()">Reply</a></div>';
                    if (XiinEngine::$userIsAuth) {
                        if ($pplID == XiinEngine::$user->ID || in_array("Administrator", XiinEngine::$user->PermArray) || in_array("ROOT", XiinEngine::$user->PermArray)) {
                            $actions .= '&nbsp;&nbsp;<div class="news_view_button_outer"><a href="' . sysBaseURL . '/comments/delete/' . $commentID . '">Delete</a></div> ';
                        }
                    }

                    if (XiinEngine::$userIsAuth == true) {
                        $form = '<form action="' . sysBaseURL . '/comments/addreply/' . $commentID . '" method="POST"><textarea name="commentcontent" rows="5" style="width:100%"></textarea><input type="submit" value="Post reply" /></form>';
                    } else {
                        $form = 'Please login to reply';
                    }

                    echo '<div class="news_comment">'
                    . '<div class="news_comment_info">' . $pplAlias . ' says...</div>'
                    . '<div class="news_comment_date">On ' . $date . '</div>'
                    . '<div class="news_comment_content">' . $content . '</div>'
                    . '<div class="news_comment_action_container">' . $actions . '</div>'
                    . '<div id="replybox_' . $commentID . '" class="news_comment_replybox" style="display:none">'
                    . $form
                    . '</div>'
                    . '<div class="xe_clear"></div>'
                    . '</div>'
                    . '<div class="xe_clear"></div>';
                    //End styling here

                    $query = "SELECT `CommentID`, p.`PPLID` AS `PPLID`, p.`PPLAlias` AS `PPLAlias`, p.`PPLIconURL` AS `PPLIconURL`, `CommentDate`, `CommentContent` FROM XE_NComments c LEFT JOIN XE_PPL p ON p.PPLID = c.PPLID WHERE c.`NewsID` = '" . $news["NewsID"] . "' AND c.`CommentReplyID` = '" . $comment["CommentID"] . "'";
                    $replyresult = $this->database->query($query) or die($this->database->error);

                    if ($replyresult->num_rows > 0) {
                        while ($reply = $replyresult->fetch_assoc()) {
                            $replyID = stripslashes($reply['CommentID']);
                            $pplID = stripslashes($reply['PPLID']);
                            $pplAlias = stripslashes($reply['PPLAlias']);
                            $pplIcon = stripslashes($reply['PPLIconURL']);
                            $date = stripslashes(date("jS M Y", strtotime($reply['CommentDate'])));
                            $content = stripslashes($reply['CommentContent']);
                            //Start styling here			
                            $actions = '<div class="news_view_button_outer"><a href="#" onclick="$(\'#replybox_' . $replyID . '\').toggle()">Reply</a></div>';
                            if (!empty(XiinEngine::$user)) {
                                if (in_array("Administrator", XiinEngine::$user->PermArray) || in_array("ROOT", XiinEngine::$user->PermArray)) {
                                    $actions .= '&nbsp;&nbsp;<div class="news_view_button_outer"><a href="' . sysBaseURL . '/comments/delete/' . $replyID . '">Delete</a></div>';
                                }
                            }

                            echo '<div class="news_comment">'
                            . '<div class="news_comment_info">' . $pplAlias . ' says...</div>'
                            . '<div class="news_comment_date">On ' . $date . '</div>'
                            . '<div class="news_comment_content">' . $content . '</div>'
                            . '<div class="news_comment_action_container">' . $actions . '</div>'
                            . '<div id="replybox_' . $replyID . '" class="news_comment_replybox" style="display:none">'
                            . $form
                            . '</div>'
                            . '<div class="xe_clear"></div>'
                            . '</div>'
                            . '<div class="xe_clear"></div>';
                            //End styling here
                        }
                    }
                }
            } else {
                echo "No comments have been added yet. Be the first!";
            }

            if (XiinEngine::$userIsAuth == true) {
                $form = '<form action="' . sysBaseURL . '/comments/add/' . $news['NewsID'] . '" method="POST"><textarea name="commentcontent" rows="5" style="width:100%"></textarea><input type="submit" value="Post comment" /></form>';
            } else {
                $form = 'Please login to comment';
            }

            echo '<div class="news_comment_foot">' . $form . '</div>';
            echo '<div class="xe_clear"></div>';
        }
    }
// simple pagination
    if (!$singlepost) {
        echo '<div class="news_header_outer">';
        $pagenumbers = ceil($totalPosts / 5);

        if ($pageNumber > 1) {
            $page = $pageNumber - 1;
            echo '<a href="' . sysBaseURL . '/news/' . $page . '">&lt Previous page</a>';
        }
        if ($pageNumber > 1 && $pageNumber < $pagenumbers) {
            echo ' | ';
        }
        if ($pageNumber < $pagenumbers) {
            $page = $pageNumber + 1;
            echo '<a href="' . sysBaseURL . '/news/' . $page . '">Next page &gt</a>';
        }
        echo '</div>';
    }
    
    if ($newsresult->num_rows == 0) {
        echo 'Sorry, there are no news posts to display';
    }
    ?>

</div>
