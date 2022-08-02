(function(){

	var BASE_URL = null;
	var LINE_ID = 0;

	 $(document).ready(function(){

		BASE_URL = $('#base-url').val();
		LINE_ID = $('#line_id').val();

		initialize_form_validator();

	 });


	$('#btn-save').click(function(){
		$('#btn-save-i').addClass('fa fa-spinner fa-spin');
		setTimeout(function(){
			var form_data = $('#data-form').form_validator('validate');
			if(form_data !== false)
			{
				appAjaxRequest({
					url : BASE_URL + 'index.php/master/line/line_save',
					data : {'form_data' : form_data},
					async : false,
					success : function(_serverResponse){
						var response = JSON.parse(_serverResponse);
						appAlertSuccess(response['message'],function(){
							window.open(BASE_URL + 'index.php/master/line/line_view/' + response['line_id'] , '_self');
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
				'line_id' : {
					key : 'line_id',
					required : true
				},
				'location' : {
					key : 'location',
					required : true
				},
				'line_code' : {
					required : true,
					remote : {
						url : BASE_URL + 'index.php/master/line/is_line_code_exists',
						data : {'line_id' : LINE_ID}
					}
				},
				'section' : {
					key : 'section',
					required : true
				},
				'seq' : {
					key : 'seq',
					notRequired : true
				},
				'category' : {
					key : 'category',
					required : true
				},
				'double_shift' : {
					key : 'double_shift',
					checkbox : {
						checkValue : 1,
						uncheckValue : 0
					}
				},
				'line_active' : {
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
