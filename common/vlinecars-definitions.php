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
define ('GALLERY_MENU_TAB', '7');

// get what position in the sidebar a given item is
// this is so they drop down automatically for the relevant sections
/// based upon the page title
function getMenuIndex($pageTitle)
{
	$persistanceMenu = split(' - ', $pageTitle);
	switch ($pageTitle[0][0])
	{
		case 'Carriages':
			return  1;
		case 'Carriage Sets':
			return  2;
		case 'Locomotives':
			return  3;
		case 'Railcars':
			return  4;	
		case 'Operations':
			return  5;	
		case 'Regions':
		case 'Stations':
			return  6;
		case 'Contact Me':
		case 'Sitemap':
		case 'Links':
		case 'Glossary':
		case 'About the Site':
			return  8;
	}
		
	return '';
}

?>