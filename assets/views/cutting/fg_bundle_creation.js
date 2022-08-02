(function () {

    var LAYSHEET_NO = 0;

    var LAYSHEET = null;

    var CUT_PLAN = null;

    $(document).ready(function () {

        $('#btn_laysheet_search').click(function () {

            var ls_no = $('#laysheet_no').val();

            if (ls_no != '') {

                LAYSHEET = null;

                CUT_PLAN = null;

                reload_summery_table(ls_no);

                load_bundle_chart(ls_no);

            }

        });


        $('#btn_create_bundles').click(function () {
            var ord_id = $('#laysheet_no').val();
            var colorId = $('#color_id').val();

            var i = 0;
            var arr = [];
            $('#summery_table tbody tr').each(function () {
                var ord_id = $('#laysheet_no').val();
                var item = $(this).find("td").eq(0).attr('id');
                var color = $(this).find("td").eq(1).attr('id');
                var size = $(this).find("td").eq(2).attr('id');
                var qty = $('#d' + i).val();
                //alert(customerId2)
                if (parseInt(qty) > 0) {
                    var data = {
                        "order_id": ord_id,
                        "item_id": item,
                        //"color": color,
                        "color" : colorId,
                        "size_id": size,
                        "qty": qty
                    }
                    arr.push(data);

                }

                i++;
            });
            // console.log(arr)

            appAjaxRequest({

                url: BASE_URL + 'index.php/cutting/bundle/save_fg_bundle',

                type: 'post',

                dataType: 'json',

                data: {

                    'ord_id': ord_id,

                    'items': arr
                },

                success: function (res) {

                    if (res != null && res != '') {
                        appAlertSuccess('Bundles generated successfully');

                        var bundle_chart = res.bundle_chart;
                        console.log(bundle_chart)
                        var str = '';

                        for (var x = 0; x < bundle_chart.length; x++) {

                            str += '<tr>';

                            str += '<td>' + bundle_chart[x]['id'] + '</td>';

                            str += '<td>' + bundle_chart[x]['ord_id'] + '</td>';

                            str += '<td>' + bundle_chart[x]['first_name'] + '</td>';

                            str += '<td>' + bundle_chart[x]['created_date'] + '</td>';
                            str += '<td><input type="number" id="m' + bundle_chart[x]['id'] + '"></td>';
                            str += '<td><button class="btn btn-danger btn-xs" data-bundle-no="' + bundle_chart[x]['id'] + '">print</button></td>';

                            str += '</tr>';

                        }
                        console.log(str)
                        $('#bundle_chart_table tbody').html(str);

                        reload_summery_table(ord_id);

                        //console.log(res);
                    }

                },

                error: function (err) {

                    appAlertError('Bundles Already generated');

                }

            });
            return false;

            appAlertConfirm('Do you want to create the bundle chart for this laysheet?', function () {

                appAjaxRequest({

                    url: BASE_URL + 'index.php/cutting/bundle/save',

                    type: 'post',

                    dataType: 'json',

                    data: {

                        'laysheet_no': LAYSHEET_NO,

                        'plies': plies
                    },
                    success: function (res) {

                        if (res != null && res != '') {

                            appAlertSuccess('Bundles generated successfully');

                            var $ctn_data = res.$ctn_data;

                            var str = '';

                            for (var x = 0; x < $ctn_data.length; x++) {

                                str += '<tr>';

                                str += '<td>' + $ctn_data[x]['id'] + '</td>';

                                str += '<td>' + $ctn_data[x]['ord_id'] + '</td>';

                                str += '<td>' + $ctn_data[x]['first_name'] + '</td>';

                                str += '<td>' + $ctn_data[x]['created_date'] + '</td>';

                                str += '<td><button class="btn btn-danger btn-xs" data-bundle-no="' + $ctn_data[x]['id'] + '">Delete</button></td>';

                                str += '</tr>';

                            }

                            $('#bundle_chart_table tbody').html(str);

                            reload_summery_table(LAYSHEET_NO);

                            console.log(res);

                        }

                    },

                    error: function (err) {

                        appAlertError('Bundles Already generated');

                    }

                });

            });

        });





//        $('#bundle_chart_table tbody').on('click', 'button', function () {
//
//            var ele = $(this);
//
//            var bundle_no = ele.attr('data-bundle-no');
//
//            appAlertConfirm('Do you want to delete selected bundle?', function () {
//
//                appAjaxRequest({
//
//                    url: BASE_URL + 'index.php/cutting/bundle/destroy/' + LAYSHEET_NO + '/' + bundle_no,
//
//                    type: 'post',
//
//                    dataType: 'json',
//
//                    success: function (res) {
//
//                        if (res.status == 'success') {
//
//                            ele.parent().parent().remove();
//
//                            appAlertSuccess(res.message);
//
//                            reload_summery_table(LAYSHEET_NO);
//
//                        }
//
//                    },
//
//                    error: function (err) {
//
//                        alert(err);
//
//                    }
//
//                });
//
//            });
//
//        });

        $('#bundle_chart_table tbody').on('click', 'button', function () {

            var ele = $(this);

            var bundle_no = ele.attr('data-bundle-no');
            var qty = $('#m' + bundle_no).val();

            appAlertConfirm('Do you want to print selected ?', function () {

                appAjaxRequest({

                    url: BASE_URL + 'index.php/cutting/bundle/print_data/' + bundle_no + '/' + qty,

                    type: 'post',

                    dataType: 'json',

                    success: function (res) {

                        if (res.status == 'success') {

                            window.open(BASE_URL + 'index.php/cutting/bundle/print_fg_barcode/' + bundle_no + '/' + res.start);
//                            ele.parent().parent().remove();
//
//                            appAlertSuccess(res.message);
//
//                            reload_summery_table(LAYSHEET_NO);

                        }

                    },

                    error: function (err) {

                        alert(err);

                    }

                });

            });

        });




        $('#btn_delete_all').click(function () {

            appAlertConfirm('Do you want to delete all bundles?', function () {

                appAjaxRequest({

                    url: BASE_URL + 'index.php/cutting/bundle/destroy_all/' + LAYSHEET_NO,

                    type: 'post',

                    dataType: 'json',

                    success: function (res) {

                        if (res.status == 'success') {

                            $('#bundle_chart_table tbody').html('');

                            appAlertSuccess(res.message);

                            reload_summery_table(LAYSHEET_NO);

                        }

                    },

                    error: function (err) {

                        alert(err);

                    }

                });

            });

        });





        $('#btn_print').click(function () {

            if (LAYSHEET != null) {

                window.open(BASE_URL + 'index.php/cutting/bundle/print_bundlechart/' + LAYSHEET.laysheet_no);

            }

        });





        $('#btn_print_barcode').click(function () {

            if (LAYSHEET != null) {

                window.open(BASE_URL + 'index.php/cutting/bundle/print_barcode/' + LAYSHEET.laysheet_no);

            }

        });





    });





    function    reload_summery_table(laysheet_no) {

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
                        color: laysheet.color_name,
                        pcd_date: laysheet.pcd_date,
                        customer: laysheet.cus_name,
                        color_id : laysheet.color
//


                    });



                    var str = '';

                    for (var x = 0; x < cut_dtails.length; x++) {

                        str += '<tr>';

                        str += '<td id="' + cut_dtails[x]['item'] + '">' + cut_dtails[x]['item_code'] + '</td>';

                        str += '<td id="' + cut_dtails[x]['item_color'] + '">' + cut_dtails[x]['color_code'] + '</td>';

                        str += '<td id="' + cut_dtails[x]['size'] + '">' + cut_dtails[x]['size_code'] + '</td>';

                        str += '<td><input type="number" id="d' + x + '"></td>';

//                        str += '<td>0</td>';
//
//                        str += '<td><input type="text"></td>';

                        str += '</tr>';

                    }

                    $('#summery_table tbody').html(str);



                    // console.log(res);

                }

            },

            error: function (err) {

                alert(err);

            }

        });

    }





    function load_bundle_chart(laysheet) {
        // alert(laysheet)
        appAjaxRequest({

            url: BASE_URL + 'index.php/cutting/bundle/get_saved_details/' + laysheet,

            type: 'get',

            dataType: 'json',

            success: function (res) {

                if (res != null && res != '') {

                    var bundle_chart = res.bundle_chart;

                    var str = '';
                    var str = '';

                    for (var x = 0; x < bundle_chart.length; x++) {

                        str += '<tr>';

                        str += '<td>' + bundle_chart[x]['id'] + '</td>';

                        str += '<td>' + bundle_chart[x]['ord_id'] + '</td>';

                        str += '<td>' + bundle_chart[x]['first_name'] + '</td>';

                        str += '<td>' + bundle_chart[x]['created_date'] + '</td>';

                        str += '<td><input type="number" id="m' + bundle_chart[x]['id'] + '"></td>';
                        str += '<td><button class="btn btn-danger btn-xs" data-bundle-no="' + bundle_chart[x]['id'] + '">Print</button></td>';

                        str += '</tr>';

                    }

                    $('#bundle_chart_table tbody').html(str);

                }

            },

            error: function (err) {

                alert(err);

            }

        });

    }





})()
