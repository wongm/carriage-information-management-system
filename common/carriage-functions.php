<?php 

/**
 * carriageFunctions.php
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
 * outputs a XHTML page for a carriage
 * includes the title and current type / code, present carriage set it is in, 
 * short description of current carriage type, page content, 
 * and a table with all events that have happened to carriage
 * carriage movements, carriage only events, carriage conversions, 
 * and carset events when the car was part of the set. 
 * outputs 'page not found' if invalid type given
 * @param car the carriage ID of the page should be output
 */
function drawCarriage($car)
{
	// test car id
	if (!is_numeric($car))
	{
		echo "<i>Carriage '$car' not found!</i>";
		return;
	}
	
	// look for and check
	$result = getCarriage($car);
	
	if ($result == '')
	{
		echo "<i>Carriage '$car' not found!</i>";
	}
	else
	{
		// draw page
		extract(getCarriage($car));
		
		$pageTitle = array(array("Carriages", '/carriages'), array("$type Type", "/carriage/type/$type"), array("Car $car", ''));
		$editLink = "carriage/editCarriage.php?id=$car";
		include_once("common/header.php");
		drawTitle("Carriage $type$car");
		getDescription("<i>$typedescription</i>");
		getDescription('Livery: '.$livery);
		getDescription('Status: '.getStatus($status));
		
		if (!is_string($livery))
		{
			getDescription("In <a href=\"".LIVERY_PAGE."$liverylink\">$livery livery</a>");
		}
		
		if (is_null($set))
		{}
		else if ($status == 'service')
		{
			getDescription("Presently in <a href=\"".CARSET_NUMBER_PAGE."$set\">set $settype$set</a>");
		}
		else
		{
			getDescription('Carriage '.$status);
		}
		getDescription($content);
		
		$events = getCarriageEvents($car);
		if (sizeof($events) > 0)
		{
			echo '<h4>Events</h4>';
			drawObjectEvents(formatCarriageEvents($events));
		}
		
		$photos = getObjectmages("carriages/$car");
		if (sizeof($photos) > 0)
		{
			drawObjectmages($photos);
		}
	}
}

function getCarriageFamilyTitle($type)
{
	if (strlen($type) < 2)
	{
		return strtoupper($type)." Type Carriages";
	}
	else if ($type == 'parcel-vans')
	{
		return "Parcel Vans";
	}
	else if ($type == 'loose-cars')
	{
		return  "Loose and special carriages";
	}
	else 
	{
		return  "Power Vans";
	}
}

function drawCarriageFamily($type)
{
	$result = getObject('family', $type);
	if ($result == '')
	{
		echo "<i>Not found!</i>";
	}
	else
	{
		extract($result);
		drawTitle(getCarriageFamilyTitle($type));
		echo "\n";
		$headerpic = strtolower("/images/headerpics/$type-type.jpg");
		if (file_exists(".$headerpic"))
		{
			$caption = strtoupper($type)." type carriage";
			echo "<img class=\"photoright\" src=\"$headerpic\" alt=\"$caption\" title=\"$caption\">\n";
		}
		echo "\n";
		getDescription($carriage_content);
		
		$currentMembers = getObjectsOfFamily('carriage_type', $type);
		
		if (sizeof($currentMembers) != 0)
		{
			echo "<h4>Subtypes</h4>";
			drawObjectsOfType($currentMembers, '', CARRIAGE_TYPE_PAGE);
		}
	}
}

/**
 * outputs a XHTML page for a type of carriage
 * includes the title, short description, page content, 
 * and a table with links to all the current and former carriages with this CODE/ TYPE
 * outputs 'page not found' if invalid type given
 * @param type the carriage type page to be output
 */
