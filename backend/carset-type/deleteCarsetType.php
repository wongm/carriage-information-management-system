<?php
include_once("../common/dbConnection.php");
include_once("../common/header.php");
?>
<?php
	// Retreiving Form Elements from Form
	$thisId = addslashes($_REQUEST['thisIdField']);
	$thisFamily = addslashes($_REQUEST['thisFamilyField']);
	$thisDescription = addslashes($_REQUEST['thisDescriptionField']);
	$thisCars = addslashes($_REQUEST['thisCarsField']);

?>
<?
$sql = "DELETE FROM carset_type WHERE id = '$thisId'";
$result = MYSQL_QUERY($sql);

?>
Record  has been deleted from database. Here is the deleted record :-<br><br>

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

<?php
include_once("../common/footer.php");
?>