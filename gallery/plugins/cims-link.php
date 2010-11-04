<?php
if (!defined('OFFSET_PATH')) define('OFFSET_PATH', 3);

$plugin_is_filter = -5;
$plugin_description = gettext("Link to CIMS interface.");
$plugin_author = "Marcus Wong (wongm)";
$plugin_version = '1.0.0'; 

//require_once(dirname(dirname(__FILE__)).'/functions.php');

zp_register_filter('admin_utilities_buttons', 'cims_link_button');
zp_register_filter('admin_toolbox_album', 'addAlbumLink');
zp_register_filter('admin_toolbox_global', 'addGlobalLink');

/**
 * creates the Utilities button to purge the static html cache
 * @param array $buttons
 * @return array
 */
function cims_link_button($buttons) {
	$buttons[] = array(
		'enable'=>true,
		'button_text'=>gettext('CIMS interface'),
		'formname'=>'cims_button',
		'action'=>'/backend',
		'icon'=>'images/redo.png',
		'title'=>gettext('Go to the CIMS interface.'),
		'alt'=>'',
		'rights'=> ADMIN_RIGHTS
		);
	return $buttons;
}

function addAlbumLink($albumname) {
	echo "<li>";
	printLink(WEBPATH.'/' . ZENFOLDER . '/admin-edit-small.php?page=edit&tab=imageinfo&album=' . urlencode($albumname), 'Edit images', NULL, NULL, NULL);
	echo "</li>";
}

function addGlobalLink() {
	echo "<li>";
	printLink(WEBPATH.'/' . ZENFOLDER . '/zp-extensions/static_html_cache.php?action=clear_html_cache', 'Clear cache', NULL, NULL, NULL);
	echo "</li>";
}
?>