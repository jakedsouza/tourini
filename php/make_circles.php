<?php include"header.php" ?>

<script type="text/javascript" charset="utf-8">
    
    
</script>


<div id="central_container">
	<!-- <div id="notification_container">
		
	</div> -->
    <div id="user-circles-container">
        <center>
            <h2>Your Circles</h2>
        </center>
        <div id="user-circle-placeholder"></div>
    </div>
    <div id="user_actions_container">
        <center> <h3>User Actions</h3> </center>
        <div id="user-action-new-circle-div">
            <button id="user-action-new-circle-btn" class="circle-action-btn">Create   </button>
            
        </div>
        <div id="user-action-remove-friends-div">
            <button id="user-action-remove-friends-btn" class="circle-action-btn">Remove Friends</button>
        </div> <div id="user-action-add-friends-div" class="circle-action-btn">
            <button id="user-action-add-friends-btn">Add Friends</button>
        </div>

    </div>
    <div id="user-friends-container">
        <center><h2></h2></center>
        <div id="user-friend_placeholder"></div>
    </div>
</div>


<div id="dialog-form" title="Create new circle">    
	<p class="validateTips">All form fields are required.</p>
    <form>
	<fieldset>
		<label for="new-circle-name">Circle Name</label>
		<input type="text" name="new-circle-name" id="new-circle-name" class="text ui-widget-content ui-corner-all" />
        </fieldset>
    </form>
</div>
<?php
include 'leftnavbar.php';
?>
</div>
</body>
</html> 