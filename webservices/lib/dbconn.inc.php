<?php
function mysql_error_show($sql="",$file=__FILE__,$line=__LINE__)
{
	global $project_vars;

	echo "There is a mysql error ... system exiting, contact system admin <a href=\"mailto:" . $project_vars['system_admin_email'] . "\">".$project_vars['system_admin_name']."</a> for additional info.";
	if($project_vars['show_mysql_error_file_line'])
		echo "<br><br>Error is at FILE: " . $file . " at LINE: " . $line;
	if($project_vars['show_mysql_error_string'])
		echo "<br><br>Mysql said: " . mysql_error();
	if($project_vars['show_mysql_error_sql'])
		echo "<br><br>The sql is: " . $sql;
	exit;
}

// function to return the table name with proper prefix
function get_table_name($table_name)
{
	global $project_vars;
	return $project_vars['mysql_table_prefix'] . $table_name;
}

//echo $project_vars['mysql_db_host'].", ".$project_vars['mysql_db_user']." ,".$project_vars['mysql_db_pass']."<br>";
if($myDB = @mysql_connect($project_vars['mysql_db_host'],$project_vars['mysql_db_user'],$project_vars['mysql_db_pass']))
	mysql_select_db($project_vars['mysql_db_name'],$myDB) or mysql_error_show('',__FILE__,__LINE__);
else
	mysql_error_show(mysql_error(),__FILE__,__LINE__);

//mysql_query("SET NAMES utf8");
?>