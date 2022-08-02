(function(){

  var BASE_URL = null;
  var ORDER = null;
  var CONTRACT = null;
  var AOD = null;
  var GRN = null;

  $(document).ready(function(){

    BASE_URL = $('#base-url').val();

    $('#grn_date').datepicker({
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
        load_aod_list(CONTRACT.contract_no);
      }
    });

    $('#aod').change(function(){
      var aod_no = $(this).val().trim();
      if(aod_no != ''){
        AOD = null;
        load_aod(aod_no);
      }
    });


    $('#select_all').change(function(){
      $('#aod_table tbody input:checkbox').prop('checked',this.checked);
    });

    $('#select_all2').change(function(){
      $('#grn_table tbody input:checkbox').prop('checked',this.checked);
    });


    $('#btn_save_grn').click(function(){
      if(ORDER == null){
        	appAlertError('Select Customer Order');
          return;
      }
      if(CONTRACT == null){
        	appAlertError('Select Supplier Contract');
          return;
      }
      if(AOD == null){
        	appAlertError('Select Supplier AOD');
          return;
      }
      var grn_date = $('#grn_date').val().trim();
      if(grn_date == ''){
        	appAlertError('Select GRN Date');
          return;
      }
      var grn_no = (GRN == null) ? 0 : GRN.grn_no;
      save_grn_header(grn_no , ORDER.order_id , AOD.aod_no , grn_date);
    });


    $('#btn_add').click(function(){
      var data = [];
      $('#aod_table tbody input:checkbox').each(function(){
        if(this.checked == true){
          data.push($(this).attr('data-barcode'));
        }
      });
      if(AOD != null && data.length > 0){
        add_selected_barcodes(GRN.grn_no , AOD.aod_no, data);
      }
    });


    $('#btn_remove').click(function(){
      var data = [];
      $('#grn_table tbody input:checkbox').each(function(){
        if(this.checked == true){
          data.push($(this).attr('data-barcode'));
        }
      });
      if(data.length > 0){
        appAlertConfirm('Do you want to remove selected bundles from grn?' , function(){
          remove_grn_bundles(GRN.grn_no , data);
        });
      }

    });


    var hidden_grn_no = $('#hidden_grn_no').val();
    if(hidden_grn_no > 0){
      load_grn(hidden_grn_no);

      $('#title_grn_no').html(' - ' + GRN.grn_no)
      $('#div_aod_bundles').show();
      $('#div_grn_bundles').show();
      $('#grn_date').val(GRN.grn_date);

      load_aod(GRN.aod_no);

      $('#order_id').val(GRN.order_id);
      $('#btn_search').trigger('click');
      load_contract_list(GRN.order_id);
      $('#contract').val(AOD.contract_no).trigger('change');

      $('#aod').val(AOD.aod_no).trigger('change');

      load_aod_bundles(AOD.aod_no);
      load_grn_bundles(GRN.grn_no);
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
      //  $('#operation').val(CONTRACT.operation_name);
        $('#supplier').val(CONTRACT.supplier_name);
        $('#emb_type').val(CONTRACT.emb_name);
      },
      error : function(err){
        console.log(err);
      }
    });
  }


  function load_aod_list(contract_no){
    appAjaxRequest({
      url : BASE_URL + 'index.php/grn/get_contract_aods/' + contract_no ,
      type : 'GET',
      async : false,
      dataType : 'json',
      success : function(res){
        if(res.data != null || res.data != ''){
          var aods = res.data;
          var str = '<option value="">... Select Aod no ...</option>';
          for(var x = 0 ; x < aods.length ; x++){
            str += '<option value="'+aods[x]['aod_no']+'">'+aods[x]['aod_no']+'</option>';
          }
            $('#aod').html(str)
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


  function save_grn_header(grn_no , order_id , aod_no , grn_date){
    var data = {
      'grn_no' : grn_no,
      'order_id' : order_id,
      'aod_no' : aod_no,
      'grn_date' : grn_date
    }
    appAjaxRequest({
      url : BASE_URL + 'index.php/grn/save' ,
      type : 'POST',
      async : false,
      dataType : 'json',
      data : { 'form_data' : data },
      success : function(res){
        appAlertSuccess(res['message']);
        GRN = res.grn;
        $('#title_grn_no').html(' - ' + GRN.grn_no)
        $('#div_aod_bundles').show();
        $('#div_grn_bundles').show();
        load_aod_bundles(AOD.aod_no);
        load_grn_bundles(GRN.grn_no);
      },
      error : function(err){
        console.log(err);
      }
    });
  }


  function load_aod_bundles(aod_no){
    appAjaxRequest({
      url : BASE_URL + 'index.php/grn/get_aod_bundles/' + aod_no,
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
        $('#aod_table tbody').html(str);
      },
      error : function(err){
        console.log(err);
      }
    });
  }

  function load_grn_bundles(grn_no){
    appAjaxRequest({
      url : BASE_URL + 'index.php/grn/get_grn_bundles/' + grn_no,
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
        $('#grn_table tbody').html(str);
      },
      error : function(err){
        console.log(err);
      }
    });
  }


  function add_selected_barcodes(grn_no,aod_no,barcodes){
    appAjaxRequest({
      url : BASE_URL + 'index.php/grn/add_selected_barcodes' ,
      type : 'POST',
      async : false,
      dataType : 'json',
      data : {
        'barcodes' : barcodes ,
        'grn_no' : grn_no,
        'aod_no' : aod_no
      },
      success : function(res){
        if(res.status == 'success'){
          appAlertSuccess(res['message']);
          load_aod_bundles(AOD.aod_no);
          load_grn_bundles(GRN.grn_no);
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


  function remove_grn_bundles(grn_no , barcodes){
    appAjaxRequest({
      url : BASE_URL + 'index.php/grn/remove_barcodes' ,
      type : 'POST',
      async : false,
      dataType : 'json',
      data : {
        'barcodes' : barcodes ,
        'grn_no' : grn_no
      },
      success : function(res){
        if(res.status == 'success'){
          appAlertSuccess(res['message']);
          load_aod_bundles(AOD.aod_no);
          load_grn_bundles(GRN.grn_no);
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


  function load_grn(grn_no){
    appAjaxRequest({
      url : BASE_URL + 'index.php/grn/get_grn/' + grn_no ,
      type : 'GET',
      async : false,
      dataType : 'json',
      success : function(res){
        GRN = res.data;
      },
      error : function(err){
        console.log(err);
      }
    });
  }


})();
