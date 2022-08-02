(function () {

    function initialize_form_validator() {

        var form = {
            events: ['blur'],
            fields: {

                'mdl-style': {
                    'key': 'style',
                    'required': {
                        'errorMessage': 'Style cannot be empty'
                    }
                },
                'mdl-color': {
                    'key': 'color',
                    'required': {
                        'errorMessage': 'Style cannot be empty'
                    }
                },
                'mdl-cut-plan-id': {
                    'key': 'cut_plan_id',

                },
                'mdl-order-id': {
                    'key': 'prod_ord_detail_id',
                    'required': {
                        'errorMessage': 'Style cannot be empty'
                    }
                }, 'mdl-lyers': {
                    'key': 'plies',
                    'required': {
                        'errorMessage': 'layers cannot be empty'
                    }
                },
                'item-id': {
                    'key': 'item_id'


                },
                 'mdl-comp': {
                    'key': 'cmp_id'


                }

            }
        }
        $('#myModal5').form_validator(form);
    }



    $(document).ready(function () {
        initialize_form_validator();
        $('#cutplan-id').keypress(function (e) {
            if (e.which == 13) {//Enter key pressed
                load_data();//Trigger search button click event
            }
        });

        $('#05-btn-save').click(function () {
            load_data()
        });
        $('#myModal5').on('show.bs.modal', function (e) {
            button = $(e.relatedTarget);
            setTableData('', 'mdl-tbl-ratio');
            get_model_data(button);
			load_saved_cut_plan(button.data('gruopid'),button.data('cmp'))
        });

		$("#style").select2({
          ajax: {
            url: BASE_URL + 'index.php/master/style/search',
            dataType: 'json'
          }
        });


    });
	
	function load_saved_cut_plan(order_details_id,component_id) {
		
		//console.log(order_details_id);
		//console.log(component_id);
		
		appAjaxRequest({
            url: BASE_URL + 'index.php/cut_plan/load_saved_cut_plans',
            'data': {'order_details_id': order_details_id, 'component_id': component_id},
			async: false,
            success: function (response) {
                try {

                    var obj = JSON.parse(response);
					load_cut_list = obj['data']['load_cut_list'];
                   // if (obj != undefined && obj != null)
				   
				   for(var y = 0 ; y < load_cut_list.length ; y++)
							{
                    $("#saved_cut_plan_id").append('<option value=' + load_cut_list[y]['cut_plan_id'] + '>' + load_cut_list[y]['cut_plan_id'] + '</option>');
							}
				
				
				

					

                } catch (e) {
                    console.log(e);
                }
            }
        });
		
	}
	
	
    function get_model_data(button) {
		
		

        //clear rows in modele
        setTableData('', 'size-table');
        $("#mdl-order-id").val(button.data('gruopid'));
        $("#item-id").val(button.data('item'));
        $("#mdl-comp").val(button.data('cmp'));
       //alert(button.data('item'))
        $("#mdl-yds").val(0);
        var cut_plan_id = $('#mdl-cut-plan-id').val();
        item_id=button.data('item');
        appAjaxRequest({
            url: BASE_URL + 'index.php/cut_plan/prod_ord_details',
            'data': {'prod_ord_detail_id': button.data('gruopid'), 'cut_plan_id': cut_plan_id,item_id:item_id,cmp_id:button.data('cmp')},
			async: false,
            success: function (response) {
                try {

                    var obj = JSON.parse(response);
                    if (obj != undefined && obj != null)
                        data = obj['data']['detail'][0];
                    size_data = obj['data']['size_data'];				

                    appSetFormData([
						{id: 'mdl-style', value: data['style']},
						{id: 'mdl-style2', value: data['style_code']},
						{id: 'mdl-color', value: data['color']},
						{id: 'mdl-color2', value: data['color_code']},
						{id: 'mdl-cpo', value: data['customer_po']}
					]);

					// load data gird
                    for (var i = 0; i < size_data.length; i++) {
                        $('#size-table').append(
							'<tr>' +
							'<td>' + size_data[i]['prod_ord_size'] + '</td>' +
							'<td class="col-md-2" ><div><input type="text"   class="form-control input-sm" placeholder="" id="' + size_data[i]['prod_ord_size'] + '" value="0"></div></td>' +
							'<td></td>' +
							'<td>' + size_data[i]['prod_ord_plan_qty'] + '</td>' +
							'<td id="mdl-' + size_data[i]['prod_ord_size'] + '">' + /*size_data[i]['cut_plan_qty']*/0 + '</td>' +
							'<td id="mdl-qty-' + size_data[i]['prod_ord_size'] + '" >0</td>' +
							'<td style="display:none">'+size_data[i]['size']+'</td>' +
							'</tr>');
                    }

                } catch (e) {
                    console.log(e);
                }
            }
        });

    }
    function loadModel(modelName, data) {

        return ActionButton = '<div class="btn-group">' +
			'<button data-toggle="dropdown" class="btn btn-default btn-sm dropdown-toggle" >Action <span class="caret"></span></button>' +
			'<ul class="dropdown-menu">' +
			'<li ><a data-toggle="modal"  data-cmp="' + data['item_component'] + '" data-item="' + data['item_id'] + '" data-target="#' + modelName + '" data-gruopid="' + data['order_detail_id'] + '">create cut plan</a></li>' +
			/*'<li><a href="#">edit cut plan</a></li>' +*/
			/*'<li><a href="#">copy cut plan</a></li>' +*/
			/*'<li class="divider"></li>' +*/
			/*'<li><a href="#">Separated link</a></li>' +*/
			'</ul>' +
			'</div>';

    }



    function load_data() {
        var ord_id = $('#cutplan-id').val();
        appAjaxRequest({
            url: BASE_URL + 'index.php/cut_plan/get_cutplan_data',
            data: {id: "user_id", ord_id: ord_id},
			async: false,
            success: function (response) {
                try {
                    var obj = JSON.parse(response);

                    if (obj != undefined && obj != null)
                        data = obj['data']['head'];
                    detail = obj['data']['detail'];

                    appSetFormData([
						{id: 'cutplan-id', value: data['order_id']},
						{id: 'color', value: data['color_code']},
						{id: 'order-code', value: data['order_code']},
						{id: 'cpo', value: data['customer_po']},
						{id: 'style', value: data['style_code']},
						{id: 'style-desc', value: data['style_name']},
						{id: 'site', value: data['site']},
						{id: 'sales-qty', value: data['sales_qty']},
						/*{id: 'season', value: data['season']},*/
						{id: 'oreder-qty', value: data['oreder_qty']},
						{id: 'customer-code', value: data['cus_name']},
						{id: 'season', value: data['season_name']},
                    ]);
					//console.log(detail)
                    for (var i = 0; i < obj['data']['detail'].length; i++) {
                        $('#component').append(
							'<tr>' +
							'<td>' + detail[i]['item_code'] + '</td>' +
							'<td>' + detail[i]['item_description'] + '</td>' +
							'<td>' + detail[i]['com_code'] + '</td>' +
							'<td>' + detail[i]['color_code'] + '</td>' +
							'<td>' + /*detail[i]['color_code']*/1 + '</td>' +
							'<td>' + loadModel('myModal5', detail[i]) +
							'</td></tr>');
                    }

                } catch (e)
                {
                    console.log(e);
                }
            }
        });
    }
	
	
	
	$("#saved_cut_plan_id").on("change", function() {
		
		var order_id = $('#mdl-order-id').val();
		
        //alert( order_id );
		var table = $("#size-table tbody");
		
		
		appAjaxRequest({
                url: BASE_URL + 'index.php/cut_plan/load_save_cut_plan_ratio',
                'data': {'cp_number': this.value,'order_id': order_id},
				async: false,
                success: function (response) {
                    var obj = JSON.parse(response);
					console.log(obj);
                    if (obj != undefined && obj != null)

                    var data = obj['data']['cut_plan_id'];
                    var detail = obj['data']['detail'];
                    var size_data_grid = obj['data']['order_size_data'];
				
                    appSetFormData( [ {id: 'mdl-cut-plan-id', value: data}, ] );

                    $('#mdl-lyers').val(0);
                    $('#mdl-yds').val('0');
                    $('#mdl-mkrRef').val(null);
                    $('#mdl-width').val(null);

                    table.find('tr').each(function (i) {
                    var fieldset = $(this);
                    $('input:text:eq(0)', fieldset).val(0);
                    });

				    $('#mdl-btn-ratio').attr("disabled", false);

                    setTableData('', 'mdl-tbl-ratio');

					var k = 0;
                    for (var i = 0; i < detail.length; i++) {
					var k = i+1;
						
					if( k == detail['length'])
						{ var rem_button = '<button class="btn btn-danger btn-xs" onclick="remove_cut_plan('+detail[i]['detail_id']+');"><i class="fa fa-remove"></i></button>';}
					else
						{ var rem_button = '';}
									
                    $('#mdl-tbl-ratio').append(
                                '<tr>' +
                                '<td>' + detail[i]['size_code'] + '</td>' +
                                '<td>' + detail[i]['ratio'] + '</td>' +
                                '<td>' + detail[i]['plies'] + '</td>' +
                                '<td>' + (detail[i]['ratio'] * detail[i]['plies']) + '</td>' +
                                '<td>' + detail[i]['marker_ref'] + '</td>' +
                                '<td>' + detail[i]['width'] + '</td>' +
                                '<td>' + detail[i]['line_no'] + '</td>' +
                                '<td>' + detail[i]['width'] + '</td>' +
                                '<td>' + rem_button + '</td>' +
                                '</tr>');
                    }
					
					
					// update cutable size qty
                    for (var i = 0; i < size_data_grid.length; i++) {
                        $("#mdl-" + size_data_grid[i]['prod_ord_size']).html(size_data_grid[i]['cut_plan_qty']);
                        $("#mdl-qty-" + size_data_grid[i]['prod_ord_size']).html(size_data_grid[i]['prod_ord_plan_qty'] - size_data_grid[i]['cut_plan_qty']);
						var check_qty =size_data_grid[i]['prod_ord_plan_qty'] - size_data_grid[i]['cut_plan_qty'];
                        if(check_qty<-2){
							$("#mdl-qty-" + size_data_grid[i]['prod_ord_size']).css("background-color", "red")
						}

                    }
					
					
                    // update_order_qtys(data);

                }
            });

	});
	
	
	
	
	$("#mdl-lyers").on("keyup", function() {
        var plies = parseInt($("#mdl-lyers").val());
		var table = $("#size-table tbody");
		

		
		table.find('tr').each(function (i) {
                var fieldset = $(this);
				$('input:text:eq(0)', fieldset).val(0);
				//console.log($('input:text:eq(0)', fieldset).val());
				
		});
		//alert(plies);
	});
	

		
	
	
    $("#size-table tbody").on("keyup", "input", function (event) {
		var obj = $('#myModal5').form_validator('validate');
        var plies = parseInt($("#mdl-lyers").val());
        var $row = $(this).closest('tr');
        var plan_qty = parseInt($row.find('td').eq(3).text());
        var cmplt_qty = parseInt($row.find('td').eq(4).text());
        
		var balance = plan_qty - (cmplt_qty + plies * parseInt(this.value));
                //system should able to create additional qty due to marker limitation
		//if( balance < 0 )
//			{ 	appAlertError('Remaining Qty less than 0');
//				$row.find('td').eq(5).text(plan_qty - cmplt_qty);
//				$row.find('td').eq(2).text(0);
//				$row.find('td').eq(1).context.value = 0;
//				//document.getElementById($row.find('td').eq(0)).value=0;
//			}else{
				$row.find('td').eq(2).text(plies * parseInt(this.value));
				$row.find('td').eq(5).text(plan_qty - (cmplt_qty + plies * parseInt(this.value)));
			//}
    });



    $("#mdl-btn-ratio").click(function (event) {
		//alert('ok')
        var obj = $('#myModal5').form_validator('validate');
		//console.log(obj);
		//remove unwanted colmn from header obj
        delete obj.plies;

        if (obj !== undefined && obj !== false)
        {
            //get ratio section data
            var cut_plan_id = $('#mdl-cut-plan-id').val();
            var plies = $('#mdl-lyers').val();
			if(plies <= 0 )
				{ 
					appAlertError('Layer can not be empty or zero');
					return true; 
				}
				
            var table = $("#size-table tbody");
            var mkr_ref = $("#mdl-mkrRef").val();
            var marker_legth = $("#mdl-yds").val();
            var width = $("#mdl-width").val();
            var item_id = $("#item-id").val();
            var mdl_cmp = $("#mdl-comp").val();
            // var rowCount = $('#mdl-tbl-ratio tbody tr').length
            // var rowCount = $('#mdl-tbl-ratio tbody tr').length
            var arr = [];
            table.find('tr').each(function (i) {
                var fieldset = $(this);
                //console.log($('input:text:eq(0)', fieldset).val());
                //var obj={};
                var tds = $(this).find('td');
				
				//debugger;
				
				
				
				//if(tds.eq(5).text() < 0 )
				//{ 
				//	appAlertError('Remaining Qty less than 0');
				//	return true; 
				//}
				//console.log("qty<>"+tds.eq(2).text())
				if(parseInt(tds.eq(2).text()) == 0){
					console.log("working");
				}
				if(parseInt(tds.eq(2).text()) != 0) {
					console.log("inqty<>"+tds.eq(2).text())
					var obj_data = {
						'cut_plan_id': cut_plan_id,
						'ratio': $('input:text:eq(0)', fieldset).val(),
						'size': tds.eq(6).text(),
						'qty': tds.eq(2).text(),
						'plies': plies,
						'marker_ref': mkr_ref,
						'marker_legth': marker_legth,
						'width': width,
						'item_id': item_id,
						'mdl_cmp': mdl_cmp
					}
					if(obj_data['qty'] == ''){
						return;
					}

					arr.push(obj_data);
				}
				

				

            });
            
			
			//Disable our button
            $('#mdl-btn-ratio').attr("disabled", true);

            appAjaxRequest({
                url: BASE_URL + 'index.php/cut_plan/save_cut_plan_ratio',
                'data': {'formData': obj, 'ratio': arr},
				async: false,
                success: function (response) {
                    var obj = JSON.parse(response);
                    if (obj != undefined && obj != null)

                    var data = obj['data']['cut_plan_id'];
                    var detail = obj['data']['detail'];
                    var size_data_grid = obj['data']['order_size_data'];
				
                    appSetFormData( [ {id: 'mdl-cut-plan-id', value: data}, ] );

                    // $('#mdl-lyers').val(0);
                    // $('#mdl-yds').val('0');
                    // $('#mdl-mkrRef').val(null);
                    // $('#mdl-width').val(null);

                    table.find('tr').each(function (i) {
                    var fieldset = $(this);
                    //$('input:text:eq(0)', fieldset).val(0);
                    });

				    $('#mdl-btn-ratio').attr("disabled", false);

                    setTableData('', 'mdl-tbl-ratio');

					var k = 0;
                    for (var i = 0; i < detail.length; i++) {
					var k = i+1;
						
					if( k == detail['length'])
						{ var rem_button = '<button class="btn btn-danger btn-xs" onclick="remove_cut_plan('+detail[i]['detail_id']+');"><i class="fa fa-remove"></i></button>';}
					else
						{ var rem_button = '';}
									
                    $('#mdl-tbl-ratio').append(
                                '<tr>' +
                                '<td>' + detail[i]['size_code'] + '</td>' +
                                '<td>' + detail[i]['ratio'] + '</td>' +
                                '<td>' + detail[i]['plies'] + '</td>' +
                                '<td>' + (detail[i]['ratio'] * detail[i]['plies']) + '</td>' +
                                '<td>' + detail[i]['marker_ref'] + '</td>' +
                                '<td>' + detail[i]['width'] + '</td>' +
                                '<td>' + detail[i]['line_no'] + '</td>' +
                                '<td>' + detail[i]['width'] + '</td>' +
                                '<td>' + rem_button + '</td>' +
                                '</tr>');
                    }
					
					
					// update cutable size qty
                    for (var i = 0; i < size_data_grid.length; i++) {
                        $("#mdl-" + size_data_grid[i]['prod_ord_size']).html(size_data_grid[i]['cut_plan_qty']);
                        $("#mdl-qty-" + size_data_grid[i]['prod_ord_size']).html(size_data_grid[i]['prod_ord_plan_qty'] - size_data_grid[i]['cut_plan_qty']);
						var check_qty =size_data_grid[i]['prod_ord_plan_qty'] - size_data_grid[i]['cut_plan_qty'];
						if(check_qty<-2){
							$("#mdl-qty-" + size_data_grid[i]['prod_ord_size']).css("background-color", "red")
						}
                    }
					
					
                    // update_order_qtys(data);

                }
            });
        }
    });


    






//self execution function ends here
})();

