<?php 

class NPFW_NovaPoshtaAdapter{

    public $server_url;
    public $Language;
    
    
    public function __construct() {
        // $this->$options         = get_option( 'my_option_name' );
        $this->server_url       = 'https://api.novaposhta.ua/v2.0/json/';
        $this->Parser           = new NPFW_Parser();
        $this->Language         = get_option('languague');
        $this->apiKey           = get_option('api_key');


        // ajax
        add_action( 'wp_ajax_get_billing_city', array( $this, 'npfw_search_settlements' ) );
        add_action( 'wp_ajax_nopriv_get_billing_city', array( $this, 'npfw_search_settlements' ) );

        add_action( 'wp_ajax_get_warehouses', array( $this, 'npfw_getWarehouses' ) );
        add_action( 'wp_ajax_nopriv_get_warehouses', array( $this, 'npfw_getWarehouses' ) );

        add_action( 'wp_ajax_get_document_price', array( $this, 'npfw_getDocumentPrice' ) );
        add_action( 'wp_ajax_nopriv_get_document_price', array( $this, 'npfw_getDocumentPrice' ) );
    }


    // /* ==========================================
    //     Ajax, online search in the directory of settlements
    // ========================================== */
    public function npfw_search_settlements(){
        
        $billing_city = !empty($_POST['city']) ? sanitize_text_field($_POST['city']) : '';
        $data = array(
            'body' => array(
                'apiKey' => $this->apiKey,
                'modelName' => 'Address',
                'calledMethod' => 'getCities',
                'methodProperties' => array(
                    'FindByString' => $billing_city,
                    'Limit' => 5,
                ) 
            )
        );

        $args = array(
            'headers' => array(
                'Content-Type' => 'application/json'
            ),
            'body' => json_encode( $data['body'] )
        );
        $result = wp_remote_post( $this->server_url, $args );
       

        if(!empty($result['body'])){
        	$resultParse = $this->Parser->npfw_parseJSON($result['body']);

	        $options = get_option( 'npfw_my_option_name' );
            $languague     = !empty($options['languague']) ? $options['languague'] : '';
            $enable_loader = !empty($options['enable_loader']) ? 'is-laoder' : '';
	        echo json_encode(array( 'success' => true, 'data' => $resultParse->data, 'enable_loader' => $enable_loader, 'languague' => $this->Language));
        }
        else{
        	echo json_encode(array( 'success' => false));
        }
        
        die();
    }


    // /* ==========================================
    //     Ajax get warehouses
    // ========================================== */
    public function npfw_getWarehouses(){
        $CityRef = !empty($_POST['city_ref']) ? sanitize_text_field($_POST['city_ref']) : '';

        $data = array(
            'body' => array(
                'modelName' => 'AddressGeneral',
                'calledMethod' => 'getWarehouses',

                'methodProperties' => array(
                    'CityRef' => $CityRef,
                    'Language' => $this->Language,
                )
            )
        );

        $args = array(
            'headers' => array(
                'Content-Type' => 'application/json'
            ),
            'body' => json_encode( $data['body'] )
        );
        $result = wp_remote_post( $this->server_url, $args );

        if(!empty($result['body'])){
        	$resultParse = $this->Parser->npfw_parseJSON($result['body']);    
            $languague   = !empty($this->Language) ? $this->Language : '';
        	echo json_encode(array( 'success' => true, 'data' => $resultParse, 'languague' => $this->Language ));
        }
        else{
        	echo json_encode(array( 'success' => false));
        }
        
        die();
    }



    // /* ==========================================
    //     Ajax get warehouses
    // ========================================== */
    public function npfw_getDocumentPrice(){
        $city_recipient = !empty($_POST['city_ref']) ? $_POST['city_ref'] : '';
        global $woocommerce;
        $items = $woocommerce->cart->get_cart();
        $weight = $length = $width = $height = 0;
        $max_height = 0;
        $max_width = 0;
        foreach($items as $key => $item) {
            $weight     += get_post_meta($item['product_id'], '_weight', true);
            $length     += get_post_meta($item['product_id'], '_length', true);
            $width      = get_post_meta($item['product_id'], '_width', true);
            $height     = get_post_meta($item['product_id'], '_height', true);
            if($width > $max_width){
                $max_width = $width;
            }
            if($height > $max_height){
                $max_height = $height;
            }
        }


        $data = array(
            'body' => array(
                'apiKey' => $this->apiKey, 
                'modelName' => 'InternetDocument',
                'calledMethod' => 'getDocumentPrice',
                'methodProperties' => array(
                    'CitySender' => 'db5c88ac-391c-11dd-90d9-001a92567626',
                    'CityRecipient' => $city_recipient,
                    'ServiceType' => 'WarehouseWarehouse',
                    'Weight' => $weight,
                    'volumetricLength' => $length,
                    'volumetricWidth' => $max_width,
                    'volumetricHeight' => $max_height,
                    'Cost' => '100',
                    'CargoType' => 'Cargo',
                    'SeatsAmount' => '10'
                )
            )
        );
        $args = array(
            'headers' => array(
                'Content-Type' => 'application/json'
            ),
            'body' => json_encode( $data['body'] )
        );


        $result = wp_remote_post( $this->server_url, $args );
        file_put_contents(__DIR__.'/A_1.txt', print_r([$items, $result], true));
        if(!empty($result['body'])){
            $resultParse = $this->Parser->npfw_parseJSON($result['body']);     
            echo json_encode(array( 'success' => true, 'data' => $resultParse ));
        }
        else{
            echo json_encode(array( 'success' => false));
        }
        die();
    }
}


if(class_exists('NPFW_NovaPoshtaAdapter')){
    new NPFW_NovaPoshtaAdapter();
}