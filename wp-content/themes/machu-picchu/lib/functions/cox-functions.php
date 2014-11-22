<?php

function cox_thumb($url,$w,$h) {
	$img_ar = @getimagesize($url);
	$img['w'] = $img_ar[0];
	$img['h'] = $img_ar[1];
	if($img['h'] > $h || $img['w'] > $w || !isset($img['w'])){
	$url= CHILD_URL."/lib/external/timthumb.php?src=$url&amp;w=$w&amp;h=$h&amp;zc=1&amp;q=100";
	}
	return $url;
	
}

function cox_email($email) {
if($email=='')
$email =  get_option('admin_email');

$contact ='
<div id="contact_form">
  <form name="contact" method="post">
    <fieldset>
      <label for="name" id="name_label">Name</label>
      <input type="text" name="name" id="name" size="30" value="" class="text-input" />
      <label class="error" for="name" id="name_error" style="display: block; margin-top: -12px; margin-bottom: 25px; color:#c2c2c2; font-size:10px;">This field is required.</label>
	  
      <label for="email" id="email_label">Email</label>
      <input type="text" name="email" id="email" size="30" value="" class="text-input" />
      <label class="error" for="email" id="email_error" style="display: block; margin-top: -12px; margin-bottom: 25px; color:#c2c2c2; font-size:10px;">This field is required.</label>
	  
      <label for="text" id="text_label">Message</label>
      <textarea cols="20" rows="5" name="text" id="text"></textarea>
      <label class="error" for="text" id="text_error" style="display: block; margin-top: -10px; margin-bottom: 25px; color:#c2c2c2; font-size:10px;">This field is required.</label>
      <input name="temail" id="temail" type="hidden" value="'.$email.'" />
      <input type="submit" name="submit" class="button" id="submit_contact" value="Send" />
    </fieldset>
  </form>
</div>
';
return $contact;
}

function cox_from_option( $opt ) {
	$return='';
	switch($opt){
		//cox-settings
		case 1:
			$return = COX_SETTINGS_FIELD;
			break;
		default:
			return '';
	}
    return $return;
}

function cox_get_fresh_option( $opt, $from ) {
	$setting = get_option(cox_from_option($from));
        if ( isset($setting[$opt]) )
            return $setting[$opt];
        return false;
}

function cox_get_option( $opt, $from ) {
	return genesis_get_option($opt, cox_from_option($from));
}

function cox_get_version() {
    $theme_data = get_theme_data(CHILD_DIR . '/style.css');
    return $theme_data['Version'];
}

function cox_add_select_setting($id, $label, $from, $type) {
    return cox_add_label($id, $label) . '<select id="' . $id . '" name="' . cox_from_option($from) . '[' . $id . ']" class="' . $type . '-option-types">' . cox_create_options(cox_get_fresh_option($id, $from), $type) . '</select>';
}

function cox_add_text_setting($id, $label, $from, $size = 25) { 
    return cox_add_label($id, $label) . '<input type="text" id="' . $id . '" name="' . cox_from_option($from) . '[' . $id . ']" size="' . $size . '" value="' . esc_attr( cox_get_fresh_option($id, $from) ) . '" />';
}

function cox_add_color_setting($id, $label, $from) { 
    return cox_add_label($id, $label) . '<input type="text" id="' . $id . '" name="' . cox_from_option($from) . '[' . $id . ']" size="8" maxsize="7" value="' . esc_attr( cox_get_fresh_option($id, $from) ) . '" class="color-picker" />';
}

function cox_add_checkbox_setting($id, $label, $from) { 
    return '<input type="checkbox" id="' . $id . '" name="' . cox_from_option($from) . '[' . $id . ']" value="true" class="checkbox" ' . checked(cox_get_fresh_option($id, $from), 'true', false) . '/>' . cox_add_label($id, $label, true, false);
}

function cox_add_textarea_setting($id, $label, $from, $cols = 25, $rows = 10) { 
    return cox_add_label($id, $label) . '<br /><textarea id="' . $id . '" name="' . cox_from_option($from) . '[' . $id . ']" cols="'.$cols.'" rows="'.$rows.'">' . esc_attr(cox_get_fresh_option($id, $from)) . '</textarea>';
}

function cox_add_note($note) {
    return '<span class="description"><strong>' . __('Note', COX_DOMAIN) . ':</strong> ' . $note . '</span>';
}

function cox_setting_line($args) {
    if ( is_array($args) ) {
        $output = '';
        foreach ($args as $arg) {
            $output .= ' ' .$arg;
        }
        cox_setting_line($output);
    } else {?>
            <p><?php echo $args; ?></p>
    <?php
    }
}

