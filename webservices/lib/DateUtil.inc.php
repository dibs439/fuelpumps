<?php

#################################################################################
## Developed by 360m                                   							##
## http://www.360m.com                                          				##
## ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ 	##
##                                                                             	##
## Author of file: Dibyendu Mitra Roy                                  			##
#################################################################################

/**
 * @category mnGage Web Application
 * @package gcrm
 * @subpackage gcrm/site/controllers/utils
 * @author Dibyendu Mitra Roy <dibyendu@360m.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link http://mngage.360m.com/
 */

/**
 * Begin Document
 */
 
function unixTm($strDT)
{ 
	$arrDT = explode(" ", $strDT); 
	$arrD = explode("-", $arrDT[0]); 
	$arrT = explode(":", $arrDT[1]);
	
	/*print_r($arrDT);
	echo "<br>";
	print_r($arrD);
	echo "<br>";	
	print_r($arrT);
	echo "<br>";*/
	
	return mktime($arrT[0], $arrT[1], $arrT[2], $arrD[1], $arrD[2], $arrD[0]); 
} 

function dateDiff($date1,$date2, $opt=1) 
{
	// This function returns difference between 2 dates
	// it accepts 3 arguments viz., End date, Start Date & Format Option in which it will print
	// the result

	//echo "<BR>";
	/*echo "Date2: ".$date2."<BR>";
	echo "Date1: ".$date1."<BR>";*/
	
	$dt2=unixTm($date2); 
	$dt1=unixTm($date1); 
	$r =  $dt1 - $dt2; 
	$dd=floor($r / 86400); 
	//if ($dd<=9) $dd="0".$dd; 
	$r=$r % 86400; 
	$hh=floor($r/3600); 
	//if ($hh<=9) $hh="0".$hh; 
	$r=$r % 3600; 
	$mm=floor($r/60); 
	if ($mm<=9) $mm="0".$mm; 
	$r=$r % 60; 
	$ss=$r; 
	if ($ss<=9) $ss="0".$ss;
	
	//if only no. of days
	if($opt==1)
		$resd="$dd" ;
	
	//if only day + hours
	elseif($opt==2)
		$resd="$dd day, $hh hour+" ;			

	//if only day + hours + min
	elseif($opt==3)
		$resd="$dd day, $hh hour, $mm min+";
	
	elseif($opt==4)
		$resd=$ss;
	
	elseif($opt==5)
		$resd=$hh;
	
	return $resd;
	

	/*if($r > 0)
	{
		return $resd; 
	}
	else
		return -1;*/
} 


function hourDifference($date1, $date2) 
{
	// This function returns difference between 2 dates
	// it accepts 3 arguments viz., End date, Start Date & Format Option in which it will print
	// the result

	//echo "<BR>";
	//echo "Date2: ".$date2."<BR>";
	//echo "Date1: ".$date1."<BR>";
	$dt2=unixTm($date2); 
	$dt1=unixTm($date1); 
	$r =  $dt1 - $dt2; 
	$hh=floor($r / 3600); 
	

	//echo $hh."<BR>";

	return $hh;
	

} 



function minutesDifference($date1, $date2) 
{
	$hr = hourDifference($date1, $date2);
	$min = $hr * 60;
	return $min;
} 

function secondsDifference($date1, $date2) 
{
	$min = minutesDifference($date1, $date2);
	$sec = $min * 60;
	return $sec;
} 

/*
function dateadd($date1, $val)
{
	$timestamp = @strtotime($date1);
	$day = @date("d", $timestamp); 
	$month = @date("m", $timestamp);
	$year = @date("Y", $timestamp);
	$hour = @date("H", $timestamp);
	$minute = @date("i", $timestamp);
	$second = @date("s", $timestamp);


	$date1 = @date("Y-m-d H:i:s", mktime ($hour,$minute,$second,$month+$mon,$day,$year));


}*/

