<?php
# always include this line
@date_default_timezone_set("GMT"); 
# pull the ISO currencies file into a simplexml object
$xml=simplexml_load_file('http://www.currency-iso.org/dam/downloads/lists/list_one.xml') or die("Error: Cannot create object");
$writer = new XMLWriter();
$writer->openURI('currencies.xml');
$writer->startDocument("1.0");
$writer->startElement("currencies");
# get all the currency codes
$codes = $xml->xpath("//CcyNtry/Ccy");
$ccodes = [];
# make array with unique currency codes
foreach ($codes as $code) {
	if (!in_array($code, $ccodes)) {
		$ccodes[] = (string) $code;
	}
}
foreach ($ccodes as $ccode) { 
	$nodes = $xml->xpath("//Ccy[.='$ccode']/parent::*");
	
	$cname =  $nodes[0]->CcyNm;
	
	# begin writing out the nodes & values
	$writer->startElement("currency");
		$writer->startElement("ccode");
		$writer->text($ccode);
		$writer->endElement();
		$writer->startElement("cname");
		$writer->text($cname);
		$writer->endElement();
		$writer->startElement("cntry");
		
			$last = count($nodes) - 1;
			
			# group countries together using the same code
			# & lowercase first letter in name
			foreach ($nodes as $index=>$node) {
				$writer->text(mb_convert_case($node->CtryNm, MB_CASE_TITLE, "UTF-8"));
				if ($index!=$last) {$writer->text(', ');}
			}
		$writer->endElement();
	
	$writer->endElement();
}
$writer->endDocument();
$writer->flush();
echo "All done ....!"
?>
