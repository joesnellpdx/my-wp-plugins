<?php

/**
 * Script Control
 **/

function jspdx_tmm_events_admin_scriptsload()
{
  // Register the style like this for a plugin:
  wp_register_style( 'admin_css', JSPDX_TMM_EVENTS_URL.'css/admin.css', array(), '20130222', 'all' );
  //wp_register_script( 'timepicker', JSPDX_TMM_EVENTS_URL  .('js/timepicker.js'), array( 'jquery' ) );
  wp_enqueue_style('admin_css');
  wp_enqueue_style( 'jspdx-tmm-events-css' ); 
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-ui-core');
  wp_enqueue_script('jquery-ui-slider');
  wp_enqueue_script('jquery-ui-datepicker');
  wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/themes/smoothness/jquery-ui.css');
  wp_enqueue_script( 'timepicker', JSPDX_TMM_EVENTS_URL. 'js/timepicker.js', array( 'jquery'));
  wp_enqueue_script( 'jspdx_tmm_events_admin_js', JSPDX_TMM_EVENTS_URL. 'js/jspdx_tmm_events_admin.js', array( 'jquery-ui-core' ,'jquery-ui-datepicker', 'jquery-ui-slider' ) );

}
add_action( 'admin_enqueue_scripts', 'jspdx_tmm_events_admin_scriptsload' );

?>