(function () {

	var STYLE_ID = null;
	var COLOR_ID = null;
	var TRANSFER_TYPE = null;
	var TRANSFER_ID = '';
	var SITE_ID = null;

	$(document).ready(function () {

		TRANSFER_ID = $('#transfer_id').val();
		if(TRANSFER_ID != null && TRANSFER_ID != ''){
			STYLE_ID = $('#style_id').val().trim();
			COLOR_ID = $('#color_id').val().trim();
			let order_id = $('#order_id').val();
			let TRANSFER_TYPE = $('#transfer_type').val();
			load_stock_details_after_transfer();

			if(TRANSFER_TYPE == 'FG_TRANSFER'){
				load_order_stock(order_id);
			}
		}

		$('#transfer_type').change(function(){
			let type = $(this).val();
			TRANSFER_TYPE = type;

			if(type == 'WRITEOFF'){
				$('#order_id_div, #tbl_order_stock_div, #line_id_div').hide();
				$('#btn_transfer, #transfer_reason_div').show();
				load_transfer_reasons('WRITEOFF');
			}
			else if(type == 'FG_TRANSFER'){
				$('#order_id_div, #transfer_reason_div, #btn_transfer, #tbl_order_stock_div, #line_id_div').show();
				load_transfer_reasons('FG_TRANSFER');
			}
			else if(type == 'LEFT_OVER'){
				$('#order_id_div, #tbl_order_stock_div').hide();
				$('#line_id_div, #transfer_reason_div, #btn_transfer').show();
				load_transfer_reasons('LEFT_OVER');
			}
			else {
					$('#order_id_div, #transfer_reason_div, #btn_transfer, #btn_print, #tbl_order_stock_div, #line_id_div').hide();
					$('#transfer_reason').html('<option value="">...Select One...</option>');
			}
		});


		$('#style_id').change(function(){
			let style_id = $(this).val();
			if(style_id != ''){
				load_style_colors(style_id);
			}
			else {
				$('#color_id').html('<option value="">...Select One...</option>');
			}
		});


		$('#btn_search').click(function () {
			let style_id = $('#style_id').val().trim();
			let color_id = $('#color_id').val().trim();
			let site_id = $('#site_id').val();

			if(style_id == '' || color_id == '' || site_id == '' || TRANSFER_TYPE == null || TRANSFER_TYPE == ''){
				iziToast.error({title: '', message: 'Please select site, style, color and transfer type', position : 'topRight'	});
				return;
			}
			STYLE_ID = style_id;
			COLOR_ID = color_id;
			SITE_ID = site_id;
			$('#tbl_order_stock tbody').html('');
			load_stock_details();

			if(TRANSFER_TYPE == 'FG_TRANSFER'){
				load_orders();
				load_lines('FG');
			}
			else if(TRANSFER_TYPE == 'LEFT_OVER'){
				load_lines('LEFT_OVER');
			}
			else {
				$('#order_id').html('<option value="">...Select One...</option>');
				$('#lines_id').html('<option value="">...Select One...</option>');
			}

		});


		$('#order_id').change(function(){
			let order_id = $(this).val();
			if(order_id == ''){
				$('#tbl_order_stock tbody').html('');
			}
			else{
				load_order_stock(order_id);
			}
		});

});

function load_orders(){
		appAjaxRequest({
			url: BASE_URL + 'index.php/fg/bstores_transfer/get_order_details',
			type: 'get',
			dataType: 'json',
			data : {
				'style_id' : STYLE_ID,
				'color_id' : COLOR_ID
			},
			//async : false,
			success: function (res) {
				if(res != undefined && res != null){
					let orders = res.data;
					let orders_str = '<option value="">...Select One...</option>';
					if(orders != null && orders.length > 0){
						for(let x = 0 ; x < orders.length ; x++){
							orders_str += `<option value="${orders[x].order_id}">${orders[x].order_id} - ${orders[x].customer_po}</option>`;
						}
					}
					$('#order_id').html(orders_str);
				}
			},
			error : function(err){
				$('#order_id').html('<option value="">...Select One...</option>');
				alert(err);
			}
		});
}


function load_lines(_category){
	appAjaxRequest({
		url: BASE_URL + 'index.php/fg/bstores_transfer/get_left_over_lines',
		type: 'get',
		dataType: 'json',
		 data : {
			 'site_id' : SITE_ID,
			 'category' : _category
		 },
		//async : false,
		success: function (res) {
			if(res != undefined && res != null){
				let lines = res.data;
				let lines_str = '<option value="">...Select One...</option>';
				if(lines != null && lines.length > 0){
					for(let x = 0 ; x < lines.length ; x++){
						lines_str += `<option value="${lines[x].line_id}">${lines[x].line_code}</option>`;
					}
				}
				$('#line_id').html(lines_str);
			}
		},
		error : function(err){
			$('#lines_id').html('<option value="">...Select One...</option>');
			alert(err);
		}
	});
}


function load_stock_details(){
	//let transfer_type = (TRANSFER_TYPE == 'FG TRANSFER') ? 'FG_TRANSFER' : 'WRITEOFF';
	appAjaxRequest({
		url: BASE_URL + 'index.php/fg/bstores_transfer/get_stock_details',
		type: 'get',
		dataType: 'json',
		data : {
			'style_id' : STYLE_ID,
			'color_id' : COLOR_ID,
			'site_id' : SITE_ID
		},
	//	async : false,
		success: function (res) {
			if(res != undefined && res != null){
				let bstores_stock = res.stock;
				let stock_str = '';

				if(bstores_stock != null){
					for(let x = 0 ; x < bstores_stock.length ; x++){
						let bstores_qty = (bstores_stock[x].bstores_qty == null) ? 0 : parseInt(bstores_stock[x].bstores_qty);
						let all_transfered_qty = (bstores_stock[x].all_transfered_qty == null) ? 0 : parseInt(bstores_stock[x].all_transfered_qty);
						let bstore_balance = bstores_qty - all_transfered_qty;
						stock_str += `<tr>
							<td><input type="checkbox" data-id="${x}"></td>
							<td>${bstores_stock[x].size_code}</td>
							<td>${get_formated_data(bstore_balance)}</td>
							<td><input type="number" class="form-control input-sm" id="txt_${x}" data-size-id="${bstores_stock[x].size}"
							data-size-code="${bstores_stock[x].size_code}" data-bstore-qty="${bstore_balance}" disabled></td>
						</tr>`;
					}
				}
				$('#tbl_bstores_stock tbody').html(stock_str);
				load_orders();
			}
		},
		error: function (err) {
				$('#tbl_bstores_stock tbody').html('');
			alert(err);
		}
	});
}


function load_stock_details_after_transfer(){
	appAjaxRequest({
		url: BASE_URL + 'index.php/fg/bstores_transfer/get_stock_details_after_transfer',
		type: 'get',
		dataType: 'json',
		data : {
			'style_id' : STYLE_ID,
			'color_id' : COLOR_ID,
			'transfer_id' : TRANSFER_ID
		},
		//	async : false,
		success: function (res) {
			if(res != undefined && res != null){
				let bstores_stock = res.stock;
				let stock_str = '';

				if(bstores_stock != null){
					for(let x = 0 ; x < bstores_stock.length ; x++){
						let bstores_qty = (bstores_stock[x].bstores_qty == null) ? 0 : parseInt(bstores_stock[x].bstores_qty);
						let all_transfered_qty = (bstores_stock[x].all_transfered_qty == null) ? 0 : parseInt(bstores_stock[x].all_transfered_qty);
						let bstore_balance = bstores_qty - all_transfered_qty;
						stock_str += `<tr>
							<td></td>
							<td>${bstores_stock[x].size_code}</td>
							<td>${get_formated_data(bstore_balance)}</td>
							<td>${get_formated_data(bstores_stock[x].transfered_qty)}</td>
						</tr>`;
					}
				}
				$('#tbl_bstores_stock tbody').html(stock_str);
				load_orders();
			}
		},
		error: function (err) {
				$('#tbl_bstores_stock tbody').html('');
			alert(err);
		}
	});
}


$('#tbl_bstores_stock tbody').on('click', ':checkbox', function () {
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
	let order_id = $('#order_id').val();
	let line_id = $('#line_id').val();
	//let transfer_type = (TRANSFER_TYPE == 'FG TRANSFER') ? 'FG_TRANSFER' : 'WRITEOFF';

	if(SITE_ID == null || SITE_ID == ''){
		iziToast.error({title: '', message: 'Please select site', position : 'topRight'});
		return;
	}
	if(STYLE_ID == null || STYLE_ID == ''){
		iziToast.error({title: '', message: 'Please select stye', position : 'topRight'});
		return;
	}
	if(COLOR_ID == null || COLOR_ID == ''){
		iziToast.error({title: '', message: 'Please select color',	position : 'topRight'});
		return;
	}
	if(TRANSFER_TYPE == 'FG_TRANSFER' && (order_id == null || order_id == '')){
		iziToast.error({title: '', message: 'Please select order id',	position : 'topRight'});
		return;
	}
	if((TRANSFER_TYPE == 'LEFT_OVER' || TRANSFER_TYPE == 'FG_TRANSFER') && (line_id == null || line_id == '')){
		iziToast.error({title: '', message: 'Please select line_id',	position : 'topRight'});
		return;
	}
	if(reansfer_reason == null || reansfer_reason == ''){
		iziToast.error({title: '',	message: 'Please select transfer reason',	position : 'topRight'});
		return;
	}
	//check qty_
	let has_errors = false;
	$('#tbl_bstores_stock :checkbox').each(function() {
		let ele = $(this);

		if(ele.is(':checked')){
			let txt = $('#txt_'+ele.attr('data-id'));
			let txt_val = txt.val();
			txt_val = (txt_val == null || txt_val == '' || txt_val == 0) ? 0 : parseInt(txt.val());
			let bstore_qty = txt.attr('data-bstore-qty');
			bstore_qty = (bstore_qty == null || bstore_qty == 'null'  || bstore_qty == '' || bstore_qty == 0) ? 0 : parseInt(bstore_qty);
			let size_id = txt.attr('data-size-id');

			if(txt_val == 0){
				iziToast.error({title: '', message: 'Incorrect transfer qty in size - ' + txt.attr('data-size-code'),	position : 'topRight'});
				has_errors = true;
				return;
			}
			else if(bstore_qty == 0){
				iziToast.error({title: '', message: 'No b store items to transfer in size - ' + txt.attr('data-size-code'),position : 'topRight'});
				has_errors = true;
				return;
			}
			else if(bstore_qty <= txt_val){
				iziToast.error({title: '',message: 'Not enough b store items to transfer in size - ' + txt.attr('data-size-code'),position : 'topRight'});
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
		iziToast.error({title: '',message: 'Please select size to transfer',position : 'topRight'});
		return;
	}

appAlertConfirm('Do you want to transfer b stores items?', function () {

	$('#btn-transfer-i').addClass('fa fa-spinner fa-spin');
	setTimeout(function(){
				appAjaxRequest({
					url: BASE_URL + 'index.php/fg/bstores_transfer/save',
					type: 'post',
					data: {
						'style_id' : STYLE_ID,
						'color_id' : COLOR_ID,
						'transfer_reason' : reansfer_reason,
						'order_id' : order_id,
						'transfer_details' : transfer_data,
						'transfer_type' : TRANSFER_TYPE,
						'site_id' : SITE_ID,
						'line_id' : line_id
					},
					dataType: 'json',
					async : false,
					success: function (res) {
						$('#btn-transfer-i').removeClass('fa fa-spinner fa-spin');
						if (res.status == 'success') {
							TRANSFER_ID = res.id;
							appAlertSuccess(res.message, function(){
									window.open(BASE_URL + 'index.php/fg/bstores_transfer/view_transfer/' + TRANSFER_ID, '_self');
							});
						}
						else {
							iziToast.error({title: '',message: res.message,position : 'topRight'});
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


	function load_style_colors(_style_id){
		appAjaxRequest({
			url: BASE_URL + 'index.php/fg/bstores_transfer/get_style_colors/' + _style_id,
			type: 'get',
			dataType: 'json',
			async : false,
			success: function (res) {
				let colors = res.data;
				let str = '<option value="">...Select One...</option>';
				for(let x = 0 ; x < colors.length ; x++){
					str += `<option value="${colors[x].color_id}">${colors[x].color_code}</option>`;
				}
				$('#color_id').html(str);
			},
			error : function(err){
				console.log(err);
				$('#color_id').html('<option value="">...Select One...</option>');
			}
		});
	}


	function load_transfer_reasons(_transfer_type){
		//_transfer_type = (_transfer_type == 'FG TRANSFER') ? 'FG_TRANSFER' : 'WRITEOFF';
		appAjaxRequest({
			url: BASE_URL + 'index.php/fg/bstores_transfer/get_transfer_reasons/' + TRANSFER_TYPE,
			type: 'get',
			dataType: 'json',
			async : false,
			success: function (res) {
				let reasons = res.data;
				let str = '<option value="">...Select One...</option>';
				for(let x = 0 ; x < reasons.length ; x++){
					str += `<option value="${reasons[x].reason_id}">${reasons[x].reason_text}</option>`;
				}
				$('#transfer_reason').html(str);
			},
			error : function(err){
				console.log(err);
				$('#transfer_reason').html('<option value="">...Select One...</option>');
			}
		});
	}


	function load_order_stock(_order_id){
		appAjaxRequest({
			url: BASE_URL + 'index.php/fg/bstores_transfer/get_order_stock',
			type: 'get',
			dataType: 'json',
			data : {order_id : _order_id},
			async : false,
			success: function (res) {
				let stock = res.stock;
				let stock_str = '';

				if(stock != null){
					for(let x = 0 ; x < stock.length ; x++){
						let order_qty = (stock[x].order_qty == null) ? 0 : parseInt(stock[x].order_qty);
						let fg_qty = (stock[x].fg_qty == null) ? 0 : parseInt(stock[x].fg_qty);

						stock_str += `<tr>
							<td>${stock[x].size_code}</td>
							<td>${get_formated_data(stock[x].order_qty)}</td>
							<td>${get_formated_data(stock[x].fg_qty)}</td>
							<td>${order_qty - fg_qty}</td>
						</tr>`;
					}
				}
				$('#tbl_order_stock tbody').html(stock_str);
			},
			error : function(err){
				console.log(err);
				$('#tbl_order_stock tbody').html('');
			}
		});
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
