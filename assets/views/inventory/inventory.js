(function(){

    //var ORDER = null;
    var OPERATION = null;
    //var NEXT_OPERATION = null;
    var PREVIOUS_OPERATION = null;
    var BARCODE = null;

    $(document).ready(function () {

        OPERATION = $('#operation').val();
        PREVIOUS_OPERATION = $('#previous_operation').val();

        if($('#packing_id').val() != ''){
          let h_customer = $('#h_customer').val();
          //let h_location = $('#h_location').val();
          //let h_issue_location = $('#h_issue_location').val();

          $('#customer').val(h_customer);
          //$('#site').val(h_location);
          //$('#location').val(h_issue_location);
          let order_code_hidden = $('#order_code_hidden').val();
            $("#order_code").empty().append(`<option value="${order_code_hidden}">${order_code_hidden}</option>`).val(order_code_hidden).trigger('change');
        }

        $("#order_code").select2({
          ajax: {
            url: BASE_URL + 'index.php/order/order/order_code_search',
            dataType: 'json'
          }
        });


        $('.date').datepicker({
            format: "yyyy-mm-dd",
            viewMode: "days",
            minViewMode: "days"
        });

        $('#barcode').on('keypress', function (e) {
            if (e.which === 13) {
              $('#btn_add').trigger('click');
            }
        });


        $('#btn_add').click(function () {

            var barcode = $('#barcode').val().trim();
			         $("#barcode").val("");
			         $("#barcode").focus();
               if (barcode == '') {
                appAlertError('Enter barcode number');
                return;
            }
            BARCODE = barcode;

            var scan_date = $('#scan_date').val();
            if (scan_date == '') {
                appAlertError('Enter line no');
                return;
            }

            var line_no = $('#line_no').val();
            if (line_no == '') {
                appAlertError('Enter line no');
                return;
            }

            var customer = $('#customer').val();
            if (customer == '') {
                appAlertError('Enter customer');
                return;
            }

            scan_barcode(OPERATION, PREVIOUS_OPERATION, barcode, line_no, customer, scan_date);
        });


           $('#btn_create').click(function () {

            var scan_date = $('#scan_date').val();
            if (scan_date == '') {
                appAlertError('select date');
                return;
            }

            var laysheet = $('#laysheet').val();
            if (laysheet == '') {
                appAlertError('Enter laysheet no');
                return;
            }

            var customer = $('#customer').val();
            if (customer == '') {
                appAlertError('Select Customer');
                return;
            }

            var style = $('#style').val();
             if (style == '') {
                 appAlertError('Enter style');
                 return;
             }

           /*var buyer_po = $('#buyer_po').val();
            if (buyer_po == '') {
                appAlertError('Enter buyer po');
                return;
            }*/

            var order_code = $('#order_code').val();
             if (order_code == null || order_code == '') {
                 appAlertError('Select order code');
                 return;
             }

            var remarks = $('#remarks').val();

            //scan_barcode(OPERATION, PREVIOUS_OPERATION, barcode, line_no, shift_no, scan_date);
            create_packing_list(scan_date,laysheet,customer,style,order_code,remarks)

            // $("p").hide("slow", function(){
            //  alert("The paragraph is now hidden");
            // });
            // passing function as an argument
            //greet('Peter', callMe);


        });


        $('#btn_confirm').click(function(){
          appAlertConfirm('Do you want to confirm this packing list?', function () {
            confirm_packing_list();
          });
        });


        $('#btn_unconfirm').click(function(){
          appAlertConfirm('Do you want to revoke this packing list?', function () {
            unconfirm_packing_list();
          });
        });


function create_packing_list(scan_date,laysheet,customer,style, order_code,remarks) {
           appAjaxRequest({
            url: BASE_URL + 'index.php/inventory/inventory/create_packing_list',
            type: 'POST',
            dataType: 'json',
            async : false,
            data: {
              //'order_id' : order_id,
              'scan_date': scan_date,
              'laysheet': laysheet,
              'customer': customer,
              'style' : style,
              'order_code' : order_code,
              'remarks' : remarks
            },
            success: function (res) {
              if(res.status == 'success'){
                //$('#pack').val(res.id);
                //$('#div_barcode').show();
                appAlertSuccess(res.message, function(){
                  window.open(BASE_URL + 'index.php/inventory/inventory/inventory_view/' + res.id, '_self');
                });
              }
              else {
                appAlertError(res.message);
              }
            },
            error: function (err) {
                appAlertError('Process Error');
                console.log(err);
            }
        });
        }

// 		function processUserInput(callback) {
// 			var name = prompt('Please enter your name.');
// 			callback(name);
// 		}
// function validate_data(){
// 	$("#barcode").val("");
// 	$("#barcode").focus();
// }


// function
		function greet(name, callback) {
			console.log('Hi' + ' ' + name);
			callback();
		}

// callback function
		function callMe() {
			console.log('I am callback function');
			$("#barcode").val("");
			$("#barcode").focus();
		}



    $('#added_item_table tbody').on('click', 'button', function () {
        var ele = $(this);
        var details_id = ele.attr('data-details-id');
        var packing_id = $('#pack').val();
        appAlertConfirm('Do you want to delete this barcode', function () {
            //remove_from_production(ORDER.order_id , OPERATION.operation_id , OPERATION_POINT , barcode);
            remove_barcode(packing_id, details_id, ele);
        });
    });


    $('#select_all').change(function () {
        $('#added_item_table tbody input:checkbox').prop('checked', this.checked);
    });


    $('#btn_remove').click(function () {
        var data = [];
        var packing_id = $('#pack').val();
        $('#added_item_table tbody input:checkbox').each(function () {
            if (this.checked == true) {
                data.push($(this).attr('data-details-id'));
            }
        });

        if (data.length > 0) {
            appAlertConfirm('Do you want to remove selected batcodes?', function () {
                remove_selected_barcodes(packing_id, data);
            });
        }
    });



    $('#btn_add_roll').click(function(){
        let new_qty = $('#txt_qty').val().trim();
        let qty = $('#txt_qty').attr('data-qty');
        let pack_list_id = $('#pack').val();

        if(qty == '' || new_qty == null || new_qty == ''){
          appAlertError('Incorrect qty');
          return;
        }

        qty = parseFloat(qty);
        new_qty = parseFloat(new_qty);

        if(new_qty > qty){
          appAlertError('Entered qty is grater than actual qty');
          return;
        }

        if (BARCODE == null || BARCODE == '') {
            appAlertError('Enter barcode number');
            return;
        }

        new_qty = Math.round((new_qty + Number.EPSILON) * 100) / 100;

        appAjaxRequest({
         url: BASE_URL + 'index.php/inventory/inventory/add_role',
         type: 'POST',
         dataType: 'json',
         async : false,
         data: {
             'barcode': BARCODE,
             'qty' : new_qty,
             'pack_list_id' : pack_list_id
         },
         success : function(res){
           if(res.status == 'success'){
             add_item_to_table(res.data);
             $("#model1").modal('hide');
             appAlertSuccess(res.message);
           }
           else {
             appAlertError(res.message);
           }
         },
         error : function(err){

         }
       });
      });
  });




    function scan_barcode(operation_id, previous_operation_id, barcode, line_no, customer, scan_date) {
        let packing_id = $('#pack').val();

        appAjaxRequest({
            url: BASE_URL + 'index.php/inventory/inventory/scan_barcode',
            type: 'POST',
            dataType: 'json',
            data: {
                'barcode': barcode,
                'packing_id' : packing_id
            },
            async: false,
            success: function (res) {
                if (res.status == 'success') {
                   // add_item_to_table(res.data);
                    display_items(res.data)
                    $('#div_btn_delete').show();
                    $("#model1").modal('show');
                } else {
                    $('#table_data tbody').html('');
                    appAlertError(res.message);
                }
            },
            error: function (err) {
               $('#table_data tbody').html('');
                console.log(err);
            }
        });
    }


    function add_item_to_table(data) {
        let confirmed = $('#confirmed').val();
        var str = '<tr>';
        str += '<td><input type="checkbox" data-details-id="' + data['pack_details_id'] + '" /></td>';
        str += '<td>' + data['item_no'] + '</td>';
        str += '<td>' + data['description'] + '</td>';
        str += '<td>' + data['batch_no'] + '</td>';
        str += '<td>' + data['roll_no'] + '</td>';
        str += '<td>' + data['item_code'] + '</td>';
        str += '<td>' + data['actual'] + '</td>';
        str += '<td>' + data['bin_location'] + '</td>';
        if(confirmed == 'NO'){
          str += '<td><button data-details-id="' + data['pack_details_id'] + '" class="btn btn-danger btn-xs">Delete</button></td>';
        }
        $('#added_item_table tbody').append(str);
    }

     function display_items(data) {
        var str = '';
        str += '<tr><td>Barcode</td><td>' + data['item_code'] + '</td><tr>';
        str += '<tr><td>role_no</td><td>' + data['role_no'] + '</td><tr>';
        str += '<tr><td>Barcode</td><td>' + data['item_code'] + '</td><tr>';
        str += '<tr><td>Color</td><td>' + data['color'] + '</td><tr>';
        str += '<tr><td>Shade</td><td>' + data['shade'] + '</td><tr>';
        let actual_qty = (data['actchchual'] == null || data['actchchual'] == '') ? 0 : parseFloat(data['actchchual']);
        let packed_qty = (data['packed_qty'] == null || data['packed_qty'] == '') ? 0 : parseFloat(data['packed_qty']);
        let remaning_qty = (actual_qty - packed_qty);
        remaning_qty = Math.round((remaning_qty + Number.EPSILON) * 100) / 100;
        str += '<tr><td>Qty</td><td><input type="number" class="form-control input-sm" id="txt_qty" data-qty="'+remaning_qty+'" value="'+remaning_qty+'"></td><tr>';
        //str += '<tr><td>Barcode</td><td>' + data['actchchual'] + '</td><tr>';
        $('#table_data tbody').html(str);
    }



    function remove_barcode(packing_id, details_id, _ele) {
        appAjaxRequest({
            url: BASE_URL + 'index.php/inventory/inventory/destroy',
            type: 'POST',
            dataType: 'json',
            data: {
                'packing_id': packing_id,
                'item': details_id
            },
            async: false,
            success: function (res) {
              if(res.status == 'success'){
                _ele.parent().parent().remove();
              }
              else {
                appAlertError(res.message);
              }
            },
            error: function (err) {
                appAlertError('Process Error');
                console.log(err);
            }
        });

    }



    function remove_selected_barcodes(packing_id, data) {
        appAjaxRequest({
            url: BASE_URL + 'index.php/inventory/inventory/destroy_list',
            type: 'POST',
            dataType: 'json',
            data: {
              'packing_id': packing_id,
              'items': data
            },
            async: false,
            success: function (res) {
              if(res.status == 'success'){
                $('#added_item_table tbody input:checkbox').each(function () {
                    if (this.checked == true) {
                        $(this).parent().parent().remove();
                    }
                });
              }
              else {
                appAlertError(res.message);
              }
            },
            error: function (err) {
                appAlertError('Process Error');
                console.log(err);
            }
        });
    }


    function confirm_packing_list(){
      let pack_list_id = $('#pack').val();
      appAjaxRequest({
          url: BASE_URL + 'index.php/inventory/inventory/confirm',
          type: 'POST',
          dataType: 'json',
          data: {
            'packing_id': pack_list_id
          },
          async: false,
          success: function (res) {
            if(res.status == 'success'){
              appAlertSuccess(res.message, function(){
                location.reload();
              });
            }
            else {
              appAlertError(res.message);
            }
          },
          error: function (err) {
              appAlertError('Process Error');
              console.log(err);
          }
      });
    }


    function unconfirm_packing_list(){
      let pack_list_id = $('#pack').val();
      appAjaxRequest({
          url: BASE_URL + 'index.php/inventory/inventory/unconfirm',
          type: 'POST',
          dataType: 'json',
          data: {
            'packing_id': pack_list_id
          },
          async: false,
          success: function (res) {
            if(res.status == 'success'){
              appAlertSuccess(res.message, function(){
                location.reload();
              });
            }
            else {
              appAlertError(res.message);
            }
          },
          error: function (err) {
              appAlertError('Process Error');
              console.log(err);
          }
      });
    }


})();
