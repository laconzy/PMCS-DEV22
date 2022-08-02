var TABLE = null;
var MSG = null;
var SITE_VIEW = null;
var SITE_DEL = null;
var SEARCH_TEXT = '';

$(document).ready(function() {

    //USER_VIEW = $('#user-view').val();
    //USER_DEL = $('#user-del').val();

    var columns = [
      { "data": "task_id"},
      { "data": "proc_inst_id" },
      { "data": "proc_name" },
      { "data": "level" },
      { "data": "object_id" },
      { "data": "started_date" },
      { "data": "started_user_name" },
      {
        "data": "status",
        render : function(data){
          if(data == 'PENDING')
            return '<span class="text-success">PENDING</span>';
          else
            return '<span class="text-danger">COMPLETE</span>';
        }
      },
			{
				"data": "task_id",
				"orderable": false,
				'width':'5%',
				render : function(data, type, full, meta ){
					str = '<a class="btn btn-primary btn-xs" href="'+BASE_URL+ full['view_open_path'] + full['object_id'] +'" target="_blank">View</a> ';
          str += '<button class="btn btn-success btn-xs" data-btn="resend" data-task-id="'+data+'" data-proc-inst-id="'+full['proc_inst_id']+'">Resend</button> ';
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
            "url": BASE_URL+"index.php/approval_proc/get_sending_fail_emails",
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
	resend_email(this);
});



function resend_email(ele)
{
  var task_id = $(ele).attr('data-task-id');
  var proc_inst_id = $(ele).attr('data-proc-inst-id');

  appAlertConfirm('Do you want to resend this email?' , function(){
    appAjaxRequest({
      url : BASE_URL + 'index.php/approval_proc/resend_email',
      type: 'post',
      dataType : 'json',
      data : {
        'task_id' : task_id,
        'proc_inst_id' : proc_inst_id
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
        console.error(err);
        alert('Email sending process error');
      }
    });
  });
}
