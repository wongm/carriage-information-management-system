<?php
include_once("../common/dbConnection.php");

	// Retreiving Form Elements from Form
	$thisName = addslashes($_REQUEST['thisNameField']);
	$thisLine = addslashes($_REQUEST['thisLineField']);
	$thisTracks = addslashes($_REQUEST['thisTracksField']);
	$thisType = addslashes($_REQUEST['thisTypeField']);
	$thisImage = addslashes($_REQUEST['thisImageField']);
	$thisUrl = addslashes($_REQUEST['thisUrlField']);
	$thisDisplay = addslashes($_REQUEST['thisDisplayField']);
	//$thisStatus = addslashes($_REQUEST['thisStatusField']);
	$thisPhotos = addslashes($_REQUEST['thisPhotosField']);
	$thisDescription = addslashes($_REQUEST['thisDescriptionField']);
	$thisCredits = addslashes($_REQUEST['thisCreditsField']);
	$thisOpen = addslashes($_REQUEST['thisOpenField']);
	$thisOpenAccuracy = addslashes($_REQUEST['thisOpenAccuracyField']);
	$thisClose = addslashes($_REQUEST['thisCloseField']);
	$thisCloseAccuracy = addslashes($_REQUEST['thisCloseAccuracyField']);
	$thisLong = addslashes($_REQUEST['thisCoordsField']);
	$thisKm = addslashes($_REQUEST['thisKmField']);
	$thisDiagram = addslashes($_REQUEST['thisDiagramsField']);
	$thisKmAccuracy = addslashes($_REQUEST['thisKmAccuracyField']);
	
	// for auto modification of last modiufied 
	$thisModified = date('Y-m-d H:i:s');
	
$sqlFirstHalf = "INSERT INTO locations (`name` , `type` , `display` , `status`, `diagrams`, `modified` ";
$sqlLastHalf = "'$thisName' , '$thisType' , '$thisDisplay' , 'open', '$thisDisgram' , '$thisModified'";

if($thisTracks != ''){
	$sqlFirstHalf = $sqlFirstHalf." , `tracks`";
	$sqlLastHalf = $sqlLastHalf." , '$thisTracks'";
}
if($thisImage != ''){
	$sqlFirstHalf = $sqlFirstHalf." , `image`";
	$sqlLastHalf = $sqlLastHalf." , '$thisImage'";
}
if($thisUrl != ''){
	$sqlFirstHalf = $sqlFirstHalf." , `url`";
	$sqlLastHalf = $sqlLastHalf." , '$thisUrl'";
}
if($thisDescription != ''){
	$sqlFirstHalf = $sqlFirstHalf." , `description`";
	$sqlLastHalf = $sqlLastHalf." , '$thisDescription'";
}
if($thisCredits != ''){
	$sqlFirstHalf = $sqlFirstHalf." , `credits`";
	$sqlLastHalf = $sqlLastHalf." , '$thisCredits'";
}
if($thisOpen != ''){
	$sqlFirstHalf = $sqlFirstHalf." , `open` , `openAccuracy`";
	$sqlLastHalf = $sqlLastHalf." , '$thisOpen' , '$thisOpenAccuracy'";
}
if($thisClose != ''){
	$sqlFirstHalf = $sqlFirstHalf." , `close` , `closeAccuracy`";
	$sqlLastHalf = $sqlLastHalf." , '$thisClose' , '$thisCloseAccuracy'";
}
if($thisLong != ''){
	$sqlFirstHalf = $sqlFirstHalf." , `long`";
	$sqlLastHalf = $sqlLastHalf." , '$thisLong'";
}
if($thisLat != ''){
	$sqlFirstHalf = $sqlFirstHalf." , `lat`";
	$sqlLastHalf = $sqlLastHalf." , '$thisLat'";
}
if($thisPhotos == '')
{
	$thisPhotos = '0';
}
if($thisPhotos != ''){
	$sqlFirstHalf = $sqlFirstHalf." , `photos`";
	$sqlLastHalf = $sqlLastHalf." , '$thisPhotos'";
}

if ($thisLine == '')
{
	insertfail();
}
else
{
	$sqlQuery = $sqlFirstHalf.") VALUES (".$sqlLastHalf.")";
	$result = MYSQL_QUERY($sqlQuery);
	
	// add line stuff link
	$sqlQuery = "SELECT location_id FROM locations ORDER BY location_id DESC";
	$thisLocation_id = MYSQL_RESULT(MYSQL_QUERY($sqlQuery), 0, 'location_id');
	
	$linestuff = "INSERT INTO locations_raillines 
		(`line_id`, `location_id`, `km`, `kmaccuracy`) 
		VALUES ('$thisLine', '$thisLocation_id', '$thisKm', '$thisKmAccuracy')";
	MYSQL_QUERY($linestuff);	
	
	if ($result != 0)
	{
		failed();
	}
	
	header("Location: listStations.php?line=".$thisLine."&inserted=true",TRUE,302);

?>
A new record has been inserted in the database. Here is the information that has been inserted :- <br><br>

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
	<td align="right"><b>Years : </b></td>
	<td><? echo $thisYears; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Description : </b></td>
	<td><? echo $thisDescription; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Credits : </b></td>
	<td><? echo $thisCredits; ?></td>
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
	<td align="right"><b>Coords : </b></td>
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
</table>

<a href="enterNewLocations.php">More?</a>

<?php
}	// end null values if
include_once("../common/footer.php");
?>