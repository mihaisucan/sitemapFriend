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
class sitemapFriend {
  public $config = array(
    'type' => 'html',
    'urlScheme' => 'abs',
    'startId' => 0,
    'contexts' => '',
    'showDeleted' => false,
    'showUnpublished' => false,
    'onlySearchable' => true,
    'showHidden' => true,
    'maxDepth' => 0,
    'onlyTemplates' => '',
    'skipTemplates' => '',
    'excludeResources' => '',
    'skipResources' => '',
    'includeResources' => '',
    'excludeChildrenOf' => '',
    'sortBy' => 'menuindex',
    'sortDir' => 'ASC',
    'parentTitles' => false,
    'parentTitlesReversed' => false,
    'titleSeparator' => ' - ',
    'tplItem' => 'sitemap_html_item',
    'tplContainer' => 'sitemap_html_container',
    'tplOuter' => 'sitemap_html_outer',
    'lastmodFormat' => 'F j, Y, g:i a', // March 10, 2001, 5:16 pm
  );

  protected $modx = null;
  protected $skipResources = array();
  protected $includeResources = array();
  protected $excludeChildrenOf = array();
  protected $queryWhere = array();
  protected $parentTitles = array();

  function __construct(modX &$modx, array &$config) {
    $this->modx =& $modx;

    $this->config = array_merge($this->config, $config);
    $this->config['type'] = strtolower($this->config['type']);

    if ($this->config['type'] != 'xml' &&
        $this->config['type'] != 'html') {
      $this->config['type'] = 'html';
    }

    // shorthand for XML sitemaps
    if ($this->config['type'] == 'xml') {
      $this->config['tplItem'] = 'sitemap_xml_item';
      $this->config['tplOuter'] = 'sitemap_xml_outer';
      $this->config['tplContainer'] = '';
      $this->config['urlScheme'] = 'full';
      $this->config['lastmodFormat'] = 'c';
    }
  }

  /**
   * Generate the entire site map.
   *
   * @access public
   * @return string The site map output, based on current configuration. Format
   * is entirely dependent on the chunks used.
   */
  public function run() {
    $this->parentTitles = array();
    $this->skipResources = array();
    $this->includeResources = array();
    $this->excludeChildrenOf = array();

    $this->queryWhere = array(
      'modResource.class_key:!=' => 'modWebLink',
    );

    if (!empty($this->config['contexts'])) {
      $this->queryWhere['modResource.context_key:IN'] =
        $this->prepareList($this->config['contexts']);
    } else {
      $this->queryWhere['modResource.context_key'] =
        $this->modx->context->get('key');
    }

    if (!empty($this->config['onlyTemplates'])) {
      $this->queryWhere['Template.id:IN'] =
        $this->prepareList($this->config['onlyTemplates']);
    }

    if (!empty($this->config['skipTemplates'])) {
      $skipTemplates = $this->prepareList($this->config['skipTemplates'], true);
      $this->queryWhere[1] = '`Template`.`id` NOT IN (' . $skipTemplates . ')';
      unset($skipTemplates);
    }

    if (!empty($this->config['excludeResources'])) {
      $excludeResources =
        $this->prepareList($this->config['excludeResources']);
    } else {
      $excludeResources = array();
    }

    // exclude self
    $excludeResources[] = $this->modx->resource->get('id');
    $site_start = $this->modx->getOption('site_start');
    $error_page = $this->modx->getOption('error_page');
    if ($error_page && $error_page != $site_start) {
      $excludeResources[] = $error_page;
    }

    $unauthorized_page = $this->modx->getOption('unauthorized_page');
    if ($unauthorized_page && $unauthorized_page != $site_start) {
      $excludeResources[] = $unauthorized_page;
    }
    $site_unavailable_page = $this->modx->getOption('site_unavailable_page');
    if ($site_unavailable_page && $site_unavailable_page != $site_start) {
      $excludeResources[] = $site_unavailable_page;
    }

    if (!empty($excludeResources)) {
      $excludeResources = implode('", "', array_unique($excludeResources));
      $this->queryWhere[2] = '`modResource`.`id` NOT IN ("' .
        $excludeResources . '")';
    }
    unset($excludeResources);

    if (!empty($this->config['skipResources'])) {
      $this->skipResources = $this->prepareList($this->config['skipResources']);
    }

    if (!empty($this->config['excludeChildrenOf'])) {
      $this->excludeChildrenOf = $this->prepareList($this->config['excludeChildrenOf']);
    }

    if (!empty($this->config['includeResources'])) {
      $this->includeResources = $this->prepareList($this->config['includeResources']);
    } else {
      if (!$this->config['showUnpublished']) {
        $this->queryWhere['published'] = 1;
      }

      if (!$this->config['showDeleted']) {
        $this->queryWhere['deleted'] = 0;
      }

      if ($this->config['onlySearchable']) {
        $this->queryWhere['searchable'] = 1;
      }

      if (!$this->config['showHidden']) {
        $this->queryWhere['hidemenu'] = 0;
      }
    }

    $output = $this->runDeep($this->config['startId']);
    if (!empty($this->config['tplOuter'])) {
      $props = array(
        'startId' => $this->config['startId'],
        'items' => $output,
      );
      $output = $this->getChunk('Outer', $props);
      unset($props);
    }

    $this->parentTitles = array();
    $this->queryWhere = array();
    $this->skipResources = array();
    $this->includeResources = array();
    $this->excludeChildrenOf = array();

    return $output;
  }

