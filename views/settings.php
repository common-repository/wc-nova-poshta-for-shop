<div class="">
 	<h1><?php _e('Setting for Nova Poshta','npfw') ?></h1>
 	<form method='post' action='options.php'>
 		<div class="tab_button">
 			<?php _e('Main settings', 'npfw'); ?>
 		</div>
 		<?php 

		settings_fields( 'npw_submenu-page' ); 
 	    do_settings_sections(  'npw_submenu-page' );
        
		$options = get_option( 'npfw_my_option_name' );
		$class_warehouses_select	= !(empty($options['class_warehouses_select'])) ? $options['class_warehouses_select'] : '';
		$class_warehouses_wrapper 	= !(empty($options['class_warehouses_wrapper'])) ? $options['class_warehouses_wrapper'] : '';
		$warehouses_send 			= !(empty($options['warehouses_send'])) ? $options['warehouses_send'] : '';
		$city_send 					= !(empty($options['city_send'])) ? $options['city_send'] : '';
		$region_send 				= !(empty($options['region_send'])) ? $options['region_send'] : '';
        $city_sender                = !(empty($options['city_sender'])) ? $options['city_sender'] : '';
        $api_key                    = !(empty($options['api_key'])) ? $options['api_key'] : '';
        $languague                  = !(empty($options['languague'])) ? $options['languague'] : '';
        $output_fields              = !(empty($options['output_fields'])) ? $options['output_fields'] : '';

     
		?>
		<div class="item_form_np">
			<label style="width: 220px; display: inline-block;"><?php _e('Api key','npfw'); ?></label>
			<input style="width: 260px;" type='text' name='npfw_my_option_name[api_key]' value='<?php echo $api_key; ?>'>
		</div>
 		
 		<div class="item_form_np">
 			<label style="width: 220px; display: inline-block;"><?php _e('Select languague','npfw'); ?></label>
 			<input type="radio" name="npfw_my_option_name[languague]" value="Ua" <?php checked('Ua', $languague); ?>>Ukraine
 			<input type="radio" name="npfw_my_option_name[languague]" value="Ru" <?php checked('Ru', $languague); ?>>Russian
 		</div>
 		<div class="item_form_np">
 			<label style="width: 220px; display: inline-block;"><?php _e('Output fields','npfw'); ?></label>
 			<input type="radio" name="npfw_my_option_name[output_fields]" value="output_fields1" <?php checked('output_fields1', $output_fields); ?>>Standart (Woocommerce)
 			<input type="radio" name="npfw_my_option_name[output_fields]" value="output_fields2" <?php checked('output_fields2', $output_fields); ?>>Custom fields
 			<input type="radio" name="npfw_my_option_name[output_fields]" value="output_fields3" <?php checked('output_fields3', $output_fields); ?>>Shortcode
 		</div>

 		<div class="item_form_np">
 			<label style="width: 220px; display: inline-block;"><?php _e('Enable loader','npfw'); ?></label>
 			<input type="checkbox" name="npfw_my_option_name[enable_loader]" value="1" <?php echo !empty($options['enable_loader']) ? 'checked' : ''; ?>>
 		</div>

        <?/*<div class="item_form_np">
            <label style="width: 220px; display: inline-block;"><?php _e('City Sender ','npfw'); ?></label>
            <input type="text" name="my_option_name[city_sender]" value='<?php echo $class_warehouses_select; ?>'>
        </div>*/?>

 		<div class="item_form_np">
 			<label style="width: 220px; display: inline-block;"><?php _e('Add html class to select warhouse','npfw'); ?></label>
 			<input style="width: 260px;" type='text' name='npfw_my_option_name[class_warehouses_select]' value='<?php echo $city_sender; ?>'>
 		</div>
 		<?/* <div class="item_form_np">
 			<label style="width: 220px; display: inline-block;"><?php _e('Add html class to wrapper select warhouse','npfw'); ?></label>
 			<input style="width: 260px;" type='text' name='my_option_name[class_warehouses_wrapper]' value='<?php echo $class_warehouses_wrapper ?>'>
 		</div>
        */?>

        <div class="item_form_np name_shortcode">
            <label style="width: 220px; display: inline-block;"><?php _e('Shortcode','npfw'); ?>:</label>
            <span class="name_shortcode">['npfw_shortcode']</span>
        </div>

        
 		<?php submit_button('Save settings', 'primary','btnSubmit'); ?>
 	</form>
</div>

