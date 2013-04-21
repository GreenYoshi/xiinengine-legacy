<?php

function generateFile($fileUrl,$fileContent) {
    $fh = fopen($fileUrl, 'w') or die('Cannot open '.$fileUrl);
    fwrite($fh, $fileContent);
    fclose($fh);
}

function generateAutoPage($db,$pageName) {
    switch($pageName) {
        case 'about':
            $sqlQuery = 'INSERT INTO `XE_Pages`(`PageTitle`, `PagePretty`, `PageDate`, `PageContent`, `PageHeaderNav`, `PageFooterNav`, `PagePublished`, `PageTags`) '
            .'VALUES ("About","about","'.date('Y-m-d H:i:s').'","XiinEngine Copyright Xiin Networks '.date('Y').'",0,1,1,"about")';
            break;
        case 'legal':
$copyright = $db->real_escape_string('
<a href="http://xiinengine.com" target="_blank">XiinEngine 1.2</a> Copyright (C) '.date('Y').' <a href="http://xiinet.com" target="_blank">Xiin Networks</a><br />
<br />
XiinEngine&rsquo;s code base is a collaboration between:<br />
<br />
<ul>
    <li>Philip Whitehall <philip.whitehall@xiinet.com></li>
    <li>Ian Karlsson <ian.karlsson@xiinet.com></li>
    <li>Luuk Lenders <luuk.lenders@xiinet.com></li>
    <li>James Mayell <james.mayell@xiinet.com></li>
</ul>
<br />
<a href="http://htmlpurifier.org/" target="_blank">HTML Purifier</a> and <a href="http://www.tinymce.com/" target="_blank">tinyMCE</a> are sub-components used in XiinEngine, and are both published under the <a href="http://www.gnu.org/licenses/lgpl-2.1.html" target="_blank">LGPL v 2.1+</a> license.<br />
<br />
<a href="http://ivaynberg.github.com/select2/" target="_blank">Select2</a> is a sub-component used in XiinEngine, published under the <a href="http://www.apache.org/licenses/LICENSE-2.0" target="_blank">Apache License v2.0</a>.<br />
<br />
XiinEngine is licensed under the <a href="http://opensource.org/licenses/MIT" target="_blank">MIT License</a>:<br />
<br />
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:<br />
<br />
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.<br />
<br />
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.<br />
');
            $sqlQuery = 'INSERT INTO `XE_Pages`(`PageTitle`, `PagePretty`, `PageDate`, `PageContent`, `PageHeaderNav`, `PageFooterNav`, `PagePublished`, `PageTags`) '
            .'VALUES ("Legal","legal","'.date('Y-m-d H:i:s').'","'.$copyright.'",0,1,1,"legal")';
            break;
        default:
            break;
    }
    return $sqlQuery;
}
?>
