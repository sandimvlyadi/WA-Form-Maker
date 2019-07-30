jQuery(function($) {
	var baseurl = wafm.siteurl;
	var table = '';
	var tableDetail = '';
	var displayPicture = '';

	wafm.apiSettings.getRoute = function( path ) {
		var url = wafm.apiSettings.root;

		url = url.replace(
			wafm.apiSettings.namespace,
			wafm.apiSettings.namespace + path );

		return url;
	};

	$(document).ready(function(){
		table = $('#dataTable').DataTable({
			'processing'	: true,
	        'serverSide'	: true,
	        'lengthChange'	: false,
			'searching'		: false,

	        'ajax' : {
	        	'url'	: wafm.apiSettings.getRoute( '/wafm_reception_numbers/datatables' ),
	            'type'	: 'GET',
	            'data'  : function(d){
	                d.search = {
	                	'value': $('input[name="search"]').val(),
	                	'regex': false
	                }
	            },
	            'dataSrc' : function(response){
	            	var i = response.start;
	            	var row = new Array();
	            	if (response.result) {
	            		for(var x in response.data){
	                        var button = '<button id="'+ response.data[x].id +'" name="btn_edit" class="btn btn-info btn-sm" title="Edit" data-toggle="modal" data-target="#btnAddNumberModal"><i class="fa fa-edit"></i></button> <button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash"></i></button>';
	                        var picture = '';
	                        if (response.data[x].picture.length > 0) {
	                        	picture = '<img src="'+ response.data[x].picture +'" class="img-responsive display-picture" style="max-width: 100px;">'
	                        }

		            		row.push({
		            			'no'			: i,
	                            'name'			: response.data[x].name,
	                            'number'		: response.data[x].number,
	                            'picture'		: picture,
		            			'aksi'			: button
		            		});
		            		i = i + 1;
		            	}

		            	response.data = row;
	            		return row;
	            	} else{
	            		response.draw = 0;
	            		return [];
	            	}
	            }
	        },

	        'columns' : [
	        	{ 'data' : 'no' },
	            { 'data' : 'name' },
	            { 'data' : 'number' },
	            { 'data' : 'picture' },
	        	{ 'data' : 'aksi' }
	        ],

			'columnDefs': [
	    		{
	    			'orderable'	: false,
	    			'targets'	: [ 0, 4 ]
	    		}
	  		]
		});
	});

	$('button[name="btn_add"]').on('click', function(){
		$('button[name="btn_save"]').attr('id', 0);
		$('input[name="name"]').val('');
		$('input[name="number"]').val('');
		$('input[name="picture"]').val('');
		displayPicture = '';
		$('img[name="picture"]').attr('src', wafm.imgurl + 'user.png');
	});

	$('img[name="picture"]').on('click', function(){
		$('input[name="picture"]').trigger('click');
	});

	$('input[name="picture"]').on('change', function(){
		if ($(this).val() != '') {
			var fd = $(this).prop('files')[0];
			var fu = new FormData();
			fu.append('file', fd);

			$.ajax({
		        type: 'POST',
		        url: wafm.apiSettings.getRoute( '/wafm_upload/image' ),
		        data: fu,
		        dataType: 'json',
	            contentType: false,
	            processData: false,
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

						var data = response.data;
						$('img[name="picture"]').attr('src', data.url);
						displayPicture = data.url;
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
		}
	});

	$('#dataTable').on('click', 'button[name="btn_edit"]', function(){
		var id = $(this).attr('id');
		
		$.ajax({
	        type: 'GET',
	        url	: wafm.apiSettings.getRoute( '/wafm_reception_numbers/edit/' + id ),
	        dataType: 'json',
	        success: function(response){
	            if(response.result){
	            	var data = response.data;
	            	$('button[name="btn_save"]').attr('id', data.id);
	            	$('input[name="name"]').val(data.name);
	            	$('input[name="number"]').val(data.number);
	            	$('input[name="picture"]').val('');
	            	if (data.picture.length > 0) {
	            		displayPicture = data.picture;
	            		$('img[name="picture"]').attr('src', displayPicture);
	            	} else{
	            		$('img[name="picture"]').attr('src', wafm.imgurl + 'user.png');
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
	                        align: 'right'
	                    }
	                });
	            }
	        }
	    });
	});

	$('#dataTable').on('click', 'button[name="btn_delete"]', function(){
		var id = $(this).attr('id');
		
		if (!confirm('Are you sure?')) {
			return;
		}

		$.ajax({
	        type: 'POST',
	        url	: wafm.apiSettings.getRoute( '/wafm_reception_numbers/delete/' ),
	        data: {
	        	'id': id
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
					
	                table.ajax.reload(null, false);
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

	$('input[name="search"]').on('keyup', function(){
	    table.ajax.reload(null, false);
	});

	$('button[name="btn_save"]').on('click', function(){
		$(this).attr('disabled', 'disabled');
		var missing = false;
	    $('#formData').find('input, textarea').each(function(){
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
	                        align: 'right'
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

		save($(this));
	});

	function save(btn) {
		var id = btn.attr('id');
		btn.attr('disabled', 'disabled');

	    $.ajax({
	        type: 'POST',
	        url	: wafm.apiSettings.getRoute( '/wafm_reception_numbers/save' ),
	        data: {
	        	'id': id,
	        	'name': $('input[name="name"]').val(),
	        	'number': $('input[name="number"]').val(),
	        	'picture': displayPicture
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
					
	                window.location.reload();
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

	            btn.removeAttr('disabled');
	        }
	    });
	}
});