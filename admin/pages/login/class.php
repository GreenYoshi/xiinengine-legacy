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
class page_login extends XePage {

    private $bodyData;
    private $titleData;
    private $metaData;
    private $pageScripts;

    public function runPage() {
        ob_start();
        include "page.php";
        $this->bodyData = ob_get_contents();
        ob_end_clean();
    }

    public function getBody() {
        if (isset($this->bodyData))
            return $this->bodyData;
        else
            throw new Exception("There's nothing to display on this page!");
    }

    public function getTitle() {
        if (isset($this->titleData))
            return $this->titleData;
        else
            return "";  // We accept empty titles
    }

    public function getMeta() {
        if (isset($this->titleData))
            return $this->metaData;
        else
            return "";
    }

    public function getScripts() {
        if (isset($this->pageScripts))
            return $this->pageScripts;
        else
            return "";
    }

    public function getVars() {
        return array(
            "pageBody" => $this->getBody(),
            "pageTitle" => $this->getTitle(),
            "pageMeta" => $this->getMeta(),
            "pageScripts" => $this->getScripts()
        );
    }

}

?>