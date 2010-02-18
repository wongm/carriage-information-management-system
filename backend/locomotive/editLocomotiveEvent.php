<?php
$thisId = $_REQUEST['id'];
include_once("../common/dbConnection.php");
include_once("../common/header.php");
editObjectEventsForm('locomotive', 'Locomotive', $thisId);
include_once("../common/footer.php");
?>