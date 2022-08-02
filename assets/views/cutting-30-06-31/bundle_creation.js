(function(){

  var LAYSHEET_NO = 0;
  var LAYSHEET = null;
  var CUT_PLAN = null;

  $(document).ready(function(){


    $('#btn_laysheet_search').click(function(){
      var ls_no = $('#laysheet_no').val();
      if(ls_no != ''){
        LAYSHEET = null;
        CUT_PLAN = null;
        reload_summery_table(ls_no);
        load_bundle_chart(ls_no);
      }
    });


    $('#btn_create_bundles').click(function(){

      if(LAYSHEET_NO == 0 || LAYSHEET_NO == ''){
        appAlertError('You must load a laysheet no to continue.');
        return;
      }

      var plies = $('#no_of_plies').val();
      if(plies == '' || plies <= 0) {
        appAlertError('Enter valid plies count');
        return;
      }

      appAlertConfirm('Do you want to create the bundle chart for this laysheet?' , function(){
        appAjaxRequest({
          url : BASE_URL + 'index.php/cutting/bundle/save',
          type: 'post',
          dataType : 'json',
          data : {
            'laysheet_no' : LAYSHEET_NO,
            'plies' : plies
          },
          success : function(res){
            if(res != null && res != ''){
              appAlertSuccess('Bundles generated successfully');
              var bundle_chart = res.bundle_chart;
              var str = '';
              for(var x = 0 ; x < bundle_chart.length ; x++){
                str += '<tr>';
                str += '<td>' + bundle_chart[x]['bundle_no'] + '</td>';
                str += '<td>' + bundle_chart[x]['barcode'] + '</td>';
                str += '<td>' + bundle_chart[x]['size_code'] + '</td>';
                str += '<td>' + bundle_chart[x]['qty'] + '</td>';
                str += '<td><button class="btn btn-danger btn-xs" data-bundle-no="'+bundle_chart[x]['bundle_no']+'">Delete</button></td>';
                str += '</tr>';
              }
              $('#bundle_chart_table tbody').html(str);
              reload_summery_table(LAYSHEET_NO);
              console.log(res);
            }
          },
          error : function(err){
            appAlertError('Bundles Already generated');
          }
        });
      });

    });


    $('#bundle_chart_table tbody').on('click','button',function(){
        var ele = $(this);
        var bundle_no = ele.attr('data-bundle-no');
        appAlertConfirm('Do you want to delete selected bundle?' , function(){
          appAjaxRequest({
            url : BASE_URL + 'index.php/cutting/bundle/destroy/'+LAYSHEET_NO+'/'+bundle_no,
            type: 'post',
            dataType : 'json',
            success : function(res){
              if(res.status == 'success'){
                ele.parent().parent().remove();
                appAlertSuccess(res.message);
                reload_summery_table(LAYSHEET_NO);
              }
            },
            error : function(err){
              alert(err);
            }
          });
        });
    });


    $('#btn_delete_all').click(function(){
      appAlertConfirm('Do you want to delete all bundles?' , function(){
        appAjaxRequest({
          url : BASE_URL + 'index.php/cutting/bundle/destroy_all/'+LAYSHEET_NO,
          type: 'post',
          dataType : 'json',
          success : function(res){
            if(res.status == 'success'){
              $('#bundle_chart_table tbody').html('');
              appAlertSuccess(res.message);
              reload_summery_table(LAYSHEET_NO);
            }
          },
          error : function(err){
            alert(err);
          }
        });
      });
    });


    $('#btn_print').click(function(){
      if(LAYSHEET != null){
        window.open(BASE_URL + 'index.php/cutting/bundle/print_bundlechart/' + LAYSHEET.laysheet_no);
      }
    });


    $('#btn_print_barcode').click(function(){
      if(LAYSHEET != null){
        window.open(BASE_URL + 'index.php/cutting/bundle/print_barcode/' + LAYSHEET.laysheet_no);
      }
    });


  });


  function reload_summery_table(laysheet_no){
    appAjaxRequest({
      url : BASE_URL + 'index.php/cutting/bundle/get_laysheet_details/' + laysheet_no,
      type: 'get',
      dataType : 'json',
      success : function(res){
        if(res != null && res != ''){
          var laysheet = res.laysheet;
          var cut_dtails = res.cut_details;

          LAYSHEET = laysheet;
          LAYSHEET_NO = laysheet.laysheet_no;
          CUT_PLAN = res.cut_plan;

          appFillFormData({
            cut_no : laysheet.cut_no,
            cut_plan_id : laysheet.cut_plan_id,
            lay_qty : laysheet.lay_qty,
            /*site : CUT_PLAN.site_name,*/
            color : CUT_PLAN.color_code,
            item : CUT_PLAN.item_name
          });

          var str = '';
          for(var x = 0 ; x < cut_dtails.length ; x++){
            str += '<tr>';
            str += '<td>' + cut_dtails[x]['size_code'] + '</td>';
            str += '<td>' + cut_dtails[x]['ratio'] + '</td>';
            str += '<td>' + cut_dtails[x]['planned_qty'] + '</td>';
            str += '<td>' + cut_dtails[x]['qty'] + '</td>';
            str += '<td>' + cut_dtails[x]['bundle_qty'] + '</td>';
            str += '<td>' + cut_dtails[x]['remaning_qty'] + '</td>';
            str += '</tr>';
          }
          $('#summery_table tbody').html(str);

          console.log(res);
        }
      },
      error : function(err){
        alert(err);
      }
    });
  }


  function load_bundle_chart(laysheet){
    appAjaxRequest({
      url : BASE_URL + 'index.php/cutting/bundle/get_bundle_chart/'+laysheet,
      type: 'get',
      dataType : 'json',
      success : function(res){
        if(res != null && res != ''){
            var bundle_chart = res.bundle_chart;
            var str = '';
            for(var x = 0 ; x < bundle_chart.length ; x++){
              str += '<tr>';
              str += '<td>' + bundle_chart[x]['bundle_no'] + '</td>';
              str += '<td>' + bundle_chart[x]['barcode'] + '</td>';
              str += '<td>' + bundle_chart[x]['size_code'] + '</td>';
              str += '<td>' + bundle_chart[x]['qty'] + '</td>';
              str += '<td><button class="btn btn-danger btn-xs" data-bundle-no="'+bundle_chart[x]['bundle_no']+'">Delete</button></td>';
              str += '</tr>';
            }
            $('#bundle_chart_table tbody').html(str);
        }
      },
      error : function(err){
        alert(err);
      }
    });
  }


})()
