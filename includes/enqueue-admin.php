<?php 

	/*
	=======================================================
		ADMIN ENQUEUE FUNCTION
	=======================================================
	*/


	function npfw_load_admin_scripts($hook){
		global $admin_page_hooks;
	
		wp_enqueue_style('admin_css', plugins_url( '../assets_file/css/admin_style.css', __FILE__ ));
		wp_enqueue_media();
		wp_enqueue_script( 'admin_media', plugins_url( '../assets_file/js/admin_custom.js', __FILE__ ));
	 
	}
	add_action( 'admin_head', 'npfw_load_admin_scripts' );
 ?>
