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

function showForm($addr=null,$myrow=null){

global $page_ext,$table_groups,$is_fix_group,$group_name,$groups_from_where,$group,$id,$base_from_where,$table,$db;

echo $group;
	$update=false;
	if (is_null($addr)){
		$update=true;
		$addr=$myrow;
	}
	
	if($update)
	{
	?>
	<form method="get" action="delete<?php echo $page_ext; ?>">
	<input type="hidden" name="id" value="<?php echo $myrow['id']?>" />
	<button class="btn btn-danger" type="submit" name="update" onclick="return confirm('<?php  echo ucfmsg("DELETE_PLAYER"); ?>?')"
		value="<?php echo ucfmsg('DELETE') ?>"><?php echo ucfmsg('DELETE') ?></button>

	</form>	
	<form class="form-horizontal" style="margin: 0px 0px 0px 100px;" enctype="multipart/form-data"
	accept-charset="utf-8" method="post" id="user_form"
	action="edit<?php echo $page_ext; ?>">
	
	<button class="btn btn-success" type="submit" class="update"
		name="update" value="<?php echo ucfmsg('UPDATE') ?>"><?php echo ucfmsg('UPDATE') ?></button>
		<input type="hidden" name="id" value="<?php echo echoIfSet($addr, 'id'); ?>" /> 
	<?php
	}else{
	?>
	<form class="form-horizontal" name="theform" enctype="multipart/form-data"
	accept-charset="utf-8" method="post"
	action="edit<?php echo $page_ext; ?>">
	
	<button class="btn btn-success" type="submit" name="submit"
		value="<?php echo ucfmsg('ENTER') ?>"><?php echo ucfmsg('ENTER') ?></button>
	
	<?php
	}
	?>
	
	<br/>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("FIRSTNAME") ?>:</label>
		<div class="controls">
			<input type="text" name="firstname"
				value="<?php echoIfSet($addr, 'firstname'); ?>" size="35"
				 />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("MIDDLENAME") ?>:</label>
		<div class="controls">
			<input type="text" name="middlename"
				value="<?php echoIfSet($addr, 'middlename'); ?>" size="15"
				 />


		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("LASTNAME") ?>:</label>
		<div class="controls">
			<input type="text" name="lastname"
				value="<?php echoIfSet($addr, 'lastname'); ?>" size="35"
				 />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("NICKNAME") ?>:</label>
		<div class="controls">
			<input type="text" name="nickname"
				value="<?php echoIfSet($addr, 'nickname'); ?>" size="35" />

		</div>
	</div>
	<div class="control-group">
	<label class="control-label"><?php echo ucfmsg("GENDER") ?>:</label>
	<div class="controls">
	<div class="btn-group" data-toggle="buttons-radio">
  <button type="button" id="radiogender_0" class="btn btn-primary"><?php echo ucfmsg("MALE") ?></button>
  <button type="button" id="radiogender_1" class="btn btn-primary"><?php echo ucfmsg("FEMALE") ?></button>
  </div>
</div>
	</div>
	<input type="hidden" name="gender" id="hradiogender"
			value="<?php $hgender=getIfSetFromAddr($addr, 'gender');echo ($hgender==""?"0":$hgender);?>">
	
	
	
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("BIRTHDAY") ?>:</label>
		<div class="controls">
			<select name="bday">
			<?php   if(isset($addr['bday']) && $addr ['bday'] !='0') { ?>
          <option value="<?php echoIfSet($addr, 'bday'); ?>"
					selected="selected"><?php
			echo ucfmsg ( strtoupper ( $addr ['bday'] ) );
			?></option>
     		<?php } ?>
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
     <?php   if(isset($addr['bmonth']) && $addr['bmonth'] !='-') { ?>
          <option value="<?php echoIfSet($addr, 'bmonth'); ?>"
					selected="selected"><?php
			echo ucfmsg ( strtoupper ( $addr ['bmonth'] ) );
			?></option>
     <?php } ?>
          		<option value="-">-</option>
				<option value="January">1-<?php echo ucfmsg("JANUARY") ?></option>
				<option value="February">2-<?php echo ucfmsg("FEBRUARY") ?></option>
				<option value="March">3-<?php echo ucfmsg("MARCH") ?></option>
				<option value="April">4-<?php echo ucfmsg("APRIL") ?></option>
				<option value="May">5-<?php echo ucfmsg("MAY") ?></option>
				<option value="June">6-<?php echo ucfmsg("JUNE") ?></option>
				<option value="July">7-<?php echo ucfmsg("JULY") ?></option>
				<option value="August">8-<?php echo ucfmsg("AUGUST") ?></option>
				<option value="September">9-<?php echo ucfmsg("SEPTEMBER") ?></option>
				<option value="October">10-<?php echo ucfmsg("OCTOBER") ?></option>
				<option value="November">11-<?php echo ucfmsg("NOVEMBER") ?></option>
				<option value="December">12-<?php echo ucfmsg("DECEMBER") ?></option>
			</select> <input class="byear" type="text" name="byear" size="4"
				maxlength="4" value="<?php echoIfSet($addr, 'byear'); ?>" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("ID_CARD_NUMBER") ?>:</label>
		<div class="controls">
			<input type="text" name="id_card_number" size="35"
				value="<?php echoIfSet($addr, 'id_card_number'); ?>" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("EMAIL") ?>:</label>
		<div class="controls">
			<input type="text" name="email"
				value="<?php echoIfSet($addr, 'email'); ?>" size="35"
				 />

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
		<label class="control-label"><?php echo ucfmsg("PROFESSION") ?>:</label>
		<div class="controls">
			<input type="text" name="profession"
				value="<?php echoIfSet($addr, 'profession'); ?>" size="35" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("FACEBOOKUSERNAME"); ?>:</label>
		<div class="controls">
			<input type="text" name="facebookusername"
				value="<?php echoIfSet($addr, 'facebookusername'); ?>" size="24" />
		</div>
		<?php echo '(ex: https://www.facebook.com/lapazrugby => lapazrugby)';?>
		
	</div>
	    <div class="fileupload fileupload-new" data-provides="fileupload">
	  <div class="input-append">
	  <label class="control-label"><?php echo ucfmsg("PHOTO") ?>:</label>
	    <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Select Image</span><span class="fileupload-exists">Change</span><input type="file" name="photo" /></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
	  </div>
	  
	</div>
	
	<?php
	if($update)
	{
	?>
	<div class="control-group">
		<label class="control-label"><?php echo msg("DELETE") ?>:</label>
		<div class="controls">
			<input type="checkbox" name="delete_photo" style="position: relative;top: 5px;"/>
		</div>
		<?php
	$sql = "SELECT photo FROM $base_from_where AND $table.id='$id'";
	$result = mysql_query($sql, $db);
	$r = mysql_fetch_array($result);
	if ($r['photo'] !== ''){
include_once "photo.php";
		?>
		
		<img style="position:relative;left:50px" src="<?php echo getImgPath($id);?>" />
		<?php  } ?>
	</div>
	<?php }
	?>
	<br/><br/>
	<div class="control-group">
	<label class="control-label"><?php echo ucfmsg("CATEGORY") ?>:</label>
	<div class="controls">
	<div class="btn-group" data-toggle="buttons-radio">
  <button type="button" id="radiocategory_2" class="btn btn-primary"><?php echo ucfmsg("INFANTILE") ?></button>
  <button type="button" id="radiocategory_1" class="btn btn-primary"><?php echo ucfmsg("JUVENILE") ?></button>
   <button type="button" id="radiocategory_0" class="btn btn-primary"><?php echo ucfmsg("ADULT") ?></button>
  </div>
</div>
	</div>
	<input type="hidden" name="category" id="hradiocategory"
			value="<?php $hcategory=getIfSetFromAddr($addr, 'category');echo ($hcategory==""?"0":$hcategory);?>">
	<br/><br/>
	<div class="control-group">
	<label class="control-label"><?php echo ucfmsg("ATTENDANCE") ?>:</label>
	<div class="controls">
	<div class="btn-group" data-toggle="buttons-radio">
  <button type="button" id="radioattendance_0" class="btn btn-primary"><?php echo ucfmsg("ACTIVE") ?></button>
  <button type="button" id="radioattendance_1" class="btn btn-primary"><?php echo ucfmsg("ABSENT") ?></button>
  <button type="button" id="radioattendance_2" class="btn btn-primary"><?php echo ucfmsg("OUT_OF_CITY") ?></button>
  </div>
</div>
	</div>
	<input type="hidden" name="attendance" id="hradioattendance"
			value="<?php $hattendance=getIfSetFromAddr($addr, 'attendance');echo ($hattendance==""?"0":$hattendance);?>">
	<br/>
<div class="control-group">
	<label class="control-label" style="text-decoration:underline"><?php echo ucfmsg("POSITION") ?>:</label><br />
	<br />
	<div class="controls">
	<div class="btn-group" data-toggle="buttons-checkbox">
		<button type="button" class="btn btn-primary position"
			id="bposition_1">1 Pilar</button>
		<input type="hidden" name="position_1" id="position_1"
			value="<?php echoIfSet($addr, 'position_1'); ?>">

		<button type="button" class="btn btn-primary position"
			id="bposition_2">2 Hooker</button>
		<input type="hidden" name="position_2" id="position_2"
			value="<?php echoIfSet($addr, 'position_2'); ?>">
		<button type="button" class="btn btn-primary position"
			id="bposition_3">3 Pilar</button>
		<input type="hidden" name="position_3" id="position_3"
			value="<?php echoIfSet($addr, 'position_3'); ?>">
	</div>
	</div>
	
	<br />
	<div class="controls">
	<div class="btn-group" data-toggle="buttons-checkbox">
		<button type="button" class="btn btn-primary position"
			id="bposition_4">4 Segunda linea</button>
		<input type="hidden" name="position_4" id="position_4"
			value="<?php echoIfSet($addr, 'position_4'); ?>">
		<button type="button" class="btn btn-primary position"
			id="bposition_5">5 Segunda linea</button>
		<input type="hidden" name="position_5" id="position_5"
			value="<?php echoIfSet($addr, 'position_5'); ?>">
	</div>
	</div>
	<br />
	<div class="controls">
	<div class="btn-group" data-toggle="buttons-checkbox">
		<button type="button" class="btn btn-primary position"
			id="bposition_6">6 Tercera linea ala</button>
		<input type="hidden" name="position_6" id="position_6"
			value="<?php echoIfSet($addr, 'position_6'); ?>">
		<button type="button" class="btn btn-primary position"
			id="bposition_8">8 Tercera linea</button>
		<input type="hidden" name="position_8" id="position_8"
			value="<?php echoIfSet($addr, 'position_8'); ?>">
		<button type="button" class="btn btn-primary position" id="bposition_7">7
			Tercera linea ala</button>
		<input type="hidden" name="position_7" id="position_7"
			value="<?php echoIfSet($addr, 'position_7'); ?>">
	</div>
	</div>
	<br />
	<div class="controls">
	<div class="btn-group" data-toggle="buttons-checkbox">
		<button type="button" class="btn btn-primary position"
			id="bposition_9">9 Medio scrum</button>
		<input type="hidden" name="position_9" id="position_9"
			value="<?php echoIfSet($addr, 'position_9'); ?>">
	</div>
	</div>
	<br />
	<div class="controls">
	<div class="btn-group" data-toggle="buttons-checkbox"
		style="left: 100px">
		<button type="button" class="btn btn-primary position"
			id="bposition_10">10 Apertura</button>
		<input type="hidden" name="position_10" id="position_10"
			value="<?php echoIfSet($addr, 'position_10'); ?>">
		<button type="button" class="btn btn-primary position"
			id="bposition_12">12 Primer centro</button>
		<input type="hidden" name="position_12" id="position_12"
			value="<?php echoIfSet($addr, 'position_12'); ?>">
		<button type="button" class="btn btn-primary position"
			id="bposition_13">13 Segundo centro</button>
		<input type="hidden" name="position_13" id="position_13"
			value="<?php echoIfSet($addr, 'position_13'); ?>">
	</div>
	</div>
	<br />
	<br/>
	<div class="controls">
	<div class="btn-group" data-toggle="buttons-checkbox"
		style="left: 50px">
		<button type="button" class="btn btn-primary position"
			id="bposition_11">11 Wing izquierdo</button>
		<input type="hidden" name="position_11" id="position_11"
			value="<?php echoIfSet($addr, 'position_11'); ?>">
		<button type="button" class="btn btn-primary position"
			id="bposition_15">15 Fullback</button>
		<input type="hidden" name="position_15" id="position_15"
			value="<?php echoIfSet($addr, 'position_15'); ?>">
		<button type="button" class="btn btn-primary position"
			id="bposition_14">14 Wing derecho</button>
		<input type="hidden" name="position_14" id="position_14"
			value="<?php echoIfSet($addr, 'position_14'); ?>">
	</div>
	</div>
	
	</div>
	
	 <input type="hidden" name="company" value="" />
	<input type="hidden" name="title" value="" />
<br/>

<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("FIRST_EXPERIENCE") ?>:</label>
		<div class="controls">
			<select name="first_exp_year">
			<?php   if(isset($addr['first_exp_year']) && $addr ['first_exp_year'] !='0') { ?>
          <option value="<?php echoIfSet($addr, 'first_exp_year'); ?>"
					selected="selected"><?php
			echo ucfmsg ( strtoupper ( $addr ['first_exp_year'] ) );
			?></option>
     		<?php } 
     		$currentYear=date("Y");
     		
     		$i=0;
     		while ($i<=40){
				echo "<option value='".($currentYear-$i)."'>".($currentYear-$i)."</option>";
				$i++;
			}
			?>
				
			</select> 

		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" style="text-decoration:underline"><?php echo ucfmsg("POSITION_IN_BOARD") ?>:</label>
		<div class="controls">

			<br class="clear" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo msg("PRESIDENT") ?>:</label>
		<div class="controls">
			<input type="checkbox" name="president" <?php if($myrow['president'] ==1){?>CHECKED<?php } ?> style="position: relative;top: 5px;"/>

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo msg("VICEPRESIDENT") ?>:</label>
		<div class="controls">
			<input type="checkbox" name="vicepresident" <?php if($myrow['vicepresident'] ==1){?>CHECKED<?php } ?> style="position: relative;top: 5px;"/>

		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo msg("SECRETARYGENERAL") ?>:</label>
		<div class="controls">
			<input type="checkbox" name="secretarygeneral" <?php if($myrow['secretarygeneral'] ==1){?>CHECKED<?php } ?> style="position: relative;top: 5px;"/>

		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo msg("TREASURER") ?>:</label>
		<div class="controls">
			<input type="checkbox" name="treasurer" <?php if($myrow['treasurer'] ==1){?>CHECKED<?php } ?> style="position: relative;top: 5px;" />

		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo msg("COMMUNICATION") ?>:</label>
		<div class="controls">
			<input type="checkbox" name="communication" <?php if($myrow['communication'] ==1){?>CHECKED<?php } ?> style="position: relative;top: 5px;" />

		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("OTHER_POSITION") ?>:</label>
		<div class="controls">

			<br class="clear" />

		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo msg("REFEREE") ?>:</label>
		<div class="controls">
			<input type="checkbox" name="referee" <?php if($myrow['referee'] ==1){?>CHECKED<?php } ?> style="position: relative;top: 5px;" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo msg("TRAINER") ?>:</label>
		<div class="controls">
			<input type="checkbox" name="trainer" <?php if($myrow['trainer'] ==1){?>CHECKED<?php } ?> style="position: relative;top: 5px;" />

		</div>
	</div>
	<br/>
	<br/>
	<br/>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("ADDRESS") ?>:</label>
		<div class="controls">
			<textarea name="address" rows="5" cols="35"><?php echoIfSet($addr, 'address'); ?></textarea>


		</div>
	</div>
	<br/>
	<div class="control-group">
		<label class="control-label" style="text-decoration:underline"><?php echo ucfmsg("TELEPHONE") ?>:</label>
		<div class="controls">

			<br class="clear" />

		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("PHONE_MOBILE") ?> 2:</label>
		<div class="controls">
			<input type="text" name="mobile2"
				value="<?php echoIfSet($addr, 'mobile2'); ?>" size="35" />

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
		<label class="control-label"><?php echo ucfmsg("EMAIL") ?>2:</label>
		<div class="controls">
			<input type="text" name="email2"
				value="<?php echoIfSet($addr, 'email2'); ?>" size="35" />

		</div>
	</div>
	<br />
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("EMAIL") ?>3:</label>
		<div class="controls">
			<input type="text" name="email3"
				value="<?php echoIfSet($addr, 'email3'); ?>" size="35" />

		</div>
	</div>
	<br />
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("HOMEPAGE") ?>:</label>
		<div class="controls">
			<input type="text" name="homepage"
				value="<?php echoIfSet($addr, 'homepage'); ?>" size="35" />

		</div>
	</div>
	

	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("TWITTER");?>:</label>
		<div class="controls">
			<input type="text" name="twitter"
				value="<?php echoIfSet($addr, 'twitter');?>" size="24" />


		</div>

	</div>

	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("SKYPE");?>:</label>
		<div class="controls">
			<input type="text" name="skype"
				value="<?php echoIfSet($addr, 'skype');?>" size="24" />


		</div>

	</div>
	
	<?php 
/*
		       * <div class="control-group"> <label class="control-label"><?php echo ucfmsg("ANNIVERSARY") ?>:</label> <div class="controls"> <select name="aday"> <option value="<?php echoIfSet($addr, 'aday'); ?>" selected="selected"><?php echoIfSet($addr, 'aday'); ?></option> <option value="0">-</option> <option value="1">1</option> <option value="2">2</option> <option value="3">3</option> <option value="4">4</option> <option value="5">5</option> <option value="6">6</option> <option value="7">7</option> <option value="8">8</option> <option value="9">9</option> <option value="10">10</option> <option value="11">11</option> <option value="12">12</option> <option value="13">13</option> <option value="14">14</option> <option value="15">15</option> <option value="16">16</option> <option value="17">17</option> <option value="18">18</option> <option value="19">19</option> <option value="20">20</option> <option value="21">21</option> <option value="22">22</option> <option value="23">23</option> <option value="24">24</option> <option value="25">25</option> <option value="26">26</option> <option value="27">27</option> <option value="28">28</option> <option value="29">29</option> <option value="30">30</option> <option value="31">31</option> </select> <select name="amonth"> <?php if(isset($addr['amonth'])) { ?> <option value="<?php echoIfSet($addr, 'amonth'); ?>" selected="selected"><?php echo ucfmsg ( strtoupper ( $addr ['amonth'] ) ); ?></option> <?php } ?> <option value="-">-</option> <option value="January"><?php echo ucfmsg("JANUARY") ?></option> <option value="February"><?php echo ucfmsg("FEBRUARY") ?></option> <option value="March"><?php echo ucfmsg("MARCH") ?></option> <option value="April"><?php echo ucfmsg("APRIL") ?></option> <option value="May"><?php echo ucfmsg("MAY") ?></option> <option value="June"><?php echo ucfmsg("JUNE") ?></option> <option value="July"><?php echo ucfmsg("JULY") ?></option> <option value="August"><?php echo ucfmsg("AUGUST") ?></option> <option value="September"><?php echo ucfmsg("SEPTEMBER") ?></option> <option value="October"><?php echo ucfmsg("OCTOBER") ?></option> <option value="November"><?php echo ucfmsg("NOVEMBER") ?></option> <option value="December"><?php echo ucfmsg("DECEMBER") ?></option> </select> <input class="byear" type="text" name="ayear" size="4" maxlength="4" value="<?php echoIfSet($addr, 'ayear'); ?>" /> </div> </div>
		       */
		?>
			
			<input type="hidden" name="aday" value=""> <input type="hidden"
		name="amonth" value=""> <input type="hidden" name="ayear" value=""> <input
		type="hidden" name="address2" value=""> <input type="hidden"
		name="phone2" value="">
    <?php
		if (!$update && isset ( $table_groups ) and $table_groups != "" and ! $is_fix_group) {
			?>
	
 
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
		</div>
	</div>
    <?php } ?>
    
    <?php 
/*
		       * <div class="control-group"> <label class="control-label"><b><?php echo ucfmsg("SECONDARY") ?></b></label> <div class="controls"> <br class="clear" /> </div> </div> <div class="control-group"> <label class="control-label"><?php echo ucfmsg("ADDRESS") ?>:</label> <div class="controls"> <textarea name="address2" rows="5" cols="35"></textarea> </div> </div> <div class="control-group"> <label class="control-label"><?php echo ucfmsg("PHONE_HOME") ?>:</label> <div class="controls"> <input type="text" name="phone2" value="<?php echoIfSet($addr, 'phone2'); ?>" size="35" /> </div> </div>
		       */
		?>
	<div class="control-group">
		<label class="control-label"><?php echo ucfmsg("NOTES") ?>:</label>
		<div class="controls">
			<textarea name="notes" rows="5" cols="35"><?php echoIfSet($addr, 'notes'); ?></textarea>
		</div>
		
	</div>


	<?php
	if($update)
	{
	?>
	<button class="btn btn-success" type="submit" class="update"
		name="update" value="<?php echo ucfmsg('UPDATE') ?>"><?php echo ucfmsg('UPDATE') ?></button>
	</form>	
	<form name="delete_address" method="get" action="delete<?php echo $page_ext; ?>">
	<input type="hidden" name="id" value="<?php echo $myrow['id']?>" />
	<button class="btn btn-danger" type="submit" name="update" onclick="return confirm('<?php  echo ucfmsg("DELETE_PLAYER"); ?>?')"
		value="<?php echo ucfmsg('DELETE') ?>"><?php echo ucfmsg('DELETE') ?></button>

	</form>	
	
	<?php
	}else{
	?>
	<button class="btn btn-success" type="submit" name="submit"
		value="<?php echo ucfmsg('ENTER') ?>"><?php echo ucfmsg('ENTER') ?></button>
	</form>
	<?php
	}
	?>
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

//radios
	
	$( "[id^=hradio]" ).each(function( index ) {
		
		var bid=$( this ).attr('id')+'_'+$( this ).val();
		bid=bid.substring(1);
		$( "#"+bid ).addClass('active');
			
		
		});
	$('[id^=radio]').on('click',function(e) {
		var id=$(this).attr('id');
		var val=id.substring(id.indexOf('_')+1);
		var idh='h'+id.substring(0,id.indexOf('_'));
		$('#'+idh).val(val);
	
	});
	
	</script>
<?php 	
}

