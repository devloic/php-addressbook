<?php
  $app_id = '363409343725130';
  $app_secret = 'd81efa04bb88e20c75e4340b0a8d5ca9';
  $my_url = 'http://localhost/php-addressbook/fb/';

  $code = $_REQUEST["code"];
 
 
 
 //auth user
 if(empty($code)) {
    $dialog_url = 'https://www.facebook.com/dialog/oauth?client_id=' 
    . $app_id . '&redirect_uri=' . urlencode($my_url) ;
    echo("<script>top.location.href='" . $dialog_url . "'</script>");
  }

  //get user access_token
  $token_url = 'https://graph.facebook.com/oauth/access_token?client_id='
    . $app_id . '&redirect_uri=' . urlencode($my_url) 
    . '&client_secret=' . $app_secret 
    . '&code=' . $code;
  $access_token = file_get_contents($token_url);
 
  // Run fql query
  $fql_query_url = 'https://graph.facebook.com/'
    . '/fql?q=SELECT+uid+FROM+group_member+WHERE+gid=213230898810622'
    . '&' . $access_token;
  $fql_query_result = file_get_contents($fql_query_url);
  //http://stackoverflow.com/questions/7695794/facebook-id-integers-being-returned-oddly
  $fql_query_result=preg_replace('/"uid":(\d+)/', '"uid":"$1"', $fql_query_result );

  $fql_query_obj = json_decode($fql_query_result, true);

  //display results of fql query
  echo '<pre>';
  print_r("query results:");
  //print_r($fql_query_obj);
  echo '</pre>';
  
  $uids='';
  foreach ($fql_query_obj["data"] as $key => $value){
	//echo $key . ':'.$value['uid'].'<br/>';
	$uids = $uids.','.$value['uid'];
  }
  $uids=substr($uids,1);
 
  
  // Run fql query
  $fql_query_url = 'https://graph.facebook.com/'
    . '/fql?q=SELECT+pic_big,uid,name,first_name,username,profile_url+FROM+user+WHERE+uid+in+('.$uids.')'
    . '&' . $access_token;
	//
	//pic_big,uid,name,username
	//SELECT+uid,username,first_name,middle_name,last_name,name,pic_small,pic_big,pic_square,pic,affiliations,profile_update_time,timezone,religion,birthday,birthday_date,devices,sex,hometown_location,meeting_sex,meeting_for,relationship_status,significant_other_id,political,current_location,activities,interests,is_app_user,music,tv,movies,books,quotes,about_me,hs_info,education_history,work_history,notes_count,wall_count,status,has_added_app,online_presence,locale,proxied_email,profile_url,email_hashes,pic_small_with_logo,pic_big_with_logo,pic_square_with_logo,pic_with_logo,pic_cover,allowed_restrictions,verified,profile_blurb,family,website,is_blocked,contact_email,email,third_party_id,name_format,video_upload_limits,games,work,education,sports,favorite_athletes,favorite_teams,inspirational_people,languages,likes_count,friend_count,mutual_friend_count,can_post
  $fql_query_result = file_get_contents($fql_query_url);
  $fql_query_result=preg_replace('/"uid":(\d+)/', '"uid":"$1"', $fql_query_result );

  $fql_query_obj = json_decode($fql_query_result, true);
  //display results of fql query
  
 
  echo '<pre>';
  print_r("query results:");
  print_r($fql_query_obj);
  echo '</pre>';
   
  $result='';
  $result_no_username='';
  foreach ($fql_query_obj["data"] as $key => $value){
	  if (! empty($value['username'])){
		$result .= $value['username'].'@facebook.com;'.$value['first_name'].";;;;;;;;;;;;;;</br>";
	  }else{
		$result_no_username .= $value['profile_url']."</br>";
	  }
  }
  echo $result;
  echo $result_no_username;
 die();
  
foreach ($fql_query_obj["data"] as $key => $value){
	if ( !file_exists('./pics/'.$value['uid'].'_'.iconv("UTF-8", "ISO-8859-1", $value['name']).'.jpg')){
		$sourcecode= file_get_contents($value['pic_big']);
		echo "writing ".'./pics/'.$value['uid'].'_'.iconv("UTF-8", "ISO-8859-1", $value['name']).'.jpg'.'<br/>';
		$savefile = fopen('./pics/'.$value['uid'].'_'.iconv("UTF-8", "ISO-8859-1", $value['name']).'.jpg', 'w');
		fwrite($savefile, $sourcecode);
		fclose($savefile);
	}
}
  

  
?>