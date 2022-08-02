(function(){

	var BASE_URL = null;
	var DES_ID = 0;

	 $(document).ready(function(){

		BASE_URL = $('#base-url').val();
		DES_ID = $('#des_id').val();

		initialize_form_validator();

	 });


	$('#btn-save').click(function(){
		$('#btn-save-i').addClass('fa fa-spinner fa-spin');
		setTimeout(function(){
			var form_data = $('#data-form').form_validator('validate');
			if(form_data !== false)
			{
				appAjaxRequest({
					url : BASE_URL + 'index.php/master/designation/designation_save',
					data : {'form_data' : form_data},
					async : false,
					success : function(_serverResponse){
						var response = JSON.parse(_serverResponse);
						appAlertSuccess(response['message'],function(){
							window.open(BASE_URL + 'index.php/master/designation/designation_view/' + response['des_id'] , '_self');
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
				'des_id' : {
					required : true
				},
				'designation' : {
					required : true,
					remote : {
						url : BASE_URL + 'index.php/master/designation/is_designation_exists',
						data : {'des_id' : DES_ID}
					}
				},
				'des_active' : {
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
