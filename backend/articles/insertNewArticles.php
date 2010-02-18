<?php
include_once("../common/dbConnection.php");
//include_once("../common/header.php");

	// Retreiving Form Elements from Form
	$thisId = addslashes($_REQUEST['thisIdField']);
	$thisLink = addslashes($_REQUEST['thisLinkField']);
	$thisTitle = addslashes($_REQUEST['thisTitleField']);
	$thisDescription = addslashes($_REQUEST['thisDescriptionField']);
	$thisContent = addslashes($_REQUEST['thisContentField']);
	$thisPhotos = addslashes($_REQUEST['thisPhotosField']);
	$thisLine = addslashes($_REQUEST['thisLineField']);

	if ($thisTitle == '' OR $thisContent == '')
	{
		insertfail();
	}
	else
	{
		$sqlQuery = "INSERT INTO articles (link , title , description , content , photos, line_id) VALUES ('$thisLink' , '$thisTitle' , '$thisDescription' , '$thisContent' , '$thisPhotos' , '$thisLine')";
		$result = MYSQL_QUERY($sqlQuery);
		
		
		$sqlQuery = "SELECT id FROM articles ORDER BY id desc LIMIT 0, 1";
		$result = MYSQL_QUERY($sqlQuery);
		$id = MYSQL_RESULT($result,$i,"id");
		
		header("Location: editArticles.php?id=".$id."&inserted=true",TRUE,302);
		
		if ($result != 0)
		{
			failed();
		}	?>
A new record has been inserted in the database. Here is the information that has been inserted :- <br><br>

<table>
<tr height="30">
	<td align="right"><b>Id : </b></td>
	<td><? echo $thisId; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Link (can never be changed!): </b></td>
	<td><? echo $thisLink; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Title : </b></td>
	<td><? echo $thisTitle; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Description (admin only visibility, can never be changed!): </b></td>
	<td><? echo $thisDescription; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Content : </b></td>
	<td bgcolor="white"><? echo stripslashes(stripslashes($thisContent)); ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Line : </b></td>
	<td><? echo $thisLine; ?></td>
</tr>
</table>

<?php
}	// end if
include_once("../common/footer.php");
?>