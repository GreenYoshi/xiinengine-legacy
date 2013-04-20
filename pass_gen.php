<?php

	$Passgen_Toggle = 0;
	
	if($Passgen_Toggle) {


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>XE1 Password Generator</title>
</head>
<body>
<form method="post">
	<input type="text" name="blah" value="Enter a string and press enter" />
</form>
<br />
<?php

	include "admin/config/sec_scr.php";

	if(isset($_POST["blah"])){
		$hash = hash("sha512",XE_SALT_L.$_POST["blah"].XE_SALT_R);
		echo $hash;	
	}
?>

</body>
</html>

<?php
	}

?>