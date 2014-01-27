<?php

include ("include/dbconnect.php");
include ("include/format.inc.php");
echo "<title>Groups | Address Book</title>";
include ("include/header.inc.php");
include ("include/photo.class.php");


echo "<h1>".ucfmsg('CLUBS')."</h1>";

//only allow root role
$login = AuthLoginFactory::getBestLogin ();;
$is_root=$login->hasRoles(array('root'));
if(!$is_root ) {
	echo "<br /><div class='msgbox'>Editing is disabled.<br /><i>return to the <a href='group$page_ext'>group page</a></i></div>";
} else {
if($submit) {

	if (isset ( $_FILES ["group_logo"] ) && $_FILES ["group_logo"] ["error"] <= 0) {
			
		$file_tmp_name = $_FILES ["group_logo"] ["tmp_name"];
		$file_name = $_FILES ["group_logo"] ["name"];
		$photo = new Photo ( $file_tmp_name );
		$photo->scaleToMaxSide ( 150 );
		$group_logo = $photo->getBase64 ();
	}
	else{
		$group_logo='';
	}
		$sql = "INSERT INTO $table_groups (domain_id, group_name, group_logo,group_header, group_footer,  group_parent_id,group_address,group_telmobile,group_telwork,group_twitter,group_facebook_page,group_facebook_group,group_website)
		                           VALUES ('$domain_id', '$group_name','$group_logo','$group_header','$group_footer','$group_parent_id','$group_address','$group_telmobile','$group_telwork','$group_twitter','$group_facebook_page','$group_facebook_group','$group_website')";
		$result = mysql_query($sql);

		echo "<br /><div class='msgbox'>A new group has been entered into the address book.<br /><i>return to the <a href='group$page_ext'>group page</a></i></div>";

// -- Add people to a group
} else if($new) {
?>
  <form accept-charset="utf-8" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<label>Group name:</label>
  	<input type="text" name="group_name" size="35" /><br /><br />
  	
  	 
    <div class="fileupload fileupload-new" data-provides="fileupload">
	  <div class="input-append">
	  <label class="control-label"><?php echo ucfmsg("CLUB_LOGO") ?>:</label>
	    <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Select Image</span><span class="fileupload-exists">Change</span><input type="file" name="group_logo" /></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
	  </div>
	</div>
	
<!-- 
		<label><?php echo ucfmsg('GROUP_PARENT'); ?></label>
		<select name="group_parent_id">
  	  <option value="0">[none]</option>
  	<?php
  		$sql="SELECT group_name, group_id
  		        FROM $groups_from_where
  		      ORDER BY lower(group_name) ASC;";
  
  		$result_groups = mysql_query($sql);
  		$result_gropup_snumber = mysql_numrows($result_groups);
  
  		//	has parent row in list been found?
  		$parent_found = false;
  		while ($myrow2 = mysql_fetch_array($result_groups))
  		{
  		echo "<option value=\"".$myrow2['group_id']."\">".$myrow2["group_name"]."</option>\n";
  		}
  	?>
   </select><br /><br /> 
-->
<input type="hidden" name="group_parent_id" value="none" />
     <!--  
     <label>Group header (Logo):</label>
	<textarea name="group_header" rows="10" cols="40"></textarea><br />

    <label>Group footer (Comment):</label>
	<textarea name="group_footer" rows="10" cols="40"></textarea><br /><br />
	--> 
	<input type="hidden" name="group_header" value="" />
	<input type="hidden" name="group_footer" value="" />
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("ADDRESS") ?>:</label>
		<div class="controls">
			<textarea name="group_address" rows="5" cols="35"></textarea>


		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("PHONE_MOBILE") ?>:</label>
		<div class="controls">
			<input type="text" name="group_telmobile"
				value="" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("PHONE_LINE") ?>:</label>
		<div class="controls">
			<input type="text" name="group_telwork" value="" />

		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("WEBSITE") ?>:</label>
		<div class="controls">
			<input type="text" name="group_website" value="" />

		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("FACEBOOK_PAGE") ?>:</label>
		<div class="controls">
			<input type="text" name="group_facebook_page" value="" />

		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("FACEBOOK_GROUP") ?>:</label>
		<div class="controls">
			<input type="text" name="group_facebook_group" value="" />

		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("TWITTER") ?>:</label>
		<div class="controls">
			<input type="text" name="group_twitter" value="" />

		</div>
	</div>
	
    <button class='btn btn-success' name='submit' type='submit'   value="Enter information">Enter information</button>
		
  </form>
<?php
		
} else if($delete) {
	
	// Remove the groups
	foreach($selected as $group_id)
	{
		// Delete links between addresses and groups
		$sql = "delete from $table_grp_adr where domain_id = $domain_id AND group_id = $group_id";
		$result = mysql_query($sql);

		// Delete groups
		$sql = "delete from $groups_from_where AND group_id = $group_id";
		$result = mysql_query($sql);
	}
	echo "<div class='msgbox'>Group has been removed.<br /><i>return to the <a href='group$page_ext'>group page</a></i></div>";	
}
else if($add)
{
	// Lookup for the group_id
	$sql = "select * from $groups_from_where AND group_name = '$to_group'";

	$result = mysql_query($sql);

	$myrow = mysql_fetch_array($result);
	$group_id   = $myrow["group_id"];
	$group_name = $myrow["group_name"];

	// Add people to the group, who are not alread in the group!
	if(isset($selected)){
		foreach($selected as $user_id)
	  {
		
		  $sql = "insert into $table_grp_adr (domain_id, id, group_id, created, modified) 
		                              values ($domain_id, $user_id, $group_id, now(), now())";
		  $result = mysql_query($sql);
	  }
  	  echo "<div class='msgbox'>Users added.<br /><i>Go to <a href='./?group=$group_name'>group page \"$group_name\"</a>.</i></div>";
	} else {
  	  echo "<div class='msgbox'><i>No users selected.<br />Please use the checkbox to select a user.</i></div>";
	}
}
// -- Remove people from a group
else if($remove)
{
	// Lookup for the group_id
	$sql = "select * from $table_groups where group_name = '$group'";

	$result = mysql_query($sql);
	// $resultsnumber = mysql_numrows($result);

	$myrow = mysql_fetch_array($result);
	$group_id   = $myrow["group_id"];
	$group_name = $myrow["group_name"];

	// Remove people from the group, who are not alread in the group!
	foreach($selected as $user_id)
	{
		
		$sql = "delete from $table_grp_adr where id = $user_id AND group_id = $group_id";
		$result = mysql_query($sql);
	}
	
	echo "<div class='msgbox'>Users removed. <br /><i>return to <a href='./?group=$group_name'>group page \"$group_name\"</a>.</i></div>";
}
else if($update)
{
	$sql="SELECT * FROM $table_groups WHERE group_id=$id";
	$result = mysql_query($sql);
	$resultsnumber = mysql_numrows($result);
	
	if (isset ( $_FILES ["group_logo"] ) && $_FILES ["group_logo"] ["error"] <= 0) {
			
		$file_tmp_name = $_FILES ["group_logo"] ["tmp_name"];
		$file_name = $_FILES ["group_logo"] ["name"];
		$photo = new Photo ( $file_tmp_name );
		$photo->scaleToMaxSide ( 150 );
		$group_logo = $photo->getBase64 ();
		
	}
	else{
		$group_logo='';
	}
	if($resultsnumber > 0)
	{
		if (!isset($group_parent_id) || !is_numeric($group_parent_id)  )
			$gpid='null';
		else
			$gpid=$group_parent_id;
		$sql = "UPDATE $table_groups SET group_name='$group_name'".
                                               ", group_header='$group_header'".
                                               ", group_footer='$group_footer'". 
                                               ", group_parent_id=$gpid".
                                               ", group_logo='$group_logo'".
                                               ", group_address='$group_address'".
                                               ", group_telmobile='$group_telmobile'".
                                               ", group_telwork='$group_telwork'".
                                               ", group_facebook_group='$group_facebook_group'".
                                               ", group_facebook_page='$group_facebook_page'".
                                               ", group_twitter='$group_twitter'".
                                               ", group_website='$group_website'".
                                             " WHERE group_id=$id";
		$result = mysql_query($sql);

		// header("Location: view?id=$id");		

		echo "<br /><div class='msgbox'>Group record has been updated.<br /><i>return to the <a href='group$page_ext'>group page</a></i></div>";
	} else {
		echo "<br /><div class='msgbox'>Invalid ID.<br /><i>return to the <a href='group$page_ext'>group page</a></i></div>"; 
	}
}
// Open for Editing
else if($edit || $id)
{
  if($edit)
    $id = $selected[0];

    $result = mysql_query("$select_groups AND groups.group_id=$id",$db);
    $myrow = mysql_fetch_array($result);

?>
	<form accept-charset="utf-8" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <input type="hidden" name="id" value="<?php echo $myrow['group_id']?>" />

		<label><?php echo ucfmsg('CLUB_NAME'); ?></label>
		<input type="text" name="group_name" size="35" value="<?php echo $myrow['group_name'];?>" />
    <br /><br />
    
    <div class="fileupload fileupload-new" data-provides="fileupload">
	  <div class="input-append">
	  <label class="control-label"><?php echo ucfmsg("CLUB_LOGO") ?>:</label>
	    <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Select Image</span><span class="fileupload-exists">Change</span><input type="file" name="group_logo" /></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
	  </div>
	</div>
	<?php
	$sql = "SELECT group_logo FROM $table_groups WHERE group_id = $id";
	$result = mysql_query($sql);
	$r = mysql_fetch_array($result);
	if ($r['group_logo'] !== ''){
		?>
		<img style="position:relative;left:180px;margin-bottom:20px" src="group_photo.php?id=<?php echo  $myrow['group_id']; ?>" />
		<?php  } ?>
	
<!-- 
		<label><?php echo ucfmsg('GROUP_PARENT'); ?></label>
		<select name="group_parent_id">
				<?php
					$sql="SELECT group_name, group_id
					        FROM $table_groups 
					       WHERE group_id != $id
					      ORDER BY lower(group_name) ASC;";

					$result_groups = mysql_query($sql);
					$result_gropup_snumber = mysql_numrows($result_groups);

					//	has parent row in list been found?
					$parent_found = false;
					while ($myrow2 = mysql_fetch_array($result_groups))
					{
						//	look for selected parent
						if ($myrow['group_parent_id'] == $myrow2['group_id']) {
							$selected_text = ' selected';
							$parent_found = true;
						} else {
							//	not found, reset selected text
							$selected_text = '';
						}

						//	parent option
						echo "<option value=\"".$myrow2['group_id']."\"$selected_text>".$myrow2["group_name"]."</option>\n";
					}
					//	if no matching parent found, default to none
					if (!$parent_found)
						$selected_text = ' selected';
					else
						$selected_text = '';
					//	none option
					echo "<option value=\"none\"$selected_text>[none]</option>\n";
				?>
			</select>
		<br /><br class="clear" />
 -->	
 	<input type="hidden" name="group_parent_id" value="none" />
 	
		<!-- 
		<label><?php echo ucfmsg('CLUB_HEADER'); ?>:</label>
		<textarea name="group_header" rows="10" cols="40"><?php echo $myrow["group_header"]?></textarea><br />

		<label><?php echo ucfmsg('CLUB_FOOTER'); ?>:</label>
		<textarea name="group_footer" rows="10" cols="40"><?php echo $myrow["group_footer"]?></textarea><br /><br />
		 -->
		 
		 	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("ADDRESS") ?>:</label>
		<div class="controls">
			<textarea name="group_address" rows="5" cols="35"><?php echo $myrow["group_address"]?></textarea>


		</div>
	</div>
		 <div class="control-group">
		<label class="control-label"><?php echo ucfmsg("PHONE_MOBILE") ?>:</label>
		<div class="controls">
			<input type="text" name="group_telmobile"
				value="<?php echo $myrow['group_telmobile']?>" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("PHONE_LINE") ?>:</label>
		<div class="controls">
			<input type="text" name="group_telwork" value="<?php echo $myrow['group_telwork']?>" />

		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("WEBSITE") ?>:</label>
		<div class="controls">
			<input type="text" name="group_website" value="<?php echo $myrow['group_website']?>" />

		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("FACEBOOK_PAGE") ?>:</label>
		<div class="controls">
			<input type="text" name="group_facebook_page" value="<?php echo $myrow['group_facebook_page']?>" />

		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("FACEBOOK_GROUP") ?>:</label>
		<div class="controls">
			<input type="text" name="group_facebook_group" value="<?php echo $myrow['group_facebook_group']?>" />

		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("TWITTER") ?>:</label>
		<div class="controls">
			<input type="text" name="group_twitter" value="<?php echo $myrow['group_twitter']?>" />

		</div>
	</div>
		 
		 <input type='hidden' name="group_header" value='' />
		  <input type='hidden' name="group_footer" value='' />
		  <button class='btn btn-success' name='update' type='submit'   value="<?php  echo ucfmsg("UPDATE"); ?>"><?php echo ucfmsg('UPDATE'); ?></button>
		
	</form>
    <br />
  <?php

}
else
{
	$result = mysql_query($select_groups." ORDER BY groups.group_name");
	$resultsnumber = mysql_numrows($result);

?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<button class='btn btn-success' name='new' type='submit'   value="<?php  echo ucfmsg("NEW_CLUB"); ?>"><?php echo ucfmsg('NEW_CLUB'); ?></button>
<button class='btn btn-danger' onclick="return confirm('<?php  echo ucfmsg("DELETE_CLUB"); ?>?')" name='delete' type='submit'   value="<?php  echo ucfmsg("DELETE_CLUB"); ?>"><?php echo ucfmsg('DELETE_CLUB'); ?></button>
<button class='btn btn-success' name='edit' type='submit'   value="<?php  echo ucfmsg("EDIT_CLUB"); ?>"><?php echo ucfmsg('EDIT_CLUB'); ?></button>
  

<hr />

<?php
	while ($myrow = mysql_fetch_array($result)) {
		echo "<input type='checkbox' style='margin:0px 7px;' name='selected[]' value='".$myrow['group_id']."' title='Select (".$myrow['group_name'].")'/>";
		if($myrow['parent_name'] != "") {
			echo $myrow['group_name']." <i>(".$myrow['parent_name'].")</i><br />";
		} else {
			echo $myrow['group_name']."<br />";
		}
	}	
?>
<br />

  <button class='btn btn-success' name='new' type='submit'   value="<?php  echo ucfmsg("NEW_CLUB"); ?>"><?php echo ucfmsg('NEW_CLUB'); ?></button>
<button class='btn btn-danger'  name='delete' onclick="return confirm('<?php  echo ucfmsg("DELETE_CLUB"); ?>?')" type='submit'   value="<?php  echo ucfmsg("DELETE_CLUB"); ?>"><?php echo ucfmsg('DELETE_CLUB'); ?></button>
<button class='btn btn-success' name='edit' type='submit'   value="<?php  echo ucfmsg("EDIT_CLUB"); ?>"><?php echo ucfmsg('EDIT_CLUB'); ?></button>

</form>
<?php 
}
}
include ("include/footer.inc.php");
?>