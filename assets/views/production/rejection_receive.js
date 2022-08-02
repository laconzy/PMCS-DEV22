(function(){

  var ORDER = null;
  var OPERATION = null;
  var BASE_URL = null;
  var REJECTION_TYPE = null;
  var BUNDLE = null;

  $(document).ready(function(){
    BASE_URL = $('#base-url').val();

    $('.date').datepicker({
      format: "yyyy-mm-dd",
      viewMode: "days",
      minViewMode: "days"
    });

    $('#btn_search').click(function(){
      var order_id = $('#order_id').val();
      $('#operations').html('');
      $('#added_item_table tbody').html('');
      ORDER = null;
      OPERATION = null;
      if(order_id != null && order_id != ''){
        load_order(order_id);
      }
    });


    $('#site').change(function(){
      var site_id = $(this).val();
      var str = '<option value="">... Select Line ...</option>';
      if(site_id == null || site_id == ''){
        $('#line_no').html(str);
      }
      else {
        appAjaxRequest({
         url : BASE_URL + 'index.php/production/rejection/get_lines/' + site_id,
         type : 'GET',
         dataType : 'json',
         async : false,
         data : { },
         success : function(res){
          let lines = res.data;
          if(lines != null){
            for(let x = 0 ; x < lines.length ; x++){
              str += `<option value="${lines[x]['line_id']}">${lines[x]['line_code']}</option>`;
            }
          }
          $('#line_no').html(str);
         },
         error : function(err){
           console.log(err);
           appAlertError(err);
           $('#line_no').html(str);
         }
       });
      }
    });


    $('#operations').change(function(){
      var selected = $(this).find('option:selected');
      var operation_id = selected.val();//$(this).val();
      OPERATION = null;
      load_operation(operation_id);
      $('#barcode').val('');
    });


    $('#rejection_type').change(function(){
      var type = $(this).val();
      REJECTION_TYPE = (type == '') ? null : type;
    });


    $('#btn_find').click(function(){
      if(ORDER == null){
        appAlertError('Incorrect order');
        return;
      }

      if(OPERATION == null){
        appAlertError('Select Operation');
        return;
      }

      if(REJECTION_TYPE == null){
        appAlertError('Select Rejection Type');
        return;
      }

      var barcode = $('#barcode').val().trim();
      if(barcode == ''){
        appAlertError('Enter Valid Barcode');
        return;
      }

      load_bundle(ORDER.order_id, OPERATION.operation_id, barcode);

    });





    $('#btn_save').click(function(){

      if(BUNDLE != null){

        var qty = $('#rejection_qty').val();

        if(qty > BUNDLE.qty || qty <= 0){

          appAlertError('Rejection qty must be in between 1 and bundle qty');

          return;

        }

        BUNDLE['rejected_qty'] = qty;

        add_to_rejection(BUNDLE);

      }

    });

    //receive reject

    $('#receive').click(function(){

     var date=$("#scan_date").val();
     var line_no=$("#line_no").val();
     var status=$("#hour").val();
     var order_id=$("#order_id").val();
     //var date=$("#scan_date").val();

     if(date==''){
      appAlertError('Please select the date');
      return
    }
     if(line_no==''){
      appAlertError('Please select the Line');
      return
    }

     appAjaxRequest({
      url : BASE_URL + 'index.php/production/rejection/load_reject_list_1',
      type : 'GET',
      dataType : 'json',
      async : false,
      data : {
        'date' : date,
        'line_no' : line_no,
        'status' : status,
        'order_id' : order_id
      },
      success : function(res){
      //  console.log(res);
        if(res != null){
          var rejection = res.rejection;
          var str = '';
          for(var x = 0 ; x < rejection.length ; x++){
            str += '<tr>';
            str += '<td>'+rejection[x]['id']+'</td>';
            str += '<td>'+rejection[x]['line_code']+'</td>';
            str += '<td>'+rejection[x]['order_id']+'</td>';
            str += '<td>'+rejection[x]['order_code']+'</td>';
            str += '<td>'+rejection[x]['size_code']+'</td>';
            str += '<td>'+rejection[x]['qty']+'</td>';
            str += '<td>'+rejection[x]['status']+'</td>';
            str += '<td> <input type="checkbox" checked data-id='+rejection[x]['id']+'></td>';
            str += '</tr>';
          }
          $('#rejection_list tbody').html(str);
        }
      },
      error : function(err){
        console.log(err);
      }
    });
  });

// deletereject

$('#delete_reject').click(function(){

     // alert(8)

     var date=$("#scan_date").val();

     if(date==''){
      appAlertError('Please select the date');
      return
    }
    $("#myModal3").modal('show');
    appAjaxRequest({

      url : BASE_URL + 'index.php/production/rejection/load_reject_list',

      type : 'GET',

      dataType : 'json',

      async : false,

      data : {

        'date' : date

      },

      success : function(res){

        console.log(res);
        if(res != null){

          var rejection = res.rejection;
//alert(rejection.length)
var str = '';
for(var x = 0 ; x < rejection.length ; x++){


  str += '<tr>';

  str += '<td>'+rejection[x]['id']+'</td>';
  str += '<td>'+rejection[x]['order_id']+'</td>';

  str += '<td>'+rejection[x]['order_code']+'</td>';

  str += '<td>'+rejection[x]['size_code']+'</td>';

  str += '<td>'+rejection[x]['qty']+'</td>';

  str += '<td> <input type="checkbox checked></td>';

  str += '</tr>';
}
          //console.log(str)
          $('#rejection_list tbody').html(str);
  //console.log(str)
}



},

error : function(err){

  console.log(err);

}

});
  });



$('#rejection_list tbody').on('click', 'button', function () {

  var ele = $(this);

  var id = ele.attr('data-id');

  appAlertConfirm('Do you want to delete selected item?', function () {

    appAjaxRequest({

      url: BASE_URL + 'index.php/production/rejection/destroy/' + id,

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

$('#select_all').change(function(){

  $('#rejected_table tbody input:checkbox').prop('checked',this.checked);

});




//confirm data
$('#receive_con').click(function(){
  var site_id = $('#site').val();
  var data = [];
  var table =$('#rejection_list').length;
  $('#rejection_list tbody input:checkbox').each(function(){
    if(this.checked == true){
      var obj={'id':$(this).attr('data-id')}
      data.push(obj);
    }
  });

  appAjaxRequest({
    url : BASE_URL + 'index.php/production/rejection/confirm',
    type : 'post',
    dataType : 'json',
    async : false,
    data : {
      'data' : data,
      'site_id' : site_id
    },
    success : function(res){
     if(res.status == 'success'){
      appAlertSuccess('Confirmed');
      $("#myModal3").modal('hide');
    }
  },
  error : function(err){
        console.log(err);
  }
});

});

});


function load_order(order_id){
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
        load_order_operations(ORDER.order_id);
      }
      else {
        appAlertError('Incorrect order no');
      }
    },
    error : function(err){
      console.log(err);
    }
  });
}



function load_order_operations(order_id){
  appAjaxRequest({
    url : BASE_URL + 'index.php/order/order_operation/get/'+order_id+'/all',
    type : 'GET',
    dataType : 'json',
    async : false,
    success : function(res){
      var operations = res.data;
      var str = '<option value="">...Select operation...</option>';
      for(var x = 0 ; x < operations.length ; x++) {
          if(x == (operations.length-1)){//last operation
            str += '<option value="'+operations[x]['operation_id']+'" data-previous-operation="'+operations[x-1]['operation_id']+'" data-next-operation="NO">'+operations[x]['operation_name']+'</option>';
          }
          else if(x == 0){//first operation
            str += '<option value="'+operations[x]['operation_id']+'" data-previous-operation="NO" data-next-operation="'+operations[x+1]['operation_id']+'">'+operations[x]['operation_name']+'</option>';
          }
          else{
            str += '<option value="'+operations[x]['operation_id']+'" data-previous-operation="'+operations[x-1]['operation_id']+'" data-next-operation="'+operations[x+1]['operation_id']+'">'+operations[x]['operation_name']+'</option>';
          }
        }
        $('#operations').html(str);
      },
      error : function(err){
        console.log(err);
      }
    });
}



function load_operation(operation_id){
  appAjaxRequest({
    url : BASE_URL + 'index.php/master/operation/get/'+operation_id,
    type : 'GET',
    dataType : 'json',
    async : false,
    success : function(res){
      OPERATION = res.data;
      load_rejected_bundles(ORDER.order_id, OPERATION.operation_id);
      },
      error : function(err){
        console.log(err);
      }
    });
}





function load_bundle(order_id, operation_id, barcode){

  appAjaxRequest({

    url : BASE_URL + 'index.php/production/rejection/get_bundle',

    type : 'GET',

    dataType : 'json',

    async : false,

    data : {

      'order_id' : order_id,

      'operation_id' : operation_id,

      'barcode' : barcode

    },

    success : function(res){

      if(res.status == 'success'){

        BUNDLE = res.data;

        $('#barcode_item').html(BUNDLE.item_code);

        $('#barcode_bundle').html(BUNDLE.bundle_no);

        $('#barcode_no').html(BUNDLE.barcode);

        $('#barcode_size').html(BUNDLE.size_code);

        $('#barcode_qty').html(BUNDLE.qty);

        $('#rejection_qty').val(0);

      }

      else{

        $('#barcode_item,#barcode_bundle,#barcode_no,#barcode_size,#barcode_qty').html('');

        $('#rejection_qty').val(0);

        appAlertError(res.message);

      }

    },

    error : function(err){

      console.log(err);

    }

  });

}





function add_to_rejection(bundle){

  appAjaxRequest({

    url : BASE_URL + 'index.php/production/rejection/save_bundle',

    type : 'POST',

    dataType : 'json',

    async : false,

    data : { 'data' : bundle },

    success : function(res){

      if(res.status == 'success'){

        $('#barcode_item,#barcode_bundle,#barcode_no,#barcode_size,#barcode_qty').html('');

        $('#rejection_qty').val(0);

        $('#barcode').val('');

        load_rejected_bundles(ORDER.order_id, OPERATION.operation_id);

      }

      else{

        appAlertError('Process Error');

      }

    },

    error : function(err){

      console.log(err);

    }

  });

}





function load_rejected_bundles(order_id, operation_id){

  appAjaxRequest({

    url : BASE_URL + 'index.php/production/rejection/get_rejected_bundles',

    type : 'GET',

    dataType : 'json',

    async : false,

    data : {

      'order_id' : order_id,

      'operation_id' : operation_id

    },

    success : function(res){

      var str = '';

      if(res.data != null){

        var bundles = res.data;

        for(var x = 0 ; x < bundles.length ; x++){

          str = '<tr>';

          str += '<td><input type="checkbox" data-barcode="'+bundles[x]['barcode']+'" ></td>';

          str += '<td>'+ bundles[x]['item_code'] +'</td>';

          str += '<td>'+ bundles[x]['bundle_no'] +'</td>';

          str += '<td>'+ bundles[x]['barcode'] +'</td>';

          str += '<td>'+ bundles[x]['size_code'] +'</td>';

          str += '<td>'+ bundles[x]['qty'] +'</td>';

          str += '<td>'+ bundles[x]['rejected_qty'] +'</td>';

        }

      }

      $('#rejected_table tbody').html(str);

    },

    error : function(err){

      console.log(err);

    }

  });

}





function remove_bundles(order_id, operation_id , barcodes){

  appAjaxRequest({

    url : BASE_URL + 'index.php/production/rejection/remove_barcodes' ,

    type : 'POST',

    async : false,

    dataType : 'json',

    data : {

      'barcodes' : barcodes ,

      'order_id' : order_id,

      'operation_id' : operation_id

    },

    success : function(res){

      if(res.status == 'success'){

        appAlertSuccess(res['message']);

        load_rejected_bundles(ORDER.order_id, OPERATION.operation_id);

      }

      else{

        appAlertError('Process Error');

      }

    },

    error : function(err){

      console.log(err);

    }

  });

}


$('#btn_pass').click(function(){
     // alert(1)

     var order_id = $('#order_id').val();
     var line_no = $('#line_no').val();
     var shift = $('#shift').val();
     var date = $('#scan_date').val();

     if(order_id == "" || order_id == null){
      appAlertError("Please enter Order ID");
      return false;
    }
    if(line_no == "" || line_no == 0){
      appAlertError("Please Select the line");
      return false;
    }

    if(shift == "" || shift == 0){
      appAlertError("Please Select the Shift");
      return false;
    }

    if(shift == "" || date == null){
      appAlertError("Please Select the Date");
      return false;
    }
      // $('#operations').html('');

      // $('#added_item_table tbody').html('');
      load_reject();
      ORDER = null;

      OPERATION = null;

      if(order_id != null && order_id != ''){

        load_size(order_id);

      }

    });

$('#reject').click(function(){
     // alert(1)

     var order_id = $('#order_id').val();
     var line_no = $('#line_no').val();
     var shift = $('#shift').val();
     var date = $('#scan_date').val();

     if(order_id == "" || order_id == null){
      appAlertError("Please enter Order ID");
      return false;
    }
    if(line_no == "" || line_no == 0){
      appAlertError("Please Select the line");
      return false;
    }

    if(shift == "" || shift == 0){
      appAlertError("Please Select the Shift");
      return false;
    }

    if(shift == "" || date == null){
      appAlertError("Please Select the Date");
      return false;
    }



    ORDER = null;

    OPERATION = null;

    if(order_id != null && order_id != ''){

      load_size_to_reject(order_id);
      load_reject();

    }

  });

$('#save_data').click(function(){
     // alert(1)

     var order_id = $('#order_id').val();
     var line_no = $('#line_no').val();
     var hour = $('#hour').val();
     var size = $('#size').val();
     var qty = $('#qty').val();
     var shift = $('#shift').val();
     var date = $('#scan_date').val();

//alert(shift)
      // $('#operations').html('');

      // $('#added_item_table tbody').html('');

      appAjaxRequest({

        url : BASE_URL + 'index.php/production/rejection/save_data',

        type : 'POST',

        dataType : 'json',

        async : false,

        data : {

          'order_id' : order_id,
          'line_no' : line_no,
          'hour' : hour,
          'size' : size,
          'qty' : qty,
          'shift' : shift,
          'date' : date

        },

        success : function(res){
         $("#myModal1").modal('hide');
         load_reject();

       },

       error : function(err){

        console.log(err);

      }

    });

    });
$('#btn_reject').click(function(){
     // alert(1)

     var order_id = $('#order_id').val();
     var line_no = $('#line_no').val();
     var hour = $('#hour').val();
     var size = $('#size_r').val();
     var qty = $('#qty').val();
     var shift = $('#shift').val();
     var qty_reject = $('#qty_reject').val();
     var rejection_type = $('#rejection_type').val();

//alert(shift)
      // $('#operations').html('');

      // $('#added_item_table tbody').html('');

      appAjaxRequest({

        url : BASE_URL + 'index.php/production/rejection/save_reject',

        type : 'POST',

        dataType : 'json',

        async : false,

        data : {

          'order_id' : order_id,
          'line_no' : line_no,
          'hour' : hour,
          'size' : size,
          'qty' : qty_reject,
          'shift' : shift,
          'reason_code' : rejection_type


        },

        success : function(res){

          if(res.status="Unsucess"){
            appAlertError(res.message);
          }else        {
           $("#myModal2").modal('hide');
           load_reject();
         }


       },

       error : function(err){

        console.log(err);

      }

    });

    });

function load_size(order_id){
//alert(2)
appAjaxRequest({

  url : BASE_URL + 'index.php/production/rejection/get_size',

  type : 'POST',

  dataType : 'json',

  async : false,

  data : {

    'order_id' : order_id

  },

  success : function(res){

    if(res.size != null && res.size != ''){
      var result = res.size;
        // console.log(result);
        $('#size').empty();

        $('#pass_order').text(result[0].order_code);

        $('#size').append('<option value="0">--Select Size--</option>');
        for (var index = 0; index < result.length; index++) {

          $('#size').append('<option value="'+result[index].size_id+'">' + result[index].size_code + '</option>');

        }


      }

      else{

        appAlertError('Incorrect order no');

      }

    },

    error : function(err){

      console.log(err);

    }

  });

}

function load_size_to_reject(order_id){
//alert(2)
appAjaxRequest({

  url : BASE_URL + 'index.php/production/rejection/get_size',

  type : 'POST',

  dataType : 'json',

  async : false,

  data : {

    'order_id' : order_id

  },

  success : function(res){
     //   alert(2)
//console.log(res)
if(res.size != null && res.size != ''){
  var result = res.size;
  console.log(result);
  $('#size_r').empty();
         // alert(1)
         $('#fail_order').text(result[0].order_code);
         $('#size_r').append('<option value="0">--Select Size--</option>');
         for (var index = 0; index < result.length; index++) {

          $('#size_r').append('<option value="'+result[index].size_id+'">' + result[index].size_code + '</option>');
        }


      }

      else{

        appAlertError('Incorrect order no');

      }

    },

    error : function(err){

      console.log(err);

    }

  });

}

function load_reject(){

  var line_no = $('#line_no').val();
  var shift = $('#shift').val();
  var date = $('#scan_date').val();

  appAjaxRequest({

    url : BASE_URL + 'index.php/production/rejection/load_reject',

    type : 'POST',

    dataType : 'json',

    async : false,

    data : {

      'line_no' : line_no,
      'shift' : shift,
      'date' : date

    },

    success : function(res){

     // var res.qty;

     $('#qty_rej').text(res.qty_reject);
     $('#qty_pass').text(res.qty_pass);
     //   alert(2)
//console.log(res)
 //        if(res.size != null && res.size != ''){
 //          var result = res.size;
 //          console.log(result);
 //          $('#size').empty();
 //         // alert(1)
 // $('#size').append('<option value="0">--Select Size--</option>');
 //         for (var index = 0; index < result.length; index++) {

 //      $('#size').append('<option value="'+result[index].size_id+'">' + result[index].size_code + '</option>');
 //      }


 //        }

 //        else{

 //          appAlertError('Incorrect order no');

 //        }

},

error : function(err){

  console.log(err);

}

});

}

})();
