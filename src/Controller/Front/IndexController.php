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
use Pi\Mvc\Controller\ActionController;
use Pi\Paginator\Paginator;
use Zend\Db\Sql\Predicate\Expression;
use Zend\Json\Json;

class IndexController extends ActionController
{
    public function indexAction()
    {
        // Get info from url
        $module = $this->params('module');
        // Get config
        $config = Pi::service('registry')->config->read($module);
        // Get topic or homepage setting
        $topic = Pi::api('topic', 'news')->canonizeTopic();
        // Set story info
        $where = array('status' => 1, /*'time_publish <= ?' => time(),*/);
        // Get story List
        $storyList = $this->storyList($where, $topic['show_perpage']);
        // Set paginator info
        $template = array(
            'controller' => 'index',
            'action' => 'index',
            );
        // Get paginator
        $paginator = $this->storyPaginator($template, $where, $topic['show_perpage']);
        // Spotlight
        $spotlight = Pi::api('spotlight', 'news')->getSpotlight();
        // Set view
        $this->view()->headTitle($topic['seo_title']);
        $this->view()->headdescription($topic['seo_description'], 'set');
        $this->view()->headkeywords($topic['seo_keywords'], 'set');
        $this->view()->setTemplate($topic['template']);
        $this->view()->assign('stores', $storyList);
        $this->view()->assign('paginator', $paginator);
        $this->view()->assign('topic', $topic);
        $this->view()->assign('config', $config);
        $this->view()->assign('spotlight', $spotlight);
    }
    
    public function storyList($where, $limit)
    {
        // Set info
        $story = array();
        $page = $this->params('page', 1);
        $module = $this->params('module');
        $offset = (int)($page - 1) * $limit;
        $order = array('time_publish DESC', 'id DESC');
        // Set day limit
        if ($this->config('daylimit')) {
            $where['time_publish > ?'] = time() - (86400 * $config['daylimit']);
        }
        // Set info
        $columns = array('story' => new Expression('DISTINCT story'));
        // Get info from link table
        $select = $this->getModel('link')->select()->where($where)->columns($columns)->order($order)->offset($offset)->limit(intval($limit));
        $rowset = $this->getModel('link')->selectWith($select)->toArray();
        // Make list
        foreach ($rowset as $id) {
            $storyId[] = $id['story'];
        }
        if (empty($storyId)) {
            return $story;
        }
        // Set info
        $where = array('status' => 1, 'id' => $storyId);
        // Get topic list
        $topicList = Pi::api('topic', 'news')->topicList();
        // Get list of story
        $select = $this->getModel('story')->select()->where($where)->order($order);
        $rowset = $this->getModel('story')->selectWith($select);
        foreach ($rowset as $row) {
            $story[$row->id] = Pi::api('story', 'news')->canonizeStory($row, $topicList);
        }
        // return story
        return $story;
    }

    public function storyPaginator($template, $where, $limit)
    {
        $page = $this->params('page', 1);
        //
        $template['slug'] = (isset($template['slug'])) ? $template['slug'] : '';
        $template['year'] = (isset($template['year'])) ? $template['year'] : '';
        $template['month'] = (isset($template['month'])) ? $template['month'] : '';
        // get count     
        $columns = array('count' => new Expression('count(DISTINCT `story`)'));
        $select = $this->getModel('link')->select()->where($where)->columns($columns);
        $count = $this->getModel('link')->selectWith($select)->current()->count;
        // paginator
        $paginator = Paginator::factory(intval($count));
        $paginator->setItemCountPerPage(intval($limit));
        $paginator->setCurrentPageNumber(intval($page));
        $paginator->setUrlOptions(array(
            'router'    => $this->getEvent()->getRouter(),
            'route'     => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
            'params'    => array_filter(array(
                'module'        => $this->getModule(),
                'controller'    => $template['controller'],
                'action'        => $template['action'],
                'slug'          => $template['slug'],
                'year'          => $template['year'],
                'month'         => $template['month'],
            )),
        ));
        return $paginator;
    }
}