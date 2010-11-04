<?php

/**
 * Prints excerpts of the direct subpages (1 level) of a page for a kind of overview. The setup is:
 * <div class='pageexcerpt'>
 * <h4>page title</h3>
 * <p>page content excerpt</p>
 * <p>read more</p>
 * </div>
 *
 * @param int $excerptlength The length of the page content, if nothing specifically set, the plugin option value for 'news article text length' is used
 * @param string $readmore The text for the link to the full page. If empty the read more setting from the options is used.
 * @param string $shortenindicator The optional placeholder that indicates that the content is shortened, if this is not set the plugin option "news article text shorten indicator" is used.
 * @return string
 */
function printCimsSubPagesExcerpts($excerptlength='', $readmore='', $shortenindicator='') {
	global  $_zp_current_zenpage_page;
	if(empty($readmore)) {
		$readmore = get_language_string(getOption("zenpage_read_more"));
	}
	if((zp_loggedin(ZENPAGE_PAGES_RIGHTS))) {
		$published = FALSE;
	} else {
		$published = TRUE;
	}
	$pages = getPages($published);
	$subcount = 0;
	if(empty($excerptlength)) {
		$excerptlength = getOption("zenpage_text_length");
	}
	foreach($pages as $page) {
		$pageobj = new ZenpagePage($page['titlelink']);
		if($pageobj->getParentid() == getPageID()) {
			$subcount++;
			$pagetitle = $pageobj->getTitle();
			$pagecontent = $pageobj->getContent();
			$hint = $show = '';
			if(!checkPagePassword($pageobj, $hint, $show) && $published) {
				$pagecontent = '<p><em>'.gettext('This page is password protected').'</em></p>';
			} else {
				if(stristr($pagecontent,"<!-- pagebreak -->") !== FALSE) {
					$array = explode("<!-- pagebreak -->",$pagecontent);
					//$shortenindicator .= $readmorelink;
					//$pagecontent = shortenContent($array[0], strlen($array[0]), $shortenindicator);
					$pagecontent = getNewsContentShorten($array[0], strlen($array[0]),$shortenindicator,cleanupLink(getPageLinkURL($page['titlelink'])));
					if ($shortenindicator && count($array) <= 1 || ($array[1] == '</p>' || trim($array[1]) =='')) {
						$pagecontent = str_replace($shortenindicator, '', $pagecontent);
					}
				} else if(strlen($pagecontent) > $excerptlength) {
					$pagecontent = getNewsContentShorten($pagecontent, $excerptlength, $shortenindicator,cleanupLink(getPageLinkURL($page['titlelink'])));
				}
			}
			echo "\n<div class='pageexcerpt'>\n";
			echo "<h4><a href=\"".cleanupLink(getPageLinkURL($page['titlelink']))."\" title=\"".strip_tags($pagetitle)."\">".$pagetitle."</a></h4>";
			echo $pagecontent;
			echo "</div>\n";
		}
	}
}


/**
 * Prints the parent pages breadcrumb navigation for the current page
 *
 * @param string $before Text to place before the breadcrumb item
 * @param string $after Text to place after the breadcrumb item
 */
function printCimsParentPagesBreadcrumb($before='', $after='') {
	$parentid = getPageParentID();
	$parentpages = getParentPages($parentid);
	foreach($parentpages as $parentpage) {
		$parentobj = new ZenpagePage($parentpage);
		echo $before."<a href='".htmlspecialchars(cleanupLink(getPageLinkURL($parentpage)))."'>".htmlspecialchars($parentobj->getTitle())."</a>".$after;
	}
}

function cleanupLink($link)
{
	return str_replace('/gallery/pages', '', $link);
}
?>