function dayadd($date1, $val)
{
$timestamp = @strtotime($date1);
$day = @date("d", $timestamp); 
$month = @date("m", $timestamp);
$year = @date("Y", $timestamp);
$hour = @date("H", $timestamp);
$minute = @date("i", $timestamp);
$second = @date("s", $timestamp);

$date1 = @date("Y-m-d H:i:s", mktime ($hour,$minute,$second,$month,$day+$val,$year));

return $date1; 
}
function monthadd($date1, $val)
{
$timestamp = @strtotime($date1);
$day = @date("d", $timestamp); 
$month = @date("m", $timestamp);
$year = @date("Y", $timestamp);
$hour = @date("H", $timestamp);
$minute = @date("i", $timestamp);
$second = @date("s", $timestamp);

$date1 = @date("Y-m-d H:i:s", mktime ($hour,$minute,$second,$month+$val,$day,$year));

return $date1; 
}
function yearadd($date1, $val)
{
$timestamp = @strtotime($date1);
$day = @date("d", $timestamp); 
$month = @date("m", $timestamp);
$year = @date("Y", $timestamp);
$hour = @date("H", $timestamp);
$minute = @date("i", $timestamp);
$second = @date("s", $timestamp);

$date1 = @date("Y-m-d H:i:s", mktime ($hour,$minute,$second,$month,$day,$year+$val));

return $date1; 
}

function houradd($date1, $val)
{
$timestamp = @strtotime($date1);
$day = @date("d", $timestamp); 
$month = @date("m", $timestamp);
$year = @date("Y", $timestamp);
$hour = @date("H", $timestamp);
$minute = @date("i", $timestamp);
$second = @date("s", $timestamp);

$date1 = @date("Y-m-d H:i:s", mktime ($hour+$val,$minute,$second,$month,$day,$year));

return $date1; 
}

function minadd($date1, $val)
{
$timestamp = @strtotime($date1);
$day = @date("d", $timestamp); 
$month = @date("m", $timestamp);
$year = @date("Y", $timestamp);
$hour = @date("H", $timestamp);
$minute = @date("i", $timestamp);
$second = @date("s", $timestamp);

$date1 = @date("Y-m-d H:i:s", mktime ($hour,$minute+$val,$second,$month,$day,$year));

return $date1; 
}
function daydiff($date1, $val)
{
$timestamp = @strtotime($date1);
$day = @date("d", $timestamp); 
$month = @date("m", $timestamp);
$year = @date("Y", $timestamp);
$hour = @date("H", $timestamp);
$minute = @date("i", $timestamp);
$second = @date("s", $timestamp);
$date1 = @date("Y-m-d H:i:s", mktime($hour,$minute,$second,$month,$day-$val,$year));
return $date1;
}
function firstdayofmonth($date1)
{
$timestamp = @strtotime($date1);
$day = @date("d", $timestamp); 
$month = @date("m", $timestamp);
$year = @date("Y", $timestamp);
$hour = @date("H", $timestamp);
$minute = @date("i", $timestamp);
$second = @date("s", $timestamp);

//first day of the month is where $month=1;
$day=1;
$date1 = @date("Y-m-d H:i:s", mktime ($hour,$minute,$second,$month,$day,$year));
return $date1; 
}
function dateonly($date1)
{
$timestamp = @strtotime($date1);
$hour = @date("H", $timestamp);
$minute = @date("i", $timestamp);
$second = @date("s", $timestamp);

$day = @date("d", $timestamp); 
$month = @date("m", $timestamp);
$year = @date("Y", $timestamp);

$date1 = @date("Y-m-d H:i:s", mktime ($hour,$minute,$second,$month,$day,$year));
return $date1; 
}

function houronly($date1)
{
$timestamp = @strtotime($date1);
$hour = @date("H", $timestamp);
return $hour; 
}

function minonly($date1)
{
$timestamp = @strtotime($date1);
$hour = @date("i", $timestamp);
return $hour; 
}

