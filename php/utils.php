<?php
// PHP functions for various utilities

function database_connect() {
	$db_host = "127.0.0.1:3306";
	$db_user = "root";
	$db_pw = "aaaaaa";
	$db_name = "project";
	$connection = mysql_connect($db_host, $db_user, $db_pw);
	if (!$connection) {
		die("Could not Connect to $db_host");
	}
	$db_selected = mysql_select_db($db_name, $connection);
	if (!$db_selected) {
		die("Could not select database $db_name");
	}
	return $connection;
}

function executeQuery($query)
{
	database_connect();
	//	echo "$query";
	//database_connect();
	$query = mysql_query($query);	
	return $query;		
}


// Check if user is logged in . Returns true if he is logged in , false otherwise
function authinticateUser() {
	if (!isset($_SESSION['isloggedin'])) {
		if($_SESSION['isloggedin'] == true){
			return true;
		}else{
			redirect("error.php", "1");	
		}
		
	}
}

// function to log user in
function login($uname,$password) {
	
	$password = sha1($password);
//	echo "Pass - $password<br/>";
	$query = "SELECT EXISTS(SELECT 1 FROM project.users WHERE uname = '$uname')";
	$checkquery=executeQuery($query);	
	$checkquery = mysql_fetch_array($checkquery);
	$checkquery= $checkquery[0];
	if($checkquery=='0'){
		
		echo"<div class='error'>User name doesn't exist. Please enter a valid user name</div>";
	}else {
		$aa = "select password from project.users where uname='$uname'";
		$aa = executeQuery($aa);	
		//$aa = mysql_query($aa, $con);
		$aa = mysql_fetch_array($aa);
		//$aa = sha1($aa[0]);
		if($password!=$aa[0])
			echo"<div class='error'>Invalid Password. Please enter a correct password</div>";
		else {			
        
		session_start();
		$_SESSION['isloggedin'] = true;
		$_SESSION['uname'] = $uname;			
 		header("Location:home.php");
		}
	}
}

// function to logout user
function logout() {
	$_SERVER['auth'] = 0;
}

//function to register user
function register($uname,$pass,$email){
	
	$password = sha1($pass);
	$qry = "Select count(*) as count from project.users where uname = '$uname' OR email = '$email'";
	$qry = executeQuery($qry);
	$a = mysql_fetch_assoc($qry);
	//var_dump($a);
	if($a['count'] != 0){
		echo "<div class='error'>User name or email already Exists . Please try another user name or email </div>";
		return ;
	}
	
	//$qry = "INSERT INTO project.users(uname,password,email)VALUES('$uname','$password','$email')";

	$qry="INSERT INTO project.users (uname,password,usertype,firstname,middlename,lastname,title,email,isActiveuser,ucreate_date,lastlogin_date,about)VALUES('$uname','$password','normal','$uname','','','','$email',1,NOW(),NOW(),'')";	
	$qry = executeQuery($qry);
	$qry2 = "INSERT INTO project.user_circles (uname,frienduname,circleid)VALUES('$uname','$uname',1)";
	$qry2 = executeQuery($qry2);
	$qry2 = "INSERT INTO project.user_circles (uname,frienduname,circleid)VALUES('$uname','$uname',2)";
	$qry2 = executeQuery($qry2);
		if($qry == FALSE || $qry2 == FALSE){
		echo "<div class='error'>Error occured</div>";
	}else{
		// session_start();	
// 			
		// $_SESSION['name'] = $uname;
		// $a = $_SESSION['name'];
		// echo "$a";
		header("Location:login.php");				
	}
	
}


// function to redirect user to a particular page
function redirect($page, $error = "", $success = "") {
	$error_str = "";
	$success_str = "";
	$extra = "";
	if (!empty($error))
		$error_str = "?e=" . urlencode($error);
	if (!empty($success))
		$success_str = "?s=" . urlencode($success);
	if (@$_REQUEST['force'] == 1)
		$extra = "&force=1";

	$relocate = "Location: " . $page . $error_str . $success_str;
	$relocate = str_replace("&?e", "&e", $relocate);
	$relocate = str_replace("&?s", "&s", $relocate);
	header($relocate . $extra);
	return;
}
function notify($msg)
{
	echo "<script> notify(\"$msg\")</script>";
}

function isFriend($uname , $funame){
	$query ="select isaccepted from friendship  
where (from_name='$funame' and to_name='$uname')
or (to_name='$funame' and from_name='$uname')";
$query = executeQuery($query);
if(mysql_num_rows($query) > 0){
	return TRUE;
}else{
	return FALSE;
	
}
}

function requestSent($uname , $funame){
	$query = "select isaccepted from friendship_request  
where  (to_name='$funame' and from_name='$uname') ";
$query = executeQuery($query);
if(mysql_num_rows($query) > 0){
	return TRUE;
}else{
	return FALSE;
	
}
}

function getFriendRequests($uname){
	$query = "select count(*) as count from friendship_request
where to_name='$uname'";
$query = executeQuery($query);
$row = mysql_fetch_assoc($query);
    return $row['count'];
}

function getFriendRequestsList($uname){
	$query = "select distinct from_name as name from friendship_request
where to_name='$uname'";
$query = executeQuery($query);
$out = array();
while ($row = mysql_fetch_assoc($query)) {
	array_push($out,$row['name']);
}
//return array("jake","nahe" );;
    return  $out;
}


?>

