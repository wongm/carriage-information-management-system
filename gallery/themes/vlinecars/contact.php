<?php $startTime = array_sum(explode(" ",microtime())); if (!defined('WEBPATH')) die();

$pageTitle = ' - Contact me';
include_once('header.php'); ?>
<a href="<?=getGalleryIndexURL();?>" title="Gallery Index"><?=getGalleryTitle();?></a> &raquo; Contact me
<?php 
include_once('midbit.php'); 
printContactForm();
include_once('footer.php'); 
?>