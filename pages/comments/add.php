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
 
//	$reply is set by page.php
	$moduleDebug = false;
	$error = "";
	
	// Check if any user is logged in
	if(XiinEngine::$userIsAuth == true)
	{
		$id = $this->database->real_escape_string(XiinEngine::$input[2]);
		$pplid = XiinEngine::$user->ID;
		
		// check for recent comments
		$timecheck = date('Y-m-d H:i:s', time() -(10*60)); // 10 minutes ago
		$query = "SELECT CommentID FROM XE_NComments WHERE PPLID = '$pplid' & CommentDate > '$timecheck'";
		$result = $this->database->query($query);
		// if user has more than 4 posts, we'll prevent the user from posting
		if($result->num_rows > 4)
		{
			$error .= "You're commenting too often. Please wait a few minutes and try again.";
		}
		
	}
	else
		$error .= "Please login to comment<br />";
	
	// Check if ID exists and is numeric
	if(!empty(XiinEngine::$input[2]) && is_numeric(XiinEngine::$input[2]))
		$id = $this->database->real_escape_string(XiinEngine::$input[2]);
	else
		$error .= "Please enter a numeric ID<br />";
		
	// check if content exists
	if(!empty($_POST["commentcontent"]))
		$content = ($_POST["commentcontent"]); // reason we aren't escaping here is because we'll escape the final output later
	else
		$error .= "Please enter some content<br />";
	
		
	// get news id if the comment is a reply
	if($reply)
	{
		$query = "SELECT CommentID, NewsID FROM XE_NComments WHERE CommentID = '$id'";
		$result = $this->database->query($query);
		$comment = $result->fetch_assoc();
		if($result->num_rows > 0)
		{
			$newsid = $comment["NewsID"];
		}
		else
		{
			$error .= "The comment you're replying to doesn't exist. It might have been deleted.";
		}
	}
	else
	{
		$newsid = $id;	
	}

//  if we need to restrict to recent postings only, have this...
//	$old_date = date('Y-m-d H:i:s', time() -(30*86400)); // 30 days ago

	$query = "SELECT NewsID, NewsDate, NewsPretty FROM XE_News WHERE NewsID = '$newsid' AND NewsPublished = '1'";
	$result = $this->database->query($query) or die($this->database->error);
	$news = $result->fetch_assoc();
	if($result->num_rows == 0)
	{	
		$error .= "This news article doesn't exist. It might have been deleted.";
	}
	
	if($error == "")
	{
		echo "ok<br />";
		
		$purifier_config = HTMLPurifier_Config::createDefault();
		$purifier = new HTMLPurifier($purifier_config);
		$content = $this->database->real_escape_string($purifier->purify($content));
		$date = date('Y-m-d H:i:s');

		if($reply)
			$query = "INSERT INTO XE_NComments (`NewsID`,`PPLID`,`CommentDate`,`CommentContent`,`CommentReplyID`)"
					."VALUES ('$newsid','$pplid','$date','$content','$id')";
		else
			$query = "INSERT INTO XE_NComments (`NewsID`,`PPLID`,`CommentDate`,`CommentContent`)"
					."VALUES ('$newsid','$pplid','$date','$content')";
		
		if($moduleDebug)
		{
			echo $query;
		}
		else
		{					
			$this->database->query($query) or die("db query failed! ".$this->database->error);
			header("location:".sysBaseURL."/news/".$news["NewsPretty"]);
		}
		
	}
	else
	{
		echo "The comment could not be posted because of the following error(s):<br /> $error";	
	}

?>