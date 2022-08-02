(function(){

    //var ORDER = null;
    var OPERATION = null;
    //var NEXT_OPERATION = null;
    var PREVIOUS_OPERATION = null;
    //var OPERATION_POINT = null;

    $(document).ready(function () {

        OPERATION = $('#operation').val();
        PREVIOUS_OPERATION = $('#previous_operation').val();

        $('.date').datepicker({
            format: "yyyy-mm-dd",
            viewMode: "days",
            minViewMode: "days"
        });

        $('#barcode').on('keypress', function (e) {
            if (e.which === 13) {
              //alert('ok');
              //Disable textbox to prevent multiple submit
              //  $(this).attr("disabled", "disabled");
                //Do Stuff, submit, etc..
                if (OPERATION == null) {
                    appAlertError('Incorrect operation');
                    return;
                }
                var barcode = $('#barcode').val().trim();
				$("#barcode").val("");
				$("#barcode").focus();
                if (barcode == '') {

                    appAlertError('Enter barcode number');

                    return;

                }

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

                var shift_no = $('#shift_no').val();

                if (shift_no == '') {

                    appAlertError('Enter shift no');

                    return;

                }

                scan_barcode(OPERATION, PREVIOUS_OPERATION, barcode, line_no, shift_no, scan_date);


                //Enable the textbox again if needed.
                $(this).removeAttr("disabled");
            }
        });


        $('#btn_add').click(function () {

            if (OPERATION == null) {
                appAlertError('Incorrect operation');
                return;
            }

            var barcode = $('#barcode').val().trim();
			      $("#barcode").val("");
			      $("#barcode").focus();
            if (barcode == '') {
                appAlertError('Enter barcode number');
                return;
            }

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

            var shift_no = $('#shift_no').val();
            if (shift_no == '') {
                appAlertError('Enter shift no');
                return;
            }

            var shift_type = $('#shift_type').val();
            if(OPERATION == 1){
              if (shift_type == '') {
                  appAlertError('Enter shift type');
                  return;
              }
            }
            else {
              shift_type = null;
            }

            scan_barcode(OPERATION, PREVIOUS_OPERATION, barcode, line_no, shift_no, scan_date, shift_type);

			// $("p").hide("slow", function(){
			// 	alert("The paragraph is now hidden");
			// });
			// passing function as an argument
			//greet('Peter', callMe);


        });


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
            var barcode = ele.attr('data-barcode');
            var prev_operation = ele.attr('data-previous-operation');
            appAlertConfirm('Do you want to delete this bundle - ' + barcode, function () {
                //remove_from_production(ORDER.order_id , OPERATION.operation_id , OPERATION_POINT , barcode);
                remove_from_production(OPERATION, barcode, prev_operation, ele);
            });
        });


        $('#select_all').change(function () {
            $('#added_item_table tbody input:checkbox').prop('checked', this.checked);
        });


        $('#btn_remove').click(function () {
            var data = [];
            $('#added_item_table tbody input:checkbox').each(function () {
                if (this.checked == true) {
                    data.push({
                      'barcode' : $(this).attr('data-barcode'),
                      'previous_operation_id' : $(this).attr('data-previous-operation')
                    });
                }
            });

            if (data.length > 0) {
                appAlertConfirm('Do you want to remove selected bundles from this operation?', function () {
                    //remove_barcodes_from_production(ORDER.order_id , OPERATION.operation_id , OPERATION_POINT , data);
                    remove_barcodes_from_production(OPERATION, data);
                });
            }
        });


    });







    /*function load_order(order_id){

     appAjaxRequest({

     url : BASE_URL + 'index.php/order/order/get',

     type : 'GET',

     dataType : 'json',

     async : false,

     data : {

     'order_id' : order_id

     },

     success : function(res){

     if(res.data != null && res.data != ''){

     ORDER = res.data;

     order_operations(ORDER.order_id);

     }

     else{

     appAlertError('Incorrect order no');

     }

     },

     error : function(err){

     console.log(err);

     }

     });

     }*/









    function scan_barcode(operation_id, previous_operation_id, barcode, line_no, shift_no, scan_date, shift_type) {
        appAjaxRequest({
            url: BASE_URL + 'index.php/production/production/scan_barcode',
            type: 'POST',
            dataType: 'json',
            data: {
                'barcode': barcode,
                'operation': operation_id,
                'previous_operation': previous_operation_id,
                'line_no': line_no,
                'shift_no': shift_no,
                'scan_date': scan_date,
                'shift_type' : shift_type
            },
            async: false,
            success: function (res) {
                if (res.status == 'success') {
                    add_item_to_table(res.data);
                } else {
                    appAlertError(res.message);
                }
            },
            error: function (err) {
                console.log(err);
            }
        });
    }


    function add_item_to_table(data) {
        var str = '<tr>';
        str += '<td><input type="checkbox" data-barcode="' + data['barcode'] + '" data-previous-operation="' + data['prev_operation'] + '" /></td>';
        str += '<td>' + data['item_code'] + '</td>';
        str += '<td>' + data['color_code'] + '</td>';
        str += '<td>' + data['bundle_no'] + '</td>';
        str += '<td>' + data['barcode'] + '</td>';
        str += '<td>' + data['size_code'] + '</td>';
        str += '<td>' + data['qty'] + '</td>';
        var line_no = (data['line_code'] == null) ? '' : data['line_code'];
        str += '<td>' + line_no + '</td>';
        str += '<td><button data-barcode="' + data['barcode'] + '" data-previous-operation="' + data['prev_operation'] + '" class="btn btn-danger btn-xs">Delete</button></td>';
        $('#added_item_table tbody').append(str);
    }





    function remove_from_production(operation_id, barcode, prev_operation, _ele) {
        appAjaxRequest({
            url: BASE_URL + 'index.php/production/production/destroy',
            type: 'POST',
            dataType: 'json',
            data: {
                //'order_id' : order_id,
                'operation_id': operation_id,
                'previous_operation_id' : prev_operation,
                'barcode': barcode
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



    function remove_barcodes_from_production(operation_id, barcodes) {
      $('body').loadingModal({
      position: 'auto',
      text: '',
      color: '#fff',
      opacity: '0.5',
      backgroundColor: 'rgb(0,0,0)',
      animation: 'cubeGrid'
    });
    setTimeout(function(){
      appAjaxRequest({
          url: BASE_URL + 'index.php/production/production/destroy_list',
          type: 'POST',
          dataType: 'json',
          data: {
              //'order_id' : order_id,
              'operation_id': operation_id,
              //'previous_operation_id' : PREVIOUS_OPERATION,
              'barcodes': barcodes
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
            $('body').loadingModal('destroy');
          },
          error: function (err) {
              appAlertError('Process Error');
              console.log(err);
              $('body').loadingModal('destroy');
          }
      });
    },200);

    }





})();
