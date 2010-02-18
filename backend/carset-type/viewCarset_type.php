<?php
include_once("../common/dbConnection.php");
include_once("../common/header.php");
?>
<?php
$thisId = $_REQUEST['idField']
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

View Record<br><br>

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

<?php
include_once("../common/footer.php");
?>