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
$moduleDebug = false;
$PPLPass = $_POST['PPLPass'];
$PPLPassCheck = $_POST['PPLPassCheck'];
// Grab info
$rememberPassKey = $this->database->real_escape_string(XiinEngine::$input[2]);
$permquery = "SELECT PPLPretty, PPLPass FROM XE_PPL WHERE PPLRememberPassKey = '" . $rememberPassKey . "'";
$dbresult = $this->database->query($permquery) or die($this->database->error);
$perm = $dbresult->fetch_assoc();

// Check for any changes between the database and forms
//$keyvar = array_keys($engine);
//$checkcount = 0;
//print_r($keyvar);
// Password check
if (!empty($perm)) {
    if ($PPLPass == $PPLPassCheck) {
        $postPass = hash("sha512", XE_SALT_L . $PPLPass . XE_SALT_R);
        $this->database->query("UPDATE XE_PPL SET PPLPass = '" . $postPass . "', PPLRememberPassKey = '' WHERE PPLPretty = '" . $perm['PPLPretty'] . "'") or die($this->database->error);

        echo '<div class="body_other_outer">';
        echo '<div class="user_form_outer">';
        echo '<div class="user_form_inner">';
        echo '<div class="user_form_header_notice">Success!</div>';
        echo "Thank you for activating/resetting your account password. You will be redirected to the homepage in 5 seconds.";
        echo '</div>';
        echo '</div>';
        echo '</div>';
        ?>
        <script language="javascript" type="text/javascript">
            $(document).ready(function() {
                setTimeout(redirect,5000);
            });
        			
            function redirect() {
                window.location = '<?=sysBaseURL?>';
            }
        </script>
        <?php

    } else {
        echo '<div class="body_other_outer">';
        echo '<div class="user_form_outer">';
        echo '<div class="user_form_inner">';
        echo '<div class="user_form_header_notice">Hmm, there was a problem</div>';
        echo "Your password verification didn't match up!";
        echo '<div class="result_nav"><div class="result_nav_left"><a href="' . sysBaseURL . '/activate/' . $rememberPassKey . '" class="result_button submit" >Fine, I&rsquo;ll just try again then, shall I?</a></div></div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}
?>