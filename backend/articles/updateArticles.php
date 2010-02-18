<?php
include_once("../common/dbConnection.php");
//include_once("../common/header.php");
?>
<?php
	// Retreiving Form Elements from Form
	$thisId = addslashes($_REQUEST['thisIdField']);
	$thisLink = addslashes($_REQUEST['thisLinkField']);
	$thisTitle = addslashes($_REQUEST['thisTitleField']);
	$thisDescription = addslashes($_REQUEST['thisDescriptionField']);
	$thisContent = addslashes($_REQUEST['thisContentField']);
	$thisPhotos = addslashes($_REQUEST['thisPhotosField']);
	$thisLine = addslashes($_REQUEST['thisLineField']);
	$thisCaption = addslashes($_REQUEST['thisCaptionField']);

?>
<?
$sql = "UPDATE articles SET id = '$thisId' , caption = '$thisCaption' , link = '$thisLink' , title = '$thisTitle' , description = '$thisDescription' , content = '$thisContent' , photos = '$thisPhotos' , line_id = '$thisLine' WHERE id = '$thisId'";
$result = MYSQL_QUERY($sql);

header("Location: editArticles.php?id=".$thisId."&updated=true",TRUE,302);

if ($result != 0)
{
	failed();
}	?>
Record  has been updated in the database. Here is the updated information :- <br><br>

<table>
<tr height="30">
	<td align="right"><b>Id : </b></td>
	<td><? echo $thisId; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Link : </b></td>
	<td><? echo $thisLink; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Title : </b></td>
	<td><? echo $thisTitle; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Description : </b></td>
	<td><? echo $thisDescription; ?></td>
</tr>
<tr height="30">
    <td valign="top" align="right"><b>Content: </b></td>
    <td bgcolor="white"><? echo getDescription(stripslashes(stripslashes($thisContent))); ?></td>
</tr>
</table>
<br><br><a href="listArticles.php">Go Back to List All Records</a>

<?php
include_once("../common/footer.php");
?>