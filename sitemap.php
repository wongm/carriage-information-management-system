<?php include_once("common/dbConnection.php");
include_once("common/formatting-functions.php");

$pageTitle = array(array("Sitemap", ''));
include_once("common/header.php");?>
<div id="sitemap">
<p>A guide to all the pages on this site.</p>
<ul>
<li><a href="/index.php">Home</a></li>
<?	
// basic stuff to start off
echo getConfigVariable('sitemap-top');

// get all lines and their subsections
$sql = "SELECT * FROM raillines WHERE todisplay != 'hide'";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);	?>
<li><a href="/lineguide">Lineguide Overview</a>
<ul>
<?	

if ($numberOfRows>0) 
{
	for ($j = 0; $j < $numberOfRows; $j++)
	{
		$line["lineId"] = stripslashes(MYSQL_RESULT($result,$j,"line_id"));
		$line["lineName"] = stripslashes(MYSQL_RESULT($result,$j,"name"));
		$line["lineLink"] = stripslashes(MYSQL_RESULT($result,$j,"link"));
		$line["numLocations"] = MYSQL_NUM_ROWS(MYSQL_QUERY("SELECT * FROM locations_raillines WHERE line_id = '".$line["lineId"]."'"));
		$line["todisplay"] = MYSQL_RESULT($result,$j,"todisplay");
		$todisplay = $line["todisplay"];
		$line["showTrack"] = substr($todisplay, 4, 1) == 1;
		$line["showSafeworking"] = substr($todisplay, 3, 1) == 1;
		$line["showEvents"] = substr($todisplay, 2, 1) == 1;
		$line["showLocations"] = substr($todisplay, 1, 1) == 1;
		$line["showGoogleMap"] = file_exists('./images/kml-'.$lineToDisplay.'.kml') == 1;
		$itemstodisplay = getLineguidePages($line);	
?>
<li><a href="lineguide/<? echo $line["lineLink"]; ?>" ><? echo $line["lineName"]; ?> Line</a>
<ul>
<?
		for ($i = 0; $i < sizeof($itemstodisplay); $i++)
		{	
?>
<li><a href="lineguide/<? echo $line["lineLink"]; ?>/<? echo $itemstodisplay[$i][0]; ?>" ><? echo $itemstodisplay[$i][1]; ?></a></li>
<?		
		}
?>
</ul></li>
<? 	
	}
}?>
</ul></li>
<?	

// middle bit from DB
echo getConfigVariable('sitemap-middle');

// get all articles
$articles = MYSQL_QUERY("SELECT * FROM articles WHERE link != '' AND `line_id` = '0'");
$numberOfRows = MYSQL_NUMROWS($articles);
if ($numberOfRows>0) 
{?>
<li><a href="articles.php">Articles Listing</a>
<ul>
<?	
	for ($i = 0; $i < MYSQL_NUM_ROWS($articles); $i++)
	{
		echo '<li><a href="articles/'.stripslashes(MYSQL_RESULT($articles,$i,"link")).'">'.stripslashes(MYSQL_RESULT($articles,$i,"title")).'</a></li>';
	}?>
</ul></li>
<?	
}

// last bit from DB
echo getConfigVariable('sitemap-bottom');
echo '</ul></div>';
include_once("common/footer.php");
?>
