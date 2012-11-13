<?php session_start();
if (isset($_POST['request'])) {
	include_once 'utils.php';
	$uname = $_SESSION['uname'];
	$reqType = $_POST['request'];

	switch ($reqType) {
		case 'uploadPhotos' : {
			$json = getUserCircles($uname);
			echo "$json";
			break;
		}
		default :
			break;
	}

}
?>