<?php 

class NPFW_CheckoutFields{

	public function __construct() {
		add_filter( 'woocommerce_checkout_fields' ,  array($this, 'npfw_add_to_wooc_fields') );
	}


	function npfw_add_to_wooc_fields( $fields ) {
		$options = get_option( 'npfw_my_option_name' );
        $enable_loader              = !(empty($options['enable_loader'])) ? 'is-loader' : '';
		$class_warehouses_wrapper   = !empty($options['class_warehouses_wrapper']) ? $options['class_warehouses_wrapper'] : '';
		$class_warehouses_select    = !empty($options['class_warehouses_select']) ? $options['class_warehouses_select'] : '';
		  

        if($options != '1' && !empty(get_option( 'npfw_my_option_name' ))){    
    		if($options['output_fields'] == 'output_fields1'){
    			$fields['billing']['billing_warehouses'] = array(
    		    	'type'      => 'select',
    		    	'options'	=> array(
    					''		=> __('Please select warehouses','npfw')
    				),
    		        'label'     => __('Warehouses', 'npfw'),
    		    	'required'  => true,
    		    	'class'     => array($class_warehouses_wrapper),
    		    	'input_class' => array('billing_warehouses_sumoselect'.' '.$enable_loader.' '. $class_warehouses_select),
    		    	'clear'     => true,
    		    	'priority'  => 75
    		    );
    		}
    		else if($options['output_fields'] == 'output_fields2'){
    			$fields['billing']['billing_np_city'] = array(
    		        'label'     => __('City', 'npfw'),
    		        'placeholder' => __('Please select city', 'npfw'),
    			    'required'  => true,
    			    'class'     => array('form-row-wide'),
    			    'clear'     => true,
    			    'priority'  => 190
    		    );

    		    $fields['billing']['billing_warehouses'] = array(
    		    	'type'      => 'select',
    		    	'placeholder' => __('Please select warehouses', 'npfw'),
    		    	'options'	=> array(
    					''		=> __('Please select warehouses', 'npfw'),
    				),
    		        'label'     => __('Warehouses', 'npfw'),
    		    	'required'  => true,
    		    	'class'     => array($class_warehouses_wrapper),
    		    	'input_class' => array('billing_warehouses_sumoselect'.' '.$enable_loader.' '. $class_warehouses_select),
    		    	'clear'     => true,
    		    	'priority'  => 200
    		    );
    		}
        }

	    
		unset($fields['billing']['billing_postcode']);

	    return $fields;
	}


}


if(class_exists('NPFW_CheckoutFields')){
    new NPFW_CheckoutFields();
}