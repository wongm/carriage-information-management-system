<?php
include_once("../common/dbConnection.php");
include_once("../common/header.php");
?>
<?php
$thisId = $_REQUEST['id']
?>
<?php
$sql = "SELECT   * FROM carset_type WHERE id = '$thisId'";
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
	$thisFamily = MYSQL_RESULT($result,$i,"family");
	$thisDescription = MYSQL_RESULT($result,$i,"description");
	$thisCars = MYSQL_RESULT($result,$i,"cars");

}
?>

<h2>Confirm Record Deletion</h2><br><br>

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

<h3>If you are sure you want to delete the above record, please press the delete button below.</h3><br><br>
<form name="carset_typeEnterForm" method="post" action="deleteCarset_type.php">
<input type="hidden" name="thisIdField" value="<? echo $thisId; ?>">
<input type="submit" name="submitConfirmDeleteCarset_typeForm" value="Delete  from Carset_type">
<input type="button" name="cancel" value="Go Back" onClick="javascript:history.back();">
</form>

<?php
include_once("../common/footer.php");
?>