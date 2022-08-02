(function() {

  var BASE_URL = null;
  var GROUP_ID = 0;

$(document).ready(function(){

    BASE_URL = $('#base_url').val();
    GROUP_ID = $('#group_id').val();

    $('#data-form').form_validator({
			events : ['blur'],
			fields : {
				'group_id' : {
					key : 'group_id',
					required : true
				},
				'group_name' : {
					required : true,
					remote : {
						url : BASE_URL + 'index.php/permission_group/is_group_exists',
						data : {'group_id' : GROUP_ID}
					}
				}
			}
		});

    if(GROUP_ID == 0)
    {
       /* make_ajax_request({
            url : PAGE.getBaseUrl()+'index.php/permission_group/get_menu_list',
            success : function(response){
                try{
                    var obj = JSON.parse(response);
                    load_permissions(obj);
                }
                catch (e){

                }
            }
        });       */
    }
    else
    {
      get_permissions();
    }

});


function get_permissions()
{
    appAjaxRequest({
        url : BASE_URL + 'index.php/permission_group/get_permissions/' + GROUP_ID,
        dataType : 'JSON',
        success : function(response){
            load_permissions(response.data);
        }
    });
}


function load_permissions(per_arr)
{
    if(per_arr != null || per_arr != undefined)
    {
        var ele = $('#pg-permission-list tbody');
        ele.empty();
        var str = '';
        for(var x = 0 ; x < per_arr.length ; x++)
        {
            var permission = per_arr[x];
            str += '<tr>';
            if(permission['menu_id'] != undefined && permission['menu_id'] != null)
            {
                if(permission['permission_status'] == undefined || permission['permission_status'] == '0')
                    str += '<td><input data-permission-id="'+permission['menu_id']+'" type="checkbox"></td><td>'+permission['menu_text']+'</td>';
                else if(permission['permission_status'] == '1')
                    str += '<td><input data-permission-id="'+permission['menu_id']+'" type="checkbox" checked></td><td>'+permission['menu_text']+'</td>';
            }
        }
        ele.html(str);
    }
}


function get_permissions()
{
    var chk_boxes = $('#pg-permission-list tbody input[type = checkbox]');
    var arr = [];
    chk_boxes.each(function(){
        var ele = $(this);
        arr.push({
            menu_id : ele.attr('data-permission-id'),
            permission_status : ele.prop('checked') == true ? 1 : 0
        });
    });
    return arr;
}


$('#pg-btn-save').click(function(){

    var obj = $('#data-form').form_validator('validate');
    if(obj != false)
    {
        appAjaxRequest({
            url : BASE_URL + 'index.php/permission_group/save_permission_group',
            data : { 'data' : obj },
            type : 'POST',
            async : false,
            success : function(response){
                try{
                    var res = JSON.parse(response);
                    if(res['status'] == 'success')
                    {
                      appAlertSuccess(res['message'],function(){
                          window.open(BASE_URL + 'index.php/permission_group/open_permission_group/' + res['group_id'] , '_self');
                      });
                    }
                    else{
                          appAlertError('Process Error');
                    }
                }
                catch(e){alert(e);}
            }
        });
    }
});

$('#permission-div input').on('change', function(event){
    var status = 'REMOVE';
    if($(this).is(':checked')){
        status = 'ADD';
    }
    var permission_code = $(this).attr('data-permission-code');
    change_permission(permission_code,status);
});


$('#line-permission-div input').on('change', function(event){
    var status = 'REMOVE';
    if($(this).is(':checked')){
        status = 'ADD';
    }
    var line_id = $(this).attr('data-line-id');
    change_line_permission(line_id,status);
});


function change_permission(permission_code,status){
    appAjaxRequest({
        url : BASE_URL + 'index.php/permission_group/modify_permissions',
        data : {
            'permission_code' : permission_code,
            'group_id' : GROUP_ID,
            'status' : status
        },
        type : 'GET',
        async : true,
        success : function(response){
            var obj = JSON.parse(response);
            if(obj['status'] === 'success'){
                $('#'+permission_code).addClass('fa fa-check').css('color', 'green');
                setTimeout(function(){
                        $('#'+permission_code).removeClass('fa fa-check').css('color', '');
                }, 3000);
            }
            else{
                $('#'+permission_code).addClass('fa fa-close').css('color', 'red');
            }
        }
    });
}



function change_line_permission(line_id,status){
    appAjaxRequest({
        url : BASE_URL + 'index.php/permission_group/modify_line_permissions',
        data : {
            'line_id' : line_id,
            'group_id' : GROUP_ID,
            'status' : status
        },
        type : 'GET',
        async : true,
        success : function(response){
            var obj = JSON.parse(response);
            if(obj['status'] === 'success'){
                $('#'+line_id).addClass('fa fa-check').css('color', 'green');
                setTimeout(function(){
                        $('#'+line_id).removeClass('fa fa-check').css('color', '');
                }, 3000);
            }
            else{
                $('#'+line_id).addClass('fa fa-close').css('color', 'red');
            }
        }
    });
}

})();
