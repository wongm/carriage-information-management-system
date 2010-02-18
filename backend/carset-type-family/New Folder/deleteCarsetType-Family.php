<?php
include_once("../common/dbConnection.php");
include_once("../common/header.php");
?>
<?php
	// Retreiving Form Elements from Form
	$thisFamily = addslashes($_REQUEST['thisFamilyField']);
	$thisCarset_type = addslashes($_REQUEST['thisCarset_typeField']);

?>
<?
$sql = "DELETE FROM carset_type_family WHERE family = '$thisFamily'";
$result = MYSQL_QUERY($sql);

?>
Record  has been deleted from database. Here is the deleted record :-<br><br>

<table>
<tr height="30">
	<td align="right"><b>Family : </b></td>
	<td><? echo $thisFamily; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Carset_type : </b></td>
	<td><? echo $thisCarset_type; ?></td>
</tr>
</table>

<?php
include_once("../common/footer.php");
?>