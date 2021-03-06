<?php

/**
 * carriages.php
 *
 * Takes requests from the use passed as query strings,
 * and fobs it off to sub-methods.
 *
 * Marcus Wong
 * May 2008
 *
 */

$display = $_REQUEST['section'];
$car = $_REQUEST['car'];
$type = $_REQUEST['type'];

include_once("common/vlinecars-formatting-functions.php");
include_once("common/formatting-functions.php");
include_once("common/carriage-functions.php");
include_once("common/gallery-functions.php");

	// individual carriage page
	if ($car != '')
	{
		drawCarriage($car);
	}
	// individual carriage type page
	elseif ($type != '')
	{
		$pageTitle = array(array("Carriages", '/carriages'), array("$type Type", ''));
		$editLink = "carriage-type/editCarriageType.php?id=$type";
		include_once("common/header.php");
		drawCarriageType($type);
	}
	// individual carriage type page
	elseif ($display == 'loose-cars' OR $display == 'power-vans' OR $display == 'parcel-vans' )
	{
		$pageTitle = array(array("Carriages", '/carriages'), array(getCarriageFamilyTitle($display), ''));
		$editLink = "family/editFamily.php?id=$display";
		include_once("common/header.php");
		drawCarriageFamily($display);
	}
	// display all carriages by number
	elseif ($display == 'number')
	{
		$pageTitle = array(array("Carriages", '/carriages'), array("By Number", ''));
		$editLink = "carriage/listCarriage.php";
		include_once("common/header.php");
		drawTitle('Carriages By Number');
		echo '<h4>In service</h4>';
		drawObjectsOfType(getAllCarriages('service', 'all'), '', CARRIAGE_NUMBER_PAGE);

		echo '<h4>Out of service</h4>';
		drawObjectsOfType(getAllCarriages('outofservice', 'all'), 'out', CARRIAGE_NUMBER_PAGE);
	}
	// display all carriages by type
	elseif ($display == 'type')
	{
		$pageTitle = array(array("Carriages", '/carriages'), array("By Type", ''));
		$editLink = "carriage-type/listCarriageType.php";
		include_once("common/header.php");
		drawTitle('Carriages By Type');
		drawObjectsOfType(getAllObjectsOfTable('carriage_type', '', 'id'), 'current', CARRIAGE_TYPE_PAGE);
	}
	// carriage family
	elseif ($display != '')
	{
		$pageTitle = array(array("Carriages", '/carriages'), array(getCarriageFamilyTitle($display), ''));
		$editLink = "family/editFamily.php?id=$display";
		include_once("common/header.php");
		drawCarriageFamily($display);
	}

	include_once("common/footer.php");
?>
