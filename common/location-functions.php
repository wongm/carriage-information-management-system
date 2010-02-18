<?php

/*
 *	returns an array of data for a location
 */
function getLocation($locationToFind, $boxToFind, $idToFind, $linelink)
{
	$toFind .= "l.name = '".addslashes($locationToFind)."' AND ";
	$sql = "SELECT * , DATE_FORMAT(open, '%W, %e %M %Y') AS fopen, DATE_FORMAT(close, '%W, %e %M %Y') 
			AS fclose FROM locations l, locations_raillines lr, raillines r 
			WHERE ".$toFind." r.line_id = lr.line_id AND l.location_id = lr.location_id 
			AND display != 'tracks' AND r.todisplay != 'hide' ORDER BY l.location_id ASC";
	$result = MYSQL_QUERY($sql);
	
	// if no duplicates - spit it out!
	if (MYSQL_NUM_ROWS($result) == 1)
	{
		// page header stuff
		$pageTitle = MYSQL_RESULT($result,'0',"name");
		$pageTitle = stripslashes($pageTitle);
		
		// set output status
		$location["error"] = false;
		
		// collect data into an array
		$location["id"] = MYSQL_RESULT($result,'0',"location_id");
		$location["numberoflines"] = MYSQL_NUM_ROWS($result);
		$location["pageTitle"] = $pageTitle;
		$location["result"] = $result;
		$location["name"] = MYSQL_RESULT($result,'0',"name");
		$location["uniqueId"] = $location["id"];
		$location["display"] = MYSQL_RESULT($result,'0',"display");
		$location["url"] = MYSQL_RESULT($result,'0',"url");
		$location["description"] = stripslashes(MYSQL_RESULT($result,'0',"description"));
		$location["credits"] = stripslashes(MYSQL_RESULT($result,'0',"l.credits"));
		$location["image"] = MYSQL_RESULT($result,'0',"image");
		$location["diagrams"] = MYSQL_RESULT($result,'0',"diagrams");
		$location["km"] = MYSQL_RESULT($result,'0',"lr.km");
		$location["lineName"] = MYSQL_RESULT($result,'0',"r.name");
		$location["lineLink"] = MYSQL_RESULT($result,'0',"r.link");
		$location["line"] = MYSQL_RESULT($result,'0',"r.line_id");
		$location["approxOpen"] = MYSQL_RESULT($result,'0',"openAccuracy");
		$location["approxClose"] = MYSQL_RESULT($result,'0',"closeAccuracy");
		$location["stillOpen"] = MYSQL_RESULT($result,'0',"close") > date('Y-m-d');
		$location["openPlain"] = MYSQL_RESULT($result,'0',"open");
		$location["closePlain"] = MYSQL_RESULT($result,'0',"close");
		$location["coords"] = MYSQL_RESULT($result,'0',"long");
		$location["photos"] = MYSQL_RESULT($result,'0',"photos");
		$location["open"] = formatDate(MYSQL_RESULT($result,'0',"fopen"), $approxOpen);
		$location["close"] = formatDate(MYSQL_RESULT($result,'0',"fclose"), $approxClose);
		$location["todisplay"] = MYSQL_RESULT($result,'0',"r.todisplay");
		
		$kmAccuracy = MYSQL_RESULT($result,'0',"lr.kmAccuracy");
		if ($kmAccuracy == 'exact')
		{
			$location["exactKm"] =  true;
			$location["hideKm"] = false;
		}
		else
		{
			$location["hideKm"] = true;
			$location["exactKm"] =  false;
		}
		
		// fix for location on two lines
		if ($linelink != '')
		{
			$location["linesource"] = $linelink;
			
			if ($location["lineLink"] != $linelink)
			{
				$location["basekm"] = $location["km"];
				$location["km"] = MYSQL_RESULT($result,'1',"lr.km");
			}
			else
			{
				$location["basekm"] = $location["km"];
			}
		}
		else
		{
			$location["linesource"] = $location["lineLink"];
			$location["basekm"] = $location["km"];
		}
		
		// next and backward locations
		$location["nextLocation"] = getNeighbourLocation($location["id"], $location["km"], $location["lineLink"], 'next');
		$location["backLocation"] = getNeighbourLocation($location["id"], $location["km"], $location["lineLink"], 'back');
		
		return 	$location;
	}	// end zero result if
	else
	{
		$location['error'] = 'empty';
		return $location;
	}
}		// end function


