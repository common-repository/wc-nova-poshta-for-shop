<?php 

	function npfw_enqueue_scripts() {
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_script( 'npfw_sumoselect', plugins_url( '../assets_file/js/jquery.sumoselect.min.js', __FILE__ ), array('jquery') );
		wp_enqueue_script( 'npfw_post_script', plugins_url( '../assets_file/js/custom.js', __FILE__ ), array('jquery') );

	}
	add_action( 'wp_enqueue_scripts', 'npfw_enqueue_scripts' );

	function npfw_load_plugin_css() {
		wp_enqueue_style( 'npfw_autocomplete_css', plugins_url( '../assets_file/css/jquery-ui.min.css', __FILE__ ));
		wp_enqueue_style( 'npfw_sumoselect_css', plugins_url( '../assets_file/css/sumoselect.min.css', __FILE__ ));
		wp_enqueue_style( 'npfw_style', plugins_url( '../assets_file/css/style.css', __FILE__ ));
	}
	add_action( 'wp_enqueue_scripts', 'npfw_load_plugin_css' );



	add_action( 'wp_enqueue_scripts', 'npfw_myajax_data', 99 );
	function npfw_myajax_data(){
			wp_localize_script( 'npfw_post_script', 'myajax', 
				array(
					'url' => admin_url('admin-ajax.php'),
					'nonce' => wp_create_nonce('plb-nonce')
				)
			);  
	}





	
	

?>