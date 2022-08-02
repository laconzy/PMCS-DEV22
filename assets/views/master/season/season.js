(function(){

	var BASE_URL = null;
	var SEASON_ID = 0;

	 $(document).ready(function(){

		BASE_URL = $('#base-url').val();
		SEASON_ID = $('#season_id').val();

		initialize_form_validator();

	 });


	$('#btn-save').click(function(){
		$('#btn-save-i').addClass('fa fa-spinner fa-spin');
		setTimeout(function(){
			var form_data = $('#data-form').form_validator('validate');
			if(form_data !== false)
			{
				appAjaxRequest({
					url : BASE_URL + 'index.php/master/season/season_save',
					data : {'form_data' : form_data},
					async : false,
					success : function(_serverResponse){
						var response = JSON.parse(_serverResponse);
						appAlertSuccess(response['message'],function(){
							window.open(BASE_URL + 'index.php/master/season/season_view/' + response['season_id'] , '_self');
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
				'season_id' : {
					key : 'season_id',
					required : true
				},
				'season_name' : {
					required : true,
					key : 'season_name',
					remote : {
						url : BASE_URL + 'index.php/master/season/is_season_code_exists',
						data : {'season_id' : SEASON_ID}
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
