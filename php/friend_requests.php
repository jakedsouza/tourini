<?php include"header.php"
?>

<style type="text/css" media="screen">

	.friendbox {
            font-size: larger;
		background-color: whitesmoke;
		width: auto;
		height: auto;
		border-radius: 8px;
		border-style: solid;
		border-width: 1px;
		border-color: #D4D1BF;
		overflow: hidden;
		
	}
	.friendbox:hover {
		border-color: #0e224a;
		background-color: threedhighlight;
		
	}
</style>
<script>
   $(".add-friend-button").live("click",function(){
       var name = $(this).parent().text() ;
        notify("Accepted friend request from " +name );
        $.ajax({
            type : 'POST',
            url : 'home_model.php',
            data : {
                'request' : 'addFriendToTable',
                'friendname': name               
            },
            success : function(output) {
                $(this).parent().hide("slow");
               
            }
   })})
</script>
<div id="central_container">
    <h2><center>You have the following friend requests</center></h2>    
<div class="friendbox">
    <ol>
<?php 
    $friendRequests = getFriendRequestsList($uname);
   // var_dump($friendRequests);
    
    foreach ($friendRequests as $friendName){
    
    ?><li>
    <?php echo "$friendName " ;?>
        <input class="add-friend-button" type="button" value="Add" style="margin-left: 20px;margin-right: 10%" name='<?php echo "$friendName"?>' />
    </li>
    <?php }?>
        </ol>
    </div>
</div>
	
<?php
include 'leftnavbar.php';
?>
</div>
</body> </html>