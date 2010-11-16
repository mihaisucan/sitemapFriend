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
 * @package sitemapfriend
 */
$properties = array(
    array(
        'name' => 'type',
        'desc' => 'prop.type',
        'type' => 'list',
        'options' => array(
          array('name' => 'HTML', 'value' => 'html'),
          array('name' => 'XML', 'value' => 'xml'),
        ),
        'value' => 'html',
    ),
    array(
        'name' => 'urlScheme',
        'desc' => 'prop.urlScheme',
        'type' => 'list',
        'options' => array(
          array('name' => 'Relative', 'value' => -1),
          array('name' => 'Absolute', 'value' => 'abs'),
          array('name' => 'Full',     'value' => 'full'),
        ),
        'value' => 'abs',
    ),
    array(
        'name' => 'startId',
        'desc' => 'prop.startId',
        'type' => 'numberfield',
        'options' => '',
        'value' => 0,
    ),
    array(
        'name' => 'contexts',
        'desc' => 'prop.contexts',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
    ),
    array(
        'name' => 'showDeleted',
        'desc' => 'prop.showDeleted',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => false,
    ),
    array(
        'name' => 'showUnpublished',
        'desc' => 'prop.showUnpublished',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => false,
    ),
    array(
        'name' => 'onlySearchable',
        'desc' => 'prop.onlySearchable',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => true,
    ),
    array(
        'name' => 'showHidden',
        'desc' => 'prop.showHidden',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => true,
    ),
    array(
        'name' => 'maxDepth',
        'desc' => 'prop.maxDepth',
        'type' => 'numberfield',
        'options' => '',
        'value' => 0,
    ),
    array(
        'name' => 'onlyTemplates',
        'desc' => 'prop.onlyTemplates',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
    ),
    array(
        'name' => 'skipTemplates',
        'desc' => 'prop.skipTemplates',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
    ),
    array(
        'name' => 'excludeResources',
        'desc' => 'prop.excludeResources',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
    ),
    array(
        'name' => 'skipResources',
        'desc' => 'prop.skipResources',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
    ),
    array(
        'name' => 'includeResources',
        'desc' => 'prop.includeResources',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
    ),
    array(
        'name' => 'sortBy',
        'desc' => 'prop.sortBy',
        'type' => 'textfield',
        'options' => '',
        'value' => 'menuindex',
    ),
    array(
        'name' => 'sortDir',
        'desc' => 'prop.sortDir',
        'type' => 'list',
        'options' => array(
          array('name' => 'Ascending', 'value' => 'ASC'),
          array('name' => 'Descending', 'value' => 'DESC'),
        ),
        'value' => 'ASC',
    ),
    array(
        'name' => 'parentTitles',
        'desc' => 'prop.parentTitles',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => false,
    ),
    array(
        'name' => 'parentTitlesReversed',
        'desc' => 'prop.parentTitlesReversed',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => false,
    ),
    array(
        'name' => 'titleSeparator',
        'desc' => 'prop.titleSeparator',
        'type' => 'textfield',
        'options' => '',
        'value' => ' - ',
    ),
    array(
        'name' => 'tplItem',
        'desc' => 'prop.tplItem',
        'type' => 'textfield',
        'options' => '',
        'value' => 'sitemap_html_item',
    ),
    array(
        'name' => 'tplContainer',
        'desc' => 'prop.tplContainer',
        'type' => 'textfield',
        'options' => '',
        'value' => 'sitemap_html_container',
    ),
    array(
        'name' => 'tplOuter',
        'desc' => 'prop.tplOuter',
        'type' => 'textfield',
        'options' => '',
        'value' => 'sitemap_html_outer',
    ),
    array(
        'name' => 'lastmodFormat',
        'desc' => 'prop.lastmodFormat',
        'type' => 'textfield',
        'options' => '',
        'value' => 'F j, Y, g:i a',
    ),
);

return $properties;
