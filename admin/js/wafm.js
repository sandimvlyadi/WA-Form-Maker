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
                    window.open(response.target, '_blank');
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