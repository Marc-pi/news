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
    'category' => array(
        array(
            'title' => _a('Admin'),
            'name' => 'admin'
        ),
        array(
            'title' => _a('Json output'),
            'name' => 'json'
        ),
        array(
            'title' => _a('Show'),
            'name' => 'show'
        ),
        array(
            'title' => _a('Feed'),
            'name' => 'feed'
        ),
        array(
            'title' => _a('Image'),
            'name' => 'image'
        ),
        array(
            'title' => _a('File'),
            'name' => 'file'
        ),
        array(
            'title' => _a('Social'),
            'name' => 'social'
        ),
        array(
            'title' => _a('Spotlight'),
            'name' => 'spotlight'
        ),
        array(
            'title' => _a('Vote'),
            'name' => 'vote'
        ),
        array(
            'title' => _a('Favourite'),
            'name' => 'favourite'
        ),
        array(
            'title' => _a('Micro blog'),
            'name' => 'microblog'
        ),
    ),
    'item' => array(
        // Generic
        'advertisement' => array(
            'title' => _a('Advertisement'),
            'edit' => 'textarea',
        ),
        // Admin
        'admin_perpage' => array(
            'category' => 'admin',
            'title' => _a('Perpage'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 50
        ),
        'admin_setpage' => array(
            'category' => 'admin',
            'title' => _a('Set topic as system page for support customise layout for blocks'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 0
        ),
        'admin_setauthor' => array(
            'category' => 'admin',
            'title' => _a('Set story authors'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 1
        ),
        'admin_time_publish' => array(
            'category' => 'admin',
            'title' => _a('Set custom publish time'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 0
        ),
        'admin_deactivate_view' => array(
            'category' => 'admin',
            'title' => _a('Deactivate module front pages'),
            'description' => _a('Deactivate module front pages by 404 error code, useful if you want use module as service for event and blog and dont want publish any story as news'),
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 0
        ),
        // Json
        'admin_json' => array(
            'category' => 'json',
            'title' => _a('Active json output'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 1
        ),
        'json_perpage' => array(
            'category' => 'json',
            'title' => _a('Perpage on json output'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 100
        ),
        'json_check_password' => array(
            'category' => 'json',
            'title' => _a('Check password for json output'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 0
        ),
        'json_password' => array(
            'category' => 'json',
            'title' => _a('Password for json output'),
            'description' => _a('After use on mobile device , do not change it'),
            'edit' => 'text',
            'filter' => 'string',
            'value' => md5(rand(1,99999)),
        ),
        // Show
        'style' => array(
            'title' => _a('Show Style'),
            'description' => ' ',
            'edit' => array(
                'type' => 'select',
                'options' => array(
                    'options' => array(
                        'news' => _a('News'),
                        'list' => _a('List'),
                        'table' => _a('Table'),
                        'media' => _a('Media'),
                        'spotlight' => _a('Spotlight'),
                        'topic' => _a('Topic'),
                    ),
                ),
            ),
            'filter' => 'string',
            'value' => 'news',
            'category' => 'show',
        ),
        'show_perpage' => array(
            'category' => 'show',
            'title' => _a('Perpage'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 5
        ),
        'show_columns' => array(
            'title' => _a('Columns'),
            'description' => ' ',
            'edit' => array(
                'type' => 'select',
                'options' => array(
                    'options' => array(
                        1 => _a('One column'),
                        2 => _a('Two columns'),
                        3 => _a('Three columns'),
                        4 => _a('Four columns'),
                    ),
                ),
            ),
            'filter' => 'number_int',
            'value' => 1,
            'category' => 'show',
        ),
        'show_order_link' => array(
            'title' => _a('Story order'),
            'description' => _a('Story list order options'),
            'edit' => array(
                'type' => 'select',
                'options' => array(
                    'options' => array(
                        'publishDESC' => _a('Publish time DESC'),
                        'publishASC' => _a('Publish time ASC'),
                    ),
                ),
            ),
            'filter' => 'string',
            'value' => 'publishDESC',
            'category' => 'show',
        ),
        'show_subid' => array(
            'category' => 'show',
            'title' => _a('Show Subtopic stories on main topic'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 1
        ),
        'show_topic' => array(
            'category' => 'show',
            'title' => _a('Show Topic'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 1
        ),
        'show_topicinfo' => array(
            'category' => 'show',
            'title' => _a('Show Topic Information'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 1
        ),
        'show_author' => array(
            'category' => 'show',
            'title' => _a('Show author'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 1
        ),
        'show_date' => array(
            'category' => 'show',
            'title' => _a('Show Date'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 1
        ),
        'show_hits' => array(
            'category' => 'show',
            'title' => _a('Show Hits'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 1
        ),
        'show_tag' => array(
            'category' => 'show',
            'title' => _a('Show Tags'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 1
        ),
        'show_attach' => array(
            'category' => 'show',
            'title' => _a('Show attach files'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 1
        ),
        'show_attribute' => array(
            'category' => 'show',
            'title' => _a('Show attribute information'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 1
        ),
        'show_nav' => array(
            'category' => 'show',
            'title' => _a('Show navigation'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 1
        ),
        'show_spotlight' => array(
            'category' => 'show',
            'title' => _a('Show spotlight'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 0
        ),
        'view_breadcrumbs' => array(
            'category' => 'show',
            'title' => _a('Show breadcrumbs'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 1
        ),
        'show_related' => array(
            'category' => 'show',
            'title' => _a('Show related news'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 1
        ),
        'related_num' => array(
            'category' => 'show',
            'title' => _a('related number'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 10
        ),
        'show_latest' => array(
            'category' => 'show',
            'title' => _a('Show latest news'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 1
        ),
        'latest_num' => array(
            'category' => 'show',
            'title' => _a('latest number'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 10
        ),
        'daylimit' => array(
            'category' => 'show',
            'title' => _a('Just show news from X days ago'),
            'description' => _a('Set 0 for show all news, Or set day number for limit news in days'),
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 0
        ),
        // Feed
        'feed_icon' => array(
            'category' => 'feed',
            'title' => _a('Show feed icon'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 1
        ),
        'feed_num' => array(
            'category' => 'feed',
            'title' => _a('Feed number'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 10
        ),
        // Image
        'image_default' => array(
            'category' => 'image',
            'title' => _a('Use default if image not set'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 0
        ),
        'image_size' => array(
            'category' => 'image',
            'title' => _a('Image Size'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 1000000
        ),
        'image_quality' => array(
            'category' => 'image',
            'title' => _a('Image quality'),
            'description' => _a('Between 0 to 100 and support both of JPG and PNG, default is 75'),
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 75
        ),
        'image_path' => array(
            'category' => 'image',
            'title' => _a('Image path'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'string',
            'value' => 'news/image'
        ),
        'image_extension' => array(
            'category' => 'image',
            'title' => _a('Image Extension'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'string',
            'value' => 'jpg,jpeg,png,gif'
        ),
        'image_largeh' => array(
            'category' => 'image',
            'title' => _a('Large Image height'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 1200
        ),
        'image_largew' => array(
            'category' => 'image',
            'title' => _a('Large Image width'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 1200
        ),
        'image_mediumh' => array(
            'category' => 'image',
            'title' => _a('Medium Image height'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 400
        ),
        'image_mediumw' => array(
            'category' => 'image',
            'title' => _a('Medium Image width'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 400
        ),
        'image_thumbh' => array(
            'category' => 'image',
            'title' => _a('Thumb Image height'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 200
        ),
        'image_thumbw' => array(
            'category' => 'image',
            'title' => _a('Thumb Image width'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 200
        ),
        'image_lightbox' => array(
            'category' => 'image',
            'title' => _a('Use lightbox'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 1
        ),
        'image_watermark' => array(
            'category' => 'image',
            'title' => _a('Add Watermark'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 0
        ),
        'image_watermark_source' => array(
            'category' => 'image',
            'title' => _a('Watermark Image'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'string',
            'value' => ''
        ),
        'image_watermark_position' => array(
            'title' => _a('Watermark Positio'),
            'description' => '',
            'edit' => array(
                'type' => 'select',
                'options' => array(
                    'options' => array(
                        'top-left' => _a('Top Left'),
                        'top-right' => _a('Top Right'),
                        'bottom-left' => _a('Bottom Left'),
                        'bottom-right' => _a('Bottom Right'),
                    ),
                ),
            ),
            'filter' => 'text',
            'value' => 'bottom-right',
            'category' => 'image',
        ),
        // Social
        'social_sharing' => array(
            'title' => _t('Social sharing items'),
            'description' => '',
            'edit' => array(
                'type' => 'multi_checkbox',
                'options' => array(
                    'options' => Pi::service('social_sharing')->getList(),
                ),
            ),
            'filter' => 'array',
            'category' => 'social',
        ),
        // Spotlight
        'spotlight_number' => array(
            'category' => 'spotlight',
            'title' => _a('Number of stories'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 1
        ),
        'spotlight_image' => array(
            'category' => 'spotlight',
            'title' => _a('Show Image for sub spotlights'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 0
        ),
        'spotlight_registry' => array(
            'category' => 'spotlight',
            'title' => _a('Spotlight story number for registry'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 7
        ),
        // Vote
        'vote_bar' => array(
            'category' => 'vote',
            'title' => _a('Use vote system'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 1
        ),
        // favourite
        'favourite_bar' => array(
            'category' => 'favourite',
            'title' => _a('Use favourite system'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 1
        ),
        // Texts
        'text_description_index' => array(
            'category' => 'head_meta',
            'title' => _a('Description for index page'),
            'description' => '',
            'edit' => 'textarea',
            'filter' => 'string',
            'value' => ''
        ),
        'force_replace_space' => array(
            'category' => 'head_meta',
            'title' => _a('Force replace space by comma(,)'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 1
        ),
        // File
        'file_size' => array(
            'category' => 'file',
            'title' => _a('File Size'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 1000000
        ),
        'file_path' => array(
            'category' => 'file',
            'title' => _a('File path'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'string',
            'value' => 'news'
        ),
        'file_extension' => array(
            'category' => 'file',
            'title' => _a('File Extension'),
            'description' => '',
            'edit' => 'textarea',
            'filter' => 'string',
            'value' => 'jpg,png,gif,avi,flv,mp3,mp4,pdf,docs,xdocs,zip,rar'
        ),
        // microblog
        'microblog_active' => array(
            'category' => 'microblog',
            'title' => _a('Active microblog system'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 0
        ),
        'microblog_perpage' => array(
            'category' => 'microblog',
            'title' => _a('Micro blog perpage'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 20
        ),
    ),
);