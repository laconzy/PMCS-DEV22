(function(){



    var BASE_URL = null;

    var ORDER_ID = 0;



    $(document).ready(function(){



        BASE_URL = $('#base-url').val();

        ORDER_ID = $('#order_id').val();



        //select 2 boxes

        $("#style").select2({

          ajax: {

            url: BASE_URL + 'index.php/master/style/search',

            dataType: 'json'

          }

        });



        $(".color").select2({

          ajax: {

            url: BASE_URL + 'index.php/master/colour/search',

            dataType: 'json'

          }

        });



        $("#order_item_search").select2({

          ajax: {

            url: BASE_URL + 'index.php/master/item/search',

            dataType: 'json'

          }

        });



        $("#item_size_search").select2({

          ajax: {

            url: BASE_URL + 'index.php/master/size/search',

            dataType: 'json'

          }

        });





        $("#customer").select2({

          ajax: {

            url: BASE_URL + 'index.php/master/customer/search',

            dataType: 'json'

          }

        });



        //date pickers

        $('.date').datepicker({

            format: "yyyy-mm-dd",

            viewMode: "days",

            minViewMode: "days"

        });





      $('#item_order_qty').keyup(function(){

        var qty = $(this).val();

        qty = parseInt(qty);

        var planned_qty = ((qty * 3) / 100) + qty;

        $('#item_planned_qty').val(parseInt(planned_qty));

      });

        //nevighation buttons

      /*  $('#btnNext').click(function(){

            $('.nav-tabs > .active').next('li').find('a').trigger('click');

        });



        $('#btnPrevious').click(function(){

            $('.nav-tabs > .active').prev('li').find('a').trigger('click');

        });



        $('#btnNext2').click(function(){

            $('.nav-tabs > .active').next('li').find('a').trigger('click');

        });*/



    initialize_form_validator();



    if(ORDER_ID > 0){

      get_order(ORDER_ID);

      load_order_items(ORDER_ID);

      //load_operations(ORDER_ID); no need for this project

    }





	//not use in this project

    /*$('#btn_add_operation').click(function(){

      var data = {

        'order_id' : ORDER_ID ,

        'operation' : $('#operation').val()

      }

      appAjaxRequest({

        url : BASE_URL + 'index.php/order/order_operation/save',

        type: 'POST',

        dataType : 'json',

        data : { 'data' : data},

        success : function(res){

          if(res['status'] == 'success') {

            var str = '<tr>';

            str += '<td>' + res['operation']['operation_name'] + '</td> <td> ' + res['operation']['operation_type'] + '</td>';

            str += '<td>' + res['operation']['uom_in'] + '</td> <td> ' + res['operation']['uom_out'] + '</td>';

            str += '<td>' + res['operation']['operation_order'] + '</td>';

            str += '<td> <button class="btn btn-danger btn-xs" data-id="'+res['operation']['operation']+'">Delete</button> </td>';

            str += '</tr>';

            $('#operation_table tbody').append(str);

          }

        },

        error : function(err){

          alert(err);

        }

      });

    });*/





    $('#btn_new_item').click(function(){

      $('#order_item_id').val(0);

      $('#order_item_search').val(null).trigger('change');

      $('#item_color_search').val(null).trigger('change');

      $('#item_size_search').val(null).trigger('change');

      $('#tbl_order_item_sizes tbody').html('');

      $('#tbl_order_item tbody').html('');

      $('#item_description,#item_planned_qty,#item_order_qty').val('');

      $('#item_model').modal('show');

    });



});



/*$('#item_model').on('shown.bs.modal', function () {

  alert();

})*/



$('#style').on('select2:select', function (e) {

    $('#style_name').val(e.params.data.style_name);

});



$('#color').on('select2:select', function (e) {

    $('#color_name').val(e.params.data.color_name);

});



$('#customer').on('select2:select', function (e) {

    $('#customer_name').val(e.params.data.cus_name);

});





//load item components when selecting item

$('#order_item_search').on('select2:select', function (e) {

    $('#item_description').val(e.params.data.item_description);

    appAjaxRequest({

      url : BASE_URL + 'index.php/master/item/get_item_components',

      type: 'get',

      dataType : 'json',

      data : { 'item_id' : e.params.data.id },

	  async: false,

      success : function(res){

        var str = '';

        for(var x = 0 ; x < res.length ; x++) {

          var tr_id = 'tr_com_' + x;

          str += '<tr id="' + tr_id + '" data-component="' + res[x]['component_id'] + '">';

          str += '<td>' + res[x]['com_code'] + '</td> <td> ' + res[x]['com_description'] + '</td>';

          str += '<td> <select id="'+tr_id+'_color" class="color2" style="width:90%"></select> </td>';

          str += '</tr>';

        };

        $('#tbl_order_item tbody').html(str);

        $(".color2").select2({

          ajax: {

            url: BASE_URL + 'index.php/master/colour/search',

            dataType: 'json'

          }

        });

      },

      error : function(err){

        alert(err);

      }

    });

});



//not using

/*$('#operation_table tbody').on('click','button',function(){

  var ele = $(this);

  remove_operation(ORDER_ID , ele.attr('data-id'));

  ele.parent().parent().remove();

})*/



//zizes to items

$('#btn_add_sizes').click(function(){



    var size_id = $('#item_size_search').val();

    var size = $('#item_size_search').select2('data')[0]['text'];

    var ord_qty = $('#item_order_qty').val();

    var planned_qty = $('#item_planned_qty').val();

    var has_duplicate = false;



    if(size == '' || ord_qty == '' || planned_qty == ''){

      appAlertError('Incorrect Data. You must add size, order qty and planned qty');

      return false;

    }



    $('#tbl_order_item_sizes tbody').find('tr').each(function(){

        if($(this).attr('data-size') == size_id){

          has_duplicate = true;

        }

    });



    if(has_duplicate == true){

      appAlertError('Duplicate size');

      return false;

    }





    var str = '<tr data-size="'+size_id+'">';

    str += '<td>' + size + '</td> <td>' + ord_qty + '</td> <td>' + planned_qty + '</td>';

    str += '<td><button class="btn btn-danger btn-xs" data-size="'+size+'">Delete</button></td>';

    str += '</tr>';

    $('#tbl_order_item_sizes tbody').append(str);

});





$('#tbl_order_item_sizes tbody').on('click','button',function(){

  var ele = $(this);

  var message = 'Do you want to remove size ' + $(this).attr('data-size') + ' ?' ;

  appAlertConfirm(message , function(){

    ele.parent().parent().remove();

  });

})





//save order details header

$('#btn_order_save').click(function(){

   var obj =  $('#data-form').form_validator('validate');

   if(obj !== undefined && obj !== false)  {

     save_order(obj);

   }

});



//save order item

$('#btn_save_items').click(function(){

    var item = $('#order_item_search').val();

    var item_color = $('#item_color_search').val();

    var order_item_id = $('#order_item_id').val();



    if(item == '' || item== null || item_color == '' || item_color == null){

      appAlertError('You must select item and item color first');

      return false;

    }



    var data = {

      'order_item_id' : order_item_id,

      'order_id' : ORDER_ID,

      'item' : item,

      'item_color' : item_color

    }



    var components = get_item_components_from_table();//get item components

    if(components == null || components.length <= 0){

      appAlertError('Incorrect Component Colors');

      return false;

    }



    var sizes = get_item_sizes_from_table();//get item sizes and qty

    if(sizes.length <= 0){

      appAlertError('You must add atleast one size to an item');

      return false;

    }



    save_order_item(data , components , sizes);



});





$('#order_table tbody').on('click','button',function(){

  var ele = $(this);

  var type = ele.attr('data-type');

  var id = ele.attr('data-id');



  if(type == 'VIEW'){

    get_order_item(id);

    $('#item_model').modal('show');

  }

  else if(type == 'DELETE'){

    appAlertConfirm('Do you want to remove item from order?',function(){

      delete_order_item(id);

      ele.parent().parent().remove();

    });

  }

});











function initialize_form_validator() {

    $('#data-form').form_validator({
        events : ['blur'],
        fields : {
            'order_id' : {
              'key' : 'order_id'
            },
            'order_code' : {
                'key' : 'order_code',
                'required': {
                    'errorMessage' : 'Order code cannot be empty'
                }
            },
            'style' : {
                'key' : 'style',
                'required': {
                    'errorMessage' : 'Style code cannot be empty'
                }
            },
            'color' : {
                'key' : 'color',
                'required': {
                    'errorMessage' : 'Colour code cannot be empty'
                }
            },
            'customer' : {
                'key' : 'customer',
                'required': {
                    'errorMessage' : 'Customer Code cannot be empty'
                }
            },
            'customer_po' : {
                'key' : 'customer_po',
                'required': {
                    'errorMessage' : 'Customer PO cannot be empty'
                }
            },
            'uom' : {
                'key' : 'uom',
                'required': {
                    'errorMessage' : 'UOM cannot be empty'
                }
            },
            'ship_method' : {
                'key' : 'ship_method',
                'required': {
                    'errorMessage' : 'Ship Method cannot be empty'
                }
            },
            'country' : {
                'key' : 'country',
                'required': {
                    'errorMessage' : 'Country cannot be empty'
                }
            },
            'delivary_date' : {
                'key' : 'delivary_date',
                'required': {
                    'errorMessage' : 'Delivery date cannot be empty'
                }
            },
            'pcd_date' : {
                'key' : 'pcd_date',
                'required': {
                    'errorMessage' : 'PCD date cannot be empty'
                }
            },
            'planned_delivary_date' : {
                'key' : 'planned_delivary_date',
                'required': {
                    'errorMessage' : 'Plan Deli Date cannot be empty'
                }
            },
           'season' : {
              'key' : 'season',
              'minLength': {
              'minValue' : 10,
              'errorMessage' : 'Season cannot be empty'
              }
            },
           'sales_qty' : {
               'key' : 'sales_qty',
               'required': {
                   'errorMessage' : 'Sales qty cannot be empty'
               }
           },
           'smv' : {
               'key' : 'smv',
               'required': {
                   'errorMessage' : 'SMV cannot be empty'
               }
           },
           'shipment_complete' : {
   					key : 'shipment_complete',
   					checkbox : {
   						checkValue : 1,
   						uncheckValue : 0
   					}
   				}

       }



  });

}







//save order header details

function save_order(_data) {

  appAjaxRequest({

     url : BASE_URL + 'index.php/order/order/save',

     data : { 'data' : _data },

     async : false,

     type : 'POST',

     success : function(response){

         try{

             var obj = JSON.parse(response);

             if(obj['status'] == 'success') {

               appAlertSuccess(obj['message'],function(){

                   $('#order_id').val(obj['order_id']);

                   ORDER_ID = obj['order_id'];

                   //$('#tab-2,#tab-3,#tab_head_2,#tab_head_3').css('display','');

				   $('#tab-2,#tab_head_2').css('display','');

               });

             }

             else {

               appAlertError(obj['message']);

             }

         }

         catch(e) {

             alert('Time Out...Please Re-Login');

         }

     }

 });

}



//save order item details

function save_order_item(_data,_components,_sizes) {

  appAjaxRequest({

    url : BASE_URL + 'index.php/order/order_item/save',

    type : 'POST',

    async : false,

    dataType : 'json',

    data : {

      'data' : _data,

      'components' : _components,

      'sizes' : _sizes

    },

    success : function(res){

        if(res['status'] = 'success'){

          appAlertSuccess(res['message'],function(){

            $('#order_item_search').val(null).trigger('change');

            $('#item_color_search').val(null).trigger('change');

            $('#item_size_search').val(null).trigger('change');

            $('#tbl_order_item_sizes tbody').html('');

            $('#tbl_order_item tbody').html('');

            $('#item_description,#item_planned_qty,#item_order_qty').val('');



            if(_data['order_item_id'] > 0){

              load_order_items(_data['order_id']);

              $('#item_model').modal('hide');

            }

            else{

              load_order_item(res.order_item);//add saved item to the item list

            }



          });

        }

        else{

          appAlertError(res['message']);

        }

    },

    error : function(err){

      console.log(err);

    }

  });

}



//add saved oreder item to the table

function load_order_item(_item) {

  var str = '<tr> <td>'+_item.item_code+'</td> <td>'+_item.item_description+'</td> <td>'+_item.color_code+'</td>';

  str += '<td>'+_item.order_qty+'</td>';

  str += '<td>'+_item.planned_qty+'</td>';

  str += '<td> <button data-type="VIEW" data-id="'+_item.id+'" class="btn btn-primary btn-xs">More</button>  <button data-type="DELETE" data-id="'+_item.id+'" class="btn btn-danger btn-xs">Delete</button></td>';

  $('#order_table tbody').append(str);

}



//get all order items from the server

function load_order_items(_order_id) {

  appAjaxRequest({

    url : BASE_URL + 'index.php/order/order_item/get/' + _order_id + '/all',

    type : 'GET',

    dataType : 'json',

    success : function(res){

      var str = '';

      for(var x = 0 ; x < res.data.length ; x++) {

         var item = res.data[x];

         str += '<tr> <td>'+ item.item_code +'</td> <td>'+ item.item_description +'</td> <td>'+ item.color_code +'</td>';

         str += '<td>'+ item.order_qty +'</td>';

         str += '<td>'+ item.planned_qty +'</td>';

         str += '<td> <button data-type="VIEW" data-id="'+item.id+'" class="btn btn-primary btn-xs">More</button>  <button data-type="DELETE" data-id="'+item.id+'" class="btn btn-danger btn-xs">Delete</button></td>';

      }

      $('#order_table tbody').html(str);

    },

    error : function(err){

      console.log(err);

    }

  });

}





//not using

//get all order $operations

/*function load_operations(_order_id){

  appAjaxRequest({

    url : BASE_URL + 'index.php/order/order_operation/get/' + _order_id + '/all',

    type : 'GET',

    dataType : 'json',

    success : function(res){

      var str = '';

      for(var x = 0 ; x < res.data.length ; x++) {

         var operation = res.data[x];

         str += '<tr> <td>'+ operation.operation_name +'</td> <td>'+ operation.operation_type +'</td> ';

         str += '<td>'+ operation.uom_in +'</td> <td>'+ operation.uom_out +'</td> ';

         str += '<td>'+ operation.operation_order +'</td> ';

         str += '<td><button class="btn btn-danger btn-xs" data-id="'+operation.operation+'">Delete</button> </td> </tr>';

      }

      $('#operation_table tbody').html(str);

    },

    error : function(err){

      console.log(err);

    }

  });

}*/





//get full order item details from the server

function get_order_item(_order_id) {

  appAjaxRequest({

    url : BASE_URL + 'index.php/order/order_item/get/' + _order_id,

    type : 'GET',

    dataType : 'json',

    success : function(res){

      var data = res.data;

      var components = res.components;

      var sizes = res.sizes;

      $('#order_item_id').val(data.id);

      $("#order_item_search").empty().append('<option value="'+ data.item +'">'+ data.item_code+'</option>').val(data.item).trigger('change');

      $("#item_color_search").empty().append('<option value="'+ data.item_color +'">'+ data.color_code+'</option>').val(data.item_color).trigger('change');

      $('#item_description').val(data.item_description);



      //load components to table

      var str = '';

      for(var x = 0 ; x < components.length ; x++) {

        var tr_id = 'tr_com_' + x;

        str += '<tr id="' + tr_id + '" data-component="' + components[x]['item_component'] + '">';

        str += '<td>' + components[x]['com_code'] + '</td> <td> ' + components[x]['com_description'] + '</td>';

        str += '<td> <select id="'+tr_id+'_color" class="color2" style="width:90%"> <option value="'+components[x]['component_color']+'" selected> '+components[x]['color_code']+' </option> </select> </td>';

        str += '</tr>';

      };

      $('#tbl_order_item tbody').html(str);

      $(".color2").select2({

        ajax: {

          url: BASE_URL + 'index.php/master/colour/search',

          dataType: 'json'

        }

      });



      //load sizes to table

      var str2 = '';

      for(var x = 0 ; x < sizes.length ; x++) {

        str2 += '<tr data-size="'+sizes[x]['size']+'">';

        str2 += '<td>' + sizes[x]['size_code'] + '</td> <td>' + sizes[x]['order_qty'] + '</td> <td>' + sizes[x]['planned_qty'] + '</td>';

        str2 += '<td><button class="btn btn-danger btn-xs" data-size="'+sizes[x]['size']+'">Delete</button></td>';

        str2 += '</tr>';

      }

      $('#tbl_order_item_sizes tbody').html(str2);



    },

    error : function(err){

      console.log(err);

    }

  });

}



//get the added components od the item

function get_item_components_from_table() {

  var components = [];

  $('#tbl_order_item tbody').find('tr').each(function(){ //get item components

      var tr = $(this);

      var tr_id = tr.attr('id');

      var color_id = $('#'+tr_id+'_color').val();

      if(color_id == null || color_id == ''){

        return false;

      }

      components.push({

        component_id : tr.attr('data-component'),

        color_id :color_id

      });

  });

  return components;

}



//get added item sizes if a item

function get_item_sizes_from_table() {

  var sizes = [];

  $('#tbl_order_item_sizes tbody').find('tr').each(function(){

    var tr = $(this);

    var tds =tr.find('td');

    sizes.push({

      size_id : tr.attr('data-size'),

      order_qty : tds[1].innerHTML,

      planned_qty : tds[2].innerHTML

    });

  });

  return sizes;

}





//get order header details

function get_order(order_id){

  appAjaxRequest({

    url : BASE_URL + 'index.php/order/order/get',

    type : 'GET',

    async : false,

    dataType : 'json',

    data : { 'order_id' : order_id },

    success : function(res){

      appFillFormData(res.data);

      if(res.data.shipment_complete == undefined || res.data.shipment_complete == null || res.data.shipment_complete == 0){
        $( "#shipment_complete" ).prop( "checked", false);
      }
      else if(res.data.shipment_complete == 1){
        $( "#shipment_complete" ).prop( "checked", true);
      }

      $("#style").empty().append('<option value="'+res.data.style+'">'+res.data.style_code+'</option>').val(res.data.style).trigger('change');

      $("#color").empty().append('<option value="'+res.data.color+'">'+res.data.color_code+'</option>').val(res.data.color).trigger('change');

      $("#customer").empty().append('<option value="'+res.data.customer+'">'+res.data.cus_code+'</option>').val(res.data.customer).trigger('change');

    },

    error : function(err){

      console.log(err);

    }

  });

}





//delete order itrm vith components and sizes

function delete_order_item(id){

  appAjaxRequest({

    url : BASE_URL + 'index.php/order/order_item/destroy/'+id,

    type : 'GET',

    async : false,

    dataType : 'json',

    success : function(res){

      if(res.status == 'success')

        appAlertSuccess(res.message);

      else

        appAlertError('Error occured when deleting');

    },

    error : function(err){

      console.log(err);

    }

  });

}





//not using

//remove operation from an order

/*function remove_operation(order_id,operation){

  appAjaxRequest({

    url : BASE_URL + 'index.php/order/order_operation/destroy/'+order_id+'/'+operation,

    type : 'GET',

    async : false,

    dataType : 'json',

    success : function(res){

    },

    error : function(err){

      console.log(err);

    }

  });

}*/





})();
