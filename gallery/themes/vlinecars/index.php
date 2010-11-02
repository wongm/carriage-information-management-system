<?php 
include_once('header.php'); ?>
<?php echo getGalleryTitle(); ?>
<?php 
include_once('midbit.php'); 
?>
<div class="topbar">
  	<h3>Welcome to <?php echo getGalleryTitle(); ?></h3>
  	<p><?php printGalleryDesc(); ?></p>
<? if(function_exists("printAllNewsCategories"))
{
	printAllNewsCategories("View news items",TRUE,"","menu-active");
	printPageMenu("list","","menu-active","submenu","menu-active");
}
?>
</div>

<?php drawWongmAlbumNextables(false); ?>
  
<table class="centeredTable">
<?php 
  $i = 0;
  
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
	drawWongmAlbumNextables(true);
	include_once('footer.php'); 
?>