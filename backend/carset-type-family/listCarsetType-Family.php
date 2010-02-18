<?php
$pageTitle = 'Edit Carset Type to Family mappings';
include_once("../common/dbConnection.php");
include_once("../common/header.php");

$sql = "SELECT   * FROM carset_type_family";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUM_ROWS($result);

echo '<a href="enterNewCarsetType-Family.php">Add new carset type - family mapping</a><hr/>';

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
		<TD><B>Carset type</B></TD>
	</TR>
<?
	while ($i<$numberOfRows)
	{

		if (($i%2)==0) { $bgColor = "#FFFFFF"; } else { $bgColor = "#C0C0C0"; }

	$thisFamily = MYSQL_RESULT($result,$i,"family");
	$thisCarset_type = MYSQL_RESULT($result,$i,"carset_type");

?>
	<TR BGCOLOR="<? echo $bgColor; ?>">
		<TD><? echo $thisFamily; ?></TD>
		<TD><? echo $thisCarset_type; ?></TD>
	<TD><a href="confirmDeleteCarsetType-Family.php?family=<? echo $thisFamily; ?>&carsettype=<?=$thisCarset_type?>">Delete</a></TD>

	</TR>
<?
		$i++;

	} // end while loop
?>
</TABLE>

<?
} // end of if numberOfRows > 0 
 ?>

<?php
include_once("../common/footer.php");
?>