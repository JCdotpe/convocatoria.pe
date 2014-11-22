<?php
// Start the engine
require_once( get_template_directory() . '/lib/init.php' );

require_once(TEMPLATEPATH.'/lib/init.php');
require_once(STYLESHEETPATH.'/lib/init.php');

// Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Genesis Sample Theme' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/' );

// Add Viewport meta tag for mobile browsers
add_action( 'genesis_meta', 'sample_viewport_meta_tag' );
function sample_viewport_meta_tag() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

// Add bootstrap css
add_action( 'wp_enqueue_scripts', 'bootstrap_style_sheet' );
function bootstrap_style_sheet() {
	wp_enqueue_style( 'custom-stylesheet', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css', array(), PARENT_THEME_VERSION );
}

// Add font awesome css
add_action( 'wp_enqueue_scripts', 'font_awesome_style_sheet' );
function font_awesome_style_sheet() {
	wp_enqueue_style( 'custom-stylesheet', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css', array(), PARENT_THEME_VERSION );
}

// Remove js default
add_action('wp_enqueue_scripts', 'crunchify_script_remove_header');
function crunchify_script_remove_header() {
      wp_deregister_script( 'jquery' );
      wp_deregister_script( 'jquery-ui' );
}
 
// Load js files
add_action('genesis_after_footer', 'crunchify_script_add_body');
function crunchify_script_add_body() {
      wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js' );
      wp_register_script( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js' );
      wp_register_script( 'snap_svg', CHILD_URL .'/js/snap.svg-min.js' );
      wp_register_script( 'classie', CHILD_URL .'/js/classie.js' );
      wp_register_script( 'main', CHILD_URL .'/js/main.js' );
      wp_register_script( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js' );
      wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js', array( 'jquery' ), '1.11.1', false );
      wp_enqueue_script( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js', array( 'jquery' ), '3.3.1' );
      wp_enqueue_script( 'snap_svg', CHILD_URL .'/js/snap.svg-min.js' );
      wp_enqueue_script( 'classie', CHILD_URL .'/js/classie.js' );
      wp_enqueue_script( 'main', CHILD_URL .'/js/main.js' );
}

// Load iframe convocatorias
add_action('genesis_after_header', 'iframe_load');
function iframe_load() {


$ip= $_SERVER['REMOTE_ADDR']; 

if (($ip == '181.177.234.130') or ($ip == '127.0.0.1'))  { 
	echo '<div class="header-ads"><img src="http://drive.google.com/uc?export=view&amp;id=0B3A_OYLiO9cCWXNkNC1hekxMX0k" /></div>';
}
else{ 
      echo '<div class="header-ads">

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Convocatoria.pe 728x90 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-1445607604292298"
     data-ad-slot="3618025566"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

      </div>';
} 


      echo '




      <div class="iframe-load">

			<div class="menu-wrap">
				
		<iframe id="iframe-ajax-load" src="" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0" style="width: calc(100% - 80px); height: calc(100% - 120px); overflow: scroll"></iframe>

				
				<button class="close-button" id="close-button">Close Menu</button>
				<div class="morph-shape" id="morph-shape" data-morph-open="M-1,0h101c0,0,0-1,0,395c0,404,0,405,0,405H-1V0z">
					<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 100 800" preserveAspectRatio="none">
						<path d="M-1,0h101c0,0-97.833,153.603-97.833,396.167C2.167,627.579,100,800,100,800H-1V0z"/>
					</svg>
				</div>
			</div>

      </div>';
}

// Add support for custom background
add_theme_support( 'custom-background' );

//Enable HTML5 Support
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

// Add support for custom header
add_theme_support( 'genesis-custom-header', array(
	'width' => 1152,
	'height' => 120
) );

//* Reposition the secondary navigation
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before_header', 'genesis_do_subnav' );

//* Menu bootstrap
remove_action( 'genesis_after_header', 'genesis_do_nav' ); 
add_action('genesis_header', 'custom_do_nav', 5); 
function custom_do_nav() { wp_nav_menu(array( 
	'menu' => 'Primary Navigation', 
	'container' => 'nav', 
	'container_class' => 'navbar navbar-default navbar-static-top', 
	'menu_class' => 'nav navbar-nav navbar-right', 
	'menu_id' => 'navigation', 
	'items_wrap' => ' <div class="container-fluid"> <div class="navbar-header"> <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mry-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button> </div> <div class="collapse navbar-collapse" id="mry-navbar-collapse-1"><ul id="%1$s" class="%2$s">%3$s</ul></div></div>'
)); 
} 

// Custom post info
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
if ( !is_page() ) {
	$post_info = '[post_categories before=""] [post_date] [post_edit]';
	return $post_info;
}}

// Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

// Customize Genesis Footer 
remove_action( 'genesis_footer', 'genesis_do_footer' );

// Remove the post meta function
remove_action('genesis_entry_footer', 'genesis_post_meta');


// Facebook comments
remove_action('genesis_comment_form', 'genesis_do_comment_form');
add_action('genesis_comment_form', 'genesis_fb_comments');
function genesis_fb_comments() {
	echo '<div id="respond" class="comment-respond"><div class="fb-comments" data-href="'.get_permalink().'" data-width="100%" data-numposts="5" data-colorscheme="light"></div></div>';
}



// ADMIN


