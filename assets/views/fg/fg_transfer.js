(function () {

	var FROM_SITE_ID = null;
	var TO_SITE_ID = null;
	var FROM_LINE_ID = null;
	var TO_LINE_ID = null;
	var FROM_ORDER_ID = null;
	var TO_ORDER_ID = null;
	var FROM_ORDER = null;
	var TO_ORDER = null;
	var TRANSFER_ID = '';

	$(document).ready(function () {

		TRANSFER_ID = $('#transfer_id').val();
		//if(TRANSFER_ID != null && TRANSFER_ID != ''){
		//	load_fg_transfer_data();
	//	}

		$('#btn_from_order').click(function () {
			let f_order_id = $('#from_order_id').val();
			FROM_ORDER_ID = f_order_id;
			load_order_details(f_order_id, FROM_LINE_ID, 'from');
		});

		$('#btn_to_order').click(function () {
			let t_order_id = $('#to_order_id').val();
			TO_ORDER_ID = t_order_id;
			load_order_details(t_order_id, TO_LINE_ID, 'to');
		});

		$('#from_site_id').change(function(){
			let site_id = $(this).val();
			$('#to_site_id').val(site_id);

			if(site_id == ''){
				$('#from_line_id, #to_line_id').html('<option value="">... Select One ...</option>');
				FROM_SITE_ID = null;
				TO_SITE_ID = null;
			}
			else {
				FROM_SITE_ID = site_id;
				TO_SITE_ID = site_id;

				appAjaxRequest({
					url: BASE_URL + 'index.php/fg/fg_transfer/get_lines',
					type: 'get',
					dataType: 'json',
					data : {
						'site_id' : site_id
					},
					async : false,
					success: function (res) {
						let lines = res.data;
						let str = '<option value="">... Select One ...</option>';

						if(lines != null){
							for(let x = 0 ; x < lines.length ; x++){
								str += `<option value="${lines[x]['line_id']}">${lines[x]['line_code']}</option>`;
							}
						}
						$('#from_line_id, #to_line_id').html(str);
					},
					error : function(err){
						$('#from_line_id, #to_line_id').html('<option value="">... Select One ...</option>');
					}
			});
		}
		});


		$('#from_line_id').change(function(){
			let line_id = $(this).val();
			$('#to_line_id').val(line_id);
			if(line_id == ''){
				FROM_LINE_ID = null;
				TO_LINE_ID = null;
			}
			else {
				FROM_LINE_ID = line_id;
				TO_LINE_ID = line_id;
			}
		});

});


function load_order_details(_order_id, _line_id,  _type){
	//clear current data
	let form_data = {};
	form_data[`${_type}_order_id`] = '';
	form_data[`${_type}_cpo`] = '';
	form_data[`${_type}_style`] = '';
	form_data[`${_type}_color`] = '';
	appFillFormData(form_data);

	appAjaxRequest({
		url: BASE_URL + 'index.php/fg/fg_transfer/get_order_details',
		type: 'get',
		dataType: 'json',
		data : {
			'order_id' : _order_id,
			'line_id' : _line_id,
			'transfer_id' : TRANSFER_ID
		},
		async : false,
		success: function (res) {
			if(res != undefined && res != null){
				let order = res.order;
				let size_data = res.size_data;

				if(order == null){
					iziToast.error({
						title: '',
						message: 'Incorrect order id',
						position : 'topRight'
					});
					return;
				}

				if(_type == 'from'){
					FROM_ORDER = order;
				}
				else {
					TO_ORDER = order;
				}
				if(validate_two_orders_details()){
						$('#btn_transfer').show();
						$('#transfer_reason_div').show();

						form_data[`${_type}_order_id`] = order.order_id;
						form_data[`${_type}_cpo`] = order.customer_po;
						form_data[`${_type}_style`] = order.style_code;
						form_data[`${_type}_color`] = order.color_code;
						appFillFormData(form_data);
						generate_table_data(size_data, _type);
				}
				else {
					$('#btn_transfer').hide();
					$('#transfer_reason_div').hide();
				}
			}
		},
		error: function (err) {
			alert(err);
		}
	});
}


$('#tbl_from tbody').on('click', ':checkbox', function () {
	var id =  $(this).attr('data-id');

	if($(this).is(':checked')){
			$('#txt_' + id).attr('disabled', false);
	}
	else {
		$('#txt_' + id).attr('disabled', true);
	}
});


$('#btn_transfer').click(function(){

	let transfer_data = [];
	let reansfer_reason = $('#transfer_reason').val();

	if(FROM_ORDER_ID == null){
		iziToast.error({
			title: '',
			message: 'Please select from order',
			position : 'topRight'
		});
		return;
	}
	if(TO_ORDER_ID == null){
		iziToast.error({
			title: '',
			message: 'Please select to order',
			position : 'topRight'
		});
		return;
	}
	if(reansfer_reason == null || reansfer_reason == ''){
		iziToast.error({
			title: '',
			message: 'Please select transfer reason',
			position : 'topRight'
		});
		return;
	}
	//check qty_
	let has_errors = false;
	$('#tbl_from tbody :checkbox').each(function() {
		let ele = $(this);

		if(ele.is(':checked')){
			let txt = $('#txt_'+ele.attr('data-id'));
			let txt_val = txt.val();
			txt_val = (txt_val == null || txt_val == '' || txt_val == 0) ? 0 : parseInt(txt.val());
			let fg_qty = txt.attr('data-fg-qty');
			fg_qty = (fg_qty == null || fg_qty == 'null'  || fg_qty == '' || fg_qty == 0) ? 0 : parseInt(txt.attr('data-fg-qty'));
			let size_id = txt.attr('data-size-id');

			if(txt_val == 0){
				iziToast.error({
					title: '',
					message: 'Incorrect transfer qty in size - ' + txt.attr('data-size-code'),
					position : 'topRight'
				});
				has_errors = true;
				return;
			}
			else if(fg_qty == 0){
				iziToast.error({
					title: '',
					message: 'No finish goods to transfer in size - ' + txt.attr('data-size-code'),
					position : 'topRight'
				});
				has_errors = true;
				return;
			}
			else if(fg_qty <= txt_val){
				iziToast.error({
					title: '',
					message: 'Not enough finish goods to transfer in size - ' + txt.attr('data-size-code'),
					position : 'topRight'
				});
				has_errors = true;
				return;
			}

			transfer_data.push({
				'size_id' : size_id,
				'qty' : txt_val
			});
		}
	});

	if(has_errors){
		return;
	}
	if(transfer_data == null || transfer_data.length <= 0){
		iziToast.error({
			title: '',
			message: 'Please select size to transfer',
			position : 'topRight'
		});
		return;
	}

appAlertConfirm('Do you want to transfer finish goods?', function () {

	$('#btn-transfer-i').addClass('fa fa-spinner fa-spin');
	setTimeout(function(){
				appAjaxRequest({
					url: BASE_URL + 'index.php/fg/fg_transfer/save',
					type: 'post',
					data: {
						'from_order_id' : FROM_ORDER_ID,
						'to_order_id' : TO_ORDER_ID,
						'transfer_reason' : reansfer_reason,
						'from_site_id' : FROM_SITE_ID,
						'to_site_id' : TO_SITE_ID,
						'from_line_id' : FROM_LINE_ID,
						'to_line_id' : TO_LINE_ID,
						'transfer_details' : transfer_data
					},
					dataType: 'json',
					async : false,
					success: function (res) {
						$('#btn-transfer-i').removeClass('fa fa-spinner fa-spin');
						if (res.status == 'success') {
							TRANSFER_ID = res.id;
							// $('#tbl_from tbody :checkbox').attr('disabled', true);
							// $('#tbl_from tbody input').attr('disabled', true);
							// $('#btn_transfer').hide();
							// $('#btn_print').show();
							// $('#from_order_id,#to_order_id,#btn_from_order,#btn_to_order').attr('disabled', true);

							appAlertSuccess(res.message, function(){
									window.open(BASE_URL + 'index.php/fg/fg_transfer/view_transfer/' + TRANSFER_ID, '_self');
							});
							//load_order_details(FROM_ORDER_ID, 'from');
							//load_order_details(TO_ORDER_ID, 'to');
						}
						else {
							appAlertError(res.message);
						}
					},
					error: function (err) {
						$('#btn-transfer-i').removeClass('fa fa-spinner fa-spin');
						alert(err);
					}
				});
	},500);
});


});


function generate_table_data(size_data, _type){
	let str = '';
	if(size_data != null){
		for(let x = 0 ; x < size_data.length ; x++){
			str += `<tr>`;
				if(_type == 'from' && TRANSFER_ID == ''){
					str += `<td><input type="checkbox" data-id="${x}"></td>`;
				}
				else if(_type == 'from' && TRANSFER_ID != ''){
					str += `<td></td>`;
				}

				str += `<td>${size_data[x].size_code}</td>
				<td>${size_data[x].order_qty}</td>
				<td>${get_formated_data(size_data[x].fg_qty)}</td>`;

				if(_type == 'from' && TRANSFER_ID == ''){
					str += `<td><input type="number" step="1" class="form-control input-sm"
					id="txt_${x}" data-fg-qty="${size_data[x].fg_qty}" data-size-code="${size_data[x].size_code}"
					data-size-id="${size_data[x].size}" disabled></td>`;
				}
				else if(_type == 'from' && TRANSFER_ID != ''){
					str += `<td>${get_formated_data(size_data[x].fg_transfer_out_qty)}</td>`;
				}
				else if(_type == 'to' && TRANSFER_ID != ''){
					str += `<td>${get_formated_data(size_data[x].fg_transfer_in_qty)}</td>`;
				}
				else {
					str += `<td></td>`;
				}

			str += `</tr>`;
		}
	}
	$('#tbl_' + _type + ' tbody').html(str);
}


function load_fg_transfer_data(){
	appAjaxRequest({
		url: BASE_URL + 'index.php/fg/fg_transfer/get_transfer_data/' + TRANSFER_ID,
		type: 'get',
		dataType: 'json',
		async : false,
		success: function (res) {
				let transfer_data = res.transfer_data;
				let from_order = res.from_order;
				let from_order_size_data = res.from_order_size_data;
				let to_order = res.to_order;
				let to_order_size_data = res.to_order_size_data;

				appFillFormData({
					'transfer_reason' : transfer_data.transfer_reason
				});

				let form_data = {};
				if(from_order != null){
					form_data[`from_order_id`] = from_order.order_id;
					form_data[`from_cpo`] = from_order.customer_po;
					form_data[`from_style`] = from_order.style_code;
					form_data[`from_color`] = from_order.color_code;
					appFillFormData(form_data);
				}
				form_data = {};
				if(to_order != null){
					form_data[`to_order_id`] = to_order.order_id;
					form_data[`to_cpo`] = to_order.customer_po;
					form_data[`to_style`] = to_order.style_code;
					form_data[`to_color`] = to_order.color_code;
					appFillFormData(form_data);
				}

				generate_table_data(from_order_size_data, 'from');
				generate_table_data(to_order_size_data, 'to');
		},
		error: function (err) {
			alert(err);
		}
	});
}


	function validate_two_orders_details(){
		let status = true;
		// if(FROM_ORDER != null && TO_ORDER != null){
		// 	if((FROM_ORDER['style_code'] != TO_ORDER['style_code'])){
		// 		iziToast.error({
		// 			title: '',
		// 			message: 'Styles are different',
		// 			position : 'topRight'
		// 		});
		// 		status = false;
		// 	}
		// 	if(FROM_ORDER['color_code'] != TO_ORDER['color_code']){
		// 		iziToast.error({
		// 			title: '',
		// 			message: 'Colors are different',
		// 			position : 'topRight'
		// 		});
		// 		status = false;
		// 	}
		// 	if(FROM_ORDER_ID == TO_ORDER_ID){
		// 		iziToast.error({
		// 			title: '',
		// 			message: 'Cannot use same order id',
		// 			position : 'topRight'
		// 		});
		// 		status = false;
		// 	}
		// }
		return status;
	}



	function get_formated_data(_data){
		if(_data == undefined || _data == null || _data == 0){
			return '';
		}
		else {
			return _data;
		}
	}


})()
