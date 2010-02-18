<?php

    // Retreiving Form Elements from Form
    $thisLine_id = addslashes($_REQUEST['thisLine_idField']);
    $thisName = addslashes($_REQUEST['thisNameField']);
    $thisLink = addslashes($_REQUEST['thisLinkField']);
    $thisPhotos = addslashes($_REQUEST['thisPhotosField']);
    $thisOpened = addslashes($_REQUEST['thisOpenedField']);
    $thisClosed = addslashes($_REQUEST['thisClosedField']);
    
    $pageTitle = "Updated line - $thisName";
	include_once("../common/dbConnection.php");
//	include_once("../common/header.php");
//	include_once("../../common/functions.php");
    
    /*
    
    //$thisStartlocation = addslashes($_REQUEST['thisStartlocationField']);
    // $thisEndlocation = addslashes($_REQUEST['thisEndlocationField']);
    
    if($thisStartlocation != 'null' AND $thisStartlocation != '')
    {
    	$thisKmstart = MYSQL_RESULT(MYSQL_QUERY("SELECT * FROM locations l, locations_raillines lr 
    		WHERE lr.location_id = l.location_id AND l.location_id = '".$thisStartlocation."'"),'0',"km");
    	$thisstartName = MYSQL_RESULT(MYSQL_QUERY("SELECT * FROM locations WHERE location_id = '".$thisStartlocation."'"),'0',"name");
	}
	if($thisEndlocation != 'null' AND $thisEndlocation != '')
    {
		$thisKmend = MYSQL_RESULT(MYSQL_QUERY("SELECT * FROM locations l, locations_raillines lr 
    		WHERE lr.location_id = l.location_id AND l.location_id = '".$thisEndlocation."'"),'0',"km");
		$thisendName = MYSQL_RESULT(MYSQL_QUERY("SELECT * FROM locations WHERE location_id = '".$thisEndlocation."'"),'0',"name");
	}
	*/
	
    $thisDescription = addslashes($_REQUEST['thisDescriptionField']);
    $thisCredits = addslashes($_REQUEST['thisCreditsField']);
    $thisTrackyears = addslashes($_REQUEST['thisTrackyearsField']);
    $thisTrackdefault = addslashes($_REQUEST['thisTrackdefaultField']);
    $thisTracksubpage = addslashes($_REQUEST['thisTracksubpageField']);
    $thisSafeworkingyears = addslashes($_REQUEST['thisSafeworkingyearsField']);
    $thisSafeworkingdefault = addslashes($_REQUEST['thisSafeworkingdefaultField']);
    $thisImageCaption = addslashes($_REQUEST['thisImageCaptionField']);
	$thisTrackDiagramNote = addslashes($_REQUEST['thisTrackDiagramNoteField']);
	$thisSafeworkingDiagramNote = addslashes($_REQUEST['thisSafeworkingDiagramNoteField']);
	$thisDiagramTabs = addslashes($_REQUEST['thisDiagramTabsField']);
	
	// for tab display
	$thisTodisplay = 10000;
	
	$showtrack = addslashes($_REQUEST['showTrack']);
	$showsafeworking = addslashes($_REQUEST['showSafeworking']);
	$showevents = addslashes($_REQUEST['showEvents']);
	$showlocations = addslashes($_REQUEST['showLocations']);
	$hideall = addslashes($_REQUEST['hideAll']);
	
	if ($showtrack)
	{
		$thisTodisplay += 1;
	}
	if ($showsafeworking)
	{
		$thisTodisplay += 10;
	}
	if ($showevents)
	{
		$thisTodisplay += 100;
	}
	if ($showlocations)
	{
		$thisTodisplay += 1000;
	}
	if ($hideall)
	{
		$thisTodisplay = 'hide';
	}

$sql = "UPDATE raillines SET name = '$thisName' , link = '$thisLink' , 
	startlocation = '$thisStartlocation' , endlocation = '$thisEndlocation' , 
	opened = '$thisOpened' , closed = '$thisClosed' , kmstart = '$thisKmstart' , 
	kmend = '$thisKmend' , description = '$thisDescription' , credits = '$thisCredits' , 
	trackyears = '$thisTrackyears' , trackdefault = '$thisTrackdefault' , tracksubpage = '$thisTracksubpage' , 
	safeworkingyears = '$thisSafeworkingyears' , safeworkingdefault = '$thisSafeworkingdefault' , 
	todisplay = '$thisTodisplay' , imagecaption = '$thisImageCaption' , 
	safeworkingdiagramnote = '$thisSafeworkingDiagramNote', trackdiagramnote = '$thisTrackDiagramNote', 
	trackdiagramtabs = '$thisDiagramTabs', photos = '$thisPhotos'  WHERE line_id = '$thisLine_id' ";
	
	$result = MYSQL_QUERY($sql);
	
	header("Location: editLine.php?line=".$thisLink."&updated=true",TRUE,302);
	
	$done .= '<p>Location data updated!</p>';
	
	/*
	 * --------------------------------------------------
	 * for the galley database table
	 * --------------------------------------------------
	 */
	if ($thisPhotos != '')
	{
		galleryDBConnect();
		
		if (sizeof(split(';', $thisPhotos)) == 1)
		{
			$gallerysql = "UPDATE `zen_albums` 
				SET `line_link` = '$thisLink' , `line_name` = '$thisName' 
				WHERE `folder` = '$thisPhotos'";
			$galleryresult = MYSQL_QUERY($gallerysql);///echo $gallerysql;
			$done .= '<p>Gallery location links updated!</p>';
		}
		backendDBConnect();
	}

if ($result != 0)
{
	failed();
}

echo $done;
 ?>
<table>
<tr height="30">
    <td align="right"><b>Line ID : </b></td>
    <td><? echo $thisLine_id; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Name : </b></td>
    <td><? echo $thisName; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Link : </b></td>
    <td><? echo $thisLink; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Opened : </b></td>
    <td><? echo $thisOpened; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Closed : </b></td>
    <td><? echo $thisClosed; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Track Years : </b></td>
    <td><? echo $thisTrackyears; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Track Year Default : </b></td>
    <td><? echo $thisTrackdefault; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Safeworking Years : </b></td>
    <td><? echo $thisSafeworkingyears; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Safeworking Year Default : </b></td>
    <td><? echo $thisSafeworkingdefault; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>To Display? </b></td>
    <td><? echo $thisTodisplay; ?></td>
</tr>
<tr height="30">
    <td valign="top" align="right"><b>Description : </b></td>
    <td bgcolor="white"><? echo getDescription(stripslashes(stripslashes($thisDescription))); ?></td>
</tr>
<tr height="30">
    <td valign="top" align="right"><b>Credits : </b></td>
    <td bgcolor="white"><? echo stripslashes(stripslashes($thisCredits)); ?></td>
</tr>
</table>
<a href="editLine.php?line=<? echo $thisLink; ?>">Go Back!</a>

<?php
include_once("../common/footer.php");
?>