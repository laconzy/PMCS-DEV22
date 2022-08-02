(function () {

	var ORDER_ID = null;
	var STYLE_ID = null;
	var COLOR_ID = null;
	var REQUEST_ID = '';


	$(document).ready(function () {

		REQUEST_ID = $('#request_id').val();

		$('#btn_search').click(function () {
			let order_id = $('#order_id').val().trim();

			if(order_id == ''){
				iziToast.error({title: '', message: 'Please enter order id', position : 'topRight'	});
				return;
			}
			ORDER_ID = order_id;

			$('#tbl_order_stock tbody').html('');
			load_stock_details();
		});


		$('#btn_send').click(function(){
			appAlertConfirm('Do you want to send request for approval?', function () {
				send_for_approval();
			});
		});

});




function load_stock_details(){
	appAjaxRequest({
		url: BASE_URL + 'index.php/production/recut/get_stock_details',
		type: 'get',
		dataType: 'json',
		data : {
			'order_id' : ORDER_ID
		},
		async : false,
		success: function (res) {
			if(res != undefined && res != null){

				if(res.status == 'error'){
					iziToast.error({title: '', message: res.message, position : 'topRight'	});
					return;
				}

				let rejection_stock = res.stock;
				let order_data = res.order_data;
				let stock_str = '';

				if(rejection_stock != null){
					for(let x = 0 ; x < rejection_stock.length ; x++){
						let rejection_qty = (rejection_stock[x].rejection_qty == null) ? 0 : parseInt(rejection_stock[x].rejection_qty);
						let requested_qty = (rejection_stock[x].requested_qty == null) ? 0 : parseInt(rejection_stock[x].requested_qty);
						let rejection_balance = rejection_qty - requested_qty;
						stock_str += `<tr>
							<td><input type="checkbox" data-id="${x}" data-reject-reason="${rejection_stock[x].reason_code}" data-reject-name="${rejection_stock[x].rejection_name}"></td>
							<td>${rejection_stock[x].size_code}</td>
							<td>${rejection_stock[x].rejection_name}</td>
							<td>${get_formated_data(rejection_balance)}</td>
							<td><input type="number" class="form-control input-sm" id="txt_${x}" data-size-id="${rejection_stock[x].size}"
							data-size-code="${rejection_stock[x].size_code}" data-rejection-qty="${rejection_balance}" disabled></td>
						</tr>`;
					}
				}
				$('#tbl_stock tbody').html(stock_str);

				if(order_data != null){
					$('#style').val(order_data.style_code);
					$('#color').val(order_data.color_code);
					$('#customer_po').val(order_data.customer_po);
				}
				else {
					$('#style, #color, #customer_po').val('');
				}
			}
		},
		error: function (err) {
				$('#tbl_stock tbody').html('');
			alert(err);
		}
	});
}





$('#tbl_stock tbody').on('click', ':checkbox', function () {
	var id =  $(this).attr('data-id');

	if($(this).is(':checked')){
			$('#txt_' + id).attr('disabled', false);
	}
	else {
		$('#txt_' + id).attr('disabled', true);
	}
});


$('#btn_save').click(function(){

	let transfer_data = [];
	//let order_id = $('#order_id').val();

	if(ORDER_ID == null || ORDER_ID == ''){
		iziToast.error({title: '', message: 'Please enter order id', position : 'topRight'});
		return;
	}

	//check qty_
	let has_errors = false;
	$('#tbl_stock :checkbox').each(function() {
		let ele = $(this);

		if(ele.is(':checked')){
			let reject_reason = ele.attr('data-reject-reason');
			let reject_name = ele.attr('data-reject-name');
			let txt = $('#txt_'+ele.attr('data-id'));
			let txt_val = txt.val();
			txt_val = (txt_val == null || txt_val == '' || txt_val == 0) ? 0 : parseInt(txt.val());
			let rejection_qty = txt.attr('data-rejection-qty');
			rejection_qty = (rejection_qty == null || rejection_qty == 'null'  || rejection_qty == '' || rejection_qty == 0) ? 0 : parseInt(rejection_qty);
			let size_id = txt.attr('data-size-id');

			if(txt_val == 0){
				iziToast.error({title: '', message: 'Incorrect request qty in size - ' + txt.attr('data-size-code') + ',' + reject_name,	position : 'topRight'});
				has_errors = true;
				return;
			}
			else if(rejection_qty == 0){
				iziToast.error({title: '', message: 'No rejection qty to request in size - ' + txt.attr('data-size-code') + ',' + reject_name, position : 'topRight'});
				has_errors = true;
				return;
			}
			else if(rejection_qty < txt_val){
				iziToast.error({title: '',message: 'Not enough rejection qty to request in size - ' + txt.attr('data-size-code') + ',' + reject_name, position : 'topRight'});
				has_errors = true;
				return;
			}

			transfer_data.push({
				'size_id' : size_id,
				'reject_reason' : reject_reason,
				'qty' : txt_val
			});
		}
	});

	if(has_errors){
		return;
	}
	if(transfer_data == null || transfer_data.length <= 0){
		iziToast.error({title: '',message: 'Please select size to request',position : 'topRight'});
		return;
	}

appAlertConfirm('Do you want to save recut request?', function () {

	$('#btn-save-i').addClass('fa fa-spinner fa-spin');
	setTimeout(function(){
				appAjaxRequest({
					url: BASE_URL + 'index.php/production/recut/save',
					type: 'post',
					data: {
						'order_id' : ORDER_ID,
						'transfer_details' : transfer_data
					},
					dataType: 'json',
					async : false,
					success: function (res) {
						$('#btn-save-i').removeClass('fa fa-spinner fa-spin');
						if (res.status == 'success') {
							REQUEST_ID = res.id;
							appAlertSuccess(res.message, function(){
									window.open(BASE_URL + 'index.php/production/recut/view_request/' + REQUEST_ID, '_self');
							});
						}
						else {
							iziToast.error({title: '',message: res.message,position : 'topRight'});
						}
					},
					error: function (err) {
						$('#btn-save-i').removeClass('fa fa-spinner fa-spin');
						alert(err);
					}
				});
	},500);
});


});


	function send_for_approval(){
		appAjaxRequest({
			url: BASE_URL + 'index.php/approval_proc/start_process',
			type: 'post',
			data: {
				'proc_code' : 'RECUT',
				'object_id' : REQUEST_ID
			},
			dataType: 'json',
			async : false,
			success: function (res) {
				if(res.status == 'success'){
					appAlertSuccess(res.message, function(){
						location.reload();
					});
				}
				else {
					appAlertError(res.message);
				}
			},
			error : function(err){
				appalertError(err);
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
