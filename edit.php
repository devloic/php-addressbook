<?php
include ("include/dbconnect.php");
include ("include/format.inc.php");
include ("include/photo.class.php");

if ($submit || $update) {
	?>
<meta HTTP-EQUIV="REFRESH" content="3;url=.">
<?php

}


$resultsnumber = 0;
if ($id) {
	
	$sql = "SELECT * FROM $base_from_where AND $table.id='$id'";
	$result = mysql_query ( $sql, $db );
	$r = mysql_fetch_array ( $result );
	
	$resultsnumber = mysql_numrows ( $result );
}

if (($resultsnumber == 0 && ! isset ( $all )) || (! $id && ! isset ( $all ))) {
	?><title>Address book <?php echo ($group_name != "" ? "($group_name)":""); ?></title><?php
	include ("include/header.inc.php");
} else {
	?><title><?php echo $r["firstname"].(isset($r['middlename']) ? " ".$r['middlename']:"")." ".$r["lastname"]." ".($group_name != "" ? "($group_name)":"")."\n"; ?></title><?php
	if (! isset ( $_GET ["print"] )) {
		include ("include/header.inc.php");
	} else {
		echo '</head><body>';
		// echo '</head><body onload="javascript:window.setTimeout(window.print(self), 1000)";>';
	}
}
?>
<h1><?php echo ucfmsg('EDIT_ADD_ENTRY'); ?></h1>
<?php
if ($submit) {
	
	if (! $read_only) {
		//
		// Primitiv filter against spam on "sourceforge.net".
		//
		if ($_SERVER ['SERVER_NAME'] == "php-addressbook.sourceforge.net") {
			
			$spam_test = $firstname . $middlename . $lastname . $address . $home . $mobile . $work . $email . $email2 . $email3 . $bday . $bmonth . $byear . $aday . $amonth . $ayear . $address2 . $phone2;
			$blacklist = array (
					'viagra',
					'seroquel',
					'zovirax',
					'ultram',
					'mortage',
					'loan',
					'accutane',
					'ativan',
					'gun',
					'sex',
					'porn',
					'arachidonic',
					'recipe',
					'comment1',
					'naked',
					'gay',
					'fetish',
					'domina',
					'fakes',
					'drugs',
					'methylphenidate',
					'nevirapine',
					'viramune' 
			);
			foreach ( $blacklist as $blackitem ) {
				if (strpos ( strtolower ( $spam_test ), $blackitem ) !== FALSE) {
					exit ();
				}
			}
			if (preg_match ( '/\D{3,}/', $home ) > 0 || preg_match ( '/\D{3,}/', $mobile ) > 0) {
				exit ();
			}
			if (strlen ( $home ) > 15 || strlen ( $mobile ) > 15) {
				exit ();
			}
		}
		
		$addr ['firstname'] = $firstname;
		$addr ['middlename'] = $middlename;
		$addr ['lastname'] = $lastname;
		$addr ['nickname'] = $nickname;
		$addr ['title'] = $title;
		$addr ['company'] = $company;
		$addr ['address'] = $address;
		$addr ['home'] = $home;
		$addr ['mobile'] = $mobile;
		$addr ['work'] = $work;
		$addr ['fax'] = $fax;
		$addr ['email'] = $email;
		$addr ['email2'] = $email2;
		$addr ['email3'] = $email3;
		$addr ['homepage'] = $homepage;
		$addr ['facebookusername'] = $facebookusername;
		$addr ['bday'] = $bday;
		$addr ['bmonth'] = $bmonth;
		$addr ['byear'] = $byear;
		$addr ['aday'] = $aday;
		$addr ['amonth'] = $amonth;
		$addr ['ayear'] = $ayear;
		$addr ['address2'] = $address2;
		$addr ['phone2'] = $phone2;
		$addr ['notes'] = $notes;
		$addr ['position_1'] = $position_1;
		$addr ['position_2'] = $position_2;
		$addr ['position_3'] = $position_3;
		$addr ['position_4'] = $position_4;
		$addr ['position_5'] = $position_5;
		$addr ['position_6'] = $position_6;
		$addr ['position_7'] = $position_7;
		$addr ['position_8'] = $position_8;
		$addr ['position_9'] = $position_9;
		$addr ['position_10'] = $position_10;
		$addr ['position_11'] = $position_11;
		$addr ['position_12'] = $position_12;
		$addr ['position_13'] = $position_13;
		$addr ['position_14'] = $position_14;
		$addr ['position_15'] = $position_15;
		
		
		if (isset ( $_FILES ["photo"] ) && $_FILES ["photo"] ["error"] <= 0) {
			
			$file_tmp_name = $_FILES ["photo"] ["tmp_name"];
			$file_name = $_FILES ["photo"] ["name"];
			$photo = new Photo ( $file_tmp_name );
			$photo->scaleToMaxSide ( 150 );
			$addr ['photo'] = $photo->getBase64 ();
		}
		
		if (isset ( $table_groups ) and $table_groups != "") {
			if (! $is_fix_group) {
				$g_name = $new_group;
			} else {
				$g_name = $group_name;
			}
			saveAddress ( $addr, $g_name );
			
			echo "<br /><div class='msgbox'>Information entered into address book.";
			echo "<br /><i><a href='edit$page_ext'>add next</a> or return to <a href='index$page_ext'>home page</a>.</i></div>";
		}
	} else
		echo "<br /><div class='msgbox'>Editing is disabled.</div>\n";
} else if ($update) {
	if (! $read_only) {
		$addr ['id'] = $id;
		$addr ['firstname'] = $firstname;
		$addr ['middlename'] = $middlename;
		$addr ['lastname'] = $lastname;
		$addr ['nickname'] = $nickname;
		$addr ['title'] = $title;
		$addr ['company'] = $company;
		$addr ['address'] = $address;
		$addr ['home'] = $home;
		$addr ['mobile'] = $mobile;
		$addr ['work'] = $work;
		$addr ['fax'] = $fax;
		$addr ['email'] = $email;
		$addr ['email2'] = $email2;
		$addr ['email3'] = $email3;
		$addr ['homepage'] = $homepage;
		$addr ['facebookusername'] = $facebookusername;
		$addr ['bday'] = $bday;
		$addr ['bmonth'] = $bmonth;
		$addr ['byear'] = $byear;
		$addr ['aday'] = $aday;
		$addr ['amonth'] = $amonth;
		$addr ['ayear'] = $ayear;
		$addr ['address2'] = $address2;
		$addr ['phone2'] = $phone2;
		$addr ['notes'] = $notes;
		$addr ['position_1'] = $position_1;
		$addr ['position_2'] = $position_2;
		$addr ['position_3'] = $position_3;
		$addr ['position_4'] = $position_4;
		$addr ['position_5'] = $position_5;
		$addr ['position_6'] = $position_6;
		$addr ['position_7'] = $position_7;
		$addr ['position_8'] = $position_8;
		$addr ['position_9'] = $position_9;
		$addr ['position_10'] = $position_10;
		$addr ['position_11'] = $position_11;
		$addr ['position_12'] = $position_12;
		$addr ['position_13'] = $position_13;
		$addr ['position_14'] = $position_14;
		$addr ['position_15'] = $position_15;
		
		$keep_photo = true;
		if (isset ( $delete_photo )) {
			$keep_photo = ! $delete_photo;
		}
		
		if (isset ( $_FILES ["photo"] ) && $_FILES ["photo"] ["error"] <= 0) {
			
			$file_tmp_name = $_FILES ["photo"] ["tmp_name"];
			$file_name = $_FILES ["photo"] ["name"];
			$photo = new Photo ( $file_tmp_name );
			$photo->scaleToMaxSide ( 150 );
			$addr ['photo'] = $photo->getBase64 ();
			$keep_photo = false;
		} else {
			$addr ['photo'] = '';
		}
		
		if (updateAddress ( $addr, $keep_photo )) {
			echo "<br /><div class='msgbox'>" . ucfmsg ( 'ADDRESS_BOOK' ) . " " . msg ( 'UPDATED' ) . "<br /><i>return to <a href='index$page_ext'>home page</a></i></div>";
		} else {
			echo "<br /><div class='msgbox'>" . ucfmsg ( 'INVALID' ) . " ID.<br /><i>return to <a href='index$page_ext'>home page</a></i></div>";
			echo "";
		}
	} else
		echo "<br /><div class='msgbox'>Editing is disabled.</div>\n";
} else if ($id) {
	if (! $read_only) {
		$result = mysql_query ( "SELECT * FROM $base_from_where AND $table.id=$id", $db );
		$myrow = mysql_fetch_array ( $result );
		?>

<form class="form-horizontal" enctype="multipart/form-data"
	accept-charset="utf-8" method="post" id="user_form"
	action="edit<?php echo $page_ext; ?>">

	<button class="btn btn-success" type="submit" class="update" name="update"
		value="<?php echo ucfmsg('UPDATE') ?>"><?php echo ucfmsg('UPDATE') ?></button>
	<input type="hidden" name="id"
		value="<?php echo isset($myrow['id']) ? $myrow['id'] : ''; ?>" />

	
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("FIRSTNAME") ?>:</label>
		<div class="controls">
			<input type="text" name="firstname" size="35"
				value="<?php echo $myrow['firstname']?>" />
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("MIDDLENAME") ?>:</label>
		<div class="controls">
			<input type="text" name="middlename" size="15"
				value="<?php echo $myrow['middlename']?>" />
			

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("LASTNAME") ?>:</label>
		<div class="controls">
			<input type="text" name="lastname" size="35"
				value="<?php echo $myrow['lastname']?>" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("NICKNAME") ?>:</label>
		<div class="controls">
			<input type="text" name="nickname" size="35"
				value="<?php echo $myrow['nickname']?>" />

		</div>
	</div>
	
	
		
	
	<div class="fileupload fileupload-new" data-provides="fileupload">
  <div class="input-append">
  <label class="control-label"><?php echo ucfmsg("PHOTO") ?>:</label>
    <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Select Image</span><span class="fileupload-exists">Change</span><input type="file" name="photo" /></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
  </div>
</div>

	<div class="control-group">
		<label class="control-label"><?php echo msg("DELETE") ?>:</label>
		<div class="controls">
			<input type="checkbox" name="delete_photo" />

		</div>
	</div>
	
	<div class="btn-group" data-toggle="buttons-checkbox">
	  <button type="button" class="btn btn-primary position" id="bposition_1">1 Pilar</button>
	  <input type="hidden" name="position_1" id="position_1" value="<?php echo $myrow['position_1']; ?>">
	  
	  <button type="button" class="btn btn-primary position" id="bposition_2">2 Hooker</button>
	  <input type="hidden" name="position_2" id="position_2" value="<?php echo $myrow['position_2']; ?>">
	  <button type="button" class="btn btn-primary position" id="bposition_3">3 Pilar</button>
	  <input type="hidden" name="position_3" id="position_3" value="<?php echo $myrow['position_3']; ?>">
	</div>
	<br/>
	<div class="btn-group" data-toggle="buttons-checkbox">
	  <button type="button" class="btn btn-primary position" id="bposition_4">4 Segunda linea</button>
	  <input type="hidden" name="position_4" id="position_4" value="<?php echo $myrow['position_4']; ?>">
	  <button type="button" class="btn btn-primary position" id="bposition_5">5 Segunda linea</button>
	  <input type="hidden" name="position_5" id="position_5" value="<?php echo $myrow['position_5']; ?>">
	 </div>
	<br/>
	<div class="btn-group" data-toggle="buttons-checkbox">
	  <button type="button" class="btn btn-primary position" id="bposition_6">6 Tercera linea ala</button>
	  <input type="hidden" name="position_6" id="position_6" value="<?php echo $myrow['position_6']; ?>">
	  <button type="button" class="btn btn-primary position" id="bposition_8" >8 Tercera linea</button>
	  <input type="hidden" name="position_8" id="position_8" value="<?php echo $myrow['position_8']; ?>">
	  <button type="button" class="btn btn-primary position" id="position_7">7 Tercera linea ala</button>
	  <input type="hidden" name="position_7" id="position_7" value="<?php echo $myrow['position_7']; ?>">
	 </div>
	 <br/><br/>
	<div class="btn-group" data-toggle="buttons-checkbox">
	  <button type="button" class="btn btn-primary position" id="bposition_9">9 Medio scrum</button>
	  <input type="hidden" name="position_9" id="position_9" value="<?php echo $myrow['position_9']; ?>">
	 </div>
	 <br/><br/>
	 <div class="btn-group" data-toggle="buttons-checkbox"  style="left:100px">
	  <button type="button" class="btn btn-primary position" id="bposition_10">10 Apertura</button>
	  <input type="hidden" name="position_10" id="position_10" value="<?php echo $myrow['position_10']; ?>">
	  <button type="button" class="btn btn-primary position" id="bposition_12" >12 Primer centro</button>
	  <input type="hidden" name="position_12" id="position_12" value="<?php echo $myrow['position_12']; ?>">
	  <button type="button" class="btn btn-primary position" id="bposition_13" >13 Segundo centro</button>
	  <input type="hidden" name="position_13" id="position_13" value="<?php echo $myrow['position_13']; ?>">
	 </div>
	 <br/><br/><br/>
	 <div class="btn-group" data-toggle="buttons-checkbox" style="left:50px">
	  <button type="button" class="btn btn-primary position" id="bposition_11">11 Wing izquierdo</button>
	  <input type="hidden" name="position_11" id="position_11" value="<?php echo $myrow['position_11']; ?>">
	  <button type="button" class="btn btn-primary position" id="bposition_15" >15 Fullback</button>
	  <input type="hidden" name="position_15" id="position_15" value="<?php echo $myrow['position_15']; ?>">
	  <button type="button" class="btn btn-primary position" id="bposition_14">14 Wing derecho</button>
	  <input type="hidden" name="position_14" id="position_14" value="<?php echo $myrow['position_14']; ?>">
	 </div>
	 <br/><br/><br/>
	 
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("COMPANY") ?>:</label>
		<div class="controls">
			<input type="text" name="company" size="35"
				value="<?php echo $myrow['company']?>" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("TITLE") ?>:</label>
		<div class="controls">
			<input type="text" name="title" size="35"
				value="<?php echo $myrow['title']?>" />

		</div>
	</div>
	
	
	
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("ADDRESS") ?>:</label>
		<div class="controls">
			<textarea name="address" rows="5" cols="35"><?php echo $myrow["address"]?></textarea>
			

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("TELEPHONE") ?></label>
		<div class="controls">
			
			<br class="clear" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("PHONE_HOME") ?>:</label>
		<div class="controls">
			<input type="text" name="home" value="<?php echo $myrow['home']?>" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("PHONE_MOBILE") ?>:</label>
		<div class="controls">
			<input type="text" name="mobile"
				value="<?php echo $myrow['mobile']?>" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("PHONE_WORK") ?>:</label>
		<div class="controls">
			<input type="text" name="work" value="<?php echo $myrow['work']?>" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("FAX") ?>:</label>
		<div class="controls">
			<input type="text" name="fax" value="<?php echo $myrow['fax']?>" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label">&nbsp;</label>
		<div class="controls">
			
			<br class="clear" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("EMAIL") ?>:</label>
		<div class="controls">
			<input type="text" name="email" size="35"
				value="<?php echo $myrow['email']?>" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("EMAIL") ?>2:</label>
		<div class="controls">
			<input type="text" name="email2" size="35"
				value="<?php echo $myrow['email2']?>" />

		</div>
	</div>
	
	
	
	
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("EMAIL") ?>3:</label>
		<div class="controls">
			<input type="text" name="email3" size="35"
				value="<?php echo $myrow['email3']?>" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("HOMEPAGE") ?>:</label>
		<div class="controls">
			<input type="text" name="homepage" size="35"
				value="<?php echo $myrow['homepage']?>" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("Facebook username");?>:</label>
		<div class="controls">
			<input type="text" name="facebookusername"
				value="<?php echo $myrow['facebookusername']?>" size="24" /> 
			

		</div>
		<?php echo '(ex: https://www.facebook.com/rugbylapazbolivia => rugbylapazbolivia)';?>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("BIRTHDAY") ?>:</label>
		<div class="controls">
			<select name="bday">
				<option value="<?php echo $myrow['bday']?>" selected="selected"><?php echo ($myrow["bday"] == 0?"-":$myrow["bday"]) ?></option>
				<option value="0">-</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
				<option value="24">24</option>
				<option value="25">25</option>
				<option value="26">26</option>
				<option value="27">27</option>
				<option value="28">28</option>
				<option value="29">29</option>
				<option value="30">30</option>
				<option value="31">31</option>
			</select> <select name="bmonth">
				<option value="<?php echo $myrow['bmonth'] ?>" selected="selected"><?php echo ucfmsg(strtoupper($myrow["bmonth"])); ?></option>
				<option value="-">-</option>
				<option value="January"><?php echo ucfmsg("JANUARY") ?></option>
				<option value="February"><?php echo ucfmsg("FEBRUARY") ?></option>
				<option value="March"><?php echo ucfmsg("MARCH") ?></option>
				<option value="April"><?php echo ucfmsg("APRIL") ?></option>
				<option value="May"><?php echo ucfmsg("MAY") ?></option>
				<option value="June"><?php echo ucfmsg("JUNE") ?></option>
				<option value="July"><?php echo ucfmsg("JULY") ?></option>
				<option value="August"><?php echo ucfmsg("AUGUST") ?></option>
				<option value="September"><?php echo ucfmsg("SEPTEMBER") ?></option>
				<option value="October"><?php echo ucfmsg("OCTOBER") ?></option>
				<option value="November"><?php echo ucfmsg("NOVEMBER") ?></option>
				<option value="December"><?php echo ucfmsg("DECEMBER") ?></option>
			</select> <input class="byear" type="text" name="byear" size="4"
				maxlength="4" value="<?php echo $myrow['byear']?>" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("ANNIVERSARY") ?>:</label>
		<div class="controls">
			<select name="aday">
				<option value="<?php echo $myrow['aday']?>" selected="selected"><?php echo ($myrow["aday"] == 0?"-":$myrow["aday"]) ?></option>
				<option value="0">-</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
				<option value="24">24</option>
				<option value="25">25</option>
				<option value="26">26</option>
				<option value="27">27</option>
				<option value="28">28</option>
				<option value="29">29</option>
				<option value="30">30</option>
				<option value="31">31</option>
			</select> <select name="amonth">
				<option value="<?php echo $myrow['amonth'] ?>" selected="selected"><?php echo ucfmsg(strtoupper($myrow["amonth"])); ?></option>
				<option value="-">-</option>
				<option value="january"><?php echo ucfmsg("january") ?></option>
				<option value="february"><?php echo ucfmsg("february") ?></option>
				<option value="march"><?php echo ucfmsg("march") ?></option>
				<option value="april"><?php echo ucfmsg("april") ?></option>
				<option value="may"><?php echo ucfmsg("may") ?></option>
				<option value="june"><?php echo ucfmsg("june") ?></option>
				<option value="july"><?php echo ucfmsg("july") ?></option>
				<option value="august"><?php echo ucfmsg("august") ?></option>
				<option value="september"><?php echo ucfmsg("september") ?></option>
				<option value="october"><?php echo ucfmsg("october") ?></option>
				<option value="november"><?php echo ucfmsg("november") ?></option>
				<option value="december"><?php echo ucfmsg("december") ?></option>
			</select> <input class="byear" type="text" name="ayear" size="4"
				maxlength="4" value="<?php echo $myrow['ayear']?>" />

<?php
		/*
		 * Group handling on change <label><?php echo ucfmsg("GROUP") ?>:</label> <div class="controls"> <?php if(isset($table_groups) and $table_groups != "" and !$is_fix_group) { ?> <select name="new_group"> <?php if($group_name != "") { echo "<option>$group_name</option>\n"; } $sql = "SELECT group_name FROM $table_groups ORDER BY lower(group_name) ASC"; $result_groups = mysql_query($sql); $result_gropup_snumber = mysql_numrows($result_groups); while ($myrow_group = mysql_fetch_array($result_groups)) { echo "<option>".$myrow_group["group_name"]."</option>\n"; } ?> </select> <?php } ?> 
		 */
		?>
    
		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><b><?php echo ucfmsg("SECONDARY") ?></b></label>
		<div class="controls">
			
			<br class="clear" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("ADDRESS") ?>:</label>
		<div class="controls">
			<textarea name="address2" rows="5" cols="35"><?php echo $myrow["address2"]?></textarea>
			

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("PHONE_HOME") ?>:</label>
		<div class="controls">
			<input type="text" name="phone2"
				value="<?php echo $myrow['phone2']?>" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("NOTES") ?>:</label>
		<div class="controls">
			<textarea name="notes" rows="5" cols="35"><?php echo $myrow["notes"]?></textarea><br/><br/>
			
			

			<button class="btn btn-success" type="submit" name="update"
				value="<?php echo ucfmsg('UPDATE') ?>"><?php echo ucfmsg('UPDATE') ?></button><br/><br/><br/>

</form>

<script type="text/javascript">
		
for (i = 1 ;i<=15;i++){
	if ($('#position_'+i).val() == '1'){
		$('#bposition_'+i).addClass('active');
	}
}

$('.position').on('click',function(e) {
	var index=$(this).attr('id').replace('bposition_','');
	
	if ($( this ).hasClass('active') ){
		$('#position_'+index).val("0");
		}else{
			$('#position_'+index).val("1");
		}
});


</script>


<form method="get" action="delete<?php echo $page_ext; ?>">
	<input type="hidden" name="id" value="<?php echo $myrow['id']?>" />
	<button class="btn btn-danger" type="submit" name="update"
		value="<?php echo ucfmsg('DELETE') ?>"><?php echo ucfmsg('DELETE') ?></button>

</form>
<?php
	} else
		echo "<div class='msgbox'>Editing is disabled.</div>";
} else if (! (isset ( $_POST ['quickskip'] ) || isset ( $_POST ['quickadd'] )) && (isset ( $_GET ['quickadd'] ) || isset ( $_POST ['quickadd'] ) || $quickadd)) {
	?>
<form accept-charset="utf-8" method="post" name="quickadd">
	
	<button class="btn btn-success" type="submit" name="quickadd"
		value="<?php echo ucfmsg('NEXT') ?>"><?php echo ucfmsg('NEXT') ?></button>

	<br/><br/>
	
			<label class="control-label"><?php echo ucfmsg("ADDRESS") ?>:</label>
			<textarea name="address" rows="20" tabindex="0"></textarea>
		<br/>	<br/>
			
		<button class="btn btn-success" type="submit" name="quickadd" value="<?php echo ucfmsg('NEXT') ?>"><?php echo ucfmsg('NEXT') ?></button>
		
</form>
<script type="text/javascript">
	  document.quickadd.address.focus();
	 
  </script>

<?php
} else {
	if (! $read_only) {
		
		if (isset ( $_POST ['quickadd'] )) {
			
			include_once ("include/guess.inc.php");
			$addr = guessAddressFields ( $address );
			// echo nl2br(print_r($addr, true));
		} else {
			$addr = array ();
		}
		?>
<script type="text/javascript">
<!--

last_proposal = "";

function proposeMail() {
  
  if(document.theform.email.value == last_proposal) {
  
    new_proposal = "";

    has_firstname = document.theform.firstname.value != "";
    has_middlename = document.theform.middlename.value != "";
    has_lastname  = document.theform.lastname.value  != "";
  
    if(has_firstname) {
      new_proposal = document.theform.firstname.value.toLowerCase().replace(/^\s+|\s+$/g, '');
    }
    if(has_firstname && (has_middlename || has_lastname)) {
      new_proposal += ".";
    }
    if(has_lastname) {
      new_proposal += document.theform.lastname.value.toLowerCase().replace(/^\s+|\s+$/g, '');
    }
    if(has_middlename) {
      new_proposal += document.theform.middlename.value.toLowerCase().replace(/^\s+|\s+$/g, '');
    }
    if(has_middlename && has_lastname) { // middlename cannot exsist without lastname in Dutch
      new_proposal += ".";
    }
    new_proposal += "@" + document.theform.company.value.toLowerCase().replace(/^\s+|\s+$/g, '');

    new_proposal = new_proposal.replace(/ /g, "-");
    document.theform.email.value = new_proposal;
    last_proposal = new_proposal;
    
  }
}
function ucfirst(str) {
  return str.slice(0,1).toUpperCase() + str.slice(1);
}
function ucf_arr(str_arr) {
  str_res = Array();
  for (var i = 0; i < str_arr.length; i++) {
    str_res[i] = ucfirst(str_arr[i]);
  }
  return str_res;
}

function trim(str, chars) {
  no_left = str.replace(new RegExp("^[" + chars + "]+", "g"), "");
  return no_left.replace(new RegExp("[" + chars + "]+$", "g"), "");
}

function proposeNames() {
 
  document.theform.email.value = trim(document.theform.email.value, " \t");
  who_from = document.theform.email.value.split("@", 2);

  if(who_from.length >= 2) {

    who  = who_from[0].split(/[\._]+/,2);
    if(who.length == 1)  {
      who  = who_from[0].split("_",2);
    }
    if(document.theform.firstname.value == "") {
      document.theform.firstname.value = ucf_arr(who[0].split("-")).join("-");
    }
    if(who.length > 1 && document.theform.lastname.value == "") {
      document.theform.lastname.value = ucf_arr(who[1].split("-")).join("-");
    }
  }
}

-->
</script>


<form name="theform" enctype="multipart/form-data"
	accept-charset="utf-8" method="post"
	action="edit<?php echo $page_ext; ?>">

	
	<button class="btn btn-success" type="submit" name="submit" value="<?php echo ucfmsg('ENTER') ?>"><?php echo ucfmsg('ENTER') ?></button>
	<input type="hidden" name="id"
		value="<?php echo echoIfSet($addr, 'id'); ?>" />
	<br/><br/>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("FIRSTNAME") ?>:</label>
		<div class="controls">
			<input type="text" name="firstname"
				value="<?php echoIfSet($addr, 'firstname'); ?>" size="35"
				onkeyup="proposeMail()" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("MIDDLENAME") ?>:</label>
		<div class="controls">
			<input type="text" name="middlename"
				value="<?php echoIfSet($addr, 'middlename'); ?>" size="15"
				onkeyup="proposeMail()" />
			

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("LASTNAME") ?>:</label>
		<div class="controls">
			<input type="text" name="lastname"
				value="<?php echoIfSet($addr, 'lastname'); ?>" size="35"
				onkeyup="proposeMail()" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("NICKNAME") ?>:</label>
		<div class="controls">
			<input type="text" name="nickname"
				value="<?php echoIfSet($addr, 'nickname'); ?>" size="35" />

		</div>
	</div>
	
	<div class="fileupload fileupload-new" data-provides="fileupload">
  <div class="input-append">
    <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Select Image</span><span class="fileupload-exists">Change</span><input type="file" name="photo" /></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
  </div>
</div>
	

	<div class="btn-group" data-toggle="buttons-checkbox">
	  <button type="button" class="btn btn-primary position" id="bposition_1">1 Pilar</button>
	  <input type="hidden" name="position_1" id="position_1" value="<?php echoIfSet($addr, 'position_1'); ?>">
	  
	  <button type="button" class="btn btn-primary position" id="bposition_2">2 Hooker</button>
	  <input type="hidden" name="position_2" id="position_2" value="<?php echoIfSet($addr, 'position_2'); ?>">
	  <button type="button" class="btn btn-primary position" id="bposition_3">3 Pilar</button>
	  <input type="hidden" name="position_3" id="position_3" value="<?php echoIfSet($addr, 'position_3'); ?>">
	</div>
	<br/>
	<div class="btn-group" data-toggle="buttons-checkbox">
	  <button type="button" class="btn btn-primary position" id="bposition_4">4 Segunda linea</button>
	  <input type="hidden" name="position_4" id="position_4" value="<?php echoIfSet($addr, 'position_4'); ?>">
	  <button type="button" class="btn btn-primary position" id="bposition_5">5 Segunda linea</button>
	  <input type="hidden" name="position_5" id="position_5" value="<?php echoIfSet($addr, 'position_5'); ?>">
	 </div>
	<br/>
	<div class="btn-group" data-toggle="buttons-checkbox">
	  <button type="button" class="btn btn-primary position" id="bposition_6">6 Tercera linea ala</button>
	  <input type="hidden" name="position_6" id="position_6" value="<?php echoIfSet($addr, 'position_6'); ?>">
	  <button type="button" class="btn btn-primary position" id="bposition_8" >8 Tercera linea</button>
	  <input type="hidden" name="position_8" id="position_8" value="<?php echoIfSet($addr, 'position_8'); ?>">
	  <button type="button" class="btn btn-primary position" id="position_7">7 Tercera linea ala</button>
	  <input type="hidden" name="position_7" id="position_7" value="<?php echoIfSet($addr, 'position_7'); ?>">
	 </div>
	 <br/><br/>
	<div class="btn-group" data-toggle="buttons-checkbox">
	  <button type="button" class="btn btn-primary position" id="bposition_9">9 Medio scrum</button>
	  <input type="hidden" name="position_9" id="position_9" value="<?php echoIfSet($addr, 'position_9'); ?>">
	 </div>
	 <br/><br/>
	 <div class="btn-group" data-toggle="buttons-checkbox"  style="left:100px">
	  <button type="button" class="btn btn-primary position" id="bposition_10">10 Apertura</button>
	  <input type="hidden" name="position_10" id="position_10" value="<?php echoIfSet($addr, 'position_10'); ?>">
	  <button type="button" class="btn btn-primary position" id="bposition_12" >12 Primer centro</button>
	  <input type="hidden" name="position_12" id="position_12" value="<?php echoIfSet($addr, 'position_12'); ?>">
	  <button type="button" class="btn btn-primary position" id="bposition_13" >13 Segundo centro</button>
	  <input type="hidden" name="position_13" id="position_13" value="<?php echoIfSet($addr, 'position_13'); ?>">
	 </div>
	 <br/><br/><br/>
	 <div class="btn-group" data-toggle="buttons-checkbox" style="left:50px">
	  <button type="button" class="btn btn-primary position" id="bposition_11">11 Wing izquierdo</button>
	  <input type="hidden" name="position_11" id="position_11" value="<?php echoIfSet($addr, 'position_11'); ?>">
	  <button type="button" class="btn btn-primary position" id="bposition_15" >15 Fullback</button>
	  <input type="hidden" name="position_15" id="position_15" value="<?php echoIfSet($addr, 'position_15'); ?>">
	  <button type="button" class="btn btn-primary position" id="bposition_14">14 Wing derecho</button>
	  <input type="hidden" name="position_14" id="position_14" value="<?php echoIfSet($addr, 'position_14'); ?>">
	 </div>
	 <br/><br/><br/>
	
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("TITLE") ?>:</label>
		<div class="controls">
			<input type="text" name="title" size="35"
				value="<?php echoIfSet($addr, 'title'); ?>" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("COMPANY") ?>:</label>
		<div class="controls">
			<input type="text" name="company"
				value="<?php echoIfSet($addr, 'company'); ?>" size="35"
				onkeyup="proposeMail()" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("ADDRESS") ?>:</label>
		<div class="controls">
			<textarea name="address" rows="5" cols="35"><?php echoIfSet($addr, 'address'); ?></textarea>
			

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("TELEPHONE") ?></label>
		<div class="controls">
			
			<br class="clear" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("PHONE_HOME") ?>:</label>
		<div class="controls">
			<input type="text" name="home"
				value="<?php echoIfSet($addr, 'home'); ?>" size="35" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("PHONE_MOBILE") ?>:</label>
		<div class="controls">
			<input type="text" name="mobile"
				value="<?php echoIfSet($addr, 'mobile'); ?>" size="35" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("PHONE_WORK") ?>:</label>
		<div class="controls">
			<input type="text" name="work"
				value="<?php echoIfSet($addr, 'work'); ?>" size="35" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("FAX") ?>:</label>
		<div class="controls">
			<input type="text" name="fax"
				value="<?php echoIfSet($addr, 'fax'); ?>" size="35" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label">&nbsp;</label>
		<div class="controls">
			
			<br class="clear" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("EMAIL") ?>:</label>
		<div class="controls">
			<input type="text" name="email"
				value="<?php echoIfSet($addr, 'email'); ?>" size="35"
				onkeyup="proposeNames()" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("EMAIL") ?>2:</label>
		<div class="controls">
			<input type="text" name="email2"
				value="<?php echoIfSet($addr, 'email2'); ?>" size="35" />

		</div>
	</div><br/>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("EMAIL") ?>3:</label>
		<div class="controls">
			<input type="text" name="email3"
				value="<?php echoIfSet($addr, 'email3'); ?>" size="35" />

		</div>
	</div><br/>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("HOMEPAGE") ?>:</label>
		<div class="controls">
			<input type="text" name="homepage"
				value="<?php echoIfSet($addr, 'homepage'); ?>" size="35" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("FACEBOOKUSERNAME"); ?>:</label>
		<div class="controls">
			<input type="text" name="facebookusername"
				value="<?php echoIfSet($addr, 'facebookusername'); ?>" size="24" />
		</div>
		<?php echo '(ex: https://www.facebook.com/rugbylapazbolivia => rugbylapazbolivia)';?>
		
	</div>
	
	
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("BIRTHDAY") ?>:</label>
		<div class="controls">
			<select name="bday">
				<option value="<?php echoIfSet($addr, 'bday'); ?>"
					selected="selected"><?php echoIfSet($addr, 'bday'); ?></option>
				<option value="0">-</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
				<option value="24">24</option>
				<option value="25">25</option>
				<option value="26">26</option>
				<option value="27">27</option>
				<option value="28">28</option>
				<option value="29">29</option>
				<option value="30">30</option>
				<option value="31">31</option>
			</select> <select name="bmonth">
     <?php   if(isset($addr['bmonth'])) { ?>
          <option value="<?php echoIfSet($addr, 'bmonth'); ?>"
					selected="selected"><?php
			echo ucfmsg ( strtoupper ( $addr ['bmonth'] ) );
			?></option>
     <?php } ?>
          <option value="-">-</option>
				<option value="January"><?php echo ucfmsg("JANUARY") ?></option>
				<option value="February"><?php echo ucfmsg("FEBRUARY") ?></option>
				<option value="March"><?php echo ucfmsg("MARCH") ?></option>
				<option value="April"><?php echo ucfmsg("APRIL") ?></option>
				<option value="May"><?php echo ucfmsg("MAY") ?></option>
				<option value="June"><?php echo ucfmsg("JUNE") ?></option>
				<option value="July"><?php echo ucfmsg("JULY") ?></option>
				<option value="August"><?php echo ucfmsg("AUGUST") ?></option>
				<option value="September"><?php echo ucfmsg("SEPTEMBER") ?></option>
				<option value="October"><?php echo ucfmsg("OCTOBER") ?></option>
				<option value="November"><?php echo ucfmsg("NOVEMBER") ?></option>
				<option value="December"><?php echo ucfmsg("DECEMBER") ?></option>
			</select> <input class="byear" type="text" name="byear" size="4"
				maxlength="4" value="<?php echoIfSet($addr, 'byear'); ?>" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("ANNIVERSARY") ?>:</label>
		<div class="controls">
			<select name="aday">
				<option value="<?php echoIfSet($addr, 'aday'); ?>"
					selected="selected"><?php echoIfSet($addr, 'aday'); ?></option>
				<option value="0">-</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
				<option value="24">24</option>
				<option value="25">25</option>
				<option value="26">26</option>
				<option value="27">27</option>
				<option value="28">28</option>
				<option value="29">29</option>
				<option value="30">30</option>
				<option value="31">31</option>
			</select> <select name="amonth">
     <?php   if(isset($addr['amonth'])) { ?>
          <option value="<?php echoIfSet($addr, 'amonth'); ?>"
					selected="selected"><?php
			echo ucfmsg ( strtoupper ( $addr ['amonth'] ) );
			?></option>
     <?php } ?>     
          <option value="-">-</option>
				<option value="January"><?php echo ucfmsg("JANUARY") ?></option>
				<option value="February"><?php echo ucfmsg("FEBRUARY") ?></option>
				<option value="March"><?php echo ucfmsg("MARCH") ?></option>
				<option value="April"><?php echo ucfmsg("APRIL") ?></option>
				<option value="May"><?php echo ucfmsg("MAY") ?></option>
				<option value="June"><?php echo ucfmsg("JUNE") ?></option>
				<option value="July"><?php echo ucfmsg("JULY") ?></option>
				<option value="August"><?php echo ucfmsg("AUGUST") ?></option>
				<option value="September"><?php echo ucfmsg("SEPTEMBER") ?></option>
				<option value="October"><?php echo ucfmsg("OCTOBER") ?></option>
				<option value="November"><?php echo ucfmsg("NOVEMBER") ?></option>
				<option value="December"><?php echo ucfmsg("DECEMBER") ?></option>
			</select> <input class="byear" type="text" name="ayear" size="4"
				maxlength="4" value="<?php echoIfSet($addr, 'ayear'); ?>" />

    <?php
		if (isset ( $table_groups ) and $table_groups != "" and ! $is_fix_group) {
			?>

 </div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("GROUP") ?>:</label>
		<div class="controls">
			<select name="new_group">
        <?php
			if ($group_name != "") {
				echo "<option>$group_name</option>\n";
			}
			?>
          <option value="[none]">[<?php echo msg("NONE"); ?>]</option>
          <?php
			$sql = "SELECT group_name FROM $groups_from_where ORDER BY lower(group_name) ASC";
			$result_groups = mysql_query ( $sql );
			$result_gropup_snumber = mysql_numrows ( $result_groups );
			
			while ( $myrow_group = mysql_fetch_array ( $result_groups ) ) {
				echo "<option>" . $myrow_group ["group_name"] . "</option>\n";
			}
			?>
        </select>
    <?php } ?>
    
    
		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><b><?php echo ucfmsg("SECONDARY") ?></b></label>
		<div class="controls">
			
			<br class="clear" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("ADDRESS") ?>:</label>
		<div class="controls">
			<textarea name="address2" rows="5" cols="35"></textarea>
			

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("PHONE_HOME") ?>:</label>
		<div class="controls">
			<input type="text" name="phone2"
				value="<?php echoIfSet($addr, 'phone2'); ?>" size="35" />
		</div>
	</div>
	
			<div class="control-group">
				<label class="control-label"><?php echo ucfmsg("NOTES") ?>:</label>
				<div class="controls">
					<textarea name="notes" rows="5" cols="35"></textarea>
					<br/><br/>
					
					<button class="btn btn-success" type="submit" name="submit" value="<?php echo ucfmsg('ENTER') ?>"><?php echo ucfmsg('ENTER') ?></button>
				</div>
			</div>
</form>
<script type="text/javascript">
for (i = 1 ;i<=15;i++){
	if ($('#position_'+i).val() == '1'){
		$('#bposition_'+i).addClass('active');
	}
}
$('.position').on('click',function(e) {
	var index=$(this).attr('id').replace('bposition_','');
	
	if ($( this ).hasClass('active') ){
		$('#position_'+index).val("0");
		}else{
			$('#position_'+index).val("1");
		}
});


</script>
<script type="text/javascript">
    document.theform.email.focus();
  </script>
<?php
	} else
		echo "<br /><div class='msgbox'>Editing is disabled.</div>";
}

include ("include/footer.inc.php");
?>