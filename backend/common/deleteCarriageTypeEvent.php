<?php
include_once("../common/dbConnection.php");
include_once("../common/header.php");
?>
<?php
	// Retreiving Form Elements from Form
	$thisId = addslashes($_REQUEST['thisIdField']);
	$thisCarriage_type = addslashes($_REQUEST['thisCarriage_typeField']);
	$thisDate = addslashes($_REQUEST['thisDateField']);
	$thisWhy = addslashes($_REQUEST['thisWhyField']);
	$thisNote = addslashes($_REQUEST['thisNoteField']);

?>
<?
$sql = "DELETE FROM carriage_type_event WHERE id = '$thisId'";
$result = MYSQL_QUERY($sql);

?>
Record  has been deleted from database. Here is the deleted record :-<br><br>

<table>
<tr height="30">
	<td align="right"><b>Id : </b></td>
	<td><? echo $thisId; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Carriage_type : </b></td>
	<td><? echo $thisCarriage_type; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Date : </b></td>
	<td><? echo $thisDate; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Why : </b></td>
	<td><? echo $thisWhy; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Note : </b></td>
	<td><? echo $thisNote; ?></td>
</tr>
</table>

<?php
include_once("../common/footer.php");
?>