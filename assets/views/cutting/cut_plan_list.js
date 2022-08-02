var TABLE = null;

var MSG = null;

var SITE_VIEW = null;

var SITE_DEL = null;

var SEARCH_TEXT = '';



$(document).ready(function() {



    USER_VIEW = $('#user-view').val();

    USER_DEL = $('#user-del').val();



    var columns = [

      { "data": "cut_plan_id"},

      { "data": "color_code" },

      { "data": "style_code" },
      { "data": "customer_po" },
      { "data": "prod_ord_detail_id" },

      /*{

        "data": "active",

        render : function(data){

          if(data == 'Y')

            return '<span class="text-success">Active</span>';

          else

            return '<span class="text-danger">Deactive</span>';

        }

      },*/

      {

        "data": "cut_plan_id",

        "orderable": false,

        'width':'5%',

        render : function(data, type, full, meta ){

          /*str = '<button class="btn btn-primary btn-xs" data-btn="view" data-id="'+data+'"><i class="fa fa-edit"></i></button> ';*/

          var str = '<button class="btn btn-info btn-xs" data-btn="view_cut_plan" data-id="'+data+'"><i class="fa fa-print"> Print</i></button>';

          return str;

        }

      },

			{

				"data": "cut_plan_id",

				"orderable": false,

				'width':'5%',

				render : function(data, type, full, meta ){

					/*str = '<button class="btn btn-primary btn-xs" data-btn="view" data-id="'+data+'"><i class="fa fa-edit"></i></button> ';*/

          var str = '<button class="btn btn-danger btn-xs" data-btn="delete" data-id="'+data+'"><i class="fa fa-remove"></i></button>';

          return str;

				}

			}

    ];



    /*if(USER_VIEW == 1){

        columns.push({

            "orderable": false,

            'data' : function(_data,a){

                return '<button class="btn btn-success btn-flat btn-sm" data-id="'+_data['id']+'" onclick="edit_user(this);">Edit</button>';

            }

        });

    }

    if(USER_DEL == 1){

        columns.push({

            "orderable": false,

            data : function(_data){

                return '<button class="btn btn-danger btn-flat btn-sm" data-id="'+_data['id']+'" onclick="delete_user(this)" disabled="disabled">Delete</button>';

            }

        });

    }*/



    TABLE = $('#cut-plans-table').DataTable( {

      "scrollY": "500px",

		  "scrollX": true,

		  "scrollCollapse": true,

      "autowidth":false,

		    /*"fixedColumns": {

			     leftColumns: 1

		  },*/

		  "searching": false,

		  "select": true,

		  "processing": true,

		  "serverSide": true,

        "ajax": {

            "url": BASE_URL+"index.php/cut_plan/get_cut_plans",

            "type": "POST",

            "data" : {

            	'searchText' : function(){return SEARCH_TEXT;}

            }

        },

        "columns": columns

    } );

} );



$('#btn-search').click(function(){

		SEARCH_TEXT = $('#search-text').val();

		TABLE.search("").draw();

	});



	$('#search-text').keypress(function(e) {

	    if(e.which == 13) {

	    	SEARCH_TEXT = $('#search-text').val();

			TABLE.search("").draw();

	    }

	});



$('#cut-plans-table').on('click','button',function(){

	var ele = $(this);

	var type = ele.attr('data-btn');

	if( type === 'delete')

		delete_cut_plan(this);

	else if(type === 'view_cut_plan' ){

    open_cut_plan(this);

  }

		

});



/*function open_color(ele)

{

    //alert($(ele).attr('data-id'));

    window.open(BASE_URL+'index.php/master/colour/color_view/'+$(ele).attr('data-id'));

}*/





function open_cut_plan(ele)

{

    //alert($(ele).attr('data-id'));

    window.open(BASE_URL+'index.php/cut_plan/cut_plan_view/'+$(ele).attr('data-id'));

}





function delete_cut_plan(ele)

{

  var plan_id = $(ele).attr('data-id');

  appAlertConfirm('Do you want to deactivate selected cut paln with all data?' , function(){

    appAjaxRequest({

      url : BASE_URL + 'index.php/cut_plan/destroy/'+plan_id,

      type: 'post',

      dataType : 'json',

	  async: false,

      success : function(res){

        if(res.status == 'success'){

          appAlertSuccess(res.message);

          TABLE.search("").draw();

        }

        else{

          appAlertError(res.message);

        }

      },

      error : function(err){

        alert(err);

      }

    });

  });

}

