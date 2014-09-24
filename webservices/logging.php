<?php
// Write to log database
$url = $_SERVER['PHP_SELF'];
$file = substr($url, strrpos($url, '/'));

foreach($_POST as $key => $element) {
	$data[$key] = $element;
	$raw_request .= $key."=".$element."<br>";
}



$fields_values = array('service_name' => $file, 'error_code' => $ret["error_code"], 'raw_request' => $raw_request, 'created' => date("Y-m-d H:i:s"));
$res = insert('webservice_logs', $fields_values, false, false);

?>