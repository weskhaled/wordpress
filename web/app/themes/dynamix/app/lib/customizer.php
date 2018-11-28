<?php
// lib/customizer.php

namespace App;
use WP_Customize_Control;

class My_Dropdown_Category_Control extends WP_Customize_Control {

	public $type = 'dropdown-category';

	protected $dropdown_args = false;

	protected function render_content() {
		?><label><?php

		if ( ! empty( $this->label ) ) :
			?><span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span><?php
		endif;

		if ( ! empty( $this->description ) ) :
			?><span class="description customize-control-description"><?php echo $this->description; ?></span><?php
		endif;

		$dropdown_args = wp_parse_args( $this->dropdown_args, array(
			'taxonomy'          => '',
			'post_type'         => 'page',
			'show_option_none'  => ' ',
			'selected'          => $this->value(),
			'show_option_all'   => '',
			'orderby'           => 'id',
			'order'             => 'ASC',
			'show_count'        => 1,
			'hide_empty'        => 1,
			'child_of'          => 0,
			'exclude'           => '',
			'hierarchical'      => 1,
			'depth'             => 0,
			'tab_index'         => 0,
			'hide_if_empty'     => false,
			'option_none_value' => 0,
			'value_field'       => '',
		) );

		$dropdown_args['echo'] = false;

		$dropdown = wp_dropdown_pages( $dropdown_args );
		$dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );
		echo $dropdown;

		?></label><?php

	}
}

/**
 * Add postMessage support
 */
