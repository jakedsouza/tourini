<?php include"header.php"
?>
<?php $query = NULL;
if (isset($_POST['upload_message_btn'])) {
	//include 'utils.php';
	$uname = $_SESSION['uname'];
	$caption = trim($_POST['caption']);
	$text = trim($_POST['post_text']);
	if (isset($_POST['sharewith'])) {
		$circleList = $_POST['sharewith'];
	} else {
		$circleList = array("private");
	}
	$mapaddress = $_POST['map-address'];
	$maplatlng = $_POST['map-latlng'];
	//   var_dump($circleList);

	// insert message into db
	$query1 = "insert into project.message(uname,time_upload,caption,post)values('$uname',NOW(),'$caption','$text')";
	//echo "$query1";
	$query1 = executeQuery($query1);

	// get mid
	$query2 = "select mid from message where uname = '$uname' and caption = '$caption' and post = '$text' order by time_upload desc ";
	$query2 = executeQuery($query2);
	$row = mysql_fetch_assoc($query2);
	$mid = $row['mid'];
	//	echo "MID = $mid";
	$maplatlng = str_replace("(", "", $maplatlng);
	$maplatlng = str_replace(")", "", $maplatlng);
	list($lat, $long) = preg_split("(,)", $maplatlng);
	//    echo "Lat = $lat Lng=$long ";

	// check if location is present in dbase if yes get lid else insert new row and get new lid
	$query3 = "select lid from location_info where latitude = '$lat' and longitude = '$long'";
	//echo "$query3";
	$query3 = executeQuery($query3);
	if (mysql_num_rows($query3) > 0) {
		//echo "location exists using that one";
		$row = mysql_fetch_assoc($query3);
		$lid = $row['lid'];
	} else {
		$query4 = "INSERT INTO project.location_info (longitude,latitude,address)VALUES('$long','$lat','$mapaddress')";
		executeQuery($query4);
		$query3 = "select lid from location_info where latitude = '$lat' and longitude = '$long'";
		$query3 = executeQuery($query3);
		$row = mysql_fetch_assoc($query3);
		$lid = $row['lid'];
		//echo "location does not exist  creating a new one ";
	}

	//echo "LID = $lid";

	// update lid in message table ;
	$query5 = "UPDATE project.message SET lid = '$lid' WHERE mid = $mid";
	executeQuery($query5);

	// update privacy information
	foreach ($circleList as $circle) {
		//echo "$circle";
		// get circle id
		$query6 = "select circleid from project.circle_list where circlename = '$circle'";
		$query6 = executeQuery($query6);
		$row = mysql_fetch_assoc($query6);
		$circleid = $row['circleid'];
		$query7 = "INSERT INTO project.message_privacy (mid,circleid)VALUES('$mid','$circleid')";
		$query7 = executeQuery($query7);
	}
	notify("Message Uploaded Successfully");
}
?>
<div id="central_container">
	<form id="upload_message_form" name="post_message" action="#" method="post">
		<label for="caption">Caption *</label>
		<br/>
		<input type="text" name="caption" id="upload_message_caption" size="50" required="true"/>
		<br/>
		<br/>
		<label for="upload_message_textarea">Post</label>
		<br/>
		<div id="upload_message_textarea_div">
			<textarea id="upload_message_textarea" name="post_text" cols="40" rows="10" ></textarea>
		</div>
		<div id="location-label-container">
			<label >Location</label>
			<br/>
			<input type="text" name="map-address" id="map-address" readonly="true"/>
			<br/>
			<label>Latitude and Longitude</label>
			<br/>
			<input type="text" name="map-latlng" id="map-latlng" readonly="true"/>
			<br/>
		</div>
		<br/>
		<br/>
		<label for="upload_message_circles">Select Circles to share this with</label>
		<br/>
		<?php
		include 'sharewith.php';
		?>

		<br/>
		<br/>
		<input type="submit" value="Upload" name="upload_message_btn"/>
	</form>
	<?php
if ($query == true) {
	?>
	<h2>Successfully uploaded</h2>
	<?php } elseif ($query == false && $query !=NULL) {?>
	<h2>Error occured</h2>
	<?php }?>
	<?php
	include_once 'maps.php';
	?>
</div>
<?php
	include 'leftnavbar.php';
?>

</div>
</body> </html>