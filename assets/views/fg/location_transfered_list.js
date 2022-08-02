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
      { "data": "full_name" },
      { "data": "from_line_code" },
      { "data": "to_line_code" },
      { "data": "transfered_date" },
      {
				"data": "transfer_sub_type",
				"orderable": false,
				'width':'5%',
				render : function(data, type, full, meta ){
          let str = '';
          if(data == 'FG_TO_FG'){
            return '<span>FG TO FG</span>';
          }
          else if(data == 'FG_TO_LEFT_OVER'){
            return '<span>FG TO LEFT OVER</span>';
          }
          else if(data == 'LEFT_OVER_TO_FG'){
            return '<span>LEFT OVER TO FG</span>';
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
        //  str += '<button class="btn btn-danger btn-xs" data-btn="delete" data-id="'+data+'"><i class="fa fa-remove"></i></button>';
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
            "url": BASE_URL+"index.php/fg/location_transfer/get_transfer_list",
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
		open_transfer(this);
});

function open_transfer(ele)
{
    window.open(BASE_URL+'index.php/fg/location_transfer/view_transfer/'+$(ele).attr('data-id'));
}
