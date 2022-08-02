(function(){

	var BASE_URL = null;
	var SUPPLIER_ID = 0;

	 $(document).ready(function(){

		BASE_URL = $('#base-url').val();
		SUPPLIER_ID = $('#supplier_id').val();

		initialize_form_validator();

	 });


	$('#btn_save').click(function(){
		var form_data = $('#data-form').form_validator('validate');
		if(form_data !== false)
		{
			appAjaxRequest({
				url : BASE_URL + 'index.php/master/supplier/save',
				type: 'POST',
				data : {'form_data' : form_data},
				async : false,
				success : function(_serverResponse){
					var response = JSON.parse(_serverResponse);
					appAlertSuccess(response['message'],function(){
						window.open(BASE_URL + 'index.php/master/supplier/show/' + response['supplier_id'] , '_self');
					});
				}
			});
		}
		else{
			//$('#btn-save-i').removeClass('fa fa-spinner fa-spin');
		}
	});


    function initialize_form_validator(){
		$('#data-form').form_validator({
			events : ['blur'],
			fields : {
				'supplier_id' : {
					key : 'supplier_id',
					required : true
				},
				'supplier_code' : {
					required : true,
					remote : {
						url : BASE_URL + 'index.php/master/supplier/is_exists',
						data : {'supplier_id' : SUPPLIER_ID}
					}
				},
				'supplier_name' : {
					required : true
				},
				'supplier_address' : {
					required : true
				},
				'supplier_phone' : {
					key : 'supplier_phone'
				},
				'supplier_active' : {
					key : 'active',
					checkbox : {
						checkValue : 'Y',
						uncheckValue : 'N'
					}
				}
			}
		});
	}

})();
