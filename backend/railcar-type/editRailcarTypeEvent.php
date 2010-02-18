<?php
$thisId = $_REQUEST['id'];
include_once("../common/dbConnection.php");
include_once("../common/header.php");
editObjectEventsForm('railcar_type', 'Railcar Type', $thisId);
include_once("../common/footer.php");
?>