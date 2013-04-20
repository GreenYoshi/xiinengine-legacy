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

	define("sysBaseURL", "//".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']), true);    
	define("sysPath", dirname(__FILE__), true);
	define("sysClassPath", dirname(__FILE__) . "/classes/", true);
	define("sysLibraryPath", dirname(__FILE__) . "/libraries/", true);
	define("sysPagePath", dirname(__FILE__) . "/pages/", true);
	define("sysThemePath", dirname(__FILE__) . "/themes/", true);
	define("sysModulePath", dirname(__FILE__) . "/modules/", true);
	define("sysImgPath", dirname(__FILE__) . "/imgbin/", true);
	define("sysConfigPath", dirname(__FILE__) . "/config/", true);

	define("sysMajorVersion","1",true);
	define("sysMinorVersion","2",true);
	define("sysRevisionVersion","0",true);
	define("sysXeType","Admin",true);

	define("sysDebugMode", true, true);
	define("sysMaintenanceMode", true, true);

	if(sysDebugMode == true)
	{
		error_reporting(-1);
	}    

	include "classes/XiinEngine.php";

	$xe = new XiinEngine();
	$xe->start();
?>