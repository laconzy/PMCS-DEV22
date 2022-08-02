(function(){

  var ORDER = null;
  var OPERATION = null;
  var NEXT_OPERATION = null;
  var PREVIOUS_OPERATION = null;
  var OPERATION_POINT = null;

  $(document).ready(function(){


    $('#btn_search').click(function(){
      var order_id = $('#order_id').val();
      $('#operations').html('');
      $('#added_item_table tbody').html('');
      appFillFormData({
        'operation_point' : '',
        'operation_type' : '',
        'uom_in' : '',
        'uom_out' : '',
        'previous_operation' : '',
        'next_operation' : '',
        'barcode' : ''
      });
      ORDER = null;
      OPERATION = null;
      NEXT_OPERATION = null;
      PREVIOUS_OPERATION = null;
      OPERATION_POINT = null;
      if(order_id != null && order_id != ''){
          load_order(order_id);
      }
    });

    $('#operations').change(function(){
      var selected = $(this).find('option:selected');
      var operation_id = selected.val();//$(this).val();
      var next_operation_id = selected.attr('data-next-operation');
      var previous_operation_id = selected.attr('data-previous-operation');
      load_operation(operation_id);
      load_next_operation(next_operation_id);
      load_previous_operation(previous_operation_id);
      $('#added_item_table tbody').html('');
      $('#barcode').val('');
      $('#operation_point').val("");
      if(previous_operation_id != '' && previous_operation_id != 'NO'){

      }
    });

    $('#operation_point').change(function(){
      var point = $(this).val();
      OPERATION_POINT = (point == '') ? null : point;
      $('#added_item_table tbody').html('');
      $('#barcode').val('');
    });

    $('#btn_add').click(function(){
      if(ORDER == null){
        appAlertError('Enter order no');
        return;
      }

      if(OPERATION == null){
        appAlertError('Select operation');
        return;
      }

      if(OPERATION_POINT == null){
        appAlertError('Select operation point');
        return;
      }

      var line_no = $('#line_no').val().trim();
      if(OPERATION_POINT == 'IN' && line_no == ''){
        appAlertError('Select production line');
        return;
      }

      var barcode = $('#barcode').val().trim();
      if(barcode == ''){
        appAlertError('Enter barcode number');
        return;
      }

      if(OPERATION_POINT == 'IN'){ //this is a item in process

          var previous_operation_id = (PREVIOUS_OPERATION == null) ? 0 : PREVIOUS_OPERATION.operation_id;
          item_in(ORDER.order_id,OPERATION.operation_id,OPERATION_POINT,barcode,previous_operation_id,line_no);


      }
      else if(OPERATION_POINT == 'OUT') { //this is item out process
        item_out(ORDER.order_id,OPERATION.operation_id,OPERATION_POINT,barcode,OPERATION.operation_type);
        /*if(PREVIOUS_OPERATION == null){

        }
        else{

        }*/
      }

    });



    $('#added_item_table tbody').on('click','button',function(){
      var ele = $(this);
      var barcode = ele.attr('data-barcode');
      appAlertConfirm('Do you want to delete this bundle - ' + barcode , function(){
        remove_from_production(ORDER.order_id , OPERATION.operation_id , OPERATION_POINT , barcode);
        ele.parent().parent().remove();
      });

    });


    $('#select_all').change(function(){
      $('#added_item_table tbody input:checkbox').prop('checked',this.checked);
    });


    $('#btn_remove').click(function(){
      var data = [];
      $('#added_item_table tbody input:checkbox').each(function(){
        if(this.checked == true){
          data.push($(this).attr('data-barcode'));
        }
      });
      if(data.length > 0){
        appAlertConfirm('Do you want to remove selected bundles from this operation?' , function(){
            remove_barcodes_from_production(ORDER.order_id , OPERATION.operation_id , OPERATION_POINT , data);
            $('#added_item_table tbody input:checkbox').each(function(){
              if(this.checked == true){
                $(this).parent().parent().remove();
              }
            });
        });
      }
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
  }

  function order_operations(order_id){
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
        appFillFormData({
          'operation_type' : OPERATION.operation_type,
          'uom_in' : OPERATION.uom_in,
          'uom_out' : OPERATION.uom_out
        });
      },
      error : function(err){
        console.log(err);
      }
    });
  }


  function load_next_operation(operation_id){

    if(operation_id == '' && operation_id == 'NO'){
      NEXT_OPERATION = null;
      appFillFormData({  'next_operation' : ''  });
      return;
    }

    appAjaxRequest({
      url : BASE_URL + 'index.php/master/operation/get/'+operation_id,
      type : 'GET',
      dataType : 'json',
      async : false,
      success : function(res){
        NEXT_OPERATION = res.data;
        appFillFormData({
          'next_operation' : (NEXT_OPERATION == null) ? '' : NEXT_OPERATION.operation_name
        });
      },
      error : function(err){
        console.log(err);
      }
    });
  }

  function load_previous_operation(operation_id){

    if(operation_id == '' && operation_id == 'NO'){
      PREVIOUS_OPERATION = null;
      appFillFormData({  'previous_operation' : ''  });
      return;
    }

    appAjaxRequest({
      url : BASE_URL + 'index.php/master/operation/get/'+operation_id,
      type : 'GET',
      dataType : 'json',
      async : false,
      success : function(res){
        PREVIOUS_OPERATION = res.data;
        appFillFormData({
          'previous_operation' : (PREVIOUS_OPERATION == null) ? '' : PREVIOUS_OPERATION.operation_name
        });
      },
      error : function(err){
        console.log(err);
      }
    });
  }


  function item_in(order_id,operation_id,operation_point,barcode,previous_operation_id,line_no){
    appAjaxRequest({
      url : BASE_URL + 'index.php/production/production/item_in',
      type : 'POST',
      dataType : 'json',
      data : {
        'order_id' : order_id,
        'barcode' : barcode,
        'operation' : operation_id,
        'operation_point' : operation_point,
        'previous_operation_id' : previous_operation_id,
        'line_no' : line_no
      },
      async : false,
      success : function(res){
        if(res.status == 'success'){
          add_item_to_table(res.data);
        }
        else{
          appAlertError(res.message);
        }
      },
      error : function(err){
        console.log(err);
      }
    });
  }


  function item_out(order_id,operation_id,operation_point,barcode,operation_type){
    appAjaxRequest({
      url : BASE_URL + 'index.php/production/production/item_out',
      type : 'POST',
      dataType : 'json',
      data : {
        'order_id' : order_id,
        'barcode' : barcode,
        'operation' : operation_id,
        'operation_point' : operation_point,
        'operation_type' : operation_type
        /*'previous_operation_id' : previous_operation_id*/
      },
      async : false,
      success : function(res){
        if(res.status == 'success'){
          add_item_to_table(res.data);
        }
        else{
          appAlertError(res.message);
        }
      },
      error : function(err){
        console.log(err);
      }
    });
  }


  function add_item_to_table(data){
    var str = '<tr>';
    str += '<td><input type="checkbox" data-barcode="'+data['barcode']+'" /></td>';
    str += '<td>'+ data['item_code'] +'</td>';
    str += '<td>'+ data['color_code'] +'</td>';
    str += '<td>'+ data['bundle_no'] +'</td>';
    str += '<td>'+ data['barcode'] +'</td>';
    str += '<td>'+ data['size_code'] +'</td>';
    str += '<td>'+ data['qty'] +'</td>';
    var line_no = (data['line_code'] == null) ? '' : data['line_code'];
    str += '<td>'+ line_no +'</td>';
    str += '<td><button data-barcode="'+data['barcode']+'" class="btn btn-danger btn-xs">Delete</button></td>';
    $('#added_item_table tbody').append(str);
  }


  function remove_from_production(order_id,operation_id,operation_point,barcode){
    appAjaxRequest({
      url : BASE_URL + 'index.php/production/production/destroy',
      type : 'POST',
      dataType : 'json',
      data : {
        'order_id' : order_id,
        'operation_id' : operation_id,
        'operation_point' : operation_point,
        'barcode' : barcode
      },
      async : false,
      success : function(res){

      },
      error : function(err){
        appAlertError('Process Error');
        console.log(err);
      }
    });
  }


  function remove_barcodes_from_production(order_id,operation_id,operation_point,barcodes){
    appAjaxRequest({
      url : BASE_URL + 'index.php/production/production/destroy_list',
      type : 'POST',
      dataType : 'json',
      data : {
        'order_id' : order_id,
        'operation_id' : operation_id,
        'operation_point' : operation_point,
        'barcodes' : barcodes
      },
      async : false,
      success : function(res){

      },
      error : function(err){
        appAlertError('Process Error');
        console.log(err);
      }
    });
  }


})();
