<?php
session_start();
include 'utils.php';
authinticateUser();
$uname = $_SESSION['uname'];
?>
<html>
	<head>		
		<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
		<title><?php echo "Welcome $uname"; ?></title>
		<link href="../css/style.css" />
<!--		<link href="../css/notification.css" />-->
		<link rel="stylesheet" type="text/css" href="../css/dateinput.css"/>
		<!-- <link type="text/css" href="../css/pepper-grinder/jquery-ui-1.8.19.custom.css" rel="Stylesheet" /> -->
		<link type="text/css" href="../css/ui-lightness/jquery-ui-1.8.20.custom.css" rel="Stylesheet" />
		<script type="text/javascript" src="../js/jquery-1.7.2.js"></script>
		<script type="text/javascript" src="../js/jquery.tools.min.js"></script>
		<script type="text/javascript" src="../js/jquery.multiselect.js"></script>
		<script type="text/javascript" src="../js/jquery-ui-1.8.19.custom.min.js"></script>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
		<script type="text/javascript" src="../js/main.js"></script>
		<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen"/>
	</head>
	<body>
		<div id="main_container">
			<div id="upper_navbar">
				<div id="company_logo"></div>
				<div id="home" onclick="gotoLocation('home.php')" title="Home Page"></div>
				<div id="search_form_container" title="Search">
				
						<input type="search" name="search_box" value="" id="search_box"  placeholder="Search for something"/>
						<input type="submit" name="search_btn" value="" id="search_btn" >
						</input>
				
				</div>
				<div id="user_tools">
                                    <div id="friend_requests" title="Friend Requests"><?php $a = getFriendRequests($uname); echo "$a" ;?></div>
					<div id="logout_button" title="Logout" onclick="gotoLocation('logout.php')"></div>
					<div id="settings_button" title="Edit your profile Settings" onclick="gotoLocation('settings.php')"></div>
				</div>
			</div>
			<div id="notification_container" class="info message">
			<div class="error message"></div>
			<div class="warning message"></div>
			<div class="success message"></div>
</div>