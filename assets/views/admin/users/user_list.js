var TABLE = null;
var MSG = null;
var USER_VIEW = 0;
var USER_DEL = 0;

$(document).ready(function() {

    USER_VIEW = $('#user-view').val();
    USER_DEL = $('#user-del').val();

    var columns = [
            { "data": "id" },
            { "data": "first_name" },
            { "data": "last_name" },
            { "data": "email" },
            { "data": "contact_no" },
            { "data": "dep_name" },
            { "data": "designation" },
            { "data": "group_name" },
            {
              "data": "active",
              render : function(data){
                if(data == 'Y')
                  return '<span class="text-success">Active</span>';
                else
                  return '<span class="text-danger">Deactive</span>';
              }
            }
        ];

    if(USER_VIEW == 1){
        columns.push({
            "orderable": false,
            'data' : function(_data,a){
                return '<button class="btn btn-success btn-flat btn-sm" data-btn="view" data-id="'+_data['id']+'">Edit</button>';
            }
        });
    }
    if(USER_DEL == 1){
        columns.push({
            "orderable": false,
            data : function(_data){
                return '<button class="btn btn-danger btn-flat btn-sm" data-btn="delete" data-id="'+_data['id']+'">Delete</button>';
            }
        });
    }

    TABLE = $('#users-table').DataTable( {
        "scrollY": "500px",
        "scrollCollapse": true,
       // responsive: true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": BASE_URL+"index.php/user/get_users"
            //"type": "POST"
        },
        "columns": columns
    } );
} );


$('#users-table').on('click','button',function(){
	var ele = $(this);
	var type = ele.attr('data-btn');
	if( type === 'view')
		open_user(this);
	else if(type === 'delete' )
		delete_user(this);
});


function open_user(ele)
{
    //alert($(ele).attr('data-id'));
    window.open(BASE_URL+'index.php/user/show_user/'+$(ele).attr('data-id'));
}


function delete_user(ele)
{
  var user_id = $(ele).attr('data-id');
  appAlertConfirm('Do you want to deactivate selected user?' , function(){
    appAjaxRequest({
      url : BASE_URL + 'index.php/user/destroy/'+user_id,
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
