jQuery.fn.floatdiv=function(location){
        //�ж�������汾
    var isIE6=false;
    var Sys = {};
    var ua = navigator.userAgent.toLowerCase();
    var s;
    (s = ua.match(/msie ([\d.]+)/)) ? Sys.ie = s[1] : 0;
    if(Sys.ie && Sys.ie=="6.0"){
        isIE6=true;
    }
    var windowWidth,windowHeight;//���ڵĸߺͿ�
    //ȡ�ô��ڵĸߺͿ�
    if (self.innerHeight) {
        windowWidth=self.innerWidth;
        windowHeight=self.innerHeight;
    }else if (document.documentElement&&document.documentElement.clientHeight) {
        windowWidth=document.documentElement.clientWidth;
        windowHeight=document.documentElement.clientHeight;
    } else if (document.body) {
        windowWidth=document.body.clientWidth;
        windowHeight=document.body.clientHeight;
    }
    return this.each(function(){
        var loc;//��ľ��Զ�λλ��
        var wrap=$("<div></div>");
        var top=-1;
        if(location==undefined || location.constructor == String){
            switch(location){
                case("rightbottom")://���½�
                    loc={right:"0px",bottom:"0px"};
                    break;
                case("leftbottom")://���½�
                    loc={left:"0px",bottom:"0px"};
                    break;  
                case("lefttop")://���Ͻ�
                    loc={left:"0px",top:"0px"};
                    top=0;
                    break;
                case("righttop")://���Ͻ�
                    loc={right:"0px",top:"0px"};
                    top=0;
                    break;
                case("middletop")://�����ö�
                    loc={left:windowWidth/2-$(this).width()/2+"px",top:"0px"};
                    top=0;
                    break;
                case("middlebottom")://�����õ�
                    loc={left:windowWidth/2-$(this).width()/2+"px",bottom:"0px"};
                    break;
                case("leftmiddle")://��߾���
                    loc={left:"0px",top:windowHeight/2-$(this).height()/2+"px"};
                    top=windowHeight/2-$(this).height()/2;
                    break;
                case("rightmiddle")://�ұ߾���
                    loc={right:"0px",top:windowHeight/2-$(this).height()/2+"px"};
                    top=windowHeight/2-$(this).height()/2;
                    break;
                case("middle")://����
                    var l=0;//����
                    var t=0;//����
                    l=windowWidth/2-$(this).width()/2;
                    t=windowHeight/2-$(this).height()/2;
                    top=t;
                    loc={left:l+"px",top:t+"px"};
                    break;
                default://Ĭ��Ϊ���½�
                    location="rightbottom";
                    loc={right:"0px",bottom:"0px"};
                    break;
            }
        }else{
            loc=location;
            //alert(loc.bottom);
            var str=loc.top;
            //09-11-5�޸ģ�����topΪ��ֵʱ���ж�
            if (typeof(str)!= 'undefined'){
                str=str.replace("px","");
                top=str;
            }
        }
        /*fied ie6 css hack*/
        if(isIE6){
            if (top>=0)
            {
                wrap=$("<div style=\"top:expression(documentElement.scrollTop+"+top+");\"></div>");
            }else{
                wrap=$("<div style=\"top:expression(documentElement.scrollTop+documentElement.clientHeight-this.offsetHeight);\"></div>");
            }
        }
        $("body").append(wrap);
         
        wrap.css(loc).css({position:"fixed",
            z_index:"999"});
        if (isIE6)
        {
             
            wrap.css("position","absolute");
            //û�м�����Ļ���ie6ʹ�ñ���ʽʱ�ͻᷢ����������
            //����ΪʲôҪ�����������ΪʲôҪ��nothing.txt�����żҲ��֪����ϣ��֪����ͬѧ���Ը�����
            $("body").css("background-attachment","fixed").css("background-image","url(n1othing.txt)");
        }
        //��Ҫ�̶��Ĳ����ӵ��̶�����
        $(this).appendTo(wrap);
    });
};