<?php

/* 微公众平台接口管理控制器 */

class Weixin_codeApp extends BackendApp {

    var $wx_code_mod;

    function __construct() {
        $this->Weixin_code();
    }

    function Weixin_code() {
        parent::BackendApp();
        $_POST = stripslashes_deep($_POST);
        $this->wx_code_mod = & m('wxcode');
		$this->weixin_config_mod = & m('wxpubconfig');
		$this->member_mod = & m('member');
    }
	//向服务器Post数据，并以json数据格式的形式返回
	function https_request($url, $data = null){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		if(!empty($data)){
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);
		return $output;
	}

    function index() {
          if (!IS_POST) {
             $wx_id = isset($_GET['wx_id'])? intval($_GET['wx_id']):0;
             $this->assign('wx_id', $wx_id);
             $this->display('weixin_code.index.html');
          } 

    }

	//获取access_token值
    private function get_access_token($appID, $appSecret){
		$appID = trim($appID);
		$appSecret = trim($appSecret);
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appID.'&secret='.$appSecret;
        $tempArr = json_decode($this->https_request($url), true);
        return $tempArr['access_token'];
    }

	//获取生成二维码的类型
	private function get_qrcode_type($v = 1){
		if($v == 0){
			return 'QR_SCENE';
		}
		if($v == 1){
			return 'QR_LIMIT_SCENE';
		}
	}

