<?php

namespace App;

use Roots\Sage\Container;

/**
 * Get the sage container.
 *
 * @param string $abstract
 * @param array  $parameters
 * @param Container $container
 * @return Container|mixed
 */
function sage($abstract = null, $parameters = [], Container $container = null)
{
    $container = $container ?: Container::getInstance();
    if (!$abstract) {
        return $container;
    }
    return $container->bound($abstract)
        ? $container->makeWith($abstract, $parameters)
        : $container->makeWith("sage.{$abstract}", $parameters);
}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param array|string $key
 * @param mixed $default
 * @return mixed|\Roots\Sage\Config
 * @copyright Taylor Otwell
 * @link https://github.com/laravel/framework/blob/c0970285/src/Illuminate/Foundation/helpers.php#L254-L265
 */
function config($key = null, $default = null)
{
    if (is_null($key)) {
        return sage('config');
    }
    if (is_array($key)) {
        return sage('config')->set($key);
    }
    return sage('config')->get($key, $default);
}

/**
 * @param string $file
 * @param array $data
 * @return string
 */
function template($file, $data = [])
{
    return sage('blade')->render($file, $data);
}

/**
 * Retrieve path to a compiled blade view
 * @param $file
 * @param array $data
 * @return string
 */
function template_path($file, $data = [])
{
    return sage('blade')->compiledPath($file, $data);
}

/**
 * @param $asset
 * @return string
 */
function asset_path($asset)
{
    return sage('assets')->getUri($asset);
}

/**
 * @param string|string[] $templates Possible template files
 * @return array
 */
function filter_templates($templates)
{
    $paths = apply_filters('sage/filter_templates/paths', [
        'views',
        'resources/views'
    ]);
    $paths_pattern = "#^(" . implode('|', $paths) . ")/#";

    return collect($templates)
        ->map(function ($template) use ($paths_pattern) {
            /** Remove .blade.php/.blade/.php from template names */
            $template = preg_replace('#\.(blade\.?)?(php)?$#', '', ltrim($template));

            /** Remove partial $paths from the beginning of template names */
            if (strpos($template, '/')) {
                $template = preg_replace($paths_pattern, '', $template);
            }

            return $template;
        })
        ->flatMap(function ($template) use ($paths) {
            return collect($paths)
                ->flatMap(function ($path) use ($template) {
                    return [
                        "{$path}/{$template}.blade.php",
                        "{$path}/{$template}.php",
                    ];
                })
                ->concat([
                    "{$template}.blade.php",
                    "{$template}.php",
                ]);
        })
        ->filter()
        ->unique()
        ->all();
}

/**
 * @param string|string[] $templates Relative path to possible template files
 * @return string Location of the template
 */
function locate_template($templates)
{
    return \locate_template(filter_templates($templates));
}

/**
 * Determine whether to show the sidebar
 * @return bool
 */
function display_sidebar()
{
    static $display;
    isset($display) || $display = apply_filters('sage/display_sidebar', false);
    return $display;
}

// responsive Images
/*
function acf_responsive_image($image_id,$image_size,$max_width){

	// check the image ID is not blank
	if($image_id != '') {

		// set the default src image size
		$image_src = wp_get_attachment_image_url( $image_id, $image_size );

		// set the srcset with various image sizes
		$image_srcset = wp_get_attachment_image_srcset( $image_id, $image_size );

		// generate the markup for the responsive image
		echo 'src="'.$image_src.'" srcset="'.$image_srcset.'" sizes="(max-width: '.$max_width.') 100vw, '.$max_width.'"';

	}
}
*/


// Picturefill functions
function do_feature_picturefill ($image_id, $link = NULL, $size1="0", $size2="400", $size3="600", $size4="1000", $size5="1280", $size6="1440") {
	$xsmall = wp_get_attachment_image_src($image_id,'x-small');
	$small = wp_get_attachment_image_src($image_id,'small');
	$medium = wp_get_attachment_image_src($image_id,'medium');
	$large = wp_get_attachment_image_src($image_id,'large');
	$xlarge = wp_get_attachment_image_src($image_id,'x-large');
	$xxlarge = wp_get_attachment_image_src($image_id,'xx-large');
	$get_meta = get_post_meta($image_id);
	$alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
	if(empty($alt)){
		$alt = get_the_title($image_id);
	}
	$link = '';

	if($link):
		$link_open = '<a href="'.$link.'">';
		$link_close = '</a>';
	endif;

	return '
		<picture>
			'.$link_open.'
				<!--[if IE 9]><video style="display: none;"><![endif]-->
					<source srcset="'.$xxlarge[0].'" media="(min-width: '.$size6.'px)" alt="'.$alt.'">
					<source srcset="'.$xlarge[0].'" media="(min-width: '.$size5.'px)" alt="'.$alt.'">
					<source srcset="'.$large[0].'" media="(min-width: '.$size4.'px)" alt="'.$alt.'">
					<source srcset="'.$medium[0].'" media="(min-width: '.$size3.'px)" alt="'.$alt.'">
					<source srcset="'.$small[0].'" media="(min-width: '.$size2.'px)" alt="'.$alt.'">
				<!--[if IE 9]></video><![endif]-->
				<img srcset="'.$xsmall[0].'" alt="'.$alt.'">
			'.$link_close.'
		</picture>';
}

