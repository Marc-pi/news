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
namespace Module\News\Controller\Admin;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Pi\Paginator\Paginator;
use Module\News\Form\MicroblogForm;
use Module\News\Form\MicroblogFilter;

class MicroblogController extends ActionController
{
    public function indexAction()
    {
        // Get page
        $page = $this->params('page', 1);
        $module = $this->params('module');
        // Get config
        $config = Pi::service('registry')->config->read($module);
        // Get info
        $list = array();
        $order = array('id DESC');
        $limit = intval($this->config('admin_perpage'));
        $offset = (int)($page - 1) * $this->config('admin_perpage');
        $where = array('status' => array(1, 2, 3, 4));
        $select = $this->getModel('microblog')->select()->where($where)->order($order)->offset($offset)->limit($limit);
        $rowset = $this->getModel('microblog')->selectWith($select);
        // Make list
        foreach ($rowset as $row) {
            $list[$row->id] = $row->toArray();
            $list[$row->id]['time_publish'] = _date($list[$row->id]['time_publish']);
            $list[$row->id]['user'] = Pi::user()->get($row->uid, array(
                'id', 'identity', 'name', 'email'
            ));
            // Set url
            if ($row->status == 1) {
                $list[$row->id]['microblogUrl'] = $this->url('news', array(
                    'module' => $module,
                    'controller' => 'microblog',
                    'id' => $row->id
                ));
            } else {
                $list[$row->id]['microblogUrl'] = '';
            }
        }
        // Set paginator
        $count = array('count' => new \Zend\Db\Sql\Predicate\Expression('count(*)'));
        $select = $this->getModel('microblog')->select()->columns($count);
        $count = $this->getModel('microblog')->selectWith($select)->current()->count;
        $paginator = Paginator::factory(intval($count));
        $paginator->setItemCountPerPage($limit);
        $paginator->setCurrentPageNumber($page);
        $paginator->setUrlOptions(array(
            'router' => $this->getEvent()->getRouter(),
            'route' => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
            'params' => array_filter(array(
                'module' => $this->getModule(),
                'controller' => 'microblog',
                'action' => 'index',
            )),
        ));
        // Set view
        $this->view()->setTemplate('microblog-index');
        $this->view()->assign('list', $list);
        $this->view()->assign('paginator', $paginator);
        $this->view()->assign('config', $config);
    }

    public function updateAction()
    {
        // Get id
        $id = $this->params('id');
        $module = $this->params('module');
        // Set form
        $form = new MicroblogForm('microblog');
        $form->setAttribute('enctype', 'multipart/form-data');
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $form->setInputFilter(new MicroblogFilter);
            $form->setData($data);
            if ($form->isValid()) {
                $values = $form->getData();
                if (empty($values['id'])) {
                    $values['time_create'] = time();
                    $values['uid'] = Pi::user()->getId();
                }
                // Save values
                if (!empty($values['id'])) {
                    $row = $this->getModel('microblog')->find($values['id']);
                } else {
                    $row = $this->getModel('microblog')->createRow();
                }
                $row->assign($values);
                $row->save();
                // Add / Edit sitemap
                if (Pi::service('module')->isActive('sitemap')) {
                    // Set loc
                    $loc = Pi::url($this->url('news', array(
                        'module' => $module,
                        'controller' => 'microblog',
                        'id' => $row->id
                    )));
                    // Update sitemap
                    Pi::api('sitemap', 'sitemap')->singleLink($loc, $row->status, $module, 'microblog', $row->id);
                }
                // Jump
                $message = __('Post saved successfully.');
                $this->jump(array('action' => 'index'), $message);
            }
        } else {
            if ($id) {
                $microblog = $this->getModel('microblog')->find($id)->toArray();
                $form->setData($microblog);
            }
        }
        // Set view
        $this->view()->setTemplate('microblog-update');
        $this->view()->assign('form', $form);
        $this->view()->assign('title', __('New post'));
    }

    public function deleteAction()
    {
        // Get information
        $this->view()->setTemplate(false);
        $module = $this->params('module');
        $id = $this->params('id');
        $row = $this->getModel('microblog')->find($id);
        if ($row) {
            $row->status = 5;
            $row->save();
            // Remove sitemap
            if (Pi::service('module')->isActive('sitemap')) {
                $loc = Pi::url($this->url('news', array(
                    'module' => $module,
                    'controller' => 'microblog',
                    'id' => $row->id
                )));
                Pi::api('sitemap', 'sitemap')->remove($loc);
            }
            // Remove page
            $this->jump(array('action' => 'index'), __('This post deleted'));
        }
        $this->jump(array('action' => 'index'), __('Please select post'));
    }
}