<?php
$pageTitle = 'Edit Carriages Sets';
include_once("../common/dbConnection.php");
include_once("../common/header.php");

$sql = "SELECT   * FROM carset ORDER BY id ASC";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUM_ROWS($result);

echo '<a href="enterNewCarset.php">Add new carriage set</a><hr/>';

if ($numberOfRows==0) {  
?>

Sorry. No records found !!

<?
}
else if ($numberOfRows>0) {

	$i=0;
?>
<TABLE CELLSPACING="0" CELLPADDING="3" BORDER="0">
	<TR>
		<TD>
			<a href="<? echo $PHP_SELF; ?>?sortBy=id&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
				<B>Id</B>
			</a>
</TD>
		<TD>
			<a href="<? echo $PHP_SELF; ?>?sortBy=description&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
				<B>Description</B>
			</a>
</TD>
	</TR>
<?
	while ($i<$numberOfRows)
	{

		if (($i%2)==0) { $bgColor = "#FFFFFF"; } else { $bgColor = "#C0C0C0"; }

	$thisId = MYSQL_RESULT($result,$i,"id");
	$thisDescription = substr(MYSQL_RESULT($result,$i,"content"), 0, 50).'...';

?>
	<TR BGCOLOR="<? echo $bgColor; ?>">
		<TD><? echo $thisId; ?></TD>
		<TD><? echo $thisDescription; ?></TD>
	<TD><a href="editCarset.php?id=<? echo $thisId; ?>">Edit</a></TD>
	<TD><a href="confirmDeleteCarset.php?id=<? echo $thisId; ?>">Delete</a></TD>
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