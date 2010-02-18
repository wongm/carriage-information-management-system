<?php
include_once("../common/dbConnection.php");

	// Retreiving Form Elements from Form
	$thisId = addslashes($_REQUEST['thisIdField']);
	$thisDescription = addslashes($_REQUEST['thisDescriptionField']);
	$thisFamily = addslashes($_REQUEST['thisFamilyField']);
	$thisStatus = addslashes($_REQUEST['thisStatusField']);
	$thisContent = addslashes($_REQUEST['thisContentField']);
	$thisLivery = addslashes($_REQUEST['thisLiveryField']);

	$sql = "UPDATE carset SET id = '$thisId' , description = '$thisDescription', livery = '$thisLivery', content = '$thisContent', family = '$thisFamily', status = '$thisStatus'    WHERE id = '$thisId'";
	$result = MYSQL_QUERY($sql);
	header("Location: editCarset.php?id=".$thisId."&updated=true",TRUE,302);
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
<br><br><a href="listCarset.php">Go Back to List All Records</a>

<?php
include_once("../common/footer.php");
?>