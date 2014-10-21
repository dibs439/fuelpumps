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
	
	/// truck=Truck 3&employee_no=000128&tail_id=PWD-779-909&ac_type=Chevy&customer_name=Billy Gram&mileage=17&additive=Ethanol&start_1=112&start_2=89&end_1=142&end_2=110&total_gallons=51&notes=Check testing
	
	$ret["error_code"] = "S4100"; // Initialize
	
	//echo $ret["error_code"];
	
	if(!isset($_POST["truck"]) || $_POST["truck"] == "")
	{
		$ret["error_code"] = "S4101"; // Truck not found	
	}

	else if(!isset($_POST["employee_no"]) || $_POST["employee_no"] == "")
	{
		$ret["error_code"] = "S4102"; // Employee no not found	
	}

	else if(!isset($_POST["tail_id"]) || $_POST["tail_id"] == "")
	{
		$ret["error_code"] = "S4103"; // Tail Id not found	
	}

	else if(!isset($_POST["ac_type"]) || $_POST["ac_type"] == "")
	{
		$ret["error_code"] = "S4104"; // AC Type not found	
	}	

	else if(!isset($_POST["customer_name"]) || $_POST["customer_name"] == "")
	{
		$ret["error_code"] = "S4105"; // Customer Name not found	
	}
	
	else if(!isset($_POST["ac_hours"]) || $_POST["ac_hours"] == "")
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
		'truck'					=> mysql_real_escape_string($_POST["truck"]),
		'employee_no' 				=> mysql_real_escape_string($_POST["employee_no"]),
		'car_id' 					=> mysql_real_escape_string($_POST["tail_id"]),
		'car_type_id' 				=> mysql_real_escape_string($_POST["ac_type"]),
		'car_owner_id' 				=> mysql_real_escape_string($_POST["customer_name"]),
		'ac_hours' 					=> mysql_real_escape_string($_POST["ac_hours"]),
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
			$conditions_field_values = array('truck' =>  mysql_real_escape_string($_REQUEST["truck"]));
			$fuel = get_record("fuel_master", "*", $conditions_field_values) ;
			
			if(!isset($fuel['id']))
			{
				$insert_field_values = array(
				'truck'						=> mysql_real_escape_string($_POST["truck"]),
				'employee_no' 				=> mysql_real_escape_string($_POST["employee_no"]),
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