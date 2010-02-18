<?php 

include_once("../common/dbConnection.php");

$lineLink = $_REQUEST['line'];

if (is_numeric($lineLink))
{
	$where = "r.line_id = '$lineLink'";
}
else
{
	$where = "r.link = '".$lineLink."'";
}

$sql = "SELECT * FROM locations l, locations_raillines lr, raillines r 
		WHERE lr.location_id = l.location_id AND lr.line_id = r.line_id 
		AND $where	
		ORDER BY km ASC";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUM_ROWS($result);


if ($numberOfRows==0) 
{
	$pageTitle = 'List Line Locations';
	include_once("../common/header.php");
	echo '<p class="error">No records found!</p>';  
}
else if ($numberOfRows>0) 
{	
	$thisLineId = stripslashes(MYSQL_RESULT($result,'0',"r.line_id"));
	$thisLineName = stripslashes(MYSQL_RESULT($result,'0',"r.name"));
	
	$pageTitle = 'Update '.$thisLineName.' Line Locations';
	include_once("../common/header.php");
	
	if ($_REQUEST['inserted'])
	{
		echo "<p class=\"updated\">Inserted!<p>";
	}
	?>
<a href="listLines.php">&laquo; Back to lines</a><hr>
<a href="enterNewLocation.php?line=<? echo $thisLineId; ?>">Add locations</a><hr>
<table CELLPADDING="5" >
<TR BGCOLOR="<? echo $bgColor; ?>">
		<th>Name</th>
		<th>KM</th>
</TR>
<?	for ($i = 0; $i < $numberOfRows; $i++)
	{	
		if ($i%2 == '0')
		{
			$style = 'bgcolor="white"';
		}
		else
		{
			$style = 'bgcolor="#F5F7F5"';
		}
		
		$thisLocation_id = stripslashes(MYSQL_RESULT($result,$i,"location_id"));
		$thisName = stripslashes(MYSQL_RESULT($result,$i,"name"));
		$thisImg = stripslashes(MYSQL_RESULT($result,$i,"image"));
		$thisUrl = stripslashes(MYSQL_RESULT($result,$i,"url"));
		$thisDisplay = stripslashes(MYSQL_RESULT($result,$i,"display"));
		$thisDescription = stripslashes(MYSQL_RESULT($result,$i,"description"));
		$thisCredits = stripslashes(MYSQL_RESULT($result,$i,"credits"));
		$thisOpen = stripslashes(MYSQL_RESULT($result,$i,"open"));
		$thisOpenAccuracy = stripslashes(MYSQL_RESULT($result,$i,"openAccuracy"));
		$thisClose = stripslashes(MYSQL_RESULT($result,$i,"close"));
		$thisCloseAccuracy = stripslashes(MYSQL_RESULT($result,$i,"closeAccuracy"));
		$thisCoOrds = stripslashes(MYSQL_RESULT($result,$i,"long"));
		if ($thisCoOrds != '' AND $thisCoOrds != 0)
		{
			$thisCoOrds = '<abbr title="'.$thisCoOrds.'">Coords</abbr>';
		}
		else
		{
			$thisCoOrds = '';
		}
		$thisKm = stripslashes(MYSQL_RESULT($result,$i,"km"));
		$thisPhotos = stripslashes(MYSQL_RESULT($result,$i,"photos"));
		if ($thisPhotos != '0')
		{
			$thisPhotos = '<abbr title="'.$thisPhotos.'">Photos</abbr>';
		}
		else
		{
			$thisPhotos = '';
		}
		$thisEvents = stripslashes(MYSQL_RESULT($result,$i,"events"));
		if ($thisEvents == 1)
		{
			$thisEvents = 'Y';
		}
		else
		{
			$thisEvents = '';
		}
		$thisKmAccuracy = stripslashes(MYSQL_RESULT($result,$i,"kmAccuracy"));
		
		if($thisOpen == '0001-01-01')
		{
			$thisOpen = '';
		}
		
		if($thisClose == '9999-01-01')
		{
			$thisClose = '';
		}	
		?>
<TR <? echo $style; ?>>
		<TD><a href="editLocations.php?location=<? echo $thisLocation_id; ?>"><? echo $thisName.' ('.$thisLocation_id.')'; ?></a></TD>
		<TD><? echo $thisKm; ?></TD>
</TR>
<?
	} // end for loop
}
?>
</TABLE>

<? include_once("../common/footer.php"); ?>
