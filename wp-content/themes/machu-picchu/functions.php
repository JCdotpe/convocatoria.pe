<?php
/**
 * This file calls the init.php file, but only
 * if the child theme hasn't called it first.
 *
 * This method allows the child theme to load
 * the framework so it can use the framework
 * components immediately.
 *
 * @package Genesis
 *
 **/
require_once(TEMPLATEPATH.'/lib/init.php');
require_once(STYLESHEETPATH.'/lib/init.php');

if (function_exists('add_custom_background')) {
	add_custom_background();
}
remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
/*****************************************************************************************/

//Add Doctype
/*****************************************************************************************/
remove_action('genesis_doctype', 'genesis_do_doctype');
add_action('genesis_doctype', 'custom_do_doctype');
function custom_do_doctype() { 
?>
<!DOCTYPE html>
<html <?php  language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<?php
}
//End Doctype
/*****************************************************************************************/

//Add Scripts
/*****************************************************************************************/
add_action('get_header', 'cox_header_scripts'); 
function cox_header_scripts() { 
	//Jquery
	wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', CHILD_URL.'/lib/external/jquery.min.js');
    wp_enqueue_script( 'jquery');
	//Full Layout
	add_filter('body_class', 'add_category_class_single');
	function add_category_class_single($classes){
		$classes[] = 'cox-'.cox_get_option('theme_layout',1).'-layout';
		$classes[] = genesis_get_option('nav')?'nav_primary':'';
		return $classes;
	}
	//Prettyphoto
	wp_enqueue_style('pretty', CHILD_URL .'/lib/external/prettyphoto/css/prettyPhoto.css', array(), cox_get_version());
	wp_enqueue_script('pretty', CHILD_URL.'/lib/external/prettyphoto/js/jquery.prettyPhoto.js', array('jquery'), cox_get_version(), true );	
	wp_enqueue_script('lazy', CHILD_URL.'/lib/external/lazy/jquery.lazyload.js', array('jquery'), cox_get_version(), true);
	//Tooltip
	wp_enqueue_script('tip', CHILD_URL.'/lib/external/tip/jquery.poshytip.min.js', array('jquery'), cox_get_version(), true );	
	if ( is_home() ) :
	wp_enqueue_style('diapo', CHILD_URL .'/lib/external/slider/css/diapo.css', array(), cox_get_version());
	//Slider
	wp_enqueue_script('diapo-easing', CHILD_URL.'/lib/external/slider/js/jquery.easing.1.3.js', array('jquery'), cox_get_version(), true);
	wp_enqueue_script('diapo-hover', CHILD_URL.'/lib/external/slider/js/jquery.hoverIntent.minified.js', array('jquery'), cox_get_version(), true);
	wp_enqueue_script('diapo', CHILD_URL.'/lib/external/slider/js/diapo.min.js', array('jquery'), cox_get_version(), true);
	endif;
	//Custom JS
	wp_enqueue_script('custom', CHILD_URL.'/lib/js/custom.js', array('jquery'), cox_get_version(), true);
	$coxparams = array(
	 	'url'      =>   __(CHILD_URL, COX_DOMAIN),
		'font' => cox_get_option('theme_font',1)
	 );
	wp_localize_script('custom', 'cox', $coxparams);	
}

//Cox Fonts
add_action('wp_head', 'cox_uskins_script'); 
function cox_uskins_script() { 
	$font = cox_get_option('theme_font',1);
	$color_act.= '<style type="text/css">h1,h2,h3,h4,h5{font-family:\''.$font.'\', serif}</style >';
	echo $color_act;
	//ie-
	echo '
		<!--[if lt IE 9]>
		 <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		 <script src="'.CHILD_URL.'/lib/external/selectivizr.js"></script>
		<![endif]-->';
}

//Cox JS
add_action('wp_footer', 'cox_js');
function cox_js() {
	 $output = '
	 jQuery(document).ready(function($) { ';
	if ( is_home() ) :
		$output .= '
		jQuery(".pix_diapo").diapo({
		fx:"'.cox_get_option('slider_effect',1).'"
		});
		
		jQuery("#testimonials ul").innerfade({
				speed: "slow",
				timeout: 4500,
				type: "sequence",
				containerheight: "90px"
		});
	';
	endif;
	$output .= '
	});	';
	$output = str_replace(array("\n","\t","\r"), '', $output);
	echo '<script type=\'text/javascript\'>'.$output.'</script>';
}
//End Scripts
/*****************************************************************************************/

// Force layout on homepage
add_filter('genesis_pre_get_option_site_layout', 'streamline_home_layout');
function streamline_home_layout($opt) {
    if ( is_home() )
    $opt = 'content-sidebar';
    return $opt;
}

//Add subnav Menu
remove_action('genesis_after_header', 'genesis_do_subnav');
add_action('genesis_header', 'subnav_header');
function subnav_header(){
	genesis_do_subnav();
}

//Add nav Menu
remove_action('genesis_after_header', 'genesis_do_nav');
add_action('genesis_after_header', 'custom_do_nav');
function custom_do_nav() {
genesis_do_nav();
}

