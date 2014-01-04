<?php
	
	function getImgPath($id){
		global $base_from_where,$table,$db;
		if ($id) {
			 
			if (!file_exists("img/generated/users/user_".$id.".jpg")){
		
				
				$sql = "SELECT photo FROM $base_from_where AND $table.id='$id'";
				$result = mysql_query($sql, $db);
				$r = mysql_fetch_array($result);
		
				$resultsnumber = mysql_numrows($result);
				$encoded = $r['photo'];
		
				//header('Content-Type: image/jpeg');
				//echo binaryImg($encoded);
		
				file_put_contents("img/generated/users/user_".$id.".jpg", binaryImg($encoded));
		
		
			}
		
		}
		return "img/generated/users/user_".$id.".jpg";
	}



?>