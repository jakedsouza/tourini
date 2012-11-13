<?php session_start();
if(isset($_SESSION['isloggedin'])){
	$_SESSION['isloggedin'] = false;
session_destroy();	
}
?>
<html>
	<link rel="stylesheet" type="text/css" href="../css/form.css"/>
<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen"/>
	<h1>
		Successfully logged out.<br/>
		Thank you . Please click <a href="login.php">here</a> to log back in 
	</h1>
	<?php header("Location:../")?>
</html>