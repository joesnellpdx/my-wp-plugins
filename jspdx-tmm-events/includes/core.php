<?php

/**
 * Core
 **/

class JSPDXTMMEventsWidget extends WP_Widget {

	function JSPDXTMMEventsWidget() {
		$widget_ops = array('classname' => 'jspdx-tmm-events', 'description' => __('A list of TMM Events'));
		$this->WP_Widget('list', __('JSPDX TMM Events'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? __('List') : $instance['title']);

		$amount = empty($instance['amount']) ? 3 : $instance['amount'];
		
		for ($i = 1; $i <= $amount; $i++) {
			$items[$i] = $instance['item' . $i];
			$item_links[$i] = $instance['item_link' . $i];
			$item_descs[$i] = $instance['item_desc' . $i];
			$item_startdates[$i] = $instance['item_startdate' . $i];
			$item_enddates[$i] = $instance['item_enddate' . $i];
			$item_classes[$i] = isset($instance['item_class' . $i]) ? $instance['item_class' . $i] : '';
			$item_targets[$i] = isset($instance['item_target' . $i]) ? $instance['item_target' . $i] : false;
		}

		echo $before_widget .  $before_title . $title . $after_title;  ?>
			<?php echo "<ol class='jspdx-tmm-events-ol'>"; ?>

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
						if (empty($item_enddates[$num])) :
							echo("<div><meta itemprop='startDate' content='" . date('c', strtotime($item_startdates[$num])) . "'>" . date('l, F jS, g:i a', strtotime($item_startdates[$num])) . "</div>");
							else :
								if (date('l, F jS, g:i a', strtotime($item_startdates[$num])) == date('l, F jS, g:i a', strtotime($item_enddates[$num]))) :
									echo("<div><meta itemprop='startDate' content='" . date('c', strtotime($item_startdates[$num])) . "'>" . date('l, F jS, g:i a', strtotime($item_startdates[$num])) . "</div>");
								elseif (date('l, F jS', strtotime($item_startdates[$num])) == date('l, F jS', strtotime($item_enddates[$num]))) :
									echo("<div><meta itemprop='startDate' content='" . date('c', strtotime($item_startdates[$num])) . "'>" . date('l, F jS', strtotime($item_startdates[$num])) . "<br>" . date('g:i a', strtotime($item_startdates[$num])) . " - " . date('g:i a', strtotime($item_enddates[$num])) . "</div>");
								else :
									echo("<div><meta itemprop='startDate' content='" . date('c', strtotime($item_startdates[$num])) . "'>" . date('l, F jS, g:i a', strtotime($item_startdates[$num])) . " -</div><div><meta itemprop='endDate' content='" . date('c', strtotime($item_enddates[$num])) . "'>" . date('l, F jS, g:i a', strtotime($item_enddates[$num])) . "</div>");
								endif;
						endif;
						echo("</div></li>");
					endif;
				 endforeach; ?>

			
      <?php echo "</ol>"; ?>
      <?php echo("<ul class='jspdx-tmm-events-legend'><li class='jspdx-tmm-events-thumbs-up'>Denotes Editors' Choice:</li><li class='jspdx-tmm-events-free'>Denotes Free Registration:</li><li class='jspdx-tmm-events-fire'>Denotes HOT!:<br>(Editor&#146;s Choice &#38; Free Resistration</li></ol>"); ?>
      <?php echo('<p class="jspdx-tmm-events-consider">&#42;To be considered for the National Marketing Events List or Portland Top 10 Marketing Events list please submit your event to <a href="mailto:events@tmmpdx.com">events@tmmpdx.com</a>.</p>'); ?>
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['title_link'] = $new_instance['title_link'];
		if (empty($new_instance['item' . $new_instance['new_amount']])){
			$instance['amount'] = $new_instance['amount'];
		}else{
			$instance['amount'] = $new_instance['new_amount'];
		}
		$j=0; //index to skip over blank items
		for ($i = 1; $i <= $instance['amount']; $i++) {
			if(empty($new_instance['item' . $i])){ $j++; }
			$instance['item' . $i] = strip_tags($new_instance['item' . ($j+$i)]);
			$instance['item_link' . $i] = $new_instance['item_link' . ($j+$i)];
			$instance['item_desc' . $i] = $new_instance['item_desc' . ($j+$i)];
			$instance['item_startdate' . $i] = $new_instance['item_startdate' . ($j+$i)];
			$instance['item_enddate' . $i] = $new_instance['item_enddate' . ($j+$i)];
			$instance['item_class' . $i] = $new_instance['item_class' . ($j+$i)];
			$instance['item_target' . $i] = $new_instance['item_target' . ($j+$i)];
		}
		$instance['amount'] = $instance['amount'] - $j;	
		$instance['type'] = $new_instance['type'];
		
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'title_link' => '' ) );
		$title = strip_tags($instance['title']);
		$amount = empty($instance['amount']) ? 3 : $instance['amount'];
		$new_amount = $amount + 1;
		for ($i = 1; $i <= $amount; $i++) {
			$items[$i] = $instance['item' . $i];
			$item_links[$i] = $instance['item_link' . $i];
			$item_descs[$i] = $instance['item_desc' . $i];
			$item_startdates[$i] = $instance['item_startdate' . $i];
			$item_enddates[$i] = $instance['item_enddate' . $i];
			$item_classes[$i] = $instance['item_class' . $i];
			$item_targets[$i] = $instance['item_target' . $i];
		}
		$title_link = $instance['title_link'];		
		$text = format_to_edit($instance['text']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		<p><small>Leave the Link, End Date, and Custom Style Class fields blank if not desired. Click Save for additional blank fields. To remove an item simply delete the "Event Title:" field content.</small></p>
		<ol class="jspdx-tmm-events-admin-form">
		<?php foreach ($items as $num => $item) : ?>
		
			<li>
				<label for="<?php echo $this->get_field_id('item' . $num); ?>">Event Title:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('item' . $num); ?>" name="<?php echo $this->get_field_name('item' . $num); ?>" type="text" value="<?php echo esc_attr($item); ?>" />

				<label for="<?php echo $this->get_field_id('item_link' . $num); ?>">Link:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('item_link' . $num); ?>" name="<?php echo $this->get_field_name('item_link' . $num); ?>" type="text" value="<?php echo esc_attr($item_links[$num]); ?>" />

				<label for="<?php echo $this->get_field_id('item_desc' . $num); ?>">Event Description/Sub-Head:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('item_desc' . $num); ?>" name="<?php echo $this->get_field_name('item_desc' . $num); ?>" type="text" value="<?php echo esc_attr($item_descs[$num]); ?>" />

				<label for="<?php echo $this->get_field_id('item_startdate' . $num); ?>">Event Start Date:</label>
				<input class="widefat jspdx-tmm-events-dp" id="<?php echo $this->get_field_id('item_startdate' . $num); ?>" name="<?php echo $this->get_field_name('item_startdate' . $num); ?>" type="text" value="<?php echo esc_attr($item_startdates[$num]); ?>" />
				<label for="<?php echo $this->get_field_id('item_enddate' . $num); ?>">Event End Date:</label>
				<input class="widefat jspdx-tmm-events-dp" id="<?php echo $this->get_field_id('item_enddate' . $num); ?>" name="<?php echo $this->get_field_name('item_enddate' . $num); ?>" type="text" value="<?php echo esc_attr($item_enddates[$num]); ?>" />


				<label for="<?php echo $this->get_field_id('item_class' . $num); ?>">Custom Style Class:</label>

				<!-- RADIO BUTTONS FOR CLASS -->
				<label for="<?php echo $this->get_field_id('item_class' . $num); ?>"><input type="radio" id="<?php echo $this->get_field_id('item_class' . $num); ?>" name="<?php echo $this->get_field_name('item_class' . $num); ?>" value="" <?php checked($item_classes[$num], ''); ?> /> None</label>
				<label for="<?php echo $this->get_field_id('item_class' . $num); ?>"><input type="radio" id="<?php echo $this->get_field_id('item_class' . $num); ?>" name="<?php echo $this->get_field_name('item_class' . $num); ?>" value="jspdx-tmm-events-thumbs-up" <?php checked($item_classes[$num], 'jspdx-tmm-events-thumbs-up'); ?> /> Edit's Choice</label>
				<label for="<?php echo $this->get_field_id('item_class' . $num); ?>"><input type="radio" id="<?php echo $this->get_field_id('item_class' . $num); ?>" name="<?php echo $this->get_field_name('item_class' . $num); ?>" value="jspdx-tmm-events-free" <?php checked($item_classes[$num], 'jspdx-tmm-events-free'); ?> /> Free</label>
				<label for="<?php echo $this->get_field_id('item_class' . $num); ?>"><input type="radio" id="<?php echo $this->get_field_id('item_class' . $num); ?>" name="<?php echo $this->get_field_name('item_class' . $num); ?>" value="jspdx-tmm-events-fire" <?php checked($item_classes[$num], 'jspdx-tmm-events-fire'); ?> /> HOT!</label>
				<!-- RADIO BUTTONS FOR CLASS -->

				<label for="<?php echo $this->get_field_id('item_target' . $num); ?>"><input type="checkbox" name="<?php echo $this->get_field_name('item_target' . $num); ?>" id="<?php echo $this->get_field_id('item_target' . $num); ?>" <?php checked($item_targets[$num], 'on'); ?> /> Open in new window</label>
			</li>
		<?php endforeach; ?>
		
		<?php //Additional form fields to add one more item ?>
		
			<li>
				<label for="<?php echo $this->get_field_id('item' . $new_amount); ?>">Event Title:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('item' . $new_amount); ?>" name="<?php echo $this->get_field_name('item' . $new_amount); ?>" type="text" value="" />

				<label for="<?php echo $this->get_field_id('item_link' . $new_amount); ?>">Link:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('item_link' . $new_amount); ?>" name="<?php echo $this->get_field_name('item_link' . $new_amount); ?>" type="text" value="" />
				
				<label for="<?php echo $this->get_field_id('item_desc' . $new_amount); ?>">Event Description/Sub-Head:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('item_desc' . $new_amount); ?>" name="<?php echo $this->get_field_name('item_desc' . $new_amount); ?>" type="text" value="" />

				<label for="<?php echo $this->get_field_id('item_startdate' . $new_amount); ?>">Event Start Date:</label>
				<input class="widefat jspdx-tmm-events-dp" id="<?php echo $this->get_field_id('item_startdate' . $new_amount); ?>" name="<?php echo $this->get_field_name('item_startdate' . $new_amount); ?>" type="text" value="" />
				<label for="<?php echo $this->get_field_id('item_enddate' . $new_amount); ?>">Event End Date:</label>
				<input class="widefat jspdx-tmm-events-dp" id="<?php echo $this->get_field_id('item_enddate' . $new_amount); ?>" name="<?php echo $this->get_field_name('item_enddate' . $new_amount); ?>" type="text" value="" />


				<label for="<?php echo $this->get_field_id('item_class' . $new_amount); ?>">Custom Style Class:</label>

				<!-- RADIO BUTTONS FOR CLASS -->
				<label for="<?php echo $this->get_field_id('item_class' . $new_amount); ?>"><input type="radio" id="<?php echo $this->get_field_id('item_class' . $new_amount); ?>" name="<?php echo $this->get_field_name('item_class' . $new_amount); ?>" value="" <?php checked($item_classes[$new_amount], ''); ?> /> None</label>
				<label for="<?php echo $this->get_field_id('item_class' . $new_amount); ?>"><input type="radio" id="<?php echo $this->get_field_id('item_class' . $new_amount); ?>" name="<?php echo $this->get_field_name('item_class' . $new_amount); ?>" value="jspdx-tmm-events-thumbs-up" <?php checked($item_classes[$new_amount], 'jspdx-tmm-events-thumbs-up'); ?> /> Editors' Choice</label>
				<label for="<?php echo $this->get_field_id('item_class' . $new_amount); ?>"><input type="radio" id="<?php echo $this->get_field_id('item_class' . $new_amount); ?>" name="<?php echo $this->get_field_name('item_class' . $new_amount); ?>" value="jspdx-tmm-events-free" <?php checked($item_classes[$new_amount], 'jspdx-tmm-events-free'); ?> /> Free</label>
				<label for="<?php echo $this->get_field_id('item_class' . $new_amount); ?>"><input type="radio" id="<?php echo $this->get_field_id('item_class' . $new_amount); ?>" name="<?php echo $this->get_field_name('item_class' . $new_amount); ?>" value="jspdx-tmm-events-fire" <?php checked($item_classes[$new_amount], 'jspdx-tmm-events-fire'); ?> /> HOT!</label>
				<!-- RADIO BUTTONS FOR CLASS -->

				

                <label for="<?php echo $this->get_field_id('item_target' . $new_amount); ?>"><input type="checkbox" name="<?php echo $this->get_field_name('item_target' . $new_amount); ?>" id="<?php echo $this->get_field_id('item_target' . $new_amount); ?>" />  Open in new window</label>
			</li>
		</ol>
		<input type="hidden" id="<?php echo $this->get_field_id('amount'); ?>" name="<?php echo $this->get_field_name('amount'); ?>" value="<?php echo $amount ?>" />
		<input type="hidden" id="<?php echo $this->get_field_id('new_amount'); ?>" name="<?php echo $this->get_field_name('new_amount'); ?>" value="<?php echo $new_amount ?>" />

		<script type="text/javascript">
			jQuery(document).ready(function( $ ) {
    
			    /* Backend Scripts */
					$('.jspdx-tmm-events-dp').datetimepicker({
						controlType: 'select',
						timeFormat: 'hh:mm tt'
					});
			});
		</script>

<?php
	}
}

add_action('widgets_init', create_function('', 'return register_widget("JSPDXTMMEventsWidget");'));

?>