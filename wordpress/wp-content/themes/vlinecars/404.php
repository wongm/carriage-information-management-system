<?php get_header(); ?>

	<div id="content" class="narrowcolumn">
		<h2>Error 404 - Not Found</h2>
	</div>
	
<?php 
$type = $_GET['type'];

switch ($type)
{
	case 'base':
	case 'misc':
		$breadcrumb = '/';
		break;
	case 'operations':
		$breadcrumb = '/operations/';
		break;
	default:
		$breadcrumb = '/news/';
		break;
}
?>
	
	<p><a href="<?php echo $breadcrumb; ?>">Return home</a></p>

<?php get_footer(); ?>