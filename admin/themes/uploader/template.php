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
        <style>
			html { height: 100%; }
			body {
				
				background: url(<?=sysBaseURL?>/imgbin/bg.png);
				background-position: bottom;
				background-repeat: no-repeat;
				background-size: fill;
				background-color: #9d0000;
				font-family: Verdana, Geneva, sans-serif;
				color:#ffffff;
				border: 0px;
				padding: 0px;
				margin: 0px;
				width: 100%;
				height: 100%;
			}
			
			 a:link { color: #d71f27; text-decoration: none; }
			 a:visited { color: #d71f27; text-decoration: none; }
			 a:active { color: #d71f27; text-decoration: none; }
			 a:hover { color: #ffffff; text-decoration: none; }
			
			/* SYS MODES */
			 
			#sys_status { 
				font-size: 14px;
				font-weight: bold;
				padding-left:15px;
				padding-bottom: 10px;
			}
			
			#sys_normal { color: #1cbbb4; }
			#sys_debug { color: #d1b600; }
			#sys_maintenance { color: #e50000; }
			
			#main_container {
				position: absolute;
				display: block;
				left: 0px;
				top: 0px;
				margin-bottom: 30px;
				width: 100%;
			}
			
			.titlebar_outer {
				width: 100%;
				background-color: #202020;
				height: 90px;
				margin-bottom: 15px;
			}
			
			#title {
				padding-left:15px;
				padding-top: 10px;
				font-size: 32px;
				color: #ffffff;
			}
			
			#body_outer {
				background-color: #202020;
				position:relative;
				margin-bottom: 30px;
			}
			
			#body {
				padding: 10px;
			}
			
			.nav_panel_container {
				position: absolute;
				right: 0px;
				top: 20px;
			}
			
			.nav_logo_outer {
				background-color: #202020;
				width: 260px;
				height: 90px;
				margin-bottom: 15px;
			}
			
			.nav_logo_inner {
				padding-top: 4px;
				vertical-align: middle;
				text-align: center;
			}
			
			.nav_homes_outer {
				background-color: #202020;
				width: 260px;
				height: 50px;
				margin-bottom: 15px;
			}
			
			.nav_homes_inner {
				vertical-align: middle;
				text-align: center;
				font-weight: bold;
			}
			
			.nav_homes_inner a:link { color: #ffffff; text-decoration: none; }
			.nav_homes_inner a:visited { color: #ffffff; text-decoration: none; }
			.nav_homes_inner a:active { color: #ffffff; text-decoration: none; }
			.nav_homes_inner a:hover { color: #d71f27; text-decoration: none; }
			
			.nav_administrations_section_outer {
				position: relative;
				width: 100%;
				margin-bottom: 4px;
				background-color: #202020;
				padding: 0px;
			}
			
			.nav_administrations_section_inner {
				position: relative;
				padding: 5px 5px 5px 20px;
				font-size: 18px;
				font-weight: bold;
			}
			
			.nav_entries { margin: 0px 0px 0px 8px; border: 0; padding: 0; font-size: 14px; list-style: none; }
			
			/* Defaults */
			.nav_administrations_section_inner a:link { color: #ffffff; text-decoration: none; }
			.nav_administrations_section_inner a:visited { color: #ffffff; text-decoration: none; }
			.nav_administrations_section_inner a:active { color: #ffffff; text-decoration: none; }
			.nav_administrations_section_inner a:hover { color: #d71f27; text-decoration: none; }
			
			.debug_done { font-style: italic; }
			
			.nav_tab_color {
				position: absolute;
				left: 0px;
				width: 10px;
				height: 100%;
				background-color: #ffffff;
			}
			
			#nav_tab_red { background-color: #d71f27; }
			#nav_title_red { color: #d71f27; }
			#nav_title_red a:link { color: #d71f27; text-decoration: none; }
			#nav_title_red a:visited { color: #d71f27; text-decoration: none; }
			#nav_title_red a:active { color: #d71f27; text-decoration: none; }
			
			#nav_tab_orange { background-color: #e58450; }
			#nav_title_orange { color: #e58450; }
			#nav_title_orange a:link { color: #e58450; text-decoration: none; }
			#nav_title_orange a:visited { color: #e58450; text-decoration: none; }
			#nav_title_orange a:active { color: #e58450; text-decoration: none; }
			
			#nav_tab_green { background-color: #acd373; }
			#nav_title_green { color: #acd373; }
			#nav_title_green a:link { color: #acd373; text-decoration: none; }
			#nav_title_green a:visited { color: #acd373; text-decoration: none; }
			#nav_title_green a:active { color: #acd373; text-decoration: none; }
			
			#nav_tab_teal { background-color: #1cbbb4; }
			#nav_title_teal { color: #1cbbb4; }
			#nav_title_teal a:link { color: #1cbbb4; text-decoration: none; }
			#nav_title_teal a:visited { color: #1cbbb4; text-decoration: none; }
			#nav_title_teal a:active { color: #1cbbb4; text-decoration: none; }
			
			.login_bg_tape {
				position: fixed;
				right: 50px;
				bottom: 50px;
				background: url(<?=sysBaseURL?>/imgbin/logobgtape.png);
				background-position: bottom right;
				background-repeat: no-repeat;
				background-size: 50%;
				width: 283px;
				height: 219px;
				z-index: -1;
			}
			
			/* FORMs & TABLEs STYLING */
			
			.result_button {
				display: inline-block;
				font-weight: bold;
				color: #ffffff;
			}
			
			.view {
				background-color: #acd373;
				padding: 0px 4px 0px 4px;
				font-weight: normal;
				font-size: 12px;
			}
			
			.add {
				background-color: #acd373;
				padding: 5px;
			}
			
			.edit {
				background-color: #e58450;
				padding: 0px 4px 0px 4px;
				margin-right: 5px;
			}
			
			.delete {
				background-color: #d71f27;
				padding: 0px 4px 0px 4px;
			}
			
			.cancel {
				background-color: #acd373;
				padding: 5px;
			}
			
			.pageno {
				background-color: #acd373;
				padding: 0px 5px 0px 5px;
				font-size: 18px;
				margin: 3px;
			}
			
			.not_published { 
				border: 2px solid #1fda00; 
				padding: 0px 3px 0px 3px;
				font-size: 12px;
			}
			.published { 
				border: 2px solid #1fda00;
				background-color: #1fda00;
				padding: 0px 3px 0px 3px;
				color: #202020;
				font-size: 12px;
			}
			
			.not_published:hover { 
				background-color: #1fda00;
				color: #202020;
			}
			
			.not_highlighted { 
				border: 2px solid #f1d200;
				padding: 0px 3px 0px 3px;
				font-size: 12px;
			}
			
			.highlighted {
				border: 2px solid #f1d200;
				background-color: #f1d200;
				padding: 0px 3px 0px 3px;
				color: #202020;
				font-size: 12px;
			}
			
			.not_highlighted:hover {
				background-color: #f1d200;
				color: #202020;
			}
			
			.submit {
				border: 0px;
				background-color: #e58450;
				padding: 5px;
				color: #202020;
				cursor: pointer;
			}	
			
			.result_button a:link { color: #202020; text-decoration: none; }
			.result_button a:visited { color: #202020; text-decoration: none; }
			.result_button a:active { color: #202020; text-decoration: none; }
			.result_button a:hover { color: #ffffff; text-decoration: none; }
			.submit:hover { color: #ffffff; text-decoration: none; }
			
			
			.result_list {
				width: 100%;
				border-top: 5px solid #ffffff;
				border-bottom: 5px solid #ffffff;
				margin: 5px 0px 5px 0px;
			}
			
			.result_list td {
				vertical-align: top;
			}
			
			.result_actions {
				text-align: center;
				width: 100px;
			}
			
			.result_list tr:nth-child(odd)    { background-color:#202020; }
			.result_list tr:nth-child(even)    { background-color:#404040; }
			
			.result_list tr:hover   { background-color:#666666; }
			.result_list td:hover    { background-color:#666666; }
			
			.result_header {
				font-weight: bold;
				font-size: 16px;
			}
			
			.result_label {
				width: 200px;
				font-weight: bold;
			}
			
			.result_help {
				font-weight: normal;
				font-style: italic;
				font-size: 12px;
				color: #cccccc;
			}
			
			.view_news_container {
				background-color: #ffffff;
				color: #000000;
				width: 100%;
			}
			
			.view_news_inner {
				padding: 10px;
			}
			
			.view_news_category {
				width: 100%;
			}
			
			.view_news_title {
				font-size: 22px;
			}
			
			.view_news_date {
				font-size: 16px;
			}
			
			.view_news_body {
			}
			
			.result_image_container {
				position: relative;
				float: left;
				display: block;
				width: 200px;
				height: 300px;
				overflow: hidden;
				margin: 3px;
			}
			
			.result_image_container:nth-child(odd) { background-color: #5a5a5a; }
			.result_image_container:nth-child(even) { background-color: #a5a5a5; }
			
			.result_image_buttons {
				position: absolute;
				right: 5px;
				bottom: 5px;
				z-index: 1;
			}
			
			.result_image {
				padding-top: 5px;
				text-align: center;
			}
			
			.line_clear {
				clear: both;
			}
			
			/* FANCYBOX STYLES */
			#fancybox-loading {
				position: fixed;
				top: 50%;
				left: 50%;
				width: 40px;
				height: 40px;
				margin-top: -20px;
				margin-left: -20px;
				cursor: pointer;
				overflow: hidden;
				z-index: 1104;
				display: none;
			}
			
			#fancybox-loading div {
				position: absolute;
				top: 0;
				left: 0;
				width: 40px;
				height: 480px;
				background-image: url('../images/fancybox/fancybox.png');
			}
			
			#fancybox-overlay {
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				z-index: 1100;
				display: none;
			}
			
			#fancybox-tmp {
				padding: 0;
				margin: 0;
				border: 0;
				overflow: auto;
				display: none;
			}
			
			#fancybox-wrap {
				position: absolute;
				top: 0;
				left: 0;
				padding: 20px;
				z-index: 1101;
				outline: none;
				display: none;
			}
			
			#fancybox-outer {
				position: relative;
				width: 100%;
				height: 100%;
				background: #fff;
			}
			
			#fancybox-content {
				width: 0;
				height: 0;
				padding: 0;
				outline: none;
				position: relative;
				overflow: hidden;
				z-index: 1102;
				border: 0px solid #fff;
			}
			
			#fancybox-hide-sel-frame {
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				background: transparent;
				z-index: 1101;
			}
			
			#fancybox-close {
				position: absolute;
				top: -15px;
				right: -15px;
				width: 30px;
				height: 30px;
				background: transparent url('../images/fancybox/fancybox.png') -40px 0px;
				cursor: pointer;
				z-index: 1103;
				display: none;
			}
			
			#fancybox-error {
				color: #444;
				font: normal 12px/20px Arial;
				padding: 14px;
				margin: 0;
			}
			
			#fancybox-img {
				width: 100%;
				height: 100%;
				padding: 0;
				margin: 0;
				border: none;
				outline: none;
				line-height: 0;
				vertical-align: top;
			}
			
			#fancybox-frame {
				width: 100%;
				height: 100%;
				border: none;
				display: block;
				position: absolute;
				top: 0px;
				left: 0px;
			}
			
			#fancybox-left, #fancybox-right {
				position: absolute;
				bottom: 0px;
				height: 100%;
				width: 35%;
				cursor: pointer;
				outline: none;
				background: transparent url('../images/fancybox/blank.gif');
				z-index: 1102;
				display: none;
			}
			
			#fancybox-left {
				left: 0px;
			}
			
			#fancybox-right {
				right: 0px;
			}
			
			#fancybox-left-ico, #fancybox-right-ico {
				position: absolute;
				top: 50%;
				left: -9999px;
				width: 30px;
				height: 30px;
				margin-top: -15px;
				cursor: pointer;
				z-index: 1102;
				display: block;
			}
			
			#fancybox-left-ico {
				background-image: url('../images/fancybox/fancybox.png');
				background-position: -40px -30px;
			}
			
			#fancybox-right-ico {
				background-image: url('../images/fancybox/fancybox.png');
				background-position: -40px -60px;
			}
			
			#fancybox-left:hover, #fancybox-right:hover {
				visibility: visible; /* IE6 */
			}
			
			#fancybox-left:hover span {
				left: 20px;
			}
			
			#fancybox-right:hover span {
				left: auto;
				right: 20px;
			}
			
			.fancybox-bg {
				position: absolute;
				padding: 0;
				margin: 0;
				border: 0;
				width: 20px;
				height: 20px;
				z-index: 1001;
			}
			
			#fancybox-bg-n {
				top: -20px;
				left: 0;
				width: 100%;
				background-image: url('../images/fancybox/fancybox-x.png');
			}
			
			#fancybox-bg-ne {
				top: -20px;
				right: -20px;
				background-image: url('../images/fancybox/fancybox.png');
				background-position: -40px -162px;
			}
			
			#fancybox-bg-e {
				top: 0;
				right: -20px;
				height: 100%;
				background-image: url('../images/fancybox/fancybox-y.png');
				background-position: -20px 0px;
			}
			
			#fancybox-bg-se {
				bottom: -20px;
				right: -20px;
				background-image: url('../images/fancybox/fancybox.png');
				background-position: -40px -182px; 
			}
			
			#fancybox-bg-s {
				bottom: -20px;
				left: 0;
				width: 100%;
				background-image: url('../images/fancybox/fancybox-x.png');
				background-position: 0px -20px;
			}
			
			#fancybox-bg-sw {
				bottom: -20px;
				left: -20px;
				background-image: url('../images/fancybox/fancybox.png');
				background-position: -40px -142px;
			}
			
			#fancybox-bg-w {
				top: 0;
				left: -20px;
				height: 100%;
				background-image: url('../images/fancybox/fancybox-y.png');
			}
			
			#fancybox-bg-nw {
				top: -20px;
				left: -20px;
				background-image: url('../images/fancybox/fancybox.png');
				background-position: -40px -122px;
			}
			
			#fancybox-title {
				font-family: Helvetica;
				font-size: 12px;
				z-index: 1102;
			}
			
			.fancybox-title-inside {
				padding-bottom: 10px;
				text-align: center;
				color: #333;
				background: #fff;
				position: relative;
			}
			
			.fancybox-title-outside {
				padding-top: 10px;
				color: #fff;
			}
			
			.fancybox-title-over {
				position: absolute;
				bottom: 0;
				left: 0;
				color: #FFF;
				text-align: left;
			}
			
			#fancybox-title-over {
				padding: 10px;
				background-image: url('../images/fancybox/fancy_title_over.png');
				display: block;
			}
			
			.fancybox-title-float {
				position: absolute;
				left: 0;
				bottom: -20px;
				height: 32px;
			}
			
			#fancybox-title-float-wrap {
				border: none;
				border-collapse: collapse;
				width: auto;
			}
			
			#fancybox-title-float-wrap td {
				border: none;
				white-space: nowrap;
			}
			
			#fancybox-title-float-left {
				padding: 0 0 0 15px;
				background: url('../images/fancybox/fancybox.png') -40px -90px no-repeat;
			}
			
			#fancybox-title-float-main {
				color: #FFF;
				line-height: 29px;
				font-weight: bold;
				padding: 0 0 3px 0;
				background: url('../images/fancybox/fancybox-x.png') 0px -40px;
			}
			
			#fancybox-title-float-right {
				padding: 0 0 0 15px;
				background: url('../images/fancybox/fancybox.png') -55px -90px no-repeat;
			}
			
			/* IE6 */
			
			.fancybox-ie6 #fancybox-close { background: transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/fancybox/fancy_close.png', sizingMethod='scale'); }
			
			.fancybox-ie6 #fancybox-left-ico { background: transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/fancybox/fancy_nav_left.png', sizingMethod='scale'); }
			.fancybox-ie6 #fancybox-right-ico { background: transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/fancybox/fancy_nav_right.png', sizingMethod='scale'); }
			
			.fancybox-ie6 #fancybox-title-over { background: transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/fancybox/fancy_title_over.png', sizingMethod='scale'); zoom: 1; }
			.fancybox-ie6 #fancybox-title-float-left { background: transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/fancybox/fancy_title_left.png', sizingMethod='scale'); }
			.fancybox-ie6 #fancybox-title-float-main { background: transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/fancybox/fancy_title_main.png', sizingMethod='scale'); }
			.fancybox-ie6 #fancybox-title-float-right { background: transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/fancybox/fancy_title_right.png', sizingMethod='scale'); }
			
			.fancybox-ie6 #fancybox-bg-w, .fancybox-ie6 #fancybox-bg-e, .fancybox-ie6 #fancybox-left, .fancybox-ie6 #fancybox-right, #fancybox-hide-sel-frame {
				height: expression(this.parentNode.clientHeight + "px");
			}
			
			#fancybox-loading.fancybox-ie6 {
				position: absolute; margin-top: 0;
				top: expression( (-20 + (document.documentElement.clientHeight ? document.documentElement.clientHeight/2 : document.body.clientHeight/2 ) + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop )) + 'px');
			}
			
			#fancybox-loading.fancybox-ie6 div	{ background: transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/fancybox/fancy_loading.png', sizingMethod='scale'); }
			
			/* IE6, IE7, IE8 */
			
			.fancybox-ie .fancybox-bg { background: transparent !important; }
			
			.fancybox-ie #fancybox-bg-n { filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/fancybox/fancy_shadow_n.png', sizingMethod='scale'); }
			.fancybox-ie #fancybox-bg-ne { filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/fancybox/fancy_shadow_ne.png', sizingMethod='scale'); }
			.fancybox-ie #fancybox-bg-e { filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/fancybox/fancy_shadow_e.png', sizingMethod='scale'); }
			.fancybox-ie #fancybox-bg-se { filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/fancybox/fancy_shadow_se.png', sizingMethod='scale'); }
			.fancybox-ie #fancybox-bg-s { filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/fancybox/fancy_shadow_s.png', sizingMethod='scale'); }
			.fancybox-ie #fancybox-bg-sw { filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/fancybox/fancy_shadow_sw.png', sizingMethod='scale'); }
			.fancybox-ie #fancybox-bg-w { filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/fancybox/fancy_shadow_w.png', sizingMethod='scale'); }
			.fancybox-ie #fancybox-bg-nw { filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/fancybox/fancy_shadow_nw.png', sizingMethod='scale'); }
			
			
		</style>
        <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js' type='text/javascript'></script>
        <script src="<?=sysLibraryPath?>phpTimeEmulator.js" language="javascript" type="text/javascript"></script>
        <?=$pageArray["pageScripts"]?>
	</head>
	<body>
    	<div id="main_container">
        	<div class="titlebar_outer">
                <div id="title">
                    <?=$pageArray["pageTitle"]?>
                </div>
                <div id="sys_status">
                <?php
                	if (sysDebugMode || sysMaintenanceMode)
                    {
                        if (sysDebugMode)
                            $outString = "System Status: <span id='sys_debug'>Debug</span>";
                        
                        if (sysMaintenanceMode)
                        {
                            if (sysDebugMode)
                                $outString .= " & <span id='sys_maintenance'>Maintenance</span>";
                            else
                                $outString = "System Status: <span id='sys_maintenance'>Maintenance</span>";
                        }
                    }
					else
					{
						$outString = "System Status: <span id='sys_normal'>Normal</span>";
					}
					echo ('<div class="login_debug">'.$outString.'</div>');
				?>
                </div>
            </div>            
			<div id="body_outer">
            	<div id="body">
        			<?=$pageArray["pageBody"]?>
                </div>
        	</div>
    	</div>
    </body>
</html>