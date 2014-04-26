<?php 
$pageTitle = array(array("Liveries", ''));
include_once("common/header.php");
include_once("common/dbConnection.php");

$liveries = getAllLiveries();
$numberOfRows = sizeof($liveries);

if ($numberOfRows==0)
{
?>
Sorry. No records found !!
<?
}
else
{
	for ($i = 0; $i < $numberOfRows; $i++)
	{
		?>
<h4 id="livery<? echo $liveries[$i]['id']; ?>"><? echo $liveries[$i]['name']; ?></h4>
<hr/>
<p><i><? echo $liveries[$i]['description']; ?></i></p>
<?		
		getDescription($liveries[$i]['content']);
?>
<p><a href="#top" class="credit">Top</a></p>
<?
	}	// end loop
}		// end if

include_once("common/footer.php"); ?>