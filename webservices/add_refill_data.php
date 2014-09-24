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
	
	
	
	$ret["error_code"] = "S4100"; // Initialize
	
	if(!isset($_POST["pump_id"]) || $_POST["pump_id"] == "")
	{
		$ret["error_code"] = "S4101"; // Pump id not found	
	}

	else if(!isset($_POST["filler_id"]) || $_POST["filler_id"] == "")
	{
		$ret["error_code"] = "S4102"; // Filler id not found	
	}

	else if(!isset($_POST["car_id"]) || $_POST["car_id"] == "")
	{
		$ret["error_code"] = "S4103"; // Car Id not found	
	}

	else if(!isset($_POST["car_type_id"]) || $_POST["car_type_id"] == "")
	{
		$ret["error_code"] = "S4104"; // Car Type Id not found	
	}
	

	else if(!isset($_POST["car_owner_id"]) || $_POST["car_owner_id"] == "")
	{
		$ret["error_code"] = "S4105"; // Car Owner Id not found	
	}
	
	else if(!isset($_POST["mileage"]) || $_POST["mileage"] == "")
	{
		$ret["error_code"] = "S4106"; // Mileage not found	
	}
	
	else if(!isset($_POST["additive"]) || $_POST["additive"] == "")
	{
		$ret["error_code"] = "S4107"; // Additive not found	
	}
	
	else if(!isset($_POST["start_1"]) || $_POST["start_1"] == "")
	{
		$ret["error_code"] = "S4108"; // Start Meter Reading 1 not found	
	}
	
	else if(!isset($_POST["start_2"]) || $_POST["start_2"] == "")
	{
		$ret["error_code"] = "S4109"; // Start Meter Reading 2 not found	
	}
	
	else if(!isset($_POST["end_1"]) || $_POST["end_1"] == "")
	{
		$ret["error_code"] = "S4110"; // End Meter Reading 1 not found	
	}
	
	else if(!isset($_POST["end_2"]) || $_POST["end_2"] == "")
	{
		$ret["error_code"] = "S4111"; // Start Meter Reading 2 not found	
	}
	
	else if(!isset($_POST["total_gallons"]) || $_POST["total_gallons"] == "")
	{
		$ret["error_code"] = "S4112"; // Total Gallon not found	
	}		
	// Duplicate username check
	if($ret["error_code"] == "S4100")
	{
	
		$insert_field_values = array(
		'pump_id'					=> mysql_real_escape_string($_POST["pump_id"]),
		'filler_id' 				=> mysql_real_escape_string($_POST["filler_id"]),
		'car_id' 					=> mysql_real_escape_string($_POST["car_id"]),
		'car_type_id' 				=> mysql_real_escape_string($_POST["car_type_id"]),
		'car_owner_id' 				=> mysql_real_escape_string($_POST["car_owner_id"]),
		'mileage' 					=> mysql_real_escape_string($_POST["mileage"]),
		'additive' 					=> mysql_real_escape_string($_POST["additive"]),
		'start_meter_1_reading' 	=> mysql_real_escape_string($_POST["start_1"]),
		'start_meter_2_reading' 	=> mysql_real_escape_string($_POST["start_2"]),
		'end_meter_1_reading' 		=> mysql_real_escape_string($_POST["end_1"]),
		'end_meter_2_reading' 		=> mysql_real_escape_string($_POST["end_2"]),
		'total_gallons' 			=> mysql_real_escape_string($_POST["total_gallons"]),
		'notes' 					=> mysql_real_escape_string($_POST["notes"])
		);
		
		$v = insert("refills", $insert_field_values, false, true);
		$recid = mysql_insert_id();
		if($v == 1)
		{
			$conditions_field_values = array('pump_id' =>  mysql_real_escape_string($_REQUEST["pump_id"]));
			$fuel = get_record("fuel_master", "*", $conditions_field_values) ;
			
			if(!isset($fuel['id']))
			{
				$insert_field_values = array(
				'pump_id'					=> mysql_real_escape_string($_POST["pump_id"]),
				'filler_id' 				=> mysql_real_escape_string($_POST["filler_id"]),
				'super_unleaded_gal' 		=> mysql_real_escape_string($_POST["end_1"]),
				'reg_unleaded_gal' 			=> mysql_real_escape_string($_POST["end_2"]));
				
				$v = insert("fuel_master", $insert_field_values, false, false);
			}
			else
			{
				$update_field_values = array('super_unleaded_gal' => mysql_real_escape_string($_POST["end_1"]), 'reg_unleaded_gal' => mysql_real_escape_string($_POST["end_2"]));
				update_record('fuel_master', $update_field_values, $conditions_field_values) ;
				
				
			}
			
			$ret["alert_id"] = $recid;
			$ret["error_code"] = "S4100"; 		// Fuel data successfully added.
		}
		else		
			$ret["error_code"] = "S4113"; 		// Refill data not added.
	
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