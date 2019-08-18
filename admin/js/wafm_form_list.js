jQuery(function($) {
	var baseurl = wafm.siteurl;
	var table = '';
	var tableDetail = '';
	var selectNumber = '';
	var formId = 0;
	var linkType = 'number';

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
	        	'url'	: wafm.apiSettings.getRoute( '/wafm_form_list/datatables' ),
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
	                        var button = '<button id="'+ response.data[x].id +'" name="btn_detail" class="btn btn-success btn-sm" title="Detail"><i class="fa fa-file-export"></i> Database</button> <button id="'+ response.data[x].id +'" name="btn_edit" class="btn btn-info btn-sm" title="Edit"><i class="fa fa-edit"></i></button> <button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash"></i></button>';

		            		row.push({
		            			'no'			: i,
	                            'name'			: response.data[x].name,
	                            'shortcode'		: response.data[x].shortcode,
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
	            { 'data' : 'shortcode' },
	        	{ 'data' : 'aksi' }
	        ],

			'columnDefs': [
	    		{
	    			'orderable'	: false,
	    			'targets'	: [ 0, 3 ]
	    		}
	  		]
		});

		tableDetail = $('#detailTable').DataTable({
			'processing'	: true,
	        'serverSide'	: true,
	        'lengthChange'	: false,
	        'searching'		: false,

	        'ajax' : {
	        	'url'	: wafm.apiSettings.getRoute( '/wafm_form_list/details' ),
	            'type'	: 'GET',
	            'data'  : function(d){
	                d.formId = formId
	            },
	            'dataSrc' : function(response){
	            	var i = response.start;
	            	var row = new Array();
	            	if (response.result) {
	            		for(var x in response.data){
		            		row.push({
		            			'no'	: i,
	                            'field'	: response.data[x].field,
	                            'value'	: response.data[x].value
		            		});
		            		i = i + 1;
		            	}

		            	$('button[name="btn_export"]').removeAttr('disabled');
		            	response.data = row;
	            		return row;
	            	} else{
	            		$('button[name="btn_export"]').attr('disabled', 'disabled');
	            		response.draw = 0;
	            		return [];
	            	}
	            }
	        },

	        'columns' : [
	        	{ 'data' : 'no' },
	            { 'data' : 'field' },
	            { 'data' : 'value' }
	        ],

			'columnDefs': [
	    		{
	    			'orderable'	: false,
	    			'targets'	: [ 0 ]
	    		}
	  		]
		});

		$.ajax({
	        type: 'GET',
	        url: wafm.apiSettings.getRoute( '/wafm_reception_numbers/select/0' ),
	        dataType: 'json',
	        success: function(response){
	            if(response.result){
	            	$('select[name="id_number"]').append('<option value="0">- Choose Reception Number -</option>');
	                for(var x in response.data){
	                    $('select[name="id_number"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].name +' | '+ response.data[x].number +'</option>');
	                }
	            } else{
	            	$('select[name="id_number"]').append('<option value="0">- Choose Reception Number -</option>');
	            }
	        }
	    });
	    selectNumber = $('select[name="id_number"]').select2();
	});

	$('button[name="btn_add"]').on('click', function(){
		$('button[name="btn_save"]').attr('id', 0);
		$('input[name="title"]').val('');
		$('input[name="group_link"]').val('');
		$('input[name="button_name"]').val('OPEN');
		$('input[name="button_send"]').val('SEND');
		$(selectNumber).val('0').trigger('change');
		$('textarea[name="message"]').val('Howdy, \nI\'m *{{ fa fa-user|field-name : Field Name }}* from *{{ fa fa-user|another-field-name : Another Field Name }}*\n');

		$('.wafm-form-list:eq(0)').fadeOut();
		$('.wafm-form-list:eq(1)').delay(300).fadeIn();
	});

	$('#dataTable').on('click', 'button[name="btn_detail"]', function(){
		formId = $(this).attr('id');
		$('button[name="btn_export"]').attr('id', formId);
		tableDetail.ajax.reload(null, false);

		// $('.wafm-form-list:eq(0)').fadeOut();
		// $('.wafm-form-list:eq(1)').fadeOut();
		// $('.wafm-form-list-detail').delay(300).fadeIn();
	});

	// $('button[name="btn_back"]').on('click', function(){
	// 	$('.wafm-form-list-detail').fadeOut();
	// 	$('.wafm-form-list:eq(1)').fadeOut();
	// 	$('.wafm-form-list:eq(0)').delay(300).fadeIn();
	// })

	$('button[name="btn_export"]').on('click', function(){
		var id = $(this).attr('id');
		window.open( wafm.apiSettings.getRoute( '/wafm_form_list/export/'+id ), '_blank' );

		// $.ajax({
	 //        type: 'POST',
	 //        url	: wafm.apiSettings.getRoute( '/wafm_form_list/export' ),
	 //        data: {
	 //        	'id': id
	 //        },
	 //        dataType: 'json',
	 //        success: function(response){
	 //            if(response.result){
	 //            	console.log(response);
	 //            	alert('tayo');
	 //            } else{
	 //                $.notify({
	 //                    icon: "fa fa-exclamation-triangle",
	 //                    message: response.msg
	 //                }, {
	 //                    type: 'danger',
	 //                    delay: 2000,
	 //                    timer: 500,
	 //                    z_index: 99999,
	 //                    placement: {
	 //                        from: 'bottom',
	 //                        align: 'right'
	 //                    }
	 //                });
	 //            }
	 //        }
	 //    });
	})

	$('#dataTable').on('click', 'button[name="btn_edit"]', function(){
		var id = $(this).attr('id');
		
		$.ajax({
	        type: 'GET',
	        url	: wafm.apiSettings.getRoute( '/wafm_form_list/edit/' + id ),
	        dataType: 'json',
	        success: function(response){
	            if(response.result){
	            	var data = response.data;

	            	$(selectNumber).find('option').each(function(){
	                    if ($(this).val() == data.id_number) {
	                        $(selectNumber).val($(this).val()).trigger('change');
	                    }
	                });

	            	$('button[name="btn_save"]').attr('id', data.id);
	            	$('input[name="title"]').val(data.name);
	            	$('input[name="group_link"]').val(data.group_link);
	            	$('input[name="button_name"]').val(data.button_name);
	            	$('input[name="button_send"]').val(data.button_send);
	            	$('textarea[name="message"]').val(data.message);
					
	                $('.wafm-form-list:eq(0)').fadeOut();
					$('.wafm-form-list:eq(1)').delay(300).fadeIn();
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
	        url	: wafm.apiSettings.getRoute( '/wafm_form_list/delete/' ),
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

	$('button[name="btn_add_field"]').on('click', function(){
		$('button[name="btn_add_field_save"]').removeAttr('data-dismiss');
		$('#formField input[name="field_name"]').val('');
		$('#formField input[name="required"]').prop('checked', false);
		$('#formField input[name="icon"]:eq(0)').prop('checked', true);
	});

	$('button[name="btn_add_select"]').on('click', function(){
		$('button[name="btn_add_select_save"]').removeAttr('data-dismiss');
		$('#formSelect input[name="select_name"]').val('');
		$('#formSelect input[name="select_options"]').val('');
		$('#formSelect input[name="required"]').prop('checked', false);
		$('#formSelect input[name="icon"]:eq(0)').prop('checked', true);
	});

	$('button[name="btn_add_field_save"]').on('click', function(){
		$(this).attr('disabled', 'disabled');
	    var missing = false;
	    $('#formField').find('input, textarea').each(function(){
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

	    $(this).attr('data-dismiss', 'modal');

		var fieldName = 'Field Name';

		if ($('#formField input[name="field_name"]').val() != '') {
			fieldName = $('#formField input[name="field_name"]').val();
		}

		var fn = fieldName.replace(/[^A-Z0-9]+/ig, "-").toLowerCase();
		var icon = $('#formField input[name="icon"]:checked').val();
		var msg = '';
		if ($('#formField input[name="required"]:checked').length > 0) {
			msg = $('textarea[name="message"]').val() + '*{{ ^'+ icon +'|'+ fn +' : '+ fieldName +' }}* \n';
		} else{
			msg = $('textarea[name="message"]').val() + '*{{ '+ icon +'|'+ fn +' : '+ fieldName +' }}* \n';
		}
		$('textarea[name="message"]').val(msg);
	});

	$('button[name="btn_add_select_save"]').on('click', function(){
		$(this).attr('disabled', 'disabled');
	    var missing = false;
	    $('#formSelect').find('input, textarea').each(function(){
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

	    $(this).attr('data-dismiss', 'modal');

		var selectName = 'Select Name';

		if ($('#formSelect input[name="select_name"]').val() != '') {
			selectName = $('#formSelect input[name="select_name"]').val();
		}

		var sn = selectName.replace(/[^A-Z0-9]+/ig, "-").toLowerCase();
		var options = $('#formSelect input[name="select_options"]').val();
		var icon = $('#formSelect input[name="icon"]:checked').val();
		var msg = '';
		if ($('#formSelect input[name="required"]:checked').length > 0) {
			msg = $('textarea[name="message"]').val() + '*[[ ^'+ icon +'|'+ sn +' : '+ selectName +' : '+ options +' ]]* \n';
		} else{
			msg = $('textarea[name="message"]').val() + '*[[ '+ icon +'|'+ sn +' : '+ selectName +' : '+ options +' ]]* \n';
		}
		$('textarea[name="message"]').val(msg);
	});

	$('button[name="btn_cancel"]').on('click', function(){
		$('.wafm-form-list:eq(1)').fadeOut();
		$('.wafm-form-list:eq(0)').delay(300).fadeIn();
	});

	$('button[name="btn_save"]').on('click', function(){
		var title = $('input[name="title"]').val();
		if (title == '') {
			$.notify({
                icon: 'fa fa-exclamation-triangle',
                message: 'Title could not be empty.'
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
            $('input[name="title"]').focus();
            return;
		}

		save($(this));
	});

	function save(btn) {
		var id = btn.attr('id');
		btn.attr('disabled', 'disabled');

		var g = '';
		if (linkType == 'link') {
			g = $('input[name="group_link"]').val();
		}

	    $.ajax({
	        type: 'POST',
	        url	: wafm.apiSettings.getRoute( '/wafm_form_list/save' ),
	        data: {
	        	'id': id,
	        	'title': $('input[name="title"]').val(),
	        	'group_link': g,
	        	'button_name': $('input[name="button_name"]').val(),
	        	'button_send': $('input[name="button_send"]').val(),
	        	'id_number': $('select[name="id_number"]').val(),
	        	'message': $('textarea[name="message"]').val()
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
	                $('.wafm-form-list:eq(1)').fadeOut();
					$('.wafm-form-list:eq(0)').delay(300).fadeIn();
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

	$('input[name="link-type"]').on('click', function(){
		var v = $(this).val();
		linkType = v;
		if (v == 'number') {
			$('.wafm-form-list .form-group:eq(3)').fadeIn();
			$('.wafm-form-list .form-group:eq(4)').fadeOut();
		} else{
			$('.wafm-form-list .form-group:eq(4)').fadeIn();
			$('.wafm-form-list .form-group:eq(3)').fadeOut();
		}
	})
});