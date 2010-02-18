<?php
$pageTitle='Edit Regions';
include_once("../common/dbConnection.php");
include_once("../common/header.php");

$sql = "SELECT   * FROM raillines";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUM_ROWS($result);

if ($numberOfRows==0) {  
?>

Sorry. No records found !!

<?
}
else if ($numberOfRows>0) {

	$i=0;
?>
<TABLE class="linedTable">
	<TR>
		<TD>
			<B>Name</B>
</TD>
		<TD>
			<B>Description</B>
</TD>
<TD></TD><TD></TD>
	</TR>
<?
	while ($i<$numberOfRows)
	{

		if (($i%2)==0) { $bgColor = "#FFFFFF"; } else { $bgColor = "#C0C0C0"; }

	$thisName = MYSQL_RESULT($result,$i,"name");
	$thisId = MYSQL_RESULT($result,$i,"link");
	$thisDescription = substr(MYSQL_RESULT($result,$i,"description"), 0, 50).'...';

?>
	<TR BGCOLOR="<? echo $bgColor; ?>">
		<TD><? echo $thisName; ?></TD>
		<TD><? echo $thisDescription; ?></TD>
	<TD><a href="editLine.php?line=<? echo $thisId; ?>">Edit Region</a></TD>
	<TD><a href="listStations.php?line=<? echo $thisId; ?>">Edit Stations</a></TD>
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