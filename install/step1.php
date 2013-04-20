<?php
/**
 * XiinEngine
 *
   * * XiinEngine is supplied under the MIT license. Please read license.md  in the root directory
 *
 * @package XiinEngine Legacy
 * @author Philip Whitehall <philip.whitehall@xiinet.com> 
 * @author Ian Karlsson <ian.karlsson@xiinet.com>
 * @copyright Copyright 2006-2013 Xiin Networks <http://xiinet.com/>
 * @link http://xiinengine.com/
 * @since v1.2
 * 
 * STEP 1 - XiinEngine Website Installer ("Configurationator")
 * PLEASE DELETE THIS ENTIRE DIRECTORY AFTER SETUP
 */
?>
<div class="install_step">Your Site Details</div>
<div class="install_step_instruction">
    Fill out this form, and you should be done!
</div>
<form action="index.php" method="post">
    <table class="install_table">
        <tr valign="middle">
            <td width="300" align="right">
                <label for="XE_SITE_NAME">Your site name:</label>
            </td>
            <td align="left">
                <input type="text" name="XE_SITE_NAME" id="XE_SITE_NAME" size="60">
            </td>
        </tr>
        <tr valign="middle">
            <td width="300" align="right">
                <label for="XE_SITE_DESCRIPTION">Your site description:</label>
            </td>
            <td align="left">
                <input type="text" name="XE_SITE_DESCRIPTION" id="XE_SITE_DESCRIPTION" size="60">
            </td>
        </tr>
        <tr valign="middle">
            <td width="300" align="right">
                <label for="XE_THEME_SELECT">Select Theme:</label>
            </td>
            <td align="left">
                <input type="text" name="XE_THEME_SELECT" id="XE_THEME_SELECT" size="60" value="default">
            </td>
        </tr>
        <tr valign="middle">
            <td width="300" align="right">
                <label for="XE_ROOT_PASSWORD">New root password:</label>
            </td>
            <td align="left">
                <input type="password" name="XE_ROOT_PASSWORD" id="XE_ROOT_PASSWORD" size="60">
            </td>
        </tr>
        <tr valign="middle">
            <td width="300" align="right">
                <label for="XE_ROOT_PASSWORD_CONFIRM">Confirm root password:</label>
            </td>
            <td align="left">
                <input type="password" name="XE_ROOT_PASSWORD_CONFIRM" id="XE_ROOT_PASSWORD_CONFIRM" size="60">
            </td>
        </tr>
        <tr valign="middle">
            <td width="300" align="right">
                <label for="XE_DB_HOST">Database URL:</label>
            </td>
            <td align="left">
                <input type="text" name="XE_DB_HOST" id="XE_DB_HOST" size="60" value="localhost">
            </td>
        </tr>
        <tr valign="middle">
            <td width="300" align="right">
                <label for="XE_DB_USER">Database Username:</label>
            </td>
            <td align="left">
                <input type="text" name="XE_DB_USER" id="XE_DB_USER" size="60" value="root">
            </td>
        </tr>
        <tr valign="middle">
            <td width="300" align="right">
                <label for="XE_DB_PASS">Database Password:</label>
            </td>
            <td align="left">
                <input type="password" name="XE_DB_PASS" id="XE_DB_PASS" size="60">
            </td>
        </tr>
        <tr valign="middle">
            <td width="300" align="right">
                <label for="XE_DB_NAME">Database Table:</label>
            </td>
            <td align="left">
                <input type="text" name="XE_DB_NAME" id="XE_DB_NAME" size="60" value="xe1">
            </td>
        </tr>
        <tr valign="top">
            <td width="300" align="right">
                <label for="XE_PAGE_ABOUT">Auto-create pages:</label>
            </td>
            <td align="left">
                <input type="checkbox" checked="checked" name="XE_PAGE_ABOUT" id="XE_PAGE_ABOUT" value="about">About<br />
                <input type="checkbox" checked="checked" name="XE_PAGE_LEGAL" id="XE_PAGE_ABOUT" value="legal">Legal
            </td>
        </tr>
    </table>
    <div align="center" class="login_button_container">
        <input class="install_continue" type="submit" name="action" value="Install"/>
    </div>
</form>

