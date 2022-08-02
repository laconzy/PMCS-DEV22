(function(){

	var BASE_URL = null;
	var COMPONENT_ID = 0;

	 $(document).ready(function(){

		BASE_URL = $('#base-url').val();
		COMPONENT_ID = $('#com_id').val();

		initialize_form_validator();

	 });


	$('#btn-save').click(function(){
		$('#btn-save-i').addClass('fa fa-spinner fa-spin');
		setTimeout(function(){
			var form_data = $('#data-form').form_validator('validate');
			if(form_data !== false)
			{
				appAjaxRequest({
					url : BASE_URL + 'index.php/master/component/component_save',
					data : {'form_data' : form_data},
					async : false,
					success : function(_serverResponse){
						var response = JSON.parse(_serverResponse);
						appAlertSuccess(response['message'],function(){
							window.open(BASE_URL + 'index.php/master/component/component_view/' + response['component_id'] , '_self');
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
				'com_id' : {
					key : 'com_id',
					required : true
				},
				'com_code' : {
					required : true,
					remote : {
						url : BASE_URL + 'index.php/master/component/is_component_code_exists',
						data : {'com_id' : COMPONENT_ID}
					}
				},
				'com_description' : {
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
