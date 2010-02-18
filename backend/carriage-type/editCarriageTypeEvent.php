<?php
$thisId = $_REQUEST['id'];
include_once("../common/dbConnection.php");
include_once("../common/header.php");
editObjectEventsForm('carriage_type', 'Carriage Type', $thisId);
include_once("../common/footer.php");
?>