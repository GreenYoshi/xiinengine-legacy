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
    require(sysConfigPath . "xeconfig.php");  // Site configuration
    require(sysConfigPath . "sec_scr.php");

    include(SysLibraryPath . "funcPathinfo.php"); // URL path parser

    include(SysClassPath . "XePage.php");   // XePage class
    include(sysClassPath . "XeTheme.php");
    include(sysClassPath . "SiteConfig.php");  // SiteConig class

    include(sysClassPath . "XePPL.php");

    /**
     * XE Base class
     *
     * More class documentation here
     */
    class XiinEngine {

        // Property Declarations
        public static $siteConfig; // SiteConfig object
        private $db;   // MySQLi object
        public static $userIsAuth;
        public static $userIsAdmin;
        public static $user;  // PPL object
        public static $perms;  //Perm Array
        public static $input;
        public static $database;
		public static $announcement;

        /*     * ********************************************************** */

        // Gentlemen, start your engines!
        public function start() {

            // Create site configuration.			
            self::$siteConfig = new SiteConfig;

            $this->createDB();

            self::$database = $this->db;
			
			self::$siteConfig->get($this->db);
			
			// quick and dirty fix here
			define('XE_SITE_NAME', self::$siteConfig->siteName);
			define('XE_SITE_DESCRIPTION', self::$siteConfig->siteDesc);
			define('XE_SITE_TAGS', self::$siteConfig->siteMetaTags);
			define('XE_THEME_SELECT', self::$siteConfig->siteName);

            $Authorized = $this->doAuth();

            // $_GET["q"] includes whatever was typed after the URL.
            if (isset($_GET["q"])) {
                //$input = parsePathInfo($_GET["q"]);
                $input = prettyExplode($_GET["q"]);
            }
            // If we don't have $_GET["q"], we'll resort to default.
            else {
                $input = array
                    (
                    0 => "home",
                );
            }

            self::$input = $input;

            $skipDisplay = false;

            // Redirect to login if site is closed and the user not authorized
            if ((sysClosedSite || !self::$siteConfig->sitePublicEnabled) && $Authorized == false) {
                if (isset($_SESSION["xe_userID"]))
                    header("Location: " . sysBaseURL . "/logout");
                if ($input[0] != "login" && $input[0] != "dologin")
                    header("Location: " . sysBaseURL . "/login");
                //die($input[0]);
            }

            // Redirect to login if banned
            if (self::$userIsAuth && time() < strtotime(self::$user->BanDate)) {
                if (isset($_SESSION["xe_userID"]))
                    session_unset();

                header("Location: " . sysBaseURL . "/login?error=This%20user%20is%20banned.%20Please%20contact%20staff%20for%20further%20information.");
                //die($input[0]);
            }

            // Load page.		
            $page = $this->loadPage($input[0]);

            // Read vars
            $pageVars = $page->getVars();

            // Is this a redirect page?
            if (!empty($pageVars["redirectPage"])) {
                $redirectPage = $pageVars["redirectPage"];
                // Redirect the browser
                header("Location: " . sysBaseURL . "$redirectPage");
            }
            // is this an API page?
            else if ($input[0] == "api" || $input[0] == "feed" || !empty($pageVars["bypassTheme"])) {

                // if we have one, let's tell the user our content type
                if (isset($pageVars["apiContentType"]))
                    header("Content-Type: " . $pageVars["apiContentType"]);

                // skip the theme and output the raw page
                echo $pageVars["pageBody"];
            }
            // This is neither of these
            else {
                // load theme
                $activeTheme = self::$siteConfig->themeSelect;
                if ($input[0] == "login")
                    $theme = $this->loadTheme("login");
				else
					$theme = $this->loadTheme(self::$siteConfig->themeSelect);

					/*
                else {
                    if (!empty($_GET['themeoverride']))
                        $themeOverride = $this->db->real_escape_string($_GET['themeoverride']);
                    else
                        $themeOverride = '';
                    if (!empty($themeOverride)) {
                        switch ($themeOverride) {
                            case 'default':
                                $theme = $this->loadTheme("default");
                                break;
                            case 'xmas2012':
                                $theme = $this->loadTheme("xmas2012");
                                break;
                            default:
                                $theme = $this->loadTheme($activeTheme);
                                break;
                        }
                    } else {
                        $theme = $this->loadTheme($activeTheme);
                    }
                }
				*/
				
				self::$announcement = "";				
				
				// Add a logout button when the public site is closed
				if(!self::$siteConfig->sitePublicEnabled || sysMaintenanceMode)
					self::$announcement = '<div class="xe_debug">Site closed: '.self::$siteConfig->sitePublicClosedMsg.' | <a href="' . sysBaseURL . '/' . 'logout" target="_self">Logout</a></div>';				

				// Setup the announcement banner					
				if(self::$siteConfig->siteAnnouncementEnabled)
					self::$announcement .= '<div class="xe_debug">'.self::$siteConfig->siteAnnouncementMsg.'</div>';
				
                // Send page contents to theme and execute
                $finalPage = $theme->runTheme($pageVars);
                echo $finalPage;
            }

            return;
        }

        /*     * ********************************************************** */

        // Connects to the database and creates the db object
        private function createDB() {
            $dbHost = self::$siteConfig->dbHost;
            $dbUser = self::$siteConfig->dbUser;
            $dbPass = self::$siteConfig->dbPass;
            $dbSelect = self::$siteConfig->dbSelect;

            // connect to mySQLi		
            $this->db = new MySQLi($dbHost, $dbUser, $dbPass, $dbSelect);

            // if a connection error has occured, halt.
            if (mysqli_connect_error())
                return "Could not connect to database; " . mysqli_connect_errno();

            $this->db->select_db($dbSelect);
        }

        /*     * ********************************************************** */

        // Class dispatch
        private function loadClass($type, $name, $prefix = "") {

            // Set a prefix to the class name if desired
            if (isset($prefix))
                $cname = $prefix . "_" . $name;
            else
                $cname = $name;

            if (class_exists($cname, false))
                return new $cname(self::$siteConfig, $this->db);
        }

        /*     * ********************************************************** */

        // Todo:
        // maybe merge parts of this function with loadClass() ?
        private function loadPage($pageName) {
            $path = SysPagePath . $pageName . "/class.php";
            try {
                if (is_readable($path)) {
                    //echo "LOADING $path";
                    include $path;
                    $pageClass = $this->loadClass("pages", $pageName, "page");
                    if (!is_object($pageClass))
                        throw new Exception("No class found");

                    $pageClass->runPage();
                    //echo $pageClass->getBody();
                    return $pageClass;
                }
                else {
                    // File is missing, then it must be a static page
                    include SysPagePath . "static/class.php";
                    $pageClass = $this->loadClass("pages", "static", "page");
                    $pageClass->runPage();
                    return $pageClass;
                }
            } catch (Exception $e) {
                echo "Page <b>$path</b> Error: " . $e->getMessage() . "\n";
                return false;
            }
        }

        /*     * ********************************************************** */

        private function loadTheme($themeName) {
            $path = SysThemePath . $themeName . "/class.php";
            try {
                if (is_readable($path)) {
                    include $path;
                    $themeClass = $this->loadClass("themes", $themeName, "theme");
                    if (!is_object($themeClass))
                        throw new Exception("No class found");

                    return $themeClass;
                }
                else {
                    throw new Exception("File not readable");
                }
            } catch (Exception $e) {
                echo "Theme <b>$path</b> Error: " . $e->getMessage() . "\n";
                return false;
            }
        }

        /*     * ********************************************************* */

        private function doAuth() {
            session_set_cookie_params(3600, dirname($_SERVER['SCRIPT_NAME']), $_SERVER['HTTP_HOST'], false, true);
            session_start();
            if (isset($_SESSION["xe_userIsAuth"])) {
                self::$userIsAuth = $_SESSION["xe_userIsAuth"];
                self::$userIsAdmin = $_SESSION["xe_userIsAdmin"];
                //$this->user = unserialize($_SESSION["xe_user"]);
                self::$user = new XEPPL();
                self::$user->get($this->db, $_SESSION["xe_userID"]);
                session_regenerate_id();
                if (sysMaintenanceMode && (!in_array("Administrator", self::$user->PermArray) && !in_array("ROOT", self::$user->PermArray)))
                    return false;
                else
                    return true;
            }
            else {

                return false;
            }
        }

    }

?>
