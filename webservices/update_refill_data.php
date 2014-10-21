<?php
#################################################################################
## Developed by Prologic Web Services                                   		##
## http://www.prologicsoft.com                                          		##
#################################################################################

/**
 * @category NyteLyfe Web Application
 * @package nytelyfe
 * @author Dibyendu Mitra Roy <info@prologicsoft.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.prologicsoft.com/
 */

/**
 * Begin Document
 
 * 
*/


require_once("bootstrap.php");
require_once(LIB_DIR . "inc.php");

if($project_vars['msg']['development'] == "sandbox")
	error_reporting(1);
else
	error_reporting(0);


if(isset($_POST)) {
	
	$ret = array();
	
	
	
	$ret["error_code"] = "S41000"; // Initialize
	
	if(!isset($_POST["pump_id"]) || $_POST["pump_id"] == "")
	{
		$ret["error_code"] = "S41001"; // Pump id not found	
	}

	else if(!isset($_POST["filler_id"]) || $_POST["filler_id"] == "")
	{
		$ret["error_code"] = "S41002"; // Filler id not found	
	}

	else if(!isset($_POST["super_unleaded_gal"]) || $_POST["super_unleaded_gal"] == "")
	{
		$ret["error_code"] = "S41003"; // Super Unleaded Gallon not found	
	}

	else if(!isset($_POST["reg_unleaded_gal"]) || $_POST["reg_unleaded_gal"] == "")
	{
		$ret["error_code"] = "S41004"; // Regular Unleaded Gallon not found	
	}
	
	
	// Duplicate username check
	if($ret["error_code"] == "S41000")
	{
		$conditions_field_values = array('pump_id' =>  mysql_real_escape_string($_POST["pump_id"]), 'filler_id' =>  mysql_real_escape_string($_POST["filler_id"]));
		//get_record("fuel_master", $fields_to_fetch="id", $conditions_field_values, $order_field="", $order="", $limit="") 
		$count = get_count_records("fuel_master", "id", "id", $conditions_field_values) ;
		
		if($count > 0)
			$ret["error_code"] = "S41205"; 		// Duplicate record found.
		else
		{
			$insert_field_values = array(
			'pump_id'					=> mysql_real_escape_string($_POST["pump_id"]),
			'filler_id' 				=> mysql_real_escape_string($_POST["filler_id"]),
			'super_unleaded_gal' 		=> mysql_real_escape_string($_POST["super_unleaded_gal"]),
			'reg_unleaded_gal' 			=> mysql_real_escape_string($_POST["reg_unleaded_gal"]));
			
			$v = insert("fuel_master", $insert_field_values, false, false);
			$recid = mysql_insert_id();
			if($v == 1)
			{
				$ret["alert_id"] = $recid;
				$ret["error_code"] = "S41000"; 		// Fuel data successfully added.
			}
			else		
				$ret["error_code"] = "S41206"; 		// Fuel data not added.
			
		}
	}
	
} 
else 
{
	$ret["error_code"] = "S40002"; // Invalid request parameter string.
}

echo $ret["error_code"];

include_once("logging.php");

include_once(LIB_DIR . "close.php");
?>