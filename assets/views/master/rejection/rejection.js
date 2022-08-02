(function(){

	var BASE_URL = null;
	var REJ_ID = 0;

	 $(document).ready(function(){

		BASE_URL = $('#base-url').val();
		REJ_ID = $('#id').val();

		initialize_form_validator();

	 });


	$('#btn-save').click(function(){
		$('#btn-save-i').addClass('fa fa-spinner fa-spin');
		setTimeout(function(){
			var form_data = $('#data-form').form_validator('validate');
			if(form_data !== false)
			{
				appAjaxRequest({
					url : BASE_URL + 'index.php/master/rejection/rejection_save',
					data : {'form_data' : form_data},
					async : false,
					success : function(_serverResponse){
						var response = JSON.parse(_serverResponse);
						appAlertSuccess(response['message'],function(){
							window.open(BASE_URL + 'index.php/master/rejection/rejection_view/' + response['id'] , '_self');
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
				'id' : {
					key : 'id',
					required : true
				},
				'rejection_name' : {
					required : true,
					key : 'rejection_name',
					remote : {
						url : BASE_URL + 'index.php/master/rejection/is_rejection_type_exists',
						data : {'id' : REJ_ID}
					}
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
