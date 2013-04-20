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
class page_staticpages extends XePage {

    private $bodyData;
    private $titleData;
    private $metaData;
    private $pageScripts;
    private $redirectPage;

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
            return "Pages Administration";  // We accept empty titles
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

    public function getRedirect() {
        if (isset($this->redirectPage))
            return $this->redirectPage;
        else
            return "";
    }

    public function getVars() {
        return array(
            "pageBody" => $this->getBody(),
            "pageTitle" => $this->getTitle(),
            "pageMeta" => $this->getMeta(),
            "pageScripts" => $this->getScripts(),
            "redirectPage" => $this->getRedirect()
        );
    }

    public function generateAddForm() {

        $defaultDate = date("Y-m-d H:i:s");

        require_once(sysClasSPath . "XeForm.php");
        $formObject = new XeForm($this->database, 'staticpages/add', 'XE_Pages', '');
        $formOutput = $formObject->openForm();
        $formOutput .= $formObject->row('Title', 'Up to 50 characters', 'text', 'PageTitle', '');
        $formOutput .= $formObject->row('Page', '', 'richtext', 'PageContent', '');
        $formOutput .= $formObject->row('Page Banner', 'Not used', 'text', 'PageBanner', ''); // TODO: Integrate with image upload tool
        $formOutput .= $formObject->row('Tags', 'Separate tags with commas, &amp; all spaces are replaced with hyphens.<br />Example: "nintendo,super nintendo, super mario bros,mario is missing " would be stored as "nintendo,super-nintendo,-super-mario-bros,mario-is-missing-"', 'text', 'PageTags', '');
        $formOutput .= $formObject->row('Page Date', '', 'text', 'PageDate', $defaultDate);
        $formOutput .= $formObject->row('Header Navigation', 'Click true if you want this page to appear in the site\'s header navigation bar', 'bool', 'PageHeaderNav', '');
        $formOutput .= $formObject->row('Footer Navigation', 'Click true if you want this page to appear in the site\'s footer navigation bar', 'bool', 'PageFooterNav', '');
        $formOutput .= $formObject->row('Publish Page', 'Click true to enable this page on the public site', 'bool', 'PagePublished', '');
        $formOutput .= $formObject->closeTable();
        $formOutput .= $formObject->buttons();
        $formOutput .= $formObject->closeForm();


        echo $formOutput;
    }

    public function generateEditForm($news, $newsPretty) {

        //print_r($pplarray);
        require_once(sysClassPath . "XeForm.php");
        $formObject = new XeForm($this->database, 'staticpages/edit', 'XE_Pages', $newsPretty);
        $formOutput = $formObject->openForm();
        $formOutput .= $formObject->row('Title', 'Up to 50 characters', 'text', 'PageTitle', stripslashes($news['PageTitle']));
        $formOutput .= $formObject->row('Page', '', 'richtext', 'PageContent', stripslashes($news['PageContent']));
        $formOutput .= $formObject->row('Page Banner', 'Not used', 'text', 'PageBanner', stripslashes($news['PageBanner'])); // TODO: Integrate with image upload tool
        $formOutput .= $formObject->row('Tags', 'Separate tags with commas, &amp; all spaces are replaced with hyphens.<br />Example: "nintendo,super nintendo, super mario bros,mario is missing " would be stored as "nintendo,super-nintendo,-super-mario-bros,mario-is-missing-"', 'text', 'PageTags', stripslashes($news["PageTags"]));
        $formOutput .= $formObject->row('Page Date', '', 'text', 'PageDate', stripslashes($news['PageDate']));
        $formOutput .= $formObject->row('Header Navigation', 'Click true if you want this page to appear in the site\'s header navigation bar', 'bool', 'PageHeaderNav', $news['PageHeaderNav']);
        $formOutput .= $formObject->row('Footer Navigation', 'Click true if you want this page to appear in the site\'s footer navigation bar', 'bool', 'PageFooterNav', $news['PageFooterNav']);
        $formOutput .= $formObject->row('Publish Article', 'Click true to enable this page on the public site', 'bool', 'PagePublished', $news['PagePublished']);
        $formOutput .= $formObject->closeTable();
        $formOutput .= $formObject->buttons();
        $formOutput .= $formObject->closeForm();
        echo $formOutput;
    }

}

?>