function do_page_feature_picturefill ($image_id, $link = NULL, $size1="0", $size2="600", $size3="1000", $size4="1280") {
	$small = wp_get_attachment_image_src($image_id,'small');
	$medium = wp_get_attachment_image_src($image_id,'medium');
	$large = wp_get_attachment_image_src($image_id,'large');
	$xlarge = wp_get_attachment_image_src($image_id,'x-large');
	$get_meta = get_post_meta($image_id);
	$alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
	if(empty($alt)){
		$alt = get_the_title($image_id);
	}
	$link = '';

	if($link):
		$link_open = '<a href="'.$link.'">';
		$link_close = '</a>';
	endif;

	return '
		<picture>
			'.$link_open.'
				<!--[if IE 9]><video style="display: none;"><![endif]-->
					<source srcset="'.$xlarge[0].'" media="(min-width: '.$size4.'px)" alt="'.$alt.'">
					<source srcset="'.$large[0].'" media="(min-width: '.$size3.'px)" alt="'.$alt.'">
					<source srcset="'.$medium[0].'" media="(min-width: '.$size2.'px)" alt="'.$alt.'">
				<!--[if IE 9]></video><![endif]-->
				<img srcset="'.$small[0].'" alt="'.$alt.'">
			'.$link_close.'
		</picture>';
}

function do_related_picturefill ($image_id, $alt, $link = NULL, $size1="0", $size2="768", $size3="1000") {

	$thumb = wp_get_attachment_image_src($image_id,'thumbnail');
	$xsmall = wp_get_attachment_image_src($image_id,'x-small');

	$link = '';

	if($link):
		$link_open = '<a href="'.$link.'">';
		$link_close = '</a>';
	endif;

	return '
		<picture>
			'.$link_open.'
				<!--[if IE 9]><video style="display: none;"><![endif]-->
					<source srcset="'.$xsmall[0].'" media="(min-width: '.$size2.'px)" alt="'.$alt.'" class="ui images fluid">
				<!--[if IE 9]></video><![endif]-->
				<img srcset="'.$thumb[0].'" alt="'.$alt.'" class="ui images fluid">
			'.$link_close.'
		</picture>';
}

function do_slide_picturefill ($image_id, $link = NULL, $class = NULL, $size1="0", $size2="760") {
	$medium = wp_get_attachment_image_src($image_id,'medium');
	$large = wp_get_attachment_image_src($image_id,'large');
	$get_meta = get_post_meta($image_id);
	$alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
	if(empty($alt)){
		$alt = get_the_title($image_id);
	}
	$link = '';

	if($link):
		$link_open = '<a href="'.$link.'">';
		$link_close = '</a>';
	endif;

	if($class):
		$class = 'class="'.$class.'"';
	endif;

	return '
		<picture>
			'.$link_open.'
				<!--[if IE 9]><video style="display: none;"><![endif]-->
					<source srcset="'.$large[0].'" media="(min-width: '.$size2.'px)" alt="'.$alt.'">
				<!--[if IE 9]></video><![endif]-->
				<img srcset="'.$medium[0].'" alt="'.$alt.'" '.$class.'>
			'.$link_close.'
		</picture>';
}

// Remove ACF WYISWIG auto formatting that adds p tags
function remove_content_formatting($content) {

    remove_filter( 'acf_the_content', 'wpautop' );
    the_field($content);
    add_filter( 'acf_the_content', 'wpautop' );

};

