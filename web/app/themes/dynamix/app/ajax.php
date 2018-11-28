<?php

namespace App;
use WeDevs\ORM\WP\Post as Post;
use WP_Query;

class Ajax
{
    public function __construct()
    {
        add_action('wp_ajax_get_modal', [$this, 'myajax_submit']);
        add_action('wp_ajax_get_sliders', [$this, 'getSlider']);
        // add_action('wp_ajax_nopriv_get_modal', [$this, 'myMethod']);
    }

    public function getSlider()
    {
        echo(json_encode(Post::type('slider')->status('publish')->get(),true));
        wp_die();
    }
    public function myMethod()
    {
        echo(json_encode(Post::type('slider')->status('publish')->get(),true));
        wp_die();
    }
    function myajax_submit() {
        $args = array(
            'post_type' => 'slider',
            'posts_per_page' => 5
        );
    
        $ajax_query = new WP_Query($args);
    
        echo json_encode($ajax_query->posts);
    
        die();
        // echo json_encode( $post );
    }
}

new Ajax();