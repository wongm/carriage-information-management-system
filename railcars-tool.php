<?php 

/**
 * Railcars.php
 * 
 * Takes requests from the use passed as query strings, 
 * and fobs it off to sub-methods.
 * 
 * Marcus Wong
 * May 2008
 *
 */

$car = $_REQUEST['car'];
$type = $_REQUEST['type'];

include_once("common/vlinecars-formatting-functions.php"); 
include_once("common/formatting-functions.php"); 
include_once("common/railcar-functions.php"); 
include_once("common/gallery-functions.php"); 
	
	// individual railcar page
	if ($car != '')
	{
		$result = getRailcar($car);
		$pageTitle = array(array("Railcars", '/railcars'), array($result['type'], "/railcars/".strtolower($result['type'])), array($result['id'], ''));
		$editLink = "railcar/editRailcar.php?id=$car";
		include_once("common/header.php");
		drawRailcar($result);
	}
	// individual railcar type page
	elseif ($type != '')
	{
		$result = getRailcarType($type);
		$pageTitle = array(array("Railcars", '/railcars'), array($result['id'], ''));
		$editLink = "/railcar-type/editRailcarType.php?id=$type";
		include_once("common/header.php");
		drawRailcarType($result);
		
	}
	// fallback
	else
	{
		$pageTitle = array(array("Railcars", ''));
		include_once("common/header.php");
		drawTitle('Railcars');
		getDescription(getConfigVariable('railcar_description'));
	}
	
	include_once("common/footer.php");
?>
	