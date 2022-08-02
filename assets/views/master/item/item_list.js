var TABLE = null;
var MSG = null;
var SITE_VIEW = null;
var SITE_DEL = null;
var SEARCH_TEXT = '';

$(document).ready(function() {

    USER_VIEW = $('#user-view').val();
    USER_DEL = $('#user-del').val();

    var columns = [
      { "data": "item_id"},
      { "data": "item_code" },
      { "data": "item_description" },
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
				"data": "item_id",
				"orderable": false,
				'width':'5%',
				render : function(data, type, full, meta ){
					str = '<button class="btn btn-primary btn-xs" data-btn="view" data-id="'+data+'"><i class="fa fa-edit"></i></button> ';
          str += '<button class="btn btn-danger btn-xs" data-btn="delete" data-id="'+data+'"><i class="fa fa-remove"></i></button>';
          return str;
				}
			}
    ];


    TABLE = $('#item-table').DataTable( {
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
            "url": BASE_URL+"index.php/master/item/get_items",
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

$('#item-table').on('click','button',function(){
	var ele = $(this);
	var type = ele.attr('data-btn');
	if( type === 'view')
		open_site(this);
	else if(type === 'delete' )
		delete_site(this);
});

function open_site(ele)
{
    //alert($(ele).attr('data-id'));
    window.open(BASE_URL+'index.php/master/item/item_view/'+$(ele).attr('data-id'));
}


/*function delete_site(ele)
{
    $.alert.open({
        type : 'confirm',
        title : 'Delete User',
        content : 'Are you sure you want to delete this item?',
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
}*/
