<?php

//CONTACT FORM SHORTCODE
function cox_contact( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'email'      => '',
    ), $atts));
    
    $out = cox_email($email);
    
    return $out;
}
add_shortcode('contactform', 'cox_contact');



function shortcode_iframe_load( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'link'      => '#',
    ), $atts));
	$out = "<button id='iframe_".get_the_ID()."' type='button' onclick='iframe_load(this.id)' class=\"btn btn-link iframe-button\" value=\"" .$link. "\"><i class='fa fa-bullhorn'></i> " .do_shortcode($content). "</button>  <div class='share-entry'><a href='http://www.facebook.com/sharer.php?u=".get_permalink()."' target='_blank' title='Share this page on Facebook'><i class='fa fa-facebook-square'></i> Compartir</a> <a href='http://www.linkedin.com/shareArticle?mini=true&url=".get_permalink()."' target='_blank'><i class='fa fa-linkedin-square'></i> Linkedin</a> <a href='http://twitter.com/share?url=".get_permalink()."' target='_blank' title='Tweet this page on Twitter'><i class='fa fa-twitter-square'></i> Tweet</a> <a href='https://plusone.google.com/_/+1/confirm?hl=en&url=".get_permalink()."' target='_blank' title='Plus one this page on Google'><i class='fa fa-google-plus-square'></i> Google +1</a></div>";
    return $out;
}
add_shortcode('iframe_load', 'shortcode_iframe_load');


/************************************************************************
	»»	SHORTCODES | COX WORDPRESS THEME <3
*************************************************************************/
add_filter('widget_text', 'do_shortcode');

function cox_shortcode_button( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'link'      => '#',
    ), $atts));
	$out = "<a class=\"button\" href=\"" .$link. "\">" .do_shortcode($content). "</a>";
    return $out;
}
add_shortcode('cox_button', 'cox_shortcode_button');

function cox_shortcode_drop_cap_a( $atts, $content = null ) {
   return '<span class="cox-drop-cap-a">' . do_shortcode($content) . '</span>';
}
add_shortcode('cox_drop_cap_a', 'cox_shortcode_drop_cap_a');


function cox_shortcode_drop_cap_b( $atts, $content = null ) {
   return '<span class="cox-drop-cap-b">' . do_shortcode($content) . '</span>';
}
add_shortcode('cox_drop_cap_b', 'cox_shortcode_drop_cap_b');

function cox_shortcode_pullquote_right( $atts, $content = null ) {
   return '<span class="cox-pullquote-right">' . do_shortcode($content) . '</span>';
}
add_shortcode('cox_pullquote_right', 'cox_shortcode_pullquote_right');


function cox_shortcode_pullquote_left( $atts, $content = null ) {
   return '<span class="cox-pullquote-left">' . do_shortcode($content) . '</span>';
}
add_shortcode('cox_pullquote_left', 'cox_shortcode_pullquote_left');

function cox_shortcode_download_box( $atts, $content = null ) {
   return '<div class="cox-alert cox-download-box"><span class="box-close">x</span>' . do_shortcode($content) . '</div>';
}
add_shortcode('cox_download_box', 'cox_shortcode_download_box');


function cox_shortcode_warning_box( $atts, $content = null ) {
   return '<div class="cox-alert cox-warning-box"><span class="box-close">x</span>' . do_shortcode($content) . '</div>';
}
add_shortcode('cox_warning_box', 'cox_shortcode_warning_box');


function cox_shortcode_info_box( $atts, $content = null ) {
   return '<div class="cox-alert cox-info-box"><span class="box-close">x</span>' . do_shortcode($content) . '</div>';
}
add_shortcode('cox_info_box', 'cox_shortcode_info_box');


function cox_shortcode_note_box( $atts, $content = null ) {
   return '<div class="cox-alert cox-note-box"><span class="box-close">x</span>' . do_shortcode($content) . '</div>';
}
add_shortcode('cox_note_box', 'cox_shortcode_note_box');

function cox_shortcode_check_list( $atts, $content = null ) {
	$content = str_replace('<ul>', '<ul class="cox-check-list">', do_shortcode($content));
	return $content;
	
}
add_shortcode('cox_check_list', 'cox_shortcode_check_list');

