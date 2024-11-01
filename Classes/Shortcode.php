<?php 


class NPFW_Shortcode {


    function npfw_shortcode_output($html_field) {
        $options = get_option( 'npfw_my_option_name' );
        $class_warehouses_select = !empty($options['class_warehouses_select']) ? $options['class_warehouses_select'] : '';
        $html = '';
        if($options['output_fields'] == 'output_fields3'){
            $html .= '<div class="npfw_billing_np_city"><label>'.__('City','npfw').'</labe>
                        <input id="billing_np_city" name="billing_np_city" type="text" placeholder="Please select city">
                    </div>';
            $html .= '<div class="npfw_billing_warehouses" id="billing_warehouses_field">
                        <label>'.__('Warehouses','npfw').'</labe>
                        <select class="'.$class_warehouses_select.'" name="billing_warehouses" id="billing_warehouses"><option>Please select warehouses</option></select>
                    </div>';
        }
        return $html;
    }
}


add_shortcode( 'npfw_shortcode', [ 'NPFW_Shortcode', 'npfw_shortcode_output' ] );

