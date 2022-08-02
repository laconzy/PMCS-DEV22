var TABLE = null;
var MSG = null;
var SITE_VIEW = null;
var SITE_DEL = null;
var SEARCH_TEXT = '';

$(document).ready(function() {

    //USER_VIEW = $('#user-view').val();
    //USER_DEL = $('#user-del').val();

    var columns = [
      { "data": "packing_id"},
      { "data": "packing_list_no" },
      { "data": "date" },
      { "data": "laysheet_no" },
      { "data": "buyer_code" },
      { "data": "style_no" },
      { "data": "buyer_po" },
			{
				"data": "packing_id",
				"orderable": false,
				'width':'5%',
				render : function(data, type, full, meta ){
					str = '<button class="btn btn-primary btn-xs" data-btn="view" data-id="'+data+'"><i class="fa fa-edit"></i></button> ';
          //str += '<button class="btn btn-danger btn-xs" data-btn="delete" data-id="'+data+'"><i class="fa fa-remove"></i></button>';
          return str;
				}
			}
    ];


    TABLE = $('#data-table').DataTable( {
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
            "url": BASE_URL+"index.php/inventory/inventory/get_packing_lists",
            "type": "POST",
            "data" : {
            	'searchText' : function(){return SEARCH_TEXT;}
            }
        },
        "columns": columns
    } );
} );

$('#btn-search').click(function(){
		SEARCH_TEXT = $('#search-text').val();
		TABLE.search("").draw();
	});

	$('#search-text').keypress(function(e) {
	    if(e.which == 13) {
	    	SEARCH_TEXT = $('#search-text').val();
			TABLE.search("").draw();
	    }
	});

$('#data-table').on('click','button',function(){
	var ele = $(this);
	var type = ele.attr('data-btn');
	if( type === 'view')
		open_packing_list(this);
	//else if(type === 'delete' )
	//	delete_color(this);
});

function open_packing_list(ele)
{
    //alert($(ele).attr('data-id'));
    window.open(BASE_URL+'index.php/inventory/inventory/inventory_view/'+$(ele).attr('data-id'));
}


// function delete_color(ele)
// {
//   var color_id = $(ele).attr('data-id');
//   appAlertConfirm('Do you want to deactivate selected color?' , function(){
//     appAjaxRequest({
//       url : BASE_URL + 'index.php/master/colour/destroy/'+color_id,
//       type: 'post',
//       dataType : 'json',
//       success : function(res){
//         if(res.status == 'success'){
//           appAlertSuccess(res.message);
//           TABLE.search("").draw();
//         }
//         else{
//           appAlertError('Process Error');
//         }
//       },
//       error : function(err){
//         alert(err);
//       }
//     });
//   });
// }
