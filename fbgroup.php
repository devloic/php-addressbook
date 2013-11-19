<?php

include ("include/dbconnect.php");
include ("include/format.inc.php");
echo "<title>Facebook | Address Book</title>";
include ("include/header.inc.php");


echo "<h1>".ucfmsg('GROUPS')."</h1>";

if($read_only) {
	echo "<br /><div class='msgbox'>Editing is disabled.<br /><i>return to the <a href='fbgroup$page_ext'>group page</a></i></div>";
} else {
if($submit) {
	
	
		$sql = "INSERT INTO $table_fbgroups (gid)
		                           VALUES ($gid)";
		$result = mysql_query($sql);

		echo "<br /><div class='msgbox'>A new facebook group has been entered into the address book.<br /><i>return to the <a href='fbgroup$page_ext'>group page</a></i></div>";

// -- Add people to a group
} else if($new) {
?>
  <form accept-charset="utf-8" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<label>Facebook gid:</label>
  	<input type="text" name="gid" size="35" /><br />
	
	<input type="submit" name="submit" value="Enter information" />
  </form>
<?php
		
} else if($delete) {
	
	// Remove the groups
	foreach($selected as $group_id)
	{
		
		// Delete groups
		$sql = "delete from $table_fbgroups where id = $group_id";
		$result = mysql_query($sql);
	}
	echo "<div class='msgbox'>Group has been removed.<br /><i>return to the <a href='fbgroup$page_ext'>group page</a></i></div>";	
}
else if($update)
{
	$sql="SELECT * FROM $table_fbgroups WHERE id=$id";
	$result = mysql_query($sql);
	$resultsnumber = mysql_numrows($result);

	if($resultsnumber > 0)
	{
		$sql = "UPDATE $table_fbgroups SET gid=$gid".
				" WHERE id=$id";
				$result = mysql_query($sql);

				// header("Location: view?id=$id");

				echo "<br /><div class='msgbox'>Group record has been updated.<br /><i>return to the <a href='fbgroup$page_ext'>group page</a></i></div>";
} else {
	echo "<br /><div class='msgbox'>Invalid ID.<br /><i>return to the <a href='fbgroup$page_ext'>group page</a></i></div>";
}
}
// Open for Editing
else if($edit || $id)
{
  
  if($edit)
    $id = $selected[0];

    $result = mysql_query("select * from ".$table_fbgroups." where id=$id",$db);
    $myrow = mysql_fetch_array($result);

?>
	<form accept-charset="utf-8" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <input type="hidden" name="id" value="<?php echo $myrow['id']?>" />

		<label><?php echo ucfmsg('Facebook gid'); ?></label>
		<input type="text" name="gid" size="35" value="<?php echo $myrow['gid'];?>" />
    <br /><br />

		
		<br /><br class="clear" />

		<input type="submit" name="update" value="<?php echo ucfmsg('UPDATE'); ?>" />
	</form>
    <br />
  <?php

}

else
{
	$result = mysql_query("select * from ".$table_fbgroups);
	$resultsnumber = mysql_numrows($result);

?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  <input type="submit" name="new" value="<?php echo ucfmsg('NEW_GROUP'); ?>" />
	<input type="submit" name="delete" value="<?php echo ucfmsg('DELETE_GROUPS'); ?>" />
	<input type="submit" name="edit" value="<?php echo ucfmsg('EDIT_GROUP'); ?>" />

<hr />

<?php
	while ($myrow = mysql_fetch_array($result)) {
		echo "<input type='checkbox' name='selected[]' value='".$myrow['id']."' title='Select (".$myrow['gid'].")'/>";
		echo " <i>".$myrow['gid']."</i><br />";
		
	}	
?>
<br />
  <input type="submit" name="new" value="<?php echo ucfmsg('NEW_GROUP'); ?>" />
	<input type="submit" name="delete" value="<?php echo ucfmsg('DELETE_GROUPS'); ?>" />
	<input type="submit" name="edit" value="<?php echo ucfmsg('EDIT_GROUP'); ?>" />
</form>
<?php 
}
}
include ("include/footer.inc.php");
?>