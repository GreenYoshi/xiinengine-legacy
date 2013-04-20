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
 * XE PPL class
 *
 * More class documentation here
 */
class XePPL
{
	public $ID;
	public $FName;
	public $SName;
	public $Email;
	public $Alias;
	public $Pretty;
	public $IconURL;
	public $Title;
	public $Bio;
	public $URL;
	public $Pass;
	public $RememberPassKey;
	public $LastLogin;
	public $LastIP;
	public $SecurityQuestion;
	public $SecurityAnswer;
	public $CreationDate;
	public $BanDate;
/*	public $PubFacebook;
	public $Key1Facebook;
	public $PubTwitter;
	public $Key1Twitter;
	public $PubGPlus;
	public $Key1GPlus;
	public $PubDisqus;
	public $DSNumber;
	public $N3DSNumber;
	public $WiiNumber;
	public $WiiUNumber; */
	public $PermArray;
	
	public $AssociatedPermissions;	// array

	public function get($database, $id)
	{
		$id = $database->real_escape_string($id);
		$result = $database->query("SELECT * FROM XE_PPL WHERE `PPLID` = '$id'") or die("Get() Error: ".$database->error);
		$row = $result->fetch_assoc();
		$this->ID = $row["PPLID"];
		$this->FName = $row["PPLFName"];
		$this->SName = $row["PPLSName"];
		$this->Email = $row["PPLEmail"];
		$this->Alias = $row["PPLAlias"];
		$this->Pretty = $row["PPLPretty"];
		$this->IconURL = $row["PPLIconURL"];
		$this->Title = $row["PPLTitle"];
		$this->Bio = $row["PPLBio"];
		$this->URL = $row["PPLURL"];
		$this->Pass = $row["PPLPass"];
		$this->RememberPassKey = $row["PPLRememberPassKey"];
		$this->LastLogin = $row["PPLLastLogin"];
		$this->LastIP = $row["PPLLastIP"];
		$this->SecurityQuestion = $row["PPLSecurityQuestion"];
		$this->SecurityAnswer = $row["PPLSecurityAnswer"];
		$this->CreationDate = $row["PPLCreationDate"];
		$this->BanDate = $row["PPLBanDate"];
/*		$this->PubFacebook = $row["PPLPubFacebook"];
		$this->Key1Facebook = $row["PPLKey1Facebook"];
		$this->PubTwitter = $row["PPLPubTwitter"];
		$this->Key1Twitter = $row["PPLKey1Twitter"];
		$this->PubGPlus = $row["PPLPubGPlus"];
		$this->Key1GPlus = $row["PPLKey1GPlus"];
		$this->PubDisqus = $row["PPLPubDisqus"];
		$this->DSNumber = $row["PPLDSNumber"];
		$this->N3DSNumber = $row["PPL3DSNumber"];
		$this->WiiNumber = $row["PPLWiiNumber"];
		$this->WiiUNumber = $row["PPLWiiUNumber"];*/
		$result->free();
		
		$result = $database->query("SELECT p.PermAccessName as permname FROM XE_Permissions p LEFT JOIN XE_PPL_Permissions plink ON plink.PermID = p.PermID WHERE plink.PPLID = '$id'") or die("Get() Error: ".$database->error);
		$permcount = 0;
		while ($row = $result->fetch_assoc())
		{
			$this->PermArray[$permcount] = $row["permname"];
			$permcount++;
		}
	}
}

?>