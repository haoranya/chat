$(function (){
					
   window['dandan']={}
   var ing_user;//当前用户
   //浏览器
   function liulanqi(){
	  var h=$(window).height();
	  var w=$(window).width();
	  $("#top").width(w);
	  $("#foot").html(h);
	 
	  $(".box").height(h-135);
	  $("#mid_con").height(h-255);
	  $(".right_box").height(h-134);
	  $("#mid_say textarea").width(w-480);
	  
	  if($(".box").height()<350){
		$(".box").height(350)
		 }
	  if($("#mid_con").height()<230){
		 $("#mid_con").height(230)
		  }
	  if($(".right_box").height()<351){
		 $(".right_box").height(351)
		  }
	  if($("#mid_say textarea").width()<320){
		  $("#mid_say textarea").width(320)
		  }
	  
	  if(w<=800){
		  $("#top").width(800);
		  $("#body").width(800)
		   }else{
		  $("#body").css("width","100%")  
		}	  

	  
	  $(".my_show").height($("#mid_con").height()-30);//显示的内容的高度出现滚动条

	  //右边的高度
	  r_h=$(".right_box").height()-40*3;
	  $("#right_top").height(r_h*0.25)
	  $("#right_mid").height(r_h*0.45)
	  $("#right_foot").height(r_h*0.3)
	  
   }
   window['dandan']['liulanqi']=liulanqi;
   
 //时间
function mytime(){
   var now=(new Date()).getHours();
    if(now>0&&now<=6){
	  return "午夜好";
    }else if(now>6&&now<=11){
	  return  "早上好";
    }else if(now>11&&now<=14){
	  return "中午好";
    }else if(now>14&&now<=18){
	  return "下午好";
   }else{
	  return "晚上好";
   }
}
window['dandan']['mytime']=mytime;   
   
//触发浏览器   
$(window).scroll( function() { dandan.liulanqi();  } );//滚动触发
$(window).resize(function(){ dandan.liulanqi(); return false; });//窗口触发

dandan.liulanqi();

		 
//替换所有的回车换行   
function trim2(content)   
{   
    var string = content;   
    try{   
        string=string.replace(/\r\n/g,"<br />")   
        string=string.replace(/\n/g,"<br />");         
    }catch(e) {   
        alert(e.message);   
    }   
    return string;   
} 	
//替换所有的空格
function trim(content)   
{   
    var string = content;   
    try{   
        string=string.replace(/ /g,"&nbsp;")        
    }catch(e) {   
        alert(e.message);   
    }   
    return string;   
} 	

					 
//显示所有用户个数
function user_geshu(){

     var length2=$(".ul_2 > li").length;

     $(".n_geshu_2").text(length2);	
}
user_geshu()

//点击展开会员
$(".h3").click(function (){
	 $(this).toggleClass("click_h3").next(".ul").toggle(600);
});

$("#right_foot").html('<p><img src="/images/head.jpg" alt="头象" /></p>'+$admin_name);

//过滤所有的空格
function kongge(content)   
{   
    return content.replace(/^\s\s*/, '').replace(/\s\s*$/, '');   
} 
window['dandan']['kongge']=kongge;

//欢迎
$("#top").html('<br />&nbsp;&nbsp;'+dandan.mytime()+','+$admin_name+',欢迎你的到来！！');       

})