<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * Courier Shipping Method
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {


    add_filter( 'woocommerce_shipping_methods', 'add_rsshop_shipping_method' );
    function add_rsshop_shipping_method( $methods ) {
        // $method contains available shipping methods
        $methods[ 'novaposhta' ] = 'WC_NovaPoshta_Shipping_Method';
        return $methods;
    }



    function rsshop_shipping_method_novaposhta() {
        if ( ! class_exists( 'NovaPoshta_Shipping_Method' ) ) {
            class WC_NovaPoshta_Shipping_Method extends WC_Shipping_Method {
                /**
                 * Constructor. The instance ID is passed to this.
                 */
                public function __construct( $instance_id = 0 ) {
                    $this->id                    = 'novaposhta';
                    $this->instance_id           = absint( $instance_id );
                    $this->method_title          = __( 'Доставка новою поштою', 'npfw' );
                    $this->method_description    = __( 'Метод доставка новою поштою', 'npfw' );
                    $this->supports              = array(
                        'shipping-zones',
                        'instance-settings',
                    );
                    $this->instance_form_fields = array(
                        'enabled' => array(
                            'title'         => __( 'Enable/Disable' ),
                            'type'             => 'checkbox',
                            'label'         => __( 'Увімкніть цей спосіб доставки' ),
                            'default'         => 'yes',
                        ),
                        'title' => array(
                            'title'         => __( 'Method Title' ),
                            'type'             => 'text',
                            'description'     => __( 'Це керує заголовком, який бачить користувач під час оформлення замовлення' ),
                            'default'        => __( 'Доставка новою поштою' ),
                            'desc_tip'        => true
                        )
                    );
                    $this->enabled              = $this->get_option( 'enabled' );
                    $this->title                = $this->get_option( 'title' );
                    add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
                }
                

                public function calculate_shipping( $package = array() ) {
                    $this->add_rate( array(
                        'id'    => $this->id . $this->instance_id,
                        'label' => $this->title,
                        'cost'  => 0,
                    ) );
                 }
            }
        }
    }

    add_action( 'woocommerce_shipping_init', 'rsshop_shipping_method_novaposhta' );

}