function getAdrArray($update=null){
	global $id,$firstname,$middlename,$lastname,$nickname,$title,$company,$address,$home,$mobile,$mobile2,$work,$fax,$email,$email2,$email3,$homepage,$facebookusername,$bday,
	$bmonth,$byear,$aday,$amonth,$ayear,$address2,$phone2,$notes,$position_1,$position_2,$position_3,$position_4,$position_5,$position_6,$position_7,$position_8,$position_9,$position_10,
	$position_11,$position_12,$position_13,$position_14,$position_15,$id_card_number,$twitter,$skype,$president,$vicepresident,$treasurer,$secretarygeneral,$communication,$trainer,$referee,$category,$gender,$attendance,$first_exp_year,$profession;
	
	if($update){
		$addr ['id'] = $id;
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
	$addr ['mobile2'] = $mobile2;
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
	$addr ['id_card_number'] = $id_card_number;
	$addr ['twitter'] = $twitter;
	$addr ['skype'] = $skype;
	$addr ['president'] = isset($president);
	$addr ['vicepresident'] = isset($vicepresident);
	$addr ['treasurer'] = isset($treasurer);
	$addr ['secretarygeneral'] = isset($secretarygeneral);
	$addr ['communication'] = isset($communication);
	$addr ['trainer'] = isset($trainer);
	$addr ['referee'] = isset($referee);
	$addr ['category'] = $category;
	$addr ['gender'] = $gender;
	$addr ['attendance'] = $attendance;
	$addr ['first_exp_year'] = $first_exp_year;
	$addr ['profession'] = $profession;
	
	return $addr;
}
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
		
		$addr=getAdrArray();
		
		
		
		if (isset ( $_FILES ["photo"] ) && $_FILES ["photo"] ["error"] <= 0) {
			
			$file_tmp_name = $_FILES ["photo"] ["tmp_name"];
			$file_name = $_FILES ["photo"] ["name"];
			$photo = new Photo ( $file_tmp_name );
			$photo->scaleToMaxSide ( 150 );
			$addr ['photo'] = $photo->getBase64 ();
			
		}
		
		if (isset ( $table_groups ) and $table_groups != "") {
		
		if (isset ($new_group) && $new_group) {
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
		
		$addr=getAdrArray($update);
		
		
		
		$keep_photo = true;
		if (isset ( $delete_photo )) {
			$keep_photo = ! $delete_photo;
			//delete existing photo
			if (file_exists("img/generated/users/user_".$id.".jpg")){
				unlink("img/generated/users/user_".$id.".jpg");
			}
		}
		
		if (isset ( $_FILES ["photo"] ) && $_FILES ["photo"] ["error"] <= 0) {
			
			$file_tmp_name = $_FILES ["photo"] ["tmp_name"];
			$file_name = $_FILES ["photo"] ["name"];
			$photo = new Photo ( $file_tmp_name );
			$photo->scaleToMaxSide ( 150 );
			$addr ['photo'] = $photo->getBase64 ();
			$keep_photo = false;
			//delete existing photo
			if (file_exists("img/generated/users/user_".$id.".jpg")){
				unlink("img/generated/users/user_".$id.".jpg");
			}
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



	<?php showForm(null,$myrow);?>
	
	





<?php
	} else
		echo "<div class='msgbox'>Editing is disabled.</div>";
} else if (! (isset ( $_POST ['quickskip'] ) || isset ( $_POST ['quickadd'] )) && (isset ( $_GET ['quickadd'] ) || isset ( $_POST ['quickadd'] ) || $quickadd)) {
	?>
<form accept-charset="utf-8" method="post" name="quickadd">

	<button class="btn btn-success" type="submit" name="quickadd"
		value="<?php echo ucfmsg('NEXT') ?>"><?php echo ucfmsg('NEXT') ?></button>

	<br /> <br /> <label class="control-label"><?php echo ucfmsg("ADDRESS") ?>:</label>
	<textarea name="address" rows="20" tabindex="0"></textarea>
	<br /> <br />

	<button class="btn btn-success" type="submit" name="quickadd"
		value="<?php echo ucfmsg('NEXT') ?>"><?php echo ucfmsg('NEXT') ?></button>

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


		<?php showForm($addr,null);?>
	


<script type="text/javascript">

    document.theform.firstname.focus();
  </script>
<?php
	} else
		echo "<br /><div class='msgbox'>Editing is disabled.</div>";
}

include ("include/footer.inc.php");
?>