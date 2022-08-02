(function(){

	var BASE_URL = null;
	var OPERATION_ID = 0;

	 $(document).ready(function(){

		BASE_URL = $('#base-url').val();
		OPERATION_ID = $('#operation_id').val();

		initialize_form_validator();

	 });


	$('#btn-save').click(function(){
		$('#btn-save-i').addClass('fa fa-spinner fa-spin');
		setTimeout(function(){
			var form_data = $('#data-form').form_validator('validate');
			if(form_data !== false)
			{
				appAjaxRequest({
					url : BASE_URL + 'index.php/master/operation/operation_save',
					data : {'form_data' : form_data},
					async : false,
					success : function(_serverResponse){
						var response = JSON.parse(_serverResponse);
						appAlertSuccess(response['message'],function(){
							window.open(BASE_URL + 'index.php/master/operation/operation_view/' + response['operation_id'] , '_self');
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
				'operation_id' : {
					key : 'operation_id',
					required : true
				},
				'operation_name' : {
					required : true,
					key : 'operation_name',
					remote : {
						url : BASE_URL + 'index.php/master/operation/is_operation_code_exists',
						data : {'operation_id' : OPERATION_ID}
					}
				},
				'operation_type' : {
					required : true
				},
				'uom_in' : {
					required : true
				},
				'uom_out' : {
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

})();
