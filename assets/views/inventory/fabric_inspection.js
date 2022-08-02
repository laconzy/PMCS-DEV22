(function(){

  $(document).ready(function(){

		$('.date').datepicker({
				format: "yyyy-mm-dd",
				viewMode: "days",
				minViewMode: "days"
		});

		$('#btn_search').click(function(){
			let fabric_code = $('#fabric_code').val().trim();
			let color = $('#color_id').val().trim();
			let date_from = $('#date_from').val().trim();
			let date_to = $('#date_to').val().trim();
			let received_date_from = $('#received_date_from').val().trim();
			let received_date_to = $('#received_date_to').val().trim();
			let main_store = $('#main_store').val().trim();
			let invoice = $('#invoice').val().trim();
			let pi_no = $('#pi_no').val().trim();
			let status = $('#status').val().trim();
      let role_no = $('#role_no').val().trim();

			if(invoice == '' && pi_no == ''){
				appAlertError('Must enter invoice no or dyelot no');
				return;
			}

			$('body').loadingModal({
				position: 'auto',
				text: '',
				color: '#fff',
				opacity: '0.5',
				backgroundColor: 'rgb(0,0,0)',
				animation: 'cubeGrid'
			});

			setTimeout(function(){
				appAjaxRequest({
					url: BASE_URL + 'index.php/inventory/inventory/get_fabric_allocation_data',
					type: 'get',
					dataType: 'json',
					data : {
						'fabric_code' : fabric_code,
						'color' : color,
						'date_from' : date_from,
						'date_to' : date_to,
						'received_date_from' : received_date_from,
						'received_date_to' : received_date_to,
						'main_store' : main_store,
						'invoice' : invoice,
						'pi_no' : pi_no,
						'status' : status,
            'role_no' : role_no
					},
					async : false,
					success: function (res) {
						if(res.data != undefined){
							let data = res.data;
              load_table(data);
						}
						$('body').loadingModal('destroy');
					},
					error: function (err) {
						$('body').loadingModal('destroy');
						appAlertError(err);
						console.log(err);
					}
				});
			}, 200);

		});


		$('#btn_export').click(function(){
			ExportToExcel('xlsx');
		});


    $('#btn_status').click(function () {
        var data = [];
        let status = $('#ins_status').val().trim();

        if(status == ''){
          appAlertError('Status cannot be empty');
          return;
        }

        $('#data_table tbody input:checkbox').each(function () {
            if (this.checked == true) {
                data.push($(this).attr('data-barcode'));
            }
        });

        if(data.length <= 0){
          	appAlertError('Roles not selected for the status change');
        }
        else {
          change_inspection_status(status, data);
        }
    });


    $('#btn_width').click(function () {
        var data = [];
        let width = $('#width').val().trim();

        if(width == ''){
          appAlertError('Width cannot be empty');
          return;
        }

        $('#data_table tbody input:checkbox').each(function () {
            if (this.checked == true) {
                data.push($(this).attr('data-barcode'));
            }
        });

        if(data.length <= 0){
          	appAlertError('Roles not selected for the width change');
        }
        else {
          change_width(width, data);
        }
    });


    $('#btn_shade').click(function () {
        var data = [];
        let shade = $('#shade').val().trim();

        if(shade == ''){
          appAlertError('Shade cannot be empty');
          return;
        }

        $('#data_table tbody input:checkbox').each(function () {
            if (this.checked == true) {
                data.push($(this).attr('data-barcode'));
            }
        });

        if(data.length <= 0){
          	appAlertError('Roles not selected for the shade change');
        }
        else {
          change_shade(shade, data);
        }
    });

    $('#select_all').change(function () {
        $('#data_table tbody input:checkbox').prop('checked', this.checked);
    });


	});


  function load_table(data){
    let str = '';
    for(let x = 0 ; x < data.length ; x++){
      let style_str = '';
      if(data[x]['ins_status'] == 'Pass'){
        style_str = 'style="background-color:#d6f5d6"';
      }
      str += `<tr id="tr_${data[x]['item_code']}" ${style_str}>
      <td>${data[x]['id']}</td>
      <td>${data[x]['invoice']}</td>
      <td>${data[x]['po_no']}</td>
      <td>${data[x]['part_no']}</td>
      <td style="white-space:nowrap;width:100px">${data[x]['description']}</td>
      <td>${data[x]['date']}</td>
      <td>${data[x]['fab_composion']}</td>
      <td>${data[x]['color']}</td>
      <td>${data[x]['pi_no']}</td>
      <td>${data[x]['batch_no']}</td>
      <td>${data[x]['role_no']}</td>
      <td>${data[x]['recieved']}</td>
      <td>${data[x]['item_code']}</td>
      <td>${data[x]['customer_po']}</td>
      <td>${format_data(data[x]['allocated_qty'])}</td>
      <td>${data[x]['bin']}</td>
      <td id="width_${data[x]['item_code']}">${data[x]['width']}</td>
      <td id="shade_${data[x]['item_code']}">${data[x]['shade']}</td>
      <td id="status_${data[x]['item_code']}">${data[x]['ins_status']}</td>
      <td><input type="checkbox" data-barcode="${data[x]['item_code']}" id="chk_${data[x]['item_code']}"></td>
      <td>${data[x]['comment']}</td>
      <td>${data[x]['ins_pass_by']}</td>
      <td>${data[x]['fng_no']}</td>
      </tr>`;

      /*<td>${data[x]['factory_name']}</td>
      <td>${data[x]['line_no']}</td>
      <td>${data[x]['release_no']}</td>
      <td>${data[x]['style']}</td>
      <td>${format_data(data[x]['actual_received_date'])}</td>
      <td>${data[x]['main_stores']}</td>
      <td>${data[x]['sub_stores']}</td>
      <td>${data[x]['bin_location']}</td>
      <td>${data[x]['bin_code']}</td>
      <td>${data[x]['uom']}</td>
      <td>${data[x]['status']}</td>
      <td>${data[x]['actchchual']}</td>
      <td>${data[x]['item_code']}</td>
      <td>${data[x]['inspection_date']}</td>*/
    }
    $('#data_table tbody').html(str);
  }


  function change_inspection_status(status, data){
    $('body').loadingModal({
      position: 'auto',
      text: '',
      color: '#fff',
      opacity: '0.5',
      backgroundColor: 'rgb(0,0,0)',
      animation: 'cubeGrid'
    });

    setTimeout(function(){
      appAjaxRequest({
        url: BASE_URL + 'index.php/inventory/inventory/change_inspection_status',
        type: 'post',
        dataType: 'json',
        data : {
          'status' : status,
          'barcode_list' : data
        },
        async : false,
        success: function (res) {
          if(res.status == 'success'){
            for(let x = 0 ; x < data.length ; x++){
              $('#status_' + data[x]).html(status);
              $('#chk_' + data[x]).prop('checked', false);

              if(status == 'Pass'){
                $("#tr_" + data[x]).css("background-color", "#d6f5d6");
              }
              else {
                $("#tr_" + data[x]).removeAttr("style");
              }
            }
            appAlertSuccess(res.message);
          }
          else {
            appAlertError(res.message);
          }
          $('body').loadingModal('destroy');
        },
        error : function(err) {
          console.log(err);
          $('body').loadingModal('destroy');
          appAlertError(err);
        }
      });
    }, 200);
  }


  function change_width(width, data){
    $('body').loadingModal({
      position: 'auto',
      text: '',
      color: '#fff',
      opacity: '0.5',
      backgroundColor: 'rgb(0,0,0)',
      animation: 'cubeGrid'
    });

    setTimeout(function(){
      appAjaxRequest({
        url: BASE_URL + 'index.php/inventory/inventory/change_width',
        type: 'post',
        dataType: 'json',
        data : {
          'width' : width,
          'barcode_list' : data
        },
        async : false,
        success: function (res) {
          if(res.status == 'success'){
            for(let x = 0 ; x < data.length ; x++){
              $('#width_' + data[x]).html(width);
              $('#chk_' + data[x]).prop('checked', false);
            }
            appAlertSuccess(res.message);
          }
          else {
            appAlertError(res.message);
          }
          $('body').loadingModal('destroy');
        },
        error : function(err) {
          console.log(err);
          $('body').loadingModal('destroy');
          appAlertError(err);
        }
      });
    }, 200);
  }


  function change_shade(shade, data){
    $('body').loadingModal({
      position: 'auto',
      text: '',
      color: '#fff',
      opacity: '0.5',
      backgroundColor: 'rgb(0,0,0)',
      animation: 'cubeGrid'
    });

    setTimeout(function(){
      appAjaxRequest({
        url: BASE_URL + 'index.php/inventory/inventory/change_shade',
        type: 'post',
        dataType: 'json',
        data : {
          'shade' : shade,
          'barcode_list' : data
        },
        async : false,
        success: function (res) {
          if(res.status == 'success'){
            for(let x = 0 ; x < data.length ; x++){
              $('#shade_' + data[x]).html(shade);
              $('#chk_' + data[x]).prop('checked', false);
            }
            appAlertSuccess(res.message);
          }
          else {
            appAlertError(res.message);
          }
          $('body').loadingModal('destroy');
        },
        error : function(err) {
          console.log(err);
          $('body').loadingModal('destroy');
          appAlertError(err);
        }
      });
    }, 200);
  }


	function ExportToExcel(type, fn, dl) {
		var elt = document.getElementById('data_table');
		var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
		return dl ?
				XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
				XLSX.writeFile(wb, fn || ('report.' + (type || 'xlsx')));
	}


	function format_data(_val){
		if(_val == null){
			return '';
		}
		else {
			return _val;
		}
	}

})();
