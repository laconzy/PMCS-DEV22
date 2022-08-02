var PERM_GRP_VIEW = '';
var PERM_GRP_DEL = '';
var BASE_URL = null;
var TABLE = null;

$(document).ready(function() {

    PERM_GRP_VIEW = $('#perm-grp-view').val();
    PERM_GRP_DEL = $('#perm-grp-del').val();
    BASE_URL = $('#base_url').val();

   var columns = [
       { "data": "group_id" , width : '10%' },
       { "data": "group_name" },
       {
         "data": "active",
         render : function(data){
           if(data == 'Y')
             return '<span class="text-success">Active</span>';
           else
             return '<span class="text-danger">Deactive</span>';
         }
       },
   ];

   if(PERM_GRP_VIEW == 1){
        columns.push({
            "orderable": false,
            width : '10%',
            'data' : function(_data,a){
                return '<button class="btn btn-success btn-flat btn-sm" data-btn="view" data-id="'+_data['group_id']+'">Edit</button>';
            }
        });
   }
   if(PERM_GRP_DEL == 1){
        columns.push({
            "orderable": false,
            width : '10%',
            data : function(_data){
                return '<button class="btn btn-danger btn-flat btn-sm" data-btn="delete" data-id="'+_data['group_id']+'">Delete</button>';
            }
        });
   }

    TABLE = $('#pg-groups-table').DataTable( {
        "scrollY": "500px",
        "scrollCollapse": true,
        responsive: true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": PAGE.getBaseUrl()+"index.php/permission_group/get_permissions_groups"
            //"type": "POST"
        },
        "columns": columns
    } );
    PAGE.setTable(tbl);
} );


$('#pg-groups-table').on('click','button',function(){
	var ele = $(this);
	var type = ele.attr('data-btn');
	if( type === 'view')
		open_group(this);
	else if(type === 'delete' )
		delete_group(this);
});


function open_group(ele)
{
    //alert($(ele).attr('data-id'));
    window.open(PAGE.getBaseUrl()+'index.php/permission_group/open_permission_group/'+$(ele).attr('data-id'));
}


function delete_group(ele)
{
  var group_id = $(ele).attr('data-id');
  appAlertConfirm('Do you want to deactivate selected group?' , function(){
    appAjaxRequest({
      url : BASE_URL + 'index.php/permission_group/destroy/'+group_id,
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
