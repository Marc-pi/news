<?php
/**
 * Pi Engine (http://piengine.org)
 *
 * @link            http://code.piengine.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://piengine.org
 * @license         http://piengine.org/license.txt New BSD License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */

namespace Module\News\Controller\Api;

use Pi;
use Pi\Mvc\Controller\ApiController;

class TopicController extends ApiController
{
    public function listAction()
    {
        // Set default result
        $result = [
            'result' => false,
            'data'    => [],
            'error'   => [
                'code'    => 1,
                'message' => __('Nothing selected'),
                'messageFlag' => false,
            ]
        ];

        // Get info from url
        $module = $this->params('module');
        $token  = $this->params('token');

        // Check token
        $check = Pi::api('token', 'tools')->check($token, $module);
        if ($check['status'] == 1) {

            // Save statistics
            if (Pi::service('module')->isActive('statistics')) {
                Pi::api('log', 'statistics')->save(
                    'news', 'storyList', 0, [
                        'source'  => $this->params('platform'),
                        'section' => 'api',
                    ]
                );
            }

            // Set options
            $options            = [];
            $options['type']    = 'general';

            // Get data
            $result['data'] = Pi::api('api', 'news')->getTopicFullList($options);

            // Check data
            if (!empty($result['data'])) {
                $result['result'] =  true;
            } else {
                // Set error
                $result['error'] = [
                    'code'    => 4,
                    'message' => __('Data is empty'),
                ];
            }
        } else {
            // Set error
            $result['error'] = [
                'code'    => 2,
                'message' => $check['message'],
            ];
        }

        // Check final result
        if ($result['result']) {
            $result['error'] = [];
        }

        // Return result
        return $result;
    }

    public function singleAction()
    {
        // Set default result
        $result = [
            'result' => false,
            'data'    => [],
            'error'   => [
                'code'    => 1,
                'message' => __('Nothing selected'),
            ]
        ];

        // Get info from url
        $module = $this->params('module');
        $token  = $this->params('token');
        $id     = $this->params('id');

        // Check token
        $check = Pi::api('token', 'tools')->check($token, $module);
        if ($check['status'] == 1) {

            // Save statistics
            if (Pi::service('module')->isActive('statistics')) {
                Pi::api('log', 'statistics')->save(
                    'news', 'storySingle', $this->params('id'), [
                        'source'  => $this->params('platform'),
                        'section' => 'api',
                    ]
                );
            }

            // Check id
            if (intval($id) > 0) {
                $result['data'] = Pi::api('topic', 'news')->getTopicFull(intval($id));

                // Check data
                if (!empty($result['data'])) {
                    $result['result'] =  true;
                } else {
                    // Set error
                    $result['error'] = [
                        'code'    => 4,
                        'message' => __('Data is empty'),
                    ];
                }
            } else {
                // Set error
                $result['error'] = [
                    'code'    => 3,
                    'message' => __('Id not selected'),
                ];
            }
        } else {
            // Set error
            $result['error'] = [
                'code'    => 2,
                'message' => $check['message'],
            ];
        }

        // Check final result
        if ($result['result']) {
            $result['error'] = [];
        }

        // Return result
        return $result;
    }
}