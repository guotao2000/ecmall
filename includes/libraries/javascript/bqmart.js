

//播放订单提示声音
    $(document).ready(function() {
         audioElement = document.createElement('audio');
        audioElement.setAttribute('src', '/msg.mp3');
        var int=self.setInterval("clock()",60000);
		
    });
	
function clock()
  {
	  if($("#store_id").length>0){
	  var url="/index.php?app=bqseller&store_id="+$("#store_id").val();
	
		
       $.getJSON(url, '', function(data){
		  
				if (data.done)
				{
					//if(data.retval.totalcount>0)
					//{
					//	play(audioElement);
					//	alert("您有新的订单，请及时处理！！");
					//	pause(audioElement,data.retval.url);
					//}
					if(data.retval.totalcount>0)
					{
						play(audioElement);
						//alert("您有新的订单，请及时处理！！");
						
					}else
						{
						pause(audioElement,data.retval.url);
						}
                }
        });
			}
  }
	
	//播放声音
	function play(audioElement)
	{
		audioElement.play();
	}
	//暂停功能
	function pause(audioElement,url)
	{
		audioElement.pause();///index.php?app=seller_order {$store_id}
		
			window.location.href=url;
		
	}