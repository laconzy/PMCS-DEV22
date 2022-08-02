
$(document).ready(function(){
    
    //initialize form validation plugin
    $('#01-login-form').form_validator({
        events : ['blur'],
        fields : {
            '01-username' : {
                key : 'username',
                notEmpty : {
                    message : 'Username cannot be empty'
                }
            },
            '01-password' : {
                key : 'password',
                notEmpty : {
                    message : 'Password cannot be empty'
                }
            }
        }
    });
    
});

function user_login(){
  
   var obj =  $('#01-login-form').form_validator('validate');   
   if(obj !== undefined && obj !== false)      
       return true;  
   else
     return false;
};

