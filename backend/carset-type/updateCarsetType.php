<?php
include_once("../common/dbConnection.php");

	// Retreiving Form Elements from Form
	$thisId = addslashes($_REQUEST['thisIdField']);
	$thisFamily = addslashes($_REQUEST['thisFamilyField']);
	$thisDescription = addslashes($_REQUEST['thisDescriptionField']);
	$thisCars = addslashes($_REQUEST['thisCarsField']);
	$thisContent = addslashes($_REQUEST['thisContentField']);

	$sql = "UPDATE carset_type SET id = '$thisId' , family = '$thisFamily' , description = '$thisDescription' , cars = '$thisCars'  , content = '$thisContent'  WHERE id = '$thisId'";
	$result = MYSQL_QUERY($sql);
	
	header("Location: editCarsetType.php?id=".$thisId."&updated=true",TRUE,302);

?>
Record  has been updated in the database. Here is the updated information :- <br><br>

<table>
<tr height="30">
	<td align="right"><b>Id : </b></td>
	<td><? echo $thisId; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Family : </b></td>
	<td><? echo $thisFamily; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Description : </b></td>
	<td><? echo $thisDescription; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Cars : </b></td>
	<td><? echo $thisCars; ?></td>
</tr>
</table>
<br><br><a href="listCarset_type.php">Go Back to List All Records</a>

<?php
include_once("../common/footer.php");
?>