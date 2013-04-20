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
class page_ncategories extends XePage
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
            return "News Categories Administration";  // We accept empty titles
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
	
	function generateAddForm()
	{
		// Generate the form
		// PHIL IS STILL WORKING ON THE XE_PERMISSIONS SIDE
		// ^ Will be using AJAX. I have the code for it to work, i think
		// Per-line permissions will be worked on when more permissions are in the system
		require_once (sysClassPath."XeForm.php");
		$formObject = new XeForm($this->database,'ncategories/add','XE_NCategories','');
		$formOutput = $formObject->openForm();
		$formOutput .= $formObject->row('Category Name','','text','NCatName','');
		
		$colours = array(
			"Red (News)" =>			"#d71f27", // News
			"Purple  (Reviews)" =>	"#8560a8", // Reviews
			"Orange (Videos)" =>	"#e58450", // Videos
			"Blue (Images)" =>		"#006cff", // Images
			"Green (Games)" =>		"#acd373", // Games
			"Teal (Top 10)" =>		"#1cbbb4", // Top 10
		);
		
		$formOutput .= $formObject->row('Category Color','','dropdown','NCatColor','',$colours);
		// WiiU FIELD PURPOSELY NOT HERE YET 
		$formOutput .= $formObject->closeTable();
		$formOutput .= $formObject->buttons();
		$formOutput .= $formObject->closeForm();
		
		
		echo $formOutput;
	}
	
	function generateEditForm($perm,$permid)
	{
		// Generate the form
		// PHIL IS STILL WORKING ON THE XE_PERMISSIONS SIDE
		// ^ Will be using AJAX. I have the code for it to work, i think
		// Per-line permissions will be worked on when more permissions are in the system
		require_once (sysClassPath."XeForm.php");
		$formObject = new XeForm($this->database,'ncategories/edit','XE_NCategories',$permid);
		$formOutput = $formObject->openForm();
		$formOutput .= $formObject->row('Category Name','','text','NCatName',$perm["NCatName"]);
		
		$colours = array(
			"Red (News)" =>			"#d71f27", // News
			"Purple  (Reviews)" =>	"#8560a8", // Reviews
			"Orange (Videos)" =>	"#e58450", // Videos
			"Blue (Images)" =>		"#006cff", // Images
			"Green (Games)" =>		"#acd373", // Games
			"Teal (Top 10)" =>		"#1cbbb4", // Top 10
		);
		
		$formOutput .= $formObject->row('Category Color','','dropdown','NCatColor',$perm["NCatColor"],$colours);
		// WiiU FIELD PURPOSELY NOT HERE YET 
		$formOutput .= $formObject->closeTable();
		$formOutput .= $formObject->buttons();
		$formOutput .= $formObject->closeForm();
		
		
		echo $formOutput;
	}
}

?>