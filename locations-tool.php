<?php 
include_once("common/dbConnection.php");
include_once("common/location-functions.php");
include_once("common/formatting-functions.php");

$locationName = str_replace('-', ' ', $_REQUEST['name']);

// show specific location - when losts of info given
if($locationName != "")
{
	$location = getLocation($locationName, '', '', '');
	if (!$location['error'])
	{
		$pageTitle = array(array("Regions", '/regions'), 
			array($location['lineName'], "/region/".$location['lineLink']), 
			array($location['pageTitle'], ''));
		include_once("common/header.php");
		drawLocation($location);
	}
	else
	{
		draw404InvalidSubpage('', 'station');
	}
} ?>

