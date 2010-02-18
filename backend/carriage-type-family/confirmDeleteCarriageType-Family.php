<?php
include_once("../common/dbConnection.php");
include_once("../common/header.php");

$thisFamily = $_REQUEST['family'];
$thisCarriageType = $_REQUEST['carriagetype'];

$sql = "SELECT   * FROM carriage_type_family WHERE family = '$thisFamily' AND carriage_type = '$thisCarriageType'";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
if ($numberOfRows==0) {  
?>

Sorry. No records found !!

<?php
}
else if ($numberOfRows>0) {

	$i=0;
	$thisFamily = MYSQL_RESULT($result,$i,"family");
	$thiscarriage_type = MYSQL_RESULT($result,$i,"carriage_type");

}
?>

<h2>Confirm Record Deletion</h2><br><br>

<table>
<tr height="30">
	<td align="right"><b>Family : </b></td>
	<td><? echo $thisFamily; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Carriage type : </b></td>
	<td><? echo $thiscarriage_type; ?></td>
</tr>
</table>

<h3>If you are sure you want to delete the above record, please press the delete button below.</h3><br><br>
<form name="carriage_type_familyEnterForm" method="POST" action="deleteCarriageType-Family.php">
<input type="hidden" name="thisFamilyField" value="<? echo $thisFamily; ?>">
<input type="hidden" name="thiscarriage_typeField" value="<? echo $thiscarriage_type; ?>">
<input type="submit" name="submitConfirmDeletecarriage_type_familyForm" value="Delete from carriage type <> family">
<input type="button" name="cancel" value="Go Back" onClick="javascript:history.back();">
</form>

<?php
include_once("../common/footer.php");
?>