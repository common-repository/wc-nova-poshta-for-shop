<?php
/**
 * @package Shipping of Nova Poshta for WooCommerce
 * @version 1.1.4
 */
/*
Plugin Name: Shipping of Nova Poshta for WooCommerce
Plugin URI: 
Description: Підключення служби доставки Нова Пошта до вашого магазину (WooCommerce)
Author: Andriy Prots
Version: 1.1.4
Text Domain: npfw
Domain Path: /languages
Author URI: https://github.com/ProtSport
*/

if (!defined('ABSPATH')){
	die();
} 

define('NPFW_PLUGIN_URL', plugin_dir_url(__FILE__));


/**
 * Class NovaPoshta
 *
 * @property wpdb db
 * @property NovaPoshtaApi api
 * @property Options options
 * @property Log log
 * @property string pluginVersion
 */




class NPFW_NovaPoshta{

	function __construct(){
		register_activation_hook(NPFW_PLUGIN_URL, array($this, 'activatePlugin'));
		register_deactivation_hook(NPFW_PLUGIN_URL, array($this, 'deactivatePlugin'));

		add_action( 'admin_menu', array($this, 'npfw_register_submenu_page') );
		add_action( 'admin_init', array($this, 'npfw_register_setting') );

		add_action( 'plugins_loaded', array( $this, 'npfw_translation_init' ) );

	}

 
	function activatePlugin(){echo 'The plugins is activated';}

	function unistallPlugin(){}

 	function deactivatePlugin(){}


	function npfw_translation_init() {
		$locale = is_admin() ? get_user_locale() : get_locale();
		load_textdomain( 'npfw', __DIR__ . '/languages/'.$locale . '.mo' );
	    load_plugin_textdomain( 'npfw', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}


	function npfw_register_submenu_page() {
	    add_submenu_page( 
	    	'woocommerce', 
	    	'My Custom Submenu Page', 
	    	__('Setting for NovaPoshta','npfw'), 
	    	'manage_options', 
	    	'npw_submenu-page',
	    	array( $this, 'html' )
	    );    
	}


	function npfw_register_setting() {
		register_setting( 'npw_submenu-page', 'npfw_my_option_name' ); 
		add_settings_section( 'section_id', '', '', 'npw_submenu-page' );
     
	}


	// public static 
	public function html(){
	    echo NPFW_View::npfw_render('settings');
	}

}


if(class_exists('NPFW_NovaPoshta')){
	$nova_poshta = new NPFW_NovaPoshta();
}


include __DIR__ .'/Classes/Parser.php';
include __DIR__ .'/Classes/View.php';
include __DIR__ .'/Classes/API.php';
include __DIR__ .'/Classes/NovaPoshtaAdapter.php';
include __DIR__ .'/Classes/CheckoutField.php';
include __DIR__ .'/Classes/Shortcode.php';
include __DIR__ .'/Classes/DeliveryMethod.php';

require_once('includes/enqueue-admin.php');
require_once('includes/enqueue-front.php');