<?php
/*
Plugin Name: JSPDX TMM Events
Description: Create and events list for Thoroughly Modern Marketing (http://www.tmmpdx.com)
Version: 1.0
Author: Joe Snell
Author URI: http://www.joesnellpdx.com
Plugin URI: https://github.com/joesnellpdx/my-wp-plugins/tree/master/jspdx-tmm-events
*/

/**
 * Global variables
 **/

$jspdx_plugin_name = 'JSPDX-TMM-Events';


/**
 * Define some useful constants
 **/
define('JSPDX_TMM_EVENTS_VERSION', '1.0');
define('JSPDX_TMM_EVENTS_DIR', plugin_dir_path(__FILE__));
define('JSPDX_TMM_EVENTS_URL', plugin_dir_url(__FILE__));



/**
 * Load files
 * 
 **/
function jspdx_tmm_events_load(){
		
    if(is_admin()) //load admin files only in admin
        require_once(JSPDX_TMM_EVENTS_DIR.'includes/admin.php');

    require_once(JSPDX_TMM_EVENTS_DIR.'includes/scripts.php');
    require_once(JSPDX_TMM_EVENTS_DIR.'includes/core.php');
}

jspdx_tmm_events_load();



/**
 * Activation, Deactivation and Uninstall Functions
 * 
 **/
register_activation_hook(__FILE__, 'jspdx_tmm_events_activation');
register_deactivation_hook(__FILE__, 'jspdx_tmm_events_deactivation');


function jspdx_tmm_events_activation() {
    
	//actions to perform once on plugin activation go here    
    
	
    //register uninstaller
    register_uninstall_hook(__FILE__, 'jspdx_tmm_events_uninstall');
}

function jspdx_tmm_events_deactivation() {
    
	// actions to perform once on plugin deactivation go here
	    
}

function jspdx_tmm_events_uninstall(){
    
    //actions to perform once on plugin uninstall go here
	    
}
?>