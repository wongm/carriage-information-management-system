<?php
$pageTitle = 'Edit carriage Type to Family mappings';
include_once("../common/dbConnection.php");
include_once("../common/header.php");

$sql = "SELECT   * FROM carriage_type_family";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUM_ROWS($result);

echo '<a href="enterNewCarriageType-Family.php">Add new carriage type - family mapping</a><hr/>';

if ($_REQUEST['deleted'])
{
	echo "<p class=\"updated\">Deleted!<p>";
}
else if ($_REQUEST['inserted'])
{
	echo "<p class=\"updated\">Inserted!<p>";
}

if ($numberOfRows==0) {  
?>

Sorry. No records found !!

<?
}
else if ($numberOfRows>0) {

	$i=0;
?>

<TABLE CELLSPACING="0" CELLPADDING="3" BORDER="0" WIDTH="100%">
	<TR>
		<TD><B>Family</B></TD>
		<TD><B>Carriage type</B></TD>
	</TR>
<?
	while ($i<$numberOfRows)
	{

		if (($i%2)==0) { $bgColor = "#FFFFFF"; } else { $bgColor = "#C0C0C0"; }

	$thisFamily = MYSQL_RESULT($result,$i,"family");
	$thiscarriage_type = MYSQL_RESULT($result,$i,"carriage_type");

?>
	<TR BGCOLOR="<? echo $bgColor; ?>">
		<TD><? echo $thisFamily; ?></TD>
		<TD><? echo $thiscarriage_type; ?></TD>
	<TD><a href="confirmDeleteCarriageType-Family.php?family=<? echo $thisFamily; ?>&carriagetype=<?=$thiscarriage_type?>">Delete</a></TD>

	</TR>
<?
		$i++;

	} // end while loop
?>
</TABLE>


<br>
<?
if ($_REQUEST['startLimit'] != "")
{
?>

<a href="<? echo  $_SERVER['PHP_SELF']; ?>?startLimit=<? echo $previousStartLimit; ?>&limitPerPage=<? echo $limitPerPage; ?>&sortBy=<? echo $sortBy; ?>&sortOrder=<? echo $sortOrder; ?>">Previous <? echo $limitPerPage; ?> Results</a>....
<? } ?>
<?
if ($numberOfRows == $limitPerPage)
{
?>
<a href="<? echo $_SERVER['PHP_SELF']; ?>?startLimit=<? echo $nextStartLimit; ?>&limitPerPage=<? echo $limitPerPage; ?>&sortBy=<? echo $sortBy; ?>&sortOrder=<? echo $sortOrder; ?>">Next <? echo $limitPerPage; ?> Results</a>
<? } ?>

<br><br>
<?
} // end of if numberOfRows > 0 
 ?>

<?php
include_once("../common/footer.php");
?>