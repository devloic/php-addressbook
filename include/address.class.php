<?php

require_once "translations.inc.php";
include "phone.intl_prefixes.php";
include "birthday.class.php";
      
function getIfSetFromAddr($addr_array, $key) {

	if(isset($addr_array[$key])) {	  
	  // $result = mysql_real_escape_string($addr_array[$key]);
	  $result = $addr_array[$key];
	} else {
		$result = "";
	}
	return $result;
}

function trimAll($r) {
  $res = array();
  foreach($r as $key => $val) {
  	$res[$key] = trim($val);
  }
  return $res;
}   

function echoIfSet($addr_array, $key) {
	echo getIfSetFromAddr($addr_array, $key);
}


function deleteAddresses($part_sql) {

  global $keep_history, $domain_id, $base_from_where, $table, $table_grp_adr, $table_groups;

  $sql = "SELECT * FROM $base_from_where AND ".$part_sql;
  $result = mysql_query($sql);
  $resultsnumber = mysql_numrows($result);

  $is_valid = $resultsnumber > 0; 

  if($is_valid) {
  	if($keep_history) {
  	  $sql = "UPDATE $table
  	          SET deprecated = now()
  	          WHERE deprecated is null AND ".$part_sql." AND domain_id = ".$domain_id;
  	  mysql_query($sql);
  	  $sql = "UPDATE $table_grp_adr
  	          SET deprecated = now()
  	          WHERE deprecated is null AND ".$part_sql." AND domain_id = ".$domain_id;
  	  mysql_query($sql);
  	} else {
  	  $sql = "DELETE FROM $table_grp_adr WHERE ".$part_sql." AND domain_id = ".$domain_id;
  	  mysql_query($sql);
  	  $sql = "DELETE FROM $table         WHERE ".$part_sql." AND domain_id = ".$domain_id;
  	  mysql_query($sql);
    }
  }

  return $is_valid;
}

