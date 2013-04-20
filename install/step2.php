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
 * STEP 2 - XiinEngine Website Installer Script
 * PLEASE DELETE THIS ENTIRE DIRECTORY AFTER SETUP
 */

$publicConfig = '../config/xeconfig.php';
$adminConfig = '../config/admin/xeconfig.php';

// Double check if the files don't exist in case someone tries to run this directly
if (!file_exists($publicConfig) && !file_exists($adminConfig)) {
    
    include 'text_randomiser.php';
    include 'sql.php';
    include 'install_helpers.php';
    include 'xeconfig_template.php';
    include 'sec_scr_template.php';
    
    
    // Vars used for both public and admin files
    // Todo: consider further security checks?
    $installVars['XE_SITE_NAME'] = $_POST['XE_SITE_NAME'];
    $installVars['XE_SITE_DESCRIPTION'] = $_POST['XE_SITE_DESCRIPTION'];
    $installVars['XE_THEME_SELECT'] = $_POST['XE_THEME_SELECT'];
    $installVars['XE_DB_HOST'] = $_POST['XE_DB_HOST'];
    $installVars['XE_DB_USER'] = $_POST['XE_DB_USER'];
    $installVars['XE_DB_PASS'] = $_POST['XE_DB_PASS'];
    $installVars['XE_DB_NAME'] = $_POST['XE_DB_NAME'];
    $installVars['XE_ROOT_PASSWORD'] = ($_POST['XE_ROOT_PASSWORD'] === $_POST['XE_ROOT_PASSWORD_CONFIRM'])
    ? $_POST['XE_ROOT_PASSWORD']
    : getRandomString(12);
    $autoPages['XE_PAGE_ABOUT'] = (isset($_POST['XE_PAGE_ABOUT']));
    $autoPages['XE_PAGE_LEGAL'] = (isset($_POST['XE_PAGE_LEGAL']));
    
    $securityVars['XE_SALT_L'] = getRandomString(8);
    $securityVars['XE_SALT_R'] = getRandomString(8);
    
    $xepublicconfig = getxeconfig_template($installVars,'public');
    $xeadminconfig = getxeconfig_template($installVars,'admin');
    $configfile = "xeconfig.php";
    
    $xesecscr = getsecscr_template($securityVars);
    $secscrfile = "sec_scr.php";
    
    // Generate public config
    generateFile('../config/'.$configfile,$xepublicconfig);
    
    // Generate admin config (unified with public config in XE2)
    generateFile('../admin/config/'.$configfile,$xeadminconfig);
    
    // Generate public sec_scr
    generateFile('../config/'.$secscrfile,$xesecscr);
    
    // Generate admin sec_scr (unified with public config in XE2)
    generateFile('../admin/config/'.$secscrfile,$xesecscr);
    
    //todo: add sql table installer here
    $userPassword = hash("sha512",$securityVars['XE_SALT_L'].$installVars['XE_ROOT_PASSWORD'].$securityVars['XE_SALT_R']);
    $rawSql = getSqlDump($installVars,$userPassword);

    // connect to mySQLi		
    $db = new MySQLi($installVars['XE_DB_HOST'], $installVars['XE_DB_USER'], $installVars['XE_DB_PASS'], $installVars['XE_DB_NAME']);

    // if a connection error has occured, halt.
    if (mysqli_connect_error())
        return "Could not connect to database; " . mysqli_connect_errno();

    $db->select_db($installVars['XE_DB_NAME']);
    $db->multi_query($rawSql) or die($db->error);
    while ($db->more_results() && $db->next_result());
    // Generate auto-pages as necessary
    if ($autoPages['XE_PAGE_ABOUT']) {
        $aboutQuery = generateAutoPage($db,'about');
        $db->query($aboutQuery) or die($db->error);
    }
        
    if ($autoPages['XE_PAGE_LEGAL']) {
        $legalQuery = generateAutoPage($db,'legal');
        $db->query($legalQuery) or die($db->error);
    }
    
    echo '<div id="install_status">Installation Complete!</div>';
} else {
    echo '<div id="install_status">A configuration already exists. Please delete this folder</div>';
}

?>

