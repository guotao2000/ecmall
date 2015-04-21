(function(){

	//touch.on(document, "DOMContentLoaded", function(){
		var state = "";
		var codeArea = document.querySelector("#code .viewport");
		var playArea = document.querySelector("#playarea");
		var logger = document.querySelector("#logger");
		var prefix = "#codes #";
		var suffix = "-code";

		function log(msg){
			logger.innerText = msg;
		}

	


		//init
		//(function(){
			//entry("touch");
				playArea.innerHTML = "";
			var target = document.createElement("img");
			target.id = "target";
			target.draggable = false;
			target.src = "images/cloud.png";
			playArea.appendChild(target);
			setTimeout(function(){
				target.classList.add("show");
			}, 10);
			log("识别原生事件");
				touch.on('#target', 'touchstart', function(ev){
					ev.preventDefault();
				});
				touch.on('#target', 'touchstart', function(event){
				
					
					log("当前为原生事件1: " + event.type);
				});
				touch.on('#target', 'touchmove', function(event){
				
					
					log("当前为原生事件2: " + event.type);
				});
				touch.on('#target', 'touchend', function(event){
				
					
					log("当前为原生事件3: " + event.type);
				});
			//nl.querySelector("li").classList.add("active");	
		//})();

	//});

})();