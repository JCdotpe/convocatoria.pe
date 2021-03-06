
jQuery(document).ready(function($) {
    var isUnsaved = false, $design_settings = $('#cox-settings');
    
    // Start with all post boxes closed
    if (cox.firstTime) {
        $('div.postbox').addClass('closed');
        postboxes.save_state(cox.pageHook);
    }
    
    // close postboxes that should be closed
    $('.if-js-closed').removeClass('if-js-closed').addClass('closed');
    // postboxes setup
    postboxes.add_postbox_toggles(cox.pageHook);
    
    // Add bottom margin to last meta box in each column, then bring Save / Reset buttons back in to place.
    $('.postbox-container:first .postbox:last, .postbox-container .postbox:last', $design_settings).css('marginBottom', '195px');
    $('.bottom-buttons input:first').css({'float': 'right', 'margin-top': '-180px', 'margin-right': '140px'});
    $('.bottom-buttons input:last').css({'float': 'right', 'margin-top': '-180px'});
    
    // Add toggle button functionality.
    $('<button id="toggle-meta-boxes" class="button button-secondary add-new-h2">' + cox.toggleAll + '</button>"')
    .appendTo($('#top-buttons', $design_settings))
    .click(function() {
        $('div.postbox').toggleClass('closed');
        postboxes.save_state(pagenow);
        return false;
    });
    
    $('.button-reset').click(function() {
        return genesis_confirm(cox.warnReset);
    })
    
    // Add dirty flag when we change an option
    $('input, select', $design_settings).change(function() {
        isUnsaved = true;
    })
    
    // Remove dirty flag when we save options
    $('form', $design_settings).submit (function() {
       isUnsaved = false; 
    });
    
    // Give warning if value changed and we try to leave the page before saving.
    $(window).bind('beforeunload', function(){
        if (isUnsaved) {
            return cox.warnUnsaved;
        }
    });
	
        // Add color picker to color input boxes.
    $('input:text.color-picker', $design_settings).each(function (i) {
        $(this).after('<div id="picker-' + i + '" style="z-index: 100; background: #EEE; border: 1px solid #CCC; position: absolute; display: block;"></div>');
        $('#picker-' + i).hide().farbtastic($(this));
    })
    .focus(function() {
        $(this).next().show();
    })
    .blur(function() {
        $(this).next().hide();
        isUnsaved = true;
    });
	
	

});