var TABLE = null;
var MSG = null;
var SITE_VIEW = null;
var SITE_DEL = null;
var SEARCH_TEXT = '';

$(document).ready(function() {

    USER_VIEW = $('#user-view').val();
    USER_DEL = $('#user-del').val();

    var columns = [
      { "data": "grn_no"},
      { "data": "order_id" },
      { "data": "aod_no" },
      { "data": "grn_date" },
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
				"data": "grn_no",
				"orderable": false,
				'width':'5%',
				render : function(data, type, full, meta ){
					str = '<button class="btn btn-primary btn-xs" data-btn="view" data-id="'+data+'"><i class="fa fa-edit"></i></button> ';
          str += '<button class="btn btn-danger btn-xs" data-btn="delete" data-id="'+data+'"><i class="fa fa-remove"></i></button>';
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

    TABLE = $('#grn-table').DataTable( {
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
            "url": BASE_URL+"index.php/grn/get_grns",
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

$('#grn-table').on('click','button',function(){
	var ele = $(this);
	var type = ele.attr('data-btn');
	if( type === 'view')
		open_grn(this);
	else if(type === 'delete' )
		delete_grn(this);
});

function open_grn(ele)
{
    //alert($(ele).attr('data-id'));
    window.open(BASE_URL+'index.php/grn/show/'+$(ele).attr('data-id'));
}


function delete_grn(ele)
{
  var grn_no = $(ele).attr('data-id');
  appAlertConfirm('Do you want to deactivate selected grn?' , function(){
    appAjaxRequest({
      url : BASE_URL + 'index.php/grn/destroy/'+grn_no,
      type: 'post',
      dataType : 'json',
      success : function(res){
        if(res.status == 'success'){
          appAlertSuccess(res.message);
          TABLE.search("").draw();
        }
        else{
          appAlertError('Process Error');
        }
      },
      error : function(err){
        alert(err);
      }
    });
  });
}
