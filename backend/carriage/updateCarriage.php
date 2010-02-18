<?php
include_once("../common/dbConnection.php");
///include_once("../common/header.php");
?>
<?php
	// Retreiving Form Elements from Form
	$thisId = addslashes($_REQUEST['thisIdField']);
	$thisDescription = addslashes($_REQUEST['thisDescriptionField']);
	$thisFamily = addslashes($_REQUEST['thisFamilyField']);
	$thisContent = addslashes($_REQUEST['thisContentField']);
	$thisStatus = addslashes($_REQUEST['thisStatusField']);
	$thisLivery = addslashes($_REQUEST['thisLiveryField']);

$sql = "UPDATE carriage SET id = '$thisId' , livery = '$thisLivery' , description = '$thisDescription', content = '$thisContent', family = '$thisFamily', status = '$thisStatus'  WHERE id = '$thisId'";
$result = MYSQL_QUERY($sql);
header("Location: editCarriage.php?id=".$thisId."&updated=true",TRUE,302);
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
<br><br><a href="listCarriage.php">Go Back to List All Records</a>

<?php
include_once("../common/footer.php");
?>