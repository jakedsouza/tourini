<head>
<script src="js/jquery.tools.min.js"></script> 
<!-- <link rel="stylesheet" type="text/css" href="../css/form.css"/> --><link rel="stylesheet" type="text/css" href="../css/style.css"/>
<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen"/>
		<script type="text/javascript" src="../js/main.js"></script>
		<script type="text/javascript" src="../js/jquery-1.7.2.js"></script>
		<script type="text/javascript" src="../js/jquery.tools.min.js"></script>
		<script type="text/javascript" src="../js/jquery-ui-1.8.19.custom.min.js"></script>
	<style type="text/css" media="screen">
		
/* form style */
#reg_form {
    
    padding:15px 20px;
    color:#000000;
    width:300px;
    height:auto;
    margin:0 auto;
    position:relative;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border: #000000;
    border-radius:4px;
    border-style: solid;
    border-width: 1px; 
}

/* nested fieldset */
#reg_form fieldset {
    border:0;
    margin:0;
    padding:0;
   
}

/* typography */
#reg_form h3 { color:#000000; margin-top:0px; }
#reg_form p { font-size:11px; }


/* input field */
#reg_form input {
    border:1px solid #444;
    background-color:#ffffff;
    padding:5px;
    color:#000000;
    font-size:14px;

    /* CSS3 spicing */

    -moz-border-radius:4px;
    -webkit-border-radius:4px;
}

#reg_form input:focus { background-color:#ffff00; }

#reg_form label{
	font-size: 14px;
	color: #000000;
}

/* button */
#reg_form button {
    outline:0;
    border:1px solid #666;
}


/* error message */
.error {

   margin-top: 10px;
    
    border:1px solid #FF3300;
    padding:4px 10px;
    color:#DE4343;
   
    -moz-border-radius:4px;
    -webkit-border-radius:4px;
    -moz-border-radius-bottomleft:0;
    -moz-border-radius-topleft:0;
    -webkit-border-bottom-left-radius:0;
    -webkit-border-top-left-radius:0;

    -moz-box-shadow:0 0 6px #ddd;
    -webkit-box-shadow:0 0 6px #ddd;
}

.error p {
    margin:0;
}

/* field label */
label {
    display:block;
    font-size:11px;
    color:#ccc;
}

#terms label {
    float:left;
}

#terms input {
    margin:0 5px;
}

#registerlink{
	background: transparent ;
	display: inline;
	font-size:small;
	margin: 0 auto;	
	overflow: hidden;
	text-indent: -999em;	
	cursor: pointer
}

#registerlink a:hover{
	color: #008000;
	background: #000000;
}

	</style>



<form id="reg_form" name="register_form" action="#" method="get">
  <fieldset>
    <h2>Registration Form</h2>
     
    <p>
      <label>Email *</label>
      <input type="email" name="email" required="required" />
    </p>
	 <p>
      <label>Name *</label>
      <input type="text" name="name"  maxlength="30" required="required" />
    </p>
    <p>
      <label>Password *</label>
      <input type="password" name="password" required="required" />
    </p>
     <p id="terms">
      <label>I accept the terms</label>
      <input type="checkbox" required="required" />
    </p>
    <button type="submit">Submit form</button>
    <button type="reset">Reset</button>
  </fieldset>
<?php
	
	if(isset($_GET['name'])){
		include 'utils.php';
	$uname = $_GET['name'];
	$pass = $_GET['password'];
	$email = $_GET['email'];
	register($uname, $pass, $email);	
	
}
	
	?>


</form>

<!-- <script>
$("#myform").validator();
</script> -->
	
</head>