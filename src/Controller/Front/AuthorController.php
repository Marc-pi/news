<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt New BSD License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */
namespace Module\News\Controller\Front;

use Pi;
use Pi\Filter;
use Pi\Mvc\Controller\ActionController;

class AuthorController extends ActionController
{
    public function indexAction()
    {
        // Get info from url
        $module = $this->params('module');
        $slug = $this->params('slug');
        // Get config
        $config = Pi::service('registry')->config->read($module);
        // Get topic or homepage setting
        $topic = Pi::api('topic', 'news')->canonizeTopic();
        // Get topic information from model
        $author = $this->getModel('author')->find($slug, 'slug');
        $author = Pi::api('author', 'news')->canonizeAuthor($author);
        // Check status
        if (!$author || $author['status'] != 1) {
            $url = array('', 'module' => $module, 'controller' => 'index', 'action' => 'index');
            $this->jump($url, __('The author not found.'));
        }
        // Get role
        $roles = Pi::api('author', 'news')->getFormRole();
        // Get story
        $storyList = Pi::api('author', 'news')->getStoryList($author['id'], $roles);
        // Set view
        $this->view()->headTitle($author['seo_title']);
        $this->view()->headdescription($author['seo_description'], 'set');
        $this->view()->headkeywords($author['seo_keywords'], 'set');
        $this->view()->setTemplate('author-index');
        $this->view()->assign('stores', $storyList);
        $this->view()->assign('author', $author);
        $this->view()->assign('roles', $roles);
        $this->view()->assign('topic', $topic);
        $this->view()->assign('config', $config);
    }

    public function listAction()
    {
        // Get page
        $page = $this->params('page', 1);
        $module = $this->params('module');
        // Get config
        $config = Pi::service('registry')->config->read($module);
        // Set info
        $order = array('title ASC', 'id ASC');
        $where = array('status' => 1);
        $author = array();
        // Get list of author
        $select = $this->getModel('author')->select()->where($where)->order($order);
        $rowset = $this->getModel('author')->selectWith($select);
        // Make list
        foreach ($rowset as $row) {
            $author[$row->id] = Pi::api('author', 'news')->canonizeAuthor($row);
        }
        // Set header and title
        $title = __('List of all authors');
        // Set seo_keywords
        $filter = new Filter\HeadKeywords;
        $filter->setOptions(array(
            'force_replace_space' => true
        ));
        $seoKeywords = $filter($title);
        // Set view
        $this->view()->headTitle($title);
        $this->view()->headDescription($title, 'set');
        $this->view()->headKeywords($seoKeywords, 'set');
        $this->view()->setTemplate('author-list');
        $this->view()->assign('authors', $author);
        $this->view()->assign('config', $config);
    }
}    