function cox_add_label($id, $label, $add_end_tag = true, $add_colon = true) {
    $return = '';
    if (strlen($label) > 0) {
        $return = sprintf('<label for="%s">%s', $id, $label);
        if ($add_colon)
            $return .= ':';
        if ($add_end_tag)
            $return .= '</label>';
    }
    return $return;
}


function cox_create_options($compare, $type) {
    switch($type) {
		        case "family":
            //font-family sets
            $options = array(
                array('Aclonica', 'Aclonica'),
                array('Allan', 'Allan'),
                array('Allerta', 'Allerta'),
                array('Allerta Stencil', 'Allerta Stencil'),
                array('Amaranth', 'Amaranth'),
                array('Angkor', 'Angkor'),
                array('Annie Use Your Telescope', 'Annie Use Your Telescope'),
                array('Anonymous Pro','Anonymous Pro'),
                array('Anton', 'Anton'),
                array('Architects Daughter', 'Architects Daughter'),
                array('Arimo', 'Arimo'),
                array('Artifika', 'Artifika'),
                array('Arvo', 'Arvo'),
                array('Asset', 'Asset'),
                array('Astloch', 'Astloch'),
                array('Bangers', 'Bangers'),
                array('Battambang', 'Battambang'),
                array('Bayon', 'Bayon'),
                array('Bentham', 'Bentham'),
                array('Bevan', 'Bevan'),
                array('Bigshot One', 'Bigshot One'),
                array('Bokor', 'Bokor'),
                array('Brawler', 'Brawler'),
                array('Buda', 'Buda'),
                array('Cabin', 'Cabin'),
                array('Cabin Sketch', 'Cabin Sketch'),
                array('Calligraffitti', 'Calligraffitti'),
                array('Candal', 'Candal'),
                array('Cantarell', 'Cantarell'),
                array('Cardo', 'Cardo'),
                array('Carter One', 'Carter One'),
                array('Caudex', 'Caudex'),
                array('Cedarville Cursive', 'Cedarville Cursive'),	
                array('Chenla', 'Chenla'),
                array('Cherry Cream Soda', 'Cherry Cream Soda'),
                array('Chewy', 'Chewy'),
                array('Coda', 'Coda'),
                array('Coda Caption', 'Coda Caption'),
                array('Coming Soon', 'Coming Soon'),
                array('Content', 'Content'),
                array('Copse', 'Copse'),
                array('Corben', 'Corben'),
                array('Cousine', 'Cousine'),
                array('Covered By Your Grace', 'Covered By Your Grace'),
                array('Crafty Girls', 'Crafty Girls'),
                array('Crimson Text', 'Crimson Text'),
                array('Crushed', 'Crushed'),
                array('Cuprum', 'Cuprum'),
                array('Damion', 'Damion'),
                array('Dancing Script', 'Dancing Script'),
                array('Dangrek', 'Dangrek'),
                array('Dawning of a New Day', 'Dawning of a New Day'),
                array('Didact Gothic', 'Didact Gothic'),
                array('Droid Sans', 'Droid Sans'),
                array('Droid Sans Mono', 'Droid Sans Mono'),
                array('Droid Serif', 'Droid Serif'),
                array('EB Garamond', 'EB Garamond'),
                array('Expletus Sans', 'Expletus Sans'),
                array('Fontdiner Swanky', 'Fontdiner Swanky'),
                array('Holtwood One SC', 'Holtwood One SC'),
                array('Freehand', 'Freehand'),
                array('GFS Didot', 'GFS Didot'),
                array('GFS Neohellenic', 'GFS Neohellenic'),
                array('Geo', 'Geo'),
                array('Goblin One', 'Goblin One'),
                array('Goudy Bookletter 1911', 'Goudy Bookletter 1911'),	
                array('Gravitas One', 'Gravitas One'),
                array('Gruppo', 'Gruppo'),
                array('Hammersmith One', 'Hammersmith One'),
                array('Hanuman', 'Hanuman'),
                array('Holtwood One SC', 'Holtwood One SC'),
                array('Homemade Apple', 'Homemade Apple'),
                array('IM Fell DW Pica', 'IM Fell DW Pica'),
                array('IM Fell DW Pica SC', 'IM Fell DW Pica SC'),
                array('IM Fell Double Pica', 'IM Fell Double Pica'),
                array('IM Fell Double Pica SC', 'IM Fell Double Pica SC'),
                array('IM Fell English', 'IM Fell English'),
                array('IM Fell English SC', 'IM Fell English SC'),
                array('IM Fell French Canon', 'IM Fell French Canon'),
                array('IM Fell French Canon SC', 'IM Fell French Canon SC'),
                array('IM Fell Great Primer', 'IM Fell Great Primer'),
                array('IM Fell Great Primer SC', 'IM Fell Great Primer SC'),
                array('Inconsolata', 'Inconsolata'),
                array('Indie Flower', 'Indie Flower'),
                array('Irish Grover', 'Irish Grover'),
                array('Josefin Sans', 'Josefin Sans'),
                array('Josefin Slab', 'Josefin Slab'),
                array('Judson', 'Judson'),
                array('Jura', 'Jura'),
                array('Just Another Hand', 'Just Another Hand'),
                array('Just Me Again Down Here', 'Just Me Again Down Here'),
                array('Kameron', 'Kameron'),
                array('Kenia', 'Kenia'),
                array('Khmer', 'Khmer'),
                array('Koulen', 'Koulen'),
                array('Kranky', 'Kranky'),
                array('Kreon', 'Kreon'),
                array('Kristi', 'Kristi'),
                array('La Belle Aurore', 'La Belle Aurore'),
                array('Lato', 'Lato'),
                array('League Script', 'League Script'),
                array('Lekton', 'Lekton'),
                array('Limelight', 'Limelight'),
                array('Lobster', 'Lobster'),
                array('Lobster Two', 'Lobster Two'),
                array('Lora', 'Lora'),
                array('Luckiest Guy', 'Luckiest Guy'),
                array('Maiden Orange', 'Maiden Orange'),
                array('Mako', 'Mako'),
                array('Maven Pro', 'Maven Pro'),
                array('Meddon', 'Meddon'),
                array('MedievalSharp', 'MedievalSharp'),
                array('Megrim', 'Megrim'),
                array('Merriweather', 'Merriweather'),
                array('Metal', 'Metal'),
                array('Metrophobic', 'Metrophobic'),
                array('Michroma', 'Michroma'),
                array('Miltonian', 'Miltonian'),
                array('Miltonian Tattoo', 'Miltonian Tattoo'),
                array('Molengo', 'Molengo'),
                array('Monofett', 'Monofett'),
                array('Moul', 'Moul'),
                array('Moulpali', 'Moulpali'),
                array('Mountains of Christmas', 'Mountains of Christmas'),
                array('Muli', 'Muli'),
                array('Neucha', 'Neucha'),
                array('Neuton', 'Neuton'),
                array('News Cycle', 'News Cycle'),
                array('Nobile', 'Nobile'),
                array('Nova Cut', 'Nova Cut'),
                array('Nova Flat', 'Nova Flat'),
                array('Nova Mono', 'Nova Mono'),		
                array('Nova Oval', 'Nova Oval'),
                array('Nova Round', 'Nova Round'),
                array('Nova Script', 'Nova Script'),
                array('Nova Slim', 'Nova Slim'),
                array('Nova Square', 'Nova Square'),
                array('Nunito', 'Nunito'),
                array('OFL Sorts Mill Goudy TT', 'OFL Sorts Mill Goudy TT'),
                array('Odor Mean Chey', 'Odor Mean Chey'),
                array('Old Standard TT', 'Old Standard TT'),
                array('Open Sans', 'Open Sans'),
                array('Open Sans Condensed', 'Open Sans Condensed'),
                array('Orbitron', 'Orbitron'),
                array('Oswald', 'Oswald'),
                array('Over the Rainbow', 'Over the Rainbow'),
                array('PT Sans', 'PT Sans'),
                array('PT Sans Caption', 'PT Sans Caption'),
                array('PT Sans Narrow', 'PT Sans Narrow'),
                array('PT Serif', 'PT Serif'),
                array('PT Serif Caption', 'PT Serif Caption'),
                array('Pacifico', 'Pacifico'),
                array('Paytone One', 'Paytone One'),
                array('Permanent Marker', 'Permanent Marker'),
                array('Philosopher', 'Philosopher'),
                array('Play', 'Play'),
                array('Playfair Display', 'Playfair Display'),
                array('Podkova', 'Podkova'),
                array('Preahvihear', 'Preahvihear'),
                array('Puritan', 'Puritan'),
                array('Quattrocento', 'Quattrocento'),
                array('Quattrocento Sans', 'Quattrocento Sans'),
                array('Radley', 'Radley'),
                array('Raleway', 'Raleway'),
                array('Redressed', 'Redressed'),
                array('Reenie Beanie', 'Reenie Beanie'),
                array('Rock Salt', 'Rock Salt'),
                array('Rokkitt', 'Rokkitt'),
                array('Ruslan Display', 'Ruslan Display'),
                array('Schoolbell', 'Schoolbell'),
                array('Shadows Into Light', 'Shadows Into Light'),
                array('Shanti', 'Shanti'),
                array('Siemreap', 'Siemreap'),
                array('Sigmar One', 'Sigmar One'),
                array('Six Caps', 'Six Caps'),
                array('Slackey', 'Slackey'),
                array('Smythe', 'Smythe'),
                array('Sniglet', 'Sniglet'),
                array('Special Elite', 'Special Elite'),
                array('Sue Ellen Francisco', 'Sue Ellen Francisco'),
                array('Sunshiney', 'Sunshiney'),
                array('Suwannaphum', 'Suwannaphum'),
                array('Swanky and Moo Moo', 'Swanky and Moo Moo'),
                array('Syncopate', 'Syncopate'),
                array('Tangerine', 'Tangerine'),
                array('Taprom', 'Taprom'),
                array('Tenor Sans', 'Tenor Sans'),
                array('Terminal Dosis Light', 'Terminal Dosis Light'),
                array('The Girl Next Door', 'The Girl Next Door'),			
                array('Tinos', 'Tinos'),
                array('Ubuntu', 'Ubuntu'),
                array('Ultra', 'Ultra'),
                array('UnifrakturCook', 'UnifrakturCook'),
                array('UnifrakturMaguntia', 'UnifrakturMaguntia'),
                array('Unkempt', 'Unkempt'),
                array('VT323', 'VT323'),
                array('Varela', 'Varela'),
                array('Vibur', 'Vibur'),
                array('Vollkorn', 'Vollkorn'),
                array('Waiting for the Sunrise', 'Waiting for the Sunrise'),
                array('Wallpoet', 'Wallpoet'),
                array('Walter Turncoat', 'Walter Turncoat'),
                array('Wire One', 'Wire One'),
                array('Yanone Kaffeesatz', 'Yanone Kaffeesatz'),
                array('Zeyada', 'Zeyada'),																																												
                array('Kameron', 'Kameron')
            );
            $options = apply_filters('cox_font_family_options', $options);
            sort($options);
            array_unshift($options, array('Inherit', 'inherit')); // Adds Inherit option as first option.
            break;
		case "layout":
            //Theme layout sets
            $options = array(
                array('Box', 'box'),
				array('Full', 'full')
            );
           break;
		 case "effect":
            //Theme layout sets
            $options = array(
                array('random', 'random'),
				array('simpleFade', 'simpleFade'),
				array('curtainTopLeft', 'curtainTopLeft'),
				array('curtainTopRight', 'curtainTopRight'),
				array('curtainBottomLeft', 'curtainBottomLeft'),
				array('curtainBottomRight', 'curtainBottomRight'),
				array('curtainSliceLeft', 'curtainSliceLeft'),
				array('curtainSliceRight', 'curtainSliceRight'),
				array('blindCurtainTopLeft', 'blindCurtainTopLeft'),
				array('blindCurtainTopRight', 'blindCurtainTopRight'),
				array('blindCurtainBottomLeft', 'blindCurtainBottomLeft'),
				array('blindCurtainBottomRight', 'blindCurtainBottomRight'),
				array('blindCurtainSliceBottom', 'blindCurtainSliceBottom'),
				array('blindCurtainSliceTop', 'blindCurtainSliceTop'),
				array('stampede', 'stampede'),
				array('mosaic', 'mosaic'),
				array('mosaicReverse', 'mosaicReverse'),
				array('mosaicRandom', 'mosaicRandom'),
				array('mosaicSpiral', 'mosaicSpiral'),
				array('mosaicSpiralReverse', 'mosaicSpiralReverse'),
				array('topLeftBottomRight', 'topLeftBottomRight'),
				array('bottomRightTopLeft', 'bottomRightTopLeft'),
				array('bottomLeftTopRight', 'bottomLeftTopRight')
            );
           break;		
        default:
            $options = '';
    }
	if ( is_array($options) ) {
        $output = '';
        foreach ($options as $option) {
            $output .= '<option value="'. esc_attr($option[1]) . '" title="' . esc_attr($option[1]) . '" ' . selected(esc_attr($option[1]), esc_attr($compare), false) . '>' . __($option[0], COX_DOMAIN) . '</option>';
        }
    } else {
        $output = '<option>'.__('Select type was not valid.', COX_DOMAIN).'</option>';
    }
    return $output;
}


function cox_add_radio_setting($id, $from, $type) {
    
    switch($type) {
        case 'cox-menu-link':
            //Cox Menu Target
            $options = array(
                array('— same window or tab.',''),
                array('— new window or tab.','_blank'),
                array('— current window or tab, with no frames.','_top')
            );
            break;
        default:
            $options = '';
    }
	
	if ( is_array($options) ) {
        $output = '';
        foreach ($options as $option) {
            $output .= '<label><input type="radio" name="'. cox_from_option($from) .'[' . $id . ']" id="'. $id .'" value="'. $option[1] .'" '. checked($option[1],cox_get_fresh_option($id, $from),false) . ' />'. esc_attr($option[0]). '</label>' ;
		}
    } else {
        $output = __('Radio type was not valid.', COX_DOMAIN);
    }
    return $output;
}

