<?php
include_once "bootstrap.php";
include_once(LIB_DIR . "inc.php");

$results = get_matching_records('webservice_logs', $fields_to_fetch="*", $conditions_field_values, $order_field="created", $order="DESC", $limit="");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Redemption Log</title>

<style>
body {
	font-size:12px;
}
</style>
</head>

<body>
<h2>Web Services Log</h2>

<table width="100%" border="1">
<tr style="font-weight:bold">
	<td>Sl. No.</td>
	<td>Service Name</td>
	<td>Error Code</td>
	<td>Timestamp</td>
	<td>Raw Request String</td>
</tr>
<?php
if(isset($results))
{
	foreach($results as $result)
	{
		echo "<tr>";
		echo "<td>".$result['id']."</td>";
		echo "<td>".strtoupper(substr($result['service_name'], 1))."</td>";
		echo "<td>".$result['error_code']."</td>";
		echo "<td>".$result['created']."</td>";
		echo "<td>&nbsp;".$result['raw_request']."</td>";
		echo "</tr>";
		
	}
}
?>
</table>


</body>
</html>
