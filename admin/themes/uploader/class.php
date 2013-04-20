<?
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
class theme_uploader extends XeTheme
{
    private $pageData;
    private $titleData;
    public function runTheme($pageArray)
    {
        ob_start();        
        include "template.php";       
        $this->bodyData = ob_get_contents();
        ob_end_clean();
		return $this->bodyData;    
    }
}


?>