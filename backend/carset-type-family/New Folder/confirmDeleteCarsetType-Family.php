<?php
include_once("../common/dbConnection.php");
include_once("../common/header.php");

$thisFamily = $_REQUEST['familyField'];
?>
<?php
$sql = "SELECT   * FROM carset_type_family WHERE family = '$thisFamily'";
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
	$thisCarset_type = MYSQL_RESULT($result,$i,"carset_type");

}
?>

<h2>Confirm Record Deletion</h2><br><br>

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

<h3>If you are sure you want to delete the above record, please press the delete button below.</h3><br><br>
<form name="carset_type_familyEnterForm" method="POST" action="deleteCarset_type_family.php">
<input type="hidden" name="thisFamilyField" value="<? echo $thisFamily; ?>">
<input type="submit" name="submitConfirmDeleteCarset_type_familyForm" value="Delete  from Carset_type_family">
<input type="button" name="cancel" value="Go Back" onClick="javascript:history.back();">
</form>

<?php
include_once("../common/footer.php");
?>