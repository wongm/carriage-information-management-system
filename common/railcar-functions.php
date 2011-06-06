<?php

/**
 * railcarFunctions.php
 *
 * Functions that mangle around data related to railcars
 * accepts arrays and outputs XHTML or XHTML MP in most cases.
 *
 * few manapulation functions though.
 *
 * Marcus Wong
 * May 2008
 *
 */

include_once("common/dbConnection.php");

function fixRailcarType($type)
{
	switch($type)
	{
		case 'vlocity':
			return 'VLocity';
		case 'sprinter':
			return 'Sprinter';
		default:
			return $type;
	}
}

function getRailcar($car)
{
	// look for and check
	$result = getObject('railcar', $car);
	$result['type'] = fixRailcarType($result['type']);
	return $result;
}

/**
 * outputs a XHTML page for a railcar
 * includes the title and current type / code, present railcar set it is in,
 * short description of current railcar type, page content,
 * and a table with all events that have happened to railcar
 * railcar movements, railcar only events, railcar conversions,
 * and carset events when the car was part of the set.
 * outputs 'page not found' if invalid type given
 * @param car the railcar ID of the page should be output
 */
function drawRailcar($result)
{
	if ($result == '')
	{
		echo "<i>Railcar '".$_REQUEST['car']."' not found!</i></p>";
	}
	else
	{
		extract($result);
		// draw page
		if (strtolower($type) == 'vlocity')
		{
			drawTitle("$type set $id");
		}
		else
		{
			drawTitle("$type railcar $id");
		}			

		getDescription("<i>$typedescription</i></p>");
		getDescription('Livery: '.$livery);
		getDescription('Status: '.getStatus($status));
		getDescription($content);

		$events = getEventsOfType('railcar_event', "railcar = '$id'");
		if (sizeof($events) > 0)
		{
			echo '<h4>Events</h4>';
			drawObjectEvents(formatRailcarEvents($events));
		}
		//drawObjectEvents(formatRailcarEvents(getRailcarEvents($car)));

		$photos = getObjectmages("railcars/$id");
		if (sizeof($photos) > 0)
		{
			drawObjectmages($photos);
		}
	}
}

function getRailcarType($type)
{
	$result = getObject('railcar_type', $type);
	return $result;
}


/**
 * outputs a XHTML page for a type of railcar
 * includes the title, short description, page content,
 * and a table with links to all the current and former railcars with this CODE/ TYPE
 * outputs 'page not found' if invalid type given
 * @param type the railcar type page to be output
 */
function drawRailcarType($result)
{
	if ($result == '')
	{
		$id = $_REQUEST['type'];
		echo "<i>$id railcars not found!</i></p>";
	}
	else
	{
		extract($result);
		drawTitle("$id type railcars");
		getDescription("<i>$description</i>");
		echo "\n";
		$headerpic = strtolower("/images/headerpics/$id-railcar.jpg");
		if (file_exists(".$headerpic"))
		{
			echo "<img class=\"photoright\" src=\"$headerpic\" alt=\"$id railcar\" title=\"$id railcar\">\n";
		}
		echo "\n";
		getDescription($content);

		$currentMembers = getAllObjectsOfTable('railcar', '', 'o.id ASC' , $id);
		if (sizeof($currentMembers) != 0)
		{
			echo '<h4>Current fleet</h4>';
			drawObjectsOfType($currentMembers, '', RAILCAR_NUMBER_PAGE);
		}
	}
}

/**
 * formats an array of events to be more readable
 * @param dataarray the events array to be modified. PlainDate, Date,
 * Why (sighting, book date, ect), Note about event,
 * railcar type Converted to, railcar set added to, type of event
 * @return formatted event array. 2 elements are formatted date, and formatted text.
 */
function formatRailcarEvents($dataarray)
{
	$numberOfRows = sizeof($dataarray);

	for ($i = 0; $i<$numberOfRows; $i++)
	{
		// only display non-null dates that are not special 'current' events
		if ($dataarray[$i][1] != '' AND $dataarray[$i][2] != 'current')
		{
			// setup date of event
			$date = $dataarray[$i][1];

			if($dataarray[$i][2] == 'seen')
			{
				$date .= ' (sighting)';
			}

			// check for events that follow from each other for new constructions
			if ($dataarray[$i][1] == $dataarray[$i+1][1] AND ($i == 0 OR $i == 1))
			{
				// check first two are built as type and for adding to set - in two ways
				if ($dataarray[0][2] == 'built' AND $dataarray[0][4] != '-' AND $dataarray[1][5] != '-')
				{
					$details = "Railcar built as ".$dataarray[0][4]." type railcar in set ".$dataarray[1][5]."";
					$i++;
				}
				elseif ($dataarray[0][2] == 'built' AND $dataarray[1][4] != '-' AND $dataarray[0][5] != '-')
				{
					$details = "Railcar built as ".$dataarray[1][4]." type railcar in set ".$dataarray[0][5]."";
					$i++;
				}
			}
			// built and railcar type
			elseif ($dataarray[$i][2] == 'built' AND $dataarray[$i][4] != '-')
			{
				$details = "Railcar built as ".$dataarray[$i][4]." type railcar";
			}
			// built and set number
			elseif ($dataarray[$i][2] == 'built' AND $dataarray[$i][5] != '-')
			{
				$details = "Railcar placed into set ".$dataarray[$i][5];
			}
			// converted to railcar type
			elseif ($dataarray[$i][4] != '-')
			{
				$details = "Railcar converted to ".$dataarray[$i][4]." type";
			}
			// railcar moved sets
			elseif ($dataarray[$i][5] == '0')
			{
				$details = "Railcar placed in spare pool";
			}
			elseif ($dataarray[$i][5] != '-')
			{
				$details = "Railcar placed in set ".$dataarray[$i][5];
			}
			// stored
			elseif ($dataarray[$i][6] == 'stored')
			{
				$details = "Railcar stored. ".$dataarray[$i][3];
			}
			// sold
			elseif ($dataarray[$i][6] == 'sold')
			{
				$details = "Railcar sold. ".$dataarray[$i][3];
			}
			// scrapped
			elseif ($dataarray[$i][6] == 'scrap')
			{
				$details = "Railcar scrapped. ".$dataarray[$i][3];
			}
			// into service
			elseif ($dataarray[$i][6] == 'service')
			{
				$details = "Railcar entered service. ".$dataarray[$i][3];
			}
			// scrapped
			elseif ($dataarray[$i][6] == 'sparepool')
			{
				$details = $dataarray[$i][3]." Railcar placed into spare railcar pool";
			}
			else
			{
				$details = $dataarray[$i][3];
			}

			$date = str_replace('1 January, 0001', 'Entered service', $date);
			$eventArray[] = array($date, $details);
		}
	}	//end for loop
	return $eventArray;
} //end function

 ?>