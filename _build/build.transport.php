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
 * sitemapFriend build script
 *
 * @package sitemapfriend
 * @subpackage build
 */
$mtime = microtime();
$mtime = explode(' ', $mtime);
$mtime = $mtime[1] + $mtime[0];
$tstart = $mtime;
set_time_limit(0);

define('PKG_NAME', 'sitemapFriend');
define('PKG_NAME_LOWER', strtolower(PKG_NAME));
define('PKG_VERSION', '1.0');
define('PKG_RELEASE', 'beta3');

$sources = array('root' => dirname(dirname(__FILE__)));
$sources['build'] = $sources['root'] . '/_build';
$sources['core'] = $sources['root'] . '/core/components/sitemapfriend';
$sources['docs'] = $sources['core'] . '/docs';
$sources['snippets'] = $sources['core'] . '/elements/snippets';
$sources['chunks'] = $sources['core'] . '/elements/chunks';
$sources['properties'] = $sources['build'] . '/properties';
$sources['lexicon'] = $sources['core'] . '/lexicon';

/* override with your own defines here (see build.config.sample.php) */
require_once dirname(__FILE__) . '/build.config.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

$modx = new modX();
$modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');

$modx->loadClass('transport.modPackageBuilder', '', false, true);

$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAME_LOWER, PKG_VERSION, PKG_RELEASE);
$builder->registerNamespace(PKG_NAME_LOWER, false, true,
  '{core_path}components/' . PKG_NAME_LOWER . '/');

/* create category */
$category = $modx->newObject('modCategory');
$category->set('id', 0);
$category->set('category', PKG_NAME);

/* create the chunks */

$chunkNames = array(
  array('sitemap_html_item', 'The default chunk used for each link displayed in an HTML site map.'),
  array('sitemap_html_container', 'The default chunk used for each group/folder of pages displayed in an HTML site map.'),
  array('sitemap_html_outer', 'The default chunk used for wrapping the entire list of pages in an HTML site map.'),
  array('sitemap_xml_item', 'The default chunk used for each link displayed in an XML site map.'),
  array('sitemap_xml_outer', 'The default chunk used for each group/folder of pages displayed in an XML site map.'),
);
$chunks = array();

$modx->log(modX::LOG_LEVEL_INFO,'Packaging chunks...');
foreach ($chunkNames as $id => $chunkInfo) {
  $chunkName = $chunkInfo[0];
  $chunkDesc = $chunkInfo[1];
  $chunk = $modx->newObject('modChunk');
  $chunk->set('id', $id);
  $chunk->set('name', $chunkName);

  $chunkName = strtolower($chunkName);

  $chunk->set('description', $chunkDesc);
  $chunk->setContent(file_get_contents($sources['chunks'] . "/$chunkName.chunk.tpl"));

  $chunks[] = $chunk;
}
$category->addMany($chunks);
unset($chunkNames, $chunks, $chunk, $properties, $chunkInfo, $chunkName, $chunkDesc);


/* create the snippet */

$snippetNames = array(
  array('sitemapFriend', 'Allows you to generate site maps as HTML, XML or other formats.'),
);
$snippets = array();

$modx->log(modX::LOG_LEVEL_INFO, 'Packaging snippets...');
foreach ($snippetNames as $id => $snippetInfo) {
  $snippetName = $snippetInfo[0];
  $snippetDesc = $snippetInfo[1];

  $snippet = $modx->newObject('modSnippet');
  $snippet->set('id', $id);
  $snippet->set('name', $snippetName);

  $snippetName = strtolower($snippetName);

  $snippet->set('description', $snippetDesc);
  $snippet->setContent(file_get_contents($sources['snippets'] . "/$snippetName.snippet.php"));

  $properties = include $sources['properties'] . "/snippet_$snippetName.inc.php";
  $snippet->setProperties($properties);

  $snippets[] = $snippet;
}
$category->addMany($snippets);
unset($snippetNames, $snippets, $snippet, $properties, $snippetInfo, $snippetName, $snippetDesc);

/* create category vehicle */
$attr = array(
  xPDOTransport::UNIQUE_KEY => 'category',
  xPDOTransport::PRESERVE_KEYS => false,
  xPDOTransport::UPDATE_OBJECT => true,
  xPDOTransport::RELATED_OBJECTS => true,
  xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array(
    'Chunks' => array(
      xPDOTransport::PRESERVE_KEYS => false,
      xPDOTransport::UPDATE_OBJECT => true,
      xPDOTransport::UNIQUE_KEY => 'name',
    ),
    'Snippets' => array(
      xPDOTransport::PRESERVE_KEYS => false,
      xPDOTransport::UPDATE_OBJECT => true,
      xPDOTransport::UNIQUE_KEY => 'name',
    ),
  ),
);

$modx->log(modX::LOG_LEVEL_INFO, 'Packaging vehicle...');
$vehicle = $builder->createVehicle($category, $attr);
$vehicle->resolve('file', array(
  'source' => $sources['core'],
  'target' => "return MODX_CORE_PATH . 'components/';",
));

$builder->putVehicle($vehicle);
unset($vehicle);

$modx->log(modX::LOG_LEVEL_INFO, 'Packaging lexicon...');
$builder->buildLexicon($sources['lexicon']);

/* now pack in the license file, readme and setup options */
$builder->setPackageAttributes(array(
  'license' => file_get_contents($sources['docs'] . '/license.txt'),
  'readme' => file_get_contents($sources['docs'] . '/readme.txt'),
));

$builder->pack();
unset($builder);

$mtime = microtime();
$mtime = explode(' ', $mtime);
$mtime = $mtime[1] + $mtime[0];
$tend = $mtime;
$totalTime = ($tend - $tstart);
$totalTime = sprintf('%2.4f s', $totalTime);

$modx->log(modX::LOG_LEVEL_INFO,
  "\n<br />Package Built.<br />\nExecution time: {$totalTime}\n");

exit();
