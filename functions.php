<?php
/**
 * JM functions and definitions
 */

/**
 * JM only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function jm_setup() {
	/*
	 * Make theme available for translation.
	 */
	load_theme_textdomain( 'jm' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
		'flex-height' => true
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css', jm_fonts_url() ) );
}
add_action( 'after_setup_theme', 'jm_setup' );

/**
 * Register custom fonts.
 */
function jm_fonts_url() {
	$fonts_url = '';
	$font_families = array();

	$font_families[] = 'Noto Sans:400,700';

	$query_args = array(
		'family' => urlencode( implode( '|', $font_families ) ),
		'subset' => urlencode( 'latin,latin-ext' ),
	);

	$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

	return esc_url_raw( $fonts_url );
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function jm_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'jm' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'jm' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'jm_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 */
function jm_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'jm' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
//add_filter( 'excerpt_more', 'jm_excerpt_more' );

/**
 * Handles JavaScript detection.
 */
function jm_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'jm_javascript_detection', 0 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function jm_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'jm_pingback_header' );

/**
 * Enqueue scripts and styles.
 */
function jm_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'jm-fonts', jm_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'jm-style', get_stylesheet_uri() );

	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );


	wp_enqueue_script( 'jm-global', get_theme_file_uri( '/assets/js/global.js' ), array( 'jquery' ), '1.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'jm_scripts' );


/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 */
function jm_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( is_archive() || is_search() || is_home() ) {
		$attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
	} else {
		$attr['sizes'] = '100vw';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'jm_post_thumbnail_sizes_attr', 10, 3 );


/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );


/********************************************************************************
 * Custom Functions.
 *
 */

/**
 * Theme Options and metabox for this theme.
 */
require get_parent_theme_file_path( '/inc/theme-options.php' );
require get_parent_theme_file_path( '/inc/metabox.php' );

/**
 * Change Login Wordpress - Logo
 */
function jm_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'jm_logo_url' );

function jm_logo_url_title() {
    return 'Powered by Cultura';
}
add_filter( 'login_headertitle', 'jm_logo_url_title' );

function jm_login_logo() { ?>
    <style type="text/css">
	    .login h1{
	    	margin-left: 0px;
	    }
        .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/logo.svg);
			background-size: 260px 35px;
		    height: 35px;
		    width: 170px;
        }
    </style>
<?php }
add_action( 'login_head', 'jm_login_logo' );


/**
 * Remove admin bar
 */
function jm_remove_admin_bar() {
	show_admin_bar(false);
	if ( current_user_can( 'administrator' ) ) {
		show_admin_bar(true);
	}
}
add_action( 'after_setup_theme', 'jm_remove_admin_bar' );

/**
 * Remove version
 */
remove_action( 'wp_head', 'wp_generator' );


/**
* Add font size to TinyMCE
**/
function wp_editor_fontsize_filter( $buttons ) {
    array_shift( $buttons );
    array_unshift( $buttons, 'fontsizeselect');
    array_unshift( $buttons, 'formatselect');
    return $buttons;
}    
add_filter('mce_buttons_2', 'wp_editor_fontsize_filter');

/**
 * Upload SVG in wordpress
 */
function jm_generate_svg( $svg_mime ) {
	$svg_mime['svg'] = 'image/svg+xml';
	return $svg_mime;
}
add_filter( 'upload_mimes', 'jm_generate_svg' );

/**
 * Enables the Excerpt meta box in Page edit screen.
 */
function jm_add_excerpt_support_for_pages() {
	//add_post_type_support( 'page', 'excerpt' );
	//add_post_type_support( 'ai1ec_event', 'excerpt' );
}
add_action( 'init', 'jm_add_excerpt_support_for_pages' );

/**
 * Function Add Icon Font
 */
