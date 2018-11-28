<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use WP_Query;

class FrontPage extends Controller
{
    public function getSliders()
    {
        $args = array(
        'post_type'              => 'slider',
        'posts_per_page'         => -1,
        'orderby' => array( 'post_date' => 'ASC' ),
        'tax_query' => array(
            array(
                'taxonomy' => 'slide_location',
                'field' => 'name',
                'terms' => 'home'
            )
        )
        );
        $query = new WP_Query($args);
        return $query;
    }
    public function getQuotes()
    {
        $args = array(
        'post_type'              => 'quote',
        'posts_per_page'         => -1
        );
        $query = new WP_Query($args);
        return $query;
    }
    public function getPartners()
    {
        $args = array(
        'post_type'              => 'partner',
        'posts_per_page'         => -1
        );
        $query = new WP_Query($args);
        return $query;
    }
}
