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
	        	'url'	: wafm.apiSettings.getRoute( '/wafm_follow_up/datatables' ),
	            'type'	: 'GET',
	            'dataSrc' : function(response){
	            	var i = response.start;
	            	var row = new Array();
	            	if (response.result) {
	            		for(var x in response.data){
							var button = '<button id="'+ response.data[x].id +'" name="btn_send" class="btn btn-success btn-sm" title="Follow Up"><i class="fa fa-paper-plane"></i> Follow Up</button> <button id="'+ response.data[x].id +'" name="btn_edit" class="btn btn-info btn-sm" title="Edit" data-toggle="modal" data-target="#btnAddNumberModal"><i class="fa fa-edit"></i></button> <button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash"></i></button>';

		            		row.push({
		            			'no'			: i,
	                            'name'			: response.data[x].name,
	                            'number'		: response.data[x].number,
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
				{ 'data' : 'aksi' }
	        ],

			'columnDefs': [
	    		{
	    			'orderable'	: false,
	    			'targets'	: [ 0, 3 ]
	    		}
	  		]
		});
	});

	$('button[name="btn_add"]').on('click', function(){
		$('button[name="btn_save"]').attr('id', 0);
		$('input[name="name"]').val('');
		$('input[name="number"]').val('');
	});

	$('button[name="btn_import"]').on('click', function(){
		$('input[name="file_import"]').trigger('click');
	});

	$('input[name="file_import"]').on('change', function(){
		if ($(this).val() != '') {
			var fd = $(this).prop('files')[0];
			var fu = new FormData();
			fu.append('file', fd);

			$.ajax({
		        type: 'POST',
		        url: wafm.apiSettings.getRoute( '/wafm_upload/follow_up_import' ),
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
						
						$('input[name="file_import"]').val('');
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
					table.ajax.reload(null, false);
		        }
		    });
		}
	});

	$('#dataTable').on('click', 'button[name="btn_edit"]', function(){
		var id = $(this).attr('id');
		
		$.ajax({
	        type: 'GET',
	        url	: wafm.apiSettings.getRoute( '/wafm_follow_up/edit/' + id ),
	        dataType: 'json',
	        success: function(response){
	            if(response.result){
	            	var data = response.data;
	            	$('button[name="btn_save"]').attr('id', data.id);
	            	$('input[name="name"]').val(data.name);
	            	$('input[name="number"]').val(data.number);
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
	        url	: wafm.apiSettings.getRoute( '/wafm_follow_up/delete/' ),
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
	        url	: wafm.apiSettings.getRoute( '/wafm_follow_up/save' ),
	        data: {
	        	'id': id,
	        	'name': $('input[name="name"]').val(),
	        	'number': $('input[name="number"]').val()
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

	$('#dataTable').on('click', 'button[name="btn_send"]', function(){
		var id = $(this).attr('id');
		
		$.ajax({
	        type: 'POST',
			url	: wafm.apiSettings.getRoute( '/wafm_follow_up/send/' ),
			data: {
				'id': id,
				'message': $('textarea[name="message"]').val()
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
	                        align: 'right'
	                    }
	                });
	            }
	        }
	    });
	});
});