  /**
   * Run the sitemapFriend generation, recursively.
   *
   * @access protected
   * @param integer $currentParent The current parent resource the iteration
   * is on.
   * @return string The generated output.
   */
  protected function runDeep($currentParent = 0, $depth = 0) {
    if ($this->config['maxDepth'] > 0 && $depth > $this->config['maxDepth']) {
      return '';
    }

    $output = '';

    /* build query */
    $c = $this->modx->newQuery('modResource');
    $c->leftJoin('modResource', 'Children');
    $c->select('`modResource`.*, COUNT(`Children`.`id`) AS `children`');

    /* if restricting to templates */
    if (!empty($this->config['onlyTemplates']) || !empty($this->config['skipTemplates'])) {
      $c->innerJoin('modTemplate', 'Template');
    }

    $c->where(array('parent' => $currentParent));
    $c->where($this->queryWhere);

    /* sorting/grouping */
    $c->sortby($this->config['sortBy'], $this->config['sortDir']);
    $c->groupby('modResource.id');

    /* get collection */
    $collection = $this->modx->getCollection('modResource', $c);
    unset($c);

    /* iterate */
    foreach ($collection as $child) {
      $id = $child->get('id');
      if (!empty($this->includeResources)) {
        if (!in_array($id, $this->includeResources) &&
            ((!$this->config['showUnpublished'] && !$child->get('published')) ||
            (!$this->config['showDeleted'] && $child->get('deleted')) ||
            ($this->config['onlySearchable'] && !$child->get('searchable')) ||
            (!$this->config['showHidden'] && $child->get('hidemenu')))) {
              continue;
        }
      }

      $children = $child->get('children');

      if ($this->config['parentTitles']) {
        if ($this->config['parentTitlesReversed']) {
          array_unshift($this->parentTitles, $child->get('pagetitle'));
        } else {
          $this->parentTitles[] = $child->get('pagetitle');
        }
        $title = implode($this->config['titleSeparator'], $this->parentTitles);
      } else {
        $title = $child->get('pagetitle');
      }

      $props = array('items' => '');

      /* if children, recurse */
      if ($children > 0 && !in_array($id, $this->excludeChildrenOf)) {
        $props['items'] = $this->runDeep($id, $depth + 1);
      }

      // skip this resource if needed
      if (!in_array($id, $this->skipResources)) {
        $url = $this->modx->makeUrl($id, '', '', $this->config['urlScheme']);

        $lastmod = $child->get('editedon');
        if (!$lastmod) {
          $lastmod = $child->get('publishedon');
          if (!$lastmod) {
            $lastmod = $child->get('createdon');
          }
        }
        $lastmod = strtotime($lastmod);

        $props['parent'] = $currentParent;
        $props['id'] = $id;
        $props['url'] = $url;
        $props['lastmod'] = date($this->config['lastmodFormat'], $lastmod);
        $props['title'] = $title;

        if ($this->config['type'] == 'xml') {
          $datediff = floor((time() - $lastmod) / 86400);
          if ($datediff <= 1) {
            $priority = '1.0';
            $changefreq = 'daily';
          } else if (($datediff > 1) && ($datediff <= 7)) {
            $priority = '0.75';
            $changefreq = 'weekly';
          } else if (($datediff > 7) && ($datediff <= 30)) {
            $priority = '0.50';
            $changefreq = 'weekly';
          } else {
            $priority = '0.25';
            $changefreq = 'monthly';
          }
          $props['changefreq'] = $changefreq;
          $props['priority'] = $priority;
          // escape ampersand as per http://www.w3.org/TR/REC-xml/#syntax
          $props['title'] = preg_replace('/&/', '&amp;', $props['title']);
        }

        $output .= $this->getChunk('Item', $props);
      } else {
        $output .= $props['items'];
      }

      if ($this->config['parentTitles']) {
        if ($this->config['parentTitlesReversed']) {
          array_shift($this->parentTitles);
        } else {
          array_pop($this->parentTitles);
        }
      }
    }
    unset($child, $collection);

    if ($depth > 0 && !empty($this->config['tplContainer'])) {
      $props = array(
        'depth' => $depth,
        'id' => $currentParent,
        'items' => $output,
      );
      $output = $this->getChunk('Container', $props);
    }
    unset($props);

    return $output;
  }

  /**
   * Prepares a comma-separated list for a query.
   *
   * @access protected
   * @param string $str The comma-separated list to prepare.
   * @param boolean $resultAsString Tells if you want the list as a string. If
   * false, this method returns an array.
   * @return Array|string The prepared array, or the comma-separated string 
   * prepared for the SQL query.
   */
  protected function prepareList($str, $resultAsString = false) {
    $arr = array_map('trim', explode(',', $str));
    if ($resultAsString) {
      return '"' . implode('", "', $arr) . '"';
    } else {
      return $arr;
    }
  }

  /**
   * Get the output of a chunk.
   *
   * @access protected
   * @param string $name The name of the chunk.
   * @param array $properties The properties for the chunk.
   * @return string The processed content of the chunk.
   */
  protected function getChunk($name, &$properties) {
    $chunk = null;
    if (!empty($this->config["tpl$name"])) {
      $chunk = $this->modx->getObject('modChunk',
        array('name' => $this->config["tpl$name"]));
    }

    if (!empty($chunk)) {
      $chunk->setCacheable(false);
      return $chunk->process($properties);
    } else {
      return '';
    }
  }
}

// vim:set fo=anqrowcb tw=80 ts=2 sw=2 sts=2 sta et noai nocin fenc=utf-8 ff=unix:
