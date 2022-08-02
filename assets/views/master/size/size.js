(function(){

	var BASE_URL = null;
	var SIZE_ID = 0;

	 $(document).ready(function(){

		BASE_URL = $('#base-url').val();
		SIZE_ID = $('#size-id').val();

		initialize_form_validator();

	 });


	$('#btn-save').click(function(){
		$('#btn-save-i').addClass('fa fa-spinner fa-spin');
		setTimeout(function(){
			var form_data = $('#data-form').form_validator('validate');
			if(form_data !== false)
			{
				appAjaxRequest({
					url : BASE_URL + 'index.php/master/size/size_save',
					data : {'form_data' : form_data},
					async : false,
					success : function(_serverResponse){
						var response = JSON.parse(_serverResponse);
						appAlertSuccess(response['message'],function(){
							window.open(BASE_URL + 'index.php/master/size/size_view/' + response['size_id'] , '_self');
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
				'size-id' : {
					key : 'size_id',
					required : true
				},
				'size-code' : {
					required : true,
					remote : {
						url : BASE_URL + 'index.php/master/size/is_size_code_exists',
						data : {'size_id' : SIZE_ID}
					}
				},
				'size-name' : {
					required : true
				},
				'size-active' : {
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
