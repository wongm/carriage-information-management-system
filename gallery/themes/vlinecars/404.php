<?php 
if (!defined('WEBPATH')) die(); 

// otherwise show the user possible results
header("HTTP/1.0 404 Not Found");
header("Status: 404 Not Found");
 
$startTime = array_sum(explode(" ",microtime())); 
$pageTitle = ' - 404 Page Not Found';
include_once('header.php');
?>
404 Page Not Found
<?php 
include_once('midbit.php'); 
?>
<div class="topbar">
  	<h2>404 Page Not Found</h2>
</div>
<?php
echo gettext("<h4>The gallery object you are requesting cannot be found.</h4>");

?>
<p>You can use <a href="<?=SEARCH_URL_PATH?>/<?=$term?>">Search</a> to find what you are looking for. </p> 
<p>Otherwise please check you typed the address correctly. If you followed a link from elsewhere, please inform them. If the link was from this site, then <a href="<?=CONTACT_URL_PATH?>">Contact Me</a>.</p>
<?php include_once('footer.php');
?>