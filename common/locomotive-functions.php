<?php 

/**
 * locomotive-functions.php
 * 
 * Functions that mangle around data related to carriages
 * accepts arrays and outputs XHTML or XHTML MP in most cases.
 * 
 * few manapulation functions though.
 * 
 * Marcus Wong
 * May 2008
 *
 */

include_once("common/dbConnection.php");

/**
 * outputs a XHTML page for a locomotive
 * outputs 'page not found' if invalid type given
 * @param number the ID of the page should be output
 */
function drawlocomotive($number)
{
	// look for and check
	$result = getObject('locomotive', $number);
	
	if ($result == '')
	{
		echo "<i>Locomotive '$number' not found!</i>";
	}
	else
	{
		// draw page
		extract($result);
		$classURL = LOCOMOTIVE_CLASS_PAGE.strtolower($class).'-class';
		$pageTitle = array(array("Locomotives", '/locomotives'), array(strtoupper($class).' Class', $classURL), array($number, ''));
		$editLink = "locomotive/editLocomotive.php?id=$number";
		include_once("common/header.php");
		
		drawTitle("Locomotive $number");
		getDescription('<i>'.$description.'</i>');
		getDescription('Livery: '.$livery);
		getDescription('Status: '.getStatus($status));
		getDescription($content);
		
		$events = getEventsOfType('locomotive_event', "locomotive = '$number'");
		if (sizeof($events) > 0)
		{
			echo '<h4>Events</h4>';
			print_r($events);
			drawObjectEvents(formatLocomotiveEvents($events));
		}
		
		$photos = getObjectmages("locomotives/$number");
		if (sizeof($photos) > 0)
		{
			drawObjectmages($photos);
		}
	}
}

function drawLocomotiveClass($class)
{
	// look for and check
	$result = getObject('locomotive_class', $class);
	$class = strtoupper($class);
	if ($result == '')
	{
		echo "<i>'$class' class locomotive not found!</i>";
	}
	else
	{
		// draw page
		extract($result);
		drawTitle("$class class locomotives");
		echo "\n";
		getDescription("<i>$description</i>");
		echo "\n";
		$headerpic = strtolower("/images/headerpics/$class-class.jpg");
		if (file_exists(".$headerpic"))
		{
			echo "<img class=\"photoright\" src=\"$headerpic\" alt=\"$class class locomotive\" title=\"$class class locomotive\">\n";
		}
		getDescription($content);
		
		$currentMembers = getAllObjectsOfTable('locomotive', '', ' o.id ASC ', $class);
		if (sizeof($currentMembers) != 0)
		{
			echo "<h4>Class members</h4>";
			drawObjectsOfType($currentMembers, '', LOCOMOTIVE_NUMBER_PAGE);
		}
		
		$events = getEventsOfType('locomotive_class_event', "locomotive_class = '$class'");
		if (sizeof($events) > 0)
		{
			echo '<h4>Events</h4>';
			drawObjectEvents(formatLocomotiveEvents($events));
		}
	}
}



/**
 * formats an array of events to be more readable
 * @param dataarray the events array to be modified. PlainDate, Date, 
 * Why (sighting, book date, ect), Note about event, 
 * carriage type Converted to, carriage set added to, type of event
 * @return formatted event array. 2 elements are formatted date, and formatted text.
 */
function formatLocomotiveEvents($dataarray)
{
	$numberOfRows = sizeof($dataarray);
	
	for ($i = 0; $i<$numberOfRows; $i++)
	{	
		// only display non-null dates that are not special 'current' events
		if ($dataarray[$i][1] != '' AND $dataarray[$i][2] != 'current')
		{
			// setup date of event
			$date = $dataarray[$i][2];
			
			if($dataarray[$i][3] == 'seen')
			{
				$date .= ' (sighting)';
			}
			
			// stored
			if ($dataarray[$i][5] == 'stored')
			{
				$details = "Locomotive stored. ".$dataarray[$i][4];
			}
			// sold
			elseif ($dataarray[$i][5] == 'sold')
			{
				$details = "Locomotive sold. ".$dataarray[$i][4];
			}
			// scrapped
			elseif ($dataarray[$i][5] == 'scrap')
			{
				$details = "Locomotive scrapped. ".$dataarray[$i][4];
			}
			elseif ($dataarray[$i][5] == 'built')
			{
				$details = "Locomotive built. ".$dataarray[$i][4];
			}
			elseif ($dataarray[$i][5] == 'service')
			{
				$details = "Locomotive entered service. ".$dataarray[$i][4];
			}
			else
			{
				$details = $dataarray[$i][4];
			}
			
			$date = str_replace('1 January, 0001', 'Entered service', $date);
			
			$eventArray[] = array($date, $details);
		}
	}	//end for loop
	return $eventArray;
} //end function
?>