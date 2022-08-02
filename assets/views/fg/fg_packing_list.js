(function () {

	var LAYSHEET_NO = 0;

	var LAYSHEET = null;

	var CUT_PLAN = null;

	$(document).ready(function () {

		$('#btn_laysheet_search').click(function () {
//alert(1)
		var po = $('#laysheet_no').val();
//alert(ls_no)
			//return false;
			if (po != '') {

				LAYSHEET = null;

				CUT_PLAN = null;

				reload_summery_table(po);

			//	load_bundle_chart(ls_no);

		}

	});




$('#summery_table tbody').on('click', 'button', function () {

	var ele = $(this);
		//alert('ok');

		var line_id = ele.attr('data-id');
		var order_id = ele.attr('data-order-id');
		var color_id = ele.attr('data-color-id');
		var size_id = ele.attr('data-size-id');
		var id = $('#pack').val();
		var pcs_per_ctn = $('#a'+line_id).val();
		var ctn_qty = $('#b'+line_id).val();
		var total_qty = $('#c'+line_id).val();
		var net_weight = $('#f'+line_id).val();
		var site = $('#myselect').val();
		var po = $('#customer_po').val();
		if(id == "" || id == null){
		appAlertError("Please Save the Header first!");
		return;
		}
		var data = {
			"line_id": line_id,
			"order_id": order_id,
			"color_id": color_id,
			"size_id": size_id,
			"id": id,
			"pcs_per_ctn": pcs_per_ctn,
			"ctn_qty": ctn_qty,
			"total_qty": total_qty,
			"site": site,
			"net_weight": net_weight,
			"site": site
		}

		appAlertConfirm('Do you want to Add selected size?', function () {

			appAjaxRequest({

				url: BASE_URL + 'index.php/fg/fg_inventory/save_details',

				type: 'post',
				data: data,

				dataType: 'json',

				success: function (res) {
			if (res.status == 'Success') {

						load_bundle_chart(res.id);
						reload_summery_table(po);
						

					}
					if(res.status == 'error'){

						appAlertError(res.message);

					}

				},

				error: function (err) {

					alert(err);

				}

			});

		});

	});
$("#summery_table tbody").on("keyup", "input", function (event) {
	
	var ele = $(this);

	var no = ele.attr('data-id');
	var name = ele.attr('data-name');
	value= ele.val();
	val1=parseInt($('#a'+ no).val());
	val2=parseInt($('#b'+ no).val());
	availble=parseInt($('#e'+ no).val());


	if(name == 'pcs' || name == 'ctn_qty'){
//alert(ele.val())
var total= val2*val1;
if(total>availble){
$('#a'+ no).val(0);
$('#b'+ no).val(0);
$('#c'+ no).val(0);

}else{
	$('#c'+ no).val(total);
}

}


			//}
		});

function initialize_form_validator() {

    $('#data-form').form_validator({

        events : ['blur'],

        fields : {

            'customer_po' : {

              'key' : 'customer_po'

            },

            'container' : {

                'key' : 'container',

                'required': {

                    'errorMessage' : 'Container No cannot be empty'

                }

            },

           'myselect' : {

               'key' : 'myselect',

               'required': {

                   'errorMessage' : 'SMV cannot be empty'

               }

           },

       }



  });

}

$('#btn_save').click(function () {

	
	var customer_po = $('#customer_po').val();
	var style = $('#style').val();
	var container = $('#container').val();
	var ref_1 = $('#ref_1').val();
	var ref_2 = $('#ref_2').val();
	var ref_3 = $('#ref_3').val();
	var id = $('#pack').val();
	var site = parseInt($('#site').val());


	if(customer_po == "" || customer_po == null){
		appAlertError("No PO Available!");
		return;
	}

		if(container == "" || container == null){
		appAlertError("Enter the Container No");
		return;
	}

	if(site == 0 ){
		appAlertError("Enter the Site!");
		return;
	}


	var data = {

		'customer_po' : customer_po,

		'style' : style,

		'container' : container,

		'ref_1' : ref_1,

		'ref_2' : ref_2,

		'ref_3' : ref_3,
		'id' : id

	}
	appAlertConfirm('Do you want to Create Packing List?', function () {

		appAjaxRequest({

			url: BASE_URL + 'index.php/fg/fg_inventory/save',

			type: 'post',

			data: data,

			dataType: 'json',

			success: function (res) {

				if (res.status == 'success') {



							//$('#bundle_chart_table tbody').html('');

							appAlertSuccess(res.message);

						//	reload_summery_table(LAYSHEET_NO);
					//LAYSHEET = res.id;
				}
				appFillFormData({

					pack: res.id

				});

			},

			error: function (err) {

				alert(err);

			}

		});

	});

});


$('#btn_delete_all').click(function () {

	appAlertConfirm('Do you want to delete all bundles?', function () {

		appAjaxRequest({

			url: BASE_URL + 'index.php/cutting/bundle/destroy_all/' + LAYSHEET_NO,

			type: 'post',

			dataType: 'json',

			success: function (res) {

				if (res.status == 'success') {

					$('#bundle_chart_table tbody').html('');

					appAlertSuccess(res.message);

					reload_summery_table(LAYSHEET_NO);

				}

			},

			error: function (err) {

				alert(err);

			}

		});

	});

});





$('#btn_print').click(function () {

	if (LAYSHEET != null) {

		window.open(BASE_URL + 'index.php/cutting/bundle/print_bundlechart/' + LAYSHEET.pack);

	}

});





$('#print_report').click(function () {

	var pack = $('#pack').val();

	window.open(BASE_URL + 'index.php/fg/fg_inventory/packing_list_print/' + pack);

	//}

});





});





function    reload_summery_table(po) {
//alert(2)
appAjaxRequest({

	url: BASE_URL + 'index.php/fg/fg_inventory/get_order_details/' + po,

	type: 'get',

	dataType: 'json',

	success: function (res) {

		if (res != null && res != '') {

			var laysheet = res.order_details;

			var order = res.order_details;



			//LAYSHEET = laysheet;

			LAYSHEET_NO = laysheet.laysheet_no;

			CUT_PLAN = res.cut_plan;


					// alert(laysheet.style_code)
					appFillFormData({

						style: laysheet[0].style_code,
						customer_po: laysheet[0].customer_po,
						color: laysheet[0].color_name,
						pcd_date: laysheet[0].pcd_date,
						customer: laysheet[0].cus_name,
//


});



					var str = '';

					for (var x = 0; x < order.length; x++) {

						str += '<tr>';

						str += '<td id="' + order[x]['item'] + '">' + order[x]['item_code'] + '</td>';

						str += '<td id="' + order[x]['item_color'] + '">' + order[x]['color_code'] + '</td>';

						str += '<td id="' + order[x]['size'] + '">' + order[x]['size_code'] + '</td>';
						str += '<td id="' + order[x]['size'] + '">' + order[x]['order_qty'] + '</td>';

						str += '<td><input type="number" data-id="'+x+'"  data-name="pcs"  id="a' + x + '" style="width:70px;" class="email-input"></td>';
						str += '<td><input type="number"  data-id="'+x+'" data-name="ctn_qty" id="b' + x + '" style="width:70px;" ></td>';
						str += '<td><input type="number"  data-id="'+x+'" data-name="total" id="c' + x + '" style="width:70px;" ></td>';
						str += '<td><input type="number"  data-id="'+x+'" id="e' + x + '" style="width:70px;" value="'+order[x]['available_qty']+'" ></td>';
						str += '<td><input type="number"  data-id="'+x+'" id="f' + x + '" style="width:70px;" ></td>';
						str += '<td><input type="number" id="g' + x + '" style="width:70px;" ></td>';
						str += '<td><button data-id="'+x+'" data-order-id="'+ order[x]['order_id']+'" data-color-id="'+ order[x]['item_color']+'" data-size-id="'+ order[x]['size']+'">Add</button></td>';
						str += '<td><button>Allocate</button></td>';

//                        str += '<td>0</td>';
//
//                        str += '<td><input type="text"></td>';

str += '</tr>';

}

$('#summery_table tbody').html(str);



					// console.log(res);

				}

			},

			error: function (err) {

				alert(err);

			}

		});

}


$('#bundle_chart_table tbody').on('click', 'button', function () {

	var ele = $(this);

	var bundle_no = ele.attr('data-bundle-no');
	var line_item = ele.attr('data-line-no');

	appAlertConfirm('Do you want to delete selected line?', function () {

		appAjaxRequest({

			url: BASE_URL + 'index.php/fg/fg_inventory/destroy/' + line_item + '/' + bundle_no,

			type: 'post',

			dataType: 'json',

			success: function (res) {

				if (res.status == 'success') {

					ele.parent().parent().remove();

					appAlertSuccess(res.message);



					reload_summery_table(LAYSHEET_NO);

				}
				if(res.status == 'error'){

					appAlertError(res.message);

				}

			},

			error: function (err) {

				alert(err);

			}

		});

	});

});


function load_bundle_chart(laysheet) {
		// alert(laysheet)
		appAjaxRequest({

			url: BASE_URL + 'index.php/fg/fg_inventory/get_saved_details/' + laysheet,

			type: 'get',

			dataType: 'json',

			success: function (res) {

				if (res != null && res != '') {

					var bundle_chart = res.bundle_chart;

					var str = '';
					var str = '';

					for (var x = 0; x < bundle_chart.length; x++) {

						str += '<tr>';

						str += '<td>' + bundle_chart[x]['style_code'] + '</td>';

						str += '<td>' + bundle_chart[x]['order_code'] + '</td>';

						str += '<td>' + bundle_chart[x]['size_code'] + '</td>';
						str += '<td>' + bundle_chart[x]['pcs_per_ctn'] + '</td>';
						str += '<td>' + bundle_chart[x]['ctn_qty'] + '</td>';
						str += '<td>' + bundle_chart[x]['ttl_qty'] + '</td>';
						str += '<td>' + bundle_chart[x]['weight_net'] + '</td>';
						str += '<td>' + bundle_chart[x]['weight_nn'] + '</td>';
						str += '<td><button class="btn btn-danger btn-xs" data-line-no="' + bundle_chart[x]['line_item'] + '" data-bundle-no="' + bundle_chart[x]['packing_list_id'] + '">Delete</button></td>';

						str += '</tr>';

					}

					$('#bundle_chart_table tbody').html(str);

				}

			},

			error: function (err) {

				alert(err);

			}

		});

	}





})()

