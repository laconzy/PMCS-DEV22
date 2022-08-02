/**
 * 
 */
 (function($){
	 
	var defaults = {
		events : [],
		fields : {}		
	}; 
	
	var config = {};
 
	function _createForm(ele,options)
	{
		var events = options['events'];
		for(var ee = 0 ; ee < events.length ; ee++)
		{		
			for(var key in options['fields'])
			{
				//var field = options['fields'][key];
			
				var input = $('#'+key);
				var inputSpan = $('<span></span>');
				inputSpan.attr({
					id : key+'-err'
				});
				inputSpan.css({
					'color' : 'red',
					'font-size' : '11px'
				});
				inputSpan.html('');
				$(input.parent()).append(inputSpan);

				input.on(events[ee] , function(e){
					var eventType = e.type;
					var ele = $(this);
					var field = options['fields'][ele.attr('id')];
					var status = true;
					
					if(field['notRequired'] !== undefined && field['notRequired'] === true)
					{
						if(!(field['notRequired']['removeEvents'] !== undefined && field['notRequired']['removeEvents'].indexOf(eventType) > -1))
						{
							if(ele.val() === undefined || ele.val()  === '' || ele.val() === null)
							{
								ele.css({ 'border-color' : 'orange' ,'border-width' : '2px'});								
							}		
							else	
							{
								ele.css({ 'border-color' : 'green' ,'border-width' : '2px'});
							}
						}							
					}
					
					if(field['notEmpty'] !== undefined)
					{
						if(!(field['notEmpty']['removeEvents'] !== undefined && field['notEmpty']['removeEvents'].indexOf(eventType) > -1))
							_empty(ele,field['notEmpty']) === true ? status = false : status = true;									
					}
					
					if(field['stringLength'] !== undefined && status === true )
					{
						if(!(field['stringLength']['removeEvents'] !== undefined && field['stringLength']['removeEvents'].indexOf(eventType) > -1))
						{
							var min = field['stringLength']['min'];
							var max = field['stringLength']['max'];
											
							if(min !== undefined)
							{
								_min(ele,field['stringLength']) === true ? status = false : status = true;
							}
							if(max !== undefined)
							{
								_max(ele,field['stringLength'] ) === true ? status = false : status = true;
							}
						}						
					}
					
					if(field['type'] !== undefined && status === true)
					{
						if(!(field['type']['removeEvents'] !== undefined && field['type']['removeEvents'].indexOf(eventType) > -1))
							_dataType(ele,field['type']) === true ? status = true : status = false;
					}
					
					if(field['regExp'] !== undefined && status === true)
					{
						if(!(field['regExp']['removeEvents'] !== undefined && field['regExp']['removeEvents'].indexOf(eventType) > -1))
							_regExp(ele,field['regExp']) === true ? status = true : status = false;
					}	

					if(field['remote'] !== undefined && status === true)
					{	
						if(!(field['remote']['removeEvents'] !== undefined && field['remote']['removeEvents'].indexOf(eventType) > -1))
							_remote(ele,field['remote']) === true ? status = true : status = false;
					}
                                        
                                        if(field['valueCheck'] !== undefined && status === true)
                                        {
                                            _valueCheck(ele,field['valueCheck'])=== true ? status = true : status = false;
                                        }
					
				});		

			/*input.on('focus',function(){
				inputSpan.html('');
				input.css({
					'border-color' : 'blu'
				});
			});*/
			
			}				
		}
	}
	
	function _remote(input,options)
	{
		var response = null;
		var status = false;
		var span = $('#'+input.attr('id')+'-err');
		
		var defaults = {
			type: "POST",
			async:false,
			url: '',
			data: {value : input.val()},//JSON.stringify(row_data),
			dataType : "json",
			success: function(_data){
				if(_data['status'] == true)
				{
					_styleSuccess(input,span);
				}
				else if(_data['status'] == false)
				{
					_styleError(input,span,_data['message']);
				}
				response = _data;
			},
			error: function(e){
				alert('Error: ' + e);
			}
		};
		var settings = $.extend({} , defaults , options);
		$.ajax(settings);
		return response;
	}
	
	
	function _min(input,options)
	{
		var status = false;
		var span = $('#'+input.attr('id')+'-err');
		
		if(input.val().length < options['min'])
		{
			_styleError(input , span , options['message']);
			status = true;
		}
		else 
		{
			_styleSuccess(input , span);
			status = false;
		}
		return status;
	}

	function _max(input,options)
	{
		var status = false;
		var span = $('#'+input.attr('id')+'-err');
		
		if(input.val().length > options['max'])
		{
			_styleError(input , span , options['message']);
			status = true;
		}
		else 
		{
			_styleSuccess(input , span);
			status = false;
		}
		return status;
	}
	
	function _empty(input,options)
	{
		var status = false;
		var val = input.val();
		var span = $('#'+input.attr('id')+'-err');
		if(val === undefined || val === null || val === '')
		{
			_styleError(input , span , options['message']);
			status = true;
		}
		else 
		{
			_styleSuccess(input , span);
			status = false;
		}
		return status;
	}
	
	function _regExp(input,options)
	{
		var status = false;
		var span = $('#'+input.attr('id')+'-err');
		
		if(options['regExp'].test(input.val()))
		{
			_styleSuccess(input , span);
			status = true;
		}
		else
		{
			_styleError(input , span , options['message']);
			status = false;
		}
	}
	
        
	function _dataType(input,options)
	{
		var regExp = '';
		var status = false;
		var span = $('#'+input.attr('id')+'-err');
		
		switch(options['type'])
		{
			case 'email' :
				regExp = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				break;
			case 'number' : 
				regExp = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/;
				break;
			case 'integer' :
				regExp = /^[\d.]+$/;
				break;
			case 'decimal' :
				regExp = /^\d+(\.\d{1,2})?$/;
				break;
			case 'currency' :
				regExp = /(?=.)^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?(\.[0-9]{1,6})?$/;//decimal place is optional
				break;
			case 'phone' :
				regExp = /^\d{10}$/;
				break;
			case 'url' :
				regExp = /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/;
				break;
		}
		status = regExp.test(input.val());
		if(status === false)
		{
			_styleError(input , span , options['message']);
			status = false;
		}
		else 
		{
			_styleSuccess(input , span);
			status = true;
		}
		return status;
	}
        
        
        function _valueCheck(input,options)
        {
            var check_ele_id = options['ele_to_check'];
            if(check_ele_id != undefined)
            {
                var v1 = input.val();
                var v2 = $('#'+check_ele_id).val();
                if(v1 != v2)
                {
                    _styleError(input , $('#'+input.attr('id')+'-err') , options['message']);
                    return false;
                }
                else 
                {
                    _styleSuccess(input , $('#'+input.attr('id')+'-err'));        
                    return true;
                }
            }
        }
        
	
	function _styleError(input,span,message)
	{
		span.html(message);
		input.css({	'border-color' : 'red','border-width' : 'px' });
	}
	
	function _styleSuccess(input,span)
	{
		span.html('');
		input.css({'border-color' : 'green' , 'border-width' : '1px'});
	}
	
	
 
	$.fn.form_validator = function(options){		
		
		if(typeof options === 'object')
		{
			config = $.extend(true , {} , defaults , options);
			_createForm(this,config);
			return this;
		}
		else if(typeof options === "string" && options === 'validate')
		{
			var errCount = 0;
			var data = {};
			
			for(var key in config['fields'])
			{
				var field = config['fields'][key];
				var input = $('#'+key);		
				var _errCount = 0;
				
				if(field['notRequired'] !== undefined && field['notRequired'] === true)
				{
					if(!(field['notRequired']['removeEvents'] !== undefined && field['notRequired']['removeEvents'].indexOf(eventType) > -1))
					{
						if(input.val() === undefined || input.val()  === '' || input.val() === null)
						{
							input.css({ 'border-color' : 'orange' ,'border-width' : '2px'});						
						}	
						else
						{	
							input.css({ 'border-color' : 'green' ,'border-width' : '2px'});
						}					
					}					
				}	
				
				if(field['notEmpty'] !== undefined)
				{
					if(_empty(input,field['notEmpty']))
						_errCount++;					
				}				
				if(field['stringLength'] !== undefined && _errCount == 0)
				{
					if(field['stringLength']['min'] !== undefined)
					{
						if(_min(input,field['stringLength']))
							_errCount++;						
					}
					if(field['stringLength']['max'] !== undefined)
					{
						if(_max(input,field['stringLength']))
							_errCount++;						
					}
				}
				if(field['type'] !== undefined && _errCount == 0)
				{
					if(!_dataType(input,field['type']))
						_errCount++;
				}
				else if(field['regExp'] !== undefined && _errCount == 0)
				{
					if(!_regExp(input,field['regExp']))
						_errCount++;
				}
				if(field['remote'] !== undefined && _errCount == 0)
				{
					field['remote']['async'] = false;
					var res = _remote(input,field['remote']);
					if(res == null)
						_errCount++;
					else if(res['status'] == null || res['status'] == undefined || res['status'] == false)
						_errCount++;
				}
                                
                                if(field['valueCheck'] !== undefined && _errCount == 0)
				{
					if(!_valueCheck(input,field['valueCheck']))
						_errCount++;
				}
				
				if(_errCount > 0)
					errCount++;
				else
				{
					if(field['key'] !== undefined)
					{
						var arr = field['key'].split('.');
						if(arr.length == 2)
						{
							if(data[arr[0]] == undefined)
								data[arr[0]] = {};
							data[arr[0]][arr[1]] = input.val();
						}
						else if(arr.length == 1)
						{
							data[arr[0]] = input.val();
						}
					}
					else
						data[key] = input.val();
				}
					
			}
			
			if(errCount > 0)
				return false;
			else
				return data;
		}		
	}
 
 })(jQuery);