<?php
include_once("../common/dbConnection.php");

	// Retreiving Form Elements from Form
	$thisId = addslashes($_REQUEST['thisIdField']);
	$thisDescription = addslashes($_REQUEST['thisDescriptionField']);
	$thisContent = addslashes($_REQUEST['thisContentField']);
	$thisCarsetContent = addslashes($_REQUEST['thisCarsetContentField']);
	$thisCarriageContent = addslashes($_REQUEST['thisCarriageContentField']);

	$sql = "UPDATE family 
		SET id = '$thisId' , description = '$thisDescription' ,
		content = '$thisConent' , carset_content = '$thisCarsetContent' , 
		carriage_content = '$thisCarriageContent' WHERE id = '$thisId'";
	$result = MYSQL_QUERY($sql);
	
	header("Location: editFamily.php?id=".$thisId."&updated=true",TRUE,302);

?>
Record  has been updated in the database. Here is the updated information :- <br><br>

<table>
<tr height="30">
	<td align="right"><b>Id : </b></td>
	<td><? echo $thisId; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Description : </b></td>
	<td><? echo $thisDescription; ?></td>
</tr>
</table>
<br><br><a href="listFamily.php">Go Back to List All Records</a>

<?php
include_once("../common/footer.php");
?>