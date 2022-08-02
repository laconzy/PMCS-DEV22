var TABLE = null;
var MSG = null;
var SITE_VIEW = null;
var SITE_DEL = null;
var SEARCH_TEXT = '';

$(document).ready(function() {

    USER_VIEW = $('#user-view').val();
    USER_DEL = $('#user-del').val();

    var columns = [
      { "data": "contract_no"},
      { "data": "order_id" },
      { "data": "operation_name" },
      { "data": "supplier_po" },
      { "data": "supplier_po_price" },
      { "data": "currency" },
      { "data": "supplier_name" },
      { "data": "com_code" },
      { "data": "emb_name" },
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
				"data": "contract_no",
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

    TABLE = $('#contract-table').DataTable( {
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
            "url": BASE_URL+"index.php/contract/get_list",
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

$('#contract-table').on('click','button',function(){
	var ele = $(this);
	var type = ele.attr('data-btn');
	if( type === 'view')
		open_contract(this);
	else if(type === 'delete' )
		delete_contract(this);
});

function open_contract(ele)
{
    //alert($(ele).attr('data-id'));
    window.open(BASE_URL+'index.php/contract/show/'+$(ele).attr('data-id'));
}


function delete_contract(ele)
{
    $.alert.open({
        type : 'confirm',
        title : 'Delete User',
        content : 'Are you sure you want to delete this user?',
        icon : 'warning',
        callback : function(button) {
            if(button == 'yes')
            {
                make_ajax_request({
                    url : BASE_URL+'index.php/user/delete_user/'+$(ele).attr('data-id'),
                    success : function(response){
                        try{
                            var obj = JSON.parse(response);
                            if(obj['status'] == true)
                            {
                                $.alert.open({
                                    type : 'info',
                                    title : 'Delete User',
                                    content : obj['message'],
                                    icon : 'confirm'
                                });
                                TABLE.ajax.reload( null, false );
                            }
                            else
                            {
                               $.alert.open({
                                    type : 'error',
                                    title : 'Delete User',
                                    content : obj['message']
                                });
                            }
                        }
                        catch(e)
                        {
                            alert(e);
                        }
                    }
                });
            }
        }
    });
}
