(function () {

	var TRANSFER_ID = '';

	$(document).ready(function () {

		TRANSFER_ID = $('#transfer_id').val();

		$('#btn_transfer').click(function () {
			let barcode = $('#barcode').val().trim();
			let transfer_type = $('#transfer_type').val().trim();
			let transfer_line = $('#transfer_line').val().trim();
			let transfer_shift = $('#transfer_shift').val().trim();
			let operation = $('#operation').val().trim();

			if(transfer_type == ''){
				iziToast.error({title: '', message: 'Please select transfer type', position : 'topRight'	});
				return;
			}

			if(barcode == ''){
				iziToast.error({title: '', message: 'Please enter barcode', position : 'topRight'	});
				return;
			}

			if(operation == ''){
				iziToast.error({title: '', message: 'Please select operation', position : 'topRight'	});
				return;
			}

			if(transfer_type == 'LINE' && transfer_line == ''){
				iziToast.error({title: '', message: 'Please select transfer line', position : 'topRight'	});
				return;
			}

			if(transfer_type == 'SHIFT' && transfer_shift == ''){
				iziToast.error({title: '', message: 'Please select transfer shift', position : 'topRight'	});
				return;
			}

			transfer_barcode(transfer_type, barcode, operation, transfer_line, transfer_shift);
		});


		// $('#btn_send').click(function(){
		// 	appAlertConfirm('Do you want to send request for approval?', function () {
		// 		send_for_approval();
		// 	});
		// });

});




function transfer_barcode(transfer_type, barcode, operation, transfer_line, transfer_shift){
	appAjaxRequest({
		url: BASE_URL + 'index.php/production/barcode_transfer/transfer',
		type: 'post',
		dataType: 'json',
		data : {
			'transfer_type' : transfer_type,
			'barcode' : barcode,
			'transfer_line' : transfer_line,
			'transfer_shift' : transfer_shift,
			'operation' : operation
		},
		async : false,
		success: function (res) {
			if(res.status == 'success'){
				$('#btn_transfer').hide();
				$('#transfer_type, #barcode, #operation, #transfer_line, #transfer_shift').attr('disabled', true);
				iziToast.success({title: '', message: res.message, position : 'topRight'	});
			}
			else {
				iziToast.error({title: '', message: res.message, position : 'topRight'	});
			}
		},
		error: function (err) {
			iziToast.error({title: '', message: err, position : 'topRight'	});
			console.log(err);
		}
	});
}





})()