/*
 * gets the next location on a line
 * forwards or backwards
 */
function getNeighbourLocation($id, $km, $linelink, $way)
{
	$bit = '';
	
	if ($_REQUEST['line'] != '')
	{		
		$linelink = str_replace('-line', '', $_REQUEST['line']);
	}
	
	$line = MYSQL_RESULT(MYSQL_QUERY("SELECT * FROM raillines WHERE link = '".$linelink."'"),0,"line_id");
	if ($way == 'back')
	{
		$sqlNext = "SELECT * FROM locations l, locations_raillines lr 
		WHERE l.location_id = lr.location_id 
		AND lr.km < '".$km."' AND (lr.line_id = '".$line."') 
		ORDER BY lr.km DESC";
	}
	else
	{
		$sqlNext = "SELECT * FROM locations l, locations_raillines lr 
		WHERE l.location_id = lr.location_id 
		AND lr.km > '".$km."' AND (lr.line_id = '".$line."')  
		ORDER BY lr.km ASC";
	}
	$resultNext = MYSQL_QUERY($sqlNext);
	
	if (MYSQL_NUM_ROWS($resultNext) > '0')	
	{
		$name = stripslashes(MYSQL_RESULT($resultNext,0,"name"));
		$id = stripslashes(MYSQL_RESULT($resultNext,0,"location_id"));
		$type = stripslashes(MYSQL_RESULT($resultNext,0,"type"));
		$base = str_replace(' ', '-', strtolower($name));
		
		if ($way == 'back')
		{
			return '<a href="/region/station/'.$base.$bit.'" alt="Previous Location" title="Previous Location" >&laquo; '.$name.'</a>'; 
		}
		else
		{
			return '<a href="/region/station/'.$base.$bit.'" alt="Next Location" title="Next Location">'.$name.' &raquo;</a>'; 
		}
	}
}
	
/*
 * draws a Location to the page
 * give it an array with location data
 */
function drawLocation($location)
{
	extract($location);
?>
<div class="locations">
<?
	
	// working out if dot poinst section shown or not
	$dotpoints = 0;
	drawTitle($pageTitle);
	
	if ($typeToDisplay != 'Miscellaneous')	
	{
?>
<div class="datatable">
	<b>Region: </b><a href="/region/<?=$lineLink?>"><?=$lineName?></a><br/>
<?		
		if (!$hideKm)	
		{
			if(!$exactKm)
			{
				$basekm .= ' (approx)';
			}
?>
	<b>Distance from Melbourne: </b><?=$basekm?>km<?=$distancestring?><br/>
<?
		}
	}	// end 'Miscellaneous' if statement
		
	if ($coords != '' AND $coords != '0')
	{
?>
	<b>Google Map: </b><a href="/aerial.php?id=<?=$id?>"  onClick="p(this.href); return false;">View</a><br/>
<?
	}
	
	if (!$isCrossing AND $openPlain != '0001-01-01')	
	{
?>
	<b>Opened: </b><?=formatDate($open, $approxOpen)?><br/>
<?
	}
	
	if(!$isCrossing  AND !$stillOpen)
	{
?>
	<b>Closed: </b><?=formatDate($close, $approxClose)?><br/>
<?
	}
?>
</div>
<ul>
<?
	// for table of contents
	if($description != "")
	{
		$descriptionTitles = getDescriptionTitles($description); 
		$sizedt = sizeof($descriptionTitles);
		$dotpoints = $dotpoints + $sizedt;
		
		for ($i = 0; $i < sizeof($descriptionTitles); $i++)
		{
?>
	<li><?=$descriptionTitles[$i]?></li>
<?	
		}
	}
	
	// display description
	if($description != "")
	{
		getDescription($description); 
	}
	
	echo '</div>';
	
	drawNeighbourLocationBar($nextLocation, $backLocation);	
	include_once("common/footer.php");
		
} //end function


function drawNeighbourLocationBar($nextLocation, $backLocation)
{
	if ($backLocation != '' OR $nextLocation != '')
	{
?>
<div class="navigation">
	<div class="prev"><?=$backLocation; ?></div>
	<div class="next"><?=$nextLocation;?></div>
</div>
<? 
	} 
}	// end function

?>