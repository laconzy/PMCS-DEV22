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


		// $('#btn_create_bundles').click(function () {
		// 	var ord_id = $('#laysheet_no').val();

		// 	var i = 0;
		// 	var arr = [];
		// 	// $('#summery_table tbody tr').each(function () {
		// 	// 	var ord_id = $('#laysheet_no').val();
		// 	// 	var item = $(this).find("td").eq(0).attr('id');
		// 	// 	var color = $(this).find("td").eq(1).attr('id');
		// 	// 	var size = $(this).find("td").eq(2).attr('id');
		// 	// 	var ctn_per_pc = $('#a' + i).val();
		// 	// 	var ctn_qty = $('#b' + i).val();
		// 	// 	var ttl_qty = $('#c' + i).val();
		// 	// 	var avalble = $('#d' + i).val();
		// 	// 	//alert(customerId2)
		// 	// 	if (parseInt(qty) > 0) {
		// 	// 		var data = {
		// 	// 			"order_id": ord_id,
		// 	// 			"item_id": item,
		// 	// 			"color": color,
		// 	// 			"size_id": size,
		// 	// 			"qty": qty,
		// 	// 			"ctn_qty": ctn_qty,
		// 	// 			"ttl_qty": ttl_qty
		// 	// 			//"qty": qty
		// 	// 		}
		// 	// 		arr.push(data);

		// 	// 	}

		// 	// 	i++;
		// 	// });
		// 	// console.log(arr)

		// 	// appAjaxRequest({

		// 	// 	url: BASE_URL + 'index.php/fg/fg_inventory/save_packing_list',

		// 	// 	type: 'post',

		// 	// 	dataType: 'json',

		// 	// 	data: {

		// 	// 		'ord_id': ord_id,

		// 	// 		'items': arr
		// 	// 	},

		// 	// 	success: function (res) {

		// 	// 		if (res != null && res != '') {
		// 	// 			appAlertSuccess('Bundles generated successfully');

		// 	// 			var id = res.id;
		// 	// 			console.log(id)
		// 	// 			var str = '';
		// 	// 			//load_bundle_chart(id);
		// 	// 			// for (var x = 0; x < bundle_chart.length; x++) {

		// 	// 			// 	str += '<tr>';

		// 	// 			// 	str += '<td>' + bundle_chart[x]['id'] + '</td>';

		// 	// 			// 	str += '<td>' + bundle_chart[x]['ord_id'] + '</td>';

		// 	// 			// 	str += '<td>' + bundle_chart[x]['first_name'] + '</td>';

		// 	// 			// 	str += '<td>' + bundle_chart[x]['created_date'] + '</td>';
		// 	// 			// 	str += '<td><input type="number" id="m' + bundle_chart[x]['id'] + '"></td>';
		// 	// 			// 	str += '<td><button class="btn btn-danger btn-xs" data-bundle-no="' + bundle_chart[x]['id'] + '">print</button></td>';

		// 	// 			// 	str += '</tr>';

		// 	// 			// }
		// 	// 			//console.log(str)
		// 	// 			//$('#bundle_chart_table tbody').html(str);

		// 	// 			//reload_summery_table(ord_id);

		// 	// 			//console.log(res);
		// 	// 		}

		// 	// 	},

		// 	// 	error: function (err) {

		// 	// 		appAlertError('Bundles Already generated');

		// 	// 	}

		// 	// });
		// 	return false;

		// 	appAlertConfirm('Do you want to create the bundle chart for this laysheet?', function () {

		// 		appAjaxRequest({

		// 			url: BASE_URL + 'index.php/cutting/bundle/save',

		// 			type: 'post',

		// 			dataType: 'json',

		// 			data: {

		// 				'laysheet_no': LAYSHEET_NO,

		// 				'plies': plies
		// 			},
		// 			success: function (res) {

		// 				if (res != null && res != '') {

		// 					appAlertSuccess('Bundles generated successfully');

		// 					var $ctn_data = res.$ctn_data;

		// 					var str = '';

		// 					for (var x = 0; x < $ctn_data.length; x++) {

		// 						str += '<tr>';

		// 						str += '<td>' + $ctn_data[x]['id'] + '</td>';

		// 						str += '<td>' + $ctn_data[x]['ord_id'] + '</td>';

		// 						str += '<td>' + $ctn_data[x]['first_name'] + '</td>';

		// 						str += '<td>' + $ctn_data[x]['created_date'] + '</td>';

		// 						str += '<td><button class="btn btn-danger btn-xs" data-bundle-no="' + $ctn_data[x]['id'] + '">Delete</button></td>';

		// 						str += '</tr>';

		// 					}

		// 					$('#bundle_chart_table tbody').html(str);

		// 					reload_summery_table(LAYSHEET_NO);

		// 					console.log(res);

		// 				}

		// 			},

		// 			error: function (err) {

		// 				appAlertError('Bundles Already generated');

		// 			}

		// 		});

		// 	});

		// });





