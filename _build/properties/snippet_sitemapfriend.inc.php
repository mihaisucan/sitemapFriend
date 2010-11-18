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
        'desc' => 'type',
        'type' => 'list',
        'options' => array(
          array('name' => 'HTML', 'value' => 'html'),
          array('name' => 'XML', 'value' => 'xml'),
        ),
        'value' => 'html',
        'lexicon' => PKG_NAME_LOWER . ':properties',
    ),
    array(
        'name' => 'urlScheme',
        'desc' => 'urlScheme',
        'type' => 'list',
        'options' => array(
          array('name' => 'Relative', 'value' => -1),
          array('name' => 'Absolute', 'value' => 'abs'),
          array('name' => 'Full',     'value' => 'full'),
        ),
        'value' => 'abs',
        'lexicon' => PKG_NAME_LOWER . ':properties',
    ),
    array(
        'name' => 'startId',
        'desc' => 'startId',
        'type' => 'numberfield',
        'options' => '',
        'value' => 0,
        'lexicon' => PKG_NAME_LOWER . ':properties',
    ),
    array(
        'name' => 'contexts',
        'desc' => 'contexts',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => PKG_NAME_LOWER . ':properties',
    ),
    array(
        'name' => 'showDeleted',
        'desc' => 'showDeleted',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => false,
        'lexicon' => PKG_NAME_LOWER . ':properties',
    ),
    array(
        'name' => 'showUnpublished',
        'desc' => 'showUnpublished',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => false,
        'lexicon' => PKG_NAME_LOWER . ':properties',
    ),
    array(
        'name' => 'onlySearchable',
        'desc' => 'onlySearchable',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => true,
        'lexicon' => PKG_NAME_LOWER . ':properties',
    ),
    array(
        'name' => 'showHidden',
        'desc' => 'showHidden',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => true,
        'lexicon' => PKG_NAME_LOWER . ':properties',
    ),
    array(
        'name' => 'maxDepth',
        'desc' => 'maxDepth',
        'type' => 'numberfield',
        'options' => '',
        'value' => 0,
        'lexicon' => PKG_NAME_LOWER . ':properties',
    ),
    array(
        'name' => 'onlyTemplates',
        'desc' => 'onlyTemplates',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => PKG_NAME_LOWER . ':properties',
    ),
    array(
        'name' => 'skipTemplates',
        'desc' => 'skipTemplates',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => PKG_NAME_LOWER . ':properties',
    ),
    array(
        'name' => 'excludeResources',
        'desc' => 'excludeResources',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => PKG_NAME_LOWER . ':properties',
    ),
    array(
        'name' => 'skipResources',
        'desc' => 'skipResources',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => PKG_NAME_LOWER . ':properties',
    ),
    array(
        'name' => 'includeResources',
        'desc' => 'includeResources',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => PKG_NAME_LOWER . ':properties',
    ),
    array(
        'name' => 'sortBy',
        'desc' => 'sortBy',
        'type' => 'textfield',
        'options' => '',
        'value' => 'menuindex',
        'lexicon' => PKG_NAME_LOWER . ':properties',
    ),
    array(
        'name' => 'sortDir',
        'desc' => 'sortDir',
        'type' => 'list',
        'options' => array(
          array('name' => 'Ascending', 'value' => 'ASC'),
          array('name' => 'Descending', 'value' => 'DESC'),
        ),
        'value' => 'ASC',
        'lexicon' => PKG_NAME_LOWER . ':properties',
    ),
    array(
        'name' => 'parentTitles',
        'desc' => 'parentTitles',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => false,
        'lexicon' => PKG_NAME_LOWER . ':properties',
    ),
    array(
        'name' => 'parentTitlesReversed',
        'desc' => 'parentTitlesReversed',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => false,
        'lexicon' => PKG_NAME_LOWER . ':properties',
    ),
    array(
        'name' => 'titleSeparator',
        'desc' => 'titleSeparator',
        'type' => 'textfield',
        'options' => '',
        'value' => ' - ',
        'lexicon' => PKG_NAME_LOWER . ':properties',
    ),
    array(
        'name' => 'tplItem',
        'desc' => 'tplItem',
        'type' => 'textfield',
        'options' => '',
        'value' => 'sitemap_html_item',
        'lexicon' => PKG_NAME_LOWER . ':properties',
    ),
    array(
        'name' => 'tplContainer',
        'desc' => 'tplContainer',
        'type' => 'textfield',
        'options' => '',
        'value' => 'sitemap_html_container',
        'lexicon' => PKG_NAME_LOWER . ':properties',
    ),
    array(
        'name' => 'tplOuter',
        'desc' => 'tplOuter',
        'type' => 'textfield',
        'options' => '',
        'value' => 'sitemap_html_outer',
        'lexicon' => PKG_NAME_LOWER . ':properties',
    ),
    array(
        'name' => 'lastmodFormat',
        'desc' => 'lastmodFormat',
        'type' => 'textfield',
        'options' => '',
        'value' => 'F j, Y, g:i a',
        'lexicon' => PKG_NAME_LOWER . ':properties',
    ),
);

return $properties;