function saveAddress($addr_array, $group_name = "") {

	  global $domain_id, $table, $table_grp_adr, $table_groups, $month_lookup, $base_from_where;

    if(isset($addr_array['id'])) {
    	$set_id  = "'".$addr_array['id']."'";
    	$src_tbl = $month_lookup." WHERE bmonth_num = 1";
    } else {
    	$set_id  = "ifnull(max(id),0)+1"; // '0' is a bad ID
    	$src_tbl = $table;
    }
    
    $sql = "INSERT INTO $table ( domain_id, id, firstname, middlename, lastname, nickname, company, title, address, home, mobile, work, fax, email, email2, email3, homepage, facebookusername ,aday, amonth, ayear, bday, bmonth, byear, address2, phone2, photo, notes, position_1, position_2, position_3, position_4 , position_5 , position_6  , position_7   , position_8 , position_9  , position_10  , position_11, position_12 , position_13 , position_14 , position_15 , id_card_number , twitter, skype, president,vicepresident,treasurer,secretarygeneral,communication,trainer,referee,category,gender,attendance,first_exp_year,created, modified)
                        SELECT   $domain_id                                        domain_id
                               , ".$set_id."                                       id
                               , '".getIfSetFromAddr($addr_array, 'firstname')."'  firstname
                               , '".getIfSetFromAddr($addr_array, 'middlename')."' lastname
                               , '".getIfSetFromAddr($addr_array, 'lastname')."'   lastname
                               , '".getIfSetFromAddr($addr_array, 'nickname')."'   nickname
                               , '".getIfSetFromAddr($addr_array, 'company')."'    company
                               , '".getIfSetFromAddr($addr_array, 'title')."'      title
                               , '".getIfSetFromAddr($addr_array, 'address')."'    address
                               , '".getIfSetFromAddr($addr_array, 'home')."'       home
                               , '".getIfSetFromAddr($addr_array, 'mobile')."'     mobile
                               , '".getIfSetFromAddr($addr_array, 'work')."'       work
                               , '".getIfSetFromAddr($addr_array, 'fax')."'        fax
                               , '".getIfSetFromAddr($addr_array, 'email')."'      email
                               , '".getIfSetFromAddr($addr_array, 'email2')."'     email2
                               , '".getIfSetFromAddr($addr_array, 'email3')."'     email3
                               , '".getIfSetFromAddr($addr_array, 'homepage')."'   homepage
                               , '".getIfSetFromAddr($addr_array, 'facebookusername')."'   facebookusername
                               , '".getIfSetFromAddr($addr_array, 'aday')."'       aday
                               , '".getIfSetFromAddr($addr_array, 'amonth')."'     amonth
                               , '".getIfSetFromAddr($addr_array, 'ayear')."'      ayear
                               , '".getIfSetFromAddr($addr_array, 'bday')."'       bday
                               , '".getIfSetFromAddr($addr_array, 'bmonth')."'     bmonth
                               , '".getIfSetFromAddr($addr_array, 'byear')."'      byear
                               , '".getIfSetFromAddr($addr_array, 'address2')."'   address2
                               , '".getIfSetFromAddr($addr_array, 'phone2')."'     phone2
                               , '".getIfSetFromAddr($addr_array, 'photo')."'      photo
                               , '".getIfSetFromAddr($addr_array, 'notes')."'      notes
                               , '".getIfSetFromAddr($addr_array, 'position_1')."'      position_1
                               , '".getIfSetFromAddr($addr_array, 'position_2')."'      position_2
                               , '".getIfSetFromAddr($addr_array, 'position_3')."'      position_3
                               , '".getIfSetFromAddr($addr_array, 'position_4')."'      position_4
                               , '".getIfSetFromAddr($addr_array, 'position_5')."'      position_5
                               , '".getIfSetFromAddr($addr_array, 'position_6')."'      position_6
                               , '".getIfSetFromAddr($addr_array, 'position_7')."'      position_7
                               , '".getIfSetFromAddr($addr_array, 'position_8')."'      position_8
                               , '".getIfSetFromAddr($addr_array, 'position_9')."'      position_9
                               , '".getIfSetFromAddr($addr_array, 'position_10')."'      position_10
                               , '".getIfSetFromAddr($addr_array, 'position_11')."'      position_11
                               , '".getIfSetFromAddr($addr_array, 'position_12')."'      position_12
                               , '".getIfSetFromAddr($addr_array, 'position_13')."'      position_13
                               , '".getIfSetFromAddr($addr_array, 'position_14')."'      position_14
                               , '".getIfSetFromAddr($addr_array, 'position_15')."'      position_15
                               , '".getIfSetFromAddr($addr_array, 'id_card_number')."'   id_card_number
                               , '".getIfSetFromAddr($addr_array, 'twitter')."'   twitter
                               , '".getIfSetFromAddr($addr_array, 'skype')."'   skype
                               , '".getIfSetFromAddr($addr_array, 'president')."'   president
                               , '".getIfSetFromAddr($addr_array, 'vicepresident')."'   vicepresident
                               , '".getIfSetFromAddr($addr_array, 'treasurer')."'   treasurer
                               , '".getIfSetFromAddr($addr_array, 'secretarygeneral')."'   secretarygeneral
                               , '".getIfSetFromAddr($addr_array, 'communication')."'   communication
                               , '".getIfSetFromAddr($addr_array, 'trainer')."'   trainer
                               , '".getIfSetFromAddr($addr_array, 'referee')."'   referee
                               , '".getIfSetFromAddr($addr_array, 'category')."'   category
                               , '".getIfSetFromAddr($addr_array, 'gender')."'   gender
                               , '".getIfSetFromAddr($addr_array, 'attendance')."'   attendance
                               , '".getIfSetFromAddr($addr_array, 'first_exp_year')."'   first_exp_year					
                               , now(), now()
                            FROM ".$src_tbl;
    

    
    $result = mysql_query($sql);
    
    if(mysql_errno() > 0) {
      echo "MySQL: ".mysql_errno().": ".mysql_error();
    }

    $sql = "SELECT max(id) max_id from $table";
    $result = mysql_query($sql);
    $rec = mysql_fetch_array($result);
    $id = $rec['max_id'];

    if(!isset($addr_array['id']) && $group_name) {
    	$sql = "INSERT INTO $table_grp_adr SELECT $domain_id domain_id, $id id, group_id, now(), now(), NULL FROM $table_groups WHERE group_name = '$group_name'";
    	$result = mysql_query($sql);
    }
    
    //adding to the group of the current user
    $login = AuthLoginFactory::getBestLogin ();;
    $user_group=$login->getUser()->getGroup();
    if(!isset($addr_array['id']) && $user_group!='') {
    	$sql = "INSERT INTO $table_grp_adr SELECT $domain_id domain_id, $id id, group_id, now(), now(), NULL FROM $table_groups WHERE group_name = '$user_group'";
    	$result = mysql_query($sql);
    }
    
    return $id;
}

