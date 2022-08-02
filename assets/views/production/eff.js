(function () {

    var LAYSHEET_NO = 0;
    var LAYSHEET = null;

    $(document).ready(function () {

        $('.date').datepicker({
            format: "yyyy-mm-dd",
            viewMode: "days",
            minViewMode: "days"
        });

        $('#site').change(function(){
          let site = $(this).val();
          if(site != ''){
            appAjaxRequest({
                url: BASE_URL + 'index.php/production/commitments/get_lines_from_site/' + site,
                type: 'post',
                dataType: 'json',
                async : false,
                success: function (res) {
                  let str = '<option value="0">...Select Line...</option>';
                  let lines = res.data;
                  if(lines != null && lines.length > 0){
                    for(let x = 0 ; x < lines.length ; x++){
                      str += `<option value="${lines[x]['line_id']}">${lines[x]['line_code']}</option>`;
                    }
                  }
                  $('#line_no').html(str);
                },
                error : function(err){
                    $('#line_no').html('<option value="0">...Select Line...</option>');
                    alert(err);
                }
              });
          }
          else {
            $('#line_no').html('<option value="0">...Select Line...</option>');
          }
        });

        $('#line_no').change(function () {
           var date = $('#scan_date').val();
           var shift = $('#shift').val();
           var line_no = $('#line_no').val();

           if(shift == ''){
            appAlertError('Please Select The Shift');
            return;
           }

          if(date == ''){
              appAlertError('Please Select The date');
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

        appAjaxRequest({
            url: BASE_URL + 'index.php/production/commitments/get_line_data',
            type: 'post',
            dataType: 'json',
            data: {
                'shift': shift,
                'date': date,
                'line_no': line_no
            },
            success: function (res) {
                if (res != null && res != '') {
                        //appAlertSuccess('Bundles generated successfully');
                        var lines = res.lines;
                        var style_categories = res.style_categories;
                        var str = '';
                        if (lines != null) {

                          for(let x = 0 ; x < lines.length ; x++){
                            str += '<tr>';
                            str += `<td>${lines[x]['line_code']}</td>`;
                            str += `<td><input type="hidden" id="style_id${x}" value="${lines[x]['style']}">${lines[x]['style_code']}</td>`;

                            if(lines[x]['style_category'] == null){
                              let str2 = `<select id="style_category_id${x}"> <option value="">...Select One...</option>`;
                              for(let y = 0 ; y < style_categories.length ; y++){
                                str2 += `<option value="${style_categories[y]['id']}">${style_categories[y]['category']}</option>`;
                              }
                              str += `</select>`;
                              str += `<td>${str2}</td>`;
                            }
                            else {
                              str += `<td><input type="hidden" id="style_category_id${x}" value="${lines[x]['style_category']}">${lines[x]['category']}</td>`;
                            }

                            str += `<td><input type="number" style="max-width:60px;text-align:right"  id="direct${x}" value="${lines[x]['direct']}" disabled></td>`;
                            str += `<td><input type="number"  style="max-width:60px" id="indirect${x}" value="${lines[x]['indirect']}" disabled></td>`;
                            str += `<td><input type="text" style="max-width:60px;text-align:right"  id="work_mins${x}" value="${lines[x]['minutes']}"></td>`;
                            str += `<td><input type="number"  style="max-width:60px;text-align:right" id="ot${x}" value="${lines[x]['ot']}"></td>`;
                            str += `<td><input type="number"  style="max-width:60px;text-align:right" id="prod_qty${x}" value="${lines[x]['ttl_qty']}"></td>`;
                            str += `<td><input type="number"  style="max-width:60px;text-align:right" id="smv${x}" value="${lines[x]['smv']}"></td>`;
                            str += `<td><input type="number" style="max-width:60px;text-align:right"  id="produce_mins${x}" value="${lines[x]['ttl_qty'] * lines[x]['smv']}"></td>`;
                            str += `<td><input type="text" style="max-width:200px;text-align:right"  id="comments${x}" value=""></td>`;
                            str += `</tr>`;
                          }
                      }
                       $('#summery_table tbody').html(str);
                   }
                   $('body').loadingModal('destroy');
               },
               error: function (err) {
                  $('body').loadingModal('destroy');
                  appAlertError(err);
                }
            });
    });



    $('#btn_save').click(function () {

      var table_length = $("#summery_table tbody tr").length;
      var date = $("#scan_date").val();
      var shift = $("#shift").val();
      var line = $("#line_no").val();
      var data_arr = [];
      let has_error = false;

      if(table_length <= 0){
       appAlertError('No data to save');
       return;
      }

      for(let x = 0 ; x < table_length ; x++){
        var direct = $('#direct' + x).val();
        var indirect = $('#indirect' + x).val();
        var smv = $('#smv' + x).val();
        let style_category = $('#style_category_id' + x).val();

        if(direct == '' || direct == 0 || indirect == '' || indirect == 0){
           appAlertError("Please enter the direct and indirect cardre in row " + (x + 1))
           has_error = true;
           break;
        }

         if(smv == '' || smv == 0){
           appAlertError("Please enter the SMV in row " + (x + 1))
           has_error = true;
           break;
        }

        if(style_category == null || style_category == ''){
          appAlertError("Please select style category in row " + (x + 1))
          has_error = true;
          break;
        }

        var obj_data = {
           'date': date,
           'line_id': line,
           'direct': direct,
           'indirect': indirect,
           'work_mins': $('#work_mins' + x).val(),
           'ot': $('#ot' + x).val(),
           'out_qty': $('#prod_qty' + x).val(),
           'smv': $('#smv' + x).val(),
           'minutes': $('#produce_mins' + x).val(),
           'shift': shift,
           'style_id': $('#style_id' + x).val(),
           'comments': $('#comments' + x).val(),
           'style_category' : style_category
       }
       data_arr.push(obj_data);

      }

      if(has_error == false){
        appAjaxRequest({
            url: BASE_URL + 'index.php/production/commitments/save_eff',
            type: 'post',
            async : false,
            'data': {
                'data': data_arr,
                'date':date,
                'shift':shift,
                'line':line
            },
            dataType: 'json',
            success: function (res) {
               if (res.status == 'success') {
                 appAlertSuccess(res.message);
               }
               else {
                 appAlertError(res.message);
               }
            },
            error: function (err) {
                alert(err);
            }
        });
      }      
});





  /*$('#btn_print').click(function () {
      if (LAYSHEET != null) {
          window.open(BASE_URL + 'index.php/cutting/bundle/print_bundlechart/' + LAYSHEET.laysheet_no);
      }
  });*/

  /*$('#btn_print_barcode').click(function () {
      if (LAYSHEET != null) {
          window.open(BASE_URL + 'index.php/cutting/bundle/print_barcode/' + LAYSHEET.laysheet_no);
      }
  });*/

});





/*function  reload_summery_table(laysheet_no) {
    appAjaxRequest({
        url: BASE_URL + 'index.php/cutting/bundle/get_order_details/' + laysheet_no,
        type: 'get',
        dataType: 'json',
        success: function (res) {
            if (res != null && res != '') {
                var laysheet = res.laysheet;
                var cut_dtails = res.cut_details;
                LAYSHEET = laysheet;
                LAYSHEET_NO = laysheet.laysheet_no;
                CUT_PLAN = res.cut_plan;
                    // alert(laysheet.style_code)
                    appFillFormData({
                        style: laysheet.style_code,
                        customer_po: laysheet.customer_po,
                        customer_po: laysheet.color_name,
                        pcd_date: laysheet.pcd_date,
                        customer: laysheet.cus_name,
                    });

                    var str = '';
                    for (var x = 0; x < cut_dtails.length; x++) {
                        str += '<tr>';
                        str += '<td id="' + cut_dtails[x]['item'] + '">' + cut_dtails[x]['item_code'] + '</td>';
                        str += '<td id="' + cut_dtails[x]['item_color'] + '">' + cut_dtails[x]['color_code'] + '</td>';
                        str += '<td id="' + cut_dtails[x]['size'] + '">' + cut_dtails[x]['size_code'] + '</td>';
                        str += '<td><input type="number" id="d' + x + '">'+cut_dtails[x]['comments']+'</td>';
                        str += '</tr>';
                    }
                    $('#summery_table tbody').html(str);
                }
            },
            error: function (err) {
                alert(err);
            }
        });
}*/


})()
