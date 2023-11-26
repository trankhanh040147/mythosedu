<?php

namespace CoreSystem\Modules\ExtensionsDDL\Inc;

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use CoreSystem\Modules\ExtensionsDDL\Inc\Controls\Groups\Icon;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;

class Helper {

	public static function get_post_types(){
        // Get Post Types
        $post_types = get_post_types( array(
            'public'            => true,
            'show_in_nav_menus' => true
        ) );

        return $post_types;
    }

    public static function get_post_categories() {

        $options = array();

        $terms = get_terms( array(
            'taxonomy'      => 'category',
            'hide_empty'    => true,
        ));

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            foreach ( $terms as $term ) {
                $options[ $term->term_id ] = $term->name;
            }
        }

        return $options;
    }

    public static function get_tags() {

        $options = array();

        $tags = get_tags();

        foreach ( $tags as $tag ) {
            $options[ $tag->term_id ] = $tag->name;
        }

        return $options;
    }


    public static function get_posts() {

        $post_list = get_posts( array(
            'post_type'         => 'post',
            'orderby'           => 'date',
            'order'             => 'DESC',
            'posts_per_page'    => -1,
        ) );

        $posts = array();

        if ( ! empty( $post_list ) && ! is_wp_error( $post_list ) ) {
            foreach ( $post_list as $post ) {
                $posts[ $post->ID ] = $post->post_title;
            }
        }

        return $posts;
    }

    public static function get_authors() {

        $options = array();

        $users = get_users();

        foreach ( $users as $user ) {
            $options[ $user->ID ] = $user->display_name;
        }

        return $options;
    }

	public static function get_modules() {
		$modules = [
			'timeline'          => [ 'name' => 'Timeline', 'enabled' => true, 'type' => 'widget' ],
			'table'             => [ 'name' => 'Table', 'enabled' => true, 'type' => 'widget' ],
			/*'info-circle'       => [ 'name' => 'Info Circle', 'enabled' => true, 'type' => 'widget' ],
			'comparison-table'  => [ 'name' => 'Comparison Table', 'enabled' => true, 'type' => 'widget' ],
			'image-compare'     => [ 'name' => 'Image Compare', 'enabled' => true, 'type' => 'widget' ],
			'animated-text'     => [ 'name' => 'Animated Text', 'enabled' => true, 'type' => 'widget' ],
			'dual-button'       => [ 'name' => 'Dual Button', 'enabled' => true, 'type' => 'widget' ],
			'particles'         => [ 'name' => 'Particles', 'enabled' => true, 'type' => 'feature' ],
            //'ribbon-badges'     => [ 'name' => 'Ribbon & Badges', 'enabled' => true, 'type' => 'feature' ],
            'wrapper-links'     => [ 'name' => 'Wrapper Link', 'enabled' => true, 'type' => 'feature' ],
			'modal-popup'       => [ 'name' => 'Modal Popup', 'enabled' => true, 'type' => 'widget' ],
			'progress-bar'      => [ 'name' => 'Progress Bar', 'enabled' => true, 'type' => 'widget' ],
			'flip-box'          => [ 'name' => 'Flip Box', 'enabled' => true, 'type' => 'widget' ],
			'split-text'        => [ 'name' => 'Split Text', 'enabled' => true, 'type' => 'widget' ],
			'gmap'              => [ 'name' => 'Google Map', 'enabled' => true, 'type' => 'widget' ],
			'text-separator'    => [ 'name' => 'Text Separator', 'enabled' => true, 'type' => 'widget' ],
			'price-table'       => [ 'name' => 'Price Table', 'enabled' => true, 'type' => 'widget' ],
			'twitter'           => [ 'name' => 'Twitter', 'enabled' => true, 'type' => 'widget' ],
			'bg-slider'         => [ 'name' => 'Background Slider', 'enabled' => true, 'type' => 'feature' ],
			'animated-gradient' => [ 'name' => 'Animated Gradient', 'enabled' => true, 'type' => 'feature' ],
			'post-list'         => [ 'name' => 'Post List', 'enabled' => true, 'type' => 'widget' ],
			'shape-separator'   => [ 'name' => 'Shape Separator', 'enabled' => true, 'type' => 'widget' ],
			'filterable-gallery'   => [ 'name' => 'Filterable Gallery', 'enabled' => true, 'type' => 'widget' ],
			*/
		];

		$modules = apply_filters('core_co_active_modules', $modules);

		return $modules;
	}
}