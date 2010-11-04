<?php 

/**
 * carsetFunctions.php
 * 
 * Functions that mangle around data related to carriage sets
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
 * outputs a XHTML page for a type of carriage set 
 * includes the title, short description, page content, 
 * and a table with links to all the current and former sets with this CODE/ TYPE
 * outputs 'page not found' if invalid type given
 * @param type the carriage set type page to be output
 */
function drawCarsetType($type)
{
	$result = getCarsetType($type);
	if ($result == '')
	{
		echo "<i>Type '$type' not found</i></p>";
	}
	else
	{	
		extract($result);
		$familyUrl = "/carsets/".strtolower($family)."-type";
		$pageTitle = array(array("Carriage Sets", '/carsets'), array("$family Type", $familyUrl), array("$type Sets", ''));
		$editLink = "carset-type/editCarsetType.php?id=$type";
		include_once("common/header.php");	
		drawTitle("$type type carriage sets");
		
		getDescription("<i>$description</i>");
		echo "\n";
		$headerpic = strtolower("/images/headerpics/$type-set.jpg");
		if (file_exists(".$headerpic"))
		{
			echo "<img class=\"photoright\" src=\"$headerpic\" alt=\"$type type carriage set\" title=\"$type type carriage set\">\n";
		}
		getDescription($content);
		
		$currentMembers = getObjectsOfCode('carset', 'current', $type, '`carset`');
		$pastMembers = getObjectsOfCode('carset', 'past', $type, '`carset`');
		
		if (sizeof($currentMembers) != 0)
		{
			echo '<h4>Current members</h4>';
			drawObjectsOfType($currentMembers, '', CARSET_NUMBER_PAGE);
		}
		if (sizeof($pastMembers) != 0)
		{
			echo '<h4>Past members</h4>';
			drawObjectsOfType($pastMembers, 'yes', CARSET_NUMBER_PAGE);
		}
	}
}

/**
 * outputs a lofi XHTML MP page for a type of carriage set 
 * includes the title, short description, page content, 
 * and a table with links to all the current and former sets with this CODE/ TYPE
 * outputs 'page not found' if invalid type given
 * @param type the carriage set type page to be output
 */
function drawCarsetTypeMobile($type)
{
	$result = getObject('carset_type', $type);
	if ($result == '')
	{
		echo "<i>Type '$type' not found</i></p>";
	}
	else
	{		
		extract($result);
		echo "$type type carriages</p>";
		getDescription("<i>$description</i>");
	
		$currentMembers = getObjectsOfCode('carset', 'current', $type, '`carset`');
		$pastMembers = getObjectsOfCode('carset', 'past', $type, '`carset`');
	
		if (sizeof($currentMembers) != 0)
		{
			echo '<hr/><p>Current members:</p>';
			drawObjectsOfTypeMobile($currentMembers, '', 'mcarsets.php?set=');
		}
		if (sizeof($pastMembers) != 0)
		{
			echo '<p>Past members:</p>';
			drawObjectsOfTypeMobile($pastMembers, 'yes', 'mcarsets.php?set=');
		}
	}
}

function drawCarsetFamily($type)
{
	$result = getObject('family', $type);
	if ($result == '')
	{
		echo "<i>Not found!</i></p>";
	}
	else
	{
		extract($result);
		drawTitle("$type Type Carriage Sets");
		echo "\n";
		$headerpic = strtolower("/images/headerpics/$type-family.jpg");
		if (file_exists(".$headerpic"))
		{
			echo "<img class=\"photoright\" src=\"$headerpic\" alt=\"$type type carriage set\" title=\"$type type carriage set\">\n";
		}
		
		getDescription($carset_content);
		$currentMembers = getObjectsOfFamily('carset_type', $type);
		if (sizeof($currentMembers) != 0)
		{
			echo "<h4>Subtypes</h4>";
			drawObjectsOfType($currentMembers, '', CARSET_TYPE_PAGE);
		}
		
		$currentMembers = getCarsetsOfFamily('carset', $type);
		if (sizeof($currentMembers) != 0)
		{
			echo "<h4>Carsets</h4>";
			drawObjectsOfType($currentMembers, '', CARSET_NUMBER_PAGE);
		}
	}
}

