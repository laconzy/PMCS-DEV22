(function(){


	var BASE_URL = null;
	var STYLE_ID = 0;

	 $(document).ready(function(){
		BASE_URL = $('#base-url').val();
		STYLE_ID = $('#style-id').val();
		initialize_form_validator();
	 });


	$('#btn-save').click(function(){
		$('#btn-save-i').addClass('fa fa-spinner fa-spin');
		setTimeout(function(){
			var form_data = $('#data-form').form_validator('validate');
			if(form_data !== false)
			{
				appAjaxRequest({
					url : BASE_URL + 'index.php/master/style/style_save',
					data : {'form_data' : form_data},
					async : false,
					success : function(_serverResponse){
						var response = JSON.parse(_serverResponse);
						appAlertSuccess(response['message'],function(){
							window.open(BASE_URL + 'index.php/master/style/style_view/' + response['style_id'] , '_self');
						});
					}
				});
			}
			else{
				$('#btn-save-i').removeClass('fa fa-spinner fa-spin');
			}
		},500);
	});



	$('#btn_add_operation').click(function(){
		appAjaxRequest({
			url : BASE_URL + 'index.php/master/style/add_operation',
			type: 'POST',
			dataType : 'json',
			data : {
				'style_id' : STYLE_ID ,
				'operation' : $('#operation').val()
			},
			success : function(res){
				if(res['status'] == 'success') {
					load_operations(res.operations);
				}
				else {
					appAlertError(res.message);
				}
			},
			error : function(err){
				alert(err);
			}
		});
	});


	$('#operation_table tbody').on('click','button',function(){
	  var ele = $(this);
	  remove_operation(STYLE_ID , ele.attr('data-id'),  ele.attr('data-seq'));
	  ele.parent().parent().remove();
	})


	function load_operations(data){
		let str = '';
		for(let x = 0 ; x < data.length ; x++){
			str += '<tr>';
			str += '<td>' + data[x]['operation_name'] + '</td>';
			str += '<td>' + data[x]['operation_order'] + '</td>';
			str += '<td> <button class="btn btn-danger btn-xs" data-id="'+data[x]['operation_id']+'" data-seq="'+data[x]['operation_order']+'">Delete</button> </td>';
			str += '</tr>';
		}
		$('#operation_table tbody').html(str);
	}


	function remove_operation(style_id, operation, seq){
	  appAjaxRequest({
	    url : BASE_URL + 'index.php/master/style/remove_operation',
	    type : 'POST',
			data : {
				'style_id' : style_id,
				'operation_id' : operation,
				'seq' : seq
			},
	    async : false,
	    dataType : 'json',
	    success : function(res){
				if(res.status == 'success'){
					load_operations(res.operations);
				}
				else {
					appAlertError('Error occured while deleteing operation');
				}
	    },
	    error : function(err){
	      console.log(err);
	    }
	  });
	}



    function initialize_form_validator(){

		$('#data-form').form_validator({

			events : ['blur'],

			fields : {

				'style-id' : {

					key : 'style_id',

					required : true

				},

				'style-code' : {

					required : true,

					remote : {

						url : BASE_URL + 'index.php/master/style/is_style_code_exists',

						data : {'style_id' : STYLE_ID}

					}

				},


				'style-name' : {

					required : true

				},
				'style_cat' : {

					required : true

				},
				'item_id' : {
					required : true
				},

				'style-active' : {

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
