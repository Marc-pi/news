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
namespace Module\News\Route;

use Pi;
use Pi\Mvc\Router\Http\Standard;

class Blog extends Standard
{
    /**
     * Default values.
     * @var array
     */
    protected $defaults = array(
        'module'        => 'news',
        'controller'    => 'index',
        'action'        => 'index'
    );

    protected $controllerList = array(
        'author', 'favourite', 'index', 'json', 'media', 'story', 'tag', 'topic'
    );

    /**
     * {@inheritDoc}
     */
    protected $structureDelimiter = '/';

    /**
     * {@inheritDoc}
     */
    protected function parse($path)
    {
        $matches = array();
        $parts = array_filter(explode($this->structureDelimiter, $path));

        // Set controller
        $matches = array_merge($this->defaults, $matches);
        if (isset($parts[0]) && in_array($parts[0], $this->controllerList)) {
            $matches['controller'] = $this->decode($parts[0]);
        }

        // Make Match
        if (isset($matches['controller']) && !empty($parts[1])) {
            switch ($matches['controller']) {
                case 'story':
                    $matches['slug'] = $this->decode($parts[1]);
                    break;

                case 'topic':
                    if ($parts[1] == 'list') {
                        $matches['action'] = 'list';
                    } else {
                        $slug = $this->decode($parts[1]);
                        $topicList = Pi::registry('topic', 'news')->read();
                        foreach ($topicList as $topic) {
                            if ($topic['slug'] == $slug) {
                                $action = $topic['name'];
                            }
                        }
                        $matches['action'] = $action;
                        $matches['slug'] = $slug;
                    }
                    break;

                case 'author':
                    if ($parts[1] == 'list') {
                        $matches['action'] = 'list';
                    } else {
                        $matches['slug'] = $this->decode($parts[1]);
                    }
                    break;

                case 'tag':
                    if ($parts[1] == 'term') {
                        $matches['action'] = 'term';
                        $matches['slug'] = urldecode($parts[2]);
                    } elseif ($parts[1] == 'list') {
                        $matches['action'] = 'list';
                    }
                    break; 

                case 'json':
                    $matches['action'] = $this->decode($parts[1]);
                    if (isset($parts[2]) && $parts[2] == 'id') {
                        $matches['id'] = intval($parts[3]);
                    }
                    break; 

                case 'media':
                    $matches['action'] = $this->decode($parts[1]);
                    $matches['id'] = intval($parts[2]);
                    break;    
            }
        }
        return $matches;
    }

    /**
     * assemble(): Defined by Route interface.
     *
     * @see    Route::assemble()
     * @param  array $params
     * @param  array $options
     * @return string
     */
    public function assemble(
        array $params = array(),
        array $options = array()
    ) {
        $mergedParams = array_merge($this->defaults, $params);
        if (!$mergedParams) {
            return $this->prefix;
        }
        
        // Set module
        $url['module'] = 'blog';

        if (!empty($mergedParams['controller']) && $mergedParams['controller'] != 'index') {
            $url['controller'] = $mergedParams['controller'];
        }

        if (!empty($mergedParams['action']) && $mergedParams['action'] != 'index') {
            $url['action'] = $mergedParams['action'];
        }

        if (!empty($mergedParams['slug'])) {
            $url['slug'] = $mergedParams['slug'];
        }

        if (!empty($mergedParams['id']) && $mergedParams['controller'] == 'json') {
            $url['id'] = 'id' . $this->paramDelimiter . $mergedParams['id'];
        } elseif(!empty($mergedParams['id'])) {
            $url['id'] = $mergedParams['id'];
        }

        if (!empty($mergedParams['start'])) {
            $url['start'] = 'start' . $this->paramDelimiter . $mergedParams['start'];
        }

        if (!empty($mergedParams['limit'])) {
            $url['limit'] = 'limit' . $this->paramDelimiter . $mergedParams['limit'];
        }

        // Make url
        $url = implode($this->paramDelimiter, $url);

        if (empty($url)) {
            return $this->prefix;
        }
        return $this->paramDelimiter . $url;
    }
}