function dayonly($date1)
{
// Coverts a date into "Mon Sep 13 06:44:47 2004" format
$timestamp = @strtotime($date1);
$hour = @date("H", $timestamp);
$minute = @date("i", $timestamp);
$second = @date("s", $timestamp);

$day = @date("d", $timestamp); 
$month = @date("m", $timestamp);
$year = @date("Y", $timestamp);

$date1 = @date("D M j G:i:s Y", mktime ($hour,$minute,$second,$month,$day,$year));

$dayname = @date("D", $timestamp);

return $dayname; 
}		


function dateonly2($date1)
{
	$timestamp = @strtotime($date1);

	/*$hour = @date("H", $timestamp);
	$minute = @date("i", $timestamp);
	$second = @date("s", $timestamp);*/

	$day = @date("d", $timestamp); 
	$month = @date("m", $timestamp);
	$year = @date("Y", $timestamp);

	$date1 = @date("Y-m-d", mktime($hour,$minute,$second,$month,$day,$year));
	return $date1; 
}


function convertType1($date1)
{
	// Coverts a date into "Mon Sep 13 06:44:47 2004" format
	$timestamp = @strtotime($date1);
	$hour = @date("H", $timestamp);
	$minute = @date("i", $timestamp);
	$second = @date("s", $timestamp);

	$day = @date("d", $timestamp); 
	$month = @date("m", $timestamp);
	$year = @date("Y", $timestamp);

	$date1 = @date("D M j G:i:s Y", mktime ($hour,$minute,$second,$month,$day,$year));
	return $date1; 
}		
function convertType2($date1)
{
	// Coverts a date into "Sep 13 2004" format
	$timestamp = @strtotime($date1);
	$hour = @date("H", $timestamp);
	$minute = @date("i", $timestamp);
	$second = @date("s", $timestamp);

	$day = @date("d", $timestamp); 
	$month = @date("m", $timestamp);
	$year = @date("Y", $timestamp);

	$date1 = @date("M j Y", mktime ($hour,$minute,$second,$month,$day,$year));
	return $date1; 
}		
function convertType3($date1)
{
// Coverts a date into "Sep 13 2004" format
$timestamp = @strtotime($date1);
$hour = @date("H", $timestamp);
$minute = @date("i", $timestamp);
$second = @date("s", $timestamp);

$day = @date("d", $timestamp); 
$month = @date("m", $timestamp);
$year = @date("Y", $timestamp);

$date1 = @date("Y-m-d", mktime ($hour,$minute,$second,$month,$day,$year));
return $date1; 
}		
function convertType4($date1)
{
// Coverts a date into "Sep 13 2004" format
$timestamp = @strtotime($date1);
$hour = @date("H", $timestamp);
$minute = @date("i", $timestamp);
$second = @date("s", $timestamp);

$day = @date("d", $timestamp); 
$month = @date("m", $timestamp);
$year = @date("Y", $timestamp);

$date1 = @date("d-m-Y", mktime ($hour,$minute,$second,$month,$day,$year));
return $date1; 
}

function convertType5($date1)
{
	// Coverts a date into "Mon Sep 13 06:44:47 2004" format
	$timestamp = @strtotime($date1);
	$hour = @date("H", $timestamp);
	$minute = @date("i", $timestamp);
	$second = @date("s", $timestamp);

	$day = @date("d", $timestamp); 
	$month = @date("m", $timestamp);
	$year = @date("Y", $timestamp);

	$date1 = @date("d/m/Y H:i", mktime ($hour,$minute,$second,$month,$day,$year));
	return $date1; 
}		


function convertType6($date1)
{
// Coverts a date into "Sep 13 2004" format
$timestamp = @strtotime($date1);
$hour = @date("H", $timestamp);
$minute = @date("i", $timestamp);
$second = @date("s", $timestamp);

$day = @date("d", $timestamp); 
$month = @date("m", $timestamp);
$year = @date("Y", $timestamp);

$date1 = @date("m/d/Y", mktime ($hour,$minute,$second,$month,$day,$year));
return $date1; 
}

