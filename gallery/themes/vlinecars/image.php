<?php 
$startTime = array_sum(explode(" ",microtime())); if (!defined('WEBPATH')) die();
include_once('header.php');
?>
<a href="<?=getGalleryIndexURL();?>" title="Gallery Index"><?=getGalleryTitle();?></a> &raquo; 
<?php printParentBreadcrumb('', ' &raquo; ', ' &raquo; '); ?>
<a href="<?=getAlbumLinkURL();?>" title="<?=getAlbumTitle();?> Index"><?=getAlbumTitle();?></a> &raquo; 
<?php printTruncatedImageTitle(true); ?>
<?php 
include_once('midbit.php'); 
?>
<div class="topbar">
  	<h3><?=getImageTitle();?></h3>
  	<?php printImageDesc(true); ?>   
<table class="centeredTable">
	<tr><td class="imageDisplay">
        <a href="<?=getFullImageURL();?>" title="<?=getImageTitle();?>">
        <?php printDefaultSizedImage(getImageTitle()); ?></a><br/>
		<a href="<?=getFullImageURL();?>"><? getSelectedSizedThingy(); ?></a><br/>
    </td></tr>
</table>

<?php printEXIFData() ; ?>

<table class="nextables"><tr id="thumbnav"><td>
    <?php if (hasPrevImage()) { ?>
    <a class="prev" href="<?=getPrevImageURL();?>" title="Previous Image"><span>&laquo;</span> Previous</a>
    </td><td>
    <a class="next" href="<?=getPrevImageURL();?>" title="<?=getPrevImageTitle();?>"><?='<img src="'.getPrevImageThumb().'" />'; ?></a>
    <?php } else { echo "</td><td>"; } ?>
    </td><td>
    <?php if (hasNextImage()) { ?>
    <a class="prev" href="<?=getNextImageURL();?>" title="<?=getNextImageTitle();?>"><?='<img src="'.getNextImageThumb().'" />'; ?></a>
    </td><td>
    <a class="next" href="<?=getNextImageURL();?>" title="Next Image">Next <span>&raquo;</span></a>
    <?php } else { echo "</td><td>"; } ?>
</td></tr></table>
  
<?php 	
  	printForumLink();
  	include_once('footer.php'); 
?>