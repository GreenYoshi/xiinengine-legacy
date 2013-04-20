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
$footerQuery = "SELECT PageTitle, PagePretty "
        . "FROM XE_Pages "
        . "WHERE PageFooterNav = 1 "
        . "AND PagePublished = 1";
$footerItems = $this->database->query($footerQuery) or die($this->database->error);
?><div class="footer_line"></div>
<div class="footer_nav">
    <?php
    $firstItem = true;
    while ($item = $footerItems->fetch_assoc()) {
        if (!$firstItem)
            echo ' | ';

        echo '<a href="' . sysBaseURL . '/' . $item['PagePretty'] . '" target="_self">' . $item['PageTitle'] . '</a>';
        $firstItem = false;
    }
    ?>

</div>
<div class="footer_copyright">
    Powered by <a href="http://xiinengine.com/" target="_blank">XiinEngine</a> <?=sysMajorVersion.'.'.sysMinorVersion?> - &copy; <?= date("Y") ?> Xiin Networks<br />
    Content &copy; <?=XE_SITE_NAME?> unless otherwise stated.
</div>
<div class="xe_clear"></div>