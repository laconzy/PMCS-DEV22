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


		$('#btn_print').click(function(){
			var data = [];
      $('#data_table tbody input:checkbox').each(function () {
          if (this.checked == true) {
              data.push($(this).attr('data-barcode'));
          }
      });

      if(data.length <= 0){
          appAlertError('Roles not selected for print');
      }
      else {
        var data_str = JSON.stringify(data);
        localStorage.setItem('pmcs_inv_data', data_str);
        window.open(BASE_URL + 'index.php/inventory/inventory/print_labels_view', '_blank');
      }
		});


    $('#btn_print2').click(function(){
			var data = [];
      $('#data_table tbody input:checkbox').each(function () {
          if (this.checked == true) {
              data.push($(this).attr('data-barcode'));
          }
      });

      if(data.length <= 0){
          appAlertError('Roles not selected for print');
      }
      else {
        var data_str = JSON.stringify(data);
        localStorage.setItem('pmcs_inv_data2', data_str);
        window.open(BASE_URL + 'index.php/inventory/inventory/print_labels_view2', '_blank');
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
      <td><input type="checkbox" data-barcode="${data[x]['item_code']}" id="chk_${data[x]['item_code']}"></td>
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
      <td>${data[x]['comment']}</td>
      <td>${data[x]['ins_pass_by']}</td>
      <td>${data[x]['fng_no']}</td>
      </tr>`;

    }
    $('#data_table tbody').html(str);
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
