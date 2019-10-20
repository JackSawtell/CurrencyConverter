<?php
# always include this line (in config file in final version)
@date_default_timezone_set("GMT"); 
# the function to generate errors (in functions file in final version)
require_once('generate_error.php');
# exit if core data files are missing
if (!file_exists('rates.xml') || !file_exists('currencies.xml')) {
	echo generate_error(1400, $error_hash, 'xml');
	exit;
}
# make the currency array (again in final config file)
$xml=simplexml_load_file('rates.xml');
$rates = $xml->xpath("//code");
foreach ($rates as $key=>$val) {$codes[] =(string) $val;}
# parmeters in URL and format values expected
# kept in the config file
$params = array('from', 'to', 'amnt', 'format');
$frmts = array('xml', 'json');
############################################################################
# turn $_GET params into PHP variables
extract($_GET);
# set format to default to XML
if (!isset($format) || empty($format)) {
	$format = 'xml';
}
$get = array_intersect($params, array_keys($_GET));
if (count($get) < 4) {
	echo generate_error(1100, $error_hash, $format);
	exit;
}
if (count($_GET) > 4) {
	echo generate_error(1200, $error_hash, $format);
	exit;
}
# $to and $from are not recognized currencies
if (!in_array($to, $codes) || !in_array($from, $codes)) {
	echo generate_error(1000, $error_hash, $format);
	exit;
}
# check for allowed format values
if (!in_array($format, $frmts)) {
	echo generate_error(1200, $error_hash, $format);
	exit;
}
# $amnt is not a decimal value
if (!preg_match('/^[+-]?(\d*\.\d+([eE]?[+-]?\d+)?|\d+[eE][+-]?\d+)$/', $amnt)) {
	echo generate_error(1300,  $error_hash, $format);
	exit;
}
echo "OK ... all validation passed.";
# now read in currencies data file 
# update rate if more than 12 hours old (use rates file timestamp)
# do conversion
# echo result as XML or JSON depending on format param or xml if format unspecified.
