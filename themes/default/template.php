<?
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
?><!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?=$pageArray["pageTitle"]." | ".XE_SITE_NAME?> </title>
        <?
			if(isset($pageArray["pageMeta"]))
				echo("<meta name=\"description\" content=\"".$pageArray["pageMeta"]."\" />\n");
			else
				echo("<meta name=\"description\" content=\"".XE_SITE_DESCRIPTION."\" />\n");
        ?>
        <meta name="keywords" content="<?=XE_SITE_TAGS?>" />
        <link rel="shortcut icon" href="<?=sysBaseURL?>/favicon.ico" />
        <link href='http://fonts.googleapis.com/css?family=Press+Start+2P' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Iceland' rel='stylesheet' type='text/css'>
        <link href="<?=sysBaseURL?>/themes/default/theme.css" rel="stylesheet"/>
        <link href="<?=sysBaseURL?>/libraries/select2/select2.css" rel="stylesheet"/>
        <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js' type='text/javascript'></script>
        <script src="<?=sysBaseURL?>/libraries/phpTimeEmulator.js" language="javascript" type="text/javascript"></script>
                <!-- <script src="<?=sysBaseURL?>/libraries/select2/select2.min.js" language="javascript" type="text/javascript"></script> -->
        <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
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
        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-178466-9']);
            _gaq.push(['_trackPageview']);
		
            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
		
        </script>
    </head>
    <body class="xepublic">
		<?=XiinEngine::$announcement?>
        <div class="public_header">
            <?php include "p_header.php"; ?>
        </div>
        <div class="public_body">
            <?=$pageArray["pageBody"]?>
        </div>
        <div class="public_footer">
            <?php include "p_footer.php"; ?>
        </div>
    </body>
</html>