<?php

$locationToFind = $_REQUEST['location'];
include_once("../common/dbConnection.php");

if (is_numeric($locationToFind))
{
	$search = "l.location_id = '$locationToFind'";
}
else
{
	$search = "l.name = '$locationToFind'";
}

$sql = "SELECT   * FROM locations l, locations_raillines lr 
	WHERE l.location_id = lr.location_id AND $search";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
$pageTitle = 'Edit Location';

if ($numberOfRows > 1 and !is_numeric($locationToFind)) 
{  
	include_once("../common/header.php");
	echo '<p class="error">Multiple records found!</p>';
}
else if ($numberOfRows == 0) 
{
	include_once("../common/header.php");
	echo '<p class="error">No records found!</p>';
}
else
{

	//general crap
	$i=0;
	$thisLocationId = stripslashes(MYSQL_RESULT($result,$i,"l.location_id"));
	$thisName = stripslashes(MYSQL_RESULT($result,$i,"name"));
	$thisSuburb = stripslashes(MYSQL_RESULT($result,$i,"suburb"));
	$thisTracks = stripslashes(MYSQL_RESULT($result,$i,"tracks"));
	$thisType = stripslashes(MYSQL_RESULT($result,$i,"type"));
	$thisImage = stripslashes(MYSQL_RESULT($result,$i,"image"));
	$thisUrl = stripslashes(MYSQL_RESULT($result,$i,"url"));
	$thisDiagrams = stripslashes(MYSQL_RESULT($result,$i,"diagrams"));
	//$thisStatus = stripslashes(MYSQL_RESULT($result,$i,"status"));
	$thisDisplay = stripslashes(MYSQL_RESULT($result,$i,"display"));
	$thisDescription = stripslashes(MYSQL_RESULT($result,$i,"description"));
	$thisCredits = stripslashes(MYSQL_RESULT($result,$i,"credits"));
	$thisOpen = stripslashes(MYSQL_RESULT($result,$i,"open"));
	$thisOpenAccuracy = stripslashes(MYSQL_RESULT($result,$i,"openAccuracy"));
	$thisClose = stripslashes(MYSQL_RESULT($result,$i,"close"));
	$thisCloseAccuracy = stripslashes(MYSQL_RESULT($result,$i,"closeAccuracy"));
	$thisCoOrds = stripslashes(MYSQL_RESULT($result,$i,"long"));
	//$thisKmAccuracy = stripslashes(MYSQL_RESULT($result,$i,"kmAccuracy"));
	$thisPhotos = stripslashes(MYSQL_RESULT($result,$i,"photos"));
	
	$thisLine = stripslashes(MYSQL_RESULT($result,$i,"line_id"));
	$thisKm = stripslashes(MYSQL_RESULT($result,$i,"km"));
	
	// next and forward linkzor
	$sqlBack = "SELECT * FROM locations l, locations_raillines lr 
	WHERE l.location_id = lr.location_id AND `km` < '".$thisKm."' AND line_id = '".$thisLine."' ORDER BY km DESC";
	$resultBack = MYSQL_QUERY($sqlBack);
	$sqlNext = "SELECT * FROM locations l, locations_raillines lr 
	WHERE l.location_id = lr.location_id AND `km` > '".$thisKm."' AND line_id = '".$thisLine."' ORDER BY km ASC";
	$resultNext = MYSQL_QUERY($sqlNext);
	
	if (MYSQL_NUM_ROWS($resultBack) > '0')	
	{
		$Name = stripslashes(MYSQL_RESULT($resultBack,0,"name"));
		$id = stripslashes(MYSQL_RESULT($resultBack,0,"l.location_id"));
		$back = '<a href="./editLocations.php?location='.$id.'">&laquo; '.$Name.'</a>'; 
	}	
	if (MYSQL_NUM_ROWS($resultNext) > '0')	
	{
		$Name = stripslashes(MYSQL_RESULT($resultNext,0,"name"));
		$id = stripslashes(MYSQL_RESULT($resultNext,0,"l.location_id"));
		$next = '<a href="./editLocations.php?location='.$id.'">'.$Name.' &raquo;</a>'; 
	}
	
	$pageTitle = "Update Location - $thisName";
	include_once("../common/header.php");
	
	if ($_REQUEST['updated'])
	{
		echo "<p class=\"updated\">Updated!<p>";
	}
?>
<a href="listStations.php?line=<?=$thisLine?>">&laquo; Back to line</a><hr>
<form name="locationsUpdateForm" method="POST" action="updateLocations.php">
<input type="hidden" name="thisLineField" value="<? echo $thisLine; ?>">
<input type="hidden" name="thisKmField" value="<? echo $thisKm; ?>">
<fieldset id="general"><legend>General</legend>
<table cellspacing="5" cellpadding="2" border="0" width="100%">
	<tr valign="top" height="20">
		<td align="right"> <b> Location ID :  </b> </td>
		<td><? echo $thisLocationId; ?></td> 
		<input type="hidden" name="thisLocation_idField" value="<? echo $thisLocationId; ?>">
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Name :  </b> </td>
		<td> <input type="text" name="thisNameField" size="30" value="<? echo $thisName; ?>">  </td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Description :  </b> </td>
		<td> 
			<form>
			<script type="text/javascript" src="js_quicktags.js"></script>
			<script type="text/javascript">edToolbar();</script>
			<textarea name="thisDescriptionField" id="thisDescriptionField" wrap="VIRTUAL" cols="100" rows="30"><? echo $thisDescription; ?></textarea>
			<script type="text/javascript">var edCanvas = document.getElementById('thisDescriptionField');</script>
			</form>
		</td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Credits :  </b> </td>
		<td> <textarea name="thisCreditsField" wrap="VIRTUAL" cols="80" rows="8"><? echo $thisCredits; ?></textarea></td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"><b>Show updated :  </b></td>
		<td><label><input type="checkbox" checked="yes" name="flag" /> <small>(check to show on main page as recently updated)</small></label></td> 
	</tr>
</table>

<input type="submit" name="submitUpdateLocationsForm" value="Update Locations" />
</form>
</fieldset><br>

<br><fieldset id="lines"><legend>Railway Lines</legend>
<table cellspacing="1" cellpadding="5" border="0">
<? /* 
		start looping though all railway lines for this location
		grab all railway lines for this location
	*/
	$sqllines = "SELECT * FROM locations_raillines lr, raillines r 
		WHERE lr.line_id = r.line_id AND location_id = '".$thisLocationId."'";
	$resultlines = MYSQL_QUERY($sqllines);
	$numlines = MYSQL_NUM_ROWS($resultlines);
	
	if ($numlines > 0)
	{
		/* 
			and output them
		*/
		for ($i = 0; $i < $numlines; $i++)
		{
			$thisLocalReadOnlyLine = stripslashes(MYSQL_RESULT($resultlines,$i,"lr.line_id"));
			$thisLocalReadOnlyLineName = stripslashes(MYSQL_RESULT($resultlines,$i,"name"));
			$thisLocalReadOnlyKm = stripslashes(MYSQL_RESULT($resultlines,$i,"km"));
			$thisLocalReadOnlyKmAccuracy = stripslashes(MYSQL_RESULT($resultlines,$i,"kmAccuracy"));
			
?>			<tr><td>
				<fieldset><table cellspacing="2" cellpadding="2">
					<tr valign="top" height="20">
						<td align="right"> <b> Line :  </b> </td>
						<td width="220"><?=$thisLocalReadOnlyLineName?></td>
						<td align="left" rowspan="3">
							<a href="editLocations_raillines.php?line=<?=$thisLocalReadOnlyLine?>&location=<?=$thisLocationId?>">Edit!</a><br>
							<a href="confirmDeleteLocations_raillines.php?line=<?=$thisLocalReadOnlyLine?>&location=<?=$thisLocationId?>">Delete!</a>
						</td>
					</tr>
				    <tr valign="top" height="20">
						<td align="right"> <b> Km :  </b> </td>
						<td><? echo $thisLocalReadOnlyKm; ?></td> 
					</tr>
					<tr valign="top" height="20">
						<td align="right"> <b> KM Accuracy :  </b> </td>
						<td><?=$thisLocalReadOnlyKmAccuracy?></td>
					</tr>
				</fieldset></table>
			</td></tr>
<?			}
		}			
		?>
			<tr><td>
				<fieldset>
				<form name="locations_raillinesEnterForm" method="POST" action="insertNewLocations_raillines.php">
				<input type="hidden" name="thisLocation_idField" value="<? echo $thisLocationId; ?>">
	
				<table cellspacing="2" cellpadding="2" border="0">
					<tr valign="top" height="20">
					<td align="right"> <b> Line :  </b> </td>
					<td width="220"> <select name="thisLine_idField" id="thisLine_idField">
<? drawLineNameSelectFields($thisLine_id); ?>	
				    </select></td>
				    <td align="right" rowspan="2">
						<input type="submit" name="submitEnterLocations_raillinesForm" value="Enter Line">
					</td></tr>
					<tr valign="top" height="20">
						<td align="right"> <b> Km :  </b> </td>
						<td> <input type="text" name="thisKmField" size="8" value="<? echo $thisKm; ?>">
						<select name="thisKmAccuracyField">
<? drawApproxDistanceFields() ?>	
						</select></td>
					</tr>
				</table>
				
				</form></fieldset>
			</td></tr>
		</table>
</fieldset>
</br>

<?php
}	// end zero result if
include_once("../common/footer.php");
?>