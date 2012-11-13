<?php include"header.php" ?>

<?php
$uname = $_SESSION['uname'];
$queryGetUserFriends = "select to_name from friendship where from_name = '$uname' and isaccepted = 1 ";
$queryGetUserCircles = "select distinct circlename from circle_list cl , friendship f , user_circles uc where cl.circleid = uc.circleid and uname = '$uname' order by circlename ";
echo "$queryGetUserCircles";
$queryGetUserFriends = executeQuery($queryGetUserFriends);
$queryGetUserCircles = executeQuery($queryGetUserCircles);
?>
<div id="central_container">
    <div id="friends_container">
        Friends
        <?php while ($row = mysql_fetch_assoc($queryGetUserFriends)) {
            ?>
            <?php $friendName = $row['to_name'];
            echo "$friendName"; ?>

        <input type="checkbox" class="friends_selected" name='<?php echo "$friendName";?>'/> 
           
        <?php } ?>
            </input>
    </div>
    <div id="circles_container">
        Circles
        <select id="circlelist">
            <?php while ($row = mysql_fetch_assoc($queryGetUserCircles)) {
                ?>

                    <?php $circleName = $row['circlename']; ?>
                <?php echo "$circleName"; ?>			
                <option value='<?php echo "$circleName"; ?>'><?php echo "$circleName"; ?></option>
            <?php } ?>		
        </select>
        <button id="add_friends">Add to circle</button>
        <button id="view_friends">View Friends in circle</button>
    </div>

    <div id="friends_in_circle" >
        This is hidden untill user clicks on view friends , then a list of all friends appear with checkboxes untill user selects
        remove from circle 
    </div>	
</div>

<script>
    
    $('#add_friends').click(function(){
        
        $("#friends_container :checked").each(function()
        {
            alert($(this).attr('name'));
        });
        alert($('#circlelist').val());       
        
    });


</script>


<?php
include 'leftnavbar.php';
?>
















<?php include"header.php"
?>
<script type="text/javascript" charset="utf-8">
	$(function() {
		$('div.user_circle').selectable();
	});
</script>
<style type="text/css" media="screen">
	#selected_circle_container {
		margin-bottom: 2%;
		margin-left: 0%;
		margin-right: 8%;
		font-family: Palatino Linotype;
		font-size: 24px;
		text-transform: capitalize;
		background-color: #f2f2f2;
		border-color: #000000;
		border-style: solid;
		border-width: 1px;
		border-radius: 4px;
		overflow: auto;
		overflow-style: marquee-block;
		font-smooth: always;
	}
	#user_circle_container {
		margin-bottom: 2%;
		font-family: Palatino Linotype;
		font-size: 24px;
		text-transform: capitalize;
		background-color: #f2f2f2;
		border-color: #000000;
		border-style: solid;
		border-width: 1px;
		border-radius: 4px;
		overflow: auto;
		overflow-style: marquee-block;
		font-smooth: always;
	}
	/*div.selected_circle{
		height: 40px;
		width: 80px;
		float: left;
		border: 2px solid #666666;
		background-color: #CCCCCC;
		margin-right: 5px;
		margin-bottom: 5px;
		margin-top: 5px;
		-webkit-border-radius: 10px;
		-ms-border-radius: 10px;
		-moz-border-radius: 10px;
		border-radius: 10px;
		-webkit-box-shadow: inset 0 0 3px #000;
		-ms-box-shadow: inset 0 0 3px #000;
		box-shadow: inset 0 0 3px #000;
		text-align: center;
		cursor: move;
	}*/
	/*div.selected_circle :hover {
		background-color: #BCD5E6;
	}*/
	#user_circle_container div {
		width: 100px;
		height: 100px;
		display: inline-block;
		overflow: hidden;
		border-radius: 66px;
		-moz-border-radius: 66px;
		-webkit-border-radius: 66px;
		-khtml-border-radius: 66px;
		border: #ccc 4px double;
		font-size: 20px;
		color: #888;
		line-height: 100px;
		text-shadow: 0 1px 0 #fff;
		text-decoration: none;
		text-align: center;
		background: #ddd
	}
	#user_circle_container div:hover {
		border: #1B75BB 4px solid;
		color: #aaa;
		text-decoration: none;
		background: #e6e6e6
	}
	
	
	div.selected_circle .ui-selecting { background: #FECA40; }
	div.selected_circle .ui-selected { background: #F39814; color: white; }
	div.selected_circle { list-style-type: none; margin: 0; padding: 0; }
	div.selected_circle li { margin: 3px; padding: 1px; float: left; width: 100px; height: 80px; font-size: 4em; text-align: center; }
</style>
<div id="central_container">
	<?php $uname = $_SESSION['uname'];
	$queryGetUserFriends = "select uname from users";
	$queryGetUserCircles = "select uname from users";
	$queryGetUserFriends = executeQuery($queryGetUserFriends);
	$queryGetUserCircles = executeQuery($queryGetUserCircles);
	?>

	<div id="user_friends"  unselectable="true">
		<div class="user_friend_entry"  draggable="true"></div>
	</div>
	<div id="user_circle_container" >
		<center>
			Circles
		</center>
		<div id="new_circle" >
			New Circle
		</div>
		<?php while($row = mysql_fetch_assoc($queryGetUserCircles)){
		?>
		<div class="user_circle">
			<?php $circlename = $row['uname'];
			echo "$circlename";
			?>
		</div>
		<?php }?>
	</div>
	<div id="selected_circle_container" >
		
	</div>
	<div id="create_circle"></div>
</div>
<script type="text/javascript" charset="utf-8">
    $('div.user_circle').click(function() {
//        $.ajax({
//            url : 'getFriends.php',
//            data : {
//                circle : $(this).html()
//            },
//            type : 'post',
//            success : function(output) {
//                $('#selected_circle_container').html(output);
//                makeSelectable();
//            }
//        });
    });
</script>
<?php
include 'leftnavbar.php';
?>

\

	
