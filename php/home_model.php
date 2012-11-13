<?php
session_start();
include_once 'utils.php';
if (isset($_POST['request'])) {
    $uname = $_SESSION['uname'];
    $reqType = $_POST['request'];
    //echo "alert('a')";
    switch ($reqType) {
        case 'gettopMessages' : {
                $json = gettopMessages($uname);
                echo "$json";
                break;
           
            }
        case 'gettopPhotos' : {
                $json = gettopPhotos($uname);
                echo "$json";
                break;          
            }    
        case 'gettopMessagesOther' : {
        		$otherUname = $_POST['otherUser'];
                $json = gettopMessagesOther($uname,$otherUname);
                echo "$json";
                break;          
            }
        case 'gettopPhotosOther' : {
        		$otherUname = $_POST['otherUser'];
                $json = gettopPhotosOther($uname,$otherUname);
                echo "$json";
                break;          
            }    
     case 'addFriendRequest' : {
        		$otherUname = $_POST['otherUser'];
                $json = addFriendRequest($uname,$otherUname);
                echo "$json";
                break;          
            }    
             case 'addFriendToTable' : {
        		$otherUname = $_POST['friendname'];
                $json = addFriendToTable($uname,$otherUname);
                echo "$json";
                break;          
            }    
        default :
            break;
    }
}

function gettopPhotosOther($uname,$otherUname){
	$top_photo_query = "select distinct p.pid as pid , p.timeuploaded as time , p.caption as caption , p.pname as pname , 
p.photo as photopath,l.address as address , p.uname as uname from  
photos p , location_info l , photo_privacy pp ,user_circles uc  where  
p.lid = l.lid and  
p.pid = pp.pid and  
pp.circleid = uc.circleid and(  
(uc.frienduname = '$uname' and uc.uname = '$otherUname') or uc.circleid = 2) 
order by p.timeuploaded desc";
    
    $output = array();
$top_photo_query = executeQuery($top_photo_query);
while($row = mysql_fetch_assoc($top_photo_query)){
    $outputrow = array();
     array_push($outputrow,$row['pid']);
     array_push($outputrow,$row['uname']);
     array_push($outputrow,$row['pname']);
     array_push($outputrow,$row['caption']);
     array_push($outputrow,$row['photopath']);
     array_push($outputrow,$row['time']);
     array_push($outputrow,$row['address']);
    array_push($output, $outputrow);    
}
    $output = json_encode($output);
return $output;
}

function gettopMessagesOther($uname,$otherUname){
	$top_message_query = "select distinct m.mid as mid , m.time_upload as time , m.caption as caption , m.post as post , l.address as address , m.uname as uname from 
message m , location_info l , message_privacy mp ,user_circles uc 
where 
m.lid = l.lid and 
m.mid = mp.mid and 
mp.circleid = uc.circleid and ((
 uc.frienduname = '$uname' and uc.uname = '$otherUname' ) or uc.circleid = 2)
order by m.time_upload desc ";
    $output = array();
$top_message_query = executeQuery($top_message_query);
while($row = mysql_fetch_assoc($top_message_query)){
    $outputrow = array();
    array_push($outputrow,$row['mid']);
    array_push($outputrow,$row['time']);
    array_push($outputrow,$row['caption']);
    array_push($outputrow,$row['post']);
    array_push($outputrow,$row['address']);
    array_push($outputrow,$row['uname']);
    array_push($output, $outputrow);    
}
$output = json_encode($output);
return $output;
    
}
function gettopPhotos($uname) {
    $top_photo_query = "select distinct p.pid as pid , p.timeuploaded as time , p.caption as caption , p.pname as pname ,
    p.photo as photopath,l.address as address , p.uname as uname from 
photos p , location_info l , photo_privacy pp ,user_circles uc 
where 
p.lid = l.lid and 
p.pid = pp.pid and 
pp.circleid = uc.circleid and 
 (  (uc.uname = p.uname and
uc.frienduname = '$uname')  or uc.circleid = 2)
order by p.timeuploaded desc";
    
    $output = array();
$top_photo_query = executeQuery($top_photo_query);
while($row = mysql_fetch_assoc($top_photo_query)){
    $outputrow = array();
     array_push($outputrow,$row['pid']);
     array_push($outputrow,$row['uname']);
     array_push($outputrow,$row['pname']);
     array_push($outputrow,$row['caption']);
     array_push($outputrow,$row['photopath']);
     array_push($outputrow,$row['time']);
     array_push($outputrow,$row['address']);
    array_push($output, $outputrow);    
}
    $output = json_encode($output);
return $output;
}



function gettopMessages($uname) {

    $top_message_query = "select distinct m.mid as mid , m.time_upload as time , m.caption as caption , m.post as post , l.address as address , m.uname as uname from 
message m , location_info l , message_privacy mp ,user_circles uc 
where 
m.lid = l.lid and 
m.mid = mp.mid and 
mp.circleid = uc.circleid and 
( (uc.uname = m.uname and
  uc.frienduname = '$uname' ) or uc.circleid = 2)
order by m.time_upload desc ";
    $output = array();
$top_message_query = executeQuery($top_message_query);
while($row = mysql_fetch_assoc($top_message_query)){
    $outputrow = array();
    array_push($outputrow,$row['mid']);
    array_push($outputrow,$row['time']);
    array_push($outputrow,$row['caption']);
    array_push($outputrow,$row['post']);
    array_push($outputrow,$row['address']);
    array_push($outputrow,$row['uname']);
    array_push($output, $outputrow);    
}
$output = json_encode($output);
return $output;
    
    
}
function addFriendRequest($uname,$otherUname){
	$query = "INSERT INTO project.friendship_request(from_name,to_name,isaccepted,date_requested,date_accepted)VALUES('$uname','$otherUname',0,NOW(),null)";
	$query = executeQuery($query);
	if($query){
		return json_encode(TRUE);
	}else{
		return json_encode(FALSE);
	}	
	
}

function addFriendToTable($uname,$frienduname){
$uname = trim($uname);
$frienduname = trim($frienduname);
    $q = "INSERT INTO project.friendship
(from_name,
to_name,
date,
isaccepted)
VALUES
(
'$uname',
'$frienduname',
NOW(),
1
)";

$q = executeQuery($q);

$q = "INSERT INTO project.friendship
(from_name,
to_name,
date,
isaccepted)
VALUES
(
'$frienduname',
'$uname',
NOW(),
1
)";
$q = executeQuery($q);
$q = "DELETE FROM project.friendship_request
WHERE ( from_name ='$uname' and to_name='$frienduname' ) or( from_name ='$frienduname' and to_name='$uname' )";

$q = executeQuery($q);
return true;
}



?>