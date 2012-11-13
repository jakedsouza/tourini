<?php
include 'header.php';
?>

<style>
    #users-container,#photos-container,#messages-container {
    	min-height: 40px;
        height: auto;
        display: block;
        padding: 10px;
        margin-top: 10px;
        background-color: #FFFFFF;
        border-radius:4px;
    }
    
    .user-result:nth-child(even) ,.search-message-result:nth-child(even),.photo-result:nth-child(even){
    	display: block;
    	font-size: large;
    	padding-left: 50px;
        padding-top: 10px;
        padding-bottom: 10px;
        background-color: #999999;
        border-color: #000000;
        border-width: 1px;
        border-radius:2px;
        margin-top: 4px;
    }
    .user-result:nth-child(odd),.search-message-result:nth-child(odd),.photo-result:nth-child(odd){
    	display: block;
    	font-size: large;
    	padding-left: 50px;
        background-color: #cccccc;
        padding-left: 50px;
        padding-top: 10px;
        padding-bottom: 10px;
          border-color: #000000;
        border-width: 1px;
        border-radius:2px;
        margin-top: 4px;
    }
    
</style>
<div id="central_container">
    <!-- <div id="search_form_container" title=""> -->
    <?php
    if (isset($_GET['searchFor'])) {
        $searchfor = $_GET["searchFor"];
        $searches = explode(" ", $searchfor);
        $no_of_words = count($searches);
        $result1 = array();
        $result2 = array();
        $result31 = array();
        $result32 = array();
        $j = 0;
        $usersResult = array();
        $messageResult = array();
        $photoResult = array();
        // for loop for users                                                                       
        for ($i = 0; $i < $no_of_words; $i++) {
            $key = $searches[$i];
            $query1 = "select distinct uname from project.users where firstname like '%$key%' or lastname like '%$key%' or middlename like '%$key%' or uname like '%$key%'";
          //  $query1 = "select distinct uname from project.users ";
            $query1 = executeQuery($query1);
            if ($query1) {
                while ($row = mysql_fetch_assoc($query1)) {
                    global $result1;
                    $result1[$j] = $row['uname'];
                    array_push($usersResult, $row['uname']);
                    $j++;
                }
            }
            $query2 ="select distinct p.uname as uname,p.pid as pid,p.caption as caption,p.timetaken as timetaken,l.address as address 
from photos p , location_info l ,user_circles u ,photo_privacy pp where 
p.lid = l.lid and 
p.pid = pp.pid and 
pp.circleid = u.circleid and 
(u.frienduname = '$uname' or u.uname = '$uname') and 
(p.pname like '%$key%' or 
p.caption like '%$key%' or 
l.address like '%$key%'

)
";
            // $query2 ="select distinct p.uname as uname,p.pid as pid,p.caption as caption,p.timetaken as timetaken,l.address as address 
// from photos p , location_info l ,user_circles u ,photo_privacy pp 
// ";
 //   $query2 = "(select distinct p.uname as uname,p.caption as caption,p.pname as pname ,p.pid as pid,p.timetaken as timetaken ,p.photo as photo from photos p where pname like '%$key%' or caption like '%$key%')";

            $query2 = executeQuery($query2);
            if ($query2) {
                while ($row = mysql_fetch_assoc($query2)) {
                 //   global $result1;
              //      $result1[$j] = $row['uname'];
                    $out = array();
					$out["uname"] = $row['uname'];
                  	$out["pid"] = $row['pid'];
					$out["caption"] = $row['caption'];
					$out["timetaken"]=$row['timetaken'];
					$out["address"] = $row['address'];
                    //array_push($out, $row['photo']);
                   // array_push($out, $row['caption']);
                   // array_push($out, $row['pid']);
                   // array_push($out, $row['timetaken']);
                    //array_push($out, $row['address']);
                    
                    // array_push($out, $row['address']);
                    array_push($photoResult, $out);
                    $j++;
                }
            }
         // $query3 = "select distinct uname,text from project.message where text like '%$key%' or caption like '%$key%'";
        $query3 = "select distinct m.uname as uname,m.caption as caption , m.post as post ,m.time_upload as timetaken,l.address as address 
from message m , location_info l ,user_circles u ,message_privacy mp  where 
m.lid = l.lid and 
m.mid = mp.mid and 
mp.circleid = u.circleid and (u.frienduname = '$uname' or u.uname = '$uname')
 and 
(m.post like '%$key%' or 
m.caption like '%$key%' or 
l.address like '%$key%'
)";
        // $query3 = "select distinct m.uname as uname,m.caption as caption , m.post as post ,m.time_upload as timetaken,l.address as address 
// from message m , location_info l ,user_circles u ,message_privacy mp
// ";
        $query3 = executeQuery($query3);
        if ($query3) {
                while ($row = mysql_fetch_assoc($query3)) {
              //      global $result1;
             //       $result1[$j] = $row['uname'];
                     $out = array();
					 $out["uname"] = $row['uname'];
					 $out["caption"] = $row['caption'];
					 $out["post"] = $row['post'];
					 $out["timetaken"] = $row['timetaken'];
					 $out["address"] = $row['address'];
                     // array_push($out, $row['uname']);
                     // array_push($out, $row['text']);
                    array_push($messageResult, $out);
                    $j++;
                }
            }
        }
       
?>              

    <div class="search-results-container" id="users-container">
        <center><h2>Search From Users</h2></center>
        <?php foreach ($usersResult as $user){?>
        <div class="user-result info-container">
            <a href="other_user.php?otheruname=<?php echo "$user"; ?>"><?php echo "$user"; ?></a>
        </div>        
        <?php } ?>
    </div>
     <div class="search-results-container" id="photos-container">
         <center><h2>Search From Photos</h2></center>
        <?php 
        foreach ($photoResult as $photo){?>
        <div class="photo-result">
           <?php $uname = $photo["uname"];$pid = $photo["pid"];$caption = $photo["caption"];$time = $photo["timetaken"];$address = $photo["address"]; 
           $uname = "<a href='other_user.php?otheruname=$uname'>$uname</a>";
           echo "$uname uploaded a photo <br/> Caption : $caption <br/>Date: $time <br/> Location : $address ";?>
            <div class="photo-image info-container"  >
                <img src="<?php echo "../images/userphotos/$pid" ?>" width="200" height="150" border="1" />
            </div>
               </div>
        <?php }?> 
     </div>
     <div class="search-results-container" id="messages-container">
         <center><h2>Search From Messages</h2></center>
        <?php foreach ($messageResult as $message){?>
        <div class="search-message-result">
           <?php $uname = $message['uname'];$caption = $message['caption'];$post =$message['post'];
           $time = $message['timetaken'];$address=$message["address"];
           $uname = "<a href='other_user.php?otheruname=$uname'>$uname</a>";
            echo "$uname uploaded a message <br/>Caption : $caption <br/>$post<br/>Date: $time <br/>Location : $address";?>
        </div>        
        <?php }?>
    </div>

    <!-- </div> -->
</div>
    <?php
    include 'leftnavbar.php';
    //include 'search_results_option_bar_right.php';
    ?>

<!-- <script type="text/javascript" charset="utf-8">
$('div[id ^="user_search_"]').click(function(){
var friendName = $(this).html();
//        alert(friendName);
var myform = document.createElement("form");
myform.method = "get";
myform.action = "home.php";
var myinput = document.createElement("input");
myinput.setAttribute("friendname",friendName);
myform.appendChild(myinput);
document.body.appendChild(myform);
myform.submit();

});

</script> -->


<?php }?>