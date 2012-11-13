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

    $target = "../images/userphotos/";
    //$target = "C:\\wamp2\\www\\tourini\\images\\userphotos\\";

    $query = "select max(pid) as pid from project.photos";
    $result = executeQuery($query);
    $row = mysql_fetch_array($result);

    // $pid = $result[0];
    $pid = $row['pid'];

    //query to pull out max pid and then adding it by one and assigning it to the name variable
    $target = $target . basename($pid);

    //$pic=($_FILES['photo'][$pid]);

    $query = "insert into project.photos(uname,pname,timetaken,time_uploaded,caption,photo)
				values('$uname','$pname',NOW(),NOW(),'$caption','$target')";
    //echo "$query";
    $query = executeQuery($query);

    //Writes the photo to the server
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
        $uploaded = TRUE;
        //Tells you if its all ok
        // echo "The file ". basename( $_FILES['uploadedfile']['name']). " has been uploaded,
        // and your information has been added to the directory";
        // echo "file has been uploaded";

?>
<div id="central_container">
	<h2>YOUR PHOTO HAS BEEN UPLOADED</h2>
</div>
<?php
} else {

echo "Sorry, there was a problem uploading your file.";
}
}
?>
<div id="central_container">
	<div id="user-location-main-container">
		<div id="upload_photo_form_div" >
			<form id="upload_photo_form" name="user_location" action="#" method="post" enctype="text/plain" style="margin-right: 40%">
				<div id="location-label-container">
					<label >Location</label>
					<input type="text" name="map-address" id="map-address" readonly="true"/>
					<label>Latitude and Longitude</label>
					<input type="text" name="map-latlng" id="map-latlng" readonly="true"/>
				</div>	
				<input type="submit" value="Checkin" name="upload_photo_btn" id="upload_photo_btn"/>
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