// custom work navigation
function custom_post_nav($post_type = '', $meta_key = '', $meta_value = '') {

    $pages = array();
    $args = array(
        'post_type' => $post_type,
        'meta_key' => $meta_key,
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'posts_per_page' => -1,
        'meta_type' => 'numeric',
        // 'meta_query' => array(
        //     'key' => $meta_key,
        //     'value' => $meta_value,
        //     'compare' => '>='
        // ),
       // 'meta_value' => $meta_value
     );
    $nav_posts = get_posts($args);

    foreach($nav_posts as $nav_post) {
        $pages[] += $nav_post->ID;
    }

    $id = get_the_id();

    $current = array_search($id, $pages);
    $prevID = $pages[$current-1];
    $nextID = $pages[$current+1];

    $total = count($pages);
    foreach ($pages as $mykey => $myval) {
        if ($myval== $id) {
            $key = ($mykey + 1);
            }
    }

    $output .= '<div class="grid-x grid-padding-x">';

    if (!empty($prevID)) {
        $output .= '<div class="cell auto"><a class="previous" href="'.get_permalink($prevID).'" title="'.get_the_title($prevID).'"><i class="icon-arrow-left"></i> Previous</a></div>';
    } else {
        $output .= '<div class="cell auto"><a class="previous" href="'.get_permalink(end($pages)).'" title="'.get_the_title(end($pages)).'"><i class="icon-arrow-left"></i> Previous</a></div>';
    }

    //$output .= '<div class="col-xs-2 count text-center"> '.$key.' / '.$total.'</div>';

    if (!empty($nextID)) {
        $output .= '<div class="cell auto text-right"><a class="next" href="'.get_permalink($nextID).'" title="'.get_the_title($nextID).'">Next <i class="icon-arrow-right"></i></a></div>';
    } else {
        $output .= '<div class="cell auto text-right"><a class="next" href="'.get_permalink(array_shift($pages)).'" title="'.get_the_title(array_shift($pages)).'">Next <i class="icon-arrow-right"></i></a></div>';
    }


    $output .= '</div>';

    return $output;

}

function the_breadcrumb() {

	// Settings
    $separator          = '<i class="icon-arrow-right"></i>';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = 'Home';

    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';

    // Get the query & post information
    global $post,$wp_query;

    // Do not display on the homepage
    if ( !is_front_page() ) {

        // Build the breadcrums
        echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '" class="no-print">';

        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';

        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {

            echo '<li class="item-current item-archive"><span class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</span></li>';

        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';

            }

            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><span class="bread-current bread-archive">' . $custom_tax_name . '</span></li>';

        } else if ( is_single() ) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';

            }

            // Get post category info
            $category = get_the_category();

            if(!empty($category)) {

                // Get last category post is in
                $last_category = end(array_values($category));

                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);

                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                    $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }

            }

            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {

                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;

            }

            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';

            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {

                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';

            } else {

                echo '<li class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';

            }

        } else if ( is_category() ) {

            // Category page
            echo '<li class="item-current item-cat"><span class="bread-current bread-cat">' . single_cat_title('', false) . '</span></li>';

        } else if ( is_page() ) {

            // Standard page
            if( $post->post_parent ){

                // If child page, get parents
                $anc = get_post_ancestors( $post->ID );

                // Get parents in the right order
                $anc = array_reverse($anc);

                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }

                // Display parent pages
                echo $parents;

                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><span title="' . get_the_title() . '"> ' . get_the_title() . '</span></li>';

            } else {

                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</span></li>';

            }

        } else if ( is_tag() ) {

            // Tag page

            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;

            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><span class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</span></li>';

        } elseif ( is_day() ) {

            // Day archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';

            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><span class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</span></li>';

        } else if ( is_month() ) {

            // Month Archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><span class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</span></li>';

        } else if ( is_year() ) {

            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><span class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</span></li>';

        } else if ( is_author() ) {

            // Auhor archive

            // Get the author information
            global $author;
            $userdata = get_userdata( $author );

            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><span class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</span></li>';

        } else if ( get_query_var('paged') ) {

            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><span class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</span></li>';

        } else if ( is_search() ) {

            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><span class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</span></li>';

        } elseif ( is_404() ) {

            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }

        echo '</ul>';

    }
}


// class Nav_Menu_Walker extends Walker_Nav_Menu
// {
//     /*
//      * Add ui text menu class
//      */

//     function start_lvl( &$output, $depth = 0, $args = array() ) {
//         $indent = str_repeat("\t", $depth);
//         $output .= "\n$indent<div class=\"ui text menu\">\n";
//     }
// }

// function nav_menu_fallback($args)
// {
//     /*
//      * Instantiate new Page Walker class instead of applying a filter to the
//      * "wp_page_menu" function in the event there are multiple active menus in theme.
//      */

//     $walker_page = new Walker_Page();
//     $fallback = $walker_page->walk(get_pages(), 0);
//     $fallback = str_replace("children", "ui right dropdown menu", $fallback);
//     echo '<div class="ui text menu">'.$fallback.'</div>';
// }
