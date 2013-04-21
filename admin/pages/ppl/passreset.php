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
// SECURITY, Reroutes non admins/roots to homepage
if (!in_array("Administrator", XiinEngine::$user->PermArray) && !in_array("ROOT", XiinEngine::$user->PermArray) && !in_array("Xiin Networks Developer", XiinEngine::$user->PermArray)) {
    // Allow if owner of account
    if (XiinEngine::$user->Pretty != XiinEngine::$input[2])
        $this->redirectPage = "/home";
}
?>

<?php

$debug = false;

$pplPretty = substr(XiinEngine::$input[2], 0, 50);
$dbmailto = $this->database->query("SELECT PPLAlias, PPLFName, PPLSName, PPLEmail FROM XE_PPL WHERE PPLPretty = '" . $pplPretty . "' LIMIT 1");
$mailto = $dbmailto->fetch_assoc();
$mailURLRaw = explode('/', sysBaseURL);
$mailURL = $mailURLRaw[2];
// Error Checking Process. By default, data is ok
$okdata = true;
$error = "No errors occurred";

// Generate Activation Key
$rememberPassKey = hash("sha512", XE_SALT_L . $mailto['PPLEmail'] . date("H:jYU") . XE_SALT_R);

$subject = XE_SITE_NAME.' Account Reset';

$body = 'Dear ' . $mailto['PPLFName'] . ' ' . $mailto['PPLSName'] . ',
Your password has been reset on '.XE_SITE_NAME.'. Please click the link below to set a new password:

http://'.$mailURL.'/activate/' . $rememberPassKey . '

If you cannot click it, copy paste it into a web browser. Hope to see you online soon!

Kind regards,

'.XE_SITE_NAME.' Team';

$email = 'no-reply@'.$mailURL;

if ($debug) {
    echo "First Name: " . $name . "<br>";
    echo "Email: " . $mailto['PPLEmail'] . "<br>";
    echo "Remember Pass Key: " . $rememberPassKey . "<br>";
    echo "Subject: " . $subject . "<br>";
    echo "Body: " . nl2br($body) . "<br>";
    echo "<br>";
    echo "OK DATA?: " . $error . "<br>";
} else {
    // If data is fine, insert the new user to the database and redirect to the homepage
    if (!$okdata) {
        $error;
    } else {
        mail($mailto['PPLEmail'], $subject, $body, "From:" . $email);
        $this->database->query("UPDATE XE_PPL SET PPLRememberPassKey = '" . $rememberPassKey . "' WHERE PPLPretty = '" . $pplPretty . "'") or die($this->database->error);
        header("location:" . sysBaseURL . "/ppl");
    }
}
?>