function customize_register($wp_customize) {
  $wp_customize->get_setting('blogname')->transport = 'postMessage';

  // remove defaults
  // $wp_customize->remove_panel( 'widgets' );
  $wp_customize->remove_section( 'static_front_page' );
  // remove nav menus
  remove_action( 'customize_controls_enqueue_scripts', array( $wp_customize->nav_menus, 'enqueue_scripts' ) );
  remove_action( 'customize_register', array( $wp_customize->nav_menus, 'customize_register' ), 11 );
  remove_filter( 'customize_dynamic_setting_args', array( $wp_customize->nav_menus, 'filter_dynamic_setting_args' ) );
  remove_filter( 'customize_dynamic_setting_class', array( $wp_customize->nav_menus, 'filter_dynamic_setting_class' ) );
  remove_action( 'customize_controls_print_footer_scripts', array( $wp_customize->nav_menus, 'print_templates' ) );
  remove_action( 'customize_controls_print_footer_scripts', array( $wp_customize->nav_menus, 'available_items_template' ) );
  remove_action( 'customize_preview_init', array( $wp_customize->nav_menus, 'customize_preview_init' ) );

  $wp_customize->add_setting('upload_logo');

  $wp_customize->add_control(
    new \WP_Customize_Image_Control(
      $wp_customize,
      'upload_logo',
      array(
        'label' => 'Logo',
        'section' => 'title_tagline',
        'settings' => 'upload_logo',
        'transport' => 'postMessage'
      )
    )
  );

  $wp_customize->add_setting(
    'upload_logo_width',
    array(
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field'
    )
  );

  $wp_customize->add_control(
    'upload_logo_width',
    array(
      'label' => 'Logo Max Width',
      'section' => 'title_tagline',
      'settings' => 'upload_logo_width',
      'transport' => 'postMessage'
    )
  );


  $wp_customize->add_section(
      'colours',
      array(
          'title' => 'Colours',
          'description' => 'Change the colours of the theme.',
          'priority' => 35,
      )
  );

  $wp_customize->add_setting(
    'primary_colour',
    array(
      'default' => '#00BAFF',
      'sanitize_callback' => 'sanitize_hex_color',
      'transport' => 'postMessage'
    )
  );

  $wp_customize->add_control(
    new \WP_Customize_Color_Control(
      $wp_customize,
      'primary_colour',
      array(
        'label' => 'Primary Colour',
        'section' => 'colours',
        'settings' => 'primary_colour'
      )
    )
  );

  $wp_customize->add_setting(
    'secondary_colour',
    array(
      'default' => '#FFA500',
      'sanitize_callback' => 'sanitize_hex_color',
      'transport' => 'postMessage'
    )
  );

  $wp_customize->add_control(
    new \WP_Customize_Color_Control(
      $wp_customize,
      'secondary_colour',
      array(
        'label' => 'Secondary Colour',
        'section' => 'colours',
        'settings' => 'secondary_colour'
      )
    )
  );

  $wp_customize->add_setting(
    'header_background_colour',
    array(
      'default' => '#00BAFF',
      'sanitize_callback' => 'sanitize_hex_color',
      'transport' => 'postMessage'
    )
  );

  $wp_customize->add_control(
    new \WP_Customize_Color_Control(
      $wp_customize,
      'header_background_colour',
      array(
        'label' => 'Header Background Colour',
        'section' => 'colours',
        'settings' => 'header_background_colour'
      )
    )
  );

  $wp_customize->add_setting(
    'header_font_colour',
    array(
      'default' => '#fff',
      'sanitize_callback' => 'sanitize_hex_color',
      'transport' => 'postMessage'
    )
  );

  $wp_customize->add_control(
    new \WP_Customize_Color_Control(
      $wp_customize,
      'header_font_colour',
      array(
        'label' => 'Header Font Colour',
        'section' => 'colours',
        'settings' => 'header_font_colour'
      )
    )
  );

  $wp_customize->add_setting(
    'mobile_menu_hover_colour',
    array(
      'default' => '#1e73be',
      'sanitize_callback' => 'sanitize_hex_color',
      'transport' => 'postMessage'
    )
  );

  $wp_customize->add_control(
    new \WP_Customize_Color_Control(
      $wp_customize,
      'mobile_menu_hover_colour',
      array(
        'label' => 'Mobile Menu Hover Colour',
        'section' => 'colours',
        'settings' => 'mobile_menu_hover_colour'
      )
    )
  );

  $wp_customize->add_setting(
    'footer_background_colour',
    array(
      'default' => '#6b5488',
      'sanitize_callback' => 'sanitize_hex_color',
      'transport' => 'postMessage'
    )
  );

  $wp_customize->add_control(
    new \WP_Customize_Color_Control(
      $wp_customize,
      'footer_background_colour',
      array(
        'label' => 'Footer Background Colour',
        'section' => 'colours',
        'settings' => 'footer_background_colour'
      )
    )
  );

  $wp_customize->add_setting(
    'footer_font_colour',
    array(
      'default' => '#fff',
      'sanitize_callback' => 'sanitize_hex_color',
      'transport' => 'postMessage'
    )
  );

  $wp_customize->add_control(
    new \WP_Customize_Color_Control(
      $wp_customize,
      'footer_font_colour',
      array(
        'label' => 'Footer Font Colour',
        'section' => 'colours',
        'settings' => 'footer_font_colour'
      )
    )
  );


  $wp_customize->add_section(
      'header',
      array(
          'title' => 'Header',
          'description' => 'Change the options for the header',
          'priority' => 35,
      )
  );

  $wp_customize->add_setting(
    'header_fixed'
  );

  $wp_customize->add_control(
    'header_fixed',
    array(
      'type' => 'checkbox',
      'label' => 'Should the header fixed on scroll?',
      'section' => 'header'
    )
  );
  $wp_customize->add_setting(
    'submit_cv'
  );


  // $wp_customize->add_control(
  //   'submit_cv',
  //   array(
  //       'type' => new My_Dropdown_Category_Control( $wp_customize, 'submit_cv', array(
  //       'section'       => 'header',
  //       'label'         => esc_html__( 'Slider posts category', 'olsen-light-child' ),
  //       'description'   => esc_html__( 'Select the category that the slider will show posts from. If no category is selected, the slider will be disabled.', 'olsen-light-child' ),
  //       )),
  //     'label' => 'Should the header fixed on scroll?',
  //     'section' => 'header'
  //   )
  // );

	$wp_customize->add_control( 
    new My_Dropdown_Category_Control( $wp_customize, 'submit_cv', array(
		'section'       => 'header',
		'label'         => esc_html__( 'Slider posts category', 'olsen-light-child' ),
		'description'   => esc_html__( 'Select the category that the slider will show posts from. If no category is selected, the slider will be disabled.', 'olsen-light-child' ),
	) ) );
// section contact
$wp_customize->add_section(
    'contactdetails',
    array(
        'title' => 'Contact Details',
        'description' => 'Manage the contact details',
        'priority' => 35,
    )
);

$wp_customize->add_setting(
  'address',
  array(
    'default' => '',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage'
  )
);

$wp_customize->add_control(
  'address',
  array(
    'label' => 'Address',
    'section' => 'contactdetails',
    'settings' => 'address'
  )
);

  $wp_customize->add_setting(
    'phonenumber_humans',
    array(
      'default' => '0121 123 4567',
      'sanitize_callback' => 'sanitize_text_field',
      'transport' => 'postMessage'
    )
  );

  $wp_customize->add_control(
    'phonenumber_humans',
    array(
      'label' => 'Phone Number (for humans)',
      'section' => 'contactdetails',
      'settings' => 'phonenumber_humans'
    )
  );

  $wp_customize->add_setting(
    'phonenumber_robots',
    array(
      'default' => '+441211234567',
      'sanitize_callback' => 'sanitize_text_field',
      'transport' => 'postMessage'
    )
  );

  $wp_customize->add_control(
    'phonenumber_robots',
    array(
      'label' => 'Phone Number (for robots)',
      'section' => 'contactdetails',
      'settings' => 'phonenumber_robots'
    )
  );

  $wp_customize->add_setting(
    'email_address',
    array(
      'default' => 'info@example.com',
      'sanitize_callback' => 'sanitize_text_field',
      'transport' => 'postMessage'
    )
  );

  $wp_customize->add_control(
    'email_address',
    array(
      'label' => 'Email Address',
      'section' => 'contactdetails',
      'settings' => 'email_address'
    )
  );

  $wp_customize->add_setting(
    'twitter',
    array(
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field'
    )
  );

  $wp_customize->add_control(
    'twitter',
    array(
      'label' => 'Twitter',
      'section' => 'contactdetails',
      'settings' => 'twitter'
    )
  );

  $wp_customize->add_setting(
    'facebook',
    array(
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field'
    )
  );

  $wp_customize->add_control(
    'facebook',
    array(
      'label' => 'Facebook',
      'section' => 'contactdetails',
      'settings' => 'facebook'
    )
  );

  $wp_customize->add_setting(
    'linkedin',
    array(
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field'
    )
  );

  $wp_customize->add_control(
    'linkedin',
    array(
      'label' => 'LinkedIn',
      'section' => 'contactdetails',
      'settings' => 'linkedin'
    )
  );

}
add_action('customize_register', __NAMESPACE__ . '\\customize_register');