function drawCarriageType($type)
{
	$result = getObject('carriage_type', $type);
	if ($result == '')
	{
		echo "<i>Not found!</i>";
	}
	else
	{
		extract($result);
		drawTitle("$type type carriages");
		echo "\n";
		getDescription("<i>$description</i>");
		echo "\n";
		$headerpic = strtolower("/images/headerpics/$type.jpg");
		if (file_exists(".$headerpic"))
		{
			$caption = strtoupper($type)." type carriage";
			echo "<img class=\"photoright\" src=\"$headerpic\" alt=\"$caption\" title=\"$caption\">\n";
		}
		getDescription($content);
		
		$currentMembers = getObjectsOfCode('carriage', 'current', $type, 'carriage');
		$pastMembers = getObjectsOfCode('carriage', 'past', $type, 'carriage');
		
		if (sizeof($currentMembers) != 0)
		{
			echo '<h4>Current fleet</h4>';
			drawObjectsOfType($currentMembers, '', CARRIAGE_NUMBER_PAGE);
		}
		if (sizeof($pastMembers) != 0)
		{
			echo '<h4>Past fleet</h4>';
			drawObjectsOfType($pastMembers, 'yes', CARRIAGE_NUMBER_PAGE);
		}
	}
}

/**
 * outputs a lofi XHTML MP page for a type of carriage
 * includes the title, short description, page content, 
 * and a table with links to all the current and former carriages with this CODE/ TYPE
 * outputs 'page not found' if invalid type given
 * @param type the carriage type page to be output
 */
function drawCarriageTypeMobile($type)
{
	$result = getObject('carriage_type', $type);
	if ($result == '')
	{
		echo "<i>Type '$type' not found</i>";
	}
	else
	{		
		extract($result);
		echo "$type type carriages</p>";
		getDescription("<p align=\"center\"><i>$description</i>");
		
		$currentMembers = getObjectsOfCode('carriage', 'current', $type, 'carriage');
		$pastMembers = getObjectsOfCode('carriage', 'past', $type, 'carriage');
		
		if (sizeof($currentMembers) != 0)
		{
			echo '<hr/><p>Current fleet:<br/>';
			drawObjectsOfTypeMobile($currentMembers, '', 'mcarriages.php?car=');
			echo '</p>';
		}
		if (sizeof($pastMembers) != 0)
		{
			echo '<p>Past fleet:<br/>';
			drawObjectsOfTypeMobile($pastMembers, 'yes', 'mcarriages.php?car=');
			echo '</p>';
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
function formatCarriageEvents($dataarray)
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
					$details = "Carriage built as ".$dataarray[0][4]." type carriage in set ".$dataarray[1][5]."";
					$i++;
				}
				elseif ($dataarray[0][2] == 'built' AND $dataarray[1][4] != '-' AND $dataarray[0][5] != '-')
				{
					$details = "Carriage built as ".$dataarray[1][4]." type carriage in set ".$dataarray[0][5]."";
					$i++;
				}
			}
			// built and carriage type
			elseif ($dataarray[$i][2] == 'built' AND $dataarray[$i][4] != '-')
			{
				$details = "Carriage built as ".$dataarray[$i][4]." type carriage";
			}
			// built and set number
			elseif ($dataarray[$i][2] == 'built' AND $dataarray[$i][5] != '-')
			{
				$details = "Carriage placed into set ".$dataarray[$i][5];
			}
			// converted to carriage type
			elseif ($dataarray[$i][4] != '-')
			{
				$details = "Carriage converted to ".$dataarray[$i][4]." type";
			}
			// carriage moved sets
			elseif ($dataarray[$i][5] == '0')
			{
				$details = "Carriage placed in spare pool";
			}
			elseif ($dataarray[$i][5] != '-')
			{
				$details = "Carriage placed in set ".$dataarray[$i][5];
			}
			// stored
			elseif ($dataarray[$i][6] == 'stored')
			{
				$details = "Carriage stored. ".$dataarray[$i][3];
			}
			// sold
			elseif ($dataarray[$i][6] == 'sold')
			{
				$details = "Carriage sold. ".$dataarray[$i][3];
			}
			// scrapped
			elseif ($dataarray[$i][6] == 'scrap')
			{
				$details = "Carriage scrapped. ".$dataarray[$i][3];
			}
			// scrapped
			elseif ($dataarray[$i][6] == 'sparepool')
			{
				$details = $dataarray[$i][3]." Carriage placed into spare carriage pool";
			}
			else
			{
				$details = $dataarray[$i][3];
			}
			
			if (strlen($details) > 0)
			{
				if ($dataarray[$i][0] == '0000-00-00')
				{
					if($dataarray[$i][2] == '')
					{
						$date = 'Currently in service';
					}
					else
					{
						$date = 'Entered service';
					}
				}
				
				$eventArray[] = array($date, $details);
			}
		}
	}	//end for loop
	return $eventArray;
} //end function

 ?>