<?php

// various URLs to bits and pieces
define ('CARRIAGE_NUMBER_PAGE', '/carriage/number/');
define ('CARRIAGE_TYPE_PAGE', '/carriage/type/');
define ('CARSET_NUMBER_PAGE', '/carset/number/');
define ('CARSET_TYPE_PAGE', '/carset/type/');
define ('RAILCAR_NUMBER_PAGE', '/railcar/number/');
define ('RAILCAR_TYPE_PAGE', '/railcar/type/');

define ('CARRIAGES_BY_NUMBER_PAGE', '/carriages/by-number');
define ('CARRIAGES_BY_TYPE_PAGE', '/carriages/by-type');
define ('CARSETS_BY_NUMBER_PAGE', '/carsets/by-number');
define ('CARSETS_BY_TYPE_PAGE', '/carsets/by-type');
define ('RAILCARS_BY_NUMBER_PAGE', '/railcars/by-number');
define ('RAILCARS_BY_TYPE_PAGE', '/railcars/by-type');

define ('LOCOMOTIVE_NUMBER_PAGE', '/locomotive/number/');
define ('LOCOMOTIVE_CLASS_PAGE', '/locomotives/');

define ('STATION_PAGE', '/region/station/');
define ('LIVERY_PAGE', '/liveries');

if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
	define ('DATE_FORMAT', '%#d %B, %Y');
} else {
	define ('DATE_FORMAT', '%e %B, %Y');
}

// site name
define ('SITE_NAME', 'V/LineCars.com');

define ('RANDOM_MAX', 9);

// what positon are these links in the side menu bar?
// this is so they drop down automatically for the relevant sections
define ('NEWS_MENU_TAB', '0');
define ('CARRIAGES_MENU_TAB', '1');
define ('CARSETS_MENU_TAB', '2');
define ('LOCOMOTIVES_MENU_TAB', '3');
define ('RAILCARS_MENU_TAB', '4');
define ('OPERATIONS_MENU_TAB', '5');
//define ('REGIONS_MENU_TAB', '6');
define ('GALLERY_MENU_TAB', '6');
define ('MISC_MENU_TAB', '7');


// get what position in the sidebar a given item is
// this is so they drop down automatically for the relevant sections
/// based upon the page title
function getMenuIndex($pageTitle)
{
	$persistanceMenu = split(' - ', $pageTitle);
	switch ($pageTitle[0][0])
	{
		case 'Carriages':
			return CARRIAGES_MENU_TAB;
		case 'Carriage Sets':
			return CARSETS_MENU_TAB;
		case 'Locomotives':
			return LOCOMOTIVES_MENU_TAB;
		case 'Railcars':
			return RAILCARS_MENU_TAB;	
		case 'Operations':
			return OPERATIONS_MENU_TAB;
		case 'Regions':
		case 'Stations':
			return REGIONS_MENU_TAB;
		case 'Contact Me':
		case 'Site Map':
		case 'Links':
		case 'Glossary':
		case 'About the Site':
			return MISC_MENU_TAB;
	}
		
	return '';
}

function printGoogleSearchBox()
{
	// if we are on the search results page
	// then include the search term in the box
	if (strpos($_SERVER['PHP_SELF'], 'search.php') > 0)
	{
		$value = $_GET['q'];
	}
?>
<form method="get" action="/misc/search">
	<input name="q" size="50" value="<?php echo $value; ?>" id="query-input" autocomplete="off" />
	<button type="submit">Search</button>
</form>
<?php
}

?>