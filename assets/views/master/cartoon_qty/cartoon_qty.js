(function(){

	var BASE_URL = null;
	var QTY_ID = 0;

	 $(document).ready(function(){

		BASE_URL = $('#base-url').val();
		QTY_ID = $('#qty-id').val();

		initialize_form_validator();

	 });


	$('#btn-save').click(function(){
		$('#btn-save-i').addClass('fa fa-spinner fa-spin');
		setTimeout(function(){
			var form_data = $('#data-form').form_validator('validate');
			if(form_data !== false)
			{
				appAjaxRequest({
					url : BASE_URL + 'index.php/master/cartoon_qty/cartoon_qty_save',
					data : {'form_data' : form_data},
					async : false,
					success : function(_serverResponse){
						var response = JSON.parse(_serverResponse);
						appAlertSuccess(response['message'],function(){
							window.open(BASE_URL + 'index.php/master/cartoon_qty/cartoon_qty_view/' + response['qty_id'] , '_self');
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
				'qty-id' : {
					key : 'qty_id',
					required : true
				},
				'qty' : {
					required : true,
					remote : {
						url : BASE_URL + 'index.php/master/cartoon_qty/is_cartoon_qty_exists',
						data : {'qty_id' : QTY_ID}
					}
				},
				'cartoon-qty-active' : {
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
