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
  	<h2>Image: <?=getImageTitle();?></h2>
  	<?php printImageDesc(true); ?>
  </div>
      
  <table class="centeredTable">
	  <tr><td class="imageDisplay">
        <a href="<?=getFullImageURL();?>" rel="lightbox" title="<?=getImageTitle();?>">
        <?php printDefaultSizedImage(getImageTitle()); ?></a><br/>
        <a href="<?=getFullImageURL();?>" rel="lightbox" title="<?=getImageTitle();?>">View full size photo (<?=getFullWidth()?>px by <?=getFullHeight()?>px)</a><br/>
      </td></tr>
  </table>

  <?php printEXIFData() ; ?>
<?php if (hasPrevImage() or hasNextImage()) { ?>    
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
<?php } ?>
<?
if(function_exists("printImageMarkupFields"))
{	
	printImageMarkupFields();
}
include_once('footer.php'); 
?>