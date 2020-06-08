<?php

namespace App;

/**
 * Add <body> classes
 */
add_filter('body_class', function (array $classes) {
    /** Add page slug if it doesn't exist */
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    /** Add class if sidebar is active */
    if (display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    /** Clean up class names for custom templates */
    $classes = array_map(function ($class) {
        return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
    }, $classes);

    return array_filter($classes);
});

/**
 * Add "… Continued" to the excerpt
 */
add_filter('excerpt_more', function () {
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
});

/**
 * Template Hierarchy should search for .blade.php files
 */
collect([
    'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment'
])->map(function ($type) {
    add_filter("{$type}_template_hierarchy", __NAMESPACE__.'\\filter_templates');
});

/**
 * Render page using Blade
 */
add_filter('template_include', function ($template) {
    collect(['get_header', 'wp_head'])->each(function ($tag) {
        ob_start();
        do_action($tag);
        $output = ob_get_clean();
        remove_all_actions($tag);
        add_action($tag, function () use ($output) {
            echo $output;
        });
    });
    $data = collect(get_body_class())->reduce(function ($data, $class) use ($template) {
        return apply_filters("sage/template/{$class}/data", $data, $template);
    }, []);
    if ($template) {
        echo template($template, $data);
        return get_stylesheet_directory().'/index.php';
    }
    return $template;
}, PHP_INT_MAX);

/**
 * Render comments.blade.php
 */
add_filter('comments_template', function ($comments_template) {
    $comments_template = str_replace(
        [get_stylesheet_directory(), get_template_directory()],
        '',
        $comments_template
    );

    $data = collect(get_body_class())->reduce(function ($data, $class) use ($comments_template) {
        return apply_filters("sage/template/{$class}/data", $data, $comments_template);
    }, []);

    $theme_template = locate_template(["views/{$comments_template}", $comments_template]);

    if ($theme_template) {
        echo template($theme_template, $data);
        return get_stylesheet_directory().'/index.php';
    }

    return $comments_template;
}, 100);

// Change output to to data-src from src
add_filter( 'wp_get_attachment_image_attributes', function ($attr) {
    $attr['data-src'] = $attr['src'];
    return $attr;
});

// ACF JSON optimised saving
add_filter('acf/settings/save_json',function( $path ) {

    // update path
    $path = get_stylesheet_directory() . '/acf-json';


    // return
    return $path;

});

add_filter('acf/settings/load_json', function( $paths ) {

    // remove original path (optional)
    unset($paths[0]);


    // append path
    $paths[] = get_stylesheet_directory() . '/acf-json';


    // return
    return $paths;

});


// Collapse ACF Repeater fields on default
add_action( 'acf/input/admin_head', function() {
  ?>
    <style id="wpster-acf-repeater-collapse">.acf-repeater .acf-table {display:none;}</style>
    <script type="text/javascript">
        jQuery(function($) {
            $('.acf-repeater .acf-row').addClass('-collapsed');
            $('#wpster-acf-repeater-collapse').detach();
        });
    </script>

<?php });

// Change colour of repeater number block in rows
add_action( 'acf/input/admin_head', function() {
    ?>
        <style id="wpster-acf-repeater-collapse">
            .acf-repeater .acf-row-handle.order {
                background: #23282d;
                color: #ffffff;
                text-shadow: none;
            }

            .acf-repeater .acf-row-handle.order:hover {
                background: #666666;
                color: #ffffff;
            }
        </style>
  <?php });

add_filter( 'mce_buttons' , function ( $buttons ) {
	/**
	 * Add in a core button that's disabled by default
	 */
	$buttons[] = 'superscript';
	$buttons[] = 'subscript';

	return $buttons;
});

// TinyMCE: First line toolbar customizations
/*
add_filter( 'mce_buttons_2' , function ( $buttons ) {

    $buttons[] = 'sup';
  	$buttons[] = 'sub';

  	return $buttons;
*/
		// The settings are returned in this array. Customize to suite your needs.
/*
		return array(
			'formatselect', 'bold', 'italic', 'sub', 'sup', 'bullist', 'numlist', 'link', 'unlink', 'blockquote', 'outdent', 'indent', 'charmap', 'removeformat', 'spellchecker', 'fullscreen', 'wp_more', 'wp_help'
		);
*/
		/* WordPress Default
		return array(
			'bold', 'italic', 'strikethrough', 'separator',
			'bullist', 'numlist', 'blockquote', 'separator',
			'justifyleft', 'justifycenter', 'justifyright', 'separator',
			'link', 'unlink', 'wp_more', 'separator',
			'spellchecker', 'fullscreen', 'wp_adv'
		); */
// 	}, 0);


/**
 * Custom WYSIWIG
 */

add_filter( 'acf/fields/wysiwyg/toolbars' , function ( $toolbars ) {
	// Uncomment to view format of $toolbars

	// echo '< pre >';
	// 	print_r($toolbars);
	// echo '< /pre >';
	//die;


	// Add a new toolbar called "Very Simple"
	// - this toolbar has only 1 row of buttons
	$toolbars['Custom' ] = array();
	$toolbars['Custom' ][1] = array('bold' , 'italic', 'underline', 'superscript', 'subscript', 'blockquote', 'bullist', 'numlist', 'pastetext', 'removeformat', 'link', 'fullscreen' );

	// remove the 'Basic' toolbar completely
	unset( $toolbars['Basic' ] );

	// return $toolbars - IMPORTANT!
	return $toolbars;
});



// Remove ACF WYISWIG auto formatting that adds p tags
// add_filter('acf/init', function ($content) {

//     remove_filter( 'acf_the_content', 'wpautop' );
//     return $content;

// });

/**
 * Add height field to ACF WYSIWYG
 */


// Remove ACF inline styles for WYSIWYG, then set the height via css in the next part
add_action('acf/input/admin_footer', function() { ?>
	<script type="text/javascript">
		(function($) {
			acf.add_action('wysiwyg_tinymce_init', function( ed, id, mceInit, $field ){
				$(".acf-field .acf-editor-wrap iframe").removeAttr("style");
			});
		})(jQuery);
	</script>
<?php });

add_action('acf/input/admin_head', function() {
        ?>
        <style type="text/css">

        .acf-editor-wrap iframe {
            height: 100px;
            min-height: 100px;
            width: 100%;
        }
        .acf-editor-wrap .mce-fullscreen iframe{
            height: 700px;
            min-height: 700px;
            width: 100%;
        }

        </style>
        <?php
});

add_filter( 'tiny_mce_before_init', function( $mce_init ) {

	// make sure we don't override other custom <code>content_css</code> files
	$content_css = get_stylesheet_directory_uri() . '/editor.css';
	if (isset($mce_init[ 'content_css' ])) {
        $mce_init[ 'content_css' ] = "{$mce_init['content_css']},{$content_css}";
    }

    return $mce_init;
});

// Invsert custom CSS into the tinyMCE for ACF code
// Have to set a class name for each wyswig field in ACF that uses this
// https://gist.github.com/hereswhatidid/f88390659cbf1fd6a03d
// https://hereswhatidid.com/2015/08/customize-acf-wysiwyg-input-styles/
add_action('acf/input/admin_footer', function() {
	?>
	<script>
		( function( $) {
			acf.add_filter( 'wysiwyg_tinymce_settings', function( mceInit, id ) {
				// grab the classes defined within the field admin and put them in an array
				var classes = $( '#' + id ).closest( '.acf-field-wysiwyg' ).attr( 'class' );
				if ( classes === undefined ) {
					return mceInit;
				}
				var classArr = classes.split( ' ' ),
					newClasses = '';
				// step through the applied classes and only use those that start with the 'hwid-' prefix
				for ( var i=0; i<classArr.length; i++ ) {
					if ( classArr[i].indexOf( 'hwid-' ) === 0 ) {
						newClasses += ' ' + classArr[i];
					}
				}
				// apply the prefixed classes to the body_class property, which will then
				// put those classes on the rendered iframe's body tag
				mceInit.body_class += newClasses;
				return mceInit;
			});
		})( jQuery );
	</script>
<?php
});

// Add in custom clases into ACF WYSIWIG
add_action('acf/input/admin_footer', function() { ?>
	<script>
        (function($) {
            acf.add_filter('wysiwyg_tinymce_settings', function(mceInit, id, $field) {
                var fieldKey = $field.data('key');
                var fieldName = $field.data('name');
                var flexContentName = $field.parents('[data-type="flexible_content"]').first().data('name');
                var layoutName = $field.parents('[data-layout]').first().data('layout');

                mceInit.body_class += " acf-field-key-" + fieldKey;
                mceInit.body_class += " acf-field-name-" + fieldName;
                if (flexContentName) {
                    mceInit.body_class += " acf-flex-name-" + flexContentName;
                }
                if (layoutName) {
                    mceInit.body_class += " acf-layout-" + layoutName;
                }
                return mceInit;
            });

        })(jQuery);
    </script>
<?php
});

// ACF Bidirectional Relationships
// https://www.advancedcustomfields.com/resources/bidirectional-relationships/

add_filter('acf/update_value/name=c_verso_recto', function ( $value, $post_id, $field  ) {

	// vars
	$field_name = $field['name'];
	$field_key = $field['key'];
	$global_name = 'is_updating_' . $field_name;


	// bail early if this filter was triggered from the update_field() function called within the loop below
	// - this prevents an inifinte loop
	if( !empty($GLOBALS[ $global_name ]) ) return $value;


	// set global variable to avoid inifite loop
	// - could also remove_filter() then add_filter() again, but this is simpler
	$GLOBALS[ $global_name ] = 1;


	// loop over selected posts and add this $post_id
	if( is_array($value) ) {

		foreach( $value as $post_id2 ) {

			// load existing related posts
			$value2 = get_field($field_name, $post_id2, false);


			// allow for selected posts to not contain a value
			if( empty($value2) ) {

				$value2 = array();

			}


			// bail early if the current $post_id is already found in selected post's $value2
			if( in_array($post_id, $value2) ) continue;


			// append the current $post_id to the selected post's 'related_posts' value
			$value2[] = $post_id;


			// update the selected post's value (use field's key for performance)
			update_field($field_key, $value2, $post_id2);

		}

	}


	// find posts which have been removed
	$old_value = get_field($field_name, $post_id, false);

	if( is_array($old_value) ) {

		foreach( $old_value as $post_id2 ) {

			// bail early if this value has not been removed
			if( is_array($value) && in_array($post_id2, $value) ) continue;


			// load existing related posts
			$value2 = get_field($field_name, $post_id2, false);


			// bail early if no value
			if( empty($value2) ) continue;


			// find the position of $post_id within $value2 so we can remove it
			$pos = array_search($post_id, $value2);


			// remove
			unset( $value2[ $pos] );


			// update the un-selected post's value (use field's key for performance)
			update_field($field_key, $value2, $post_id2);

		}

	}


	// reset global varibale to allow this filter to function as per normal
	$GLOBALS[ $global_name ] = 0;


	// return
    return $value;

}, 10, 3);


/**
 * Async load CSS
 * https://roots.io/guides/asynchronous-css-loading-in-sage/
 */
if (env('WP_ENV') === 'production') {
    add_filter('style_loader_tag', function ($html, $handle, $href) {
        if (is_admin()) {
            return $html;
        }

        $dom = new \DOMDocument();
        $dom->loadHTML($html);
        $tag = $dom->getElementById($handle . '-css');
        $tag->setAttribute('rel', 'preload');
        $tag->setAttribute('as', 'style');
        $tag->setAttribute('onload', "this.onload=null;this.rel='stylesheet'");
        $tag->removeAttribute('type');
        $html = $dom->saveHTML($tag);

        return $html;
    }, 999, 3);
}

if (env('WP_ENV') === 'production') {
    add_action('wp_head', function () {
        $preload_script = get_theme_file_path() . '/resources/assets/scripts/cssrelpreload.js';

        if (fopen($preload_script, 'r')) {
            echo '<script>' . file_get_contents($preload_script) . '</script>';
        }
    }, 101);
}

// Add custom icon (ie search) to the primary wp_nav_menu
add_filter( 'wp_nav_menu_items', function( $items, $args ) {
    if( $args->theme_location == 'primary_navigation' )  {
       $items .=  '<li class="menu-item menu-item-icon"><a href="/' .
          esc_url( $_SESSION['menu_country'] ) .'/shop"><i class="icon-magnifying-glass"></i></a></li>';
    }
    return $items;
}, 10, 2 );
