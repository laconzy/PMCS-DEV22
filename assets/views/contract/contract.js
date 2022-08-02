(function(){

    var ORDER = null;
    var ORDER_DETAILS = null;
    var CONTRACT_NO = 0;
    var CONTRACT = null;

    $(document).ready(function(){

      //date pickers
      $('.date').datepicker({
          format: "yyyy-mm-dd",
          viewMode: "days",
          minViewMode: "days"
      });

      initialize_form_validator();


      $('#btn_search').click(function(){
          ORDER = null;
          var order_id = $('#order_id').val();
          if(order_id != ''){
            load_order(order_id);
          }
      });


      $('#btn_save').click(function(){
        var form_data = $('#data-form').form_validator('validate');
  			if(form_data !== false)
  			{
          form_data['order_id'] = ORDER.order_id;
          var details = [];
          for(var x = 0 ; x < ORDER_DETAILS.length ; x++){
            var contract_qty = $('#row_'+x).find('input')[0].value;
            details.push({
              'item' : ORDER_DETAILS[x]['item_id'],
              'color' : ORDER_DETAILS[x]['color_id'],
              'size' : ORDER_DETAILS[x]['size'],
              'contract_qty' : contract_qty
            });
          }

          appAjaxRequest({
  					url : BASE_URL + 'index.php/contract/save',
  					data : {
              'data' : form_data,
              'details' : details
            },
  					async : false,
  					success : function(_serverResponse){
  						var response = JSON.parse(_serverResponse);
              CONTRACT_NO = response.contract_no;
              $('#title_contract_no').html(response.contract_no);
  						appAlertSuccess(response['message'],function(){
  							//window.open(BASE_URL + 'index.php/master/colour/color_view/' + response['color_id'] , '_self');
  						});
  					}
  				});
        }
      });


      $('#order_details_table tbody').on('change','input',function(){
        var ele = $(this);
        var max = ele.attr('data-max');
        var qty = ele.val();
        if(qty <= 0){
          ele.val(0);
          return;
        }

        if(qty > max){
          ele.val(max);
        }

      });


      $('#btn_print').click(function(){
        if(CONTRACT_NO != 0){
          window.open(BASE_URL + 'index.php/contract/print_contract/' + CONTRACT_NO + '/' + ORDER.order_id);
        }
      });


      var contract_no = $('#contract_no').val();
      if(contract_no > 0){
          load_contract(contract_no);
          load_order(CONTRACT.order_id);
          $('#external_operation').val(CONTRACT.operation).trigger('change');

          $('#order_id').val(ORDER.order_id);
          $('#supplier_po').val(CONTRACT.supplier_po);
          $('#supplier_po_price').val(CONTRACT.supplier_po_price);
          $('#currency').val(CONTRACT.currency);
          $('#supplier').val(CONTRACT.supplier);
          $('#item_component').val(CONTRACT.item_component);
          $('#emb_type').val(CONTRACT.emb_type);
          $('#delivery_date').val(CONTRACT.delivery_date);
      }


    });


    function initialize_form_validator(){
        $('#data-form').form_validator({
          events : ['blur'],
          fields : {
            'external_operation' : {
              key : 'operation',
              required : true
            },
            'supplier_po' : {
              required : true
            },
            'supplier_po_price' : {
              required : true
            },
            'currency' : {
              required : true
            },
            'supplier' : {
              required : true
            },
            'item_component' : {
              required : true
            },
            'emb_type' : {
              required : true
            },
            'delivery_date' : {
              required : true
            }
          }
        });
      }



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
            appFillFormData({
              'style' : ORDER.style_name,
              'customer_po' : ORDER.customer_po
            });
            order_summery(ORDER.order_id);
            order_operations(ORDER.order_id);
            load_order_components(ORDER.order_id);
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
        url : BASE_URL + 'index.php/order/order_operation/get/'+order_id+'/external',
        type : 'GET',
        dataType : 'json',
        async : false,
        success : function(res){
          var operations = res.data;
          var str = '<option value="">...Select operation...</option>';
          for(var x = 0 ; x < operations.length ; x++) {
              str += '<option value="'+operations[x]['operation_id']+'">'+operations[x]['operation_name']+'</option>';
          }
          $('#external_operation').html(str);
        },
        error : function(err){
          console.log(err);
        }
      });
    }


    function load_order_components(order_id){
      $('#item_component').html('<option value="">... Select Component ...</option>');
      appAjaxRequest({
        url : BASE_URL + 'index.php/contract/get_order_item_components/' + order_id,
        type : 'GET',
        dataType : 'json',
        async : false,
        success : function(res){
          if(res.data != null && res.data != ''){
            var components = res.data;
            var str = '<option value="">... Select Component ...</option>';
            for(var x = 0 ; x < components.length ; x++){
              str += '<option value="'+components[x]['item_component']+'">'+components[x]['com_code']+'</option>';
            }
            $('#item_component').html(str);
          }
        },
        error : function(err){
          console.log(err);
        }
      });
    }


    function order_summery(order_id){
      appAjaxRequest({
        url : BASE_URL + 'index.php/contract/get_order_summery/'+order_id,
        type : 'GET',
        dataType : 'json',
        /*async : false,*/
        success : function(res){
          var row = res.data;
          ORDER_DETAILS = res.data;
          var str = '';
          for(var x = 0 ; x < row.length ; x++) {
              str += '<tr id="row_'+x+'">';
              str += '<td>'+row[x]['item_code']+'</td>';
              str += '<td>'+row[x]['color_code']+'</td>';
              str += '<td>'+row[x]['size_code']+'</td>';
              str += '<td>'+row[x]['total']+'</td>';
              str += '<td> <input class="form-control input-sm" type="number" data-max="'+row[x]['total']+'" value="'+row[x]['total']+'" > </td>';
              str += '</tr>';
          }
          $('#order_details_table tbody').html(str);
        },
        error : function(err){
          console.log(err);
        }
      });
    }


    function load_contract(contract_no){
      appAjaxRequest({
        url : BASE_URL + 'index.php/contract/get_contract/'+contract_no,
        type : 'GET',
        dataType : 'json',
        async : false,
        success : function(res){
          CONTRACT = res.data;
          CONTRACT_NO = CONTRACT.contract_no;
        },
        error : function(err){
          console.log(err);
        }
      });
    }

})();
