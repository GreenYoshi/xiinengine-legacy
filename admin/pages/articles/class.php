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
class page_articles extends XePage {

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
            return "Articles Administration";  // We accept empty titles
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
        $formObject = new XeForm($this->database, 'articles/add', 'XE_News', '');
        $formOutput = $formObject->openForm();
        $formOutput .= $formObject->row('Title', 'Up to 50 characters', 'text', 'NewsTitle', '');
        $formOutput .= $formObject->row('Article', '', 'richtext', 'NewsContent', '');
        $formOutput .= $formObject->row('Source URL', 'Please enter the full URL and nothing else', 'text', 'NewsSource', '');
        $formOutput .= $formObject->row('News Banner', 'Leave blank for the moment. Will be used as the highlight image of the article', 'text', 'NewsBanner', ''); // TODO: Integrate with image upload tool
        $formOutput .= $formObject->row('Tags', 'Separate tags with commas, &amp; all spaces are replaced with hyphens.<br />Example: "nintendo,super nintendo, super mario bros,mario is missing " would be stored as "nintendo,super-nintendo,-super-mario-bros,mario-is-missing-"', 'text', 'NewsTags', '');
        $formOutput .= $formObject->ajaxrow('Categories', 'Hold CTRL to select many. Choosing "Please Select" will be rendered as a null value', 'dropdown', 'XE_NCategories', 'NCatID', 'NCatName', '');
        /*
          $formOutput .= $formObject->ajaxrow('Authors','Hold CTRL to select many. Choosing "Please Select" will be rendered as a null value','dropdown','XE_PPL','PPLID','PPLAlias',array(XiinEngine::$user->ID)); */
        $formOutput .= $formObject->row('Authors', '', 'select2_array', 'PPLID_list', array(XiinEngine::$user->ID), 'pplselect'
        );
        $formOutput .= $formObject->row('News Date', '', 'text', 'NewsDate', $defaultDate);
        $formOutput .= $formObject->row('Highlight', 'Click true if you want this article to appear in the large, top featured news slider at the top of the public website', 'bool', 'NewsHighlight', '');
        $formOutput .= $formObject->row('Publish Article', 'Click true to publish immediately', 'bool', 'NewsPublished', '');
        $formOutput .= $formObject->closeTable();
        $formOutput .= $formObject->buttons();
        $formOutput .= $formObject->closeForm();


        echo $formOutput;
    }

    public function generateEditForm($news, $newsPretty) {

        $pplarray = array();
        $pplcounter = 0;
        $pplquery = "SELECT ppl.PPLID AS pplid FROM XE_PPL ppl "
                . "LEFT JOIN XE_News_Author nlink ON nlink.PPLID = ppl.PPLID "
                . "LEFT JOIN XE_News n ON n.NewsID = nlink.NewsID "
                . "WHERE n.NewsPretty = '" . $newsPretty . "'";
        $dbresult = $this->database->query($pplquery) or die($this->database->error);
        while ($author = $dbresult->fetch_assoc()) {
            $pplarray[$pplcounter] = stripslashes($author['pplid']);
            $pplcounter++;
        }

        $catarray = array();
        $pplcounter = 0;
        $pplquery = "SELECT ncat.NCatID AS ncatid FROM XE_NCategories ncat "
                . "LEFT JOIN XE_News_Categories nlink ON nlink.NCatID = ncat.NCatID "
                . "LEFT JOIN XE_News n ON n.NewsID = nlink.NewsID "
                . "WHERE n.NewsPretty = '" . $newsPretty . "'";
        $dbresult = $this->database->query($pplquery) or die($this->database->error);
        while ($author = $dbresult->fetch_assoc()) {
            $catarray[$pplcounter] = stripslashes($author['ncatid']);
            $pplcounter++;
        }

        //print_r($pplarray);
        require_once(sysClassPath . "XeForm.php");
        $formObject = new XeForm($this->database, 'articles/edit', 'XE_News', $newsPretty);
        $formOutput = $formObject->openForm();
        $formOutput .= $formObject->row('Title', 'Up to 50 characters', 'text', 'NewsTitle', stripslashes($news['NewsTitle']));
        $formOutput .= $formObject->row('Article', '', 'richtext', 'NewsContent', stripslashes($news['NewsContent']));
        $formOutput .= $formObject->row('Source URL', 'Please enter the full URL and nothing else', 'text', 'NewsSource', stripslashes($news['NewsSource']));
        $formOutput .= $formObject->row('News Banner', 'Leave blank for the moment. Will be used as the highlight image of the article', 'text', 'NewsBanner', stripslashes($news['NewsBanner'])); // TODO: Integrate with image upload tool
        $formOutput .= $formObject->row('Tags', 'Separate tags with commas, &amp; all spaces are replaced with hyphens.<br />Example: "nintendo,super nintendo, super mario bros,mario is missing " would be stored as "nintendo,super-nintendo,-super-mario-bros,mario-is-missing-"', 'text', 'NewsTags', stripslashes($news["NewsTags"]));
        $formOutput .= $formObject->ajaxrow('Categories', 'Hold CTRL to select many. Choosing "Please Select" will be rendered as a null value', 'dropdown', 'XE_NCategories', 'NCatID', 'NCatName', $catarray);
        //$formOutput .= $formObject->ajaxrow('Authors','Hold CTRL to select many. Choosing "Please Select" will be rendered as a null value','dropdown','XE_PPL','PPLID','PPLAlias',$pplarray,'pplselect');
        $formOutput .= $formObject->row('Authors', '', 'select2_array', 'PPLID_list', $pplarray, 'pplselect'
        );
        $formOutput .= $formObject->row('News Date', '', 'text', 'NewsDate', stripslashes($news['NewsDate']));
        $formOutput .= $formObject->row('Highlight', 'Click true if you want this article to appear in the large, top featured news slider at the top of the public website', 'bool', 'NewsHighlight', $news['NewsHighlight']);
        $formOutput .= $formObject->row('Publish Article', 'Click true to publish immediately', 'bool', 'NewsPublished', $news['NewsPublished']);
        $formOutput .= $formObject->closeTable();
        $formOutput .= $formObject->buttons();
        $formOutput .= $formObject->closeForm();
        echo $formOutput;
    }

}

?>