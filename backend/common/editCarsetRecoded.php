<?php
include_once("../common/dbConnection.php");
include_once("../common/header.php");
?>
<?php
$thisId = $_REQUEST['id']
?>
<?php
$sql = "SELECT   * FROM carset_recoded WHERE id = '$thisId'";
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
	$thisCarset = MYSQL_RESULT($result,$i,"carset");
	$thisCarsetType = MYSQL_RESULT($result,$i,"carset_type");
	$thisDate = MYSQL_RESULT($result,$i,"date");
	$thisWhy = MYSQL_RESULT($result,$i,"why");
	$thisNote = MYSQL_RESULT($result,$i,"note");

}
?>

<h2>Update carset recodings</h2>
<form name="carset_recodedUpdateForm" method="post" action="updateCarsetRecoded.php">
<input type="hidden" name="thisIdField" size="20" value="<? echo $thisId; ?>">
<input type="hidden" name="referer" value="<?=$_SERVER[HTTP_REFERER]; ?>">
<table cellspacing="2" cellpadding="2" border="0" width="100%">
	<tr valign="top" height="20">
		<td align="right"> <b> Id :  </b> </td>
		<td><? echo $thisId; ?> </td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Set :  </b> </td>
		<td> <input type="text" name="thisCarsetField" size="20" value="<? echo $thisCarset; ?>">  </td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Set_type :  </b> </td>
		<td> <? drawObjectField('carset_type', $thisCarsetType); ?></td>
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

<input type="submit" name="submitUpdateCarset_recodedForm" value="Update Carset_recoded">
<input type="reset" name="resetForm" value="Clear Form">

</form>

<?php
include_once("../common/footer.php");
?>