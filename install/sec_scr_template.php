<?php

function getsecscr_template($securityVars) {
return "<?php
    define('XE_SALT_L', '".$securityVars['XE_SALT_L']."');
    define('XE_SALT_R', '".$securityVars['XE_SALT_R']."');
?>";
}
?>