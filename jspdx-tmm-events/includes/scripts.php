<?php

/**
 * Script Control
 **/

function jspdx_tmm_events_scriptsload()
{
	// Register the style like this for a plugin:
	
	wp_register_style( 'jspdx-tmm-events-css', JSPDX_TMM_EVENTS_URL.'css/jspdx-tmm-events.css', array(), '20130222', 'all' );
	wp_enqueue_style( 'jspdx-tmm-events-css' ); 

}
add_action( 'wp_enqueue_scripts', 'jspdx_tmm_events_scriptsload' );

?>