	//生成带参数二维码
	function create_code(){
		//获取传递的值
		$wx_id = isset($_GET['wx_id'])? intval($_GET['wx_id']):0;
		$uin = isset($_GET['uin'])? intval($_GET['uin']):0;
		$is_used = isset($_GET['is_used'])? intval($_GET['is_used']):0;
		$wx_title = isset($_GET['title'])? trim($_GET['title']):'';
		//获取该微信ID对应的信息
		$wx_info = $this->weixin_config_mod->find($wx_id);
		foreach($wx_info as $arr){
			$appid = trim($arr['appid']);
			$appsecret = trim($arr['appsecret']);
			$token = trim($arr['token']);
		}
		
		//获取access_token
		$access_token =$this->get_access_token($appid, $appsecret);

		//获取参数二维码的类型
		$qrcodeType = $this-> get_qrcode_type();
        $tempJson = '{"expire_seconds": 1800, "action_name": "'.$qrcodeType.'", "action_info": {"scene": {"scene_id": '.$uin.'}}}';
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
        $tempArr = json_decode($this->https_request($url, $tempJson), true);
		$qrcode_url = '';
        if(@array_key_exists('ticket', $tempArr)){
            $qrcode_url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$tempArr['ticket'];
        }

		//获取用户信息
		
		$conditions = "uin=" . $uin;
		$user_array = $this->member_mod->find(array('conditions' => $conditions));
		foreach($user_array as $arr){
			$user_id = trim($arr['user_id']);
			$user_name = trim($arr['user_name']);
			$user_level = trim($arr['user_level']);
		}
				
		//将有关数据存储到二维码表中
		$data = array();
		$data['code_title'] = $wx_title;
		$data['wx_id'] = $wx_id;
		$data['is_used'] = $is_used;
		$data['code_img'] = $qrcode_url;
		$data['uin'] = $uin;
		$data['user_id'] = $user_id;
		$data['user_level'] = $user_level;
		$data['user_name'] = $user_name;
		$this->wx_code_mod->add($data);
		$codeArr = array();
		$codeArr = $this->wx_code_mod->getAllInfo($wx_id);
		
		for($i=0; $i<count($codeArr); $i++){
			echo '<div class="info" id="codeBox_' . $codeArr[$i]['wx_id'] . '_' . $codeArr[$i]['code_id'] . '" >';
			echo '<input type="hidden" name="code_id" value="' . $codeArr[$i]['code_id'] . '" />';
			echo '<table class="infoTable">';
			echo '<tr>';
			echo '<th class="paddingT15" width="30%">';
			echo '<table class="infoTable">';
			echo '<tr>';
			echo '<td height="30px">推荐人编号：' . $codeArr[$i]['uin'] . '</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td height="30px">推荐人用户名：' . $codeArr[$i]['user_name'] . '</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td height="30px">标题：' . $codeArr[$i]['code_title'] . '</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td height="30px">扫描二维码：　　　　　　　<a href="' . $codeArr[$i]['code_img'] . '" target="_blank">预览</a></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td height="30px">';
			echo '<img src="' . $codeArr[$i]['code_img'] . '" width="300" height="300" />';
			echo '</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td height="30px">';
			echo '<!--关键词：<input id="weixin_keyword_{$wx_id}" style="width:80px;" type="text" name="weixin_keyword_{$wx_id}" class="infoTableInput"/> <input class="formbtn" type="button" id="btnKeyword" name="btnKeyword" value="提交" />-->';
			echo '</td>';
			echo '</tr>';
			echo '</table>';
			echo '</th>';
			echo '<td class="paddingT15 wordSpacing5" valign="top" width="40%">';
			echo '<table class="infoTable">';
			echo '<tr>';
			echo '<td height="30px">';
			echo '<!--<b>自动回复：</b><input id="weixin_reply_{$wx_id}" style="width:150px;" type="text" name="weixin_reply_{$wx_id}" class="infoTableInput"/>-->';
			echo '</td>';
			echo '</tr>';
			echo '</table>';
			echo '</td>';
			echo '<td class="paddingT15 wordSpacing5" valign="top" width="30%">';
			echo '<table class="infoTable">';
			echo '<tr>';
			echo '<td height="30px"><!--<b>标签：</b>--></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td height="30px"></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td height="30px"><!--<b>成为指定会员等级：</b>--></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td height="30px"></td>';
			echo '</tr>';
			echo '</table>';   
			echo '</td>';
			echo '</tr>';      
			echo '</table>';
			echo '</div>';
		}

		

	}
    //第一次加载时显示二维码列表
	function list_code(){
		//获取传递的值
		$wx_id = isset($_GET['wx_id'])? intval($_GET['wx_id']):0;
		$codeArr = array();
		$codeArr = $this->wx_code_mod->getAllInfo($wx_id);
		
		for($i=0; $i<count($codeArr); $i++){
			echo '<div class="info" id="codeBox_' . $codeArr[$i]['wx_id'] . '_' . $codeArr[$i]['code_id'] . '" >';
			echo '<input type="hidden" name="code_id" value="' . $codeArr[$i]['code_id'] . '" />';
			echo '<table class="infoTable">';
			echo '<tr>';
			echo '<th class="paddingT15" width="30%">';
			echo '<table class="infoTable">';
			echo '<tr>';
			echo '<td height="30px">推荐人编号：' . $codeArr[$i]['uin'] . '</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td height="30px">推荐人用户名：' . $codeArr[$i]['user_name'] . '</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td height="30px">标题：' . $codeArr[$i]['code_title'] . '</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td height="30px">扫描二维码：　　　　　　　<a href="' . $codeArr[$i]['code_img'] . '" target="_blank">预览</a></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td height="30px">';
			echo '<img src="' . $codeArr[$i]['code_img'] . '" width="300" height="300" />';
			echo '</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td height="30px">';
			echo '<!--关键词：<input id="weixin_keyword_{$wx_id}" style="width:80px;" type="text" name="weixin_keyword_{$wx_id}" class="infoTableInput"/> <input class="formbtn" type="button" id="btnKeyword" name="btnKeyword" value="提交" />-->';
			echo '</td>';
			echo '</tr>';
			echo '</table>';
			echo '</th>';
			echo '<td class="paddingT15 wordSpacing5" valign="top" width="40%">';
			echo '<table class="infoTable">';
			echo '<tr>';
			echo '<td height="30px">';
			echo '<!--<b>自动回复：</b><input id="weixin_reply_{$wx_id}" style="width:150px;" type="text" name="weixin_reply_{$wx_id}" class="infoTableInput"/>-->';
			echo '</td>';
			echo '</tr>';
			echo '</table>';
			echo '</td>';
			echo '<td class="paddingT15 wordSpacing5" valign="top" width="30%">';
			echo '<table class="infoTable">';
			echo '<tr>';
			echo '<td height="30px"><!--<b>标签：</b>--></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td height="30px"></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td height="30px"><!--<b>成为指定会员等级：</b>--></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td height="30px"></td>';
			echo '</tr>';
			echo '</table>';   
			echo '</td>';
			echo '</tr>';      
			echo '</table>';
			echo '</div>';
		}
	}
	//检测推荐人
	function check_uin(){
		//获取传递的值
		$wx_id = isset($_GET['wx_id'])? intval($_GET['wx_id']):0;
		$uin = isset($_GET['uin'])? intval($_GET['uin']):0;
		
		//检测uin是否存在
		$conditions = "uin=" . $uin;
		$uinarr = $this->member_mod->find(array('conditions' => $conditions));
		$conditions = "uin=" . $uin . " AND wx_id=" . $wx_id;
		$wuinarr = $this->wx_code_mod->find(array('conditions' => $conditions));
		if(count($uinarr) == 0 || count($wuinarr) > 0){
			echo 1;
		}
	}
	//检测标题
	function check_title(){
		//获取传递的值
		$wx_id = isset($_GET['wx_id'])? intval($_GET['wx_id']):0;
		$uin = isset($_GET['uin'])? intval($_GET['uin']):0;
		$wx_title = isset($_GET['title'])? trim($_GET['title']):'';
		//检测标题是否存在
		$conditions = "code_title='" . $wx_title . "' AND wx_id=" . $wx_id;
		$wuinarr = $this->wx_code_mod->find(array('conditions' => $conditions));
		if(count($wuinarr) > 0){
			echo 1;
		}
	}
	//检测开发者appid
	function check_appid(){
		//获取传递的值
		$wx_id = isset($_GET['wx_id'])? intval($_GET['wx_id']):0;
		//检测标题是否存在
		$wuinarr = $this->weixin_config_mod->find($wx_id);
		foreach($wuinarr as $arr){
			$token = $arr['token'];
			$appid = $arr['appid'];
			$appsecret = $arr['appsecret'];
			if(empty($appid) || empty($appsecret)){
				echo 1;
			}
			//获取access_token
			$access_token =$this->get_access_token($appid, $appsecret);
			if(!isset($access_token) || empty($access_token) || $access_token == false){
				echo 1;
			}
		}
	}

}

?>