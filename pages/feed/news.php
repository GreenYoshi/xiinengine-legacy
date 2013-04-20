<?php
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
 
	$output = "";
	
	// get latest podcast
	$query = "SELECT NewsDate FROM XE_News WHERE NewsPublished = '1' ORDER BY NewsDate DESC LIMIT 1";
	$result = $this->database->query($query) or die($this->database->error);
	$lastnews = $result->fetch_assoc();
	$newsupdate = date(DATE_RSS,strtotime($lastnews["NewsDate"]));

	$output .= '<?xml version="1.0"?>';
	$output .= '<rss version="2.0">';
	$output .= '<channel>';
	$output .= '<title>'.XE_SITE_NAME.' News Feed</title>';
	$output .= '<link>'.sysBaseURL.'</link>';
	$output .= '<description>'.XE_SITE_NAME.'\'s news feed</description>';
	$output .= '<image>';
	$output .= '<url>'.sysBaseURL.'/imgbin/header_logo.png</url>';
	$output .= '<title>'.sysBaseURL.'</title>';
	$output .= '<link>'.sysBaseURL.'</link>';
	$output .= '<width>386</width><height>110</height>';
	$output .= '</image>';
	$output .= '<language>en-us</language>';
	$output .= '<copyright>All original content copyright '.sysBaseURL.'</copyright>';
	$output .= '<lastBuildDate>'.$newsupdate.'</lastBuildDate>';
	$output .= '<generator>XiinEngine v1.1 Feed Generator</generator>';
	$output .= '<ttl>30</ttl>';
	
	$query = "SELECT NewsID, NewsTitle, NewsContent, NewsPretty, NewsDate FROM XE_News WHERE NewsPublished = '1' ORDER BY NewsDate DESC LIMIT 30";
	$result = $this->database->query($query) or die($this->database->error);
	while($news = $result->fetch_assoc())
	{
		$date = date(DATE_RSS,strtotime($news["NewsDate"]));
		$title = htmlspecialchars(stripslashes($news["NewsTitle"]));
		$desc = stripslashes($news["NewsContent"]);
		
		$fixed_desc = htmlspecialchars(substr(strip_tags($desc),0,200));
		
		$guid = $news["NewsID"];
		$url = htmlspecialchars(sysBaseURL."/news/".stripslashes($news["NewsPretty"]));
		
		$output .= '<item>';
		$output .= '<title>'.$title.'</title>';
		$output .= '<description>'.$fixed_desc; // substr broken ? lengths over 200 will cause php to crash?
		$output .= '...</description><pubDate>'.$date.'</pubDate>';
		$output .= '<link>'.$url.'</link>';
		$output .= '<guid>'.$guid.'</guid>';
		$output .= '</item>';
	}
	$output .= '</channel>';
	$output .= '</rss>';
	
	$this->contentType = "text/xml";
	echo($output);
	
?>