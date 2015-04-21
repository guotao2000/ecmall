<?php

/* 微公众平台接口管理控制器 */

class Weixin_configApp extends BackendApp {

    var $weixin_config_mod;

    function __construct() {
        $this->Weixin_config();
    }

    function Weixin_config() {
        parent::BackendApp();
        $_POST = stripslashes_deep($_POST);
        $this->weixin_config_mod = & m('wxpubconfig');
    }

    function index() {
          if (!IS_POST) {
            //随机生成6位Token码
			$weixin_token = $this->makecode(6);
            //组合url
			$weixin_url = SITE_URL . '/admin/app/weixinwish.php?id=' . $weixin_token;
			$this->assign('weixin_token', $weixin_token);
            $this->assign('weixin_url', $weixin_url);
            $this->display('weixin_config.index.html');
          } else {
            $url = trim($_POST['weixin_url']);
            $token = trim($_POST['weixin_token']);
            $appid = trim($_POST['weixin_appid']);
            $appsecret = trim($_POST['weixin_appsecret']);
            $account = trim($_POST['weixin_account']);
            $data = array(
                'url' => $url,
                'token' => $token,
                'appid' => $appid,
                'appsecret' => $appsecret,
                'account' => $account
            );
            $wx_id = $this->weixin_config_mod->unique($account);
            if ($wx_id) {
                $this->show_message('该微信公众账号已存在，请重新填写！');
            } else {
                $this->weixin_config_mod->add($data);
                if ($this->weixin_config_mod->has_error()) {
                    $this->show_warning($this->weixin_config_mod->get_error());
                    return;
                }
                $this->show_message('微信公众账号添加成功！');
            }
        }
    }
	//随机生成6位小写字母
	function makecode($num=4) {
        $re = '';
        $s = 'abcdefghijklmnopqrstuvwxyz';
        while(strlen($re)<$num) {
            $re .= $s[rand(0, strlen($s)-1)]; //从$s中随机产生一个字符
        }
        return $re;
    }
    
    //获得微信公众号列表
    function wx_list(){
        $conditions = $this->_get_query_conditions(array(
            array(
                'field' => 'account',         //可搜索字段title
                'equal' => 'LIKE',          //等价关系,可以是LIKE, =, <, >, <>
                'assoc' => '',           //关系类型,可以是AND, OR
                'name'  => 'title',         //GET的值的访问键名
                'type'  => 'string',        //GET的值的类型
            ),
        ));
        $page   =   $this->_get_page(10);   //获取分页信息
        $weixins=$this->weixin_config_mod->find(array(
            'fields'   => '*',
            'conditions'  => $conditions,
            'limit'   => $page['limit'],
            'order'   => 'wx_pub_config.wx_id DESC', //必须加别名
            'count'   => true   //允许统计
        ));    //显示出所有微信账号
        $page['item_count']=$this->weixin_config_mod->getCount();   //获取统计数据
        $this->_format_page($page);
        $this->import_resource(array('script' => 'inline_edit.js'));
        $this->assign('filtered', $conditions? 1 : 0); //是否有查询条件
        $this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条
        $this->assign('weixins', $weixins);
        
        $this->display('weixin_config.wx_list.html');
    }
    //编辑公众号信息
    function edit(){
        $wx_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (!$wx_id)
        {
            $this->show_warning('没有该微信公众账号!');
            return;
        }
        if (!IS_POST)
        {
            $find_data = $this->weixin_config_mod->find($wx_id);
            if (empty($find_data))
            {
                $this->show_warning('没有该微信公众账号!');
            
                return;
            }
            $weixin    =   current($find_data);
            $this->assign("wx_id", $wx_id);
            $this->import_resource(array('script' => 'jquery.plugins/jquery.validate.js'));
            $this->assign('weixin', $weixin);
            $this->display('weixin_config.edit.html');
        } else {
            $data = array();
            $wx_id = isset($_POST['wx_id']) ? intval($_POST['wx_id']) : 0;
            $data['account'] = trim($_POST['weixin_account']);
            $data['url'] = trim($_POST['weixin_url']);
            $data['token'] = trim($_POST['weixin_token']);
            $data['appid'] = trim($_POST['weixin_appid']);
            $data['appsecret'] = trim($_POST['weixin_appsecret']);
            
            $rows=$this->weixin_config_mod->edit($wx_id, $data);
            if ($this->weixin_config_mod->has_error())
            {
                $this->show_warning($this->weixin_config_mod->get_error());
            
                return;
            }
            
            $this->show_message('公众号修改成功！',
                'back_list',        'index.php?app=weixin_config&amp;act=wx_list',
                '继续修改，返回',    'index.php?app=weixin_config&amp;act=edit&amp;id=' . $wx_id);
        }
    }
    
    //删除公众账号
    function drop(){
        $wx_ids = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$wx_ids)
        {
            $this->show_warning('该公众账号不存在！');
            return;
        }
        $wx_ids=explode(',', $wx_ids);
        if (!$this->weixin_config_mod->drop($wx_ids))    //删除
        {
            $this->show_warning($this->weixin_config_mod->get_error());
        
            return;
        }
        
        $this->show_message('公众号删除成功！');
    }
    
    /**
     *    三级菜单
     *
     *    @author    Hyber
     *    @return    void
     */
    /*function _get_member_submenu() {
        $submenus = array(
            array(
                'name' => 'my_wxconfig',
                'url' => 'index.php?app=my_wxconfig',
            ),
        );
        return $submenus;
    }*/

}

?>