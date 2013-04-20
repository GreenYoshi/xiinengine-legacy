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
class page_ppl extends XePage
{
    private $bodyData;
    private $titleData;
    private $metaData;
	private $pageScripts;
	private $redirectPage;
    
    public function runPage()
    {
        ob_start();        
        include "page.php";       
        $this->bodyData = ob_get_contents();
        ob_end_clean();    
    }
    public function getBody()
    {
        if (isset($this->bodyData))
            return $this->bodyData;
        else
            throw new Exception("There's nothing to display on this page!");
    }
    public function getTitle()
    {
        if (isset($this->titleData))
            return $this->titleData;
        else
            return "People Administration";  // We accept empty titles
    }
    public function getMeta()
    {
        if (isset($this->titleData))
            return $this->metaData;
        else
            return "";
    }
	
	public function getScripts()
    {
        if (isset($this->pageScripts))
            return $this->pageScripts;
        else
            return "";
    }
	
	public function getRedirect()
    {
        if (isset($this->redirectPage))
            return $this->redirectPage;
        else
            return "";
    }
    
    public function getVars()
    {
		return array(
			"pageBody" => $this->getBody(),
			"pageTitle" => $this->getTitle(),
			"pageMeta" => $this->getMeta(),
			"pageScripts" => $this->getScripts(),
			"redirectPage" => $this->getRedirect()
		);
	}
	
	public function generateAddForm()
	{
		// Generate the form
		// PHIL IS STILL WORKING ON THE XE_PERMISSIONS SIDE
		// ^ Will be using AJAX. I have the code for it to work, i think
		// Per-line permissions will be worked on when more permissions are in the system
		require_once (sysClassPath."XeForm.php");
		$formObject = new XeForm($this->database,'ppl/add','XE_PPL','');
		$formOutput = $formObject->openForm();
		$formOutput .= $formObject->row('First Name','','text','PPLFName','');
		$formOutput .= $formObject->row('Surname','','text','PPLSName','');
		$formOutput .= $formObject->row('Email','','text','PPLEmail','');
		$formOutput .= $formObject->row('Alias','','text','PPLAlias','');
		if (in_array("Administrator",XiinEngine::$user->PermArray) || in_array("ROOT",XiinEngine::$user->PermArray))
			$formOutput .= $formObject->ajaxrow('Permission Groups','Hold CTRL to select many','dropdown','XE_Permissions','PermID','PermAccessName','');
		$formOutput .= $formObject->row('Icon URL','Test Description','text','PPLIconURL',''); // UPLOADER GOES HERE!!
		$formOutput .= $formObject->row('Title','','text','PPLTitle','');
		$formOutput .= $formObject->row('Bio','','textarea','PPLBio','');
		$formOutput .= $formObject->row('URL','Personal website link','text','PPLURL','');
		$formOutput .= $formObject->row('New Password','','password','PPLNewPass','');
		$formOutput .= $formObject->row('Verify Password','','password','PPLNewPass2','');
		$formOutput .= $formObject->row('Security Question','Not decided if this is a dropdown fixed thing or anyone can type anything they want','text','PPLSecurityQuestion','');
		$formOutput .= $formObject->row('Security Answer','','text','PPLSecurityAnswer','');
		$formOutput .= $formObject->row('Ban Date','Enter any future date to disable this account until that date','date','PPLBanDate[]','');

	// Social network management  - not implemented for now!!		

		//$formOutput .= $formObject->row('Facebook Link','Public link, not for App','text','PPLFacebook','');
		//$formOutput .= $formObject->row('Twitter Link','Public link, not for App','text','PPLTwitter','');
		//$formOutput .= $formObject->row('GPlus','Public link, not for App','text','PPLGPlus','');


		//$formOutput .= $formObject->row('3DS Friend Code','','text','PPL3DSNumber','');
		//$formOutput .= $formObject->row('Wii Friend Code','','text','PPLWiiNumber','');
		//$formOutput .= $formObject->row('WiiU Friend Code','','text','PPLWiiUNumber','');
		$formOutput .= $formObject->closeTable();
		$formOutput .= $formObject->buttons();
		$formOutput .= $formObject->closeForm();
		
		
		echo $formOutput;
	}
	