function cox_shortcode_content_list( $atts, $content = null ) {
	$content = str_replace('<ul>', '<ul class="cox-content-list">', do_shortcode($content));
	return $content;
}
add_shortcode('cox_content_list', 'cox_shortcode_content_list');

function cox_shortcode_highlight( $atts, $content = null ) {
   return '<span class="cox-highlight">' . do_shortcode($content) . '</span>';
}
add_shortcode('cox_highlight', 'cox_shortcode_highlight');

function cox_shortcode_divider( $atts, $content = null ) {
   return '<span class="cox-divider"></span>';
}
add_shortcode('cox_divider', 'cox_shortcode_divider');

function cox_shortcode_divider_with_top( $atts, $content = null ) {
   return '<span class="cox-divider-with-top"><a href="#wrap">Go to Top ↑</a></span>';
}
add_shortcode('cox_divider_with_top', 'cox_shortcode_divider_with_top');

function cox_shortcode_toggle( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'title'      => '',
    ), $atts));
   return '<h5 class="trigger">'.$title.'</h5>
<div class="toggle_container">
	<div class="block">
	' . do_shortcode($content) . '
	</div>
</div>';
}
add_shortcode('cox_toggle', 'cox_shortcode_toggle');

function cox_shortcode_tabs( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'title1'      => '',
		'content1'      => '',
		'title2'      => '',
		'content2'      => '',
		'title3'      => '',
		'content3'      => '',
		'title4'      => '',
		'content4'      => '',
		'title5'      => '',
		'content5'      => '',
    ), $atts));
	
$ret = '<ul class="tabs">';
if($title1!='')
$ret .= '<li><a href="#tab1">'.$title1.'</a></li>';
if($title2!='')	
$ret .= '<li><a href="#tab2">'.$title2.'</a></li>';
if($title3!='')	
$ret .= '<li><a href="#tab3">'.$title3.'</a></li>';
if($title4!='')	
$ret .= '<li><a href="#tab4">'.$title4.'</a></li>';
if($title5!='')	
$ret .= '<li><a href="#tab5">'.$title5.'</a></li>';
$ret .= '</ul><div class="tab_container">';
if($content1!='')
$ret .='<div id="tab1" class="tab_content">'.$content1.'</div>';
if($content2!='')
$ret .='<div id="tab2" class="tab_content">'.$content2.'</div>';
if($content3!='')
$ret .='<div id="tab3" class="tab_content">'.$content3.'</div>';
if($content4!='')
$ret .='<div id="tab4" class="tab_content">'.$content4.'</div>';
if($content5!='')
$ret .='<div id="tab5" class="tab_content">'.$content5.'</div>';
$ret .= '</div>';
return $ret;
}
add_shortcode('cox_tabs', 'cox_shortcode_tabs');


function cox_one_third( $atts, $content = null ) {
   return '<div class="one_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third', 'cox_one_third');


function cox_one_third_last( $atts, $content = null ) {
   return '<div class="one_third last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_third_last', 'cox_one_third_last');


function cox_two_third( $atts, $content = null ) {
   return '<div class="two_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_third', 'cox_two_third');


