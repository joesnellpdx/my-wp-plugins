<?php

/**
 * Script Control
 **/

function jspdx_tmm_events_admin_scriptsload()
{
	// Register the style like this for a plugin:
	wp_register_style( 'admin_css', JSPDX_TMM_EVENTS_URL.'css/admin.css', array(), '20130222', 'all' );
	wp_register_script( 'timepicker', JSPDX_TMM_EVENTS_URL 	.('js/timepicker.js') );
	wp_enqueue_style('admin_css');
	wp_enqueue_style( 'jspdx-tmm-events-css' ); 
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/themes/smoothness/jquery-ui.css');
	wp_enqueue_script('timepicker');
    wp_enqueue_script( 'jspdx_tmm_events_admin_js', JSPDX_TMM_EVENTS_URL. 'js/jspdx_tmm_events_admin.js', array( 'jquery' ) );

}
add_action( 'admin_enqueue_scripts', 'jspdx_tmm_events_admin_scriptsload' );

?>

<?php
    add_action( 'admin_init', 'jspdx_tmm_events_admin_init' );
    add_action( 'admin_menu', 'jspdx_tmm_events_menu' );

    function jspdx_tmm_events_admin_init() {
        /* Register our script. */
        wp_register_style( 'admin_css', JSPDX_TMM_EVENTS_URL.'css/admin.css', array(), '20130222', 'all' );
        wp_register_script( 'jspdx_tmm_events_admin_js', JSPDX_TMM_EVENTS_URL . ('js/jspdx_tmm_events_admin.js', __FILE__) );
        wp_register_script( 'timepicker', JSPDX_TMM_EVENTS_URL . ('js/timepicker.js', __FILE__) );
    }

    function jspdx_tmm_events_admin_menu() {
        /* Register our plugin page */
        $page = add_submenu_page( 'edit.php', // The parent page of this menu
                                  __( 'JSPDX TMM Events', 'myPlugin' ), // The Menu Title
                                  __( 'JSPDX TMM  Events', 'myPlugin' ), // The Page title
				  'manage_options', // The capability required for access to this item
				  'my_plugin-options', // the slug to use for the page in the URL
                                  'my_plugin_manage_menu' // The function to call to render the page
                               );

        /* Using registered $page handle to hook script load */
        add_action('admin_print_scripts-' . $page, 'jspdx_tmm_events_admin_scripts');
    }

    function jspdx_tmm_events_admin_scripts() {
        /*
         * It will be called only on your plugin admin page, enqueue our script here
         */
        wp_enqueue_style( 'admin_css' );
        wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script('timepicker');
		wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/themes/smoothness/jquery-ui.css');
        wp_enqueue_script( 'jspdx_tmm_events_admin_js' );
    }

    function jspdx_tmm_events_manage_menu() {
        /* Output our admin page */
    }
?>

