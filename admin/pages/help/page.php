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
?>
<h1>Development Basics</h1>


<h2>The Role of Debug and Maintenance Mode</h2>

<p>XiinEngine has 3 primary system modes, designed to close the site at various levels depending on what is necessary:</p>
<ul>
    <li>Normal - Run the website as normal. Pretty self explanatory</li>
    <li>Debug Mode - Run the website as normal, but make is visual that work is actively being done on the code</li>
    <li>Maintenance Mode - This will lock out all staff from the AdminCP apart from top level Administrators and the ROOT account</li>
</ul>
<p>The variables for these are currently hard-coded into the index.php file for both the public and admin sites. Try `sysDebugMode` and `sysMaintenanceMode` to understand the behaviour.</p>

<h2>How XE Static Pages Work</h2>

<p>Static pages are designed to give you a quick and easy way to throw together plain text/html pages without the need to go through the main 'news/blogging' system.</p>
<p>For each page, you can also set three different flags:</p>

<ul>
    <li>Header Navigation: Set this true/false to toggle the page's visibility in the header navigation bar</li>
    <li>Footer Navigation: Set this true/false to toggle the page's visibility in the footer navigation bar</li>
    <li>Publish Article: Set this true/false to toggle if the page is visible to the public yet. This is useful if you are putting together a large page and want to do it over many sittings, meaning you can save your work and come back to it later</li>
</ul>
<h2>How XE Non-Static Pages Work</h2>

<p>Like most unique websites, breaking from the mould is essential, and we actively encourage you to try building your own pages, add your own tables and add modules to the AdminCP as you see for for your website. What this section will do is walk you through the basics of how to start building an entirely new section within the scope of XE.</p>


<h3>1. Working out what data is needed, and adding to your database</h3>

<p>XE's database is written in <a href="http://en.wikipedia.org/wiki/Third_normal_form" target="_blank">3NF</a> to make the data as decoupled as possible. With this in mind, take a look around the XE database to see how the default tables are structured, and use it as a template for the new table you are putting together.
Add these to the database as necessary. Remember to add your primary key and any linker tables as needed.</p>

<h3>2. Creating the AdminCP management module</h3>

<p>All page information are stored in individual folders within the /pages directory for both public and admin sides. The 2 core files to make a page work are `class.php` and `page.php`. When a page loads, the first thing XE looks for is a matching `class.php` for the page you are calling.</p>

<ul>
    <li>Update the class name in this file to match the new page you're creating</li>
    <li>In the generateAddForm and generateEditForm functions, alter the rows that you require for your new table. Most form variations you will ever need can be found in the `XeForm.php` file. (this file itself will be extensively documented in the future)</li>
    <li>Modify the relevant scr_add.php and scr_edit fields for your data. This is where you throw in your validations and verifications</li>
    <li>The other variables in this class can either be set directly in the file or can be modified in the page file itself</li>
</ul>

<p>The `page.php` in the AdminCP is primarily used to route the user to the right form or table depending on the step in the management process. The likely setup would be to have a landing page which is a table of the data from the database, followed by an add/edit form. Take a look at the `/ncategories` folder in order to get an idea of how this is structured.</p>

<h3>3. Creating the feature for public visibility</h3>

<p>The 2 core files to make a page work are `class.php` and `page.php`. Similar to the AdminCP setup for these two files (except for the form functions). `page.php` can be freely structured as anything from plain html up to a tree structure of extra files and functionality. How you structure this is entirely up to you!</p>


<h2>Working with the Public Promotions Boxes and Sidebar</h2>

<p>The promotions boxes and sidebar are currently operated manually. If you wish to show data in these boxes which come from the database, you should be able to make all your calls via $this->database without having to make a new MySQLi connection, as this has already been established by this stage.</p>

<h2>Working with Permissions</h2>

<p>As a security measure, there are different levels of permissions. The two which come with XE by default are `ROOT` and `Administrator`. Any administrator may **view** the permmissions page in the AdminCP, but you need to log in as ROOTMAN to make any changes.</p>

<p>Permissions in XE are used to work out when an admin can login to the system (connected with System Modes), and which sections of the AdminCP they can see. Take a look at `/admin/pages/dologin`, `/admin/modules/admin_nav_panel.php` and the top of most other `/pages/[pagename]/page.php` files to understand its usage.</p>

<h2>Latest development docs</h2>
<p>For the latest version of our development help document, visit our <a href="https://github.com/GreenYoshi/xiinengine-legacy" target="_blank">GitHub Page</a></p>
