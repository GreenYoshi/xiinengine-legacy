<!DOCTYPE html>
<!--
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
-->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?=$pageArray["pageTitle"]?></title>
        <link rel="shortcut icon" href="<?=sysBaseURL?>/favicon.ico" />
        <style>
            html { height: 100%; }
            body {
                background: url(<?=sysBaseURL?>/imgbin/bg.png);
                background-position: bottom;
                background-repeat: no-repeat;
                background-size: fill;
                background-color: #202020;
                font-family:Verdana, Geneva, sans-serif;
                color:#ffffff;
                border: 0px;
                padding: 0px;
                margin: 0px;
                width: 100%;
                height: 100%;
            }

            #maincontainer {
                width: 100%;
                height: 100%;
                margin-left:auto;
                margin-right:auto;
            }

            #title {
                margin-left:10px;
                margin-right:10px;
                padding:10px;
                border:1px solid;
                border-radius:5px;

                font-size:large;
            }
            #login_container {
                color: #202020;
                width: 320px;
                position: relative;
                margin-left: auto;
                margin-right: auto;
                margin-top: 15px;
                padding: 10px;
                top: 200px;
                background-color: #ffffff;
                background-color: rgba(255,255,255,0.8);
                -moz-box-shadow: 0 0 10px #000000;
                -webkit-box-shadow: 0 0 10px #000000;
                box-shadow: 0 0 10px #000000;
                opacity: 0;
            }

            .login_image {
                color: #202020;
                width: 500px;
                position: absolute;
                top: 20px;
                margin-left: auto;
                margin-right: auto;
                margin-top: auto;
                padding: 10px;
                opacity: 1;
                z-index: -5;
            }

            table {
                font-size: 14px;
            }

            .login_labels {
                margin-bottom: 5px;
                font-size: 14px;
                position: relative;
            }

            .login_error {
                display: block;
                font-style: italic;
                font-size: 12px;
                color: #e50000;
                text-align: center;
            }

            .login_button {
                background-color: #202020;
                color: #ffffff;
                font-size: 14px;
                font-weight: bold;
                padding: 3px;
                cursor: pointer;
                width: 95%;
                margin-top: 10px;
                border: 2px solid #202020;
            }

            .login_button:hover {
                background-color: #ffffff;
                color: #202020;

            }

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

            .login_copyright {
                font-size: 16px;
                font-weight: bold;
                position: absolute;
                bottom: 5px;
                right: 5px;
            }

            .login_debug {
                font-size: 12px;
                font-weight: bold;
                color: #e50000;
                position: relative;
                top: 0px;
                left: 0px;
            }

            .login_message {
                text-align: center;	
            }

            .debug_verbose {
                font-size: 12px;
                font-weight: bold;
                position: absolute;
                top: 5px;
                right: 5px;
                text-align: right;
            }

            input#authUsername, input#authPassword { 
                border: 2px solid #202020;
                background-color: #ffffff;
                color: #202020;
                font-weight: bold;
            }

            input#authUsername:hover, input#authPassword:hover { 
                background-color: #eaeaea;
            }

            input#authUsername:focus, input#authPassword:focus { 
                border: 2px solid #202020;
                background-color: #ffffff;
                color: #202020;
                font-weight: bold;
            }

        </style>
        <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js' type='text/javascript'></script>
        <script src="<?=sysBaseURL.sysLibraryPath?>jquery.easing.1.3.js" type="text/javascript"></script>
        <?=$pageArray["pageScripts"]?>
    </head>
    <body>
        <div class="debug_verbose">
            <?php
            if (sysDebugMode) {
                include sysModulePath . "debug_verbose.php";
                getVerbose();
            }
            ?>
        </div>
        <div id="maincontainer">   
            <?=$pageArray["pageBody"]?>
        </div>
    </body>
</html>