// Print styles
function print_styles() {
  $primary_colour                                   = get_theme_mod('primary_colour');
  $secondary_colour                                 = get_theme_mod('secondary_colour');
  $header_background_colour                         = get_theme_mod('header_background_colour');
  $header_font_colour                               = get_theme_mod('header_font_colour');
  $mobile_menu_hover_colour                         = get_theme_mod('mobile_menu_hover_colour');
  $footer_background_colour                         = get_theme_mod('footer_background_colour');
  $footer_font_colour                               = get_theme_mod('footer_font_colour');
?>
<style>
    <?php if ($primary_colour) : ?>
      .Primary-bg-c {
        background-color: <?= $primary_colour; ?> !important;
      }
      .Primary-bg-c a {
        color: #FFF !important;
      }
      .Primary-bg-c a:hover {
        color: #FFF !important;
        text-decoration: underline;
      }
      .Primary-bg-c p a {
        color: #FFF !important;
      }
      .Primary-bg-c p a:hover {
        color: #FFF !important;
        text-decoration: underline;
      }
      .Primary-c {
        color: <?= $primary_colour; ?> !important;
      }
      .Primary-c--hover:hover {
        color: <?= $primary_colour; ?> !important;
      }
      .Primary-bo-c {
        border-color: <?= $primary_colour; ?> !important;
      }
      .Primary-bo-c:hover {
        background-color: <?= $primary_colour; ?> !important;
        color: #FFFFFF !important;
      }
    <?php endif; ?>

    <?php if ($secondary_colour) : ?>
      h2::before {
        background: <?= $secondary_colour; ?> !important;
      }
      .Breakout-text::before,
      .Breakout-text::after {
        color: <?= $secondary_colour; ?> !important;
      }
      p a {
        color: <?= $secondary_colour; ?> !important;
      }
    <?php endif; ?>

    <?php if ($header_background_colour) : ?>
      .Header {
        background-color: <?= $header_background_colour; ?> !important;
      }
      #shiftnav-main {
        background-color: <?= $header_background_colour; ?> !important;
      }
    <?php endif; ?>

    <?php if ($header_font_colour) : ?>
      .Header a {
        color: <?= $header_font_colour; ?> !important;
      }
      .shiftnav ul.shiftnav-menu li.menu-item > .shiftnav-target {
        color: <?= $header_font_colour; ?> !important;
      }
      .Menu-burger span {
        background: <?= $header_font_colour; ?> !important;
      }
    <?php endif; ?>

    <?php if ($mobile_menu_hover_colour) : ?>
      .shiftnav ul.shiftnav-menu li.menu-item > .shiftnav-target:hover {
        background-color: <?= $mobile_menu_hover_colour; ?> !important;
      }
    <?php endif; ?>

    <?php if ($footer_background_colour) : ?>
      footer .footer-container {
        background-color: <?= $footer_background_colour; ?> !important;
      }
    <?php endif; ?>

    <?php if ($footer_font_colour) : ?>
      .Footer {
        color: <?= $footer_font_colour; ?> !important;
      }
      .Footer .icon,
      .Footer .icon path  {
        fill: <?= $footer_font_colour; ?> !important;
      }
    <?php endif; ?>

  </style>
<?php
}
add_action('wp_head', __NAMESPACE__ . '\\print_styles');

/**
 * Customizer JS

function customize_preview_js() {
  wp_enqueue_script('sage/customizer', asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
}
add_action('customize_preview_init', __NAMESPACE__ . '\\customize_preview_js');
 */
 
/**
 * Theme customizer
*/
add_action('customize_register', function (\WP_Customize_Manager $wp_customize) {
    // Add postMessage support
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->selective_refresh->add_partial('blogname', [
        'selector' => '.brand',
        'render_callback' => function () {
            bloginfo('name');
        }
    ]);
});

/**
 * Customizer JS
 */
add_action('customize_controls_enqueue_scripts', function () {
    wp_enqueue_script('sage/customizer.js', asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
});