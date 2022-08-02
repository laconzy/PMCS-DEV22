(function () {

	var LAYSHEET_NO = 0;
	var LAYSHEET = null;
	var CUT_PLAN = null;
	var IS_CONFIRMED = false;
	var HAS_BUNDLE_CHART = false;

	$(document).ready(function () {

		$('#btn_laysheet_search').click(function () {
		var pack_list_id = $('#laysheet_no').val().trim();
			if (pack_list_id != '') {
				//LAYSHEET = null;
				//CUT_PLAN = null;
				load_packing_list(pack_list_id);
			}
			else {
				appAlertError('Enter packing list id');
			}
	});


	/*$('#btn_save').click(function(){
		$('#btn-save-i').addClass('fa fa-spinner fa-spin');
		setTimeout(function(){
			var form_data = $('#data-form').form_validator('validate');
			if(form_data !== false)
			{
				//appAlertConfirm('Do you want to Create Packing List?', function () {
					appAjaxRequest({
						url: BASE_URL + 'index.php/fg/packing_list/save',
						type: 'post',
						data: form_data,
						dataType: 'json',
						success: function (res) {
							$('#btn-save-i').removeClass('fa fa-spinner fa-spin');
							if (res.status == 'success') {
								appAlertSuccess(res.message);
								appFillFormData({
									pack: res.id,
									packing_list_id : res.id
								});
								show_confirmed_fields();
							}
						},
						error: function (err) {
							$('#btn-save-i').removeClass('fa fa-spinner fa-spin');
							alert(err);
						}
					});
			//	});
			}
			else{
				$('#btn-save-i').removeClass('fa fa-spinner fa-spin');
			}
		},500);
	});*/


/*$('#btn_delete_all').click(function () {
	appAlertConfirm('Do you want to delete all bundles?', function () {
		appAjaxRequest({
			url: BASE_URL + 'index.php/cutting/bundle/destroy_all/' + LAYSHEET_NO,
			type: 'post',
			dataType: 'json',
			success: function (res) {
				if (res.status == 'success') {
					$('#bundle_chart_table tbody').html('');
					appAlertSuccess(res.message);
					//reload_summery_table(LAYSHEET_NO);
				}
			},
			error: function (err) {
				alert(err);
			}
		});
	});
});*/


$('#btn_print').click(function () {
	if (LAYSHEET != null) {
		window.open(BASE_URL + 'index.php/cutting/bundle/print_bundlechart/' + LAYSHEET.pack);
	}
});


$('#print_report').click(function () {
	var pack = $('#packing_list_id').val();
	window.open(BASE_URL + 'index.php/fg/packing_list/packing_list_return_print/' + pack);
});


});


function load_packing_list(_packing_list_id){
	appAjaxRequest({
		url: BASE_URL + 'index.php/fg/packing_list/get_packing_list/' + _packing_list_id,
		type: 'get',
		dataType: 'json',
		success: function (res) {
			if(res != undefined && res != null){
				let packing_list = res.packing_list;
				let orders = res.orders;

				if(packing_list['is_confirmed'] != 1){
					appAlertError('Packing list not confirmed');
					return;
				}

				appFillFormData({
					style: orders[0].style_code,
					customer_po: orders[0].customer_po,
					pcd_date: orders[0].pcd_date,
					customer: orders[0].cus_name,
					packing_list_id : packing_list['id'],
					pack : packing_list['id'],
					container : packing_list['container'],
					ref_1 : packing_list['ref_1'],
					ref_2: packing_list['ref_2'],
					ref_3 : packing_list['ref_3'],
					site : packing_list['site']
				});

				let str = '<option value="">... Select One ...</option>';
				for(let x = 0 ; x < orders.length ; x++){
					str += `<option value="${orders[x].order_id}">${orders[x].order_id} - ${orders[x].color_code}</option>`;
				}
				$('#order_id').html(str);

				IS_CONFIRMED = packing_list['is_confirmed'];
				if(packing_list['is_confirmed'] != 1){
					hide_confirmed_fields();
				}
				else {
					show_confirmed_fields();
				}
				load_bundle_chart();
			}
		},
		error: function (err) {
			alert(err);
		}
	});
}


/*function search_packing_list(_pack_list_id) {
    appAjaxRequest({
	    url: BASE_URL + 'index.php/fg/packing_list/get_packing_list/' + _pack_list_id,
	    type: 'get',
	    dataType: 'json',
	    success: function (res) {
		    if (res != null && res != '') {

				let orders = res.orders;
				let packing_list = res.packing_list;

				if(orders != null && orders.length > 0){
					appFillFormData({
						style: orders[0].style_code,
						customer_po: orders[0].customer_po,
						pcd_date: orders[0].pcd_date,
						customer: orders[0].cus_name
					});

					let str = '<option value="">... Select One ...</option>';
					for(let x = 0 ; x < orders.length ; x++){
						str += `<option value="${orders[x].order_id}">${orders[x].order_id} - ${orders[x].color_code}</option>`;
					}
					$('#order_id').html(str);
					//load_bundle_chart();
					$('#btn_save').show();
				}
				else {
					appAlertError('No data avaliable for searched po number');
				}
			}
		},
		error: function (err) {
			alert(err);
		}
	});
}*/


$('#bundle_chart_table tbody').on('click', ':checkbox', function () {
	var ele = $(this);
	var data_id = ele.attr('data-id');

	if(ele.is(':checked')){
		$('#txt_'+data_id).prop('disabled', false);
	}
	else {
		$('#txt_'+data_id).prop('disabled', true);
	}
});


function load_bundle_chart() {
	 let header_id = $('#packing_list_id').val();
		appAjaxRequest({
			url: BASE_URL + 'index.php/fg/packing_list/get_confirmed_cartoons/' + header_id,
			type: 'get',
			dataType: 'json',
			success: function (res) {
				if (res != null && res != '') {
					var bundle_chart = res.bundle_chart;
					var str = '';
					var str = '';

					if(bundle_chart != undefined && bundle_chart != null && bundle_chart.length > 0){
						for (var x = 0; x < bundle_chart.length; x++) {

							let ttl_qty = parseInt(bundle_chart[x]['ttl_qty']);
							let return_qty = (bundle_chart[x]['return_qty'] == null) ? 0 : parseInt(bundle_chart[x]['return_qty']);
							let style_str = '';
							if(return_qty > ttl_qty){
								style_str = 'style="background-color:#ffcccc"';
							}

							str += `<tr ${style_str}>`;
							//str += '<td>' + bundle_chart[x]['style_code'] + '</td>';
							str += `<td><input type="checkbox" id="chk_${x}" data-id="${x}"></td>`;
							str += '<td>' + get_formated_data(bundle_chart[x]['color_code']) + '</td>';
							str += '<td>' + get_formated_data(bundle_chart[x]['size_code']) + '</td>';
							str += '<td>' + get_formated_data(bundle_chart[x]['pcs_per_ctn']) + '</td>';
							str += '<td>' + get_formated_data(bundle_chart[x]['ctn_qty']) + '</td>';
							str += '<td>' + get_formated_data(bundle_chart[x]['ttl_qty']) + '</td>';
							//str += '<td>' + return_ctn + '</td>';
							str += '<td>' + get_formated_data(bundle_chart[x]['return_qty']) + '</td>';
							str += `<td><input type="number" class="form-control input-sm" min="0" step="1" style="text-align:right" id="txt_${x}"
							data-order-id="${bundle_chart[x]['order_id']}" data-size-id="${bundle_chart[x]['size_id']}" disabled></td>`;
							//str += '<td>' + get_formated_data(bundle_chart[x]['weight_net']) + '</td>';
							if(IS_CONFIRMED == false){
								str += '<td><button class="btn btn-danger btn-xs" data-barcode="' + get_formated_data(bundle_chart[x]['barcode']) + '">Remove Cartoon</button></td>';
							}
							str += '</tr>';
						}
						$('#print_report').show();
					}


					if(IS_CONFIRMED == true){
						$('#btn_action').show();
					}
					$('#bundle_chart_table tbody').html(str);
				}
			},
			error: function (err) {
				alert(err);
			}
		});
	}


	/*$('#btn-add-barcode').click(function(){
		let barcode = $('#barcode').val().trim();
		let header_id = $('#packing_list_id').val();
		let order_id = $('#order_id').val();

		if(barcode == null || barcode == ''){
			appAlertError('Barcode cannot be empty');
			return;
		}
		if(order_id == null || order_id == ''){
			appAlertError('Order cannot be empty');
			return;
		}

		appAjaxRequest({
			url: BASE_URL + 'index.php/fg/packing_list/scan_return_barcode',
			type: 'post',
			dataType: 'json',
			data : {
				header_id : header_id,
				barcode : barcode,
				order_id : order_id
			},
			success: function (res) {
				if(res.status == 'success'){
				//	appAlertSuccess(res.message);
					$('#barcode').val('');
					load_bundle_chart();
				}
				else {
					appAlertError(res.message);
				}
			}
		});

	});*/


  /*$('#btn_confirm').click(function(){
		let pack_list_id = $('#packing_list_id').val();

		appAlertConfirm('Do you want to confirm packing list?', function () {
			appAjaxRequest({
				url: BASE_URL + 'index.php/fg/packing_list/confirm_packing_list/' + pack_list_id,
				type: 'post',
				dataType: 'json',
				success: function (res) {
					if (res.status == 'success') {
						appAlertSuccess(res.message);
						IS_CONFIRMED = true;
						hide_confirmed_fields();
						load_bundle_chart();
					}
					if(res.status == 'error'){
						appAlertError(res.message);
					}
				},
				error: function (err) {
					alert(err);
				}
			});
		});
	});*/


	$('#btn_return').click(function(){
		let pack_list_id = $('#packing_list_id').val();
		let return_list = [];
		let header_id = $('#packing_list_id').val();
		let status = true;

		$('#bundle_chart_table tbody :checkbox').each(function(){
			let ele = $(this);
			if(ele.is(':checked')){
				let txt = $('#txt_' + ele.attr('data-id'));
				return_list.push({
					order_id : txt.attr('data-order-id'),
					size_id : txt.attr('data-size-id'),
					qty : txt.val()
				});

				if(txt.val() == null || txt.val() == 0){
					status = false;
					return;
				}
			}
		});

		if(return_list.length <= 0){
			appAlertError('No data to save');
			return;
		}

		if(status == false){
			appAlertError('Qty cannot be empty and should be grater than 0');
			return;
		}

		appAlertConfirm('Are you sure you want to return these items?', function () {
			appAjaxRequest({
				url: BASE_URL + 'index.php/fg/packing_list/return_packing_items',
				type: 'post',
				dataType: 'json',
				data : {
					header_id : header_id,
					return_list : return_list
				},
				success: function (res) {
					if(res.status == 'success'){
					//	appAlertSuccess(res.message);
						$('#barcode').val('');
						load_bundle_chart();
					}
					else {
						appAlertError(res.message);
					}
				}
			});
		});
	});


	function get_formated_data(_data){
		if(_data == undefined || _data == null || _data == 0){
			return '';
		}
		else {
			return _data;
		}
	}

	function hide_confirmed_fields(){
		$('#btn_return').hide();
		//$('#div_barcode').hide();
		//$('#btn_save').hide();
		//$('#btn-add-barcode').hide();
	}

	function show_confirmed_fields(){
		$('#btn_return').show();
		//$('#div_barcode').show();
		//$('#btn_save').show();
		//$('#btn-add-barcode').hide();
	}


})()
