<?php

/**
 * carset.php
 *
 * Takes requests from the use passed as query strings,
 * and fobs it off to sub-methods.
 *
 * Marcus Wong
 * May 2008
 *
 */

$display = $_REQUEST['section'];
$set = strtoupper($_REQUEST['set']);
$type = strtoupper($_REQUEST['type']);

include_once("common/formatting-functions.php");
include_once("common/carset-functions.php");
include_once("common/gallery-functions.php");

// individual carriage set page
if ($set != '')
{
	$result = getCarset($set);
	drawCarset($set, $result);
}
// individual carriage set type page
elseif ($type != '')
{
	drawCarsetType($type);
}
// display all carriages sets by number
elseif ($display == 'number')
{
	$pageTitle = array(array("Carriage Sets", '/carsets'), array("By Number", ''));
	$editLink = 'carset/listCarset.php';
	include_once("common/header.php");

	drawTitle('Carriage Sets By Number');
	echo '<h4>Current</h4>';
	drawObjectsOfType(getAllCarsets('service'), '', CARSET_NUMBER_PAGE);

	echo '<h4>Former</h4>';
	drawObjectsOfType(getAllCarsets('outofservice'), '', CARSET_NUMBER_PAGE);
}
// display all carriages sets by type
elseif ($display == 'type')
{
	$pageTitle = array(array("Carriage Sets", '/carsets'), array("By Type", ''));
	$editLink = 'carset-type/listCarsetType.php';
	include_once("common/header.php");

	drawTitle('Carriage Sets By Type');
	drawObjectsOfType(getAllObjectsOfTable('carset_type', '', 'family, cars'), '', CARSET_TYPE_PAGE);
}
// carset families
elseif ($display != '')
{
	$display = strtoupper($display);
	$pageTitle = array(array("Carriage Sets", '/carsets'), array("$display Type", ''));
	$editLink = "family/editFamily.php?id=$display";
	include_once("common/header.php");
	drawCarsetFamily($display);
}

include_once("common/footer.php"); ?>