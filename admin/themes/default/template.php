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
?><!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?=$pageArray["pageTitle"]." | ".XE_SITE_NAME?> </title>
        <link rel="shortcut icon" href="<?=sysBaseURL?>/favicon.ico" />
        <link href="<?=sysBaseURL?>/themes/default/theme.css" rel="stylesheet"/>
        <link href="<?=sysBaseURL?>/libraries/select2/select2.css" rel="stylesheet"/>
        <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js' type='text/javascript'></script>
        <script src="<?=sysBaseURL?>/libraries/phpTimeEmulator.js" language="javascript" type="text/javascript"></script>
        <script src="<?=sysBaseURL?>/libraries/select2/select2.min.js" language="javascript" type="text/javascript"></script>
        <script language="javascript" type="text/javascript">
			
			
            $(window).load(function() {	
                var w = $(window).width();
                var maincontW = w - 290;
                $("#main_container").css("width",maincontW);
            });
			
            $(window).resize(function() {
                var w = $(window).width();
                var maincontW = w - 290;
                $("#main_container").css("width",maincontW);
            });

			
        </script>
        <?=$pageArray["pageScripts"]?>
    </head>
    <body class="xeacp">
        <div id="main_container">
            <div class="titlebar_outer">
                <div id="title">
                    <?=$pageArray["pageTitle"]?>
                </div>
                <div id="sys_status">
                    <?php
                    if (sysDebugMode || sysMaintenanceMode) {
                        if (sysDebugMode)
                            $outString = "System Status: <span id='sys_debug'>Debug</span>";

                        if (sysMaintenanceMode) {
                            if (sysDebugMode)
                                $outString .= " & <span id='sys_maintenance'>Maintenance</span>";
                            else
                                $outString = "System Status: <span id='sys_maintenance'>Maintenance</span>";
                        }
                    }
                    else {
                        $outString = "System Status: <span id='sys_normal'>Normal</span>";
                    }
                    echo ('<div class="login_debug">' . $outString . '</div>');
                    ?>
                </div>
            </div>            
            <div id="body_outer">
                <div id="body">
                    <?php echo $pageArray["pageBody"] ?>
                </div>
            </div>
        </div>
        <div class="login_bg_tape"></div>
        <div class="nav_panel_container">
            <div class="nav_logo_outer"><div class="nav_logo_inner"><a href="<?=sysBaseURL?>" target="_self"><img src="<?=sysBaseURL?>/imgbin/logonav.png" border="0"></a></div></div>
            <div class="nav_homes_outer"><div class="nav_homes_inner"><a href="/" target="_blank"><img src="<?=sysBaseURL?>/imgbin/nav_hpublic.png" border="0"></a>&nbsp;<a href="<?=sysBaseURL?>" target="_self"><img src="<?=sysBaseURL?>/imgbin/nav_hadmin.png" border="0"></a>&nbsp;<a href="<?=sysBaseURL?>/tools" target="_self"><img src="<?=sysBaseURL?>/imgbin/nav_tools.png" border="0"></a>&nbsp;<a href="<?=sysBaseURL?>/help" target="_self"><img src="<?=sysBaseURL?>/imgbin/nav_help.png" border="0"></a></div></div>
            <div class="nav_administrations_outer">
                <?php
                include sysModulePath . "admin_nav_panel.php";
                generateNav();
                ?>
            </div>
        </div>

    </body>
</html>