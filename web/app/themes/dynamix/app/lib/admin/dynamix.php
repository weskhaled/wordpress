<?php
namespace App;

use Roots\Sage\Assets\JsonManifest;
/**
 * Add Menu Admin
 */
add_action('wp_before_admin_bar_render', function () {
	global $wp_admin_bar;
	$args = array(
		'id'     => 'fd_t_1',
		'title'  => __( 'Dynamix Admin', 'text_domain' ),
		'href'   => get_site_url().'/wp-admin/admin.php?page=settings',
		'meta'   => array(
//			'class'    => 'btn',
			// 'onclick'  => 'dyna_admin_page()',
			'title'    => 'admin link',
		),
	);
    $wp_admin_bar->add_menu( $args );
    });
add_action('admin_menu', function () {
    add_menu_page( __( 'Dynamix' .' Theme Panel' ), __( 'Dynamix Panel' ), 'manage_options', 'settings', function(){
		require_once 'pages/index.php';
    });
});
/**
 * Customize JS
 */

// add_action('admin_enqueue_scripts', function () {
// 	//replace with your page "id"
// 	if($_GET["page"] == "settings")
// 	{
// 		// wp_enqueue_style('sage/admin.css', asset_path('styles/admin.css'), false, null);
// 		// wp_enqueue_script('sage/admin.js', asset_path('scripts/admin.js'), [], null, true);

// 	}
// });

add_action('admin_enqueue_scripts', function () {
	if(isset($_GET["page"]) && $_GET["page"] == "settings")
	{
		wp_enqueue_style('sage/admin.css', asset_path('styles/admin.css'), false, null);
		wp_enqueue_script('sage/admin.js', asset_path('scripts/admin.js'), ['jquery'], null, true);
		$ajax_params = array(
			'templateUrl' => get_option('siteurl'),
			'ajax_url' => admin_url('admin-ajax.php'),
			'ajax_nonce' => wp_create_nonce('my_nonce'),
		);
		$wpApiSettings = array(
			'root' => esc_url_raw( rest_url() ),
			'nonce' => wp_create_nonce( 'wp_rest' ),
		);
		wp_localize_script('sage/admin.js', 'ajax_object', $ajax_params);
		wp_localize_script('sage/admin.js', 'wpApiSettings', $wpApiSettings);
	}
}, 100);