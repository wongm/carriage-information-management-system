<?php 

/**
 * locomotives.php
 * 
 * Takes requests from the use passed as query strings, 
 * and fobs it off to sub-methods.
 * 
 * Marcus Wong
 * May 2008
 *
 */

$display = $_REQUEST['section'];
$class = strtoupper($_REQUEST['class']);
$number = strtoupper($_REQUEST['number']);

include_once("common/vlinecars-formatting-functions.php"); 
include_once("common/formatting-functions.php");
include_once("common/locomotive-functions.php"); 
include_once("common/gallery-functions.php"); 
	
	// individual carriage page
	if ($number != '')
	{
		drawLocomotive($number);
	}
	// individual carriage class page
	elseif ($class != '')
	{
		$pageTitle = array(array("Locomotives", '/locomotives'), array($class." class", ''));
		include_once("common/header.php");
		drawLocomotiveClass($class);
	}
	// fallback
	else
	{
		$pageTitle = array(array("Locomotives", '/locomotives'));
		include_once("common/header.php");
		drawTitle('Locomotives');
		echo "\n";
		$headerpic = strtolower("/images/headerpics/locomotives.jpg");
		if (file_exists(".$headerpic"))
		{
			echo "<img class=\"photoright\" src=\"$headerpic\" alt=\"Locomotives\" title=\"Locomotives\">\n";
		}
		echo "\n";
		getDescription(getConfigVariable('locomotive_description'));
	}
	
	include_once("common/footer.php");
?>
	