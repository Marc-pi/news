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
use Pi\File\Transfer\Upload;
use Module\News\Form\StoryForm;
use Module\News\Form\StoryFilter;
use Zend\Json\Json;

class StoryController extends ActionController
{
    protected $ImageStoryPrefix = 'image_';

    protected $storyColumns = array(
        'id', 'title', 'subtitle', 'slug', 'topic', 'short', 'body', 'seo_keywords', 
        'seo_description', 'important', 'status', 'time_create', 'time_update', 'time_publish', 
        'uid', 'hits', 'image', 'path', 'point', 'count', 'favorite', 'attach', 'extra'
    );

    public function indexAction()
    {
        // Get page
        $page = $this->params('page', 1);
        $module = $this->params('module');
        $status = $this->params('status');
        $topic = $this->params('topic');
        $uid = $this->params('uid');
        // Set info
        $offset = (int)($page - 1) * $this->config('admin_perpage');
        $order = array('time_publish DESC', 'id DESC');
        $limit = intval($this->config('admin_perpage'));
        // Set where
        $whereLink = array();
        if (!empty($status)) {
            $whereLink['status'] = $status;
        }
        if (!empty($topic)) {
            $whereLink['topic'] = $topic;
        }
        if (!empty($uid)) {
            $whereLink['uid'] = $uid;
        }
        // Set columns
        $columnsLink = array('story' => new \Zend\Db\Sql\Predicate\Expression('DISTINCT story'));
        // Get info from link table
        $select = $this->getModel('link')->select()->where($whereLink)->columns($columnsLink)->order($order)->offset($offset)->limit($limit);
        $rowset = $this->getModel('link')->selectWith($select)->toArray();
        // Make list
        foreach ($rowset as $id) {
            $storyId[] = $id['story'];
        }
        // Set info
        $columnStory = array('id', 'title', 'slug', 'status', 'time_publish', 'uid');
        $whereStory = array('id' => $storyId);
        // Get list of story
        $select = $this->getModel('story')->select()->columns($columnStory)->where($whereStory)->order($order);
        $rowset = $this->getModel('story')->selectWith($select);
        // Make list
        foreach ($rowset as $row) {
            $story[$row->id] = $row->toArray();
            $story[$row->id]['time_publish'] = _date($story[$row->id]['time_publish']);
        }
        // Go to time_update page if empty
        if (empty($story) && empty($status)) {
            return $this->redirect()->toRoute('', array('action' => 'update'));
        }
        // Set paginator
        $count = array('count' => new \Zend\Db\Sql\Predicate\Expression('count(DISTINCT `story`)'));
        $select = $this->getModel('link')->select()->where($whereLink)->columns($count);
        $count = $this->getModel('link')->selectWith($select)->current()->count;
        $paginator = Paginator::factory(intval($count));
        $paginator->setItemCountPerPage($this->config('admin_perpage'));
        $paginator->setCurrentPageNumber($page);
        $paginator->setUrlOptions(array(
            'router'    => $this->getEvent()->getRouter(),
            'route'     => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
            'params'    => array_filter(array(
                'module'        => $this->getModule(),
                'controller'    => 'story',
                'action'        => 'index',
            )),
        ));
        // Set view
        $this->view()->setTemplate('story_index');
        $this->view()->assign('stores', $story);
        $this->view()->assign('paginator', $paginator);

    }

    public function viewAction()
    {
        // Get info
        $module = $this->params('module');
        // Set template
        $this->view()->setTemplate('story_view');
        // Get story
        $id = $this->params('id');
        $story = $this->getModel('story')->find($id)->toArray();
        $story['time_publish'] = _date($story['time_publish']);
        // Check message
        if (!$story['id']) {
            $this->jump(array('action' => 'index'), __('Please select story'));
        }
        // Get topic
        $topics = Pi::service('api')->news(array('Story', 'Topic'), $story['topic']);
        // Set view
        $this->view()->assign('topics', $topics);
        $this->view()->assign('story', $story);
    }

