<?php
# error_hash to hold error numbers and messages
# must be kept in the config file 
$error_hash = array(
	1000 => 'Currency type not recognized',
	1100 => 'Required parameter is missing',
	1200 => 'Parameter not recognized',
	1300 => 'Currency amount must be a decimal number',
	1400 => 'Error in service',
	2000 => 'Method not recognized or is missing',
	2100 => 'Rate in wrong format or is missing',
	2200 => 'Currency code in wrong format or is missing',
	2300 => 'Country name in wrong format or is missing',
	2400 => 'Currency code not found for update',
	2500 => 'Error in service'
);
# function to return formatted json or xml error msgs
# expects three params - error_number, error_hash & format
# if format missing, default to xml
function generate_error($eno, $error_hash, $format='xml') {
	$msg = $error_hash[$eno];
	
	if ($format=='json') {
		$json = array('conv' => array("code" => "$eno", "msg" => "$msg"));
		header('Content-Type: application/json');
		return json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
	}
	else {
		$xml =  '<?xml version="1.0" encoding="UTF-8"?>';
		$xml .= '<conv><error>';
		$xml .= '<code>' . $eno . '</code>';
		$xml .= '<msg>' . $msg . '</msg>';
		$xml .= '</error></conv>';
	
		header('Content-type: text/xml');
		return $xml;
	}
}
# TESTS ##########
# uncomment following lines (one at a time) then run to test
// echo generate_error(1200, $error_hash);
// echo generate_error(1300, $error_hash, 'json');
?>

