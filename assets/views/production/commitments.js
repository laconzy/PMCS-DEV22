(function () {

    var LAYSHEET_NO = 0;
    var LAYSHEET = null;
    var CUT_PLAN = null;

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
                  let str = '<option value="">...Select Line...</option>';
                  let lines = res.data;
                  if(lines != null && lines.length > 0){
                    for(let x = 0 ; x < lines.length ; x++){
                      str += `<option value="${lines[x]['line_id']}">${lines[x]['line_code']}</option>`;
                    }
                  }
                  $('#line_no').html(str);
                },
                error : function(err){
                    $('#line_no').html('<option value="">...Select Line...</option>');
                    alert(err);
                }
              });
          }
          else {
            $('#line_no').html('<option value="">...Select Line...</option>');
          }
        });

        $('#line_no').change(function (ev) {
         var date = $('#scan_date').val();
         var shift = $('#shift').val();
         var line_no = $(this).val();

         if(shift == ''){
            appAlertError('Please Select The Shift');
            return;
        }
        if(date == ''){
           appAlertError('Please Select The Date');
           return;
        }
        if(line_no == ''){
            appAlertError('Please Select The Line No');
            return;
        }

        appAjaxRequest({
            url: BASE_URL + 'index.php/production/commitments/get_line',
            type: 'post',
            dataType: 'json',
            async : false,
            data: {
                'shift': shift,
                'date': date,
                'line_no' : line_no
            },
            success: function (res) {
                if (res != null && res != '') {
                  var line = res.line;
                  var commited_by = line['commited_by'];
                  if(commited_by == null || commited_by == "") {
                      commited_by="";
                  }

                  var str = `<tr>
                    <td>${date}</td>
                    <td>${line['line_code']}</td>
                    <td><input type="number" style="max-width:60px;text-align:right" id="plan_qty" value="${line['plan_qty']}"></td>
                    <td><input type="number" style="max-width:60px;text-align:right" id="plan_sah" value="${line['plan_sah']}"></td>
                    <td><input type="number" style="max-width:60px;text-align:right" id="commited_qty" value="${line['commited']}"></td>
                    <td>
                      <input type="number" style="max-width:60px;text-align:right" id="pcs_per_hour" value="${(line['hrs'] == undefined) ? 10 : line['hrs']}">
                      <input type="hidden" id="c" value="${line['line_id']}">
                    </td>
                    <td><input type="number"  style="max-width:60px" id="commited_by" value="${commited_by}"></td>
                    <td><input type="text" style="max-width:60px;text-align:right"  id="work_mins" value="${(line['minutes'] == undefined) ? 570 : line['minutes']}"></td>
                    <td><input type="number"  style="max-width:60px;text-align:right" id="ot" value="${(line['ot'] == undefined) ? 0 : line['ot']}"></td>
                    <td><input type="number"  style="max-width:60px;text-align:right" id="direct" value="${line['direct']}"></td>
                    <td><input type="number"  style="max-width:60px;text-align:right" id="indirect" value="${line['indirect']}"></td>
                    <td><input type="number" style="max-width:60px;text-align:right"  id="opt_avl" value="${(line['av_operator'] == undefined) ? 0 : line['av_operator']}"></td>
                  </tr>`;
                 $('#summery_table tbody').html(str);
             }
          },
          error: function (err) {
              appAlertError(err);
          }
        });
    });



    $('#btn_save').click(function () {

        var date = $('#scan_date').val();
        var shift = $('#shift').val();
        var line = $('#line_no').val();

        if(shift == ''){
           appAlertError('Please Select The Shift');
           return;
       }
       if(date == ''){
          appAlertError('Please Select The Date');
          return;
       }
       if(line_no == ''){
           appAlertError('Please Select The Line No');
           return;
       }
       if($('#direct').val() == ''){
         appAlertError('Please Enter Direct Value');
         return;
       }
       if($('#indirect').val() == ''){
         appAlertError('Please Enter Indirect Value');
         return;
       }

       var obj_data = {
         'date': date,
         'line': line,
         'shift': shift,
         'plan_qty':$("#plan_qty").val(),
         'commited': $("#commited_qty").val(),
         'commited_by': $('#commited_by').val(),
         'hrs': $('#pcs_per_hour').val(),
         'minutes': $('#work_mins').val(),
         'ot': $('#ot').val(),
         //'operator': operator,
         'av_operator': $('#opt_avl').val(),
         'indirect': $('#indirect').val(),
         'direct' : $('#direct').val(),
         'plan_sah': $('#plan_sah').val()
       }

       appAjaxRequest({
           url: BASE_URL + 'index.php/production/commitments/save_all',
           type: 'post',
           'data': {
               'data': obj_data
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

    // $('#btn_print').click(function () {
    //     if (LAYSHEET != null) {
    //         window.open(BASE_URL + 'index.php/cutting/bundle/print_bundlechart/' + LAYSHEET.laysheet_no);
    //     }
    // });

    // $('#btn_print_barcode').click(function () {
    //     if (LAYSHEET != null) {
    //         window.open(BASE_URL + 'index.php/cutting/bundle/print_barcode/' + LAYSHEET.laysheet_no);
    //     }
    // });

    });


});


/*function reload_summery_table(laysheet_no) {
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
                        str += '<td><input type="number" id="d' + x + '"></td>';
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