    public function acceptAction()
    {
        // Get id and status
        $id = $this->params('id');
        $status = $this->params('status');
        $return = array();
        // set story
        $story = $this->getModel('story')->find($id);
        // Check
        if ($story && in_array($status, array(1, 2, 3, 4, 5))) {
            // Accept
            $story->status = $status;
            // Save
            if ($story->save()) {
                $this->getModel('link')->update(array('status' => $story->status), array('story' => $story->id));
                $return['message'] = sprintf(__('%s story accept successfully'), $story->title);
                $return['ajaxstatus'] = 1;
                $return['id'] = $story->id;
                $return['storystatus'] = $story->status;
            } else {
                $return['message'] = sprintf(__('Error in accept %s story'), $story->title);
                $return['ajaxstatus'] = 0;
                $return['id'] = 0;
                $return['storystatus'] = $story->status;
            }
        } else {
            $return['message'] = __('Please select story');
            $return['ajaxstatus'] = 0;
            $return['id'] = 0;
            $return['storystatus'] = 0;
        }

        return $return;
    }


    public function removeAction()
    {
        // Get id and status
        $id = $this->params('id');
        // set story
        $story = $this->getModel('story')->find($id);
        // Check
        if ($story && !empty($id)) {
            // remove file
            $files = array(
                Pi::path('upload/' . $this->config('image_path') . '/original/' . $story->path . '/' . $story->image),
                Pi::path('upload/' . $this->config('image_path') . '/large/' . $story->path . '/' . $story->image),
                Pi::path('upload/' . $this->config('image_path') . '/medium/' . $story->path . '/' . $story->image),
                Pi::path('upload/' . $this->config('image_path') . '/thumb/' . $story->path . '/' . $story->image),
            );
            Pi::service('file')->remove($files);
            // clear DB
            $story->image = '';
            $story->path = '';
            // Save
            if ($story->save()) {
                $message = sprintf(__('Image of %s removed'), $story->title);
                $status = 1;
            } else {
                $message = __('Image not remove');
                $status = 0;
            }
        } else {
            $message = __('Please select story');
            $status = 0;
        }
        return array(
            'status' => $status,
            'message' => $message,
        );
    }

