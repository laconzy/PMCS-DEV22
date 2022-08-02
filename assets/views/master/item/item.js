(function(){

	var BASE_URL = null;
	var ITEM_ID = 0;

	 $(document).ready(function(){

			BASE_URL = $('#base-url').val();
			ITEM_ID = $('#item_id').val();

			initialize_form_validator();

			$("#item_component").select2({
				ajax: {
					url: BASE_URL + 'index.php/master/component/search',
					dataType: 'json'
					// Additional AJAX parameters go here; see the end of this chapter for the full code of this example
				}
			});


			if(ITEM_ID > 0){
				load_components(ITEM_ID);
			}


	 });


	$('#btn-save').click(function(){
		$('#btn-save-i').addClass('fa fa-spinner fa-spin');
		setTimeout(function(){
			var form_data = $('#data-form').form_validator('validate');
			if(form_data !== false)
			{
				appAjaxRequest({
					url : BASE_URL + 'index.php/master/item/item_save',
					data : {'form_data' : form_data},
					async : false,
					success : function(_serverResponse){
						var response = JSON.parse(_serverResponse);
						appAlertSuccess(response['message'],function(){
							window.open(BASE_URL + 'index.php/master/item/item_view/' + response['item_id'] , '_self');
						});
					}
				});
			}
			else{
				$('#btn-save-i').removeClass('fa fa-spinner fa-spin');
			}
		},500);
	});


	$('#btn-add').click(function(){
			var com_id = $('#item_component').val();
			if(com_id != null && com_id != '') {
				appAjaxRequest({
					url : BASE_URL + 'index.php/master/item/add_item_component',
					type : 'POST',
					data : {
						'item_id' : ITEM_ID,
						'component_id' : com_id
					},
					async : false,
					success : function(_res){
						var response = JSON.parse(_res);
						appAlertSuccess(response['message']);
						if(response['status'] == 'success' && response['component'] != null){
								add_data_to_component_table(response['component']);
						}
					}
				});
			}
	});

	$('#item_component').on('select2:select', function (e) {
	  console.table(e.params.data);
	});


	$('#item_component_table').on('click','button', function (e) {
			var ele = $(this);
			var com_id = ele.attr('data-com-id');
			appAlertConfirm('Do you want to delete selected component?' , function(){
				appAjaxRequest({
					url : BASE_URL + 'index.php/master/item/delete_item_component',
					type : 'POST',
					data : {
						'item_id' : ITEM_ID,
						'component_id' : com_id
					},
					async : false,
					success : function(_res){
						var response = JSON.parse(_res);
						appAlertSuccess(response['message']);
						if(response['status'] == 'success'){
								ele.parent().parent().remove();
						}
					}
				});
			});
	});


	function add_data_to_component_table(com_data){
		var str = '<tr> \
		<td>'+com_data['com_code']+'</td> \
		<td>'+com_data['com_description']+'</td> \
		<td> <button class="btn btn-danger btn-xs" data-com-id="'+com_data['com_id']+'">Delete</button> </td> \
		</tr>';
		$('#item_component_table tbody').append(str);
	}


    function initialize_form_validator(){
		$('#data-form').form_validator({
			events : ['blur'],
			fields : {
				'item_id' : {
					key : 'item_id',
					required : true
				},
				'item_code' : {
					required : true,
					remote : {
						url : BASE_URL + 'index.php/master/item/is_item_code_exists',
						data : {'item_id' : ITEM_ID}
					}
				},
				'item_description' : {
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


function load_components(item_id){
	appAjaxRequest({
		url : BASE_URL + 'index.php/master/item/get_item_components',
		type : 'GET',
		data : {
			'item_id' : item_id
		},
		async : false,
		success : function(_res){
			var response = JSON.parse(_res);
			if(response != null && response != ''){
				var str = '';
				for(var x = 0 ; x < response.length ; x++){
					str += '<tr> \
					<td>'+response[x]['com_code']+'</td> \
					<td>'+response[x]['com_description']+'</td> \
					<td> <button class="btn btn-danger btn-xs" data-com-id="'+response[x]['com_id']+'">Delete</button> </td> \
					</tr>';					
				}
				$('#item_component_table tbody').html(str);
			}
		}
	});
}


})();
