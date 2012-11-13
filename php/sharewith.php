<?php
$uname = $_SESSION['uname'];
$qry = "select distinct c.circlename as circlename from circle_list c, user_circles u where u.uname = '$uname' and u.circleid = c.circleid";
//echo "$qry";
$qry = executeQuery($qry);

?>
<script type="text/javascript" src="../js/jquery.multiselect.js"></script>

	
    <select id="sharewith" name="sharewith[]" multiple="multiple" class="share_with_class" >
<?php
while ($row = mysql_fetch_assoc($qry)) {
?>	
<option value=<?php echo "'$row[circlename]'";?> ><?php echo "$row[circlename]";?></option>		
<?php	
}

?>
</select>

<script>
$(document).ready(function(){
   $("#sharewith").multiselect({
   header: true
   
   }
   );
});

</script>