/**
 * outputs a XHTML page for a carriage set
 * includes the title and current type / code, 
 * short description of current carriage set type, page content, 
 * and a table with all events that have happened to carriage set
 * carriage movements, carriage set only events, and recodings. 
 * also all carriages in the set, in order, and all former carriages. 
 * outputs 'page not found' if invalid type given
 * @param set the carriage set ID of the page should be output
 */
function drawCarset($set, $result)
{
	if ($result == '')
	{
		echo "<i>Carriage set '$set' not found!</i></p>";
	}
	else
	{
		extract($result);
		$familyLink = "/carset/type/".strtoupper($type);
		$pageTitle = array(array("Carriage Sets", '/carsets'), array("$type Type", $familyLink), array($result[type].$set, ''));
		$editLink = "carset/editCarset.php?id=$set";
		include_once("common/header.php");
		
		drawTitle("Carriage Set $type$set");
		getDescription("<i>$typedescription</i>");
		getDescription('Livery: '.$livery);
		getDescription('Status: '.getStatus($status));
		
		if (!is_string($livery))
		{
			getDescription("In <a href=\"".LIVERY_PAGE."$liverylink\">$livery livery</a>");
		}
		
		getDescription($content);
		
		$events = getCarsetEvents($set);
		if (sizeof($events) > 0)
		{
			echo '<h4>Events</h4>';
			drawObjectEvents(formatCarsetEvents($events));
		}
		
		$currentMembers = getObjectsOfCode('carriage_carset', 'current', $id, 'position ASC, carriage ');
		if (sizeof($currentMembers) != 0)
		{
			echo '<h4>Current members</h4>';
			drawCarriagesOfCarset($currentMembers, ' - ', CARRIAGE_NUMBER_PAGE);
		}
		
		$pastMembers = getObjectsOfCode('carriage_carset', 'past', $id, 'position ASC, carriage ');
		if (sizeof($pastMembers) != 0)
		{
			echo '<h4>Past members</h4>';
			drawCarriagesOfCarset($pastMembers, ' - ', CARRIAGE_NUMBER_PAGE);
		}
		
		$photos = getObjectmages("carsets/$set");
		if (sizeof($photos) > 0)
		{
			drawObjectmages($photos);
		}
	}
}

/**
 * outputs a lofi XHTML MP page for a carriage set
 * includes the title and current type / code, 
 * short description of current carriage set type, page content, 
 * and a table with all events that have happened to carriage set
 * carriage movements, carriage set only events, and recodings. 
 * also all carriages in the set, in order, and all former carriages. 
 * outputs 'page not found' if invalid type given
 * @param set the carriage set ID of the page should be output
 */
function drawCarsetMobile($set)
{
	$result = getCarset($set);
	
	if ($result == '')
	{
		echo "<i>Carriage set '$set' not found</i></p>";
	}
	else
	{
		extract($result);
		echo "Set $type$set<br/>";
		echo "<i>$typedescription</i></p>";
		$currentMembers = getObjectsOfCode('carriage_carset', 'current', $id, 'carriage ASC, position ');
	
		if (sizeof($currentMembers) != 0)
		{
			echo '<p>Current members:<br/>';
			drawCarriagesOfCarsetMobile($currentMembers, '<br/>', 'mcarriages.php?car=');
			echo '</p>';
		}
		
		drawObjectEventsMobile(formatCarsetEvents(getCarsetEvents($set)));
	}
}

/**
 * outputs a XHTML snippet for a carriage set, 
 * linking to all carriages in it, in order
 * @param data array with the carriage data in it, second element is the carriage ID
 */
