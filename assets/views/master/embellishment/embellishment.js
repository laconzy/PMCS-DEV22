(function(){

	var BASE_URL = null;
	var EMB_ID = 0;

	 $(document).ready(function(){

		BASE_URL = $('#base-url').val();
		EMB_ID = $('#emb_id').val();

		initialize_form_validator();

	 });


	$('#btn-save').click(function(){
		$('#btn-save-i').addClass('fa fa-spinner fa-spin');
		setTimeout(function(){
			var form_data = $('#data-form').form_validator('validate');
			if(form_data !== false)
			{
				appAjaxRequest({
					url : BASE_URL + 'index.php/master/embellishment/embellishment_save',
					data : {'form_data' : form_data},
					async : false,
					success : function(_serverResponse){
						var response = JSON.parse(_serverResponse);
						appAlertSuccess(response['message'],function(){
							window.open(BASE_URL + 'index.php/master/embellishment/embellishment_view/' + response['emb_id'] , '_self');
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
				'emb_id' : {
					key : 'emb_id',
					required : true
				},
				'emb_name' : {
					required : true,
					key : 'emb_name',
					remote : {
						url : BASE_URL + 'index.php/master/embellishment/is_embellishment_type_exists',
						data : {'emb_id' : EMB_ID}
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
