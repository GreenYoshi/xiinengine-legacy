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
$this->titleData = XE_SITE_NAME;
$this->pageScripts = "<script language='javascript' type='text/javascript'>"
        . "$(window).load(function() {"
        . "$('#login_container').animate({opacity: 1}, 1000);"
        . "$('#authUsername').focus();"
        . "});"
        . "</script>";
?>

<form action="<?php echo sysBaseURL; ?>/dologin" method="post">


    <div class="login_image"><img src="<?php echo sysBaseURL; ?>/imgbin/logologin.png" /></div>
    <div id="login_container">
        <div class="login_labels">
            <?php
            if (sysDebugMode || sysMaintenanceMode) {
                if (sysMaintenanceMode)
                    $outString = "MAINTENANCE MODE";

                if (sysDebugMode) {
                    if (sysMaintenanceMode)
                        $outString .= "<br />DEBUG MODE";
                    else
                        $outString = "DEBUG MODE";
                }
                echo ('<div class="login_debug">' . $outString . '</div>');
            }
            ?>
            <div class="login_message">Please login to continue</div>
            <?php
            if (isset($_GET['error']))
                echo '<div class="login_error">' . $_GET['error'] . '</div>';
            ?>
        </div>
        <div align="center" class="login_form">
            <table border="0" width="100%" align="left">
                <tr valign="middle">
                    <td width="120" align="right">
                        <label for="authUsername">Username:</label>
                    </td>
                    <td align="left">
                        <input type="text" name="authUsername" id="authUsername" size="21">
                    </td>
                </tr>
                <tr valign="middle">
                    <td width="120" align="right">
                        <label for="authPassword">Password:</label>
                    </td>
                    <td align="left">
                        <input type="password" name="authPassword" id="authPassword" size="21">
                    </td>
                </tr>
            </table>

        </div>
        <div align="center" class="login_button_container">
            <input class="login_button" type="submit" name="action" value="Login"/>
        </div>
    </div>
</form>
<div class="login_copyright">XiinEngine <?=sysMajorVersion?>.<?=sysMinorVersion?> &copy; Xiin Networks <?=date("Y")?></div>