function drawCarriagesOfCarset($data, $spacer, $url)
{
	$size = sizeof($data);
	
	if ($size > 0)
	{
		echo '<table class="linedTable"><tr class="x"><td>';
		for ($i = 0; $i < $size; $i++)
		{
			$thisId = $data[$i][0];
			$thisType = getCarriageType('9999-01-01', $thisId);
			echo "<a href=\"$url$thisId\">$thisType$thisId</a>";
			
			if ($i != $size-1)
			{
				echo $spacer;
			}
		}
		echo "</td></tr></table>";
	}	
}

/**
 * outputs a lofi XHTML MP snippet for a carriage set, 
 * linking to all carriages in it, in order
 * @param data array with the carriage data in it, second element is the carriage ID
 */
function drawCarriagesOfCarsetMobile($data, $spacer, $url)
{
	$size = sizeof($data);
	
	if ($size > 0)
	{
		for ($i = 0; $i < $size; $i++)
		{
			$thisType = getCarriageType('9999-01-01', $data[$i][1]);
			$thisId = $data[$i][1];
			echo "<a href=\"$url$thisId\">$thisType$thisId</a>";
			
			if ($i != $size-1)
			{
				echo $spacer;
			}
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
function formatCarsetEvents($dataarray)
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
			if ($dataarray[0][1] == $dataarray[1][1] AND $dataarray[0][4] != '-' AND $i == 0)
			{
				// check first two are built as type and for adding to set - in two ways
				if ($dataarray[0][2] == 'built' AND $dataarray[0][4] != '-' AND $dataarray[1][5] != '-')
				{
					$details = "Set assembled as ".$dataarray[0][4]." set";
					$i++;
				}
				elseif ($dataarray[0][2] == 'built' AND $dataarray[1][4] != '-' AND $dataarray[0][5] != '-')
				{
					$details = "Set assembled as ".$dataarray[1][4]." set";
					//$details = "Carriage built as ".$dataarray[1][4]." type carriage in set ".$dataarray[0][5]."";
					$i++;
				}
			}
			// removed car
			elseif ($dataarray[$i][6] == 'removed')
			{
				$details = "Carriage ".$dataarray[$i][5]." removed";
			}
			// built and carriage type
			elseif ($dataarray[$i][2] == 'built' AND $dataarray[$i][4] != '-')
			{
				$details = "Carset assembled as ".$dataarray[$i][4]." type set";
			}
			// built and set number
			elseif ($dataarray[$i][2] == 'built' AND $dataarray[$i][5] != '-')
			{/*
				if ($i+1 != $numberOfRows)
				{
					if ($dataarray[$i+1][1] == $date)
					{
						$details = "Carset assembled with cars ".$dataarray[$i][5].", ".$dataarray[$i+1][5];
						$i++;
						
						while ($i+1 != $numberOfRows AND $dataarray[$i+1][1] == $date)
						{
							$details .= ", ".$dataarray[$i][5];
							$i++;
						}
					}
					else
					{
						$details = "Carset assembled with car ".$dataarray[$i][5];
					}
				}
				else*/
				
				$details = "Carset assembled with car ".$dataarray[$i][5];
			}
			// converted to carriage type
			elseif ($dataarray[$i][4] != '-')
			{
				$details = "Carset recoded as ".$dataarray[$i][4]." type";
			}
			// carriage moved sets
			elseif ($dataarray[$i][5] != '-')
			{
				
				$details = "Carriage ".$dataarray[$i][5]." placed in set";
			}
			// stored
			elseif ($dataarray[$i][6] == 'stored')
			{
				$details = "Carset stored. ".$dataarray[$i][3];
			}
			// sold
			elseif ($dataarray[$i][6] == 'sold')
			{
				$details = "Carset sold. ".$dataarray[$i][3];
			}
			/*
			// scrapped
			elseif ($dataarray[$i][6] == 'scrap')
			{
				$details = "Carriage scrapped. ".$dataarray[$i][3];
			}
			*/
			// spare pool
			elseif ($dataarray[$i][6] == 'sparepool')
			{
				$details = $dataarray[$i][3]." Carset broken up and carriages placed into spare pool";
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
