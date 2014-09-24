<?php
/*----------site general info - start -------------*/
/*$project_vars['mysql_db_name'] = "gcrm";
$project_vars['mysql_db_user'] = "root";
$project_vars['mysql_db_pass'] = "OWt_AtOz$?5a";
$project_vars['mysql_db_host'] = "localhost";
$project_vars['mysql_table_prefix'] = "";*/

if($_SERVER['HTTP_HOST'] == "localhost")
{
	$project_vars['mysql_db_name'] = "cibs";
	$project_vars['mysql_db_user'] = "root";
	$project_vars['mysql_db_pass'] = "system";
	$project_vars['mysql_db_host'] = "localhost";
}
else
{
	$project_vars['mysql_db_name'] = "prologic_fuelpumps";
	$project_vars['mysql_db_user'] = "prologic_fuelpu";
	$project_vars['mysql_db_pass'] = "K66qGiU*UHPH";
	$project_vars['mysql_db_host'] = "localhost";

}
$project_vars['mysql_table_prefix'] = "";


// This must match with CakePHP App's Security Salt
$project_vars['security_salt'] = "f12ca59d2f326f07a2c6e891b79e69d5ae25e0d5";

$project_vars['appname'] = "cibsin";
$project_vars['apptitle'] = "FuelPumps";
/*----------site general info - end -------------*/


// session name
$project_vars['admin_session_name'] = "fuelpumps_admin";
$project_vars['user_session_name'] = "fuelpumps_user";


/*----------mysql debug status - start-------------*/
$project_vars['show_mysql_error_file_line'] = TRUE;
$project_vars['show_mysql_error_string'] = TRUE;
$project_vars['show_mysql_error_sql'] = TRUE;
/*----------mysql debug status - end-------------*/



?>