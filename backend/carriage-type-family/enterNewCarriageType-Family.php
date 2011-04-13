<?php
$pageTitle = 'Enter new carriage Type to Family mappings';
include_once("../common/dbConnection.php");
include_once("../common/header.php");
?>
<form name="carriage_type_familyEnterForm" method="post" action="insertNewCarriageType-Family.php">

<table cellspacing="2" cellpadding="2" border="0" width="100%">
	<tr valign="top" height="20">
		<td align="right"> <b> Family :  </b> </td>
		<td><select name="thisFamilyField">
<?
	$result = MYSQL_QUERY("SELECT * FROM family ORDER BY id ASC");
	$numberOfRows = MYSQL_NUM_ROWS($result);
	
	for ($i = 0; $i < $numberOfRows; $i++)
	{
		$thisFamilyId = MYSQL_RESULT($result,$i,"id");
		echo "<option value=\"$thisFamilyId\">$thisFamilyId</option>";
	}
		?>
		</select></td> 
	</tr>
	
		<tr valign="top" height="20">
		<td align="right"> <b> carriage type :  </b> </td>
		<td><select name="thiscarriage_typeField">
<?
	$result = MYSQL_QUERY("SELECT * FROM carriage_type ORDER BY id ASC");
	$numberOfRows = MYSQL_NUM_ROWS($result);
	
	for ($i = 0; $i < $numberOfRows; $i++)
	{
		$thisFamilyId = MYSQL_RESULT($result,$i,"id");
		echo "<option value=\"$thisFamilyId\">$thisFamilyId</option>";
	}
		?>
		</select></td> 
	</tr>
</table>

<input type="submit" name="submitEntercarriage_type_familyForm" value="Enter carrriage type <> family">
<input type="reset" name="resetForm" value="Clear Form">

</form>

<?php
include_once("../common/footer.php");
?>