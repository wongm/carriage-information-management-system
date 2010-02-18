<?php
include_once("../common/dbConnection.php");

// Retreiving Form Elements from Form
$thisFamily = addslashes($_REQUEST['thisFamilyField']);
$thiscarriage_type = addslashes($_REQUEST['thiscarriage_typeField']);

$sql = "DELETE FROM carriage_type_family WHERE family = '$thisFamily' AND carriage_type = '$thiscarriage_type'";
$result = MYSQL_QUERY($sql);

header("Location: listCarriageType-Family.php?deleted=true",TRUE,302);

?>
Record  has been deleted from database. Here is the deleted record :-<br><br>

<table>
<tr height="30">
	<td align="right"><b>Family : </b></td>
	<td><? echo $thisFamily; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>carriage_type : </b></td>
	<td><? echo $thiscarriage_type; ?></td>
</tr>
</table>

<?php
include_once("../common/footer.php");
?>