    public function updateAction()
    {
        // Get id
        $id = $this->params('id');
        $module = $this->params('module');
        $option = array();
        // Find Product
        if ($id) {
            $story = $this->getModel('story')->find($id)->toArray();
            $story['topic'] = Json::decode($story['topic']);
            if ($story['image']) {
                $thumbUrl = sprintf('upload/%s/thumb/%s/%s', $this->config('image_path'), $story['path'], $story['image']);
                $option['thumbUrl'] = Pi::url($thumbUrl);
                $option['removeUrl'] = $this->url('', array('action' => 'remove', 'id' => $story['id']));
            }
        }
        // Get extra field
        $fields = Pi::api('news', 'extra')->Get();
        $option['field'] = $fields['extra'];
        // Set form
        $form = new StoryForm('story', $option);
        $form->setAttribute('enctype', 'multipart/form-data');
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $file = $this->request->getFiles();
            // Set slug
            $slug = ($data['slug']) ? $data['slug'] : $data['title'];
            $data['slug'] = Pi::api('news', 'text')->slug($slug);
            // Form filter
            $form->setInputFilter(new StoryFilter($option['field']));
            $form->setData($data);
            if ($form->isValid()) {
                $values = $form->getData();
                // Set extra data array
                if (!empty($fields['field'])) {
                    foreach ($fields['field'] as $field) {
                        $extra[$field]['field'] = $field;
                        $extra[$field]['data'] = $values[$field];
                    }
                }
                // Tag
                if (!empty($values['tag'])) {
                    $tag = explode(' ', $values['tag']);
                }
                // upload image
                if (!empty($file['image']['name'])) {
                    // Set upload path
                    $values['path'] = sprintf('%s/%s', date('Y'), date('m'));
                    $originalPath = Pi::path(sprintf('upload/%s/original/%s', $this->config('image_path'), $values['path']));
                    // Upload
                    $uploader = new Upload;
                    $uploader->setDestination($originalPath);
                    $uploader->setRename($this->ImageProductPrefix . '%random%');
                    $uploader->setExtension($this->config('image_extension'));
                    $uploader->setSize($this->config('image_size'));
                    if ($uploader->isValid()) {
                        $uploader->receive();
                        // Get image name
                        $values['image'] = $uploader->getUploaded('image');
                        // process image
                        Pi::api('news', 'image')->process($values['image'], $values['path']);
                    } else {
                        $this->jump(array('action' => 'update'), __('Problem in upload image. please try again'));
                    }
                } elseif (!isset($values['image'])) {
                    $values['image'] = '';  
                }
                // Set just story fields
                foreach (array_keys($values) as $key) {
                    if (!in_array($key, $this->storyColumns)) {
                        unset($values[$key]);
                    }
                }
                // Topics
                $values['topic'] = Json::encode(array_unique($values['topic']));
                // Set seo_title
                $title = ($values['seo_title']) ? $values['seo_title'] : $values['title'];
                $values['seo_title'] = Pi::api('news', 'text')->title($title);
                // Set seo_keywords
                $keywords = ($values['seo_keywords']) ? $values['seo_keywords'] : $values['title'];
                $values['seo_keywords'] = Pi::api('news', 'text')->keywords($keywords);
                // Set seo_description
                $description = ($values['seo_description']) ? $values['seo_description'] : $values['title'];
                $values['seo_description'] = Pi::api('news', 'text')->description($description);
                // Set time
                if (empty($values['id'])) {
                    $values['time_create'] = time();
                    $values['time_publish'] = time();
                    $values['uid'] = Pi::user()->getId();
                }
                $values['time_update'] = time();
                // Save values
                if (!empty($values['id'])) {
                    $row = $this->getModel('story')->find($values['id']);
                } else {
                    $row = $this->getModel('story')->createRow();
                }
                $row->assign($values);
                $row->save();
                // Topic
                Pi::api('news', 'topic')->setLink($row->id, $row->topic, $row->time_publish, $row->status, $row->uid);
                // Tag
                if (isset($tag) && is_array($tag) && Pi::service('module')->isActive('tag')) {
                    if (empty($values['id'])) {
                        Pi::service('tag')->add($module, $row->id, '', $tag);
                    } else {
                        Pi::service('tag')->update($module, $row->id, '', $tag);
                    }
                }
                // Writer
                if (empty($values['id'])) {
                    Pi::api('news', 'writer')->Add($values['uid']);
                }
                // Extra
                if (!empty($extra)) {
                    Pi::api('news', 'extra')->Set($extra, $row->id);
                }
                // Add to sitemap
                if (empty($values['id']) && Pi::service('module')->isActive('sitemap')) {
                    $link = array();
                    $link['loc'] = Pi::url($this->url('.news', array('module' => $module, 'controller' => 'story', 'slug' => $values['slug'])));
                    $link['lastmod'] = date("Y-m-d H:i:s"); // Or set empty
                    $link['changefreq'] = 'daily'; // Or set empty
                    $link['priority'] = ''; // Or set empty
                    Pi::service('api')->sitemap(array('Sitemap', 'add'), 'news', 'story', $link);
                }
                // Check it save or not
                if ($row->id) {
                    $message = __('Story data saved successfully.');
                    $url = array('controller' => 'story', 'action' => 'index');
                    $this->jump($url, $message);
                } else {
                    $message = __('Story data not saved.');
                }
            } else {
                $message = __('Invalid data, please check and re-submit.');
            }
        } else {
            if ($id) {
                // Get Extra
                $story = Pi::api('news', 'extra')->Form($story);
                // Get tag list
                if (Pi::service('module')->isActive('tag')) {
                    $tag = Pi::service('tag')->get($module, $story['id'], '');
                    if (is_array($tag)) {
                        $story['tag'] = implode(' ', $tag);
                    }
                }
                $form->setData($story);
                $message = 'You can edit this Story';
            } else {
                $message = 'You can add new Story';
            }
        }
        $this->view()->setTemplate('story_update');
        $this->view()->assign('form', $form);
        $this->view()->assign('title', __('Add a Story'));
        $this->view()->assign('message', $message);
    }

    public function deleteAction()
    {
        /*
           * not completed and need confirm option
           */
        // Get information
        $this->view()->setTemplate(false);
        $id = $this->params('id');
        $row = $this->getModel('story')->find($id);
        if ($row) {
            // Writer
            Pi::service('api')->news(array('Writer', 'Delete'), $row->uid);
            // Topic
            $this->getModel('link')->delete(array('story' => $row->id));
            // Attach
            $this->getModel('attach')->delete(array('story' => $row->id));
            // Extra
            $this->getModel('field_data')->delete(array(story => $row->id));
            // Spotlight
            $this->getModel('spotlight')->delete(array('story' => $row->id));
            // Remove page
            $row->delete();
            $this->jump(array('action' => 'index'), __('This story deleted'));
        }
        $this->jump(array('action' => 'index'), __('Please select story'));
    }
}