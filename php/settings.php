<?php include"header.php"
?>
<!-- dateinput styling -->

<style>
	.settings_form label{
float: left;  
width: 10em;  
margin-right: 1em;  
text-align: right;  

}
.settings_form input select{
        margin-left: .5em;
}
/* root element for tabs  */
/*ul.css-tabs {
        margin: 0 !important;
        padding: 0;
        height: 30px;
        border-bottom: 1px solid #666;
}
 single tab 
ul.css-tabs li {
        float: left;
        padding: 0;
        margin: 0;
        list-style-type: none;
}
 link inside the tab. uses a background image 
ul.css-tabs a {
        float: left;
        font-size: 13px;
        display: block;
        padding: 5px 30px;
        text-decoration: none;
        border: 1px solid #666;
        border-bottom: 0px;
        height: 18px;
        background-color: #efefef;
        color: #777;
        margin-right: 2px;
        position: relative;
        top: 1px;
        outline: 0;
        -moz-border-radius: 4px 4px 0 0;
}
ul.css-tabs a:hover {
        background-color: #F7F7F7;
        color: #333;
}
 selected tab 
ul.css-tabs a.current {
        background-color: #ddd;
        border-bottom: 1px solid #ddd;
        color: #000;
        cursor: default;
}
 tab pane 
.css-panes div {
        
        border: 1px solid #666;
        border-width: 0 1px 1px 1px;
        min-height: 150px;
        padding: 15px 20px;
        background-color: #ddd;
}*/
/* root element for tabs  */
ul.tabs {
    list-style:none;
    margin:0 !important;
    padding:0;
    border-bottom:1px solid #666;
    height:30px;
}

/* single tab */
ul.tabs li {
    float:left;
    text-indent:0;
    padding:0;
    margin:0 !important;
    list-style-image:none !important;
}

/* link inside the tab. uses a background image */
ul.tabs a {
    background: url(/media/img/tabs/blue.png) no-repeat -420px 0;
    font-size:11px;
    display:block;
    height: 30px;
    line-height:30px;
    width: 134px;
    text-align:center;
    text-decoration:none;
    color:#333;
    padding:0px;
    margin:0px;
    position:relative;
    top:1px;
}

ul.tabs a:active {
    outline:none;
}

/* when mouse enters the tab move the background image */
ul.tabs a:hover {
    background-position: -420px -31px;
    color:#fff;
}

/* active tab uses a class name "current". its highlight is also done by moving the background image. */
ul.tabs a.current, ul.tabs a.current:hover, ul.tabs li.current a {
    background-position: -420px -62px;
    cursor:default !important;
    color:#000 !important;
}

/* Different widths for tabs: use a class name: w1, w2, w3 or w2 */


/* width 1 */
ul.tabs a.s { background-position: -553px 0; width:81px; }
ul.tabs a.s:hover { background-position: -553px -31px; }
ul.tabs a.s.current  { background-position: -553px -62px; }

/* width 2 */
ul.tabs a.l { background-position: -248px -0px; width:174px; }
ul.tabs a.l:hover { background-position: -248px -31px; }
ul.tabs a.l.current { background-position: -248px -62px; }


/* width 3 */
ul.tabs a.xl { background-position: 0 -0px; width:248px; }
ul.tabs a.xl:hover { background-position: 0 -31px; }
ul.tabs a.xl.current { background-position: 0 -62px; }


/* initially all panes are hidden */
.panes {
/*    display:none;*/
}
</style>
<link rel="stylesheet" type="text/css" href="../css/dateinput.css"/>

<div id="central_container">
        <?php // code to get current user information
        $uname = $_SESSION['uname'];
        $query = "select uname,password,firstname,middlename,lastname,title,email,about from project.users where uname = '$uname'";
        $query = executeQuery($query);
        $user_data = mysql_fetch_array($query);
        //var_dump($user_data);
        $password = $user_data["password"];
        $fname = $user_data["firstname"];
        $mname = $user_data["middlename"];
        $lname = $user_data["lastname"];
        $title = $user_data["title"];
        $email = $user_data["email"];
        $about = $user_data["about"];

        // php code to add modified user information in database ,

        if (isset($_GET['save_changes'])) {
                $fname = $_GET["fname"];
                $mname = $_GET["mname"];
                $lname = $_GET["lname"];
                $title = $_GET["title"];
                $email = $_GET["email"];
                $about = $_GET["about"];

                $query = "UPDATE project.users SET      firstname = '$fname',middlename = '$mname',lastname = '$lname',title = '$title',
                        email = '$email',about = '$about' WHERE uname = '$uname';";
                $query = executeQuery($query);
                if ($query) {
                        $success = TRUE;
                } else {
                        $success = FALSE;
                }
        } 
        elseif (isset($_GET["passchange"])) {
                // Code to change password goes here
                // $oldpass = $_GET("oldpass");
                $oldpassword = $_GET["oldpass"];
                $oldpassword = sha1($oldpassword);
                if($password==$oldpassword)
                {
                        $newpass = $_GET["newpass"];
                        $conf_newpass = $_GET["conf_newpass"];
                        if($newpass=$conf_newpass)
                        {
                        $newpass = sha1($newpass);
                        $query = "UPDATE PROJECT.USERS SET password='$newpass' WHERE uname = '$uname'";
                        $query = executeQuery($query);
                        if ($query) {
                        $success1 = TRUE;
                        } else {
                                $success1 = FALSE;
                        }
                        }
                }               
                }

                ?>


        <!-- the tabs -->
