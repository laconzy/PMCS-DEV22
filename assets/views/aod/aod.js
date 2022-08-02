(function(){

  var BASE_URL = null;
  var ORDER = null;
  var CONTRACT = null;
  var AOD = null;

  $(document).ready(function(){

    BASE_URL = $('#base-url').val();

    $('#aod_date').datepicker({
        format: "yyyy-mm-dd",
        viewMode: "days",
        minViewMode: "days"
    });

    $('#btn_search').click(function(){
        ORDER = null;
        CONTRACT = null;
        var order_id = $('#order_id').val().trim();
        if(order_id == '')
          return;
        load_order(order_id);
    });


    $('#contract').change(function(){
      var contract_no = $(this).val().trim();
      if(contract_no != ''){
        CONTRACT = null;
        load_contract(contract_no);
      }
    });


    $('#select_all').change(function(){
      $('#pending_table tbody input:checkbox').prop('checked',this.checked);
    });

    $('#select_all2').change(function(){
      $('#added_table tbody input:checkbox').prop('checked',this.checked);
    });


    $('#btn_save_aod').click(function(){
      if(ORDER == null){
        	appAlertError('Select Order');
          return;
      }
      if(CONTRACT == null){
        	appAlertError('Select Contract');
          return;
      }
      var aod_date = $('#aod_date').val().trim();
      if(aod_date == ''){
        	appAlertError('Select AOD Date');
          return;
      }
      var aod_no = (AOD == null) ? 0 : AOD.aod_no;
      save_aod_header(aod_no , ORDER.order_id , CONTRACT.contract_no , aod_date);
    });


    $('#btn_add').click(function(){
      var data = [];
      $('#pending_table tbody input:checkbox').each(function(){
        if(this.checked == true){
          data.push($(this).attr('data-barcode'));
        }
      });
      if(AOD != null && data.length > 0){
        add_selected_barcodes(ORDER.order_id, CONTRACT.operation, data, AOD.aod_no);
      }
    });


    $('#btn_remove').click(function(){
      var data = [];
      $('#added_table tbody input:checkbox').each(function(){
        if(this.checked == true){
          data.push($(this).attr('data-barcode'));
        }
      });
      if(data.length > 0){
        appAlertConfirm('Do you want to remove selected bundles from aod?' , function(){
          remove_aod_bundles(AOD.aod_no , data);
        });
      }

    });


    var hidden_aod_no = $('#aod_no').val();
    if(hidden_aod_no > 0){
      load_aod(hidden_aod_no);

      $('#title_aod_no').html(' - ' + AOD.aod_no)
      $('#div_pending_bundles').show();
      $('#div_aod_bundles').show();
      $('#aod_date').val(AOD.aod_date);

      $('#order_id').val(AOD.order_id);
      $('#btn_search').trigger('click');
      load_contract_list(AOD.order_id);
      $('#contract').val(AOD.contract_no).trigger('change');

      load_pending_bundles(ORDER.order_id , CONTRACT.operation);
      load_added_bundles(AOD.aod_no);
    }


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
          load_contract_list(ORDER.order_id);
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


  function load_contract_list(order_id){
    appAjaxRequest({
      url : BASE_URL + 'index.php/contract/get_order_contracts/' + order_id ,
      type : 'GET',
      async : false,
      dataType : 'json',
      success : function(res){
        if(res.data != null || res.data != ''){
          var contracts = res.data;
          var str = '<option value="">... Select Contract ...</option>';
          for(var x = 0 ; x < contracts.length ; x++){
            str += '<option value="'+contracts[x]['contract_no']+'">'+contracts[x]['contract_no']+'</option>';
          }
            $('#contract').html(str)
        }
      },
      error : function(err){
        console.log(err);
      }
    });
  }


  function load_contract(contract_id){
    appAjaxRequest({
      url : BASE_URL + 'index.php/contract/get_contract/' + contract_id ,
      type : 'GET',
      async : false,
      dataType : 'json',
      success : function(res){
        CONTRACT = res.data;
        $('#operation').val(CONTRACT.operation_name);
        $('#supplier').val(CONTRACT.supplier_name);
        $('#emb_type').val(CONTRACT.emb_name);
      },
      error : function(err){
        console.log(err);
      }
    });
  }


  function load_pending_bundles(order_id,operation){
    appAjaxRequest({
      url : BASE_URL + 'index.php/aod/get_pending_bundles/' + order_id +'/'+operation,
      type : 'GET',
      async : false,
      dataType : 'json',
      success : function(res){
        var bundles = res.data;
        var str = '';
        for(var x = 0 ; x < bundles.length ; x++){
          str += '<tr">';
          str += '<td> <input type="checkbox" data-barcode="'+bundles[x]['barcode']+'"> </td>';
          str += '<td>' + bundles[x]['item_code'] + '</td>';
          str += '<td>' + bundles[x]['bundle_no'] + '</td>';
          str += '<td>' + bundles[x]['barcode'] + '</td>';
          str += '<td>' + bundles[x]['size_code'] + '</td>';
          str += '<td>' + bundles[x]['qty'] + '</td>';
          str += '</tr>';
        }
        $('#pending_table tbody').html(str);
      },
      error : function(err){
        console.log(err);
      }
    });
  }


  function load_added_bundles(aod_no){
    appAjaxRequest({
      url : BASE_URL + 'index.php/aod/get_added_bundles/' + aod_no,
      type : 'GET',
      async : false,
      dataType : 'json',
      success : function(res){
        var bundles = res.data;
        var str = '';
        for(var x = 0 ; x < bundles.length ; x++){
          str += '<tr">';
          str += '<td> <input type="checkbox" data-barcode="'+bundles[x]['barcode']+'"> </td>';
          str += '<td>' + bundles[x]['item_code'] + '</td>';
          str += '<td>' + bundles[x]['bundle_no'] + '</td>';
          str += '<td>' + bundles[x]['barcode'] + '</td>';
          str += '<td>' + bundles[x]['size_code'] + '</td>';
          str += '<td>' + bundles[x]['qty'] + '</td>';
          str += '</tr>';
        }
        $('#added_table tbody').html(str);
      },
      error : function(err){
        console.log(err);
      }
    });
  }


  function save_aod_header(aod_no , order_id , contract_no , aod_date){
    var data = {
      'aod_no' : aod_no,
      'order_id' : order_id,
      'contract_no' : contract_no,
      'aod_date' : aod_date
    }
    appAjaxRequest({
      url : BASE_URL + 'index.php/aod/save' ,
      type : 'POST',
      async : false,
      dataType : 'json',
      data : { 'form_data' : data },
      success : function(res){
        appAlertSuccess(res['message']);
        AOD = res.aod;
        $('#title_aod_no').html(' - ' + AOD.aod_no)
        $('#div_pending_bundles').show();
        $('#div_aod_bundles').show();
        load_pending_bundles(ORDER.order_id , CONTRACT.operation);
      },
      error : function(err){
        console.log(err);
      }
    });
  }


  function add_selected_barcodes(order_id, operation, barcodes , aod_no){
    appAjaxRequest({
      url : BASE_URL + 'index.php/aod/add_selected_barcodes' ,
      type : 'POST',
      async : false,
      dataType : 'json',
      data : {
        'order_id' : order_id,
        'operation' : operation,
        'barcodes' : barcodes ,
        'aod_no' : aod_no
      },
      success : function(res){
        if(res.status == 'success'){
          appAlertSuccess(res['message']);
          load_pending_bundles(ORDER.order_id , CONTRACT.operation);
          load_added_bundles(AOD.aod_no);
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


  function remove_aod_bundles(aod_no , barcodes){
    appAjaxRequest({
      url : BASE_URL + 'index.php/aod/remove_barcodes' ,
      type : 'POST',
      async : false,
      dataType : 'json',
      data : {
        'barcodes' : barcodes ,
        'aod_no' : aod_no
      },
      success : function(res){
        if(res.status == 'success'){
          appAlertSuccess(res['message']);
          load_pending_bundles(ORDER.order_id , CONTRACT.operation);
          load_added_bundles(AOD.aod_no);
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


  function load_aod(aod_no){
    appAjaxRequest({
      url : BASE_URL + 'index.php/aod/get_aod/' + aod_no ,
      type : 'GET',
      async : false,
      dataType : 'json',
      success : function(res){
        AOD = res.data;
      },
      error : function(err){
        console.log(err);
      }
    });
  }


})();
