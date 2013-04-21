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
$activeKey = XiinEngine::$input[1];
if ($activeKey == '' || $activeKey == NULL) {
    $this->redirectPage = "/";
}
$dbquery = "SELECT PPLAlias FROM XE_PPL WHERE PPLRememberPassKey = '" . $activeKey . "'";

$dbResult = $this->database->query($dbquery) or die("DB error" . $this->database->error());
$activationCheck = $dbResult->fetch_assoc();

if (!empty($activationCheck)) {
    $validateOne = true;
} else {
    $validateOne = false;
}
?>
<div class="body_other_outer">
    <div class="user_form_outer">
        <div class="user_form_inner">
            <div class="user_form_header_notice">Please enter a new password to continue:</div>
            <?php
            if ($validateOne) {

                require_once (sysClassPath . "XeForm.php");
                $formObject = new XeForm($this->database, XiinEngine::$input[0] . '/edit', 'XE_PPL', $activeKey);
                $formOutput = $formObject->openForm();
                $formOutput .= $formObject->row('New Password', '', 'password', 'PPLPass', ''
                );
                $formOutput .= $formObject->row('Confirm New Password', '', 'password', 'PPLPassCheck', ''
                );
                $formOutput .= $formObject->closeTable();
                $formOutput .= $formObject->buttons();
                $formOutput .= $formObject->closeForm();

                echo $formOutput;
            }
            ?>
        </div>
    </div>
</div>
