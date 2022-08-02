(function(){

	var BASE_URL = null;
	var CUS_ID = 0;

	 $(document).ready(function(){

		BASE_URL = $('#base-url').val();
		CUS_ID = $('#cus_id').val();

		initialize_form_validator();

	 });


	$('#btn-save').click(function(){
		$('#btn-save-i').addClass('fa fa-spinner fa-spin');
		setTimeout(function(){
			var form_data = $('#data-form').form_validator('validate');
			if(form_data !== false)
			{
				appAjaxRequest({
					url : BASE_URL + 'index.php/master/customer/customer_save',
					data : {'form_data' : form_data},
					async : false,
					success : function(_serverResponse){
						var response = JSON.parse(_serverResponse);
						appAlertSuccess(response['message'],function(){
							window.open(BASE_URL + 'index.php/master/customer/customer_view/' + response['cus_id'] , '_self');
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
				'cus_id' : {
					key : 'id',
					required : true
				},
				'cus_code' : {
					required : true,
					remote : {
						url : BASE_URL + 'index.php/master/customer/is_customer_code_exists',
						data : {'cus_id' : CUS_ID}
					}
				},
				'description' : {
					notRequired : true
				},
				'cus_name' : {
					required : true
				},
				'cus_other' : {
					notRequired : true
				},
				'address-line1' : {
					required : true
				},
				'address-line2' : {
					notRequired : true
				},
				'city' : {
					required : true
				},
				'state' : {
					required : true
				},
				'country' : {
					required : true
				},
				'email' : {
					notRequired : true
				},
				'phone1' : {
					notRequired : true
				},
				'phone2' : {
					notRequired : true
				},
				'cus_active' : {
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
