jQuery(function($) {
    $(document).ready(function(){
        $('.display-picture').hover(
            function() {
                $('.img-p').fadeTo('fast', 1);
            },
            function() {
                $('.img-p').fadeTo('fast', 0);
            }
        );
    });

    wafm.apiSettings.getRoute = function( path ) {
        var url = wafm.apiSettings.root;

        url = url.replace(
            wafm.apiSettings.namespace,
            wafm.apiSettings.namespace + path );

        return url;
    };

    $('button[name="btn_modal"]').on('click', function(){
        var viewContent = $('input[name="view_content"]').val();
        var addToCart = $('input[name="add_to_cart"]').val();
        var initiateCheckout = $('input[name="initiate_checkout"]').val();
        var purchase = $('input[name="purchase"]').val();

        if (typeof fbq !== 'undefined') {
            if (viewContent == 'yes') {
                var script = $('script[name="view_content"]');
                if (script.length === 0) {
                    var s = $('<script name="view_content" type="text/javascript" src="'+ wafm.fbPixelViewContent +'"></script>');
                    $('.wafm-facebook-pixel').append(s);
                }
            }
            
            if (addToCart == 'yes') {
                var script = $('script[name="add_to_cart"]');
                if (script.length === 0) {
                    var s = $('<script name="add_to_cart" type="text/javascript" src="'+ wafm.fbPixelAddToCart +'"></script>');
                    $('.wafm-facebook-pixel').append(s);
                }
            }

            if (initiateCheckout == 'yes') {
                var script = $('script[name="initiate_checkout"]');
                if (script.length === 0) {
                    var s = $('<script name="initiate_checkout" type="text/javascript" src="'+ wafm.fbPixelInitiateCheckout +'"></script>');
                    $('.wafm-facebook-pixel').append(s);
                }
            }

            if (purchase == 'yes') {
                var script = $('script[name="purchase"]');
                if (script.length === 0) {
                    var s = $('<script name="purchase" type="text/javascript" src="'+ wafm.fbPixelPurchase +'"></script>');
                    $('.wafm-facebook-pixel').append(s);
                }
            }
        }
    });

    $('button[name="btn_send"]').on('click', function(){
        var id = $(this).attr('id');
        $(this).attr('disabled', 'disabled');

        var missing = false;
        $('#wafmData' + id).find('input').each(function(){
            if($(this).prop('required')){
                if($(this).val() == ''){
                    var placeholder = $(this).attr('placeholder');
                    $.notify({
                        icon: 'fa fa-exclamation-triangle',
                        message: placeholder +' could not be empty.'
                    }, {
                        type: 'danger',
                        delay: 2000,
                        timer: 500,
                        z_index: 99999,
                        placement: {
                            from: 'bottom',
                            align: 'center'
                        }
                    });
                    $(this).focus();
                    missing = true;
                    return false;
                }
            }
        });

        $(this).removeAttr('disabled');
        if(missing){
            return;
        }

        $.ajax({
            type: 'POST',
            url : wafm.apiSettings.getRoute( '/wafm/send/' ),
            data: {
                'id': id,
                'form': $('#wafmData' + id).serialize()
            },
            dataType: 'json',
            success: function(response){
                if(response.result){
                    if (response.group_link.length > 0) {
                        window.open(response.group_link, '_blank');
                    } else{
                        window.open(response.target, '_blank');
                    }
                } else{
                    $.notify({
                        icon: "fa fa-exclamation-triangle",
                        message: response.msg
                    }, {
                        type: 'danger',
                        delay: 2000,
                        timer: 500,
                        z_index: 99999,
                        placement: {
                            from: 'bottom',
                            align: 'center'
                        }
                    });
                }
            }
        });
    });
});