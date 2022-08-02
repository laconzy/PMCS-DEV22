(function(){
	
	var BASE_URL = null;
	var SITE_ID = 0;
	
	 $(document).ready(function(){
		 
		BASE_URL = $('#base-url').val();
		SITE_ID = $('#site-id').val();
		 
		initialize_form_validator();	
		 
	 });
	 
	 
	$('#btn-save').click(function(){		
		$('#btn-save-i').addClass('fa fa-spinner fa-spin');	
		setTimeout(function(){		
			var form_data = $('#data-form').form_validator('validate'); 
			if(form_data !== false)
			{
				appAjaxRequest({
					url : BASE_URL + 'index.php/master/site/site_save',
					data : {'form_data' : form_data},
					async : false,
					success : function(_serverResponse){						
						var response = JSON.parse(_serverResponse);
						appAlertSuccess(response['message'],function(){
							window.open(BASE_URL + 'index.php/master/site/site_view/' + response['site_id'] , '_self'); 
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
				'site-id' : {
					key : 'id',
					required : true
				},
				'site-code' : {
					required : true,
					remote : {
						url : BASE_URL + 'index.php/master/site/is_site_code_exists',
						data : {'site_id' : SITE_ID}
					}
				},
				'description' : {
					notRequired : true
				},
				'site-name' : {
					required : true
				},
				'site-other' : {
					notRequired : true
				},
				'address-line1' : {
					required : true
				},
				'address-line2' : {
					notRequired : true
				},
				'city' : {
					required : true
				},
				'state' : {
					required : true
				},
				'country' : {
					required : true
				},
				'email' : {
					notRequired : true
				},
				'phone1' : {
					notRequired : true
				},
				'phone2' : {
					notRequired : true
				},
				'site-active' : {
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