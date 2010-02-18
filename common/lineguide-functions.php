<?


function getLocationsTable($lineId, $lineName, $typeSql, $typeName, $sort)
{
	// depends on what class of diagram we want - line
	if ($lineId != '')
	{
		$sqlSpecific = " (lr.line_id=$lineId) AND ";
		$pageUrl = "/lineguide/$lineName/locations";
		$headerCell = '<th><a href="'.$pageUrl.'/by-type">Type</a></th>';
		$headerWidth = '';
		$headerTitle = 'Type';
		$headerUrl = 'by-type';
		$sqlorder = ' ORDER BY lr.km ASC';
		$sortorder = 'distance from Melbourne. Click table headers to reorder';
	}
	
	$sql = "SELECT * FROM locations l, locations_raillines lr, raillines r 
		WHERE r.line_id=lr.line_id AND lr.location_id = l.location_id 
		AND ".$sqlSpecific." l.name != '' AND display != 'tracks' AND r.todisplay != 'hide' ".$sqlorder;
	$result = MYSQL_QUERY($sql);
	$numberOfRows = MYSQL_NUM_ROWS($result);
	$i = 0;	
	$j = 0;
	
	if ($numberOfRows > 0)
	{		
		// the header sort text
		$toreturn['sorttext'] = $sortText;
		// base page URL for sort links
		$toreturn['pageurl'] = $pageUrl;
		// the header cell titles
		$toreturn['headertitle'] = array($headerTitle, 'Photos', 'Events', 'History', 'Distance', 'Name');
		// the header cell width
		$toreturn['headerstyle'] = array(' width="'.$headerWidth.'"', ' width="50"', ' width="50"', ' width="50"', ' width="100"', '');
		// the header cell URLs
		$toreturn['headerurl'] = array($headerUrl, 'by-photos', 'by-events', 'by-history', 'by-km', 'by-name');
	}
	
	while ($i < $numberOfRows)
	{
		$id = stripslashes(MYSQL_RESULT($result,$i,"l.location_id"));
		if ($id == $pastid)
		{
			$i++;
			if ($i == $numberOfLocations)
			{
				break;
			}
			$id = stripslashes(MYSQL_RESULT($result,$i,"l.location_id"));
		}
		
		$locationName = stripslashes(MYSQL_RESULT($result,$i,"l.name"));
		$lineName = stripslashes(MYSQL_RESULT($result,$i,"r.name"));
		$lineLink = stripslashes(MYSQL_RESULT($result,$i,"r.link"));
		$thisKm = stripslashes(MYSQL_RESULT($result,$i,"km"));
		$staffing = stripslashes(MYSQL_RESULT($result,$i,"diagrams"));
		$locationUrl = STATION_PAGE.$locationName;
		$locationUrl = strtolower($locationUrl);
		$locationUrl = str_replace(' ', '-', $locationUrl);
		
		// only show ones with URL set
		if ($locationUrl != '')
		{
			if ($j%2 == '0')
			{
				$style = 'class="x"';
			}
			else
			{
				$style = 'class="y"';
			}
			
			$toreturn[] = array($thisKm, $locationName, $locationUrl);
			$j++;
			$pastid = $id;
			
		}	// end $thisUrl if
		$i++;
	}	/*	end while	*/ 

	return $toreturn;	
}	//end function


function drawPlainLocationsTable($locationData)
{
	$numberOfRows = sizeof($locationData);
	$numberOfColummns = sizeof($locationData['headertitle'])-1;
	$numberOfSettingEntries = 5;
	
	if ($numberOfRows > $numberOfSettingEntries)
	{
		echo $locationData['sorttext'];
?>
<table class="linedTable">
<tr>
	<th>Station</th>
	<th>Distance from Melbourne</th>
<?
		// fix number of rows by removing the initial ones containing settings
		$numberOfRows-=$numberOfSettingEntries;
	}
	
	// skips the header cells
	$i = 0;
	
	while ($i < $numberOfRows)
	{
		if ($i%2 == '0')
		{
			$style = 'class="x"';
		}
		else
		{
			$style = 'class="y"';
		}
?>
<tr <? echo $style; ?>>
	<td><a href="<?=$locationData[$i][2]?>"><?=$locationData[$i][1]?></a></td>
	<td><?=$locationData[$i][0]?></td>
</tr>
<?
		$i++;
	}	/*	end while	*/ 
?>
</table>
<?

	return;	//end function
}	

function getLine($lineToDisplay, $yearToDisplay)
{
	//	fix up names and line IDs
	$lineResult = MYSQL_QUERY("SELECT * FROM raillines WHERE link = '".$lineToDisplay."' AND todisplay != 'hide'");
	
	if (MYSQL_NUM_ROWS($lineResult) == '1')
	{
		// get locations details
		$line["lineId"] = MYSQL_RESULT($lineResult,'0',"line_id");
		$line["lineName"] = MYSQL_RESULT($lineResult,'0',"name");
		$line["lineLink"] = MYSQL_RESULT($lineResult,'0',"link");
		$line["trackDiagramNote"] = stripslashes(MYSQL_RESULT($lineResult,'0',"trackdiagramnote"));
		$line["safeworkingDiagramNote"] = stripslashes(MYSQL_RESULT($lineResult,'0',"safeworkingdiagramnote"));
		$line["credits"] = stripslashes(MYSQL_RESULT($lineResult,'0',"credits"));
		$line["description"] = stripslashes(MYSQL_RESULT($lineResult,'0',"description"));
		$line["caption"] = stripslashes(MYSQL_RESULT($lineResult,'0',"imagecaption"));
		$line["photos"] = stripslashes(MYSQL_RESULT($lineResult,'0',"photos"));
		$line["numLocations"] = MYSQL_NUM_ROWS(MYSQL_QUERY("SELECT * FROM locations_raillines WHERE line_id = '".$line["lineId"]."'"));
		
		// fix up dates for opening and closing, as well as for filtering
		if(!is_numeric($yearToDisplay) OR $yearToDisplay == "")
		{
			$yearToDisplay = date(Y);
		}
		//	fix up dates for opening and closing, as well as for filtering
		$line['openYear'] = MYSQL_RESULT($lineResult,'0',"opened");
		$line['closeYear'] = MYSQL_RESULT($lineResult,'0',"closed");
	}
	else
	{
		$line["lineId"] = "";
		$line["lineName"] = "";
		$line["diagramNote"] = "";
	}
	
	return $line;
}	// end function
?>