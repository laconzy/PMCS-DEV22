$(function () {

  let BUILDINGS = ['A', 'BC'];
  let currentBuilding = 0;

  function loadTable(_building){
    appAjaxRequest({
      url : BASE_URL + 'index.php/dashboard/production_data',
      type : 'GET',
      dataType : 'json',
      async : false,
      data : {
        //'section' : section,
        'building' : _building
      },
      success : function(res){
        if(res != null){
          var production_data = res.data;
          var max_hour = res.max_hour;
          generateTableContent(production_data, max_hour);
        }
      },
      error : function(err){
        console.log(err);
      }
    });
}


  function generateTableContent(production_data, max_hour){
    var str = '';
    //console.log(production_data)
    var plan_ttl=0;
    var commited_ttl=0;
    var qty_ttl=0;
    var hour_ttl=0;
    var variance_ttl=0;
    var hr1_ttl=0;
    var hr2_ttl=0;
    var hr3_ttl=0;
    var hr4_ttl=0;
    var hr5_ttl=0;
    var hr6_ttl=0;
    var hr7_ttl=0;
    var hr8_ttl=0;
    var hr9_ttl=0;
    var hr10_ttl=0;

    let plan_summery = 0;
    let commited_summery = 0;
    let qty_summery = 0;
    let hour_summery = 0;
    let variance_summery = 0;
    let hr1_summery = 0;
    let hr2_summery = 0;
    let hr3_summery = 0;
    let hr4_summery = 0;
    let hr5_summery = 0;
    let hr6_summery = 0;
    let hr7_summery = 0;
    let hr8_summery = 0;
    let hr9_summery = 0;
    let hr10_summery = 0;

    let currentStyle = production_data.length > 0 ? production_data[0]['style_cat'] : "";
    let currentSection = production_data.length > 0 ? production_data[0]['section'] : "";

for(var x = 0 ; x < production_data.length ; x++){

  production_data[x]['per_hour'] = parseFloat(production_data[x]['per_hour']);
  production_data[x]['per_hour'] = Math.ceil(production_data[x]['per_hour']);
  var variance = parseInt(production_data[x]['qty']) - (parseInt(max_hour) * production_data[x]['per_hour']);

  var var_color='font_blue';
  if(variance<0){
  var_color='font_red';
  }
  var hr1 ='font_blue';
  if(parseInt(production_data[x]['1'])<parseInt(production_data[x]['per_hour'])){
  var hr1 ='font_red';
  }
  var hr2 ='font_blue';
  if(parseInt(production_data[x]['2'])<parseInt(production_data[x]['per_hour'])){
  var hr2 ='font_red';
  }
  var hr3 ='font_blue';
  if(parseInt(production_data[x]['3'])<parseInt(production_data[x]['per_hour'])){
  var hr3 ='font_red';
  }
  var hr4 ='font_blue';
  if(parseInt(production_data[x]['4'])<parseInt(production_data[x]['per_hour'])){
  var hr4 ='font_red';
  }
  var hr5 ='font_blue';
  if(parseInt(production_data[x]['5'])<parseInt(production_data[x]['per_hour'])){
  var hr5 ='font_red';
  }

var hr6 ='font_blue';
if(parseInt(production_data[x]['6'])<parseInt(production_data[x]['per_hour'])){
var hr6 ='font_red';
}
var hr7 ='font_blue';
if(parseInt(production_data[x]['7'])<parseInt(production_data[x]['per_hour'])){
var hr7 ='font_red';
}
var hr8 ='font_blue';
if(parseInt(production_data[x]['8'])<parseInt(production_data[x]['per_hour'])){
var hr8 ='font_red';
}
var hr9 ='font_blue';
if(parseInt(production_data[x]['9'])<parseInt(production_data[x]['per_hour'])){
var hr9 ='font_red';
}
var hr10 ='font_blue';
if(parseInt(production_data[x]['10'])<parseInt(production_data[x]['per_hour'])){
var hr10 ='font_red';
}
var hr11 ='font_blue';
if(parseInt(production_data[x]['11'])<parseInt(production_data[x]['per_hour'])){
var hr11 ='font_red';
}

var hr12 ='font_blue';
if(parseInt(production_data[x]['12'])<parseInt(production_data[x]['per_hour'])){
var hr12 ='font_red';
}

plan_ttl = plan_ttl + parseInt(production_data[x]['plan_qty']);
commited_ttl = commited_ttl + parseInt(production_data[x]['commited']);
qty_ttl = qty_ttl + parseInt(production_data[x]['qty']);
hour_ttl = hour_ttl + parseInt(production_data[x]['per_hour']);
variance_ttl = variance_ttl + parseInt(variance);
hr1_ttl = hr1_ttl + parseInt(production_data[x]['1']);
hr2_ttl = hr2_ttl + parseInt(production_data[x]['2']);
hr3_ttl = hr3_ttl + parseInt(production_data[x]['3']);
hr4_ttl = hr4_ttl + parseInt(production_data[x]['4']);
hr5_ttl = hr5_ttl + parseInt(production_data[x]['5']);
hr6_ttl = hr6_ttl + parseInt(production_data[x]['6']);
hr7_ttl = hr7_ttl + parseInt(production_data[x]['7']);
hr8_ttl = hr8_ttl + parseInt(production_data[x]['8']);
hr9_ttl = hr9_ttl + parseInt(production_data[x]['9']);
hr10_ttl = hr10_ttl + parseInt(production_data[x]['10']);

plan_summery = plan_summery + parseInt(production_data[x]['plan_qty']);
commited_summery = commited_summery + parseInt(production_data[x]['commited']);
qty_summery = qty_summery + parseInt(production_data[x]['qty']);
hour_summery = hour_summery + parseInt(production_data[x]['per_hour']);
variance_summery = variance_summery + parseInt(variance);
hr1_summery = hr1_summery + parseInt(production_data[x]['1']);
hr2_summery = hr2_summery + parseInt(production_data[x]['2']);
hr3_summery = hr3_summery + parseInt(production_data[x]['3']);
hr4_summery = hr4_summery + parseInt(production_data[x]['4']);
hr5_summery = hr5_summery + parseInt(production_data[x]['5']);
hr6_summery = hr6_summery + parseInt(production_data[x]['6']);
hr7_summery = hr7_summery + parseInt(production_data[x]['7']);
hr8_summery = hr8_summery + parseInt(production_data[x]['8']);
hr9_summery = hr9_summery + parseInt(production_data[x]['9']);
hr10_summery = hr10_summery + parseInt(production_data[x]['10']);

let styleText = 'style="padding: 0px 8px 0px 8px"';

str += '<tr class="font2">';
str += '<td '+styleText+'>'+production_data[x]['section']+'</td>';
//str += '<td>'+production_data[x]['commited_by']+'</td>';
str += '<td '+styleText+'>'+production_data[x]['line_code']+'</td>';
str += '<td '+styleText+'>'+production_data[x]['style_cat']+'</td>';
str += '<td '+styleText+'>'+production_data[x]['plan_qty']+'</td>';
str += '<td '+styleText+'>'+production_data[x]['commited']+'</td>';
str += '<td '+styleText+'>'+Math.round(production_data[x]['per_hour'])+'</td>';
str += '<td class="font_blue" '+styleText+'>'+production_data[x]['qty']+'</td>';
str += '<td class='+var_color+' '+styleText+'>'+variance+'</td>';
str += '<td class='+hr1+' '+styleText+'>'+ getHourValue(production_data[x]['1']) +'</td>';
str += '<td class='+hr2+' '+styleText+'>'+ getHourValue(production_data[x]['2']) +'</td>';
str += '<td class='+hr3+' '+styleText+'>'+ getHourValue(production_data[x]['3'])+'</td>';
str += '<td class='+hr4+' '+styleText+'>'+ getHourValue(production_data[x]['4'])+'</td>';
str += '<td class='+hr5+' '+styleText+'>'+ getHourValue(production_data[x]['5']) +'</td>';
str += '<td class='+hr6+' '+styleText+'>'+ getHourValue(production_data[x]['6'])+'</td>';
str += '<td class='+hr7+' '+styleText+'>'+ getHourValue(production_data[x]['7']) +'</td>';
str += '<td class='+hr8+' '+styleText+'>'+ getHourValue(production_data[x]['8']) +'</td>';
str += '<td class='+hr9+' '+styleText+'>'+ getHourValue(production_data[x]['9']) +'</td>';
str += '<td class='+hr10+' '+styleText+'>'+ getHourValue(production_data[x]['10'])+'</td>';
str += '</tr>';

if(production_data[x + 1] == undefined ||  production_data[x + 1] == null || production_data[x + 1]['style_cat'] != currentStyle){
  str += '<tr class="font2" style="background-color:#F0F0F0">';
  str += '<td></td>';
  //str += '<td></td>';
  str += '<td></td>';
  str += '<td></td>';
  str += '<td '+styleText+'>' + getHourValue(plan_summery) + '</td>';
  str += '<td '+styleText+'>' + getHourValue(commited_summery) + '</td>';
  str += '<td '+styleText+'>' + getHourValue(hour_summery) + '</td>';
  str += '<td class="font_blue" '+styleText+'>' + getHourValue(qty_summery) + '</td>';
  str += '<td class='+var_color+' '+styleText+'>' + getHourValue(variance_summery) + '</td>';
  str += '<td class='+hr1+' '+styleText+'>' + getHourValue(hr1_summery) + '</td>';
  str += '<td class='+hr2+' '+styleText+'>' + getHourValue(hr2_summery) + '</td>';
  str += '<td class='+hr3+' '+styleText+'>' + getHourValue(hr3_summery) + '</td>';
  str += '<td class='+hr4+' '+styleText+'>' + getHourValue(hr4_summery) + '</td>';
  str += '<td class='+hr5+' '+styleText+'>' + getHourValue(hr5_summery) + '</td>';
  str += '<td class='+hr6+' '+styleText+'>' + getHourValue(hr6_summery) + '</td>';
  str += '<td class='+hr7+' '+styleText+'>' + getHourValue(hr7_summery) + '</td>';
  str += '<td class='+hr8+' '+styleText+'>' + getHourValue(hr8_summery) + '</td>';
  str += '<td class='+hr9+' '+styleText+'>' + getHourValue(hr9_summery) + '</td>';
  str += '<td class='+hr10+' '+styleText+'>' + getHourValue(hr10_summery) + '</td>';
  str += '</tr>';
  currentStyle = production_data[x + 1] != undefined ? production_data[x + 1]['style_cat'] : "";

  plan_summery = 0;
  commited_summery = 0;
  qty_summery = 0;
  hour_summery = 0;
  variance_summery = 0;
  hr1_summery = 0;
  hr2_summery = 0;
  hr3_summery = 0;
  hr4_summery = 0;
  hr5_summery = 0;
  hr6_summery = 0;
  hr7_summery = 0;
  hr8_summery = 0;
  hr9_summery = 0;
  hr10_summery = 0;
}

  if(currentBuilding == 1){
    if(production_data[x + 1] == undefined ||  production_data[x + 1] == null || production_data[x + 1]['section'] != currentSection){
      str += '<tr class="font2" bgcolor="black">';
      str += '<td></td>';
      //str += '<td></td>';
      str += '<td></td>';
      str += '<td></td>';
      str += '<td class="font1">'+plan_ttl+'</td>';
      str += '<td class="font1">'+commited_ttl+'</td>';
      str += '<td class="font1">'+hour_ttl+'</td>';
      str += '<td class="font1">'+qty_ttl+'</td>';
      str += '<td class="font1">'+variance_ttl+'</td>';
      str += '<td class="font1">'+hr1_ttl+'</td>';
      str += '<td class="font1" >'+hr2_ttl+'</td>';
      str += '<td class="font1" >'+hr3_ttl+'</td>';
      str += '<td class="font1" >'+hr4_ttl+'</td>';
      str += '<td class="font1" >'+hr5_ttl+'</td>';
      str += '<td class="font1">'+hr6_ttl+'</td>';
      str += '<td class="font1">'+hr7_ttl+'</td>';
      str += '<td class="font1">'+hr8_ttl+'</td>';
      str += '<td class="font1">'+hr9_ttl+'</td>';
      str += '<td class="font1">'+hr10_ttl+'</td>';
      str += '</tr>';

      plan_ttl = 0;
      commited_ttl = 0;
      hour_ttl = 0;
      qty_ttl = 0;
      variance_ttl = 0;
      hr1_ttl = 0;
      hr2_ttl = 0;
      hr3_ttl = 0;
      hr4_ttl = 0;
      hr5_ttl = 0;
      hr7_ttl = 0;
      hr8_ttl = 0;
      hr9_ttl = 0;
      hr10_ttl = 0;
      currentSection = production_data[x + 1] != undefined ? production_data[x + 1]['section'] : "";
    }
  }

}

if(currentBuilding == 0){
  str += '<tr class="font2" bgcolor="black">';
  str += '<td></td>';
  //str += '<td></td>';
  str += '<td></td>';
  str += '<td></td>';
  str += '<td class="font1">'+plan_ttl+'</td>';
  str += '<td class="font1">'+commited_ttl+'</td>';
  str += '<td class="font1">'+hour_ttl+'</td>';
  str += '<td class="font1">'+qty_ttl+'</td>';
  str += '<td class="font1">'+variance_ttl+'</td>';
  str += '<td class="font1">'+hr1_ttl+'</td>';
  str += '<td class="font1" >'+hr2_ttl+'</td>';
  str += '<td class="font1" >'+hr3_ttl+'</td>';
  str += '<td class="font1" >'+hr4_ttl+'</td>';
  str += '<td class="font1" >'+hr5_ttl+'</td>';
  str += '<td class="font1">'+hr6_ttl+'</td>';
  str += '<td class="font1">'+hr7_ttl+'</td>';
  str += '<td class="font1">'+hr8_ttl+'</td>';
  str += '<td class="font1">'+hr9_ttl+'</td>';
  str += '<td class="font1">'+hr10_ttl+'</td>';
  str += '</tr>';
}


    $('#table_production tbody').html(str);
//console.log(str)
  }


  function getHourValue(_val){
    if(_val == undefined || _val == null || _val == 0 || _val == '0'){
      return '';
    }
    else {
      return _val;
    }
  }


  function oldCodeInsideInterval(){
    	//  appAjaxRequest({

	//       url : BASE_URL + 'index.php/dashboard/production_data',

	//       type : 'GET',

	//       dataType : 'json',

	//       async : false,

	//       data : {

	//         'section' : section

	//       },

	//       success : function(res){

	//        // console.log(res);
	//         if(res != null){

	//           var production_data = res.data;
	// //alert(rejection.length)
	// var str = '';
	// console.log(production_data)
	// //alert(production_data.length)
	// var plan_ttl=0;
	// var commited_ttl=0;
	// var commited_ttl=0;
	// var hour_ttl=0;
	// var commited_ttl=0;
	// var commited_ttl=0;
	// var commited_ttl=0;
	// var commited_ttl=0;
	// var commited_ttl=0;
	// var commited_ttl=0;
	// var commited_ttl=0;
	// for(var x = 0 ; x < production_data.length ; x++){
	// var vairiance= parseInt(production_data[x]['qty'])-parseInt(production_data[x]['commited']);

	//   str += '<tr class="font2">';
	//   str += '<td>'+production_data[x]['section']+'</td>';
	//   str += '<td>'+production_data[x]['section']+'</td>';
	//   str += '<td>'+production_data[x]['line_code']+'</td>';
	//   str += '<td>'+production_data[x]['style_name']+'</td>';
	//   str += '<td>'+production_data[x]['plan_qty']+'</td>';
	//   str += '<td>'+production_data[x]['commited']+'</td>';
	//   str += '<td>'+Math.round(production_data[x]['per_hour'])+'</td>';
	//   str += '<td>'+production_data[x]['qty']+'</td>';
	//   str += '<td>'+vairiance+'</td>';
	//   str += '<td>'+production_data[x]['1']+'</td>';
	//   str += '<td>'+production_data[x]['2']+'</td>';
	//   str += '<td>'+production_data[x]['3']+'</td>';
	//   str += '<td>'+production_data[x]['4']+'</td>';
	//   str += '<td>'+production_data[x]['5']+'</td>';
	//   str += '<td>'+production_data[x]['6']+'</td>';
	//   str += '<td>'+production_data[x]['7']+'</td>';
	//   str += '<td>'+production_data[x]['8']+'</td>';
	//   str += '<td>'+production_data[x]['9']+'</td>';
	//   str += '<td>'+production_data[x]['10']+'</td>';
	//   str += '<td>'+production_data[x]['11']+'</td>';
	//   str += '<td>'+production_data[x]['12']+'</td>';
	//   str += '</tr>';
	//   console.log(str)
	// }

	//           $('#table_production tbody').html(str);
	//   //console.log(str)
	// }



	// },

	// error : function(err){

	//   console.log(err);

	// }

	// });
  }


  $(document).ready(function(){

    var section = $('#section').val();

    loadTable('A');
    currentBuilding = 1;

    setInterval(function(){
      loadTable(BUILDINGS[currentBuilding]);
      currentBuilding++;

      if(currentBuilding > 1){
        currentBuilding = 0;
      }

    }, 30000);


	});
});
