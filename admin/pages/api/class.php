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
class page_api extends XePage
{
    private $bodyData;
    private $titleData;
    private $metaData;
	private $pageScripts;
	private $contentType;
    
    public function runPage()
    {
        ob_start();
		//===================================================================================================== 
		if(!empty(XiinEngine::$input[1]) && XiinEngine::$input[1] != "page" && !is_numeric(XiinEngine::$input[1]))
		{
			$pageSelect = XiinEngine::$input[1];
		}
		else
		{
			$pageSelect = "page"; //default page
		}
		//echo "the loading page is ".$pageSelect;
		
		$loadFile = sysPagePath.XiinEngine::$input[0]."/".$pageSelect.".php";
		
		if(is_readable($loadFile))
		{
			include $loadFile;
		}
		else
		{
			echo "Sorry, this page does not exist.";
			echo "<br />Attempted to load: <b>$loadFile</b>";
		}
		//==================================================================================================
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
            return "api";  // We accept empty titles
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
    
	// rewrite just for the api content type... hehehe
    public function getVars()
    {
		$returnarray = array(
			"pageBody" => $this->getBody(),
			"pageTitle" => $this->getTitle(),
			"pageMeta" => $this->getMeta(),
			"pageScripts" => $this->getScripts()
		);
		
        if (!empty($this->contentType))
            $returnarray["apiContentType"] = $this->contentType;

		return $returnarray;
	}
}

?>