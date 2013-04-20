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
function generateNav() {
    if (isset(XiinEngine::$user)) {
        ?>

        <script type="text/javascript">
        	
        	
            $(window).load(function() {	
                $(".feature_hide").hide();
                $(".toggle_dead").css("cursor","pointer").bind('click', function() {
                    $(".feature_hide").toggle();
                });
            });
        </script>

        <?php

        echo '
		<div class="nav_administrations_section_outer"><div class="nav_tab_color">&nbsp;</div><div class="nav_administrations_section_inner">
		<div class="nav_title">
		' . XiinEngine::$user->FName . ' ' . XiinEngine::$user->SName . '
		</div>
		<ul class="nav_entries">
			<li><a href="' . sysBaseURL . '/ppl/edit/' . XiinEngine::$user->Pretty . '">Edit Account</a></li>';
        if (in_array("Xiin Networks Developer", XiinEngine::$user->PermArray) || in_array("ROOT", XiinEngine::$user->PermArray)) {
            echo '<li><span class="toggle_dead">Toggle Disabled Features</span></li>';
        }
        echo '
			<li><a href="' . sysBaseURL . '/logout">Logout</a></li> 
		</ul>
		</div></div>';

        if (in_array("Administrator", XiinEngine::$user->PermArray) || in_array("ROOT", XiinEngine::$user->PermArray) || in_array("Xiin Networks Developer", XiinEngine::$user->PermArray)) {
            echo '
			<div class="nav_administrations_section_outer"><div class="nav_tab_color" id="nav_tab_red">&nbsp;</div><div class="nav_administrations_section_inner">
			<div id="nav_title_red" class="nav_title">People Manager</div>
			<ul class="nav_entries">
				<li><a href="' . sysBaseURL . '/ppl" target="_self" class="debug_done">List All</a></li>
				<li><a href="' . sysBaseURL . '/permissions" target="_self" class="debug_done">Permissions</a></li>
				<li><a href="' . sysBaseURL . '/ppl/add" target="_self" class="debug_done">Add Account</a></li>
				
				<li><a href="' . sysBaseURL . '/ppl" target="_self" class="feature_hide">DISABLED: Search</a></li>
			</ul>
			</div></div>';
        }
        if (in_array("Administrator", XiinEngine::$user->PermArray) || in_array("ROOT", XiinEngine::$user->PermArray) || in_array("Xiin Networks Developer", XiinEngine::$user->PermArray) || in_array("Journalist", XiinEngine::$user->PermArray)) {
            echo '
			<div class="nav_administrations_section_outer"><div class="nav_tab_color" id="nav_tab_yellow">&nbsp;</div><div class="nav_administrations_section_inner">
			<div id="nav_title_yellow" class="nav_title">Articles Manager</div>
			<ul class="nav_entries">
				<li><a href="' . sysBaseURL . '/articles" target="_self" class="debug_done">Live Feed</a></li>
				<li><a href="' . sysBaseURL . '/articles/add" target="_self" class="debug_done">Add Article</a></li>
				<li><a href="' . sysBaseURL . '/ncategories" target="_self" class="debug_done">Categories</a></li>
			</ul>
			</div></div>';
        }
        if (in_array("Administrator", XiinEngine::$user->PermArray) || in_array("ROOT", XiinEngine::$user->PermArray) || in_array("Xiin Networks Developer", XiinEngine::$user->PermArray)) {
            echo '
			<div class="nav_administrations_section_outer"><div class="nav_tab_color" id="nav_tab_orange">&nbsp;</div><div class="nav_administrations_section_inner">
			<div id="nav_title_orange" class="nav_title">Pages Manager</div>
			<ul class="nav_entries">
				<li><a href="' . sysBaseURL . '/staticpages" target="_self" class="debug_done">View Pages</a></li>
				<li><a href="' . sysBaseURL . '/staticpages/add" target="_self" class="debug_done">Add Page</a></li>
			</ul>
			</div></div>';
        }
        if (in_array("Administrator", XiinEngine::$user->PermArray) || in_array("ROOT", XiinEngine::$user->PermArray) || in_array("Xiin Networks Developer", XiinEngine::$user->PermArray)) {
            echo '
			<div class="nav_administrations_section_outer"><div class="nav_tab_color" id="nav_tab_teal">&nbsp;</div><div class="nav_administrations_section_inner">
			<div id="nav_title_teal" class="nav_title">System</div>
			<ul class="nav_entries">
				<li><a href="' . sysBaseURL . '/settings" target="_self" class="debug_done">Settings</a></li>
			</ul>
			</div></div>';
        }
        
        echo '
		<div class="nav_administrations_section_outer"><div class="nav_administrations_section_inner">
		<ul class="nav_entries">
			<li class="tab_copyright"><a href="http://xiinengine.com" target="_blank">XiinEngine</a> '.sysMajorVersion.'.'.sysMinorVersion.' &copy; <a href="http://xiinet.com" target="_blank">Xiin Networks</a> '.date("Y").'</li>
		</ul>
		</div></div>';
    }
}
?>

