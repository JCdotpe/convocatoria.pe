//fonts
      WebFontConfig = {
        google: { families: [ cox.font ] }
      };
      (function() {
        var wf = document.createElement('script');
        wf.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
        wf.type = 'text/javascript';
        wf.async = 'true';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(wf, s);
      })();


//Portfolio
jQuery(".i-1").mouseenter(function(e) {
     jQuery(this).children("a").children("span").fadeIn(70);
}).mouseleave(function(e) {
     jQuery(this).children("a").children("span").fadeOut(400);
});
jQuery(".i-2").mouseenter(function(e) {
     jQuery(this).children("a").children("span").fadeIn(70);
}).mouseleave(function(e) {
     jQuery(this).children("a").children("span").fadeOut(400);
});
jQuery(".i-3").mouseenter(function(e) {
     jQuery(this).children("a").children("span").fadeIn(70);
}).mouseleave(function(e) {
     jQuery(this).children("a").children("span").fadeOut(400);
});

//Prettyphoto
jQuery("a[rel^=prettyPhoto]").prettyPhoto({
	animationSpeed:"slow",
	slideshow:5000,
	social_tools: false
});

//Tooltip
jQuery(".tooltip").poshytip({
	className: "tip-twitter",
	fade: true,
	showTimeout: 0.5
});

		
//Go to top animate
jQuery("a[href=#wrap]").click(function(){
    jQuery("html, body").animate({scrollTop:0}, "slow");
    return false;
});


/*toggle shortcode*/
	//Hide (Collapse) the toggle containers on load
jQuery(".toggle_container").hide(); 

	//Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
jQuery("h5.trigger").click(function(){
	jQuery(this).toggleClass("active").next().slideToggle("slow");
	return false; //Prevent the browser jump to the link anchor
});


/*tabs shortcode*/
//When page loads...
jQuery(".tab_content").hide(); //Hide all content
jQuery("ul.tabs li:first").addClass("active").show(); //Activate first tab
jQuery(".tab_content:first").show(); //Show first tab content

jQuery("ul.tabs li").click(function() {

jQuery("ul.tabs li").removeClass("active"); //Remove any "active" class
jQuery(this).addClass("active"); //Add "active" class to selected tab
jQuery(".tab_content").hide(); //Hide all tab content
	var activeTab = jQuery(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
	jQuery(activeTab).fadeIn(); //Fade in the active ID content
	return false;
});

//Contact
jQuery('.error').hide();
function validate_email(asd)
{

  apos=asd.indexOf("@");
  dotpos=asd.lastIndexOf(".");
  		if (apos<1||dotpos-apos<2){
	  		return false;
	    }else{
		    return true;
		}
}

jQuery("#submit_contact").click(function() {
		// validate and process form
		// first hide any error messages
    jQuery(".error").hide();
	var name = jQuery("input#name").val();
	var email = jQuery("input#email").val();
	var qq = validate_email(email);
	if (qq == false){
		jQuery("label#email_error").show();
		jQuery("input#email").focus();
		return false;
    }
	var text = jQuery("#text").val();
	if (text == "") {
		jQuery("label#text_error").show();
		jQuery("#text").focus();
		return false;
    }
	jQuery(".button").attr("disabled", true);
	var temail = jQuery("input#temail").val();
	var dataString = "name="+ name + "&email=" + email + "&text=" + text + "&temail=" + temail;
	//alert (dataString);return false;
	var theme_url = cox.url;
	jQuery.ajax({
      type: "POST",
      url: theme_url+'/lib/external/send.php',
      data: dataString,
      success: function() {
        jQuery("#contact_form").html('<div id="message"></div>');
        jQuery("#message").html("<h5>» Contact Form Submitted! - We will be in touch soon.</h5>")
        .hide()
        .fadeIn(1500, function() {
        });
      }
     });
    return false;
	});	


//Cox-Boxes
(function($) {
    $.fn.boxes = function(){
		return this.each(function() {
			var box= $(this);
			box.find(".box-close").click(function() {
				box.fadeOut('slow');
			});
		});
		
};
})(jQuery);

jQuery(".cox-alert").boxes();


//Testimonials
// based on the work of Matt Oakes http://portfolio.gizone.co.uk/applications/slideshow/
// and Ralf S. Engelschall http://trainofthoughts.org/

(function($) {

    $.fn.innerfade = function(options) {
        return this.each(function() {   
            $.innerfade(this, options);
        });
    };

    $.innerfade = function(container, options) {
        var settings = {
        		'animationtype':    'fade',
            'speed':            'normal',
            'type':             'sequence',
            'timeout':          2000,
            'containerheight':  'auto',
            'runningclass':     'innerfade',
            'children':         null
        };
        if (options)
            $.extend(settings, options);
        if (settings.children === null)
            var elements = $(container).children();
        else
            var elements = $(container).children(settings.children);
        if (elements.length > 1) {
            $(container).css('position', 'relative').css('height', settings.containerheight).addClass(settings.runningclass);
            for (var i = 0; i < elements.length; i++) {
                $(elements[i]).css('z-index', String(elements.length-i)).css('position', 'absolute').hide();
            };
            if (settings.type == "sequence") {
                setTimeout(function() {
                    $.innerfade.next(elements, settings, 1, 0);
                }, settings.timeout);
                $(elements[0]).show();
            } else if (settings.type == "random") {
            		var last = Math.floor ( Math.random () * ( elements.length ) );
                setTimeout(function() {
                    do { 
												current = Math.floor ( Math.random ( ) * ( elements.length ) );
										} while (last == current );             
										$.innerfade.next(elements, settings, current, last);
                }, settings.timeout);
                $(elements[last]).show();
						} else if ( settings.type == 'random_start' ) {
								settings.type = 'sequence';
								var current = Math.floor ( Math.random () * ( elements.length ) );
								setTimeout(function(){
									$.innerfade.next(elements, settings, (current + 1) %  elements.length, current);
								}, settings.timeout);
								$(elements[current]).show();
						}	else {
							alert('Innerfade-Type must either be \'sequence\', \'random\' or \'random_start\'');
						}
				}
    };

    $.innerfade.next = function(elements, settings, current, last) {
        if (settings.animationtype == 'slide') {
            $(elements[last]).slideUp(settings.speed);
            $(elements[current]).slideDown(settings.speed);
        } else if (settings.animationtype == 'fade') {
            $(elements[last]).fadeOut(settings.speed);
            $(elements[current]).fadeIn(settings.speed, function() {
							removeFilter($(this)[0]);
						});
        } else
            alert('Innerfade-animationtype must either be \'slide\' or \'fade\'');
        if (settings.type == "sequence") {
            if ((current + 1) < elements.length) {
                current = current + 1;
                last = current - 1;
            } else {
                current = 0;
                last = elements.length - 1;
            }
        } else if (settings.type == "random") {
            last = current;
            while (current == last)
                current = Math.floor(Math.random() * elements.length);
        } else
            alert('Innerfade-Type must either be \'sequence\', \'random\' or \'random_start\'');
        setTimeout((function() {
            $.innerfade.next(elements, settings, current, last);
        }), settings.timeout);
    };

})(jQuery);

// **** remove Opacity-Filter in ie ****
function removeFilter(element) {
	if(element.style.removeAttribute){
		element.style.removeAttribute('filter');
	}
}
