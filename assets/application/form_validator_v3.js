/**
 * Author - chamila priyadarshana
 * version - 3.0
 */
 (function($){

	var defaults = {
		events : [],
		fields : {}
	};

	var fv_objs_configs = {};
	var style_err = { 'border-color' : 'red' ,'border-width' : '1px'};
	var style_success = { 'border-color' : '' ,'border-width' : '1px'};

	function _createForm(ele,options)
	{
		var events = options['events'];
		var fields = options['fields'];

		for(var key in fields)
		{
			var field = fields[key];
			var input = $('#' + key);
			var inputSpan = $('<span></span>');
			inputSpan.attr({
				id : key+'-err'
			});
			inputSpan.css({
				'color' : 'red',
				'font-size' : '11px'
			});
			//inputSpan.html('');
			$(input.parent()).append(inputSpan);

			if(field['events'] !== undefined && (field['events'] instanceof Array))//use field events
			{
				for(var eve in field['events']) {
			    	input.on(events[eve] , function(e){
						var ele = $(this);
			    		_validate_field(ele,fields[ele.attr('id')]);
					});
				}
			}
			else{
				for(var eve in events) {
			    	input.on(events[eve], function(e){
						var ele = $(this);
			    		_validate_field(ele,fields[ele.attr('id')]);
					});
				}
			}
		}
	}

	function _validate_field(_ele,_field)
	{
		var status = true;
		try
		{
			if(_field['notRequired'] === true && _ele.val() === ''){
				return _ele.val();
			}

			//********************************************************************

			if(status == true && _field['required'] !== undefined) // required
			{
				status = _required(_ele.val());
				var _disErrMsg = (_field['required'] === true) ? 'This field is required.' : _field['required']['errorMessage'];
				_display(status , _ele , _disErrMsg);
			}

			if(status == true && _field['min'] !== undefined) // min
			{
				var _disErrMsg = '';
				var _minValue = null;
				if(typeof _field['min'] === 'number'){
					_minValue = _field['min'];
					_disErrMsg = 'Minimum allowed value = ' + _minValue;
				}
				else{
					_minValue = _field['min']['minValue'];
					_disErrMsg = _field['min']['errorMessage'];
				}
				status = _min(_ele.val(),_minValue);
				_display(status , _ele , _disErrMsg);
			}

			if(status == true && _field['max'] !== undefined) // max
			{
				var _disErrMsg = '';
				var _maxValue = null;
				if(typeof _field['max'] === 'number'){
					_maxValue = _field['max'];
					_disErrMsg = 'Maximum allowed value = ' + _maxValue;
				}
				else{
					_minValue = _field['max']['maxValue'];
					_disErrMsg = _field['max']['errorMessage'];
				}
				status = _min(_ele.val(),_maxValue);
				_display(status , _ele , _disErrMsg);
			}

			if(status == true && _field['equal'] !== undefined) // equal
			{
				var _disErrMsg = '';
				var _equalValue = null;
				if(typeof _field['equal'] !== 'object'){
					_equalValue = _field['equal'];
					_disErrMsg = 'Value must be equal to ' + _equalValue;
				}
				else{
					_equalValue = _field['equal']['equalValue'];
					_disErrMsg = _field['equal']['errorMessage'];
				}
				status = _min(_ele.val(),_equalValue);
				_display(status , _ele, _disErrMsg);
			}

			if(status == true && _field['rangeLength'] !== undefined && (typeof _field['rangeLength'] == 'object')) // equal
			{
				status = _min(_ele.val(),_field['rangeLength']['minValue'],_field['rangeLength']['maxValue']);
				var _disErrMsg = (_field['rangeLength']['errorMessage'] === undefined) ? 'Value range ' + _field['rangeLength']['minValue'] + '-' + _field['rangeLength']['maxValue'] :
					_field['rangeLength']['errorMessage'];
				_display(status , _ele , _disErrMsg);
			}

			if(status == true && _field['dataType'] !== undefined) // regular Expression
			{
				var _disErrMsg = '';
				var _dataType = null;
				if(typeof _field['dataType'] === 'string'){
					_dataType = _field['dataType'];
					_disErrMsg = 'Please enter a valid ' + _dataType;
				}
				else{
					_dataType = _field['dataType']['type'];
					_disErrMsg = _field['dataType']['errorMessage'];
				}
				status = _dataTypeValidation(_ele.val(),_dataType);
				_display(status , _ele , _disErrMsg);
			}

			if(status == true && _field['regExp'] !== undefined) // regular Expression
			{
				var _disErrMsg = '';
				var _rExp = null;
				if(typeof _field['regExp'] === 'string'){
					_rExp = _field['regExp'];
					_disErrMsg = 'Incorrect value';
				}
				else{
					_rExp = _field['regExp']['expression'];
					_disErrMsg = _field['regExp']['errorMessage'];
				}
				status = _regExp(_ele.val(),_rExp);
				_display(status , _ele , _disErrMsg);
			}

			if(status == true && _field['remote'] !== undefined && (typeof _field['remote'] == 'object')) // regular Expression
			{
				var obj = _remote(_ele.val(),_field['remote']);
				status = obj['status'] == 'error' ? false : true;
				_display(status , _ele , obj['message']);
			}

			if(status == true && _field['custom'] !== undefined && (typeof _field['custom'] == 'object')) // custom function
			{
				status = _field['custom']['functionToExecute'](ele);
				_display(status , _ele , _field['custom']['errorMessage']);
			}

			if(status === true && _field['checkbox'] === undefined){
				return _ele.val();
			}
			else if(status === true && _field['checkbox'] !== undefined){
				var _returnValue = _ele.is(':checked') === true ? _field['checkbox']['checkValue'] : _field['checkbox']['uncheckValue'];
				return _returnValue;
			}
			else
				return false;

		}
		catch(_validationError){
			alert('validation plugin error');
			return false;
		}
	}


	function _required(_value){
		if(_value == undefined || _value == null || _value == '')
			return false;
		else
			return true;
	}

	function _remote(_value,_options)
	{
		var resObj = false;
		var defaults = {
			type: "POST",
			async:false,
			url: '',
			data: {'data_value' : _value},
			dataType : "json",
			success: function(_response){
				resObj = _response;//JSON.parse(_response);
			},
			error: function(e){
				alert('Error: ' + e);
			}
		};
		var settings = $.extend(true, {} , defaults , _options);
		$.ajax(settings);
		return resObj;
	}

	function _min(_value,_min_value)
	{
		if(_value > _min_value)
			return true;
		else
			return false;
	}

	function _max(_value,_max_value)
	{
		if(_value > _max_value)
			return false;
		else
			return true;
	}

	function _regExp(_value,_reg_exp)
	{
		if(_reg_exp.test(_value)) {
			return true;
		}
		else {
			return false;
		}
	}

	function _dataTypeValidation(_value,_type)
	{
		var _regExp = '';
		switch(_type)
		{
			case 'email' :
				_regExp = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				break;
			case 'number' :
				_regExp = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/;
				break;
			case 'integer' :
				_regExp = /^[\d.]+$/;
				break;
			case 'decimal' :
				_regExp = /^\d+(\.\d{1,2})?$/;
				break;
			case 'currency' :
				_regExp = /(?=.)^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?(\.[0-9]{1,6})?$/;//decimal place is optional
				break;
			case 'phone' :
				_regExp = /^\d{10}$/;
				break;
			case 'url' :
				_regExp = /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/;
				break;
		}
		return _regExp.test(_value);
	}

    function _equal(_value,_value_to_check)
    {
        if(_value == _value_to_check) {
            return true;
        }
        else {
            return false;
        }
    }

    function _rangeLength(_value,_min,_max)
    {
        if((_min <_value) && (_value <_max)) {
            return true;
        }
        else {
            return false;
        }
    }

    function _display(_status,_input,_message){
		if(_status == false)	{
			_input.css(style_err);
			$('#'+_input.attr('id')+'-err').html(_message);
		}
		else {
			_input.css(style_success);
			$('#'+_input.attr('id')+'-err').html('');
		}
    }

	function _checkbox(_){
	}


	$.fn.form_validator = function(options){

		if(typeof options === 'object')	{
			var config = $.extend(true , {} , defaults , options);
            fv_objs_configs[this.attr('id')] = config;
                        //['config'] = config;
			_createForm(this,config);
			return this;
		}
		else if(typeof options === "string" && options === 'validate') {
			var errCount = 0;
			var data = {};
			var config = fv_objs_configs[this.attr('id')];
			var fields = config['fields'];

			for(var key in fields)	{
				var _field = fields[key];
				var _input = $('#'+key);

				var validateResponse = _validate_field(_input,_field);
				if(validateResponse === false){
					errCount++;
				}
            	else{
					if(_field['key'] === undefined){
						var _newKey = key.replace(/-/g, '_');
						data[_newKey] = validateResponse;
					}
					else{
						data[_field['key']] = validateResponse;
					}
            	}
			}

			if(errCount > 0)
				return false;
			else
				return data;
		}
	}

 })(jQuery);
