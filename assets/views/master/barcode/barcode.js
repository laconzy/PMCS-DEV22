(function(){

	var BASE_URL = null;
	var BARCODE_ID = 0;

	 $(document).ready(function(){

		BASE_URL = $('#base-url').val();
		BARCODE_ID = $('#barcode-id').val();

		initialize_form_validator();
		load_styles();
		load_colors();
		load_sizes();
		load_qtys();

		if(BARCODE_ID > 0){
			load_barcode_details(BARCODE_ID);
		}

	 });


	$('#btn-save').click(function(){
		$('#btn-save-i').addClass('fa fa-spinner fa-spin');
		setTimeout(function(){
			var form_data = $('#data-form').form_validator('validate');
			if(form_data !== false)
			{
				if(!validate_barcode(form_data)){
					$('#btn-save-i').removeClass('fa fa-spinner fa-spin');
					return false;
				}

				appAjaxRequest({
					url : BASE_URL + 'index.php/master/barcode/barcode_save',
					data : {'form_data' : form_data},
					async : false,
					success : function(_serverResponse){
						var response = JSON.parse(_serverResponse);
						appAlertSuccess(response['message'],function(){
							window.open(BASE_URL + 'index.php/master/barcode/barcode_view/' + response['barcode_id'] , '_self');
						});
					}
				});
			}
			else{
				$('#btn-save-i').removeClass('fa fa-spinner fa-spin');
			}
		},500);
	});


    function initialize_form_validator(){
		$('#data-form').form_validator({
			events : ['blur'],
			fields : {
				'barcode-id' : {
					key : 'barcode_id',
					required : true
				},
				'style' : {
					required : true,
					/*remote : {
						url : BASE_URL + 'index.php/master/barcode/is_barcode_exists',
						data : {'color_id' : COLOR_ID}
					}*/
				},
				'color' : {
					required : true
				},
				'size' : {
					required : true
				},
				'cartoon_qty' : {
					required : true
				},
				'net_weight' : {
					required : true
				},
				'barcode' : {
					required : true
				},
				'active' : {
					key : 'active',
					checkbox : {
						checkValue : 'Y',
						uncheckValue : 'N'
					}
				}
			}
		});
	}


	function load_styles(){
		$("#style").select2({
			ajax: {
				url: BASE_URL + 'index.php/master/style/search',
				dataType: 'json'
			}
		});
	}


	function load_colors(){
		$("#color").select2({
			ajax: {
				url: BASE_URL + 'index.php/master/colour/search',
				dataType: 'json'
			}
		});
	}


	function load_sizes(){
		$("#size").select2({
			ajax: {
				url: BASE_URL + 'index.php/master/size/search',
				dataType: 'json'
			}
		});
	}


	function load_qtys(){
		$("#cartoon_qty").select2({
			ajax: {
				url: BASE_URL + 'index.php/master/cartoon_qty/search',
				dataType: 'json'
			}
		});
	}


	function validate_barcode(_form_data){
		let valid_status = false;
		appAjaxRequest({
			url : BASE_URL + 'index.php/master/barcode/is_barcode_exists',
			data : _form_data,
			async : false,
			success : function(_serverResponse){
				var response = JSON.parse(_serverResponse);
				if(response.status == 'success'){
					valid_status = true;
				}
				else {
					appAlertError(response['message'],function(){});
				}
			}
		});
		return valid_status;
	}


	function load_barcode_details(_barcode_id){
			let valid_status = false;
			appAjaxRequest({
				url : BASE_URL + 'index.php/master/barcode/get_barcode/' + _barcode_id,
				async : false,
				success : function(_serverResponse){
					var response = JSON.parse(_serverResponse);
					if(response.data != undefined){
						let barcode_data = response.data;
						$("#style").empty().append('<option value="'+barcode_data.style+'">'+barcode_data.style_code+'</option>').val(barcode_data.style).trigger('change');
						$("#color").empty().append('<option value="'+barcode_data.color+'">'+barcode_data.color_code+'</option>').val(barcode_data.color).trigger('change');
						$("#size").empty().append('<option value="'+barcode_data.size+'">'+barcode_data.size_code+'</option>').val(barcode_data.size).trigger('change');
						$("#cartoon_qty").empty().append('<option value="'+barcode_data.cartoon_qty+'">'+barcode_data.qty+'</option>').val(barcode_data.cartoon_qty).trigger('change');
					}
					else {
						appAlertError("Barcode data loading error",function(){});
					}
				}
			});
	}

})();
