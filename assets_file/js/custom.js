jQuery(document).ready(function(){
    // ajax get city

    function npfw_keyup_delay(callback, ms) {
      var timer = 0;
      return function() {

        var billing_city = jQuery(this).val();
        jQuery('#billing_city').removeClass('is-selected');

        if(billing_city.length > 2){
            if(jQuery('#billing_warehouses').hasClass('is-loader')){
                // console.log('zaq');
                jQuery('#billing_city_field').addClass('is-loader');
            }
             // console.log('zaq!QQQ');
 
            jQuery.ajax({
                url:myajax.url,
                data: {
                    'action' : 'get_billing_city',
                    'city' : billing_city
                },
                type:'POST',
                success:function(data){
                    var result_data = JSON.parse(data);
                    var languague_city = result_data.languague;
                    if(result_data.success == true){
                        if(jQuery('#billing_warehouses').hasClass('is-loader')){
                            jQuery('#billing_city_field').removeClass('is-loader');
                        }
                        
                        var array_Settlements = [];
                        if(languague_city == 'Ru'){
                            jQuery.each(result_data.data, function (i, item) {
                                array_Settlements += '<span data-ref="'+item.Ref+'">'+item.DescriptionRu+'</span>';
                            });
                        }
                        else{
                            jQuery.each(result_data.data, function (i, item) {
                                array_Settlements += '<span data-ref="'+item.Ref+'">'+item.Description+'</span>';
                            });
                        }
                        jQuery(document).find('.wrapper_city_np').remove();
                        jQuery('#billing_city').closest('p').append('<div class="wrapper_city_np">'+array_Settlements+'</div>');
                            
                    }
                    else if(result_data.success == false){
                        
                    }     
                }
            });
        }

      };
    }

    jQuery('#billing_city').keyup(npfw_keyup_delay(function (e) {
    }, 500));



    jQuery(document).on('click',function (e) {
        var $target = jQuery(event.target);
        if(!$target.closest('#billing_city_field').length && jQuery('#billing_city_field').is(":visible")) {
            jQuery('.wrapper_city_np').remove();
            if(!jQuery('#billing_city').hasClass('is-selected')){
                jQuery('#billing_city').text('');
                jQuery('#billing_city').val('');
            }
        }
    });

    
    jQuery(document).on('click','.wrapper_city_np span', function() {
        var name_city = jQuery(this).text();
        var ref_city = jQuery(this).attr('data-ref');
        jQuery('#billing_city').val(name_city);
        jQuery('#billing_city').addClass('is-selected');
        jQuery('#billing_city').attr('data-cityref', ref_city);
        jQuery('.wrapper_city_np').remove();
        if(jQuery('#billing_warehouses').hasClass('is-loader')){
            jQuery('#billing_warehouses_field').addClass('is-loader');
        }

        // ajax get warehouses
        var city_ref = jQuery('#billing_city,#billing_np_city').attr('data-cityref');
        jQuery.ajax({
            url:myajax.url,
            data: {
                'action' : 'get_warehouses',
                'city_ref' : city_ref
            },
            type:'POST',
            success:function(data){
                var result_data = JSON.parse(data);
                var languague = result_data.languague;
                if(result_data.success == true){
                    result_data = result_data.data.data;
                    var array_warehouses = [];
                    if(languague == 'Ru'){
                        jQuery.each(result_data, function (i, result_data) {
                            array_warehouses +='<option value="'+result_data.DescriptionRu+'">' + result_data.DescriptionRu+ '</option>';
                        });
                    }
                    else{
                        jQuery.each(result_data, function (i, result_data) {
                            array_warehouses +='<option value="'+result_data.Description+'">' + result_data.Description+ '</option>';
                        });
                    }

                    jQuery('#billing_warehouses').html(array_warehouses);
                    if(jQuery('#billing_warehouses').hasClass('is-loader')){
                        jQuery('#billing_warehouses_field').removeClass('is-loader');
                    }
                    
                    jQuery('.billing_warehouses_sumoselect')[0].sumo.reload();
                    
                   
                }
                else if(result_data.success == false){
                    jQuery('.popup-wrapper, .popup-content[data-rel="1"]').addClass('active');
                    jQuery('html').addClass('overflow-hidden');
                    jQuery('.title_inl').text('Ошибка '+result_data.result_code);
                    jQuery('.desc_inl').text(result_data.result_message);
                }     
            }
        });
    });

    // jQuery(document).on('change','#ship-to-different-address',function() {
    //     var city_ref = jQuery('#billing_city,#billing_np_city').attr('data-cityref');
    //     console.log('test');
    //     jQuery.ajax({
    //         url:myajax.url,
    //         data: {
    //             'action' : 'get_document_price',
    //             'city_ref': city_ref
    //         },
    //         type:'POST',
    //         success:function(data){
    //             var result_data = JSON.parse(data);
    //         }
    //     }); 
    // });


    jQuery('.billing_warehouses_sumoselect').SumoSelect();
});