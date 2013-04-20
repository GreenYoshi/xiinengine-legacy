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
 
/**
 * XE Site Config class
 *
 * More class documentation here
 */
class SiteConfig
{

    public $dbHost = XE_DB_HOST;
	public $dbUser = XE_DB_USER;
	public $dbPass = XE_DB_PASS;
	public $dbSelect = XE_DB_NAME;

	public $themeSelect; // = XE_THEME_SELECT;
	
	public $siteName; // = XE_SITE_NAME;
	public $siteDesc; // = XE_SITE_DESCRIPTION;
	public $siteMetaTags;
	public $sitePublicEnabled;
	public $sitePublicClosedMsg;
	public $siteAnnouncementEnabled;
	public $siteAnnouncementMsg;
	
	public function get($database)
	{
		$result = $database->query("SELECT * FROM XE_Switchboard") or die("Failed to fetch site config - ".$database->error);
		
		while ($setting = $result->fetch_assoc())
		{
			//$settings[$setting['SwitchName']] = $setting['SwitchValue'];
			switch($setting['SwitchName'])
			{
				case 'public_site_theme':
					$this->themeSelect = stripslashes($setting['SwitchValue']);
					break;
				case 'site_name':
					$this->siteName = stripslashes($setting['SwitchValue']);
					break;
				case 'site_description':
					$this->siteDesc = stripslashes($setting['SwitchValue']);
					break;
				case 'public_site_tags':
					$this->siteMetaTags = stripslashes($setting['SwitchValue']);
					break;
				case 'public_enabled':
					$this->sitePublicEnabled = stripslashes($setting['SwitchValue']);
					break;
				case 'public_closed_message':
					$this->sitePublicClosedMsg = stripslashes($setting['SwitchValue']);
					break;
				case 'public_announcement_enabled':
					$this->siteAnnouncementEnabled = stripslashes($setting['SwitchValue']);
					break;
				case 'public_announcement':
					$this->siteAnnouncementMsg = stripslashes($setting['SwitchValue']);
					break;
			
			}
		}
	}
}

?>