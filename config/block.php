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
return array(
    // Item block
    'item' => array(
        'title' => __('Item'),
        'seo_description' => '',
        'render' => array('block', 'item'),
        'template' => 'item',
        'config' => array(
            'topicid' => array(
                'title' => __('Topic'),
                'seo_description' => __(''),
                'edit' => 'Module\News\Form\Element\Topic',
                'filter' => 'string',
                'value' => 0,
            ),
            'number' => array(
                'title' => __('Number'),
                'seo_description' => '',
                'edit' => 'text',
                'filter' => 'number_int',
                'value' => 1,
            ),
            'showdesc' => array(
                'title' => __('Shwo text'),
                'seo_description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 1,
            ),
            'showdate' => array(
                'title' => __('Show date'),
                'seo_description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 1,
            ),
            'showhits' => array(
                'title' => __('Show hits'),
                'seo_description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 1,
            ),
            'showimage' => array(
                'title' => __('Show Images'),
                'seo_description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 1,
            ),
            'showmore' => array(
                'title' => __('Show More link for each story'),
                'seo_description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 1,
            ),
            'showblockmore' => array(
                'title' => __('Show More link to module page'),
                'seo_description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 0,
            ),
            'linkblockmore' => array(
                'title' => __('Set More link to module page'),
                'seo_description' => '',
                'edit' => 'text',
                'filter' => 'string',
                'value' => '',
            ),
        ),
        'access' => array(
            'guest' => 1,
            'member' => 1,
        ),
    ),

    // List block
    'list' => array(
        'title' => __('list'),
        'seo_description' => '',
        'render' => array('block', 'item'),
        'template' => 'list',
        'config' => array(
            'topicid' => array(
                'title' => __('topic'),
                'seo_description' => __(''),
                'edit' => 'Module\News\Form\Element\Topic',
                'filter' => 'string',
                'value' => 0,
            ),
            'number' => array(
                'title' => __('Number'),
                'seo_description' => '',
                'edit' => 'text',
                'filter' => 'number_int',
                'value' => 10,
            ),
            'showdate' => array(
                'title' => __('Show date'),
                'seo_description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 0,
            ),
            'showhits' => array(
                'title' => __('Show hits'),
                'seo_description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 0,
            ),
            'showblockmore' => array(
                'title' => __('Show More link to module page'),
                'seo_description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 0,
            ),
            'linkblockmore' => array(
                'title' => __('Set More link to module page'),
                'seo_description' => '',
                'edit' => 'text',
                'filter' => 'string',
                'value' => '',
            ),
        ),
        'access' => array(
            'guest' => 1,
            'member' => 1,
        ),
    ),

    // Table block
    'table' => array(
        'title' => __('Table'),
        'seo_description' => '',
        'render' => array('block', 'item'),
        'template' => 'table',
        'config' => array(
            'topicid' => array(
                'title' => __('topic'),
                'seo_description' => __(''),
                'edit' => 'Module\News\Form\Element\Topic',
                'filter' => 'string',
                'value' => 0,
            ),
            'number' => array(
                'title' => __('Number'),
                'seo_description' => '',
                'edit' => 'text',
                'filter' => 'number_int',
                'value' => 1,
            ),
            'showdesc' => array(
                'title' => __('Shwo text'),
                'seo_description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 0,
            ),
            'showdate' => array(
                'title' => __('Show date'),
                'seo_description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 1,
            ),
            'showhits' => array(
                'title' => __('Show hits'),
                'seo_description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 1,
            ),
            'showblockmore' => array(
                'title' => __('Show More link to module page'),
                'seo_description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 0,
            ),
            'linkblockmore' => array(
                'title' => __('Set More link to module page'),
                'seo_description' => '',
                'edit' => 'text',
                'filter' => 'string',
                'value' => '',
            ),
        ),
        'access' => array(
            'guest' => 1,
            'member' => 1,
        ),
    ),


    // Slotlight block
    'spotlight' => array(
        'title' => __('Spotlight'),
        'seo_description' => '',
        'render' => array('block', 'spotlight'),
        'template' => 'spotlight',
        'config' => array(
            'topicid' => array(
                'title' => __('topic'),
                'seo_description' => __(''),
                'edit' => 'Module\News\Form\Element\Topic',
                'filter' => 'string',
                'value' => 0,
            ),
            'number' => array(
                'title' => __('Number'),
                'seo_description' => '',
                'edit' => 'text',
                'filter' => 'number_int',
                'value' => 5,
            ),
            'subspotlight' => array(
                'title' => __('Number of sub spotlight'),
                'seo_description' => '',
                'edit' => 'text',
                'filter' => 'number_int',
                'value' => 4,
            ),
            'showdesc' => array(
                'title' => __('Shwo text'),
                'seo_description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 1,
            ),
            'showdate' => array(
                'title' => __('Show date'),
                'seo_description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 1,
            ),
            'showhits' => array(
                'title' => __('Show hits'),
                'seo_description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 1,
            ),
            'showimage' => array(
                'title' => __('Show Images'),
                'seo_description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 1,
            ),
            'showblockmore' => array(
                'title' => __('Show More link to module page'),
                'seo_description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 0,
            ),
            'linkblockmore' => array(
                'title' => __('Set More link to module page'),
                'seo_description' => '',
                'edit' => 'text',
                'filter' => 'string',
                'value' => '',
            ),
        ),
        'access' => array(
            'guest' => 1,
            'member' => 1,
        ),
    ),

    // topic block
    'topic' => array(
        'title' => __('List of topic'),
        'seo_description' => '',
        'render' => array('block', 'topic'),
        'template' => 'topic',
        'config' => array(
            'topicid' => array(
                'title' => __('Topic'),
                'seo_description' => __(''),
                'edit' => 'Module\News\Form\Element\Topic',
                'filter' => 'string',
                'value' => 0,
            ),
            'showdesc' => array(
                'title' => __('Shwo text'),
                'seo_description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 1,
            ),
            'showimage' => array(
                'title' => __('Show Images'),
                'seo_description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 1,
            ),
            'showblockmore' => array(
                'title' => __('Show More link to module page'),
                'seo_description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 0,
            ),
            'linkblockmore' => array(
                'title' => __('Set More link to module page'),
                'seo_description' => '',
                'edit' => 'text',
                'filter' => 'string',
                'value' => '',
            ),
        ),
        'access' => array(
            'guest' => 1,
            'member' => 1,
        ),
    ),
);