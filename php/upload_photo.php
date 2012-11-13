<?php
include"header.php"
?>

<?php
$query = NULL;
if (isset($_POST['upload_photo_btn'])) {
    //include 'utils.php';
    $uname = $_SESSION['uname'];
    $caption = trim($_POST['caption']);
    $pname = trim($_POST['pname']);
if (isset($_POST['sharewith'])) {
		$circleList = $_POST['sharewith'];
	} else {
		$circleList = array("private");
	}
	$mapaddress = $_POST['map-address'];
	$maplatlng = $_POST['map-latlng'];
    $target = "../images/userphotos/";
    //$target = "C:\\wamp2\\www\\tourini\\images\\userphotos\\";

    $query = "select max(pid) as pid from project.photos";
    $result = executeQuery($query);
    $row = mysql_fetch_assoc($result);

    // $pid = $result[0];
    $pid = $row['pid'];
	$pid +=1;
    //query to pull out max pid and then adding it by one and assigning it to the name variable
    $target = $target . basename($pid);

    //$pic=($_FILES['photo'][$pid]);

	// check if location exists , if yes then get lid else create new lid
	$maplatlng = str_replace("(", "", $maplatlng);
	$maplatlng = str_replace(")", "", $maplatlng);
	list($lat, $long) = preg_split("(,)", $maplatlng);
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

    $query = "insert into project.photos(uname,pname,timetaken,timeuploaded,caption,photo,lid)
				values('$uname','$pname',NOW(),NOW(),'$caption','$target','$lid')";
    //echo "$query";
    $query = executeQuery($query);

	// update privacy information 
	// update privacy information
	foreach ($circleList as $circle) {
		//echo "$circle";
		// get circle id
		$query6 = "select circleid from project.circle_list where circlename = '$circle'";
		$query6 = executeQuery($query6);
		$row = mysql_fetch_assoc($query6);
		$circleid = $row['circleid'];
		$query7 = "INSERT INTO project.photo_privacy (pid,circleid)VALUES('$pid','$circleid')";
		$query7 = executeQuery($query7);
	}
	


    //Writes the photo to the server
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
        $uploaded = TRUE;
        //Tells you if its all ok
        // echo "The file ". basename( $_FILES['uploadedfile']['name']). " has been uploaded,
        // and your information has been added to the directory";
        // echo "file has been uploaded";
notify("Photo Uploaded Successfully");
?>
<!-- <div id="central_container">
	<h2>YOUR PHOTO HAS BEEN UPLOADED</h2>
</div> -->
<?php
} else {
notify("Sorry, there was a problem uploading your file.");
// echo "";
}
}
?>
<div id="central_container">
	<div id="photo-main-container" style="">
		<div id="upload_photo_form_div" >
			<form id="upload_photo_form" name="post_photo" action="#" method="post" enctype="multipart/form-data" style="margin-right: 40%">
				<label for="caption">Caption</label>
				<input type="text" name="caption" id="upload_photo_caption" size="40" placeholder="Enter a Caption" autocomplete="off"/>
				<label for="caption">Photo Name *</label>
				<input type="text" name="pname" id="upload_photo_name" size="40" required="true" placeholder="Enter a Name for the Picture" autocomplete="off"/>
				<div id="location-label-container">
					<label >Location</label>
					<input type="text" name="map-address" id="map-address" readonly="true" />
					<label>Latitude and Longitude</label>
					<input type="text" name="map-latlng" id="map-latlng" readonly="true"/>
				</div>
				<div id="upload_photo_div">
					<input type="file" name="photo" id="upload_photo_image" required="true"/>
				</div>
				<br />
				<label for="upload_message_circles">Select Circles to share with</label>
				<br/>
				<?php
				include 'sharewith.php';
				?>
				<br/>
				<br/>
				<input type="submit" value="Upload" name="upload_photo_btn" id="upload_photo_btn"/>
			</form>
		</div>
		<?php
		include_once 'maps.php';
		?>
	</div>
</div>
<?php
include 'leftnavbar.php'
?>