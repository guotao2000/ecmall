// JavaScript Document
window.onload = function(){
   dosth1();

   //dosth2();

}
 function  dosth1(){

	var oStar = document.getElementById("star");
	
	var aLi = oStar.getElementsByTagName("li");
	var oUl = oStar.getElementsByTagName("ul")[0];
	var oSpan = oStar.getElementsByTagName("span")[1];
	var oP = oStar.getElementsByTagName("p")[0];
	var i = iScore = iStar = 0;
	var aMsg = [
				"很差|很差",
				"差|差",
				"一般|一般",
				"好|好",
				"非常好|非常好"
				]

	for (i = 1; i <= aLi.length; i++){
		aLi[i - 1].index = i;
		
		//鼠标移过显示分数
		/*aLi[i - 1].onmouseover = function (){
			fnPoint(this.index);
		};
		
		//鼠标离开后恢复上次评分
		aLi[i - 1].onmouseout = function (){
			fnPoint();
		};*/
		
		//点击后进行评分处理
		aLi[i - 1].onclick = function (){
			fnPoint(this.index);
			iStar = this.index;
			oP.style.display = "none";
			oP.innerHTML = "<input type='hidden' name='pen_service' value='"+this.index+"'></input>";
			oSpan.innerHTML = "<strong>" +(this.index) + " 分</strong> (" + aMsg[this.index - 1].match(/\|(.+)/)[1] + ")"
		}
	}
	
	//评分处理
	function fnPoint(iArg){
		//分数赋值
		iScore = iArg || iStar;
		for (i = 0; i < aLi.length; i++) aLi[i].className = i < iScore ? "on" : "";	
	}
	
};
// JavaScript Document

function dosth2(){
	var oStar = document.getElementById("star2");
	
	var aLi = oStar.getElementsByTagName("li");
	var oUl = oStar.getElementsByTagName("ul")[0];
	var oSpan = oStar.getElementsByTagName("span")[1];
	var oP = oStar.getElementsByTagName("p")[0];
	var i = iScore = iStar = 0;
	var aMsg = [
				"很慢|很慢",
				"慢|慢",
				"一般|一般",
				"快|快",
				"非常快|非常快"
				]

	for (i = 1; i <= aLi.length; i++){
		aLi[i - 1].index = i;
		
		//鼠标移过显示分数
		/*aLi[i - 1].onmouseover = function (){
			fnPoint(this.index);
		};
		
		//鼠标离开后恢复上次评分
		aLi[i - 1].onmouseout = function (){
			fnPoint();
		};*/
		
		//点击后进行评分处理
		aLi[i - 1].onclick = function (){
			fnPoint(this.index);
			iStar = this.index;
			oP.style.display = "none";
			oP.innerHTML = "<input type='hidden' name='pen_ship' value='"+this.index+"'></input>";
			oSpan.innerHTML = "<strong>" +(this.index) + " 分</strong> (" + aMsg[this.index - 1].match(/\|(.+)/)[1] + ")"
		}
	}
	
	//评分处理
	function fnPoint(iArg){
		//分数赋值
		iScore = iArg || iStar;
		for (i = 0; i < aLi.length; i++) aLi[i].className = i< iScore ? "on" : "";	
	}
}
	

//文本域点击
$(document).ready(function(e) {
	/*
   $("#clear").mousedown(function(){
		var str=$(this).val();
		if(str!=""&&str!="您有什么想对我说的呢"){
		$(this).val(s);}
		else  $(this).val("");
		});*/
	 $(".text").mousedown(function(){
		var str=$(this).val();
		if(str!=""&&str!="商品很不错哟"){
		$(this).val(s);}
		else  $(this).val("");
		});
		 
	/*$("#clear").mouseleave(function(){
		var s=$(this).val();
		if(s!=""&&s!="您有什么想对我说的呢"){
			$(this).val(s);
			}else $(this).val("您有什么想对我说的呢");
		})*/
	$(".text").mouseleave(function(){
		var s=$(this).val();
		if(s!=""&&s!="商品很不错哟"){
			$(this).val(s);
			}else $(this).val("商品很不错哟");
		})
//评论商品
$(".radio").click(function(){
	$(this).attr("checked","checked");
	})
	
	//商品滑动展开
	$(".zq_sp").click(function(){
		$(this).next(".zq_list").slideToggle();
	})
	
});