function jm_add_icon_fonts() {
	wp_register_style( 'FontsAwesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style( 'FontsAwesome' ); 
}
add_action( 'wp_print_styles', 'jm_add_icon_fonts' );

/**
 * Enqueue Schema org inline scripts
 */
function jm_add_head_schema_script() {
	$options = jm_get_trim_options( get_option( 'theme_settings' ) );
?>
<script type="application/ld+json">
	{ "@context" 	: "http://schema.org",
	  "@type" 		: "Organization",
	  "name" 		: "<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>",
	  "url" 		: "<?php echo esc_url( home_url( '/' ) ); ?>",
	  "logo"		: "<?php echo wp_get_attachment_url( get_theme_mod( 'custom_logo' ) ); ?>",
	  <?php if( $options['ci_phone_office'] != "" ){ ?> 
	  "contactPoint" : [{
	    "@type" : "ContactPoint",
	    "telephone" : "+<?php echo $options['ci_phone_office']; ?>",
	    "contactType" : "customer service"
	  }],
	  <?php } ?>
	  "sameAs" : [
		<?php if( $options['ci_facebook'] != "" ){ ?>
	    "<?php echo $options['ci_facebook']; ?>",
	    <?php } ?>
		<?php if( $options['ci_twitter'] != "" ){ ?> 
	  	"<?php echo $options['ci_twitter']; ?>",
	  	<?php } ?>
	  	<?php if( $options['ci_youtube'] != "" ){ ?>
	    "<?php echo $options['ci_youtube']; ?>",
	    <?php } ?>
	    <?php if( $options['ci_instagram'] != "" ){ ?>
	    "<?php echo $options['ci_instagram']; ?>"
	    <?php } ?>
		]
	}
</script>
<?php
}
add_action( 'wp_head', 'jm_add_head_schema_script' );

/**
 * Function add url prop Schema
 */
function jm_add_menu_attributes( $atts, $item, $args ) {
	$atts['itemprop'] = 'url';
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'jm_add_menu_attributes', 10, 3 );

/**
 * Trim Theme options
 */
function jm_get_trim_options( $arr_opts ){
	$opts = array();
	if( is_array( $arr_opts ) && count( $arr_opts ) > 0 ){
		foreach( $arr_opts as $key=>$val ){
			$opts[$key] = trim( $val );
		}
		return $opts;
	}else{
		return array();
	}
}

/**
 * Function Body tag schema
 */
function jm_body_tag_schema() {
    $schema = 'http://schema.org/';
	// Is single post
	if( is_single() ) {
	    $type = "Article";
	}
	// Is author page
	elseif( is_author() ) {
	    $type = 'ProfilePage';
	}
	// Is search results page
	elseif( is_search() ) {
	    $type = 'SearchResultsPage';
	}
	else {
	    $type = 'WebPage';
	}
	echo 'itemscope itemtype="' . $schema . $type . '"';
}

/**
 * Return true if content has shortcode
 */
function jm_has_shortcode_content( $shortcode = NULL ) {
    $post_to_check = get_post( get_the_ID() );
    // false because we have to search through the post content first
    $found = false;
    // if no short code was provided, return false
    if ( ! $shortcode ) {
    	return $found;
    }
    // check the post content for the short code
    if ( stripos( $post_to_check->post_content, '[' . $shortcode) !== FALSE ) {
        // we have found the short code
        $found = TRUE;
    }
    // return our final results
    return $found;
}

/**
 * If is Blog
 */
function jm_is_blog() {
	global  $post;
	$posttype = get_post_type( $post );
	return ( ((is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_single()) || (is_tag())) && ( $posttype == 'post')  ) ? true : false ;
}

/**
 * Get Page Id by Template
 */
function jm_get_pageid_by_template( $template ){
	$page_return = "";
	$pages = get_pages(array(
		'meta_key' => '_wp_page_template',
		'meta_value' => 'page-templates/'.$template.'-page.php'
	));
	if( $pages && is_array( $pages ) ){
		foreach($pages as $page){
			$page_return = $page->ID;
			break;
		}
	}
	return $page_return;
}

/**********************************************
 ** Shortcodes
 *********************************************/
/**
 * Shortcode - Clear
 */
function jm_shortcode_clear( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'class' => ''
	), $atts );

	$html = "<div class='clear'></div>";
	return $html;
}
add_shortcode( 'clear', 'jm_shortcode_clear' );

/**
 * Shortcode - Button
 */
function jm_shortcode_button( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'class' => ''
	), $atts );
	
	$class = "";
	if( !empty( $a['class'] ) ){
		$class = 'btn-'.$a['class'];
	}

	$html_btn = "<span class='btn-page ".$class."'>".$content."</span>";

	return $html_btn;
}
add_shortcode( 'button', 'jm_shortcode_button' );

