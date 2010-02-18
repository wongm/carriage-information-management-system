<?php 

include_once("common/dbConnection.php");
include_once("common/lineguide-functions.php");
include_once("common/formatting-functions.php");

$lineToDisplay = 	$_REQUEST['line'];

/* General list all thingy */
if ($lineToDisplay != '')
{
	$line = getLine($lineToDisplay, date('Y'));
	extract($line);
	
	if ($lineId == '')
	{
		draw404InvalidSubpage("", 'region');
	}
	else
	{
		$pageTitle = array(array("Regions", '/regions'), array($lineName, ''));
		include_once("common/header.php");
		drawTitle($lineName);
		getDescription($line['description']);
		drawPlainLocationsTable(getLocationsTable($lineId, $lineToDisplay, '', '', $sort));
		include_once("common/footer.php");
	}
}
else
{
	$pageTitle = array(array("Regions", ''));
	include_once("common/header.php");
	drawTitle('Operating Regions');
	getDescription(getConfigVariable('regions_description'));
	include_once("common/footer.php");
}
		
?>