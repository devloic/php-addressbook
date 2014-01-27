<?php


	$off = (isset($off) ? $off : 0);
	
  	 $addr = array();
  	 $addr['lastname']  = getIfSet($rec,0+$off);
  	 $addr['firstname'] = getIfSet($rec,1+$off);
  	 $addr['company']   = ""; // tbd at export

     $date_parts        = explode(".", getIfSet($rec,2+$off));
     if(count($date_parts) == 3) {
  	   $addr['bday']      = ltrim($date_parts[0],"0");
  	   $addr['bmonth']    = MonthToName($date_parts[1]);
  	   $addr['byear']     = $date_parts[2];
  	 }
  	 
  	 $addr['address']   = getIfSet($rec,3+$off)."\n"
  	                     .getIfSet($rec,4+$off)." ".getIfSet($rec,5);
                        
  	 $addr['home']      = getIfSet($rec,6+$off);
  	 $addr['mobile']    = getIfSet($rec,7+$off);
  	 $addr['work']      = getIfSet($rec,9+$off);
  	 $addr['fax']       = getIfSet($rec,10+$off);
  	                    
  	 $addr['email']     = getIfSet($rec,8+$off);
  	 $addr['email2']    = getIfSet($rec,11+$off);
  	                    
  	 $addr['address2']  = str_replace(", ", "\n", getIfSet($rec,12));
  	 $addr['phone2']    = getIfSet($rec,13+$off);
  	 $addr['facebookusername']    = getIfSet($rec,14+$off);
  	 $addr['skype']    = getIfSet($rec,15+$off);
  	 $addr['twitter']    = getIfSet($rec,16+$off);
  	 $addr['id_card_number']    = getIfSet($rec,17+$off);
  	 $attendance = getIfSet($rec,18+$off);
  	 if($attendance ==""){
  	 	$attendance="0";
  	 }
  	 $addr['attendance']    = $attendance;
  	 $gender = getIfSet($rec,19+$off);
  	 if($gender ==""){
  	 	$gender="0";
  	 }
  	 $addr['gender']    = $gender;
  	 $category = getIfSet($rec,20+$off);
  	 if($category ==""){
  	 	$category="0";
  	 }
  	 $addr['category']    = $category;
  	 
  	 
?>