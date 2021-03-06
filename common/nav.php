<div class="arrowlistmenu">
<?php
// we are looking at the normal navmanu form
if (!isset($navclass))
{
	$navclass = 'menuheader xpand';
}
// otherwise add custom stuff for sitemap
else
{
?>
<p class="menuheader">Home</p>
<ul class="menuitem">
<li><a href="/">Welcome</a></li>
</ul>
<?php
}
?>
<p class="<?php echo $navclass; ?>">News</p>
<ul class="menuitem">
<li><a href="/news">News Index</a></li>
<li><a href="/news/category/media">In the Media</a></li>
</ul>
<p class="<?php echo $navclass; ?>">Carriages &amp; Vans</p>
<ul class="menuitem">
<li><a href="/carriages">Carriage Index</a></li>
<li><a href="<?=CARRIAGES_BY_NUMBER_PAGE?>">By number</a></li>
<li><a href="<?=CARRIAGES_BY_TYPE_PAGE?>">By type</a></li>
<li><a href="/carriages/h-type">H Type Carriages</a></li>
<li><a href="/carriages/n-type">N Type Carriages</a></li>
<li><a href="/carriages/s-type">S Type Carriages</a></li>
<li><a href="/carriages/z-type">Z Type Carriages</a></li>
<li><a href="/carriages/loose-cars">Loose, Special &amp; Stored Carriages</a></li>
<li><a href="/carriages/parcel-vans">Parcel Vans</a></li>
<li><a href="/carriages/power-vans">Power Vans</a></li>
</ul>
<p class="<?php echo $navclass; ?>">Carriage Sets</p>
<ul class="menuitem">
<li><a href="/carsets">Carriage Sets Index</a></li>
<li><a href="<?=CARSETS_BY_NUMBER_PAGE?>">By number</a></li>
<li><a href="<?=CARSETS_BY_TYPE_PAGE?>">By type</a></li>
<li><a href="/carsets/h-type">H Type Carriage Sets</a></li>
<li><a href="/carsets/n-type">N Type Carriage Sets</a></li>
<li><a href="/carsets/s-type">S Type Carriage Sets</a></li>
<li><a href="/carsets/z-type">Z Type Carriage Sets</a></li>
</ul>
<p class="<?php echo $navclass; ?>">Locomotives</p>
<ul class="menuitem">
<li><a href="/locomotives">Locomotives Index</a></li>
<li><a href="<?=LOCOMOTIVE_CLASS_PAGE?>a-class">A Class Locomotives</a></li>
<li><a href="<?=LOCOMOTIVE_CLASS_PAGE?>n-class">N Class Locomotives</a></li>
<li><a href="<?=LOCOMOTIVE_CLASS_PAGE?>p-class">P Class Locomotives</a></li>
<li><a href="<?=LOCOMOTIVE_CLASS_PAGE?>y-class">Y Class Locomotives</a></li>
</ul>
<p class="<?php echo $navclass; ?>">Railcars/DMUs</p>
<ul class="menuitem">
<li><a href="/railcars">Railcars Index</a></li>
<li><a href="/railcars/sprinter">Sprinters</a></li>
<li><a href="/railcars/vlocity">VLocities</a></li>
</ul>
<p class="<?php echo $navclass; ?>">Operations</p>
<ul class="menuitem">
<li><a href="/operations">Operations Index</a></li>
<li><a href="/operations/service-summaries">Service Summaries</a></li>
<li><a href="/operations/timetables">Timetables</a></li>
<li><a href="/operations/additional-services">Additional Services</a></li>
<li><a href="/operations/altered-services">Altered Services</a></li>
<li><a href="/operations/special-services">Special Services</a></li>
<li><a href="/operations/maintenance">Maintenance</a></li>
<li><a href="/operations/accidents">Accidents And Derailments</a></li>
</ul>
<? /*
<p class="<?php echo $navclass; ?>">Regions</p>
<ul class="menuitem">
<li><a href="/regions">Regions Index</a></li>
<li><a href="/region/central">Central/Metro Region</a></li>
<li><a href="/region/eastern">Eastern Region</a></li>
<li><a href="/region/north-eastern">North Eastern Region</a></li>
<li><a href="/region/northern">Northern Region</a></li>
<li><a href="/region/south-western">South Western Region</a></li>
<li><a href="/region/western">Western Region</a></li>
</ul>
*/ ?>
<p class="<?php echo $navclass; ?>">Media</p>
<ul class="menuitem">
<li><a href="/gallery">Photo Gallery</a></li>
<li><a href="/gallery/recent">Recent Uploads</a></li>
<li><a href="/gallery/page/search">Photo Search</a></li>
<? /*
<li><a href="">Video</a></li>
*/ ?>
</ul>
<p class="<?php echo $navclass; ?>">Other</p>
<ul class="menuitem">
<li><a href="/misc/about">About the Site</a></li>
<li><a href="/forums" target="_blank">Forums</a></li>
<li><a href="/misc/contact">Contact Us</a></li>
<li><a href="/misc/glossary">Glossary</a></li>
<li><a href="/liveries">Liveries</a></li>
<li><a href="/misc/links">Links</a></li>
<li><a href="/misc/sitemap">Site Map</a></li>
</ul>
</div>