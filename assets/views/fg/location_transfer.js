(function () {

	var FROM_SITE_ID = null;
	var FROM_LINE_ID = null;
	var FROM_STYLE_ID = null;
	var FROM_COLOR_ID = null;
	var FROM_ORDER_ID = null;
	var FROM_ORDER = null;
	let TRANSFER_TYPE = null;
	var TRANSFER_ID = '';

	$(document).ready(function () {

		// TRANSFER_ID = $('#transfer_id').val();
		// if(TRANSFER_ID != null && TRANSFER_ID != ''){
		// 	load_fg_transfer_data();
		// }

		$('#from_site_id').change(function () {
			let site_id = $(this).val();
			$('#to_site_id').val(site_id);
			if(site_id == ''){
				$('#from_line_id, #to_line_id').html('<option value="">... Select One ...</option>');
			}
			else {
				appAjaxRequest({
					url: BASE_URL + 'index.php/fg/location_transfer/get_lines',
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
						appAlertError(err);
						$('#line_id, #to_line_id').html('<option value="">... Select One ...</option>');
					}
				});
			}
		});

		$('#from_style_id').change(function () {
			let style_id = $(this).val();
			if(style_id == ''){
				$('#from_color_id').html('<option value="">... Select One ...</option>');
			}
			else {
				appAjaxRequest({
					url: BASE_URL + 'index.php/fg/location_transfer/get_style_colors',
					type: 'get',
					dataType: 'json',
					data : {
						'style_id' : style_id
					},
					async : false,
					success: function (res) {
						let colors = res.data;
						let str = '<option value="">... Select One ...</option>';

						if(colors != null){
							for(let x = 0 ; x < colors.length ; x++){
								str += `<option value="${colors[x]['color_id']}">${colors[x]['color_code']}</option>`;
							}
						}
						$('#from_color_id').html(str);
					},
					error : function(err){
						appAlertError(err);
						$('#from_color_id').html('<option value="">... Select One ...</option>');
					}
				});
			}
		});


		$('#btn_search').click(function(){
			let site_id = $('#from_site_id').val();
			let line_id = $('#from_line_id').val();
			let style_id = $('#from_style_id').val();
			let color_id = $('#from_color_id').val();
			let to_line_id = $('#to_line_id').val();

			if(site_id == '' || line_id == '' || style_id == '' || color_id == ''){
				iziToast.error({title: '', message: 'Please select site, line, style and color',	position : 'topRight'});
				return;
			}
			if(to_line_id == null || to_line_id == ''){
				iziToast.error({title: '', message: 'Please select to line',	position : 'topRight'});
				return;
			}

			FROM_SITE_ID = site_id;
			FROM_LINE_ID = line_id;
			FROM_STYLE_ID = style_id;
			FROM_COLOR_ID = color_id;
			TO_LINE_ID = to_line_id;
			$('#tbl_from tbody').html('');

			appAjaxRequest({
				url: BASE_URL + 'index.php/fg/location_transfer/get_order_details',
				type: 'get',
				dataType: 'json',
				data : {
					'style_id' : FROM_STYLE_ID,
					'color_id' : FROM_COLOR_ID,
					'from_line_id' : FROM_LINE_ID,
					'to_line_id' : TO_LINE_ID
				},
				async : false,
				success: function (res) {
					if(res != undefined && res != null){
						let orders = res.data;
						TRANSFER_TYPE = res.transfer_type;
						let orders_str = '<option value="">...Select One...</option>';

						if(TRANSFER_TYPE == 'LEFT_OVER_TO_FG'){
							orders_str += '<option value="0">0 - No Order</option>';
							$('#div_to_order_id').show();
							//load order to to order id
							orders_str2 = '<option value="">...Select One...</option>';
							if(orders != null && orders.length > 0){
								for(let x = 0 ; x < orders.length ; x++){
									orders_str2 += `<option value="${orders[x].order_id}">${orders[x].order_id} - ${orders[x].customer_po}</option>`;
								}
							}
							$('#to_order_id').html(orders_str2);
						}
						else {
							if(orders != null && orders.length > 0){
								for(let x = 0 ; x < orders.length ; x++){
									orders_str += `<option value="${orders[x].order_id}">${orders[x].order_id} - ${orders[x].customer_po}</option>`;
								}
							}
							$('#div_to_order_id').hide();
						}
						$('#from_order_id').html(orders_str);
					}
					else {
						TRANSFER_TYPE = null;
					}
				},
				error : function(err){
					TRANSFER_TYPE = null;
					$('#from_order_id').html('<option value="">...Select One...</option><option value="0">0 - No Order</option>');
					alert(err);
				}
			});
		});


		$('#from_order_id').change(function(){
			order_id = $(this).val();
			if(order_id == ''){
				$('#tbl_from tbody').html('');
				FROM_ORDER_ID = null;
			}
			else {
				FROM_ORDER_ID = order_id;
				appAjaxRequest({
					url: BASE_URL + 'index.php/fg/location_transfer/get_location_stock',
					type: 'get',
					dataType: 'json',
					data : {
						'site_id' : FROM_SITE_ID,
						'line_id' : FROM_LINE_ID,
						'style_id' : FROM_STYLE_ID,
						'color_id' : FROM_COLOR_ID,
						'order_id' : FROM_ORDER_ID
					},
					async : false,
					success: function (res) {
						let stock = res.data;
						let str = '';
						if(stock != null){
							for(let x = 0 ; x < stock.length ; x++){
								let fg_qty = (stock[x]['fg_qty'] == null) ? 0 : parseInt(stock[x]['fg_qty']);
								//let transfered_qty = (stock[x]['transfered_qty'] == null) ? 0 : parseInt(stock[x]['transfered_qty']);
								//let fg_balance = fg_qty - transfered_qty;

								str += `<tr>
									<td><input type="checkbox" data-id="${x}"></td>
									<td>${stock[x]['size_code']}</td>
									<td>${get_formated_data(stock[x]['order_qty'])}</td>
									<td>${get_formated_data(stock[x]['planned_qty'])}</td>
									<td>${get_formated_data(stock[x]['fg_qty'])}</td>
									<td><input type="number" class="form-control input-sm" id="txt_${x}" data-size-id="${stock[x].size}"
									data-size-code="${stock[x].size_code}" data-fg-qty="${fg_qty}" disabled></td>
								</tr>`;
							}
						}
						$('#tbl_from tbody').html(str);
						$('#transfer_reason_div, #btn_transfer').show();
					},
					error : function(err){
						appAlertError(err);
						$('#tbl_from tbody').html('');
					}
				});
			}
		});



		/*$('#btn_search').click(function(){
			let site_id = $('#site_id').val();
			let line_id = $('#line_id').val();
			let style_id = $('#style_id').val();
			let color_id = $('#color_id').val();

			if(site_id == '' || line_id == '' || style_id == '' || color_id == ''){
				iziToast.error({title: '', message: 'Please select site, line, style and color',	position : 'topRight'});
				return;
			}

			SITE_ID = site_id;
			LINE_ID = line_id;
			STYLE_ID = style_id;
			COLOR_ID = color_id;

			appAjaxRequest({
				url: BASE_URL + 'index.php/fg/fg_transfer/get_left_over_stock',
				type: 'get',
				dataType: 'json',
				data : {
					'site_id' : SITE_ID,
					'line_id' : LINE_ID,
					'style_id' : STYLE_ID,
					'color_id' : COLOR_ID
				},
				async : false,
				success: function (res) {
					let stock = res.data;
					let str = '';
					if(stock != null){
						for(let x = 0 ; x < stock.length ; x++){
							let left_over_qty = (stock[x]['left_over_qty'] == null) ? 0 : parseInt(stock[x]['left_over_qty']);
							let all_transfered_qty = (stock[x]['all_transfered_qty'] == null) ? 0 : parseInt(stock[x]['all_transfered_qty']);
							let left_over_balance = left_over_qty - all_transfered_qty;

							str += `<tr>
								<td><input type="checkbox" data-id="${x}"></td>
								<td>${stock[x]['size_code']}</td>
								<td>${get_formated_data(stock[x]['left_over_qty'])}</td>
								<td><input type="number" class="form-control input-sm" id="txt_${x}" data-size-id="${stock[x].size}"
								data-size-code="${stock[x].size_code}" data-bstore-qty="${left_over_balance}" disabled></td>
							</tr>`;
						}
					}
					$('#tbl_from tbody').html(str);
					$('#transfer_reason_div, #btn_transfer').show();
				},
				error : function(err){
					appAlertError(err);
				}
			});
		});*/


		// $('#btn_to_order').click(function () {
		// 	let t_order_id = $('#to_order_id').val();
		// 	TO_ORDER_ID = t_order_id;
		// 	load_order_details(t_order_id);
		// });

});


/* function load_order_details(_order_id){
	//clear current data
	let form_data = {};
	form_data[`to_order_id`] = '';
	form_data[`to_cpo`] = '';
	form_data[`to_style`] = '';
	form_data[`to_color`] = '';
	appFillFormData(form_data);

	appAjaxRequest({
		url: BASE_URL + 'index.php/fg/fg_transfer/get_order_details2/' + _order_id + '/' + TRANSFER_ID,
		type: 'get',
		dataType: 'json',
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

				ORDER = order;
				ORDER_ID = order.order_id;

				if(validate_two_orders_details()){
						$('#btn_transfer').show();
						$('#transfer_reason_div').show();

						form_data[`to_order_id`] = order.order_id;
						form_data[`to_cpo`] = order.customer_po;
						form_data[`to_style`] = order.style_code;
						form_data[`to_color`] = order.color_code;
						appFillFormData(form_data);
						generate_table_data(size_data);
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
}*/


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
	let to_site_id = $('#to_site_id').val();
	let to_line_id = $('#to_line_id').val();
	let to_order_id = $('#to_order_id').val();

	if(FROM_SITE_ID == null || FROM_LINE_ID == null || FROM_STYLE_ID == null || FROM_COLOR_ID == null){
		iziToast.error({
			title: '',
			message: 'Please select from site, line, style and color',
			position : 'topRight'
		});
		return;
	}
	if(to_site_id == '' || to_line_id == ''){
		iziToast.error({
			title: '',
			message: 'Please select to site and line',
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
	if(TRANSFER_TYPE == 'LEFT_OVER_TO_FG' && to_order_id == ''){
		iziToast.error({
			title: '',
			message: 'Please select to order id',
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
			else if(fg_qty < txt_val){
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
					url: BASE_URL + 'index.php/fg/location_transfer/save',
					type: 'post',
					data: {
						'from_site_id' : FROM_SITE_ID,
						'to_site_id' : to_site_id,
						'from_line_id' : FROM_LINE_ID,
						'to_line_id' : to_line_id,
						'from_order_id' : FROM_ORDER_ID,
						'from_style_id' : FROM_STYLE_ID,
						'from_color_id' : FROM_COLOR_ID,
						'transfer_reason' : reansfer_reason,
						'transfer_details' : transfer_data,
						'to_order_id' : to_order_id,
						'transfer_type' : TRANSFER_TYPE
					},
					dataType: 'json',
					async : false,
					success: function (res) {
						$('#btn-transfer-i').removeClass('fa fa-spinner fa-spin');
						if (res.status == 'success') {
							TRANSFER_ID = res.id;
							appAlertSuccess(res.message, function(){
									window.open(BASE_URL + 'index.php/fg/location_transfer/view_transfer/' + TRANSFER_ID, '_self');
							});
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


function validate_two_orders_details(){
	let status = true;

		// if(ORDER['style'] != STYLE_ID){
		// 	iziToast.error({
		// 		title: '',
		// 		message: 'Styles are different',
		// 		position : 'topRight'
		// 	});
		// 	status = false;
		// }
		// if(ORDER['color'] != COLOR_ID){
		// 	iziToast.error({
		// 		title: '',
		// 		message: 'Colors are different',
		// 		position : 'topRight'
		// 	});
		// 	status = false;
		// }

	return status;
}


function generate_table_data(size_data){
	let str = '';
	if(size_data != null){
		for(let x = 0 ; x < size_data.length ; x++){
			str += `<tr>`;

				str += `<td>${size_data[x].size_code}</td>
				<td>${size_data[x].order_qty}</td>
				<td>${get_formated_data(size_data[x].fg_qty)}</td>`;
				if(TRANSFER_ID != ''){
					str += `<td>${get_formated_data(size_data[x].fg_transfer_in_qty)}</td>`;
				}
				else {
					str += `<td></td>`;
				}

			str += `</tr>`;
		}
	}
	$('#tbl_to tbody').html(str);
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
