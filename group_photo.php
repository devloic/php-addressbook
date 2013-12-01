<?php
include ("include/dbconnect.php");
include ("include/photo.class.php");

if ($id) {
	
	$sql = "SELECT group_logo FROM $groups_from_where AND $table_groups.group_id=$id";
	$result = mysql_query ( $sql, $db );
	$r = mysql_fetch_array ( $result );
	
	$resultsnumber = mysql_numrows ( $result );
}

$encoded = $r ['group_logo'];

if ($encoded != '') {
	header ( 'Content-Type: image/jpeg' );
	echo binaryImg ( $encoded );
}

?>