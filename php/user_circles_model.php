<?php session_start();
if (isset($_POST['circle'])) {
	include_once 'utils.php';
}
?>

<?php
if (isset($_POST['request'])) {
	$uname = $_SESSION['uname'];
	$reqType = $_POST['request'];
            //echo "alert('a')";
	switch ($reqType) {
		case 'getcircle' :{
			$json = getUserCircles($uname);
			echo "$json";
			break;
                }
		case 'getFriends' :{                   
			$circle = $_POST['circle'];
			//echo "$circle";
			//return;
			$json = getUserFriendsInCircle($uname, $circle);
			echo "$json";
			break;
		}
		case 'removeFriendFromCircle':{
					$circle = $_POST['circlename'];
                        $friendList = $_REQUEST['friendList'];
                      $json = removeFriendsFromCircle($uname, $friendList,$circle);
			echo "$json";
			break;
		}
		case 'createCircle':{
			$circleName =$_POST['circlename']; 
			 $json = createNewCircle($uname, $circleName);
			echo "$json";		
			break;
		}
		case 'getFriendsNotInCircle':{
			$circleName = $_POST['circle']; 
			$json = getFriendsNotInCircle($uname, $circleName);
			echo "$json";
                        break;
		}
                case 'addfriend':{                
                    $friend = $_POST['friend'];
                    $circlename = $_POST['circle'];
                    $json = addFriendToCircle($uname, $friend,$circlename);
		    echo "$json";
                    break;
                }
                    
		default :   
			break;
	}

}

function getUserCircles($uname) {
	include_once 'utils.php';
	$output = array();
	$queryGetUserCircles = "select distinct circlename from circle_list cl , user_circles uc where cl.circleid = uc.circleid and uname = '$uname' order by circlename ";
	//$queryGetUserCircles = "select uname as circlename from users";
//	echo "string";
	$queryGetUserCircles = executeQuery($queryGetUserCircles);
        $i = 0;
	while ($row = mysql_fetch_assoc($queryGetUserCircles)) {
		$circleName = $row['circlename'];
		array_push($output, $circleName);
	}
        
        // while($i < 100){
            // array_push($output, $i);
            // $i++;
        // }
	$output = json_encode($output);
	return $output;
}

function getUserFriendsInCircle($uname, $circle) {
	include_once 'utils.php';
	$output = array();
	$querygetUserFriendsInCircle = "select distinct uc.frienduname as funame from circle_list cl, user_circles uc where cl.circleid = uc.circleid and uc.uname = '$uname' and cl.circlename ='$circle'  order by uc.frienduname";
	//$querygetUserFriendsInCircle = "select uname as circlename from users";
	//echo "$querygetUserFriendsInCircle";
	//die;
	$querygetUserFriendsInCircle = executeQuery($querygetUserFriendsInCircle);
	
	while ($row = mysql_fetch_assoc($querygetUserFriendsInCircle)) {
		$friendName = $row['funame'];
		array_push($output, $friendName);
	//	break;
		
	}
	//echo(var_export($output));
	//die;
	$output = json_encode($output);
	return $output;
}


function removeFriendsFromCircle($uname, $friendList,$circleName) {
    include_once 'utils.php';
	$query = "select circleid from circle_list where circlename = '$circleName'  ";
	
	$query = executeQuery($query);
	$row = mysql_fetch_assoc($query);
	$circleId = $row['circleid'];
//	echo "$circleId";
//	die;
	foreach ($friendList as $friend) {
		if($friend != $uname){
			$query = "DELETE FROM project.user_circles WHERE uname='$uname' and frienduname ='$friend' and circleid = '$circleId'";
			
			$query = executeQuery($query);
			// echo "var_export($query)";
			// die;
	//	}
	}
        }
	return true;
}

function createNewCircle($uname,$circleName){
	// check if circle exists in list 
	include_once 'utils.php';
	$query = "select circleid from circle_list where circlename = '$circleName'  ";
	
	$query = executeQuery($query);
	$circleId ="";
	if(mysql_num_rows($query)>0 ){
		$row = mysql_fetch_assoc($query);
		$circleId = $row['circleid'];
	}else{
		$query1 = "INSERT INTO project.circle_list(circlename)VALUES('$circleName')";
	//	return $query1;
		executeQuery($query1);
		$query = "select circleid from project.circle_list where circlename = '$circleName'  ";
		$query = executeQuery($query);
		$row = mysql_fetch_assoc($query);
		$circleId = $row['circleid'];
	}
	
	$query2 = "INSERT INTO project.user_circles(uname,frienduname,circleid)VALUES('$uname','$uname','$circleId')";
	executeQuery($query2);
	//var_dump($query2);
	return true;
	
}

function getFriendsNotInCircle($uname, $circleName){
	$output = array();
		$query = "select circleid from circle_list where circlename = '$circleName'  ";
		$query = executeQuery($query);
		$row = mysql_fetch_assoc($query);
		$circleId = $row['circleid'];
	//	return $circleId;
	$query1 = "select distinct f.to_name as friend from friendship f, user_circles u where 
	f.from_name = '$uname' and  
	u.uname = '$uname' 
	and u.circleid = '$circleId' and 
	u.frienduname != f.to_name 
	union
	select distinct f.from_name as friend from friendship f, user_circles u where 
	f.from_name = '$uname' and  
	u.uname = '$uname' 
	and u.circleid = '$circleId' and 
	u.frienduname != f.from_name";
        
       // return $query1;
        
        $query1 = executeQuery($query1);
	while($row = mysql_fetch_assoc($query1)){
		$friend = $row['friend'];
		array_push($output, $friend);
	}
	$output = json_encode($output);
	return $output;
	
}

function  addFriendToCircle($uname, $friend,$circlename){
    $query = "select circleid from circle_list where circlename = '$circlename'  ";	
    $query = executeQuery($query);
    
    $row = mysql_fetch_assoc($query);
    $circleId = $row['circleid'];
  //  return $circleId;
    $query1 = "INSERT INTO project.user_circles(uname,frienduname,circleid)VALUES('$uname','$friend','$circleId')";
    //return $query1;
    $query1 = executeQuery($query1);
    
    return true;
    
}

?>