<!-- new -->
				
				<?php foreach ($items as $num => $item) : 
					if (!empty($item)) :
						if ((empty($item_links[$num])) && (empty($item_descs[$num]))) :
							echo("<li class='jspdx-tmm-events-li'><span class='" . $item_classes[$num] . "'>" . $item . "</span></li>");
						else :
							// new
							if((empty($item_links[$num])) && ($item_descs[$num])) :
								echo("<li class='jspdx-tmm-events-li'><span class='" . $item_classes[$num] . "'>" . $item . "</span><br>" . $item_descs[$num] . "</li>");
							elseif(($item_targets[$num]) && (empty($item_descs[$num]))) :
								echo("<li class='jspdx-tmm-events-li'><a href='" . $item_links[$num] . "' target='_blank' class='" . $item_classes[$num] . "'>" . $item . "</a></li>");
							// new
							elseif(($item_targets[$num]) && ($item_descs[$num])) :
								echo("<li class='jspdx-tmm-events-li'><a href='" . $item_links[$num] . "' target='_blank' class='" . $item_classes[$num] . "'>" . $item . "</a><br>" . $item_descs . "</li>");
							elseif((empty($item_targets[$num])) && ($item_descs[$num])) :
								echo("<li class='jspdx-tmm-events-li'><p><a href='" . $item_links[$num] . "'' class='" . $item_classes[$num] . "'>" . $item . "</a></p><p>" . $item_descs[$num] . "</p><p>" . date('l, F jS, Y', strtotime($item_startdates[$num])) . "</p><p>" . $item_enddates[$num] . "</p><p>" . date('g:i a', strtotime($item_starttimes[$num])) . "</p><p>" . $item_endtimes[$num] . "</p></li>");
							else :
								echo("<li class='jspdx-tmm-events-li'><a href='" . $item_links[$num] . "'' class='" . $item_classes[$num] . "'>" . $item . "</a></li>");
							endif;
						endif;
					endif;
				 endforeach; ?>
				 <!-- new -->


				 				<?php foreach ($items as $num => $item) : 
					if (!empty($item)) :
						if (empty($item_links[$num])) :
							echo("<li class='jspdx-tmm-events-li'><div itemscope itemtype='http://schema.org/BusinessEvent' class='" . $item_classes[$num] . "'><div itemprop='name'><strong>" . $item . "</strong></div>");
						else :
							if($item_targets[$num]) :
								echo("<li class='jspdx-tmm-events-li'><div itemscope itemtype='http://schema.org/BusinessEvent' class='" . $item_classes[$num] . "'><a itemprop='url' href='" . $item_links[$num] . "' target='_blank'><div itemprop='name'><strong>" . $item . "</strong></div></a>");
							else :
								echo("<li class='jspdx-tmm-events-li'><div itemscope itemtype='http://schema.org/BusinessEvent' class='" . $item_classes[$num] . "'><a itemprop='url' href='" . $item_links[$num] . "'><div itemprop='name'><strong>" . $item . "</strong></div></a>");
							endif;
						endif;
						if($item_descs[$num]) :
							echo("<div itemprop='description'>" . $item_descs[$num] . "</div>");
						endif;
						if (empty($item_endates[$num]) :
							echo("<div><meta itemprop='startDate' content='" . $item_startdates[$num] . "'>" . date('l, F jS, Y', strtotime($item_startdates[$num])) . "</div>");
							else :
								if ($item_startdates[$num] == $item_endates[$num] :
									echo("<div><meta itemprop='startDate' content='" . $item_startdates[$num] . "'>" . date('l, F jS, Y', strtotime($item_startdates[$num])) . "</div>");
								else :
									echo("<div><meta itemprop='startDate' content='" . $item_startdates[$num] . "'>" . date('l, F jS, Y', strtotime($item_startdates[$num])) . "</div> - <div><meta itemprop='endDate' content='" . $item_enddates[$num] . "'>" . date('l, F jS, Y', strtotime($item_enddates[$num])) . "</div>");
								endif;
						endif;
						if (empty($item_endtimes[$num]) :
							echo("<div><meta itemprop='startDate' content='" . $item_startdates[$num] . "'>" . date('l, F jS, Y', strtotime($item_startdates[$num])) . "</div>");
							else :
								if ($item_startdates[$num] == $item_endates[$num] :
									echo("<div><meta itemprop='startDate' content='" . $item_startdates[$num] . "'>" . date('l, F jS, Y', strtotime($item_startdates[$num])) . "</div>");
								else :
									echo("<div><meta itemprop='startDate' content='" . $item_startdates[$num] . "'>" . date('l, F jS, Y', strtotime($item_startdates[$num])) . "</div> - <div><meta itemprop='endDate' content='" . $item_enddates[$num] . "'>" . date('l, F jS, Y', strtotime($item_enddates[$num])) . "</div>");
								endif;
						endif;
						echo("</div></li>");
					endif;
				 endforeach; ?>