function cox_two_third_last( $atts, $content = null ) {
   return '<div class="two_third last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('cox_third_last', 'cox_two_third_last');


function cox_one_half( $atts, $content = null ) {
   return '<div class="one_half">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half', 'cox_one_half');

function cox_one_half_last( $atts, $content = null ) {
   return '<div class="one_half last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_half_last', 'cox_one_half_last');

function cox_one_fourth( $atts, $content = null ) {
   return '<div class="one_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth', 'cox_one_fourth');


function cox_one_fourth_last( $atts, $content = null ) {
   return '<div class="one_fourth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_fourth_last', 'cox_one_fourth_last');


function cox_three_fourth( $atts, $content = null ) {
   return '<div class="three_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fourth', 'cox_three_fourth');


function cox_three_fourth_last( $atts, $content = null ) {
   return '<div class="three_fourth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('three_fourth_last', 'cox_three_fourth_last');

function cox_mini_one_third( $atts, $content = null ) {
   return '<div class="one_third mini">' . do_shortcode($content) . '</div>';
}
add_shortcode('mini_one_third', 'cox_mini_one_third');

function cox_mini_two_third( $atts, $content = null ) {
   return '<div class="two_third mini">' . do_shortcode($content) . '</div>';
}
add_shortcode('mini_two_third', 'cox_two_third');

function cox_mini_one_half( $atts, $content = null ) {
   return '<div class="one_half mini">' . do_shortcode($content) . '</div>';
}
add_shortcode('mini_one_half', 'cox_mini_one_half');

function cox_mini_one_fourth( $atts, $content = null ) {
   return '<div class="one_fourth mini">' . do_shortcode($content) . '</div>';
}
add_shortcode('mini_one_fourth', 'cox_mini_one_fourth');

function cox_mini_three_fourth( $atts, $content = null ) {
   return '<div class="three_fourth mini">' . do_shortcode($content) . '</div>';
}
add_shortcode('mini_three_fourth', 'cox_mini_three_fourth');

function cox_credits( $atts, $content = null ) {
   return '<span class="source-credits">' . do_shortcode($content) . '</span>';
}
add_shortcode('cox_credits', 'cox_credits');

/************************************************************************
	»»	PORTFOLIO | COX WORDPRESS THEME <3
*************************************************************************/
add_shortcode('portfolio', 'cox_portfolio');
function cox_portfolio($atts, $content = null) {
        extract(shortcode_atts(array(
                "cat" => '',
                "col" => '1',
				"items" => '4'
        ), $atts));	
$myposts = get_posts('numberposts='.$items.'&order=DESC&orderby=post_date&category='.$cat);
$port='<div id="portfolio" class="portfolio-'.$col.'">';

foreach($myposts as $post) :	
	//link
	$link = get_post_meta($post->ID, "_cox_port_link", true);
	//external
	$elink = get_post_meta($post->ID, "_cox_port_external", true);
	//img
	$p_img = CHILD_URL.'/images/no-image.png';
	if (has_post_thumbnail( $post->ID ))
		$p_img = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
	//title
	$title = get_post_meta($post->ID, "_cox_port_title", true);
	
	if($p_img!=''){
		$classp = 'img';	
		if($col=='1')
			$p_img_thumb =cox_thumb($p_img,433,263);
		else if($col=='2')
			$p_img_thumb =cox_thumb($p_img,445,233);
		else if($col=='3')
			$p_img_thumb =cox_thumb($p_img,258,164);
	}	
	//media
	$media = get_post_meta($post->ID, "_cox_port_media", true);
	if($media!=''){
		$classp = 'video';		
		$p_img = $media;
	}

	if($elink!='')
		$classp = 'link';		

	if($link=='')
		$link = get_permalink($post->ID);

	if($title=='')
		$title = get_the_title($post->ID);
		
	if($col=='1')
		$read = '<a class="read-more" href="'.$link.'">Read more »</a>';
	else
		$read = '';
		
	$port.='
		<div class="item-'.$col.' col">
			<div class="p-'.$col.'">
			<div class="i-'.$col.'">';
			if($elink!='' && $media=='')
				$port.=	'<a target="_blank" href="'.$elink.'">';
			else
				$port.=	'<a href="'.$p_img.'" rel="prettyPhoto[gallery]">';

			$port.=	'<span><div class="bg-hover-portfolio-'.$classp.'"></div><div id="bg-layer-portfolio-'.$col.'"><div></div></div></span>
			<img alt="'.get_post_meta($post->ID, "_cox_port_title", true).'" src="'.$p_img_thumb.'"/>
			</a>
			</div></div>
		<div class="ptext-'.$col.'">
			<h4><a href="'.$link.'">'.$title.'</a></h4>
			<p>'.get_post_meta($post->ID, "_cox_port_text", true).'</p>'.$read.
		'</div>
		</div>
	';
endforeach;
$port.='</div>';
return $port;	
}
//cox thumb
function cox_shortcode_img( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'src'      => '',
		'width'      => '',
		'height'      => '',
		'class'      => 'cox-image',
		'alt'      => ''
    ), $atts));
   return '<img width="'.$width.'" height="'.$height.'" src="'.cox_thumb($src,$width,$height).'" alt="'.$alt.'" class="'.$class.'" />';
}
add_shortcode('cox_img', 'cox_shortcode_img');