// Custom Breadcrumb
remove_action('genesis_before_loop', 'genesis_do_breadcrumbs');
add_action('genesis_after_header', 'genesis_do_breadcrumbs');
function custom_breadcrumb_args($args) {
    $args['sep'] = ' » ';
	$args['prefix']                  = '<div class="breadcrumb"><div class="wrap">';
    $args['suffix']                  = '</div></div>';
    return $args;
}
add_filter('genesis_breadcrumb_args', 'custom_breadcrumb_args');

// Add Slider
/*****************************************************************************************/  
add_action('genesis_after_header', 'cox_add_slider_area'); 
function cox_add_slider_area() { 
if ( is_home() ) :
	$cat = cox_get_option('slider_cat',1);
	$items = cox_get_option('slider_items',1);
	$slider='<div class="slider-content">';
	$slider.='<div id="diapo-slider"><div class="wrap"><div class="pix_diapo">';
	$height= 440;
	if($cat!=-1){
		$myposts = get_posts('numberposts='.$items.'&order=DESC&orderby=post_date&category='.$cat);
		//Diapo Slider	
			foreach($myposts as $post) :
				$sl_image = CHILD_URL.'/images/no-image.png';
				if (has_post_thumbnail( $post->ID ))
				$sl_image = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
				$sl_link = get_permalink($post->ID);
				if(get_post_meta($post->ID, "_cox_active_html", true)){
				$slider.='<div data-thumb="'.cox_thumb($sl_image,50,50).'">'.get_post_meta($post->ID, "_cox_html", true).'</div>';
				}else{
				$slider.='<div data-thumb="'.cox_thumb($sl_image,50,50).'"><a href="'.$sl_link.'"><img src="'.cox_thumb($sl_image,940,$height).'" alt=""></a></div>';
				}
			endforeach;
	}else{
		$sl_image=CHILD_URL.'/images/no-image.png';
		$slider.='<div data-thumb="'.cox_thumb($sl_image,50,50).'"><img src="'.cox_thumb($sl_image,940,$height).'" alt=""></div>';
	}
	$slider.='</div></div></div>';
	$slider.='</div>';
	echo $slider;
endif;
}
//End Slider
/*****************************************************************************************/   

// Add footer section
remove_action('genesis_footer', 'genesis_do_footer');
remove_action('genesis_footer', 'genesis_footer_markup_open', 5);
remove_action('genesis_footer', 'genesis_footer_markup_close', 15);

add_action('genesis_before_footer', 'custom_footer');
function custom_footer(){
	require(CHILD_DIR . '/cox-footer.php');
}

// Featured Image Size
add_image_size('featured-post', 45, 45, TRUE);
add_image_size('featured-page', 70, 50, TRUE);
add_image_size('archive', 565, 290, TRUE);


//Add post featured image 
add_action('genesis_before_post_title', 'post_featured_img');
function post_featured_img() { 
?>
<?php 
$site_layout = genesis_site_layout();
if ( has_post_thumbnail() ) {
	$sl_image = wp_get_attachment_url( get_post_thumbnail_id(), 'single-post-thumbnail' );
	if ( $site_layout != 'full-width-content' ) 
	echo '<img src="'.cox_thumb($sl_image,566,290).'" class="cox-image" alt="">';
	else
	echo '<img src="'.cox_thumb($sl_image,926,440).'" class="cox-image" alt="">';
} 
?>
<?php
}

//Sidebar
genesis_register_sidebar(array(
	'name'=>'Footer #1',
	'description' => 'This is the first column of the footer section.',
	'before_title'=>'<h4 class="widgettitle">','after_title'=>'</h4>'
));
genesis_register_sidebar(array(
	'name'=>'Footer #2',
	'description' => 'This is the second column of the footer section.',
	'before_title'=>'<h4 class="widgettitle">','after_title'=>'</h4>'
));
genesis_register_sidebar(array(
	'name'=>'Footer #3',
	'description' => 'This is the third column of the footer section.',
	'before_title'=>'<h4 class="widgettitle">','after_title'=>'</h4>'
));
genesis_register_sidebar(array(
	'name'=>'Footer #4',
	'description' => 'This is the fourth column of the footer section.',
	'before_title'=>'<h4 class="widgettitle">','after_title'=>'</h4>'
));

//Custom design
add_action('genesis_before_content_sidebar_wrap', 'custom_width');
function custom_width(){
	echo '<div class="row">';
}

add_action('genesis_after_content_sidebar_wrap', 'close_custom_width');
function close_custom_width(){
	echo '</div>';
}

add_action('genesis_before_loop', 'custom_primary_width');
function custom_primary_width(){
	echo '<div id="primary" class="col_10 col position">';
}

add_action('genesis_after_loop', 'close_custom_primary_width');
function close_custom_primary_width(){
	echo '</div>';
}

//Custom Aside
add_action('genesis_before_sidebar_widget_area', 'custom_aside');
function custom_aside(){
	echo '<div class="col col_6 lower"><div class="middle-sidebar">';
}

add_action('genesis_after_sidebar_widget_area', 'close_custom_aside');
function close_custom_aside(){
	echo '</div></div>';
}

add_action('genesis_before_sidebar_alt_widget_area', 'custom_aside_alt');
function custom_aside_alt(){
	echo '<div class="col col_3 lower"><div class="middle-sidebar">';
}

add_action('genesis_after_sidebar_alt_widget_area', 'close_custom_aside_alt');
function close_custom_aside_alt(){
	echo '</div></div>';
}