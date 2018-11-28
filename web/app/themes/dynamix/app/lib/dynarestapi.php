<?php

namespace App;


$data = array( 'some' );

// Create the response object
$response = new \WP_REST_Response( $data );

// Add a custom status code
$response->set_status( 201 );

// Add a custom header
// $response->header( 'Location', 'http://localhost:3000/' );

add_action( 'rest_api_init', function () {
	register_rest_route( 'dynamix/v1', '/mods', array(
		'methods' => 'GET',
		'callback' => __NAMESPACE__ . '\\get_mods',
		'args' => array(
			'id' => array(
				'validate_callback' => function($param, $request, $key) {
					return is_numeric( $param );
				}
			),
		),
	) );
	register_rest_route( 'dynamix/v1', '/logo', array(
		'methods' => 'POST',
		'callback' => __NAMESPACE__ . '\\post_logo',
		'args' => array(
			'id' => array(
				'validate_callback' => function($param, $request, $key) {
					return is_numeric( $param );
				}
			),
		),
	) );
	register_rest_route( 'dynamix/v1', '/addmedia', array(
		'methods' => 'POST',
		'callback' => __NAMESPACE__ . '\\post_media',
		'args' => array(
			'id' => array(
				'validate_callback' => function($param, $request, $key) {
					return is_numeric( $param );
				}
			),
		),
	) );
	register_rest_route( 'dynamix/v1', '/allmedias', array(
		'methods' => 'POST',
		'callback' => __NAMESPACE__ . '\\allmedias',
		'args' => array(
			'id' => array(
				'validate_callback' => function($param, $request, $key) {
					return is_numeric( $param );
				}
			),
		),
	) );
	register_rest_route( 'dynamix/v1', '/condidates', array(
		'methods' => 'POST',
		'callback' => __NAMESPACE__ . '\\getcondidates',
		'args' => array(
			'id' => array(
				'validate_callback' => function($param, $request, $key) {
					return is_numeric( $param );
				}
			),
		),
	) );
	register_rest_route( 'dynamix/v1', '/logout', array(
		'methods'             => 'POST',
		'callback'            => __NAMESPACE__ . '\\logout'
   ) );
} );

function get_mods( $data ) {
	return get_theme_mods();
}

function post_logo( \WP_REST_Request $request ) {
	$query_images_args = array(
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'post_status'    => 'inherit',
		'posts_per_page' => - 1,
	);
	
	$query_images = new \WP_Query( $query_images_args );
	
	$images = array();
	foreach ( $query_images->posts as $image ) {
		$images[] = wp_get_attachment_url( $image->ID );
	}

      // Prepare array for output
      $output = array();

      // Request the data send
      $sendData = $request->get_params();

      // Identify user
      $user = wp_get_current_user();

      // Which user is logged in?
      $userID = $user->ID;

      // Get the upload files
      $files = $request->get_file_params();

      // These files need to be included as dependencies when on the front end.
    	require_once( ABSPATH . 'wp-admin/includes/image.php' );
    	require_once( ABSPATH . 'wp-admin/includes/file.php' );
    	require_once( ABSPATH . 'wp-admin/includes/media.php' );

      // Process images
      if (!empty($files)) {
        $upload_overrides = array( 'test_form' => false );
        foreach ($files as $key => $file) {
          $attachment_id = media_handle_upload( $key, true );
          if ( is_wp_error( $attachment_id ) ) {
            $output['status'] = 'error';
        		$output['message'] = '- The image could not be uploaded.';
            return $output;
        	} else {
            // Success
            $output['status'] = 'success';
            $output['message'] = 'File '.$attachment_id.' uploaded.';
            $output['image'] = $images;
        	}
        }
      }
      
      return $output;
}
function post_media( \WP_REST_Request $request ) {
	$query_images_args = array(
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'post_status'    => 'inherit',
		'posts_per_page' => - 1,
	);
	
	$query_images = new \WP_Query( $query_images_args );
	
	$images = array();
	foreach ( $query_images->posts as $image ) {
		$images[] = wp_get_attachment_url( $image->ID );
	}

      // Prepare array for output
      $output = array();

      // Request the data send
      $sendData = $request->get_params();

      // Identify user
      $user = wp_get_current_user();

      // Which user is logged in?
      $userID = $user->ID;

      // Get the upload files
      $files = $request->get_file_params();

      // These files need to be included as dependencies when on the front end.
    	require_once( ABSPATH . 'wp-admin/includes/image.php' );
    	require_once( ABSPATH . 'wp-admin/includes/file.php' );
    	require_once( ABSPATH . 'wp-admin/includes/media.php' );

      // Process images
      if (!empty($files)) {
        $upload_overrides = array( 'test_form' => false );
        foreach ($files as $key => $file) {
          $attachment_id = media_handle_upload( $key, true );
          if ( is_wp_error( $attachment_id ) ) {
            $output['status'] = 'error';
        		$output['message'] = '- The image could not be uploaded.';
            return $output;
        	}
        }
      }
      
	$query_images_args = array(
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'post_status'    => 'inherit',
		'posts_per_page' => - 1,
	);
	
	$query_images = new \WP_Query( $query_images_args );
	
	$images =  array();
	foreach ( $query_images->posts as $image ) {
		$img = new \stdClass();
		$img->name = get_the_title( $image->ID );
		$img->url = wp_get_attachment_url( $image->ID );
		$img->id = $image->ID ;
		$images[] = $img;
	}
      
    return $images;
}


