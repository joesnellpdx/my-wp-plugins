<?php

/**
 * Core
 **/

class JSPDXTMMEventsWidget extends WP_Widget {

	function JSPDXTMMEventsWidget() {
		$widget_ops = array('classname' => 'jspdx-tmm-events', 'description' => __('A list of TMM Events'));
		$this->WP_Widget('list', __('TMM Events'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? __('List') : $instance['title']);
		$type = empty($instance['type']) ? 'unordered' : $instance['type'] ;
		$amount = empty($instance['amount']) ? 3 : $instance['amount'];
		
		for ($i = 1; $i <= $amount; $i++) {
			$items[$i] = $instance['item' . $i];
			$item_links[$i] = $instance['item_link' . $i];
			$item_classes[$i] = isset($instance['item_class' . $i]) ? $instance['item_class' . $i] : '';

			// $item_classes[$i] = $instance['item_class' . $i];
			$item_targets[$i] = isset($instance['item_target' . $i]) ? $instance['item_target' . $i] : false;
		}

		echo $before_widget .  $before_title . $title . $after_title;  ?>
			<?php if ($type == "ordered") { echo "<ol class='jspdx-tmm-events-ol' ";} else { echo("<ul class='jspdx-tmm-events-ol' "); } ?> class="list">
				
				<?php foreach ($items as $num => $item) : 
					if (!empty($item)) :
						if (empty($item_links[$num])) :
							echo("<li class='jspdx-tmm-events-li'><span class='" . $item_classes[$num] . "'>" . $item . "</span></li>");
						else :
							if($item_targets[$num]) :
								echo("<li class='jspdx-tmm-events-li'><a href='" . $item_links[$num] . "' target='_blank' class='" . $item_classes[$num] . "'>" . $item . "</a></li>");
							else :
								echo("<li class='jspdx-tmm-events-li'><a href='" . $item_links[$num] . "'' class='" . $item_classes[$num] . "'>" . $item . "</a></li>");
							endif;
						endif;
					endif;
				 endforeach; ?>
      <?php if ($type == "ordered") { echo "</ol>";} else { echo("</ul>"); } ?>
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
			$item_classes[$i] = $instance['item_class' . $i];
			$item_targets[$i] = $instance['item_target' . $i];
		}
		$title_link = $instance['title_link'];		
		$type = empty($instance['type']) ? 'unordered' : $instance['type'] ;
		$text = format_to_edit($instance['text']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		<p><small>Leave the Link and Custom Style Class fields blank if not desired. Click Save for additional blank fields. To remove an item simply delete the "Text:" field content.</small></p>
		<ol>
		<?php foreach ($items as $num => $item) : ?>
		
			<li>
				<label for="<?php echo $this->get_field_id('item' . $num); ?>">Text:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('item' . $num); ?>" name="<?php echo $this->get_field_name('item' . $num); ?>" type="text" value="<?php echo esc_attr($item); ?>" />
				<label for="<?php echo $this->get_field_id('item_link' . $num); ?>">Link:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('item_link' . $num); ?>" name="<?php echo $this->get_field_name('item_link' . $num); ?>" type="text" value="<?php echo esc_attr($item_links[$num]); ?>" />
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
				<label for="<?php echo $this->get_field_id('item' . $new_amount); ?>">Text:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('item' . $new_amount); ?>" name="<?php echo $this->get_field_name('item' . $new_amount); ?>" type="text" value="" />
				<label for="<?php echo $this->get_field_id('item_link' . $new_amount); ?>">Link:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('item_link' . $new_amount); ?>" name="<?php echo $this->get_field_name('item_link' . $new_amount); ?>" type="text" value="" />
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

		<label for="<?php echo $this->get_field_id('ordered'); ?>"><input type="radio" name="<?php echo $this->get_field_name('type'); ?>" value="ordered" id="<?php echo $this->get_field_id('ordered'); ?>" <?php checked($type, "ordered"); ?> />  Ordered</label>
		<label for="<?php echo $this->get_field_id('unordered'); ?>"><input type="radio" name="<?php echo $this->get_field_name('type'); ?>" value="unordered" id="<?php echo $this->get_field_id('unordered'); ?>" <?php checked($type, "unordered"); ?> /> Unordered</label>

<?php
	}
}

add_action('widgets_init', create_function('', 'return register_widget("JSPDXTMMEventsWidget");'));

?>