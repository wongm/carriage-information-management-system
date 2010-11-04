<?php
include_once('header.php'); ?>
<?php echo getGalleryTitle(); ?>
<?php
include_once('midbit.php');
?>
<div class="topbar">
  	<h2><?php echo getGalleryTitle(); ?></h2>
  	<p><?php printGalleryDesc(); ?></p>
</div>
<table class="centeredTable">
<?php
  $i = 0;

  while (next_album()):
	  if ($i == 0)
	  {
		  echo '<tr>';
	  }
?>
    <td class="album" valign="top">
      <div class="albumthumb"><a href="<?php echo getAlbumLinkURL();?>" title="<?=getAlbumTitle();?>">
        <?php printAlbumThumbImage(getAlbumTitle()); ?></a></div>
      <div class="albumtitle"><h4><a href="<?php echo getAlbumLinkURL();?>" title="<?=getAlbumTitle();?>">
        <?php printAlbumTitle(); ?></a></h4><small><?php printAlbumDate(); ?></small></div>
      <div class="desc"><?php printAlbumDesc(); ?></div>
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
  endwhile;

   ?>
</table>

<?php
	include_once('footer.php');
?>