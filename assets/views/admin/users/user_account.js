
(function(){

  var BASE_URL = null;

  $(document).ready(function(){

      BASE_URL = $('#base-url').val();

      $('#data-form').form_validator({
          events : ['blur'],
          fields : {
              'id' : {
                  key : 'id'
              },
              'first_name' : {
                  notEmpty : {
                      message : 'First name cannot be empty'
                  }
              },
              'last_name' : {
                  notEmpty : {
                      message : 'Last name cannot be empty'
                  }
              },
              'contact_no' : {
                  notRequired : true,
                  type : {
                      type : 'phone',
                      message : 'Incorrect contact number'
                  }
              },
              'password' : {
                  key : 'password',
                  notRequired : true
              },
              'conf_password' : {
                  key : 'conf_pass',
                  notRequired : true,
                  valueCheck : {
                      'ele_to_check' : 'password',
                      message : 'Confirm your password'
                  }
              }
          }
      });


      $('#btn_save').click(function(){
          var obj =  $('#data-form').form_validator('validate');
          if(obj !== undefined && obj !== false)
          {
             appAjaxRequest({
                 url : BASE_URL + 'index.php/user/save_user_account',
                 data : { 'data' : obj },
                 type : 'POST',
                 async : false,
                 dataType : 'json',
                 'success' : function(res){
                     if(res.status == 'success') {
                       appAlertSuccess(res.message, function(){
                         location.reload();
                       });
                     }
                     else  {
                         appAlertError(res['message']);
                     }
                 }
             });
          }
      });


  });


})();