function remove_cut_plan(cp_detail_id) {
		
var cut_plan_id = $('#mdl-cut-plan-id').val();

  appAlertConfirm('Do you want to remove this line?' , function(){
    appAjaxRequest({
      url : BASE_URL + 'index.php/cut_plan/destroy_cut_no/'+cp_detail_id,
      type: 'post',
	  async: false,
      dataType : 'json',
      success : function(res){
        if(res.status == 'success'){
          appAlertSuccess(res.message);
		  load_table(cut_plan_id);
		  
        }
        else{
          appAlertError(res.message);
        }
      },
      error : function(err){
        alert(err);
      }
    });
  });

}

function load_table(cut_plan_id) {
	
	appAjaxRequest({
                url: BASE_URL + 'index.php/cut_plan/load_cut_plan_no',
                'data': {'cut_plan_id': cut_plan_id},
				async: false,
                success: function (response) {
                var obj = JSON.parse(response);
				
				
				//console.log(obj['data']['length']);
				
				var detail = obj['data']['detail'];
				var size_data_grid = obj['data']['order_size_data'];
				//console.log(size_data_grid.length);
				if(size_data_grid.length == 0){ $('#myModal5').modal('hide'); }
                    					
                setTableData('', 'mdl-tbl-ratio');
					var k = 0;
                    for (var i = 0; i < detail.length; i++) {
					var k = i+1;
						
					if( k == detail['length'])
						{ var rem_button = '<button class="btn btn-danger btn-xs" onclick="remove_cut_plan('+detail[i]['detail_id']+');"><i class="fa fa-remove"></i></button>';}
					else
						{ var rem_button = '';}
									
                        $('#mdl-tbl-ratio').append(
                                '<tr>' +
                                '<td>' + detail[i]['size'] + '</td>' +
                                '<td>' + detail[i]['ratio'] + '</td>' +
                                '<td>' + detail[i]['plies'] + '</td>' +
                                '<td>' + (detail[i]['ratio'] * detail[i]['plies']) + '</td>' +
                                '<td>' + detail[i]['marker_ref'] + '</td>' +
                                '<td>' + detail[i]['width'] + '</td>' +
                                '<td>' + detail[i]['line_no'] + '</td>' +
                                '<td>' + detail[i]['width'] + '</td>' +
                                '<td>' + rem_button + '</td>' +
                                '</tr>');
                    }
					
					
					// update cutable size qty
                    for (var i = 0; i < size_data_grid.length; i++) {
                        $("#mdl-" + size_data_grid[i]['prod_ord_size']).html(size_data_grid[i]['cut_plan_qty']);
                        $("#mdl-qty-" + size_data_grid[i]['prod_ord_size']).html(size_data_grid[i]['prod_ord_plan_qty'] - size_data_grid[i]['cut_plan_qty']);

                    }
					
				

                }
            });
	
}


