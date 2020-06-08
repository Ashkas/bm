<?php

namespace App;

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
add_action('customize_preview_init', function () {
    wp_enqueue_script('sage/customizer.js', asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
});

/**
 * Remove default description column from category
 * https://gist.github.com/jacobwise/c4cb6192e15268a7a2e1
 */
function jw_remove_taxonomy_description($columns)
{
 // only edit the columns on the current taxonomy, replace category with your custom taxonomy (don't forget to change in the filter as well)
 if ( !isset($_GET['taxonomy']) || $_GET['taxonomy'] != 'series' )
 return $columns;

 // unset the description columns
 if ( $posts = $columns['description'] ){ unset($columns['description']); }
 return $columns;
}
add_filter('manage_edit-category_columns','jw_remove_taxonomy_description');
