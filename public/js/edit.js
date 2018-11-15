function hit(){

    var uid = $("#uid").val();

    if($("#uname").val()==''){
       
        $("#error_uname").html('用户名不可以为空哦!!!'); 

        $("#uname").focus();

    }else if($("#tel_num").val()==''){

        $("#error_tel_num").html('手机号不可以为空哦!!!'); 

        $("#error_uname").html(''); 

        $("#tel_num").focus();

    }else if($("#tel_num").val()!=''){

        if(isPhoneNo($("#tel_num").val())==false){
            
            $("#error_tel_num").html('手机号码不正确');

            $("#error_uname").html(''); 

            $('#tel_num').focus();

        }else{

            if($("#old_password").val()==''){

                $("#error_old_password").html('旧密码不可以为空哦!!!');
        
                $("#error_tel_num").html('');
        
                $("#error_uname").html(''); 
        
                $("#old_password").focus();
        
            }else if($("#new_password").val()==''){
        
                $("#error_new_password").html('新密码不可以为空哦!!!');
        
                $("#error_old_password").html('');
        
                $("#error_tel_num").html('');
        
                $("#error_uname").html(''); 
        
                $("#new_password").focus();
        
            }else{

                var url = "/user/check_uname"
      
                $.ajax({
        
                    type:'GET',
        
                    url:url,
        
                    data:{uname:$("#uname").val(),uid:uid},
        
                    success:function(data){
        
                      if(data==1){
        
                        $("#error_uname").html('用户名已经存在');
        
                        $("#error_old_password").html('');
        
                        $("#error_new_password").html('');
                
                        $("#error_tel_num").html('');
                        
                        $('#uname').focus();
        
                      }else{

                        var url = "/user/check_tel_num"
      
                        $.ajax({
                
                            type:'GET',
                
                            url:url,
                
                            data:{tel_num:$("#tel_num").val(),uid:uid},
                
                            success:function(data){
                               
                              if(data==1){
                
                                $("#error_tel_num").html('手机号已经存在');
                
                                $('#tel_num').focus();
                
                              }else{

                                $("#error_new_password").html('');

                                $("#error_old_password").html('');
        
                                $("#error_new_password").html('');
                        
                                $("#error_tel_num").html('');

                                $("#error_uname").html(''); 

                                $("#form").submit();

                              }
                              
                            }
                
                        });

                      }
                      
                    }
        
                })
        
            }

        }
    }

}

// 验证手机号
function isPhoneNo(phone) { 
    var pattern = /^1[34578]\d{9}$/; 
    return pattern.test(phone); 
   }