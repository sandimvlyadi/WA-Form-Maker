jQuery(function($) {
	var baseurl = wafm.siteurl;

	wafm.apiSettings.getRoute = function( path ) {
		var url = wafm.apiSettings.root;

		url = url.replace(
			wafm.apiSettings.namespace,
			wafm.apiSettings.namespace + path );

		return url;
	};

	$('button[name="btn_save"]').on('click', function(){
		$.ajax({
	        type: 'POST',
	        url	: wafm.apiSettings.getRoute( '/wafm_facebook_pixel/save' ),
	        data: {
	        	'view_content': $('input[name="view_content"]:checked').val() == 'on' ? 'yes' : 'no',
	        	'add_to_cart': $('input[name="add_to_cart"]:checked').val() == 'on' ? 'yes' : 'no',
	        	'initiate_checkout': $('input[name="initiate_checkout"]:checked').val() == 'on' ? 'yes' : 'no',
	        	'purchase': $('input[name="purchase"]:checked').val() == 'on' ? 'yes' : 'no'
	        },
	        dataType: 'json',
	        success: function(response){
	            if(response.result){
	            	$.notify({
	                    icon: "fa fa-check",
	                    message: response.msg
	                }, {
	                    type: 'success',
	                    delay: 2000,
	                    timer: 500,
	                    z_index: 99999,
	                    placement: {
	                        from: 'bottom',
	                        align: 'right'
	                    }
	                });
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
	                        align: 'right'
	                    }
	                });
	            }
	        }
	    });
	});

});