<?php $startTime = array_sum(explode(" ",microtime())); if (!defined('WEBPATH')) die();

$pageTitle = ' - Archive';
include_once('header.php'); ?>
<a href="<?=getGalleryIndexURL();?>" title="Gallery Index"><?=getGalleryTitle();?></a> &raquo; Archives
<?php 
include_once('midbit.php'); 
?>
<div id="padbox">
 <?php if (!checkForPassword()) {?>
	<div id="archive">
			<h2>Gallery archive</h2>
			<?php printAllDates(); ?>
			<hr />
			<?php if(function_exists("printNewsArchive")) { ?>
			<h2>News archive</h2>
			<?php printNewsArchive("archive"); ?>
			<hr />
			<?php } ?>
	</div>
	<div id="tag_cloud">
		<p><? echo gettext('Popular Tags'); ?></p>
		<?php printAllTagsAs('cloud', 'tags'); ?>
	</div>
 <?php } ?>
</div>
<? include_once('footer.php'); ?>