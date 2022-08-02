var TABLE = null;
var MSG = null;
var SITE_VIEW = null;
var SITE_DEL = null;
var SEARCH_TEXT = '';

$(document).ready(function() {

    USER_VIEW = $('#user-view').val();
    USER_DEL = $('#user-del').val();

    var columns = [
      { "data": "id"},
      { "data": "order_id" },
      { "data": "style_code" },
      { "data": "color_code" },
      { "data": "full_name" },
      { "data": "requested_date" },
      {
				"data": "status",
				render : function(data, type, full, meta ){
          if(data == 'ACTIVE'){
            return '<span style="color:green">ACTIVE</span>';
          }
          else if(data == 'CANCELLED'){
            return '<span style="color:red">CANCELLED</span>';
          }
          else {
            return '';
          }
				}
			},
			{
				"data": "id",
				"orderable": false,
				'width':'5%',
				render : function(data, type, full, meta ){
					str = '<button class="btn btn-primary btn-xs" data-btn="view" data-id="'+data+'"><i class="fa fa-edit"></i></button> ';
          str += '<button class="btn btn-danger btn-xs" data-btn="delete" data-id="'+data+'"><i class="fa fa-remove"></i></button>';
          return str;
				}
			}
    ];


    TABLE = $('#data-table').DataTable( {
      "scrollY": "500px",
		  "scrollX": true,
		  "scrollCollapse": true,
      "autowidth":false,
		  "order": [[ 0, "desc" ]],
		  "searching": false,
		  "select": true,
		  "processing": true,
		  "serverSide": true,
        "ajax": {
            "url": BASE_URL+"index.php/production/recut/get_recut_list",
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
		open_request(this);
  if( type === 'delete')
		cancel_request(this);
});


function open_request(ele)
{
    window.open(BASE_URL+'index.php/production/recut/view_request/'+$(ele).attr('data-id'));
}


function cancel_request(ele){
  var request_id = $(ele).attr('data-id');
  appAlertConfirm('Do you want to cancel selected request?' , function(){
    appAjaxRequest({
      url : BASE_URL + 'index.php/production/recut/destroy',
      type: 'post',
      dataType : 'json',
      data : {
        'request_id' : request_id
      },
      async : false,
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
