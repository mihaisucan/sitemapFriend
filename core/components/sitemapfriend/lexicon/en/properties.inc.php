<?php
/**
 * sitemapFriend
 *
 * Copyright (c) 2010 Mihai Șucan <mihai.sucan@gmail.com>.
 *
 * - Based on GoogleSiteMap by Shaun McCormick <shaun@modx.com>.
 *
 * This file is part of sitemapFriend.
 *
 * sitemapFriend is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * sitemapFriend is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * sitemapFriend; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package sitemapfriend
 */

/**
 * Properties English Topic for sitemapFriend.
 *
 * @package sitemapfriend
 * @subpackage lexicon
 * @language en
 */
$_lang['prop.type'] = 'The type of sitemap you want: xml or html. Depending on the choice you make, the other properties change their default value.';
$_lang['prop.urlScheme'] = 'The URL scheme you want: http, https, full, abs, etc. See the $modx->makeUrl() documentation. Default for HTML type: abs. For XML type, the urlScheme is always full.';
$_lang['prop.startId'] = 'Build the site map starting from the given resource ID. Default value: 0';
$_lang['prop.contexts'] = 'Limit to the specified context(s). If empty, will grab resources from current Context. Defaults to empty, can support a comma-separated list.';
$_lang['prop.showDeleted'] = 'If true, will include deleted resources. Default is false.';
$_lang['prop.showUpublished'] = 'If true, will include unpublished resources. Default is false.';
$_lang['prop.onlySearchable'] = 'If true, will only include searchable resources. Default is true.';
$_lang['prop.showHidden'] = 'If true, will include resources which are not visible in menus. Default is true.';
$_lang['prop.maxDepth'] = 'The maximum depth down the tree to grab resources from. If set to empty or 0, will grab all resources.';
$_lang['prop.onlyTemplates'] = 'A comma-separated list of template IDs to filter by. Will only filter if a value is set.';
$_lang['prop.skipTemplates'] = 'A comma-separated list of template IDs to skip. Will only filter if a value is set.';
$_lang['prop.excludeResources'] = 'A comma-separated list of resources to exclude entirely from the site map. Child resources will also be excluded. The resources pointed at by the modx options error_page, site_unavailable_page, unauthorized_page and the site map page itself are always excluded.';
$_lang['prop.skipResources'] = 'A comma-separated list of resources to hide from the site map. Child resources will NOT be excluded.';
$_lang['prop.includeResources'] = 'A comma-separated list of resources to always include in the site map, even if the given resource would otherwise be filtered out by the showDeleted, showUnpublished, onlySearchable and showHidden options.';
$_lang['prop.parentTitles'] = 'Include parent resource titles in the site map. Default value: false.';
$_lang['prop.parentTitlesReversed'] = 'If parent resource titles are used, then this tells if the titles should be in a reversed order. Default is false.';
$_lang['prop.titleSeparator'] = 'If parent resource titles are used, then this tells the titles separator string. The default string is \' - \'.';
$_lang['prop.sortBy'] = 'The field to sort the results by. Default value: menuindex.';
$_lang['prop.sortDir'] = 'The direction to sort in. Default value: ASC.';
$_lang['prop.tplItem'] = 'The chunk to use for each result item. Default for HTML type: sitemap_html_item. sitemap_xml_item is always used for the XML type.';
$_lang['prop.tplContainer'] = 'The chunk to use as a container for each resource container - a resource that has children. This is always empty for XML type.';
$_lang['prop.tplOuter'] = 'The chunk to use as an outer container for the entire site map. Default for HTML type: sitemap_html_outer. sitemap_xml_outer is always used for the XML type.';
$_lang['prop.lastmodFormat'] = 'Last modification date format. This uses the same format as the PHP date() function. Default for HTML type: F j, Y, g:i a. For the XML type the "c" value is always used (ISO 8601 date format).';