function convertType7($date1)
{
// Coverts a date into "Sep 13 2004" format
$timestamp = @strtotime($date1);
$hour = @date("H", $timestamp);
$minute = @date("i", $timestamp);
$second = @date("s", $timestamp);

$day = @date("d", $timestamp); 
$month = @date("m", $timestamp);
$year = @date("Y", $timestamp);

$date1 = @date("d/m/Y", mktime ($hour,$minute,$second,$month,$day,$year));
return $date1; 
}

function convertType8($date1)
{
	// Coverts a date into "Mon Sep 13 06:44:47 2004" format
	$timestamp = @strtotime($date1);
	$hour = @date("H", $timestamp);
	$minute = @date("i", $timestamp);
	$second = @date("s", $timestamp);

	$day = @date("d", $timestamp); 
	$month = @date("m", $timestamp);
	$year = @date("Y", $timestamp);

	$date1 = @date("D, M j G:i", mktime ($hour,$minute,$second,$month,$day,$year));
	return $date1; 
}		

function convertType9($date1)
{
	// Coverts a date into "Mon Sep 13 06:44:47 2004" format
	$timestamp = @strtotime($date1);
	$hour = @date("H", $timestamp);
	$minute = @date("i", $timestamp);
	$second = @date("s", $timestamp);

	$day = @date("d", $timestamp); 
	$month = @date("m", $timestamp);
	$year = @date("Y", $timestamp);

	$date1 = @date("F d, Y", mktime ($hour,$minute,$second,$month,$day,$year));
	return $date1; 
}		
function convertType10($date1)
{
	// Coverts a date into "Sep 13 2004" format
	$timestamp = @strtotime($date1);
	$hour = @date("H", $timestamp);
	$minute = @date("i", $timestamp);
	$second = @date("s", $timestamp);

	$day = @date("d", $timestamp); 
	$month = @date("m", $timestamp);
	$year = @date("Y", $timestamp);

	$date1 = @date("j M, Y", mktime ($hour,$minute,$second,$month,$day,$year));
	return $date1; 
}		

function daynumberonly($date1)
{
$timestamp = @strtotime($date1);
$day = @date("d", $timestamp); 
return $day;

}
function monthonly($date1)
{
$timestamp = @strtotime($date1);
$mon = @date("m", $timestamp); 
return $mon;
}
function yearonly($date1)
{
$timestamp = @strtotime($date1);
$year = @date("Y", $timestamp); 
return $year;
}
function getTime($date1)
{
$timestamp = @strtotime($date1);
$time = @date("H:i", $timestamp); 
return $time;

}

function timestampToDate($timestamp)
{
$year = substr($timestamp, 0, 4);
$mon = substr($timestamp, 4, 2);
$day = substr($timestamp, 6, 2);
$hr = substr($timestamp, 8, 2);
$min = substr($timestamp, 10, 2);
$sec = substr($timestamp, 12, 2);

return $day."/".$mon."/".$year." ".$hr.":".$min.":".$sec;
}

function timestampToDate1($timestamp)
{
	$year = substr($timestamp, 0, 4);
	$mon = substr($timestamp, 5, 2);
	$day = substr($timestamp, 8, 2);
	$hr = substr($timestamp, 11, 2);
	$min = substr($timestamp, 14, 2);
	$sec = substr($timestamp, 17, 2);

	return $day."/".$mon."/".$year;
}

function timestampToDate2($timestamp)
{
	$hour = @date("H", $timestamp);
	$minute = @date("i", $timestamp);
	$second = @date("s", $timestamp);

	$day = @date("d", $timestamp); 
	$month = @date("m", $timestamp);
	$year = @date("Y", $timestamp);
	
	//echo $hour;

	$date1 = @date("D M j G:i:s Y", mktime ($hour,$minute,$second,$month,$day,$year));

	//echo $date1;
	return $date1; 
}

