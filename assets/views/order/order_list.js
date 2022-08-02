var TABLE = null;
var MSG = null;
var SITE_VIEW = null;
var SITE_DEL = null;
var SEARCH_TEXT = '';
var COMPLETE_FILTER = '';

$(document).ready(function() {

    var columns = [
      { "data": "order_id"},
      { "data": "order_code" },
      { "data": "style_name" },
      { "data": "color_name" },
      { "data": "customer_po" },
      { "data": "uom" },
      { "data": "country_name" },
      { "data": "ship_method" },
      { "data": "delivary_date" },
      { "data": "season_name" },
      {
        "data": "active",
        render : function(data){
          if(data == 'Y')
            return '<span class="text-success">Active</span>';
          else
            return '<span class="text-danger">Deactive</span>';
        }
      },
      {
        "data": "is_complete",
        render : function(data){
          if(data == 1)
            return '<span class="text-success">Yes</span>';
          else
            return '<span class="text-danger">No</span>';
        }
      },
			{
				"data": "order_id",
				"orderable": false,
				'width':'5%',
				render : function(data, type, full, meta ){
					str = '<button class="btn btn-primary btn-xs" data-type="VIEW" data-id="'+data+'"><i class="fa fa-edit"></i></button> ';
          str += '<button class="btn btn-danger btn-xs" data-type="DELETE" data-id="'+data+'"><i class="fa fa-remove"></i></button> ';
          str += '<button class="btn btn-info btn-xs" data-type="RECON" data-id="'+data+'">Reconciliation</button> ';
          return str;
				}
			}
    ];

    /*if(USER_VIEW == 1){
        columns.push({
            "orderable": false,
            'data' : function(_data,a){
                return '<button class="btn btn-success btn-flat btn-sm" data-id="'+_data['id']+'" onclick="edit_user(this);">Edit</button>';
            }
        });
    }
    if(USER_DEL == 1){
        columns.push({
            "orderable": false,
            data : function(_data){
                return '<button class="btn btn-danger btn-flat btn-sm" data-id="'+_data['id']+'" onclick="delete_user(this)" disabled="disabled">Delete</button>';
            }
        });
    }*/

    TABLE = $('#sites-table').DataTable( {
      "scrollY": "500px",
		  "scrollX": true,
		  "scrollCollapse": true,
      "autowidth":false,
		    /*"fixedColumns": {
			     leftColumns: 1
		  },*/
		  "searching": false,
		  "select": true,
		  "processing": true,
		  "serverSide": true,
        "ajax": {
            "url": BASE_URL+"index.php/order/order/get/datatable",
            "type": "GET",
            "data" : {
            	'searchText' : function(){return SEARCH_TEXT;},
              'completeFilter' : function(){return COMPLETE_FILTER;}
            }
        },
        "columns": columns
    } );


    $('#btn-export').click(function(){
      appAjaxRequest({
        url : BASE_URL + 'index.php/order/order/export_data',
        type : 'GET',
        dataType : 'json',
        async : false,
        data : {
          'searchText' : SEARCH_TEXT,
          'completeFilter' : COMPLETE_FILTER
        },
        success : function(res){
          if(res.data != undefined && res.data != null){
            ExportToExcel(res.data, 'xlsx');
          }
          else {
            appAlertError('Error occured while exporting data');
          }
        },
        error : function(err){
          console.log(err);
        }
      });
    });


} );

$('#btn-search').click(function(){
		SEARCH_TEXT = $('#search-text').val();
    COMPLETE_FILTER = $('#filter-complete').val();
		TABLE.search("").draw();
	});

	$('#search-text').keypress(function(e) {
	    if(e.which == 13) {
	    	SEARCH_TEXT = $('#search-text').val();
        COMPLETE_FILTER = $('#filter-complete').val();
			TABLE.search("").draw();
	    }
	});

$('#sites-table').on('click','button',function(){
	var ele = $(this);
	var type = ele.attr('data-type');
	if( type === 'VIEW')
		open_order(this);
	else if(type === 'DELETE' )
		delete_order(this);
  else if(type === 'RECON' )
		reconciliation_report(this);
});

function open_order(ele)
{
    //alert($(ele).attr('data-id'));
    window.open(BASE_URL+'index.php/order/order/show/'+$(ele).attr('data-id'));
}


function delete_order(ele)
{
    appAlertConfirm('Are you sure you want to delete this order?' , function(){
      appAjaxRequest({
        url : BASE_URL + 'index.php/order/order/destroy/'+$(ele).attr('data-id'),
        type : 'GET',
        dataType : 'json',
        success : function(res){
          if(res.status == 'success'){
            appAlertSuccess(res.message);
            TABLE.ajax.reload( null, false );
          }
          else{
            appAlertError('Deleting Error');
          }
        },
        error : function(err){
          console.log(err);
        }
      });
    });
}


function reconciliation_report(ele){
  window.open(BASE_URL + 'index.php/order/order/reconciliation_report/' + $(ele).attr('data-id'), '_blank');
}

function ExportToExcel(data_set, type, fn, dl) {
  if(data_set != null && data_set.length > 0){
    //load data to hidden table
    let str = '';
    for(let x = 0 ; x < data_set.length ; x++){
      let active_status = (data_set[x]['active'] == 'Y') ? 'Active' : 'Inactive';
      let complete_status =  (data_set[x]['is_complete'] == 1) ? 'Complete' : 'Incomplete';

      str += `<tr>
      <td>${data_set[x]['order_id']}</td>
      <td>${data_set[x]['order_code']}</td>
      <td>${data_set[x]['style_name']}</td>
      <td>${data_set[x]['color_name']}</td>
      <td>${data_set[x]['customer_po']}</td>
      <td>${data_set[x]['uom']}</td>
      <td>${data_set[x]['country_name']}</td>
      <td>${data_set[x]['ship_method']}</td>
      <td>${data_set[x]['delivary_date']}</td>
      <td>${data_set[x]['season_name']}</td>
      <td>${active_status}</td>
      <td>${complete_status}</td>
      </tr>`;
    }
    $('#hidden_table tbody').html(str);

    var elt = document.getElementById('hidden_table');
    var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
    return dl ?
        XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
        XLSX.writeFile(wb, fn || ('orders.' + (type || 'xlsx')));
  }
}
