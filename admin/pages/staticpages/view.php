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
	
?>

<div class="result_button add"><a href="<?php echo sysBaseURL; ?>/staticpages/" target="_self">Return</a></div><br />

<?php 
$this->titleData = "View Mode - Pages Administration";
$this->pageScripts = "";

$newsPretty = $this->database->real_escape_string(substr(XiinEngine::$input[2],0,50));
$newsquery = "SELECT * FROM XE_Pages WHERE PagePretty = '".$newsPretty."'";
$dbresult = $this->database->query($newsquery) or die($this->database->error);
$news = $dbresult->fetch_assoc();


?>
Below is a draft preview of how a page would look on the public website.
<div class="view_news_container"><div class="view_news_inner">
<div class="view_news_category">&nbsp;</div>
<div class="view_news_title"><?=$news['PageTitle']?></div>
<div class="view_news_date"><?=date("jS M Y",strtotime($news['PageDate']))?></div>
<div class="view_news_body"><?=stripslashes($news['PageContent'])?></div>
</div></div>

<div class="result_button add"><a href="<?php echo sysBaseURL; ?>/staticpages/" target="_self">Return</a></div><br />
