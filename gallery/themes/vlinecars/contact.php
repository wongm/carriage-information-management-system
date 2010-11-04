<?php 
if (!defined('WEBPATH')) die(); 

// otherwise show the user possible results
header("HTTP/1.0 404 Not Found");
header("Status: 404 Not Found");
 
$startTime = array_sum(explode(" ",microtime())); 
$pageTitle = ' - Contact Us';
include_once('header.php');
?>
Contact Us
<?php 
include_once('midbit.php'); 
?>
<h2>Contact Us</h2>
<?php 
printContactForm();
include_once('footer.php');
?>