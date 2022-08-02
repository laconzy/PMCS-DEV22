(function(){

	var BASE_URL = null;
	var COLOR_ID = 0;

	 $(document).ready(function(){

		BASE_URL = $('#base-url').val();
		COLOR_ID = $('#color-id').val();

		initialize_form_validator();

	 });


	$('#btn-save').click(function(){
		$('#btn-save-i').addClass('fa fa-spinner fa-spin');
		setTimeout(function(){
			var form_data = $('#data-form').form_validator('validate');
			if(form_data !== false)
			{
				appAjaxRequest({
					url : BASE_URL + 'index.php/master/colour/color_save',
					data : {'form_data' : form_data},
					async : false,
					success : function(_serverResponse){
						var response = JSON.parse(_serverResponse);
						appAlertSuccess(response['message'],function(){
							window.open(BASE_URL + 'index.php/master/colour/color_view/' + response['color_id'] , '_self');
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
				'color-id' : {
					key : 'color_id',
					required : true
				},
				'color-code' : {
					required : true,
					remote : {
						url : BASE_URL + 'index.php/master/colour/is_color_code_exists',
						data : {'color_id' : COLOR_ID}
					}
				},
				'color-name' : {
					required : true
				},
				'color-active' : {
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
