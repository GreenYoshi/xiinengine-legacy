<?php

function getxeconfig_template($installVars,$domain) {
    $realmName = ($domain == 'public') ? 'Public' : 'Admin';
return "<?php
/**
 * XiinEngine
 *
   * * XiinEngine is supplied under the MIT license. Please read license.md  in the root directory
 *
 * @package XiinEngine Legacy\n
 * @author Ian Karlsson <ian.karlsson@xiinet.com>
 * @author Philip Whitehall <philip.whitehall@xiinet.com> 
 * @copyright Copyright 2006-2013 Xiin Networks <http://xiinet.com/>
 * @link http://xiinengine.com/ 
 * @since v1.2
 * 
 * ".$realmName." Configuration File
 * This has been generated from XEInstaller 1
 */
    define('XE_DB_HOST', '".$installVars['XE_DB_HOST']."');
    define('XE_DB_USER', '".$installVars['XE_DB_USER']."');
    define('XE_DB_PASS', '".$installVars['XE_DB_PASS']."');
    define('XE_DB_NAME', '".$installVars['XE_DB_NAME']."');
?>    
";
}
    
?>