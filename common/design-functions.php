<?php 


include_once("common/dbConnection.php");

function drawAllDesigns()
{
	drawObjectsOfType(getObjectsOfType('family', '', 'id'), 'designs.php?family=');
}

 ?>