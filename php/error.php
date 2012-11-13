<!-- page to show multiple error messages -->
<html>
	<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen"/>
<?php
   $errorNumber = $_GET['e'];
   $errorMessage ="Unknown Error Occured Please try again later";
   switch ($errorNumber) {
       case 1:
           $errorMessage ="You Have not logged in . Click <a href='../php/login.php'>Here</a> to login or signup";
           break;       
       default:
           
           break;
   }   
?>
<body>
	<div id="central_container">
		<h1><?php echo "$errorMessage";?></h1>
	</div>
	
</body>

</html>