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
/**
 *  This page 'does' login. There's no page.php here because this page doesn't
 *  actually display anything. 
 */ 
class page_dologin extends XePage
{
    private $redirectLocation;
    private $statusMessage;
    
    public function runPage()
    {
    	$PermissionCheck = false;	// Becomes true if having administrator permissions
		$loginCheck = false;		// Becomes true if user/pass successful AND user not banned
    
		// Does our POST exist?
		if(isset($_POST["authUsername"]) && isset($_POST["authPassword"]))
		{
			
			$postUser = $this->database->real_escape_string(strtolower($_POST["authUsername"]));
			$postPass = hash("sha512",XE_SALT_L.$_POST["authPassword"].XE_SALT_R);
			
			// Check if user exists
			$dbResult = $this->database->query("SELECT `PPLID`, LOWER(`PPLAlias`) AS PPLAlias, `PPLPass`, `PPLBanDate` FROM XE_PPL WHERE `PPLAlias` = LOWER('$postUser');") or die("DB error" . $this->database->error());
			$dbRow = $dbResult->fetch_assoc();
			
			if(isset($dbRow["PPLID"]))
			{
			
				$dbID = $dbRow["PPLID"];
				$dbAlias = $dbRow["PPLAlias"];
				$dbPass = $dbRow["PPLPass"];
				$dbBanDate = $dbRow["PPLBanDate"];
				
				// Check if aliases and passwords match
				if($dbAlias == $postUser && $dbPass == $postPass)
				{
				
					if($dbID == 1 && sysMaintenanceMode === false)
					{
					
						if (!isset($this->statusMessage))
							$this->statusMessage = "This account is disabled.";
						
					}
					else
					{
					
						// Ensure that user is not banned
						if(time() > strtotime($dbBanDate))
						{			
							$loginCheck = true;
							
							// Login successful, let's check permissions now
							//$this->statusMessage = "Password match, checking permissions: ";
							
							$dbQuery = "SELECT perm.PermAccessName AS access " // get permission names
								   . "FROM XE_PPL_Permissions link INNER JOIN XE_Permissions perm " // Join linker table with permission table to reduce query count
								   . "ON link.PermID=perm.PermID "
								   . "WHERE link.PPLID = ".$dbID." "
								   . "ORDER BY perm.PermID;";
								   
							$dbResult = $this->database->query($dbQuery) or die("DB error" . $this->database->error);
							
							$PermissionCheck = true;
							
//							while($dbRow = $dbResult->fetch_assoc())
//							{
//		//						if($dbRow["access"] == "ROOT" || $dbRow["access"] == "Administrator")
//		//						{
//		//							$PermissionCheck = true;
//		//						}	
//								switch ($dbRow["access"])
//								{
//									case "ROOT":
//									case "Administrator":
//										$PermissionCheck = true;
//										break;
//									case "Locations & Schedule Manager":
//									case "News Manager":
//									case "Fuel Surcharge Manager":
//									case "Documents Manager":
//									case "Jobs Manager":
//										if (!sysMaintenanceMode)
//											$PermissionCheck = true;
//										else
//											$this->statusMessage = "Only Admins can login during maintenance";	
//										break;
//									default:
//										break;
//								}	
//							}
							
							if($PermissionCheck === true)
							{
							
								$this->statusMessage = "Login OK";
								if(empty($_SESSION["xe_userIsAdmin"]))
									$_SESSION["xe_userIsAdmin"] = false;
								$_SESSION["xe_userIsAuth"] = true;
								$_SESSION["xe_userID"] = $dbID;
								
								// Update last login time and user IP.
								$lastlogin = date("Y-m-d H:i:s");
								$lastip = $_SERVER["REMOTE_ADDR"];
								
								$this->database->query("UPDATE XE_PPL SET PPLLastLogin = '$lastlogin', PPLLastIP = '$lastip' WHERE PPLID = '$dbID'") or die($this->database->error);
								
							}
							else
							{
								if (!isset($this->statusMessage))
									$this->statusMessage = "You do not have enough permissions for this area";					
							}
						}
						else
						{
							if (!isset($this->statusMessage))
								$this->statusMessage = "This user is banned. Please contact staff for further information.";						
						}
					
					}
				}
				else
				{
					
					// It'd be good if we actually get to know if the password is incorrect instead of
					// "Internal login failure", which could mean anything in English.
					if($dbPass != $postPass)
						$this->statusMessage = "Incorrect password";
					else
						$this->statusMessage = "Internal login failure, please contact administrator";
					
					//"dbAlias = $dbAlias, postUser = $postUser, dbPass = ".substr($dbPass,0,8).", postPass = ".substr($postPass,0,8);				
				}			
			}			
			else
			{			
				// Username error
				$this->statusMessage = "Incorrect Username";			
			}		
		}		
		else
		{		
			// No post
			$this->statusMessage = "One or more required fields are missing";				
		}

		$this->redirectLocation = "/login?error=".$this->statusMessage;
		
		// if login was successful, continue
		if($PermissionCheck === true)
		{
			$this->redirectLocation = "/";
		}
		  
    }
    public function getVars()
    {
		return array(
			"redirectPage" => $this->redirectLocation,
			"pageBody" => $this->statusMessage,
			//"pageTitle" => "XiinEngine",
			//"pageMeta" => "",
		);
	}
}

?>