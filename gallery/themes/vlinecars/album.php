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
  	<h3><?=getAlbumTitle();?></h3>
  	<?php printAlbumDescAndLink(true); ?>
</div>
<?php	drawWongmAlbumNextables(false);  ?>    
<!-- Sub-Albums -->
<table class="centeredTable">
<?php 
  // neater for when only 4 items
  if (getNumSubAlbums() == 4)
  {
	  $i = 1;
  }
  else
  {
	  $i = 0;
  }
  while (next_album()):
  if ($i == 0)
  {
	  echo '<tr>';
  } ?>
	<td class="album" valign="top">
      <div class="albumthumb"><a href="<?=getAlbumLinkURL();?>" title="<?=getAlbumTitle();?>">
        <?php printAlbumThumbImage(getAlbumTitle()); ?></a></div>
      <div class="albumtitle"><h4><a href="<?=getAlbumLinkURL();?>" title="<?=getAlbumTitle();?>">
        <?php printAlbumTitle(); ?></a></h4><small><?php printAlbumDate(); ?></small></div>
      <div class="albumdesc"><?php printAlbumDesc(); ?></div>
    </td>
<?php if ($i == 2)
  {
	  echo '</tr>';
	  $i = 0;
  }
  else
  {
	  $i++; 
  }
  endwhile; ?>
</table>
<?php $num = getNumImages(); 
  if ($num > 0): /* Only print if we have images. */ ?>
<!-- Images -->
<table class="centeredTable">
  <?php 
  // neater for when only 4 items
  if ($num == 4)
  {
	  $i = 1;
  }
  else
  {
	  $i = 0;
  }
  while (next_image()):
  if ($i == 0)
  {
	  echo '<tr>';
  } ?>
  <td class="image" valign="top">
      <div class="imagethumb"><a href="<?=getImageLinkURL();?>" title="<?=getImageTitle();?>">
       <?php printImageThumb(getImageTitle()); ?></a></div>
      <div class="imagetitle"><h4><a href="<?=getImageLinkURL();?>" title="<?=getImageTitle();?>">
        <?php printImageTitle(); ?></a></h4><small><?php printImageDate(); ?></small></div>
    </td>  
<?php if ($i == 2)
  {
	  echo '</tr>';
	  $i = 0;
  }
  else
  {
	  $i++; 
  }
  endwhile; ?>
</table>
<?php endif; 
  
  drawWongmAlbumNextables(true);
  echo "<p>Viewed ".hitcounter('album')." times.</p>";
  include_once('footer.php'); 
?>