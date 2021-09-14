<?php

if (function_exists('add_image_size')) {
  add_image_size( 'loop-square', 350, 350, array('center', 'center'));
  add_image_size( 'loop-thumbnail', 350, 150, array('center', 'center'));
  add_image_size( 'loop-list-thumbnail', 350, 250, array('center', 'center'));
  add_image_size( 'vertical-media-image', 400, 490, array('center', 'center'));
  add_image_size( 'horizontal-media-image', 500, 400, array('center', 'center'));
  add_image_size( 'slide-image', 1100, 400, array('center', 'center'));
	add_image_size( 'grid-image', 400, 400, array('center', 'center'));
}

if(!function_exists('mapi_var_dump')) {
  function mapi_var_dump($var) {
    if (current_user_can('administrator') && isset($var)) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
  }
}

if(!function_exists('mapi_write_log')) {
	function mapi_write_log($message) {
	    if ( WP_DEBUG === true ) {
	        if ( is_array($message) || is_object($message) ) {
	            error_log( print_r($message, true) );
	        } else {
	            error_log( $message );
	        }
	    }
	}
}

add_action('after_setup_theme', function () {
  if (!current_user_can('administrator') && !is_admin()) {
    show_admin_bar(false);
  }
});


add_filter( 'mapi_block_wrappers', function($noWrapper) {
  $noWrapper[] = 'acf/image-slider';
  return $noWrapper;
}, 10, 1 );


function mapi_get_regisered_size_options() {
	$included_sizes = wp_get_registered_image_subsizes();
  $sizes = array();
  if($included_sizes) :
  	foreach ($included_sizes as $key => $size) :
      $sizes[$key] = ucwords(str_replace ('-', ' ', $key)) . ' ' . $size['width'] . ' x ' . $size['height'];
    endforeach;
  endif;
  return $sizes;
}



if(!function_exists('mapi_limit_string')) {
  function mapi_limit_string($str, $length = 120) {
    if($str) :
      $str = wordwrap($str, $length);
      $str = explode("\n", $str);
      $str = $str[0] . '...';
    endif;
    return $str;
  }
}


/**
 * Checks to see if the specified email address has a Gravatar image.
 *
 * @param	$email_address	The email of the address of the user to check
 * @return			          Whether or not the user has a gravatar
 * @since	1.0
 */
if(!function_exists('mapi_has_gravatar')) {
  function mapi_has_gravatar( $email_address ) {
  	// Build the Gravatar URL by hasing the email address
  	$url = 'http://www.gravatar.com/avatar/' . md5( strtolower( trim ( $email_address ) ) ) . '?d=404';
  	// Now check the headers...
  	$headers = @get_headers( $url );
  	// If 200 is found, the user has a Gravatar; otherwise, they don't.
  	return preg_match( '|200|', $headers[0] ) ? true : false;
  }
}
