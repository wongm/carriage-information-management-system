<?php
include_once("../common/dbConnection.php");

	// Retreiving Form Elements from Form
	$thisId = addslashes($_REQUEST['thisIdField']);
	$thisDescription = addslashes($_REQUEST['thisDescriptionField']);
	$thisFamily = addslashes($_REQUEST['thisFamilyField']);
	$thisContent = addslashes($_REQUEST['thisContentField']);

	$sql = "UPDATE carriage_type SET content = '$thisContent', description = '$thisDescription' WHERE id = '$thisId'";
	$result = MYSQL_QUERY($sql);
	
	header("Location: editCarriageType.php?id=".$thisId."&updated=true",TRUE,302);

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
<br><br><a href="listCarriage_type.php">Go Back to List All Records</a>

<?php
include_once("../common/footer.php");
?>