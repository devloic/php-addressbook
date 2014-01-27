<?php 



$sql = "SELECT $table.*, b_month_lookup.bmonth_num FROM $month_from_where ORDER BY lastname, firstname ASC";


$result = mysql_query($sql);
$resultsnumber = mysql_numrows($result);


$row=1;
$activeSheet=$objPHPExcel->setActiveSheetIndex(0);
$activeSheet->setCellValueByColumnAndRow(0,$row, ucfmsg("LASTNAME"));
$activeSheet->setCellValueByColumnAndRow(1,$row, ucfmsg("FIRSTNAME"));
$activeSheet->setCellValueByColumnAndRow(2,$row, ucfmsg("BIRTHDAY"));
$activeSheet->setCellValueByColumnAndRow(3,$row, ucfmsg("ADDRESS"));
if($zip_pattern != "")
{
	$activeSheet->setCellValueByColumnAndRow(4,$row, ucfmsg("ZIP"));
	$activeSheet->setCellValueByColumnAndRow(5,$row, ucfmsg("CITY"));
}

$activeSheet->setCellValueByColumnAndRow(6,$row, ucfmsg("PHONE_HOME"));
$activeSheet->setCellValueByColumnAndRow(7,$row, ucfmsg("PHONE_MOBILE"));
$activeSheet->setCellValueByColumnAndRow(8,$row, ucfmsg("E_MAIL_HOME"));
$activeSheet->setCellValueByColumnAndRow(9,$row,ucfmsg("PHONE_WORK"));
$activeSheet->setCellValueByColumnAndRow(10,$row, ucfmsg("FAX"));
$activeSheet->setCellValueByColumnAndRow(11,$row, ucfmsg("E_MAIL_OFFICE"));
$activeSheet->setCellValueByColumnAndRow(12,$row, ucfmsg("2ND_ADDRESS"));
$activeSheet->setCellValueByColumnAndRow(13,$row, ucfmsg("2ND_PHONE"));
$activeSheet->setCellValueByColumnAndRow(14,$row, ucfmsg("FACEBOOK"));
$activeSheet->setCellValueByColumnAndRow(15,$row, ucfmsg("SKYPE"));
$activeSheet->setCellValueByColumnAndRow(16,$row, ucfmsg("TWITTER"));
$activeSheet->setCellValueByColumnAndRow(17,$row, ucfmsg("ID_CARD_NUMBER"));

$row=2;
while ($myrow = mysql_fetch_array($result))
{




$activeSheet->setCellValueByColumnAndRow(0,$row, $myrow["lastname"]);
$activeSheet->setCellValueByColumnAndRow(1,$row, $myrow["firstname"]);


		$day    = $myrow["bday"];
		$year   = $myrow["byear"];
		$month  = $myrow["bmonth_num"];
		$activeSheet->setCellValueByColumnAndRow(2,$row, ($day > 0 ? "$day.":"").($month != null ? "$month." : "")."$year");
		

		  # Home contact
		  if($zip_pattern != "")
		  {
		  $address = "";
		  $zip     = "";
		  $city    = "";
		  preg_match( "/(.*)(\b".$zip_pattern."\b)(.*)/m"
		  , str_replace("\r", "", str_replace("\n", ", ", trim($myrow["address"]))), $matches);
		  if(count($matches) > 1)
		  		$address = preg_replace("/,$/", "", trim($matches[1]));
		  		if(count($matches) > 2)
		  	$zip = $matches[2];
		  	if(count($matches) > 3)
		  	$city = preg_replace("/^,/", "", trim($matches[3]));
		  	$activeSheet->setCellValueByColumnAndRow(3,$row, $address);
		  	$activeSheet->setCellValueByColumnAndRow(4,$row, $zip);
		  	$activeSheet->setCellValueByColumnAndRow(5,$row, $city);
		  	
		  }
		  //else add($myrow["address"]);

		  # Privat contact
		  $activeSheet->setCellValueByColumnAndRow(6,$row, $myrow["home"]);
		  $activeSheet->setCellValueByColumnAndRow(7,$row, $myrow["mobile"]);
		  $activeSheet->setCellValueByColumnAndRow(8,$row, $myrow["email"]);
		  

		  # Work contact
		   $activeSheet->setCellValueByColumnAndRow(9,$row, $myrow["work"]);
		   $activeSheet->setCellValueByColumnAndRow(10,$row, $myrow["fax"]);
		   $activeSheet->setCellValueByColumnAndRow(11,$row, $myrow["email2"]);
		 

		  		# 2nd contact
		   $activeSheet->setCellValueByColumnAndRow(12,$row, $myrow["address2"]);
		   $activeSheet->setCellValueByColumnAndRow(13,$row, $myrow["phone2"]);
		

		  #facebook, skype,twitter
		   $activeSheet->setCellValueByColumnAndRow(14,$row, $myrow["facebookusername"]);
		   $activeSheet->setCellValueByColumnAndRow(15,$row, $myrow["skype"]);
		   $activeSheet->setCellValueByColumnAndRow(16,$row, $myrow["twitter"]);
		   $activeSheet->setCellValueByColumnAndRow(17,$row, $myrow["id_card_number"]);
		 

		   $row++;
}

?>