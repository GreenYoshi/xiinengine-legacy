<!DOCTYPE html>
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
 * XiinEngine Website Installer ("Configurationator")
 * PLEASE DELETE THIS ENTIRE DIRECTORY AFTER SETUP
 */
// Test for config files
$publicConfig = '../config/xeconfig.php';
$adminConfig = '../config/admin/xeconfig.php';
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>XiinEngine Configurationator</title>
        <link rel="shortcut icon" href="../favicon.ico" />
        <link href="theme.css" rel="stylesheet"/>
        <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js' type='text/javascript'></script>
    </head>
    <body class="xepublic">
        <div class="install_logo"><img src="../imgbin/logo2012-w.png" /></div>
        <div class="install_title">XiinEngine 1 Installer</div>
        <div class="install_page_content_outer">
            <div class="install_page_content_inner">
                <div class="install_step_content">
                    <?php if (!file_exists($publicConfig) && !file_exists($adminConfig)) : ?>
                        <div class="install_delete">Please delete this install folder when completed</div>
                        <?php if (!array_key_exists('action',$_POST)) : ?>
                            <?php include "step1.php"; ?>
                        <?php elseif($_POST['action'] == 'Install') : ?>
                            <?php include "step2.php"; ?>
                        <?php endif; ?>
                    <?php else : ?>
                        Installer disabled because a configuration already exists in your setup
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="install_footer">XEInstaller 1.0.1</div>
    </body>
</html>