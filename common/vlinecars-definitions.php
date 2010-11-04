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
define ('LIVERY_PAGE', '/livery/#livery');

define ('TIME_FORMAT', '%B %d, %Y');

// site name
define ('SITE_NAME', 'V/LineCars.com');

// what positon are these links in the side menu bar?
// this is so they drop down automatically for the relevant sections
define ('NEWS_MENU_TAB', '0');
define ('CARRIAGES_MENU_TAB', '1');
define ('CARSETS_MENU_TAB', '2');
define ('LOCOMOTIVES_MENU_TAB', '3');
define ('RAILCARS_MENU_TAB', '4');
define ('OPERATIONS_MENU_TAB', '5');
define ('GALLERY_MENU_TAB', '7');
define ('MISC_MENU_TAB', '8');


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
			return 6;
		case 'Contact Me':
		case 'Sitemap':
		case 'Links':
		case 'Glossary':
		case 'About the Site':
			return MISC_MENU_TAB;
	}
		
	return '';
}

function printGoogleSearchBox()
{
?>
<form method="get" action="/search.php">
	<input name="q" size="50" id="query-input" autocomplete="off" />
	<button type="submit">Search</button>
</form>
<?php
}

?>