function updateAddress($addr, $keep_photo = true) {

  global $keep_history, $domain_id, $base_from_where, $table, $table_grp_adr, $table_groups;

	$addresses = Addresses::withID($addr['id']);
	$resultsnumber = $addresses->count();

	$homepage = str_replace('http://', '', $addr['homepage']);

	$is_valid = $resultsnumber > 0;

	if($is_valid)
	{
		if($keep_history) {
		
			// Get current photo, if "$keep_photo"
			if($keep_photo) {
		 	  $r = $addresses->nextAddress()->getData();
		 	  $addr['photo'] = $r['photo'];
			}

	    $sql = "UPDATE $table
	               SET deprecated = now()
		           WHERE deprecated is null
		             AND id	       = '".$addr['id']."'
		             AND domain_id = '".$domain_id."';";
    	$result = mysql_query($sql);
    	
		  saveAddress($addr);
		} else {
	    $sql = "UPDATE $table SET firstname = '".$addr['firstname']."'
	                            , lastname  = '".$addr['lastname']."'
	                            , middlename  = '".$addr['middlename']."'
	                            , nickname  = '".$addr['nickname']."'
	                            , company   = '".$addr['company']."'
	                            , title     = '".$addr['title']."'
	                            , address   = '".$addr['address']."'
	                            , home      = '".$addr['home']."'
	                            , mobile    = '".$addr['mobile']."'
	                            , work      = '".$addr['work']."'
	                            , fax       = '".$addr['fax']."'
	                            , email     = '".$addr['email']."'
	                            , email2    = '".$addr['email2']."'
	                            , email3    = '".$addr['email3']."'
	                            , homepage  = '".$addr['homepage']."'
	                            , facebookusername  = '".$addr['facebookusername']."'
	                            , aday      = '".$addr['aday']."'
	                            , amonth    = '".$addr['amonth']."'
	                            , ayear     = '".$addr['ayear']."'
	                            , bday      = '".$addr['bday']."'
	                            , bmonth    = '".$addr['bmonth']."'
	                            , byear     = '".$addr['byear']."'
	                            , address2  = '".$addr['address2']."'
	                            , phone2    = '".$addr['phone2']."'
	                            , notes     = '".$addr['notes']."'
	                            , position_1     = '".$addr['position_1']."'
								, position_2     = '".$addr['position_2']."'
								, position_3     = '".$addr['position_3']."'
								, position_4     = '".$addr['position_4']."'
								, position_5     = '".$addr['position_5']."'
								, position_6     = '".$addr['position_6']."'
								, position_7     = '".$addr['position_7']."'
								, position_8     = '".$addr['position_8']."'
								, position_9     = '".$addr['position_9']."'
								, position_10     = '".$addr['position_10']."'
								, position_11     = '".$addr['position_11']."'
								, position_12     = '".$addr['position_12']."'
								, position_13     = '".$addr['position_13']."'
								, position_14     = '".$addr['position_14']."'
								, position_15     = '".$addr['position_15']."'	
								, id_card_number     = '".$addr['id_card_number']."'
								, twitter     = '".$addr['twitter']."'
								, skype     = '".$addr['skype']."'
								, president     = '".$addr['president']."'
								, vicepresident     = '".$addr['vicepresident']."'
								, treasurer     = '".$addr['treasurer']."'
								, secretarygeneral     = '".$addr['secretarygeneral']."'
								, communication     = '".$addr['communication']."'
								, trainer     = '".$addr['trainer']."'
								, referee     = '".$addr['referee']."'
							    , category     = '".$addr['category']."'
								, gender     = '".$addr['gender']."'
								, attendance     = '".$addr['attendance']."'
								, first_exp_year     = '".$addr['first_exp_year']."'											
	    ".($keep_photo ? "" : ", photo     = '".$addr['photo']."'")."
	                            , modified  = now()
		                        WHERE id        = '".$addr['id']."'
		                          AND domain_id = '$domain_id';";
	    
		  $result = mysql_query($sql);
    }
		// header("Location: view?id=$id");
    }

	return $is_valid;
	 
}