	public function generateEditForm($ppl,$pplPretty)
	{
		// Generate the form
		// PHIL IS STILL WORKING ON THE XE_PERMISSIONS SIDE
		// ^ Will be using AJAX. I have the code for it to work, i think
		// Per-line permissions will be worked on when more permissions are in the system
		$permarray = array();
		$permcounter = 0;
		$permquery = "SELECT perm.PermID AS permid FROM XE_Permissions perm "
					."LEFT JOIN XE_PPL_Permissions plink ON plink.PermID = perm.PermID "
					."LEFT JOIN XE_PPL p ON p.PPLID = plink.PPLID "
					."WHERE p.PPLPretty = '".$pplPretty."'";
		$dbresult = $this->database->query($permquery) or die ($this->database->error);
		while ($perm = $dbresult->fetch_assoc())
		{
			$permarray[$permcounter] = $perm['permid'];
			$permcounter++;
		}
		require_once (sysClassPath."XeForm.php");
		$formObject = new XeForm($this->database,'ppl/edit','XE_PPL',$pplPretty);
		$formOutput = $formObject->openForm();
		$formOutput .= $formObject->row('First Name','','text','PPLFName',stripslashes($ppl['PPLFName']));
		$formOutput .= $formObject->row('Surname','','text','PPLSName',stripslashes($ppl['PPLSName']));
		$formOutput .= $formObject->row('Email','','text','PPLEmail',stripslashes($ppl['PPLEmail']));
		$formOutput .= $formObject->row('Alias','','text','PPLAlias',stripslashes($ppl['PPLAlias']));
		if (in_array("Administrator",XiinEngine::$user->PermArray) || in_array("ROOT",XiinEngine::$user->PermArray))
			$formOutput .= $formObject->ajaxrow('Permission Groups','Hold CTRL to select many','dropdown','XE_Permissions','PermID','PermAccessName',$permarray);
		$formOutput .= $formObject->row('Icon URL','Test Description','text','PPLIconURL',stripslashes($ppl['PPLIconURL'])); // UPLOADER GOES HERE!!
		$formOutput .= $formObject->row('Title','','text','PPLTitle',stripslashes($ppl['PPLTitle']));
		$formOutput .= $formObject->row('Bio','','textarea','PPLBio',stripslashes($ppl['PPLBio']));
		$formOutput .= $formObject->row('URL','Personal website link','text','PPLURL',stripslashes($ppl['PPLURL']));
		$formOutput .= $formObject->row('Old Password','','password','PPLPass','');
		$formOutput .= $formObject->row('New Password','','password','PPLNewPass','');
		$formOutput .= $formObject->row('Verify Password','','password','PPLNewPass2','');
		$formOutput .= $formObject->row('Security Question','Not decided if this is a dropdown fixed thing or anyone can type anything they want','text','PPLSecurityQuestion',$ppl['PPLSecurityQuestion']);
		$formOutput .= $formObject->row('Security Answer','','text','PPLSecurityAnswer',stripslashes($ppl['PPLSecurityAnswer']));
		$formOutput .= $formObject->row('Account Creation Date','Can\'t modify this','readonly','',stripslashes($ppl['PPLCreationDate']));
		$formOutput .= $formObject->row('Ban Date','Enter any future date to disable this account until that date','date','PPLBanDate[]',stripslashes($ppl['PPLBanDate']));
/*
		$formOutput .= $formObject->row('Facebook Link','Public link, not for App','text','PPLFacebook',$ppl['PPLFacebook']);
		$formOutput .= $formObject->row('Twitter Link','Public link, not for App','text','PPLTwitter',$ppl['PPLTwitter']);
		$formOutput .= $formObject->row('GPlus','Public link, not for App','text','PPLGPlus',$ppl['PPLGPlus']);
		
		$formOutput .= $formObject->row('3DS Friend Code','','text','PPL3DSNumber',stripslashes($ppl['PPL3DSNumber']));
		$formOutput .= $formObject->row('Wii Friend Code','','text','PPLWiiNumber',stripslashes($ppl['PPLWiiNumber']));
		$formOutput .= $formObject->row('WiiU Friend Code','','text','PPLWiiUNumber',stripslashes($ppl['PPLWiiUNumber']));
*/
		$formOutput .= $formObject->closeTable();
		$formOutput .= $formObject->buttons();
		$formOutput .= $formObject->closeForm();
		
		
		echo $formOutput;
	}
}

?>