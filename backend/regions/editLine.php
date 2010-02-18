<?php
include_once("../common/dbConnection.php");

$lineLink = $_REQUEST['line'];
$sql = "SELECT * FROM raillines WHERE link = '$lineLink'";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
$thisName = stripslashes(MYSQL_RESULT($result,$i,"name"));

$pageTitle = 'Update '.$thisName.' Line Details';
include_once("../common/header.php");

if ($numberOfRows==0) {  
?>

Sorry. No records found !!

<?php
}
else if ($numberOfRows>0) 
{
	$i = 0;
	$thisLine_id = stripslashes(MYSQL_RESULT($result,$i,"line_id"));
	
	$thisLink = stripslashes(MYSQL_RESULT($result,$i,"link"));
	$thisStartlocation = stripslashes(MYSQL_RESULT($result,$i,"startlocation"));
	$thisEndlocation = stripslashes(MYSQL_RESULT($result,$i,"endlocation"));
	$thisOpened = stripslashes(MYSQL_RESULT($result,$i,"opened"));
	$thisClosed = stripslashes(MYSQL_RESULT($result,$i,"closed"));
	$thisKmstart = stripslashes(MYSQL_RESULT($result,$i,"kmstart"));
	$thisKmend = stripslashes(MYSQL_RESULT($result,$i,"kmend"));
	$thisDescription = stripslashes(MYSQL_RESULT($result,$i,"description"));
	$thisCredits = stripslashes(MYSQL_RESULT($result,$i,"credits"));
	$thisPhotos = stripslashes(MYSQL_RESULT($result,$i,"photos"));
	$thisTrackyears = stripslashes(MYSQL_RESULT($result,$i,"trackyears"));
    $thisTrackdefault = stripslashes(MYSQL_RESULT($result,$i,"trackdefault"));
    $thisTracksubpage = stripslashes(MYSQL_RESULT($result,$i,"tracksubpage"));
    $thisSafeworkingyears = stripslashes(MYSQL_RESULT($result,$i,"safeworkingyears"));
    $thisSafeworkingdefault = stripslashes(MYSQL_RESULT($result,$i,"safeworkingdefault"));
    $thisTodisplay = stripslashes(MYSQL_RESULT($result,$i,"todisplay"));
    $thisDiagramtabs = stripslashes(MYSQL_RESULT($result,$i,"trackdiagramtabs"));
    $thisImageCaption = stripslashes(MYSQL_RESULT($result,$i,"imagecaption"));
    $thisSafeworkingDiagramNote = stripslashes(MYSQL_RESULT($result,$i,"safeworkingdiagramnote"));
    $thisTrackDiagramNote = stripslashes(MYSQL_RESULT($result,$i,"trackdiagramnote"));
    
    if ($_REQUEST['updated'])
	{
		echo "<p class=\"updated\">Updated!<p>";
	}
?>
<a href="listLines.php">&laquo; Back to lines</a><hr>
<fieldset><legend>Line</legend>
<form name="raillinesUpdateForm" method="POST" action="updateRaillines.php">
<input type="hidden" name="thisLine_idField" value="<? echo $thisLine_id; ?>">
<table cellspacing="5" cellpadding="2" border="0" width="100%">
	<tr valign="top" height="20">
		<td align="right"> <b> Line ID :  </b> </td>
		<td><? echo $thisLine_id; ?></td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Name :  </b> </td>
		<td> <input type="text" name="thisNameField" size="30" value="<? echo $thisName; ?>">  </td> 
	</tr>	
	<tr valign="top" height="20">
		<td align="right"> <b> Link :  </b> </td>
		<td> <input type="text" name="thisLinkField" size="30" value="<? echo $thisLink; ?>">  </td> 
	</tr>	
	<tr valign="top" height="20">
		<td align="right"> <b> Opened :  </b> </td>
		<td> <input type="text" name="thisOpenedField" size="30" value="<? echo $thisOpened; ?>">  </td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> <abbr title="'9999-01-01' for still open">Closed</abbr> :  </b> </td>
		<td> <input type="text" name="thisClosedField" size="30" value="<? echo $thisClosed; ?>">  </td> 
	</tr>
	

<tr valign="top" height="20"><td align="left" colspan=2><hr>Front page</td></tr>		
		
	<tr valign="top" height="20">
		<td align="right"> <b> Lead image caption :    </b> </td>
		<td> <input type="text" name="thisImageCaptionField" size="100" value="<? echo $thisImageCaption; ?>"><br>
		<small>For image at top of lineguide page, File needs to be at "/images/header-<? echo $thisLink; ?>.jpg"</small> 
		</td> 
	</tr>
	
	<tr valign="top" height="20">
		<td align="right"> <b> Description :  </b> </td>
		<td> <form>
		<script type="text/javascript" src="js_quicktags.js"></script>
		<script type="text/javascript">edToolbar();</script>
		<textarea name="thisDescriptionField" id="thisDescriptionField" wrap="VIRTUAL" cols="100" rows="30"><? echo $thisDescription; ?></textarea>
		<script type="text/javascript">var edCanvas = document.getElementById('thisDescriptionField');</script>
		</form></td> 
	</tr>
</table>

<input type="submit" name="submitUpdateRaillinesForm" value="Update Rail Line">
</form></fieldset><br><br>



<?php
}	//end else if
include_once("../common/footer.php");
?>