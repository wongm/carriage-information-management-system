<?php
include_once("../common/dbConnection.php");

	// Retreiving Form Elements from Form
	$thisId = addslashes($_REQUEST['thisIdField']);
	$thisDescription = addslashes($_REQUEST['thisDescriptionField']);
	$thisContent = addslashes($_REQUEST['thisContentField']);
	$thisClass = addslashes($_REQUEST['thisClassField']);
	$thisStatus = addslashes($_REQUEST['thisStatusField']);
	$thisLivery = addslashes($_REQUEST['thisLiveryField']);

	$sql = "UPDATE locomotive SET id = '$thisId' , description = '$thisDescription' , livery = '$thisLivery' , status = '$thisStatus' , content = '$thisContent' , class = '$thisClass'  WHERE id = '$thisId'";
	$result = MYSQL_QUERY($sql);
	
	header("Location: editLocomotive.php?id=$thisId&updated=true",TRUE,302);

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
<tr height="30">
	<td align="right"><b>Content : </b></td>
	<td><? echo $thisContent; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Class : </b></td>
	<td><? echo $thisClass; ?></td>
</tr>
</table>
<br><br><a href="listLocomotive.php">Go Back to List All Records</a>

<?php
include_once("../common/footer.php");
?>