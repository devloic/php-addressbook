<?php
	include ("include/dbconnect.php");
	include ("include/format.inc.php");
?>
<title><?php echo ucfmsg("ADDRESS_BOOK").($group_name != "" ? " ($group_name)":""); ?></title>
<?php include ("include/header.inc.php"); ?>
 <h1><?php echo ucfmsg('IMPORT'); ?></h1> 
<?php
function getIfSet($ldif_record, $key) {
	
	if(isset($ldif_record[$key])) {
	  return $ldif_record[$key];
	} else {
		return "";
	}
	
}

if(!$submit) {
?>
<form method="post" enctype="multipart/form-data">
  <div class="fileupload fileupload-new" data-provides="fileupload">
	  <div class="input-append">
	  <label class="control-label" size=50 for="file" style="width:14em;padding-top: 5px;">LDIF/VCF/CSV/XLS/XLSX:</label>
	    <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Select File</span><span class="fileupload-exists">Change</span><input type="file" id="file" size=40 name="file" /></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
	  </div>
  </div>
<br/>
  <input type="hidden" name="del_format" value="phpaddr">
  <button class='btn btn-success' name='submit' type='submit'   value="Submit">Submit</button>
  
</form>
<br><br>
<i>Sample (.csv, .xls): <a href="import_sample.csv">import_sample.csv</a></i>
<?php
} else if ($_FILES["file"]["error"] > 0 || $read_only) {
    echo "Error: " . $_FILES["file"]["error"] . "<br />";
} else {
  
  $file_tmp_name = $_FILES["file"]["tmp_name"];
  $file_lines    = file($file_tmp_name, FILE_IGNORE_NEW_LINES); 
  $file_name     = $_FILES["file"]["name"];
  
  include "include/import.common.php";
  
   //
  // Save the group & addresses
  //
  $file_group_name = "";
  if(count($ab) > 0) {  	
  	$file_group_name = "@IMPORT-".$file_name."-".Date("Y-m-j_H:i:s");
    saveGroup($file_group_name);
  }
  
  foreach($ab as $addressbook) {
  	
    saveAddress($addressbook, $file_group_name);
    echo "- <b><i>".getIfSet($addressbook,'firstname')
        .trim(" ".getIfSet($addressbook,'middlename'))
        .", ".getIfSet($addressbook,'lastname')
        ."</i></b>, ".getIfSet($addressbook,'email')
        .", ".getIfSet($addressbook,'email2')
        .", ".getIfSet($addressbook,'company')."<br>";

  }
	echo "<br/><br/><div class='msgbox'>The ".$import_type."-file '".$_FILES["file"]["name"]."' is imported into ".count($ab)." records<br/>";
	echo "<i>of the new group <a href='index$page_ext?group_name=".$file_group_name."'>".$file_group_name."</a></i></div>";	               
//*/
} // end if(!$submit)
include ("include/footer.inc.php");
?>