//        $('#bundle_chart_table tbody').on('click', 'button', function () {
//
//            var ele = $(this);
//
//            var bundle_no = ele.attr('data-bundle-no');
//
//            appAlertConfirm('Do you want to delete selected bundle?', function () {
//
//                appAjaxRequest({
//
//                    url: BASE_URL + 'index.php/cutting/bundle/destroy/' + LAYSHEET_NO + '/' + bundle_no,
//
//                    type: 'post',
//
//                    dataType: 'json',
//
//                    success: function (res) {
//
//                        if (res.status == 'success') {
//
//                            ele.parent().parent().remove();
//
//                            appAlertSuccess(res.message);
//
//                            reload_summery_table(LAYSHEET_NO);
//
//                        }
//
//                    },
//
//                    error: function (err) {
//
//                        alert(err);
//
//                    }
//
//                });
//
//            });
//
//        });




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
//alert(res.status)
if (res.status == 'Success') {
//alert(2)
						//ele.parent().parent().remove();

						//appAlertSuccess(res.message);
						load_bundle_chart(res.id);
						//reload_summery_table(LAYSHEET_NO);

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
	if(name == 'pcs' || name == 'ctn_qty'){
//alert(ele.val())
var total= val2*val1;
$('#c'+ no).val(total);
}


			//}
		});

// $("#summery_table tbody").on("change", "input", function (event) {
	
// 	var ele = $(this);

// 	var no = ele.attr('data-id');
// 	var name = ele.attr('data-name');
// 	value= ele.val();
// 	if(name == 'pcs' || name == 'ctn_qty'){
// //alert(ele.val())
// }


// 			//}
// 		});


// $('#bundle_chart_table tbody').on('click', 'button', function () {

// 	var ele = $(this);

// 	var bundle_no = ele.attr('data-bundle-no');
// 	var qty = $('#m' + bundle_no).val();

// 	appAlertConfirm('Do you want to print selected ?', function () {

// 		appAjaxRequest({

// 			url: BASE_URL + 'index.php/cutting/bundle/print_data/' + bundle_no + '/' + qty,

// 			type: 'post',

// 			dataType: 'json',

// 			success: function (res) {

// 				if (res.status == 'success') {

// 					window.open(BASE_URL + 'index.php/cutting/bundle/print_fg_barcode/' + bundle_no + '/' + res.start);
// //                            ele.parent().parent().remove();
// //
// //                            appAlertSuccess(res.message);
// //
// //                            reload_summery_table(LAYSHEET_NO);

// }

// },

// error: function (err) {

// 	alert(err);

// }

// });

// 	});

// });


$('#btn_save').click(function () {
	
	var customer_po = $('#customer_po').val();
	var style = $('#style').val();
	var container = $('#container').val();
	var ref_1 = $('#ref_1').val();
	var ref_2 = $('#ref_2').val();
	var ref_3 = $('#ref_3').val();
	var id = $('#pack').val();

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

