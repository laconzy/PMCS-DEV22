(function(){

	var BASE_URL = null;
	var ID = 0;
	var ITEMS = [];
	let ITEM_ADD_STATUS = null;
	let GP_STATUS = null;

	 $(document).ready(function(){

		BASE_URL = $('#base-url').val();
		ID = $('#id').val();
		GP_STATUS = $('#gp_status').val();

		initialize_form_validator();

		if(ID > 0){
			let gp_type = $('#gp_type').val();
			if(gp_type == 'laysheet transfer'){
				get_laysheets();
			}
			else {
				get_items();
			}
		}

	 });


	$('#btn_save').click(function(){
		//$('#btn-save-i').addClass('fa fa-spinner fa-spin');
		var form_data = $('#data-form').form_validator('validate');
    if(form_data !== false)
    {
			appAjaxRequest({
				url : BASE_URL + 'index.php/gatepass/save_manual_gatepass',
				data : {'form_data' : form_data},
				async : false,
				success : function(_serverResponse){
					var res = JSON.parse(_serverResponse);
					if(res.status == 'success'){
						//$('#id, #no').val(res.gp.id);
						appAlertSuccess(res.message, function(){
							window.open(BASE_URL + 'index.php/gatepass/manual_gatepass_view/' + res.gp.id, '_self')
						});
					}
					else {
						appAlertError(res.message);
					}
				}
			});
		}
	});


	$('#btn_add').click(function(){
		let gp_type = $('#gp_type').val();

		if(gp_type == 'laysheet transfer'){
			ITEM_ADD_STATUS = 'NEW';
			$('#ls_model').modal('show');
		}
		else {
			$('#gp-new-item-title').html('New Item');

			$('#item_id').val(0);
			$('#item_details').val('');
			$('#item_unit').val('');
			$('#item_qty').val('');

			ITEM_ADD_STATUS = 'NEW';
			$('#item_model').modal('show');
		}
	});


	$('#btn_item_add').click(function(){
		var item_data = $('#gp-items-form').form_validator('validate');
    if(item_data !== false)
    {
			item_data['header_id'] = ID;

			appAjaxRequest({
				url : BASE_URL + 'index.php/gatepass/save_manual_gp_item',
				async : false,
				dataType : 'json',
				data : {
					'item' : item_data
				},
				success : function(res){
					if(res.status == 'success'){
						//add_item_to_table(res.item);
						if(ITEM_ADD_STATUS == 'NEW'){
							$('#gp-new-item-title').html('New Item');
							$('#item_id').val(0);
							$('#item_details').val('');
							$('#item_unit').val('');
							$('#item_qty').val('');
						}

						ITEMS = res.items;
						load_items(res.items);
					}
					else {
						appAlertError(res.message);
					}
				},
				error : function(err){
					console.log(err);
					appAlertError('Error occured in saveing gatepass item');
				}
			});
		}
	});


	$('#btn_ls_add').click(function(){
		var ls_data = $('#gp-laysheet-form').form_validator('validate');
    if(ls_data !== false)
    {
			ls_data['header_id'] = ID;

			appAjaxRequest({
				url : BASE_URL + 'index.php/gatepass/save_manual_gp_laysheet',
				async : false,
				dataType : 'json',
				data : {
					'laysheet' : ls_data
				},
				success : function(res){
					if(res.status == 'success'){
						//add_item_to_table(res.item);
						if(ITEM_ADD_STATUS == 'NEW'){
							$('#ls_model_title').html('New Laysheet');
							$('#item_id').val(0);
							$('#laysheet_no').val('');
						}

						ITEMS = res.laysheets;
						load_laysheets(res.laysheets);
					}
					else {
						appAlertError(res.message);
					}
				},
				error : function(err){
					console.log(err);
					appAlertError('Error occured in saveing gatepass laysheets');
				}
			});
		}
	});



	$('#gp_items tbody').on('click', 'button', function(){
		let ele = $(this);
		let type = ele.attr('data-type');
		if(type == 'edit'){
			edit_item(ele.attr('data-index'));
		}
		else {
			remove_item(ele.attr('data-id'));
		}
	});


	$('#gp_laysheets tbody').on('click', 'button', function(){
		let ele = $(this);
		let type = ele.attr('data-type');
		//if(type == 'edit'){
		//	edit_item(ele.attr('data-index'));
		//}
		//else {
			remove_laysheet(ele.attr('data-id'));
		//}
	});


	$('#btn_print').click(function(){
		window.open(BASE_URL + 'index.php/gatepass/print_manual_gp/' + ID);
	});


	$('#btn_approval').click(function(){
		let gp_type = $('#gp_type').val();

		if(gp_type == 'laysheet transfer'){
			let items_length = $('#gp_laysheets tbody tr').length;
			if(items_length <= 0){
				appAlertError('Cannot send for approval without laysheets');
				return;
			}
		}
		else{
			let items_length = $('#gp_items tbody tr').length;
			if(items_length <= 0){
				appAlertError('Cannot send for approval without items');
				return;
			}
		}


		appAlertConfirm('Do you want to send this gate pass for approval?' , function(){

			$('body').loadingModal({
	      position: 'auto',
	      text: '',
	      color: '#fff',
	      opacity: '0.5',
	      backgroundColor: 'rgb(0,0,0)',
	      animation: 'cubeGrid'
	    });


			let proc_code = '';
			if(gp_type == 'style'){
				proc_code = 'M_GATEPASS_STYLE';
			}
			else if(gp_type == 'general'){
				proc_code = 'M_GATEPASS_GENERAL';
			}
			else if(gp_type == 'laysheet transfer'){
				proc_code = 'M_GATEPASS_LAYSHEET';
			}

			setTimeout(function(){
				appAjaxRequest({
		      url : BASE_URL + 'index.php/approval_proc/start_process',
		      type: 'post',
		      dataType : 'json',
					data : {
						'proc_code' : proc_code,
						'object_id' : ID
					},
		      success : function(res){
		        if(res.status == 'success'){
							appAlertSuccess(res.message, function(){
								location.reload();
							});
		        }
		        else{
		          appAlertError('Process Error');
		        }
						$('body').loadingModal('destroy');
		      },
		      error : function(err){
						$('body').loadingModal('destroy');
		        alert(err);
		      }
		    });
			}, 200);
		});
	});


	$('#btn_receive').click(function(){
		appAlertConfirm('Do you want to mark this as received?' , function(){
				appAjaxRequest({
		      url : BASE_URL + 'index.php/gatepass/receive_manual_gp',
		      type: 'post',
		      dataType : 'json',
					data : {
						'id' : ID
					},
		      success : function(res){
		        if(res.status == 'success'){
							appAlertSuccess(res.message, function(){
								location.reload();
							});
		        }
		        else{
		          appAlertError('Process Error');
		        }
		      },
		      error : function(err){
						$('body').loadingModal('destroy');
		        alert(err);
		      }
		    });
		});
	});


	function add_item_to_table(data){
		str = `<tr>
			<td>${ITEMS.length + 1}</td>
			<td>${data.description}</td>
			<td>${data.unit}</td>
			<td>${data.qty}</td>
			<td><button class="btn btn-success btn-sm" data-id="${data.id}" data-header-id="${data.header_id}" data-type="edit">Edit</button>
			<button class="btn btn-danger btn-sm" data-id="${data.id}" data-header-id="${data.header_id}" data-type="delete">Delete</button></td>
		</tr>`;
		$('#gp_items tbody').append(str);
	}


	function load_items(data){
		str = '';
		for(let x = 0 ; x < data.length ; x++) {
			str += `<tr>
				<td>${x+1}</td>
				<td>${data[x].description}</td>
				<td>${data[x].unit}</td>
				<td>${data[x].qty}</td>`;

				if(GP_STATUS == 'NEW'){
					str += `<td><button class="label label-success" data-id="${data[x].id}" data-header-id="${data[x].header_id}" data-type="edit" data-index="${x}">Edit</button>
						<button class="label label-danger" data-id="${data[x].id}" data-header-id="${data[x].header_id}" data-type="delete" data-index="${x}">Delete</button></td>`;
				}
				str += `</tr>`;
		}

		$('#gp_items tbody').html(str);
	}


	function load_laysheets(data){
		str = '';
		for(let x = 0 ; x < data.length ; x++) {
			str += `<tr>
				<td>${x+1}</td>
				<td><a style="font-weight:bold;color:blue;" href="${BASE_URL}index.php/cutting/bundle_2/print_bundlechart/${data[x].laysheet_no}" target="_blank"><u>${data[x].laysheet_no}</u></a></td>
				<td>${data[x].order_code}</td>
				<td>${data[x].cut_no}</td>`;

			if(GP_STATUS == 'NEW'){
				str += `<td><button class="label label-danger" data-id="${data[x].id}" data-header-id="${data[x].header_id}" data-type="delete" data-index="${x}">Delete</button></td>`;
			}
			str += `</tr>`;
		}

		$('#gp_laysheets tbody').html(str);
	}


	function edit_item(_item_index){
		//clear old values
		$('#item_details, #item_unit, #item_qty').val('');
		$('#gp-new-item-title').html('Update Item');

		if(ITEMS[_item_index] != undefined){
			$('#item_id').val(ITEMS[_item_index]['id']);
			$('#item_details').val(ITEMS[_item_index]['description']);
			$('#item_unit').val(ITEMS[_item_index]['unit']);
			$('#item_qty').val(ITEMS[_item_index]['qty']);
		}
		ITEM_ADD_STATUS = 'UPDATE';
		$('#item_model').modal('show');
	}


	function remove_item(_item_id){
		appAlertConfirm('Do you want to delete selected item?' , function(){
	    appAjaxRequest({
	      url : BASE_URL + 'index.php/gatepass/delete_manual_gp_item',
	      type: 'post',
	      dataType : 'json',
				data : {
					'item_id' : _item_id,
					'header_id' : ID
				},
	      success : function(res){
	        if(res.status == 'success'){
						ITEMS = res.items;
						load_items(res.items);
						appAlertSuccess(res.message);
	        }
	        else{
	          appAlertError('Process Error');
	        }
	      },
	      error : function(err){
	        alert(err);
	      }
	    });
	  });
	}


	function remove_laysheet(_item_id){
		appAlertConfirm('Do you want to delete selected laysheet?' , function(){
	    appAjaxRequest({
	      url : BASE_URL + 'index.php/gatepass/delete_manual_gp_laysheet',
	      type: 'post',
	      dataType : 'json',
				data : {
					'item_id' : _item_id,
					'header_id' : ID
				},
	      success : function(res){
	        if(res.status == 'success'){
						ITEMS = res.laysheets;
						load_laysheets(res.laysheets);
						appAlertSuccess(res.message);
	        }
	        else{
	          appAlertError('Process Error');
	        }
	      },
	      error : function(err){
	        alert(err);
	      }
	    });
	  });
	}


	function get_items(){
		appAjaxRequest({
			url : BASE_URL + 'index.php/gatepass/get_manual_gp_items',
			type : 'get',
			async : false,
			dataType : 'json',
			data : {
				'header_id' : ID
			},
			success : function(res){
				ITEMS = res.items;
				load_items(res.items);
			},
			error : function(err){
				console.log(err);
			}
		});
	}


	function get_laysheets(){
		appAjaxRequest({
			url : BASE_URL + 'index.php/gatepass/get_manual_gp_laysheets',
			type : 'get',
			async : false,
			dataType : 'json',
			data : {
				'header_id' : ID
			},
			success : function(res){
				ITEMS = res.laysheets;
				load_laysheets(res.laysheets);
			},
			error : function(err){
				console.log(err);
			}
		});
	}



    function initialize_form_validator(){
		$('#data-form').form_validator({
			events : ['blur'],
			fields : {
				'id' : {
							key : 'id',
							required : false
					},
					'to_address' : {
							key : 'to_address',
							required : true
					},
					'attention' : {
							key : 'attention',
							required : true
					},
					'remarks' : {
							key : 'remarks',
							required : true
					},
					'date' : {
							key : 'date',
							required : true
					},
					'gp_type' : {
						key : 'type',
						required : true
					},
					'ref_style' : {
							key : 'style',
							required : true
					},
					'through' : {
							key : 'through',
							required : true
					},
					'instructed_by' : {
							key : 'instructed_by',
							required : true
					},
					'special_instruction' : {
							key : 'special_instruction',
							//required : false
					},
					'company' : {
							key : 'site',
							required : true
					},
					'return_status' : {
							key : 'return_status',
							required : true
					},
			}
		});


		$('#gp-items-form').form_validator({
        events : ['blur'],
        fields : {
						'item_id' : {
							key : 'id',
							required : false,
						},
            'item_details' : {
                key : 'description',
                required : true
            },
            'item_unit' : {
                key : 'unit',
                required : true
            },
            'item_qty' : {
                key : 'qty',
                required : true,
                // dataType : {
								// 	type : 'decimal',
								// 	errorMessage : 'Incorrect value'
								// }
            },
            // 'item_status' : {
            //     key : 'status',
            //     required : true,
            // }
					}
    	});


			$('#gp-laysheet-form').form_validator({
	        events : ['blur'],
	        fields : {
							'item_id' : {
								key : 'id',
								required : false,
							},
	            'laysheet_no' : {
	                key : 'laysheet_no',
	                required : true,
									dataType : 'integer'
	            }
						}
	    	});

	}

})();
