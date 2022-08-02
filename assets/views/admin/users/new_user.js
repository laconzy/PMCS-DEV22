var MSG = null;

$(document).ready(function(){

    var id = $('#id').val();

    var validate_obj = {
        events : ['blur'],
        fields : {
           'id' : {
             key : 'id'
           },
			     'epf_no' : {
                notEmpty : {
                    message : 'EPF NO cannot be empty'
                }
            },

			     'site' : {
                notEmpty : {
                    message : 'Hela Location cannot be empty'
                }
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
			     'nic' : {
                notEmpty : {
                    message : 'NIC cannot be empty'
                }
            },
			      'designation' : {
                notEmpty : {
                    message : 'Select Designation '
                }
            },
            'contact_no' : {
                notRequired : true,
                type : {
                    type : 'phone',
                    message : 'Incorrect contact number'
                }
            },
            'email' : {
                key : 'email',
                notEmpty : {
                    message : 'Email address cannot be empty'
                },
                notRequired : true,
                type : {
                    type : 'email',
                    message : 'Incorrect email address'
                },
                remote : {
                    url : BASE_URL+'index.php/user/is_email_exists',
                    data : {value: function(){ return $('#email').val(); } , id:id}
                }
            },
            /*'05-username' : {
                key : 'username',
                notEmpty : {
                    message : 'Username cannot be empty'
                },
                remote : {
                    url : BASE_URL+'index.php/user/is_username_exists',
                    data : {value: function(){ return $('#05-username').val(); } , id:id}
                }
            }, */
            'permission_group' : {
                notRequired : true
            },
            'department' : {
                notEmpty : {
                    message : 'Department cannot be empty'
                },
            }
        }
    };

    if(id != '0')
    {

       validate_obj['fields']['password'] = {
                key : 'password',
                notRequired : true
            };
        validate_obj['fields']['conf_password'] = {
                key : 'conf_pass',
                notRequired : true,
                valueCheck : {
                    'ele_to_check' : 'password',
                    message : 'Confirm your password'
                }
            };
      // $('#05-image-section').show();
       //load_user_details(id);
    }
    else
    {
        validate_obj['fields']['password'] = {
                key : 'password',
                notEmpty : {
                    message : 'Password cannot be empty'
                }
            };
        validate_obj['fields']['conf_password'] = {
                key : 'conf_pass',
                notEmpty : {
                    message : 'Confirm passwor cannot be empty'
                },
                valueCheck : {
                    'ele_to_check' : 'password',
                    message : 'Confirm your password'
                }
            };
    }
     //initialize form validation plugin
    $('#data-form').form_validator(validate_obj);

});


$('#btn_save').click(function(){
    var obj =  $('#data-form').form_validator('validate');
    if(obj !== undefined && obj !== false)
    {
      obj['user_name'] = obj['email'];
      obj['active'] = $('#user_active').is(":checked") ? 'Y' : 'N';
       appAjaxRequest({
           url : BASE_URL+'index.php/user/save_user',
           'data' : { 'data' : obj},
           async : false,
           'success' : function(response){
               try{
                   var res = JSON.parse(response);
                   if(res['status'] == 'success') {
                     appAlertSuccess(res['message'],function(){
                       window.open(BASE_URL + 'index.php/user/show_user/' + res['id'] , '_self');
                     });
                   }
                   else {
                      appAlertSuccess('Process Error');
                   }
               }
               catch(e)
               {
                   alert(e);
               }

           }
       });
    }
    else
     return false;
});


function load_user_details(user_id)
{
    waitingDialog.show('Loading...', {dialogSize: 'sm', progressType: 'primary'});
    make_ajax_request({
        url : BASE_URL+'index.php/user/get_user',
        data : { id : user_id},
        success : function(response){
            try{
                var obj = JSON.parse(response);
                if(obj != undefined && obj != null)
                jsSetFormData(
                    [

						{id : '05-epfno' , value : obj['dtx_epfno']},
						{id : '05-initials-name' , value : obj['dtx_name_initials']},
						{id : '05-nic' , value : obj['dtx_nic']},
                        {id : '05-first-name' , value : obj['first_name']},
                        {id : '05-last-name' , value : obj['last_name']},
                        {id : '05-contact-no' , value : obj['contact_no']},
                        {id : '05-email' , value : obj['email']},
                       // {id : '05-username' , value : obj['user_name']},
                        {id : '05-user-level' , value : obj['user_level']},
						{id : '05-staf_cat' , value : obj['dtx_staff_cat']},
						{id : '05-designation' , value : obj['dtx_designation']},
                        {id : '05-department' , value : obj['department']},
                        {id : "05-permission-group" , value : obj['permission_group']},
						{id : "05-hela-location" , value : obj['dtx_loc']},
						{id : "05-hela-payrollloc" , value : obj['dtx_payrol_loc']},
						{id : "05-hela-grade" , value : obj['dtx_grade']}



                    ]


                );
				//alert(obj['dtx_user_activity']);

				$('#user_activation').prop('checked', obj['dtx_user_activity'] == 'true' ? true : false );


                $('#05-user-image').attr('src',BASE_URL+'assets/img/users/'+obj['image_name']);
                setTimeout(function(){
                    waitingDialog.hide();
                },1000)
            }
            catch(e)
            {
                console.log(e);
            }
        }
    });
}


$('#05-email').keyup(function(){
    $('#05-username').val(this.value);
});
