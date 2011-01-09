<?php
include_once("../common/dbConnection.php");
include_once("../common/header.php");
?>
<?php
$thisId = $_REQUEST['id']
?>
<?php
$sql = "SELECT   * FROM locomotive WHERE id = '$thisId'";
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
	$thisDescription = MYSQL_RESULT($result,$i,"description");
	$thisContent = MYSQL_RESULT($result,$i,"content");
	$thisClass = MYSQL_RESULT($result,$i,"class");

}
?>

<h2>Confirm Record Deletion</h2><br><br>

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

<h3>If you are sure you want to delete the above record, please press the delete button below.</h3><br><br>
<form name="locomotiveEnterForm" method="post" action="deleteLocomotive.php">
<input type="hidden" name="thisIdField" value="<? echo $thisId; ?>">
<input type="submit" name="submitConfirmDeleteLocomotiveForm" value="Delete  from Locomotive">
<input type="button" name="cancel" value="Go Back" onClick="javascript:history.back();">
</form>

<?php
include_once("../common/footer.php");
?>