$phone_delims = array("'", '/', "-", " ", "(", ")", ".");

class Address {

    private $address; // mother of all data
    
    private $phones;
    private $emails;

    function __construct($data) {
    	$this->address = $data;
    	$this->phones = $this->getPhones();
    	$this->emails = $this->getEMails();
    }

    public function getData() {
        return $this->address;
    }

    public function getEMails() {

      $result = array();
    	if($this->address["email"]   != "") $result[] = $this->address["email"];
    	if($this->address["email2"]  != "") $result[] = $this->address["email2"];
    	if($this->address["email3"]  != "") $result[] = $this->address["email3"];
    	return $result;
    }

    public function firstEMail() {
      return (!empty($this->emails) ? $this->emails[0] : "");
    }

    public function getBirthday() {
    	return new Birthday($this->address, "b");
    }

    //
    // Phone order home->mobile->work->phone2
    //
    public function getPhones() {

      $phones = array();
    	if($this->address["home"]   != "") $phones[] = $this->address["home"];
    	if($this->address["mobile"] != "") $phones[] = $this->address["mobile"];
    	if($this->address["work"]   != "") $phones[] = $this->address["work"];
    	if($this->address["phone2"] != "") $phones[] = $this->address["phone2"];
   	  return $phones;
   	}

    public function hasPhone() {

      return !empty($this->phones);
   	}

    public function firstPhone() {
      return (!empty($this->phones) ? $this->phones[0] : "");
    }

    //
    // Create a unified format for comparison an display.
    //
    public function unifyPhones( $phones
    	 	 	 	   , $prefix = ""
                               , $remove_prefix = false ) {
                              	
      global $intl_prefix_reg, $default_provider, $phone_delims;
                              	
      $unifons = array();
                              	
     // Remove all optical delimiters
     foreach($phones as $phone) {
    	foreach($phone_delims as $phone_delim) {
    		$phone = str_replace($phone_delim, "", $phone);
    	}
                
    	if($prefix != "" || $remove_prefix = true) {
    		
    	  // Replace 00xxx => +xx
    	  $phone = preg_replace('/^00/', "+", $phone);
        
    	  // Replace 0 with $prefix (00 is already "+")
    	  if($prefix != "") {
    	    $phone = preg_replace('/^0/', $prefix, $phone);
    	  }
        
    	  // Replace xx (0) yy => xxyy
        $phone = preg_replace("/^(".$intl_prefix_reg.")0/", '${1}', $phone);   		
                
    	  // Replace +xx with 0
    	  if($remove_prefix) {
    	  	if(isset($default_provider)) {
    	  		$remove_prefixes = str_replace("+", "\+",$default_provider);
    	  	} else {
    	  		$remove_prefixes = $intl_prefix_reg;
    	  	}
    	  	$phone = preg_replace("/^(".$remove_prefixes.")/", "0", $phone);
        }
      }
        $unifons[] = $phone;  
      }
      return $unifons;

    }
    
