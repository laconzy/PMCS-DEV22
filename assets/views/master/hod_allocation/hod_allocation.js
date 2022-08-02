(function(){

	var BASE_URL = null;
	var ID = 0;

	 $(document).ready(function(){

		BASE_URL = $('#base-url').val();
		ID = $('#id').val();

		initialize_form_validator();

		$("#user_id").select2({
			ajax: {
				url: BASE_URL + 'index.php/user/search',
				dataType: 'json'
			}
		});

		if(ID != 0){
			let user_id = $('#user_id_hidden').val();
			let full_name = $('#user_full_name_hidden').val();
			$("#user_id").empty().append(`<option value="${user_id}">${full_name}</option>`).val(user_id).trigger('change');
		}

	 });


	$('#btn-save').click(function(){
		$('#btn-save-i').addClass('fa fa-spinner fa-spin');
		setTimeout(function(){
			var form_data = $('#data-form').form_validator('validate');
			if(form_data !== false)
			{
				appAjaxRequest({
					url : BASE_URL + 'index.php/master/hod_allocation/allocate_hod',
					data : {'form_data' : form_data},
					async : false,
					dataType : 'json',
					success : function(res){
						if(res.status == 'success'){
							appAlertSuccess(res.message, function(){
								window.open(BASE_URL + 'index.php/master/hod_allocation/hod_allocation_view/' + res.id , '_self');
							});
						}
						else {
							appAlertError(res.message);
						}
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
					required : false
				},
				'site_id' : {
					key : 'site_id',
					required : true
				},
				'department_id' : {
					required : true,
				},
				'user_id' : {
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