// this function converts a 10-digit date string like 25-10-2005
// to a database compatible date string
function strToDate($dateste, $src_sep="/", $des_sep="/")
{

	$dt_array = array();
	$dt_array = explode($src_sep, $dateste);
	$dd = $dt_array[0];
	$mm = $dt_array[1];
	$yy = $dt_array[2];
	

	$dt = $yy . $des_sep .$mm . $des_sep .$dd;

	return $dt;
}

// this function converts a 10-digit date string like 2005-10-25 (yyyy-mm-dd)
// into dd/mm/yyyy format
function yyyy_mm_dd2dd_mm_yyyy($dateste, $src_sep="-", $des_sep="-")
{
	$dt_array = array();
	$dt_array = explode($src_sep, $dateste);
	//print_r($dt_array);
	//exit;
	$dd = $dt_array[2];
	$mm = $dt_array[1];
	$yy = $dt_array[0];
	
	$dt = $dd. $des_sep .$mm.$des_sep .$yy;

	return $dt;
}

// this function converts a 10-digit date string like 2005=10-25 (yyyy-mm-dd)
// into dd/mm/yyyy format
function yyyy_mm_dd2mm_dd_yyyy($dateste, $src_sep="-", $des_sep="/")
{
	$dt_array = array();
	$dt_array = explode($src_sep, $dateste);
	//print_r($dt_array);
	//exit;
	$dd = $dt_array[2];
	$mm = $dt_array[1];
	$yy = $dt_array[0];

	$dt = $mm. $des_sep .$dd. $des_sep .$yy;

	return $dt;
}


//To get a month name (e.g. February) from the month number:
//$month = 2;
// $monthName will be the string "February"
function yyyy_mm_dd2month_dd_yyyy($dateste, $src_sep="-", $des_sep="  ")
{
	$dt_array = array();
	$dt_array = explode($src_sep, $dateste);
	//print_r($dt_array);
	//exit;
	$dd = $dt_array[2];
	$mm = $dt_array[1];
	$yy = $dt_array[0];
	$monthName = jdmonthname ( juliantojd( $mm, $dd, $yy ), 2 );

	$dt = $monthName. $des_sep. $dd. ", "  .$yy;

	return $dt;
	
	//To get a month name (e.g. February) from the month number:
	//$month = 2;
	// $monthName will be the string "February"

}


// this function converts a 10-digit date string like 2005=10-25 (yyyy-mm-dd)
// into dd/mm/yyyy format
function mm_dd_yyyy2yyyy_mm_dd($dateste, $src_sep="/", $des_sep="-")
{
	$dt_array = array();
	$dt_array = explode($src_sep, $dateste);
	//print_r($dt_array);
	//exit;
	$dd = $dt_array[1];
	$mm = $dt_array[0];
	$yy = $dt_array[2];

	$dt = $yy.$des_sep.$mm.$des_sep.$dd;

	return $dt;
}

function dd_mm_yyyy2yyyy_mm_dd($dateste, $src_sep="/", $des_sep="-")
{
	$dt_array = array();
	$dt_array = explode($src_sep, $dateste);
	//print_r($dt_array);
	//exit;
	$dd = $dt_array[0];
	$mm = $dt_array[1];
	$yy = $dt_array[2];

	$dt = $yy.$des_sep.$mm.$des_sep.$dd;

	return $dt;
}


function dd_mm_yyyy2yyyy_mm_dd2($dateste, $src_sep="/", $des_sep="-")
{
	$dt_array = array();
	$dt_array = explode($src_sep, $dateste);
	//print_r($dt_array);
	
	//echo "<br>"."<br>";
	//exit;
	
	$mm = $dt_array[0];
	$dd = $dt_array[1];
	$yy = $dt_array[2];

	$dt = $yy.$des_sep.$mm.$des_sep.$dd;

	return $dt;
}


?>