	public function unifyPhone( $prefix = ""
                              , $remove_prefix = false ) {
       $phones = array();
       $phones[] = $this->firstPhone();
       
       $unifons = $this->unifyPhones($phones, $prefix, $remove_prefix);
       return $unifons[0];            
    }

    //
    // Show the phone number in the shortes readable format.
    //
    public function shortPhone() {
    	return $this->unifyPhone();
    }

    public function shortPhones() {
    	return $this->unifyPhones($this->getPhones());
    }
}

class Addresses {

    private $result;

    function likePhone($row, $searchword) {
    	
    	global $phone_delims;
    	
    	$replace = $row;
    	$like    = "'$searchword'";
     	foreach($phone_delims as $phone_delim) {
    	  $replace = "replace(".$replace.", '".mysql_real_escape_string($phone_delim)."','')"; 
    	  $like    = "replace(".$like.   ", '".mysql_real_escape_string($phone_delim)."','')"; 
     	}     	
     	return $replace." LIKE CONCAT('%',".$like.",'%')";    	
    }

    protected function loadBy($load_type, $searchstring, $alphabet = "") {

	    global $base_from_where, $table;

     	$sql = "SELECT DISTINCT $table.* FROM $base_from_where";

      if($load_type == 'id') {

	 	    $sql .= " AND $table.id='$searchstring'";

      } elseif ($searchstring) {

          $searchwords = explode(" ", $searchstring);

          foreach($searchwords as $searchword) {
          	$sql .= "AND (   lastname   LIKE '%$searchword%'
                          OR middlename LIKE '%$searchword%'
                          OR firstname  LIKE '%$searchword%'
                          OR nickname   LIKE '%$searchword%'
                          OR company    LIKE '%$searchword%'
                          OR address    LIKE '%$searchword%'
                          OR ".$this->likePhone('home',   $searchword)."
                          OR ".$this->likePhone('work',   $searchword)."
                          OR ".$this->likePhone('mobile', $searchword)."
                          OR ".$this->likePhone('fax',    $searchword)."
                          OR email      LIKE '%$searchword%'
                          OR email2     LIKE '%$searchword%'
                          OR email3     LIKE '%$searchword%'
                          OR address2   LIKE '%$searchword%'
                          OR notes      LIKE '%$searchword%'
                          )";
          }
      }
      
      if($alphabet) {
      	$sql .= "AND (   lastname  LIKE  '$alphabet%'
                      OR middlename LIKE '$alphabet%'
                      OR nickname  LIKE  '$alphabet%'
                      OR firstname LIKE  '$alphabet%'
                      )";
      }

      if(true) {
          $sql .= "ORDER BY lastname, firstname ASC";
      } else {
        	$sql .= "ORDER BY firstname, lastname ASC";
      }

      //* Paging
      $page = 1;
      $pagesize = 2200;
      if($pagesize > 0) {
          $sql .= " LIMIT ".($page-1)*$pagesize.",".$pagesize;
      }
      //*/
      $this->result = mysql_query($sql);
      
    }

    public static function withSearchString($searchstring, $alphabet = "") {
    	$instance = new self();
    	$instance->loadBy($searchstring, $alphabet);
    	return $instance;
    }

    public static function withID( $id ) {
    	$instance = new self();
    	$instance->loadBy('id', $id );
    	return $instance;
    }

    public function nextAddress() {

    	$myrow = mysql_fetch_array($this->result);
    	if($myrow) {
		      return new Address(trimAll($myrow));
		  } else {
		      return false;
		  }
    }

    public function getResults() {
    	return $this->result;
    }
    
    public function count() {
    	return mysql_numrows($this->getResults());
    }
}
?>