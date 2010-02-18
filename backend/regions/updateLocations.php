<?php
	include_once("../common/dbConnection.php");
	//include_once("../common/header.php");

	// Retreiving Form Elements from Form
	$thisLocation_id = addslashes($_REQUEST['thisLocation_idField']);
	$thisName = addslashes($_REQUEST['thisNameField']);
	$thisSuburb = addslashes($_REQUEST['thisSuburbField']);
	$thisLine = addslashes($_REQUEST['thisLineField']);
	$thisTracks = addslashes($_REQUEST['thisTracksField']);
	$thisType = addslashes($_REQUEST['thisTypeField']);
	$thisImage = addslashes($_REQUEST['thisImageField']);
	$thisUrl = addslashes($_REQUEST['thisUrlField']);
	$thisDisplay = addslashes($_REQUEST['thisDisplayField']);
	//$thisStatus = addslashes($_REQUEST['thisStatusField']);
	$thisDescription = addslashes($_REQUEST['thisDescriptionField']);
	$thisCredits = addslashes($_REQUEST['thisCreditsField']);
	$thisOpen = addslashes($_REQUEST['thisOpenField']);
	$thisOpenAccuracy = addslashes($_REQUEST['thisOpenAccuracyField']);
	$thisClose = addslashes($_REQUEST['thisCloseField']);
	$thisCloseAccuracy = addslashes($_REQUEST['thisCloseAccuracyField']);
	$thisLong = addslashes($_REQUEST['thisCoordsField']);
	$thisDiagrams = addslashes($_REQUEST['thisDiagramsField']);
	$thisKm = addslashes($_REQUEST['thisKmField']);
	$thisKmAccuracy = addslashes($_REQUEST['thisKmAccuracyField']);
	$thisYear = addslashes($_REQUEST['thisYearField']);
	$thisPhotos = addslashes($_REQUEST['thisPhotosField']);
	
	//create the SQL string
	$sql = "UPDATE locations SET `name` = '$thisName' , `tracks` = '$thisTracks' , `display` = '$thisDisplay' , `type` = '$thisType' ";
	
	// for auto modification of last modified 
	
	if ($_REQUEST['flag'] == 'on')
	{
		$thisModified = date('Y-m-d H:i:s');
		$sql = $sql." , modified = '$thisModified'";
		$done .= '<p>Last updated locations updated!</p>';
	}
	
	$sql = $sql." , `url` = '$thisUrl'";
	$sql = $sql." , `image` = '$thisImage'";
	$sql = $sql." , `description` = '$thisDescription'";
	$sql = $sql." , `credits` = '$thisCredits'";
	if ($thisLong != ""){$sql = $sql." , `long` = '$thisLong'";}
	$sql = $sql." , `diagrams` = '$thisDiagrams'";
	if ($thisOpen != ""){$sql = $sql." , `open` = '$thisOpen', `openAccuracy` = '$thisOpenAccuracy'";}
	if ($thisClose != ""){$sql = $sql." , `close` = '$thisClose', `closeAccuracy` = '$thisCloseAccuracy'";}
	$sql = $sql." , `photos` = '$thisPhotos'";
	$sql = $sql." WHERE location_id = '$thisLocation_id'";
	
	/*
	 * --------------------------------------------------
	 * add it to table
	 * --------------------------------------------------
	 */
	$result = MYSQL_QUERY($sql);
	$done .= '<p>Location data updated!</p>';
	
	header("Location: editLocations.php?location=".$thisLocation_id."&updated=true",TRUE,302);
	
	/*
	 * --------------------------------------------------
	 * next and forward linkzor - to display, not update
	 * --------------------------------------------------
	 */ 
	$sqlBack = "SELECT * FROM locations l, locations_raillines lr WHERE lr.location_id = l.location_id AND km < '".$thisKm."' AND lr.line_id = '".$thisLine."' ORDER BY km DESC";
	$resultBack = MYSQL_QUERY($sqlBack);
	$sqlNext = "SELECT * FROM locations l, locations_raillines lr WHERE lr.location_id = l.location_id AND km > '".$thisKm."' AND lr.line_id = '".$thisLine."' ORDER BY km ASC";
	$resultNext = MYSQL_QUERY($sqlNext);
	
	if (MYSQL_NUM_ROWS($resultBack) > 0)	
	{
		$Name = stripslashes(MYSQL_RESULT($resultBack,0,"name"));
		$id = stripslashes(MYSQL_RESULT($resultBack,0,"location_id"));
		$back = '<a href="./editLocations.php?location='.$id.'">&laquo; '.$Name.'</a>'; 
	}	
	if (MYSQL_NUM_ROWS($resultNext) > 0)	
	{
		$Name = stripslashes(MYSQL_RESULT($resultNext,0,"name"));
		$id = stripslashes(MYSQL_RESULT($resultNext,0,"location_id"));
		$next = '<a href="./editLocations.php?location='.$id.'">'.$Name.' &raquo;</a>'; 
	}
?>
<h3>Updated Location - <? echo $thisName; ?></h3>
<hr/>
<?=$done; ?>

<table>
<tr height="30">
	<td align="right"><b>Location_id : </b></td>
	<td><? echo $thisLocation_id; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Name : </b></td>
	<td><? echo $thisName; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Suburb : </b></td>
	<td><? echo $thisSuburb; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Line : </b></td>
	<td><? echo $thisLine; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Tracks : </b></td>
	<td><? echo $thisTracks; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Type : </b></td>
	<td><? echo $thisType; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Image : </b></td>
	<td><? echo $thisImage; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Url : </b></td>
	<td><? echo $thisUrl; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Extra Diagrams? : </b></td>
	<td><? echo $thisDiagrams; ?></td>
</tr>
<!--
<tr height="30">
	<td align="right"><b>Status : </b></td>
	<td><? echo $thisStatus; ?></td>
</tr>
-->
<tr height="30">
	<td align="right"><b>Display : </b></td>
	<td><? echo $thisDisplay; ?></td>
</tr>
<tr height="30">
    <td valign="top" align="right"><b>Description : </b></td>
    <td bgcolor="white"><? echo (stripslashes(stripslashes($thisDescription))); ?></td>
</tr>
<tr height="30">
    <td valign="top" align="right"><b>Credits : </b></td>
    <td bgcolor="white"><? echo stripslashes(stripslashes($thisCredits)); ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Open : </b></td>
	<td><? echo $thisOpen; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>OpenAccuracy : </b></td>
	<td><? echo $thisOpenAccuracy; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Close : </b></td>
	<td><? echo $thisClose; ?></td>
<tr height="30">
	<td align="right"><b>Close Accuracy : </b></td>
	<td><? echo $thisCloseAccuracy; ?></td>
</tr>
</tr><tr height="30">
	<td align="right"><b>Co-ordinates : </b></td>
	<td><? echo $thisLong; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Km : </b></td>
	<td><? echo $thisKm; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Km Accuracy : </b></td>
	<td><? echo $thisKmAccuracy; ?></td>
</tr>
</table><hr>
<b>SQL : </b><br><br>
<?//echo the added changes
echo $sql.'<br/><br/>';	?>
<hr>
<a href="editLocations.php?location=<? echo $thisLocation_id; ?>">Go Back!</a>

<?php
include_once("../common/footer.php");
?>