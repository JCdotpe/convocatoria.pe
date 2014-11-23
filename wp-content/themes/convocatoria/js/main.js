/**
 * main3.js
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2014, Codrops
 * http://www.codrops.com
 */

 $( document ).ready(function() {
 	contentHeader = document.querySelector( '.site-header' );
 	contentAds = document.querySelector( '.header-ads' );

	contentHeader.addEventListener( 'click', function(ev) {
		var target = ev.target;
		if ($('body').hasClass('open-iframe')) {
			close_menu();
		}
	});


	contentAds.addEventListener( 'click', function(ev) {
		var target = ev.target;
		if ($('body').hasClass('open-iframe')) {
			close_menu();
		}
	});


});

function close_menu(){

	$('body').removeClass('open-iframe');
	var bodyEl = document.body;
	$("#iframe-ajax-load").attr("src", "");
	classie.remove( bodyEl, 'show-menu' );
	setTimeout( function() {
		path.attr( 'd', initialPath );
		isAnimating = false; 
	}, 300 );

}


function iframe_load(id_button){

	var bodyEl = document.body;
	morphEl = document.getElementById( 'morph-shape' );
	s = Snap( morphEl.querySelector( 'svg' ) );
	path = s.select( 'path' );
	pathOpen = morphEl.getAttribute( 'data-morph-open' );
	initialPath = this.path.attr('d');

	iframe_src = $("#"+id_button+"").val();
	$("#iframe-ajax-load").attr("src", iframe_src);
	classie.add( bodyEl, 'show-menu' );
	path.animate( { 'path' : pathOpen }, 400, mina.easeinout, function() { isAnimating = false; } );
	$('body').addClass('open-iframe');

}
 

(function($) { $(document).ready( function() { $('.navbar-header').on('click','button',function(e) { e.preventDefault(); var menuName = $(this).data('target'); 

	$(menuName).slideToggle(); }); var menuName = $('.navbar-header button').data('target'); $(menuName).slideUp(); }); })(jQuery); 
 
