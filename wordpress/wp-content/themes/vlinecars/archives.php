<?php
/*
Template Name: Archives
*/
?>
<?php get_header(); ?>
<h2>News Archives</h2>
<div id="content" class="widecolumn">
<h3>By month:</h3>
  <ul>
    <?php wp_get_archives('type=monthly'); ?>
  </ul>

<h3>By subject:</h3>
  <ul>
     <?php wp_list_cats(); ?>
  </ul>

</div>

<?php get_footer(); ?>
