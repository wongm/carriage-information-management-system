<?php
$thisId = $_REQUEST['id'];
include_once("../common/dbConnection.php");
include_once("../common/header.php");
editObjectEventsForm('carset', 'Carset', $thisId);
include_once("../common/footer.php");
?>