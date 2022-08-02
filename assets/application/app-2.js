/*
 * param 
 * ...............
 * options - type = object , details which should pass to the ajax function
 * 
 * return 
 * ..........
 * type = object
 * data which came from server
 */
function appAjaxRequest(options)
{
    var response = null;
    var defaults = {
         type : 'post',
         url : '',
         async : true,
         data : {},
         success : function(_response){
             response = JSON.parse(_response);
         },
         error : function(xhr,status,err) {
             console.log(xhr.responseText);
         }
    };    
    var obj = $.extend({} , defaults , options);    
    $.ajax(obj);
    return response;    
}


/*
* pass set of data to html inputs
* [
* {id : 'input_id' , type :'text,select,checkbox,radio' , value : 'for input type text and select' , 
*     status : 'for check box and radio - true or false'}
* ]
*/
function appSetFormData(arr)
{
    try
    {
        if(arr !== undefined && arr !== null)
        {
            for(var x = 0 , arrLength = arr.length; x < arrLength ; x++)
            {
                var obj = arr[x];
				var _ele = $('#'+obj['id']);			
                if(obj['type'] === undefined || obj['type'] === 'text' || obj['type'] == 'select')
                {
                    _ele.val(obj['value']);
                }
                else if(obj['type'] === 'checkbox' || obj['type'] === 'radio')
                {
					_ele.prop('checked', obj['status']); // Check = true or uncheck = true
                }
            }
        }
        return true;
    }
    catch(_exception)  {
        console.log(_exception);
        return false;
    }
}

/*
* get a data of a form or passed input elements
* _inputs = string or array
* string - id of a form or a div
* array - array of inputs ids
*/
function appGetFormData(_inputs)
{
    try
    {
		var returnObj = {};
		
        if(arr !== undefined && arr !== null)
        {
			if(_inputs.constructor === Array)
			{
				for(var x = 0 ; x < _inputs.length ; x++)
				{
					returnObj[_inputs[x]['key']] = document.getElementById(_inputs[x]['id']).value;
				}
			}
			else if(typeof _inputs === 'string'){
				$('#' + _inputs + ' :input').each(function(){
					returnObj[this.id] = this.value;
				});
			}            
        }
        return returnObj;
    }
    catch(_exception)  {
        console.log(_exception);
        return {};
    }
}

function setTableData(tblData,table){
  $('#'+table+' tbody').html(tblData);
}