function allmedias( \WP_REST_Request $request ) {
	$offset = 0 ;
	$per_page = 10 ;
	if(isset($request['offset'])){
		$offset = $request['offset'];
	}
	if(isset($request['per_page'])){
		$per_page = $request['per_page'];
	}
	$query_images_args = array(
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'post_status'    => 'inherit',
		'posts_per_page' => $per_page,
		'offset' => $offset,
	);
	
	$query_images = new \WP_Query( $query_images_args );
	
	$images =  array();
	foreach ( $query_images->posts as $image ) {
		$img = new \stdClass();
		$img->name = get_the_title( $image->ID );
		$img->url = wp_get_attachment_url( $image->ID );
		$img->id = $image->ID ;
		$images[] = $img;
	}
      
	// return $images;
	$query_posts_count = new \WP_Query( array(
		'post_type'      => 'attachment',
		'post_status'    => 'inherit',
		'posts_per_page' => -1
	) );
	$totlal = count($query_posts_count->posts);
    return array(
		'lenght' => $totlal,
		// 'lenght' => wp_count_posts('condidate')->pending,
		'data' => $images,
		'page' => ($offset/$per_page)+1,
	);
}

function getcondidates( \WP_REST_Request $request ) {
	$offset = 0 ;
	$per_page = 5 ;
	if(isset($request['offset'])){
		$offset = $request['offset'];
	}
	if(isset($request['per_page'])){
		$per_page = $request['per_page'];
	}
	
	$query_posts_args = array(
		'post_type'      => 'condidate',
		'post_status'    => 'all',
		'posts_per_page' => $per_page,
		'offset' => $offset,
	);
	
	$query_posts = new \WP_Query( $query_posts_args );
	
	$datacndts = array();
	foreach ( $query_posts->posts as $post ) {
		$condidate = new \stdClass();
		$condidate->name = get_the_title( $post->ID );
		$condidate->status = get_post_status($post->ID);
		$condidate->meta = get_post_meta($post->ID, 'condidate_info');
		$condidate->id = $post->ID ;
		$datacndts[] = $condidate;
	}
	$query_posts_count = new \WP_Query( array(
		'post_type'      => 'condidate',
		'post_status'    => 'all',
		'posts_per_page' => -1
	) ); 
    return array(
		'lenght' => count($query_posts_count->posts),
		// 'lenght' => wp_count_posts('condidate')->pending,
		'data' => $datacndts
	);
}

function logout() {
	wp_logout();
	return true;
}