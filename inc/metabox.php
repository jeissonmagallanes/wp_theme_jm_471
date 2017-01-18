<?php
add_filter( 'rwmb_meta_boxes', 'rw_register_meta_boxes' );

function rw_register_meta_boxes()
{
    if ( !class_exists( 'RW_Meta_Box' ) )
        return;
    $prefix = 'rw_';
    $meta_boxes = array();

    $meta_boxes[] = array(
        'title'    => 'Top Header Image',
        'pages'    => array( 'page', 'post' ),
        'context'  => 'side',
        'priority' => 'low',
        'fields' => array(
            array(
                'name' => 'Main Banner in Page',
                'desc'  => 'Use this space to set the main image in the top part of every page. If you leave blank, a image by default will be used for filling up this position.',
                'id'   => $prefix . 'banner',
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
            )
        )
    );
    return $meta_boxes;
}