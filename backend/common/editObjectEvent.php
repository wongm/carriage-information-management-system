<?php
$thisId = $_REQUEST['id'];
$object = $_REQUEST['object'];
include_once("../common/dbConnection.php");
include_once("../common/header.php");
editObjectEventsForm($object, getNiceName($object), $thisId);
include_once("../common/footer.php");
?>