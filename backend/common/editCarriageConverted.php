<?php
include_once("../common/dbConnection.php");
include_once("../common/header.php");
?>
<?php
$thisId = $_REQUEST['id']
?>
<?php
$sql = "SELECT   * FROM carriage_converted WHERE id = '$thisId'";
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
	$thisCarriage = MYSQL_RESULT($result,$i,"carriage");
	$thisCarriageType = MYSQL_RESULT($result,$i,"carriage_type");
	$thisDate = MYSQL_RESULT($result,$i,"date");
	$thisWhy = MYSQL_RESULT($result,$i,"why");
	$thisNote = MYSQL_RESULT($result,$i,"note");
}
?>

<h2>Update carriage conversion details</h2>
<form name="carriage_convertedUpdateForm" method="POST" action="updateCarriageConverted.php">
<input type="hidden" name="thisIdField" value="<? echo $thisId; ?>">
<input type="hidden" name="referer" value="<?=$_SERVER[HTTP_REFERER]; ?>">

<table cellspacing="2" cellpadding="2" border="0" width="100%">
	<tr valign="top" height="20">
		<td align="right"> <b> Id :  </b> </td>
		<td><? echo $thisId; ?></td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Carriage :  </b> </td>
		<td> <input type="text" name="thisCarriageField" size="20" value="<? echo $thisCarriage; ?>">  </td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Carriage_type :  </b> </td>
		<td> <? drawObjectField('carriage_type', $thisCarriageType); ?></td>
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Date :  </b> </td>
		<td> <input type="text" name="thisDateField" size="20" value="<? echo $thisDate; ?>">  </td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Why :  </b> </td>
		<td> <? drawWhyField($thisWhy); ?> </td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Note :  </b> </td>
		<td> <input type="text" name="thisNoteField" size="20" value="<? echo $thisNote; ?>">  </td> 
	</tr>
</table>

<input type="submit" name="submitUpdateCarriage_convertedForm" value="Update Carriage_converted">
<input type="reset" name="resetForm" value="Clear Form">

</form>

<?php
include_once("../common/footer.php");
?>