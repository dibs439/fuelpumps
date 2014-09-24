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


if(isset($_REQUEST)) {
	
	$ret = array();
	
	
	
	$ret["error_code"] = "S4200"; // Initialize
	
	if(!isset($_REQUEST["pump_id"]) || $_REQUEST["pump_id"] == "")
	{
		$ret["error_code"] = "S4201"; // Pump id not found	
	}

	
	
	
	// Duplicate username check
	if($ret["error_code"] == "S4200")
	{
		$conditions_field_values = array('pump_id' =>  mysql_real_escape_string($_REQUEST["pump_id"]));
		$fuel = get_record("fuel_master", "*", $conditions_field_values) ;
		
		if(!isset($fuel['id']))
		{
			$ret["error_code"] = "S4202"; 		// No record found.
		}
		else
		{
			$ret['super_unleaded_gal'] = $fuel["super_unleaded_gal"];
			$ret['reg_unleaded_gal'] = $fuel["reg_unleaded_gal"];
			
			
		}
	}
	
} 
else 
{
	$ret["error_code"] = "S4002"; // Invalid request parameter string.
}

echo json_encode($ret);

include_once("logging.php");

include_once(LIB_DIR . "close.php");
?>