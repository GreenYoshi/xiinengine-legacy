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
 
function getVerbose()
{
	echo 'XE1 DEBUG INFORMATION<br />';
	echo 'XE Site Name: '.XE_SITE_NAME.'<br />';
	echo 'Site Version: '.sysMajorVersion.'.'.sysMinorVersion.'.'.sysRevisionVersion.' ('.sysXeType.')<br />';
	echo 'User Agent: '.$_SERVER['HTTP_USER_AGENT'].'<br />';
	echo 'Screen Resolution: <script language="javascript" type="text/javascript">
		document.write(screen.width + " x " + screen.height);
		</script><br />';
	echo 'Browser Resolution: <script language="javascript" type="text/javascript">
		document.write(window.innerWidth + " x " + window.innerHeight);
		</script><br />';
	echo 'User IPv4 Address: '.$_SERVER['REMOTE_ADDR'].'<br />';
	echo 'Signature: '.$_SERVER['SERVER_SIGNATURE'].'<br />';
	

}

?>