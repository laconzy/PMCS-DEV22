function print_laysheet(cut_plan,cut_no,item_id,ord_id,plies){
   // alert(cut_plan+' '+cut_plan)
    appAjaxRequest({
            url: BASE_URL + 'index.php/cut_plan/print_lay_sheet',
            data: {cut_plan: cut_plan, cut_no: cut_no,item_id:item_id,ord_id:ord_id,plies:plies},
            success: function (response) {
                try {
                    var obj = JSON.parse(response);
                    lay_sheet=obj.lay_sheet;
                    //alert(lay_sheet)
                    //window.location.href = BASE_URL + 'index.php/cut_plan/print_laysheet/'+lay_sheet;
                    window.open(
   BASE_URL + 'index.php/cut_plan/print_laysheet/'+lay_sheet,
  '_blank' // <- This is what makes it open in a new window.
);

//window.location.open(BASE_URL + 'index.php/cut_plan/lay_sheet_print');
                } catch (e)
                {
                    console.log(e);
                }
            }
        });
}


(function () {

    function initialize_form_validator() {

        var form = {
            events: ['blur'],
            fields: {

                'mdl-style': {
                    'key': 'style',
                    'required': {
                        'errorMessage': 'Style cannot be empty'
                    }
                },
                'mdl-color': {
                    'key': 'color',
                    'required': {
                        'errorMessage': 'Style cannot be empty'
                    }
                },
                'mdl-cut-plan-id': {
                    'key': 'cut_plan_id',

                },
                'mdl-order-id': {
                    'key': 'prod_ord_detail_id',
                    'required': {
                        'errorMessage': 'Style cannot be empty'
                    }
                }, 'mdl-lyers': {
                    'key': 'plies',
                    'required': {
                        'errorMessage': 'layers cannot be empty'
                    }
                }

            }
        }
        $('#myModal5').form_validator(form);
    }



    $(document).ready(function () {
        initialize_form_validator();
        $('#cutplan-id').keypress(function (e) {
            if (e.which == 13) {//Enter key pressed
                load_data();//Trigger search button click event
            }
        });

        $('#05-btn-save').click(function () {
            load_data()
        });
        $('#myModal5').on('show.bs.modal', function (e) {
            button = $(e.relatedTarget);
            setTableData('', 'mdl-tbl-ratio');
            get_model_data(button);
        });




    })
    function get_model_data(button) {

        //clear rows in modele
        setTableData('', 'size-table');
        $("#mdl-order-id").val(button.data('gruopid'));
        var cut_plan_id = $('#mdl-cut-plan-id').val();
        appAjaxRequest({
            url: BASE_URL + 'index.php/cut_plan/prod_ord_details',
            'data': {'prod_ord_detail_id': button.data('gruopid'), 'cut_plan_id': cut_plan_id},
            success: function (response) {
                try {

                    var obj = JSON.parse(response);
                    if (obj != undefined && obj != null)
                        data = obj['data']['detail'][0];
                    size_data = obj['data']['size_data'];

                    appSetFormData(
                            [
                                {id: 'mdl-style', value: data['style_code']},
                                {id: 'mdl-color', value: data['color_code']},
                                {id: 'mdl-cpo', value: data['customer_po']}
                            ]
                            );

// load data gird
                    for (var i = 0; i < size_data.length; i++) {
                        $('#size-table').append(
                                '<tr>' +
                                '<td>' + size_data[i]['prod_ord_size'] + '</td>' +
                                '<td class="col-md-2" ><div><input type="text"   class="form-control input-sm" placeholder="" id="' + size_data[i]['prod_ord_size'] + '" ></div></td>' +
                                '<td></td>' +
                                '<td>' + size_data[i]['prod_ord_plan_qty'] + '</td>' +
                                '<td id="mdl-' + size_data[i]['prod_ord_size'] + '">' + size_data[i]['cut_plan_qty'] + '</td>' +
                                '<td id="mdl-qty-' + size_data[i]['prod_ord_size'] + '" >0</td>' +
                                '</td></tr>');
                    }

                } catch (e) {
                    console.log(e);
                }
            }
        });

    }
    function loadModel(modelName, data) {

        return ActionButton = '<div class="btn-group">' +
                '<button data-toggle="dropdown" class="btn btn-default btn-sm dropdown-toggle" >Action <span class="caret"></span></button>' +
                '<ul class="dropdown-menu">' +
                '<li ><a data-toggle="modal" href="'+ BASE_URL + 'index.php/cut_plan/lay_sheet_print'+'"  data-gruopid="' + data['cut_plan_detail_id'] + '">Print lays sheet</a></li>' +
                '<li><a href="#">Print</a></li>' +
//                '<li><a href="#">copy cut plan</a></li>' +
//                '<li class="divider"></li>' +
//                '<li><a href="#">Separated link</a></li>' +
                '</ul>' +
                '</div>';

    }



    function load_data() {
        var ord_id = $('#cutplan-id').val();
        appAjaxRequest({
            url: BASE_URL + 'index.php/cut_plan/load_cut_plan',
            data: {id: "user_id", ord_id: ord_id},
            success: function (response) {
                try {
                    var obj = JSON.parse(response);

                    if (obj != undefined && obj != null)
                        data = obj['data']['detail'];
                    var detail = obj['data']['size_data'];
                    console.log(detail)
                    appSetFormData(
                            [
                                {id: 'cutplan-id', value: data['cut_plan_id']},
                                {id: 'color', value: data['prod_ord_detail_id']},
                                {id: 'order-code', value: data['item_code']},
                                {id: 'cpo', value: data['color_code']},
                                {id: 'style', value: data['com_code']},
                                {id: 'style-desc', value: data['com_description']},
                                {id: 'site', value: data['style_code']},
                                {id: 'sales-qty', value: data['ord_qty']},
                                {id: 'season', value: data['plan_qty']},
                                {id: 'oreder-qty', value: data['date']},
                                {id: 'style_code2', value: data['style_code']},
                            ]
                            );
$("#component tbody tr").remove();
                    for (var i = 0; i < detail.length; i++) {
                        $('#component tbody').append(
                                '<tr>' +
                                '<td>' + data['item_code'] + '</td>' +
                                '<td>' + detail[i]['line_no'] + '</td>' +
                                '<td>' + detail[i]['plies'] + '</td>' +
                                '<td>' + detail[i]['width'] + '</td>' +
                                '<td>' + detail[i]['marker_ref'] + '</td>' +
                                '<td>' + '<button class="btn  btn-success btn-flat btn-sm" data-id="' + detail[i]['line_no'] + '" onclick="print_laysheet('+ord_id+','+ detail[i]['line_no'] +','+detail[i]['item_id'] +','+detail[i]['ord_id'] +','+detail[i]['plies'] +')" >Print</button>'+
                                '</td></tr>');
                    }

                } catch (e)
                {
                    console.log(e);
                }
            }
        });
    }
    $("#size-table tbody").on("keyup", "input", function (event) {
        var plies = parseInt($("#mdl-lyers").val());
        var $row = $(this).closest('tr');
        var plan_qty = parseInt($row.find('td').eq(3).text());
        var cmplt_qty = parseInt($row.find('td').eq(4).text());
        $row.find('td').eq(2).text(plies * parseInt(this.value));
        $row.find('td').eq(5).text(plan_qty - (cmplt_qty + plies * parseInt(this.value)));
    });

    $("#mdl-btn-ratio").click(function (event) {

        var obj = $('#myModal5').form_validator('validate');
//console.log(obj);
//remove unwanted colmn from header obj
        delete obj.plies;

        if (obj !== undefined && obj !== false)
        {
            //get ratio section data
            var cut_plan_id = $('#mdl-cut-plan-id').val();
            var plies = $('#mdl-lyers').val();
            var table = $("#size-table tbody");
            var mkr_ref = $("#mdl-mkrRef").val();
            var marker_legth = $("#mdl-yds").val();
            var width = $("#mdl-width").val();
            // var rowCount = $('#mdl-tbl-ratio tbody tr').length
            var arr = [];
            table.find('tr').each(function (i) {
                var fieldset = $(this);
                console.log($('input:text:eq(0)', fieldset).val());
                //var obj={};
                var tds = $(this).find('td')
                var obj_data = {
                    'cut_plan_id': cut_plan_id,
                    'ratio': $('input:text:eq(0)', fieldset).val(),
                    'size': tds.eq(0).text(),
                    'qty': tds.eq(2).text(),
                    'plies': plies,
                    'marker_ref': mkr_ref,
                    'marker_legth': marker_legth,
                    'width': width,
                }
                arr.push(obj_data);

            });
            //detail section end

            appAjaxRequest({
                url: BASE_URL + 'index.php/cut_plan/save_cut_plan_ratio',
                'data': {'formData': obj, 'ratio': arr},
                success: function (response) {
                    var obj = JSON.parse(response);
                    if (obj != undefined && obj != null)
                        var data = obj['data']['cut_plan_id'];
                    var detail = obj['data']['detail'];
                    var size_data_grid = obj['data']['order_size_data'];

                    appSetFormData(
                            [
                                {id: 'mdl-cut-plan-id', value: data},
                            ]
                            );

                    setTableData('', 'mdl-tbl-ratio');
                    for (var i = 0; i < detail.length; i++) {
                        $('#mdl-tbl-ratio').append(
                                '<tr>' +
                                '<td>' + detail[i]['size'] + '</td>' +
                                '<td>' + detail[i]['ratio'] + '</td>' +
                                '<td>' + detail[i]['plies'] + '</td>' +
                                '<td>' + (detail[i]['ratio'] * detail[i]['plies']) + '</td>' +
                                '<td>' + detail[i]['marker_ref'] + '</td>' +
                                '<td>' + detail[i]['width'] + '</td>' +
                                '<td>' + detail[i]['line_no'] + '</td>' +
                                '<td>' + detail[i]['width'] + '</td>' +
                                '<td>' + detail[i]['width'] + '</td>' +
                                '</tr>');
                    }
// update cutable size qty
                    for (var i = 0; i < size_data_grid.length; i++) {
                        $("#mdl-" + size_data_grid[i]['prod_ord_size']).html(size_data_grid[i]['cut_plan_qty']);
                        $("#mdl-qty-" + size_data_grid[i]['prod_ord_size']).html(size_data_grid[i]['prod_ord_plan_qty'] - size_data_grid[i]['cut_plan_qty']);

                    }
                    // update_order_qtys(data);

                }
            });
        }
    });

    function remove_cut_plan() {

    }






//self execution function ends here
})();
