<?php
namespace App;
add_filter('excerpt_length', function() {
    return 10;
  });

/**
 * Extend Recent Posts Widget 
 *
 * Adds different formatting to the default WordPress Recent Posts Widget
 */

Class My_Recent_Posts_Widget extends \WP_Widget_Recent_Posts {

	function widget($args, $instance) {
	
		extract( $args );
		
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts') : $instance['title'], $instance, $this->id_base);
				
		if( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
			$number = 10;
					
		$r = new \WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
		if( $r->have_posts() ) :
			
			echo $before_widget;
            if( $title ) echo $before_title . $title . $after_title; ?>

            <?php while( $r->have_posts() ) : $r->the_post(); ?>	
                <div data-href="<?php the_permalink(); ?>" class="media post col-md-12">
                    <div class="media-body">
                        <h4 class="media-heading"><?php the_title(); ?></h4>
                        <div class="post-excerpt"><?php the_excerpt(); ?></div>
                        <span class="date color-white bg-black float-sm-right"><?php the_time( 'F d'); ?></span>
                    </div>
                </div>
            <?php endwhile; ?>
			 
			<?php
			echo $after_widget;
		
		wp_reset_postdata();
		
		endif;
	}
}
function my_recent_widget_registration() {
  unregister_widget('WP_Widget_Recent_Posts');
  register_widget('App\\My_Recent_Posts_Widget');
}
add_action('widgets_init', __NAMESPACE__ . '\\my_recent_widget_registration');

// require_once 'lib/customizer.php';
require_once 'lib/post_type/slider.php';
require_once 'lib/post_type/quote.php';
require_once 'lib/post_type/partner.php';
