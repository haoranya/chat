function ok(){
    
    if($("#uname").val()==''){

        $("#error_uname").html("用户名不可以为空!");

        $('#uname').focus();

    }else if($("#password").val()==''){

        $("#error_password").html("密码不可以为空!");

        $("#error_uname").html('');

        $('#password').focus();

    }else if($("#tel_num").val()==''){

        $("#error_tel_num").html("手机号不可以为空!");

        $("#error_password").html('');

        $("#error_uname").html('');

        $('#tel_num').focus();

    }else if($("#tel_num").val()!=''){

        if(isPhoneNo($("#tel_num").val())==false){
            
            $("#error_tel_num").html('手机号码不正确');

            $("#error_password").html('');

            $("#error_uname").html('');

            $('#tel_num').focus();
        }else{

            var url = "/register/check_uname"
      
            $.ajax({
    
                type:'GET',
    
                url:url,
    
                data:{uname:$("#uname").val()},
    
                success:function(data){
    
                  if(data==1){
    
                    $("#error_uname").html('用户名已经存在');
    
                    $('#uname').focus();
    
                  }else{

                    var url = "/register/check_tel_num"
      
                    $.ajax({
            
                        type:'GET',
            
                        url:url,
            
                        data:{tel_num:$("#tel_num").val()},
            
                        success:function(data){
                           
                          if(data==1){
            
                            $("#error_tel_num").html('手机号已经存在');
            
                            $('#tel_num').focus();
            
                          }else{
        
                            $("#error_tel_num").html('');
        
                            $("#form").submit();
        
                          }
                          
                        }
            
                    })

                  }
                  
                }
    
            })



        }
    }

}

// 验证手机号
function isPhoneNo(phone) { 
    var pattern = /^1[34578]\d{9}$/; 
    return pattern.test(phone); 
   }