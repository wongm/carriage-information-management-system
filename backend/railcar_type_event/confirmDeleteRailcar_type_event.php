<?php
include_once("../common/dbConnection.php");
include_once("../common/header.php");
?>
<?php
$thisId = $_REQUEST['idField']
?>
<?php
$sql = "SELECT   * FROM railcar_type_event WHERE id = '$thisId'";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
if ($numberOfRows==0) {  
?>

Sorry. No records found !!

<?php
}
else if ($numberOfRows>0) {

	$i=0;
	$thisId = MYSQL_RESULT($result,$i,"id");
	$thisRailcar_type = MYSQL_RESULT($result,$i,"railcar_type");
	$thisDate = MYSQL_RESULT($result,$i,"date");
	$thisWhy = MYSQL_RESULT($result,$i,"why");
	$thisNote = MYSQL_RESULT($result,$i,"note");

}
?>

<h2>Confirm Record Deletion</h2><br><br>

<table>
<tr height="30">
	<td align="right"><b>Id : </b></td>
	<td><? echo $thisId; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Railcar_type : </b></td>
	<td><? echo $thisRailcar_type; ?></td>
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

<h3>If you are sure you want to delete the above record, please press the delete button below.</h3><br><br>
<form name="railcar_type_eventEnterForm" method="POST" action="deleteRailcar_type_event.php">
<input type="hidden" name="thisIdField" value="<? echo $thisId; ?>">
<input type="submit" name="submitConfirmDeleteRailcar_type_eventForm" value="Delete  from Railcar_type_event">
<input type="button" name="cancel" value="Go Back" onClick="javascript:history.back();">
</form>

<?php
include_once("../common/footer.php");
?>