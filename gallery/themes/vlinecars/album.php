<?php
$startTime = array_sum(explode(" ",microtime())); if (!defined('WEBPATH')) die();
include_once('header.php');
?>
<a href="<?=getGalleryIndexURL();?>" title="Gallery Index"><?=getGalleryTitle();?></a> &raquo;
<?php printParentBreadcrumb('', ' &raquo; ', ' &raquo; '); ?>
<?php printAlbumTitle(true);?>
<?php
include_once('midbit.php');
?>
<div class="topbar">
  	<h2><?=getAlbumTitle();?></h2>
  	<?php printAlbumDescAndLink(true); ?>
</div>

<?
 	drawWongmListSubalbums();

 	/* Only print if we have images. */
 	$num = getNumImages();
  	if ($num > 0)
  	{
  		drawWongmGridImages($num);
	}

	if (hasPrevPage() || hasNextPage())
  	{
?>
<table class="nextables"><tr id="pagelinked"><td>
	<?php if (hasPrevPage()) { ?> <a class="prev" href="<?=getMyPageURL(getPrevPageURL());?>" title="Previous Page"><span>&laquo;</span> Previous</a> <?php } ?>
	</td><td><?php printPageList(); ?></td><td>
	<?php if (hasNextPage()) { ?> <a class="next" href="<?=getMyPageURL(getNextPageURL());?>" title="Next Page">Next <span>&raquo;</span></a><?php } ?>
</td></tr></table>
<?php
	}

	printTags('links', '<h4>Tags</h4>');

	echo "<p>".formatHitCounter(incrementAndReturnHitCounter('album'), false)."</p>";
	include_once('footer.php');
?>