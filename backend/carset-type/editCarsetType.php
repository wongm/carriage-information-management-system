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
	$thisDescription = stripslashes(MYSQL_RESULT($result,$i,"description"));
	$thisCars = MYSQL_RESULT($result,$i,"cars");
	$thisContent = stripslashes(MYSQL_RESULT($result,$i,"content"));

}
?>
<h3>Update Carset Type</h3><hr/>
<?
	if ($_REQUEST['inserted'])
	{
		echo "<p class=\"updated\">Inserted!<p>";
	}
	elseif ($_REQUEST['updated'])
	{
		echo "<p class=\"updated\">Updated!<p>";
	}
	else
	{
		echo "<a href=\"listCarsetType.php\">Return without changes!</a>";
		echo "<hr>";
	}
?>
<fieldset id="<?=$object?>"><legend>Carset type</legend>
<form name="carset_typeUpdateForm" method="POST" action="updateCarsetType.php">
<input type="hidden" name="thisIdField" value="<? echo $thisId; ?>">

<table>
	<tr valign="top" height="20">
		<td align="right"> <b> Id :  </b> </td>
		<td> <? echo $thisId; ?>  </td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Family :  </b> </td>
		<td> <input type="text" name="thisFamilyField" size="20" value="<? echo $thisFamily; ?>">  </td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Description :  </b> </td>
		<td> <input type="text" name="thisDescriptionField" size="20" value="<? echo $thisDescription; ?>">  </td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Cars :  </b> </td>
		<td> <input type="text" name="thisCarsField" size="20" value="<? echo $thisCars; ?>">  </td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Content :  </b> </td>
		<td> <? fancyform('Content', $thisContent); ?> </td> 
	</tr>
</table>

<input type="submit" name="submitUpdateCarset_typeForm" value="Update Carset Type">

</form>
</fieldset>


<?php
editAddObjectEventsForm('carset_type', 'Carset Type', $thisId); 
editCarsetRecodesForm('', $thisId);
include_once("../common/footer.php");
?>