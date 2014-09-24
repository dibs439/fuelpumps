<?php
	function redirect($url) {
		header("location:$url");
		exit;
	}
	
	function htaccessURL($url='',$cat='') {
		$strurl = $url."/".$cat;
		return $strurl;
	}
	


	// Accepts the following parameters :
	// 1. tablename
	// 2. field_values array
	
	function get_num_record($table, $fields_values) 
	{
	
		global $project_vars;
		$sql = "SELECT id FROM " . get_table_name($table) . " WHERE ";
		
		$i = 0;
		$cnt = 0;
		if(isset($fields_values) && count($fields_values))
		{
			foreach($fields_values as $key=>$val)
			{
				if($i > 0)
					$sql.= " AND ";
				$sql.= $key." = '".addslashes($val)."'";
				$i++;
			}
			
			$res = mysql_query($sql) or mysql_error_show($sql,__FILE__,__LINE__);
			$cnt = mysql_num_rows($res);
		}
		
		return $cnt;
		
	}
	
	
		
	function get_resourceid($id,$table,$fld='id',$op="=",$comma="'") {
		global $project_vars;
		$sql = "SELECT * FROM " . get_table_name($table); 
		$res = mysql_query($sql) or mysql_error_show($sql,__FILE__,__LINE__);
			if(mysql_num_rows($res) >0){
					return $res;
				}else{
					return 0;
				}
		
	}
	
	function array_operation1($field, $location= array()){
	 $str ='';
		  if(is_array($location) && sizeof($location)>0){
			  $str = " WHERE ";
				foreach($location as $key=>$val){ 
					if(!is_null($val)){						 
						 $str.=  $field .' =  "'. $val .'" or ';
					 } 			   
				  }
		  }  
			$str =  substr($str,0,-3);
			return $str;
	}


	function array_operation2($location = array()){
		 $str ='';
			  if(is_array($location) && sizeof($location)>0){			  
					foreach($location as $key=>$val){ 
						if(!is_null($val)){						 
							 $str.=  $key .' =  "'. $val .'" , ';
						 } 			   
					  }
			  }  
			 $str =  substr($str,0,-2);   
				return $str;
	 }

	function update_consumer($table, $arr1, $where=''){
	global $project_vars;
	$sql = '';
	$str  = array_operation2($arr1);	
		if($str){
		  $sql  = " UPDATE ".$table." SET  ".$str." ".$where;  
		  $res = mysql_query($sql) or mysql_error_show($sql,__FILE__,__LINE__);
				if(mysql_affected_rows()>0){
					return 1;
				  }
		   }
	 return 0;
	}
	
	
	
	function update_single_field($table, $id, $field, $value)
	{
		global $project_vars;
		$sql = " UPDATE " . get_table_name($table) . " SET " . $field . "='" . $value . "' WHERE id LIKE '" . $id . "'";
		//echo $sql; 
		mysql_query($sql) or mysql_error_show($sql,__FILE__,__LINE__);
		if(mysql_affected_rows()>0){
			return 1;
		} else {
			return 0;
		}
	}
	


	
	function insert($table, $arr1, $autoinc=true, $dates=true)
	{
		global $project_vars;
		$sql = '';
		$str1 ='';
		$str2 ='';
		$n = 0;
		
		
		if(sizeof($arr1) > 0 && is_array($arr1))
		{
		
			if($autoinc)
			{
				$str1 ='(id,';
				$str2 ='VALUES (uuid(),';
			}
			else
			{
				$str1 ='(';
				$str2 ='VALUES (';
			}
			
			foreach($arr1 as $key=>$val)
			{
				if($n > 0)
				{
					$str1.= ",";
					$str2.= ",";
				}
				
				$str1.= $key;
				$str2.="'".addslashes(trim($val))."'";
				$n++;
			}
			
			//$str1	   = substr($str1,0,-1);
			//$str2	   = substr($str2,0,-1);
			if($dates)
			{
				$str1      = $str1.' , created, modified)';
				$str2      = $str2.' , NOW(), NOW())';
			}
			else
			{
				$str1      = $str1.')';
				$str2      = $str2.')';
			}
			
			}
			if($str1 <> "" && $str2 <> "")
			{
				$sql = " INSERT INTO ".$table."  ".$str1." ".$str2; 
				$res = mysql_query($sql) or mysql_error_show($sql,__FILE__,__LINE__);
				//echo $sql;
				if(mysql_affected_rows()>0)
					return 1;
				else
					return 0;
				
			}			
			return 0;
	}
	
	// For UUID
	function insert2($table, $arr1, $autoinc=true, $dates=true)
	{
		global $project_vars;
		$sql = '';
		$str1 ='';
		$str2 ='';
		$n = 0;
		
		
		if(sizeof($arr1) > 0 && is_array($arr1))
		{
		
			if($autoinc)
			{
				$sql2 = "SELECT UUID()";
				$result2 = mysql_query($sql2);
				$row2 = mysql_fetch_row($result2);
				$uuid = $row2[0];
				
				$str1 ="(id,";
				$str2 ="VALUES ('".$uuid."',";
			}
			else
			{
				$str1 ="(";
				$str2 ="VALUES (";
			}
			
			foreach($arr1 as $key=>$val)
			{
				if($n > 0)
				{
					$str1.= ",";
					$str2.= ",";
				}
				
				$str1.= $key;
				$str2.="'".addslashes(trim($val))."'";
				$n++;
			}
			
			if($dates)
			{
				$str1      = $str1.' , created, modified)';
				$str2      = $str2.' , NOW(), NOW())';
			}
			else
			{
				$str1      = $str1.')';
				$str2      = $str2.')';
			}
			
		}
		if($str1 <> "" && $str2 <> "")
		{
			$sql = " INSERT INTO ".$table."  ".$str1." ".$str2; 
			
			$res = mysql_query($sql) or mysql_error_show($sql,__FILE__,__LINE__);
			
			if(mysql_affected_rows()>0)
			{
				return $uuid;
			}
			else
				return 0;
			
		}			
		return 0;
	}
	
	function make_array($field1, $res)
	{
		$arr1 = array();
		
		if($field1 && $res){
			while($ka = mysql_fetch_assoc($res)){
				if($ka[$field1]){
				 $arr1[$field1.++$i]= $ka[$field1];
				}
			}
		}
		
		return $arr1;
	}


	function get_where_record($table, $where=''){
		global $project_vars;
		$sql = "SELECT * FROM " . get_table_name($table)." ".$where; 
		$res = mysql_query($sql) or mysql_error_show($sql,__FILE__,__LINE__);
		if(mysql_num_rows($res) >0){
			return $res;
		}else{
			return 0;
		}
	 }
	
	function get_strimg_format($str){
		if(!empty($str)){
		 return "#".$str."*";
		}	
		return 0;
	}
	
	
	function row_exists2($table, $where='') {
		global $project_vars;
		$sql = "SELECT * FROM " . get_table_name($table) . "  " .$where;
		$res = mysql_query($sql) or mysql_error_show($sql,__FILE__,__LINE__);
		if(mysql_num_rows($res) >=1){
			return 1;
		}else{
			return 0;
		}
	}

	function row_data2($table, $where='') {
		global $project_vars;
		$sql = "SELECT * FROM " . get_table_name($table) . "  " .$where;
		$res = mysql_query($sql) or mysql_error_show($sql,__FILE__,__LINE__);
		if(mysql_num_rows($res) >=1){
			return 1;
		}else{
			return 0;
		}
	}



	function distance($lat1,$lon1,$lat2,$lon2) { 
		$theta = $lon1 - $lon2; 
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
		$dist = acos($dist); 
		$dist = rad2deg($dist); 
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);
	
		/*
		if ($unit == "K") {
			return ($miles * 1.609344); 
		} else if ($unit == "N") {
			return ($miles * 0.8684);
		} else {
			return $miles;
		}
		*/
		
		return ($miles * 1.609344); 	  
	}
	
	function genRandomString($length=10, $format="M") 
	{
		//$length = 10;
		if($format == "A")
			$characters = "abcdefghijklmnopqrstuvwxyz";
		else if($format == "N")
			$characters = "0123456789";
		else
			$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
		
		
		$string = "";    
	
		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters))];
		}
	
		return $string;
	}
	
	function update_record($table, $update_field_values, $conditions_field_values) 
	{
		$var = 0;
		if(isset($update_field_values) && count($update_field_values) > 0)
		{
			$sql = "UPDATE " . get_table_name($table) . " SET ";
			$i = 0;
			$j = 0;
			foreach($update_field_values as $key=>$val)
			{
				if($i > 0)
					$sql.= ", ";
				$sql.= $key." = '".addslashes($val)."'";
				$i++;
			}
			
			if(count($conditions_field_values) > 0)
			{
				$sql.= " WHERE ";
				
				foreach($conditions_field_values as $key=>$val)
				{
					if($j > 0)
						$sql.= " AND ";
					$sql.= $key." = '".addslashes($val)."'";
					$j++;
				}
				
			}
			//echo $sql."<br />";
			$var = mysql_query($sql) or mysql_error_show($sql,__FILE__,__LINE__);
		}
		return $var;
		
		
	}
	
	function get_record($table, $fields_to_fetch="*", $conditions_field_values, $order_field="", $order="", $limit="") 
	{
		$var = 0; $row = NULL;
		if($fields_to_fetch <> "")
		{
			$sql = "SELECT " . $fields_to_fetch ." FROM " . get_table_name($table);
			
			$j = 0;
			if(count($conditions_field_values) > 0)
			{
				$sql.= " WHERE ";
				
				foreach($conditions_field_values as $key=>$val)
				{
					if($j > 0)
						$sql.= " AND ";
					$key = trim($key);
					$params = explode(' ', $key);
					if(count($params) > 1)
					{
						$field = $params[0];
						$op = $params[1];
					}
					else
					{
						$field = $key;
						$op = "=";
					}
					
					$sql.= $field." ".$op." '".addslashes($val)."'";
					$j++;
				}
			}
			
			if($order_field <> "")
				$sql.= " order by ".$order_field;
			
			if($order <> "")
				$sql.= " ".$order;
			
			if($limit <> "")
				$sql.= " limit 0, ".$limit;
			
			//echo $sql."<br>";
			
			$res = mysql_query($sql) or mysql_error_show($sql,__FILE__,__LINE__);

			if($row = mysql_fetch_assoc($res))
			{
				$row = array_map('stripslashes', $row); 
			}
			return $row;
		}
	}

	function get_count_records($table, $count_field, $fields_to_fetch="*", $conditions_field_values, $group_field, $order_field="", $order="", $limit="") 
	{
		$var = 0; $row = NULL;
		if($count_field <> "")
		{
			if($fields_to_fetch <> "")
				$sql = "SELECT COUNT( ".$count_field." ) AS counter, ".$fields_to_fetch." FROM ". get_table_name($table)."";
			else
				$sql = "SELECT COUNT( ".$count_field." ) AS counter FROM ". get_table_name($table)."";
			
		
			
			$j = 0;
			if(count($conditions_field_values) > 0)
			{
				$sql.= " WHERE ";
				
				foreach($conditions_field_values as $key=>$val)
				{
					if($j > 0)
						$sql.= " AND ";
					$key = trim($key);
					$params = explode(' ', $key);
					if(count($params) > 1)
					{
						$field = $params[0];
						$op = $params[1];
					}
					else
					{
						$field = $key;
						$op = "=";
					}
					
					$sql.= $field." ".$op." '".addslashes($val)."'";
					$j++;
				}
			}
			
			if($group_field <> "")
				$sql.= " GROUP BY ".$group_field;
			
			if($order_field <> "")
				$sql.= " ORDER BY ".$order_field;
			
			if($order <> "")
				$sql.= " ".$order;
			
			if($limit <> "")
				$sql.= " LIMIT 0, ".$limit;
			
			//echo $sql."<br>";
			
			$res = mysql_query($sql) or mysql_error_show($sql,__FILE__,__LINE__);

			$rows = NULL;
			while($row = mysql_fetch_assoc($res))
			{
				$row = array_map('stripslashes', $row); 
				$rows[] = $row;

			}
			return $rows;
		}
	}
	
	function get_matching_records($table, $fields_to_fetch="*", $conditions_field_values, $order_field="", $order="", $limit="") 
	{
		$var = 0; $row = NULL;
		if($fields_to_fetch <> "")
		{
			$sql = "SELECT " . $fields_to_fetch ." FROM " . get_table_name($table);
			
			$j = 0;
			if(count($conditions_field_values) > 0)
			{
				$sql.= " WHERE ";
				
				foreach($conditions_field_values as $key=>$val)
				{
					if(strpos($key, "<>") > 0)
					{
						$pos = strpos($key, "<>");
						$fld = substr($key, 0, $pos);
						$op = substr($key, $pos, strlen($key));
					}
					else
					{
						$fld = $key;
						$op = "=";
					}
					if($j > 0)
						$sql.= " AND ";
					
					$sql.= $fld." ".$op." '".addslashes($val)."'";
					$j++;
				}
			}
			
			
			if($order_field <> "")
				$sql.= " order by ".$order_field;
			
			if($order <> "")
				$sql.= " ".$order;
			
			if($limit <> "")
				$sql.= " limit 0, ".$limit;
			
			//echo $sql."<br>";
			$res = mysql_query($sql) or mysql_error_show($sql,__FILE__,__LINE__);

			while($row = mysql_fetch_assoc($res))
			{
				$row = array_map('stripslashes', $row); 
				$rows[] = $row;

			}
			//print_r($row);
			return $rows;
		}
	}
	
	// Handles OR conditions
	function get_records($table, $fields_to_fetch="*", $conditions_field_values, $order_field="", $order="", $limit="") 
	{
		$var = 0; $row = NULL;
		if($fields_to_fetch <> "")
		{
			mysql_query ("set character_set_results='utf8'");
			$sql = "SELECT " . $fields_to_fetch ." FROM " . get_table_name($table);
			
			$j = 0;
			$fkey = "AND";
			if(count($conditions_field_values) > 0)
			{
				$sql.= " WHERE 1=1 ";
				
				foreach($conditions_field_values as $fkey=>$fval)
				{
				
					if(strtoupper($fkey) == "OR")
					{
						$fkey = strtoupper($fkey);
						// Conditions inside $val
						if(is_array($fval))
						{
							$cond_array = $fval;

							foreach($cond_array as $key=>$val)
							{
								if(strpos($key, "<>") > 0)
								{
									$pos = strpos($key, "<>");
									$fld = substr($key, 0, $pos);
									$op = substr($key, $pos, strlen($key));
								}
								else
								{
									$fld = $key;
									$op = "=";
								}
								if($j > 0)
									$sql.= " ".$fkey." ";
								
								$sql.= $fld." = '".addslashes($val)."'";
								$j++;
							}						
						}
							
					}
					else
						$sql.= "AND ".$fkey." = '".addslashes($fval)."'";
				}
			}
			
			
			if($order_field <> "")
				$sql.= " order by ".$order_field;
			
			if($order <> "")
				$sql.= " ".$order;
			
			if($limit <> "")
				$sql.= " limit 0, ".$limit;
			
			
			
			//echo $sql."<br>";
			
			$res = mysql_query($sql) or mysql_error_show($sql,__FILE__,__LINE__);

			while($row = mysql_fetch_assoc($res))
			{
				$row = array_map('stripslashes', $row); 
				$rows[] = $row;

			}
			//print_r($row);
			return $rows;
		}
	}	

	function get_conditional_records($table, $fields_to_fetch="*", $conditions_string="", $order_field="", $order="", $limit="") 
	{
		$var = 0; $row = NULL; $rows=NULL;
		if($fields_to_fetch <> "")
		{
			$sql = "SELECT " . $fields_to_fetch ." FROM " . get_table_name($table);
			
			$j = 0;
			if($conditions_string <> "")
			{
				$sql.= " where ".$conditions_string;
			}
			
			if($order_field <> "")
				$sql.= " order by ".$order_field;
			
			if($order <> "")
				$sql.= " ".$order;
			
			if($limit <> "")
				$sql.= " limit 0, ".$limit;
			
			//echo $sql."<br>";
			$res = mysql_query($sql) or mysql_error_show($sql,__FILE__,__LINE__);

			while($row = mysql_fetch_assoc($res))
			{
				$row = array_map('stripslashes', $row); 
				$rows[] = $row;

			}
			//print_r($row);
			return $rows;
		}
	}


	
	// Developed by Dibs
	// Date: 09 March, 2012
	// Formulates table joins and returns the resultset
	// Usage:
	// $tables: Table names as array elements array('users', 'consumers')
	function finder_query($tables, $joins=NULL, $conditions=NULL, $fields="*")
	{
		$sql = "SELECT ".$fields." FROM ";
		if(isset($tables) && is_array($tables))
		{
			for($i=0; $i <count($tables); $i++)
			{
				if($i > 0)
					$sql .= ", ";
				$sql .= $tables[$i];
			}
			$j = 0;
			$sql .= " WHERE 1=1 ";
			if(isset($joins) && is_array($joins))
			{
				while(list($jointype, $joincond) = each($joins))
				{
					//if($j > 0)
					if($jointype == "LEFTJOIN")
						$sql .= " LEFT JOIN ";
						
					if(is_array($joincond))
					{
						
						while(list($col1, $col2) = each($joincond))
						{
							$sql .= " ON ".$col1."=".$col2;
						}
					
					}
				}
			}
			$k = 0;
			if(isset($conditions) && is_array($conditions))
			{
				while(list($key, $value) = each($conditions))
				{
					if($j > 0)
						$sql .= " AND ";
					$sql .= $key." = '".$value."'";
					$k++;
				}
			}
		
		}
		
		//echo $sql;
		
		
	}
	
	// Calculate difference between start_date & end_date
	// Start Date: $date1
	// End Date:  $date2
	function datediff2($date1, $date2)
	{
		/*echo $date1."<br>";
		echo $date2."<br>";*/
		
		$diff = strtotime($date2) - strtotime($date1);
		$days = $diff/(60*60*24);
		//echo $days;
		
		return $days;
		
			
	}

	
	function check_duplicate_email($email, $consumer_id, $account_id, $exclude_self=true)
	{
		if($exclude_self == true)
		{
			$sql = sprintf("SELECT id FROM consumers WHERE email = '%s' AND account_id = '%s' AND id != '%s'",		
			mysql_real_escape_string($email),
			mysql_real_escape_string($account_id),
			mysql_real_escape_string($consumer_id));
		}
		else
		{
			$sql = sprintf("SELECT id FROM consumers WHERE email = '%s' AND account_id = '%s' ",		
			mysql_real_escape_string($email),
			mysql_real_escape_string($account_id));
		}

		$res = mysql_query($sql) or mysql_error_show($sql,__FILE__,__LINE__);
		$numrec = mysql_num_rows($res);
		if($numrec >0){
			return $numrec;
		}else{
			return 0;
		}
		
	}

	function get_hash($salt, $pass, $type="")
	{
		if($type == "" || $type == "sha1")
			return sha1($salt.$pass);
		else if($type == "md5")
			return md5($salt.$pass);
		
	}
	
 	function delete_record($table, $conditions_field_values) 
	{
		$var = 0;
		if(isset($conditions_field_values))
		{
			$sql = "DELETE FROM " . get_table_name($table) ;
			$i = 0;
			$j = 0;
			
			if(count($conditions_field_values) > 0)
			{
				$sql.= " WHERE ";
				
				foreach($conditions_field_values as $key=>$val)
				{
					if($j > 0)
						$sql.= " AND ";
					$sql.= $key." = '".addslashes($val)."'";
					$j++;
				}
				
			}
			
			//echo $sql."<br>";
			
			$var = mysql_query($sql) or mysql_error_show($sql,__FILE__,__LINE__);
		}
		return $var;
		
		
	}
	
	function check_latlon($val)
	{
		return preg_match('/^(\\-?\\d+[.\\d]+),?\\s*(\\-?\\d+[.\\d]+)?$/', $val);
	}
	
	
	// Returns x number of matching users as specified in limit variable (default=25) for a radius as specified in rad variable(default=10) in order of distance (nearest to furthest) based on given lat and lon value for a specific country
	function get_nearest_location_distance($lat, $lon, $rad=20, $limit=25)
	{
		$R = 6371;  // earth's radius, km
		
		// first-cut bounding box (in degrees)
		$maxLat = $lat + rad2deg($rad/$R);
		$minLat = $lat - rad2deg($rad/$R);
		// compensate for degrees longitude getting smaller with increasing latitude
		$maxLon = $lon + rad2deg($rad/$R/cos(deg2rad($lat)));
		$minLon = $lon - rad2deg($rad/$R/cos(deg2rad($lat)));
		
		
		
		
		// convert origin of filter circle to radians
		$lat = deg2rad($lat);
		$lon = deg2rad($lon);
		
		//echo $maxLat." ".$minLat."<br>";
		//echo $maxLon." ".$minLon."<br>";
		
		
		$sql = "Select id, first_name, last_name,  city, zip, lat, lon,
		acos(sin($lat)*sin(radians(lat)) + cos($lat)*cos(radians(lat))*cos(radians(lon)-$lon))* $R As D
		From (
		Select id, first_name, last_name,  city, zip, lat, lon
		From users
		Where lat > $minLat And lat < $maxLat
		And lon > $minLon And lon < $maxLon
		AND user_type_id != 5
		) As FirstCut 
		Where 1=1 Order by D limit 0,".$limit;	
		
		/*$sql = "select id, first_name, last_name,  city, zip, lat, lon,
		(acos(sin($lat)*sin(radians(lat)) + cos($lat)*cos(radians(lat))*cos(radians(lon)-$lon))* $R) As D
		From ( 	
		Select id, first_name, last_name,  city, zip, lat, lon
		From users
		Where country = '%s') As FirstCut 
		Where D < $rad Order by D limit 0,".$limit;	*/
		
		
		$query = sprintf($sql,
		mysql_real_escape_string($country));
		
		//echo $query."<br>";
		
		$res = mysql_query($query);
		
		$pret = NULL;
		//$result = mysql_query($query);
		if(isset($res))
		{
		
			$pret = NULL;
			while($row = mysql_fetch_array($res)) 
			{
			//print_r($row);
			$row = array_map('stripslashes', $row);
			//print_r($row)."<br>";
			$pret[] = $row;
			}
			
		}

		return $pret;
	}
	
	
	function get_nearest_issues($lat, $lon, $rad=20, $limit=25)
	{
		$R = 6371;  // earth's radius, km
		
		// first-cut bounding box (in degrees)
		$maxLat = $lat + rad2deg($rad/$R);
		$minLat = $lat - rad2deg($rad/$R);
		// compensate for degrees longitude getting smaller with increasing latitude
		$maxLon = $lon + rad2deg($rad/$R/cos(deg2rad($lat)));
		$minLon = $lon - rad2deg($rad/$R/cos(deg2rad($lat)));
		
		
		
		
		// convert origin of filter circle to radians
		$lat = deg2rad($lat);
		$lon = deg2rad($lon);
		
		//echo $maxLat." ".$minLat."<br>";
		//echo $maxLon." ".$minLon."<br>";
		
		
		$sql = "SELECT FirstCut.id, report_id, issue_type_id, issue_types.name, lat, lon, status, created,
		acos(sin($lat)*sin(radians(lat)) + cos($lat)*cos(radians(lat))*cos(radians(lon)-$lon))* $R As D
		From (
		Select issues.id, report_id, issue_type_id, lat, lon, status, created
		From issues
		Where lat > $minLat And lat < $maxLat
		And lon > $minLon And lon < $maxLon
		) As FirstCut LEFT JOIN issue_types ON FirstCut.issue_type_id = issue_types.id
		Where 1=1 Order by D limit 0,".$limit;	
		
		/*$sql = "select id, first_name, last_name,  city, zip, lat, lon,
		(acos(sin($lat)*sin(radians(lat)) + cos($lat)*cos(radians(lat))*cos(radians(lon)-$lon))* $R) As D
		From ( 	
		Select id, first_name, last_name,  city, zip, lat, lon
		From users
		Where country = '%s') As FirstCut 
		Where D < $rad Order by D limit 0,".$limit;	*/
		
		
		$query = sprintf($sql,
		mysql_real_escape_string($country));
		
		//echo $query."<br>";
		
		$res = mysql_query($query);
		
		$pret = NULL;
		//$result = mysql_query($query);
		if(isset($res))
		{
		
			$pret = NULL;
			while($row = mysql_fetch_array($res)) 
			{
				//print_r($row);
				$row = array_map('stripslashes', $row);
				//print_r($row)."<br>";
				$pret[] = $row;
			}
			
		}

		return $pret;
	}
	
	
	function upload_file($fileObj, $destDir, $max_size=4096000, $rename_image="1")
	{
		//echo $destDir;
		
		if(isset($fileObj['name']) && $fileObj['name'] <> "")
		{
			if($rename_image == 1)
			{
				echo $fileObj['name'];
				
				$arr = explode(".", $fileObj['name']);
				$ext = $arr[count($arr)-1];
				$filename = md5(date("YmdHis"));
				$thumbnm2 = substr($filename, 0, 12).".".$ext;
				//echo $thumbnm2 ;
				
			}
			else
			{
				$thumbnm2 = $fileObj['name'];
				$thumbnm2 = str_replace(array(" "), array("_"), $thumbnm2);
			}
			if(substr($fileObj['type'] , 0, 5) == "image") 
			{
				if($fileObj['size'] <= $max_size)
				{
					$imgsize2 = filesize($fileObj['tmp_name']);
					//print_r($imgsize2);
					//exit;
					
					
						$dir=$destDir."/".$thumbnm2;
						if(copy($fileObj['tmp_name'], $dir))
						{
							$data['status'] = "1";
							$data['msg'] = "File ".$thumbnm2." successfully uploaded to .".$destDir;
							$data['file'] = $thumbnm2;
						}
						else
						{
							$data['status'] = "-4";	// Files not uploaded
							$data['msg'] =  "File ".$thumbnm2." could not be copied.";
							$data['file'] = "";
						}
					
				}
				else	// Size exceeds
				{
					$data['status'] = "-1";
					$data['msg'] = "File ".$thumbnm2." could not be uploaded. File size exceeds the maximum limit.";
					$data['file'] = "";
				}
			}
			else		// Not an image
			{
				$data['status'] = "-2";
				$data['msg'] = "File ".$thumbnm2." could not be uploaded. Not a valid image.";
				$data['file'] = "";
			}
		}
		else		// Not an image
		{
			$data['msg'] = "No file was uploaded.";
			$data['status'] = "-3";
			$data['file'] = "";
		}
		
		return $data;
	}
	
	function get_counter($table, $conditions_field_values, $group) 
	{
		$var = 0; $row = NULL; $rows=NULL;
		//if($conditions <> "")
		{
			$sql = "SELECT COUNT(id) AS counter FROM " . get_table_name($table);;
			
			
			if(count($conditions_field_values) > 0)
			{
				$sql.= " WHERE ";
				
				foreach($conditions_field_values as $key=>$val)
				{
					if($j > 0)
						$sql.= " AND ";
					$sql.= $key." = '".addslashes($val)."'";
					$j++;
				}
				
			}
			
			//echo $sql."<br>";
			$res = mysql_query($sql) or mysql_error_show($sql,__FILE__,__LINE__);

			while($row = mysql_fetch_assoc($res))
			{
				$row = array_map('stripslashes', $row); 
				$rows[] = $row;

			}
			//print_r($row);
			return $rows;
		}
	}
	
	function get_lat_lon_from_addr($address) {
		//$address = '201 S. Division St., Ann Arbor, MI 48104'; // Google HQ
		$latlon = NULL;
		if($address != "")
		{
			$prepAddr = str_replace(' ','+',$address);
			 
			$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
			 
			$output= json_decode($geocode);
			 
			$lat = $output->results[0]->geometry->location->lat;
			$long = $output->results[0]->geometry->location->lng;
			 
			$latlon['lat'] = $lat ;
			$latlon['lon'] = $long ;
			
			//echo $address.'<br>Lat: '.$lat.'<br>Long: '.$long;
		}
		
		return $latlon;
		
	}
		
		
?>