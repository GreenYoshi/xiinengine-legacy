XiinEngine 1.2 (Legacy)
=========================

XiinEngine 1 is a OO-PHP, database-driven content management system. The code base has been used internally by Xiin Networks (http://xiinet.com) since 2010, but is finally making its public debut in version 1.2.

The XE1 series of code will be updated for bug fixes and minor enhancements, as we consider a lot of this code 'legacy' to our modern way of web development. However, we felt that it is a milestone which showcases our way of thinking when it comes to the management of a basic website's content.

XiinEngine is aimed for beginner to mid-level web developers who are comfortable with object-oriented PHP who would like to see the centre of balance of a website shifted away from blog-like management. The solution presented in XE1.2 is a stripped-down 'core' of what has been used on Xiin Networks' internal and external projects, which include:
* Radio Nintendo 7 (http://radionintendo.com)
* Player Pixel 1 (http://playerpixel.com)

The basics of the website will work after running the installer (instructions below). However, we believe the code base is easy to understand that you will want to create your own modules on top of the existing code (such as the examples above).

XiinEngine 1 has been tested and should work on at least PHP 5.2 and MySQL 5.0.

XE1 Setup Checklist
------------------------

To get started with XE, follow these steps:

*  In your hosting, create a database with a name of your choosing. Ensure it's visible in phpMyAdmin

*  If your upload is not in the /xe1 folder from the root directory of your hosting:
   1.  In the root `/.htaccess` included in the download, change the line `RewriteBase /xe1` to a folder of choice, or `/`
   2.  In `/admin/.htaccess` included in the download, change the line `RewriteBase /xe1/admin` to match the public `.htaccess` file

*  Copy XE files to a web directory on server

*  Go to your new website's address and add `/install` to the name

*  Fill out the site's basic information, and click `Install`

*  You can now login at `/admin/`, use the username `ROOTMAN`, and the password you created

*  Should you wish to open the doors immediately, turn off debug and maintenance mode in `index.php` and `/admin/index.php` (change `sysDebugMode` and `sysMaintenanceMode` to `false`). Additionally for the public site's `index.php`, turn `sysClosedSite` to false. Please also set "Public Site Enabled" in the system setting in the AdminCP

*  Remember to delete the entirety of the `/install` folder

Re-install XE1
------------------------

If for any reason you need to re-install XE1 afresh, the minimum requirement for the core files to reset are to:

*  Delete the `/config/sec_scr.php`, `/config/xeconfig.php`, `/admin/config/sec_scr.php` and `/admin/config/xeconfig.php` files

*  Re-upload the `/install` folder back in its original place (because you deleted it when you installed the first time for security reasons, right?)

*  Follow the main setup guide again

Development Basics
---------------------------

**The Role of Debug and Maintenance Mode**

XiinEngine has 3 primary system modes, designed to close the site at various levels depending on what is necessary:

*  Normal - Run the website as normal. Pretty self explanatory - ROOT account is disabled
*  Debug Mode - Run the website as normal, but make is visual that work is actively being done on the code - ROOT account is disabled
*  Maintenance Mode - This will lock out all staff from the AdminCP apart from top level Administrators and the ROOT account

The variables for these are currently hard-coded into the index.php file for both the public and admin sites. Try `sysDebugMode` and `sysMaintenanceMode` to understand the behaviour.

**How XE Static Pages Work**

Static pages are designed to give you a quick and easy way to throw together plain text/html pages without the need to go through the main 'news/blogging' system.
For each page, you can also set three different flags:

* Header Navigation: Set this true/false to toggle the page's visibility in the header navigation bar
* Footer Navigation: Set this true/false to toggle the page's visibility in the footer navigation bar
* Publish Article: Set this true/false to toggle if the page is visible to the public yet. This is useful if you are putting together a large page and want to do it over many sittings, meaning you can save your work and come back to it later

**How XE Non-Static Pages Work**

Like most unique websites, breaking from the mould is essential, and we actively encourage you to try building your own pages, add your own tables and add modules to the AdminCP as you see for for your website. What this section will do is walk you through the basics of how to start building an entirely new section within the scope of XE.


*1. Working out what data is needed, and adding to your database*

XE's database is written in [3NF](http://en.wikipedia.org/wiki/Third_normal_form "3NF") to make the data as decoupled as possible. With this in mind, take a look around the XE database to see how the default tables are structured, and use it as a template for the new table you are putting together.
Add these to the database as necessary. Remember to add your primary key and any linker tables as needed.

*2. Creating the AdminCP management module*

All page information are stored in individual folders within the /pages directory for both public and admin sides. The 2 core files to make a page work are `class.php` and `page.php`. When a page loads, the first thing XE looks for is a matching `class.php` for the page you are calling.

* Update the class name in this file to match the new page you're creating
* In the generateAddForm and generateEditForm functions, alter the rows that you require for your new table. Most form variations you will ever need can be found in the `XeForm.php` file. (this file itself will be extensively documented in the future)
* Modify the relevant scr_add.php and scr_edit fields for your data. This is where you throw in your validations and verifications
* The other variables in this class can either be set directly in the file or can be modified in the page file itself

The `page.php` in the AdminCP is primarily used to route the user to the right form or table depending on the step in the management process. The likely setup would be to have a landing page which is a table of the data from the database, followed by an add/edit form. Take a look at the `/ncategories` folder in order to get an idea of how this is structured.

*3. Creating the feature for public visibility*

The 2 core files to make a page work are `class.php` and `page.php`. Similar to the AdminCP setup for these two files (except for the form functions). `page.php` can be freely structured as anything from plain html up to a tree structure of extra files and functionality. How you structure this is entirely up to you!


**Working with the Public Promotions Boxes and Sidebar**

The promotions boxes and sidebar are currently operated manually. If you wish to show data in these boxes which come from the database, you should be able to make all your calls via $this->database without having to make a new MySQLi connection, as this has already been established by this stage.

**Working with Permissions**

As a security measure, there are different levels of permissions. The two which come with XE by default are `ROOT` and `Administrator`. Any administrator may **view** the permmissions page in the AdminCP, but you need to log in as ROOTMAN to make any changes.

Permissions in XE are used to work out when an admin can login to the system (connected with System Modes), and which sections of the AdminCP they can see. Take a look at `/admin/pages/dologin`, `/admin/modules/admin_nav_panel.php` and the top of most other `/pages/[pagename]/page.php` files to understand its usage.
