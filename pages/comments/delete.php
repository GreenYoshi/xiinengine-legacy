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
		
		$query = "SELECT CommentID, NewsID, PPLID FROM XE_NComments WHERE CommentID = '$id'";
		$result = $this->database->query($query);
		if($result->num_rows == 0)
		{
			$error .= "You can't delete this comment as it doesn't even exist<br />";
		}
		else
		{
			$comment = $result->fetch_assoc();
			if ($comment["PPLID"] == XiinEngine::$user->ID || in_array("Administrator",XiinEngine::$user->PermArray) || in_array("ROOT",XiinEngine::$user->PermArray))
			{
				$query = "SELECT NewsID, NewsPretty FROM XE_News WHERE NewsID = '".$comment["NewsID"]."'";
				$result = $this->database->query($query) or die("db query failed! ".$this->database->error);
				$news = $result->fetch_assoc();
				
				// todo/suggestion for RN7.1 ? show "comment deleted by user/admin request" and
				// keep showing replies. however to keep this neat and to allow admins to see
				// the original content we'll need an extra field in the table.
				$query = "DELETE FROM XE_NComments WHERE CommentID = '$id'";
				
				if($moduleDebug)
				{
					echo $query;
				}
				else
				{				
					$this->database->query($query) or die("db query failed! ".$this->database->error);
					$query = "DELETE FROM XE_NComments WHERE CommentReplyID = '$id'";
					$this->database->query($query) or die("db query failed! ".$this->database->error);
					header("location:".sysBaseURL."/news/".$news["NewsPretty"]);
				}
				
				$error .= "Deleted the comment";
			}
			else
			{
				$error .= "You aren't allowed to delete this comment<br />";
			}
		}		
	}
	else
		$error .= "Please login to comment<br />";
		
	echo $error;
?>