<!--        <ul class="tabs" >
                <li>
                        <a href="#">Personal Information</a>
                </li>
                <li>
                        <a href="#">Change Password</a>
                </li>
              
        </ul>-->
        <!-- tab "panes" -->
        <div class="panes" id="panes">
                <div>
                        <form action="#" method="get" accept-charset="utf-8" id="personal_settings_form" class="settings_form">
                                <label for="uname" id="uname_label">Username</label>
                                <input type="text" name="uname" disabled="true" value="<?php echo "$uname";?>"  >
                                <br/>
                                <label for="title" id="title_label" >Title</label>
                                <select id="title" name="title" >
                                        <option value="Dr.">Dr.</option>
                                        <option value="Mr.">Mr.</option>
                                        <option value="Mrs.">Mrs.</option>
                                        <option value="Ms.">Ms.</option>
                                        <option value="Prof.">Prof.</option>
                                </select>
                                <br/>
                                <label for="fname" id="fname_label">First Name</label>
                                <input type="text" name="fname" value="<?php echo "$fname";?>"/>
                                <br/>
                                <label for="mname" id="mname_label">Middle Name</label>
                                <input type="text" name="mname" value="<?php echo "$mname";?>"/>
                                <br/>
                                <label for="lname" id="lname_label">Last Name</label>
                                <input type="text" name="lname" value="<?php echo "$lname";?>"/>
                                <br/>
                                <label for="email" id="email_label">Email ID</label>
                                <input type="email" name="email" value="<?php echo "$email";?>"/>
                                <br/>
                                <label for="dob" id="dob_label">Date of Birth</label>
                                <input type="date" name="dob" id="dob"/>
                                <br/>
                                <label for="about" id="about_label">About Me </label>
                                <br/>
                                <textarea name="about" rows="8" cols="40" ><?php echo "$about";?></textarea>
                                <br/>
                                <p>
                                        <center>
                                                <input type="submit" value="Save Changes" name="save_changes"/>
                                        </center>
                                </p>
                                <p>
                                        <?php
if (isset($success)) {
if ($success ) {
                                        ?>
                                        <h2>Profile successfully updated</h2>
                                        <?php } else {?>
                                        <h2>Error updating profile</h2><?php }

                                                }
                                        ?>
                                </p>
                
                </form>
                </div>
                <div>
                        <form action="#" method="get" accept-charset="utf-8" id="password_settings_form" class="settings_form">
                                <label for="oldpass" id="oldpass_label">Old Password</label>
                                <input type="password" name="oldpass" required="true"/>
                                <br/>
                                <label for="newpass" id="newpass_label" >New Password</label>
                                <input type="password" name="newpass" required="true"/>
                                <br/>
                                <label for="conf_newpass" id="conf_newpass_label" >Confirm New Password</label>
                                <input type="password" name="conf_newpass" required="true"/>
                                <br/>
                                <p>
                                        <center>
                                                <input type="submit" value="Change Password" name="passchange"/>
                                        </center>
                                </p>
                                <p>
                                        <?php
                                        if (isset($success1)) {
                                        if ($success1) {
                                        ?>
                                        <h2>Password successfully updated</h2>
                                        <?php }
                                        } else {?>
                                        <?php }
                                        ?>
                                </p>
                
                        </form>
                </div>
                     
        </div>
</div>



</div>

<script>
        // perform JavaScript after the document is scriptable.
        $(function() {
                // setup ul.tabs to work as tabs for each div directly under div.panes
                //$(".css-tabs").tabs(".css-panes > div");
              //  $("ul.tabs").tabs("div.panes > div");
        });
      $(document).ready(function(){
 //alert("S")
 $("ul.tabs").tabs("div.panes > div");
     
})

  $("#dob").dateinput();

</script>

