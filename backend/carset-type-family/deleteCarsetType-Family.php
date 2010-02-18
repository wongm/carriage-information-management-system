<?php
include_once("../common/dbConnection.php");

// Retreiving Form Elements from Form
$thisFamily = addslashes($_REQUEST['thisFamilyField']);
$thisCarset_type = addslashes($_REQUEST['thisCarset_typeField']);

$sql = "DELETE FROM carset_type_family WHERE family = '$thisFamily' AND carset_type = '$thisCarset_type'";
$result = MYSQL_QUERY($sql);

header("Location: listCarsetType-Family.php?deleted=true",TRUE,302);

?>
Record  has been deleted from database. Here is the deleted record :-<br><br>

<table>
<tr height="30">
	<td align="right"><b>Family : </b></td>
	<td><? echo $thisFamily; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>carset_type : </b></td>
	<td><? echo $thisCarset_type; ?></td>
</tr>
</table>

<?php
include_once("../common/footer.php");
?>