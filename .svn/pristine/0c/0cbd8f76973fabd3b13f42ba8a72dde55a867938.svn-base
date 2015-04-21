<?php

/* 微公众平台接口管理控制器 */

class Weixin_messageApp extends BackendApp {

    var $weixin_config_mod;
	var $wxtuwen_mod;
	var $_uploadedfile_mod;

    function __construct() {
        $this->Weixin_message();
    }

    function Weixin_message() {
        parent::BackendApp();
        $_POST = stripslashes_deep($_POST);
        $this->weixin_config_mod = & m('wxpubconfig');
		$this->wxtuwen_mod = & m('wxtuwen');
		$this->_uploadedfile_mod = &m('uploadedfile');
    }

    function index() {
		if (!IS_POST){
			
			$wx_id = isset($_GET['wx_id'])? intval($_GET['wx_id']):0;
			$wx_id = trim($wx_id);
			$wxtw = array('is_subscribe' => 0, 'tw_type' => 0, 'is_pub' => 1);
			
            $files_belong_wxtw = $this->_uploadedfile_mod->find(array(
                'conditions' => 'store_id = 0 AND belong = ' . BELONG_WXTW . ' AND item_id = 0',
                'fields' => 'this.file_id, this.file_name, this.file_path',
                'order' => 'add_time DESC'
            ));
			
            $this->assign("id", 0);
            $this->assign('belong', BELONG_WXTW);
			
            $this->import_resource(array('script' => 'jquery.plugins/jquery.validate.js,change_upload.js'));
            $this->assign('wxtw', $wxtw);
            $this->assign('files_belong_wxtw', $files_belong_wxtw);
            
            $template_name = $this->_get_template_name();
            $style_name    = $this->_get_style_name();
			
            $this->assign('build_editor', $this->_build_editor(array(
                'name' => 'content',
                'content_css' => SITE_URL . "/themes/mall/{$template_name}/styles/{$style_name}/css/ecmall.css"
            )));
			
			$this->assign('build_upload', $this->_build_upload(array('belong' => BELONG_WXTW, 'item_id' => 0))); // 构建swfupload上传组件
			
			$this->assign('wx_id', $wx_id);
			$this->display('weixin_message.index.html');
		} else {
			$wx_id = intval($_POST['wx_id']);
			if(is_uploaded_file($_FILES["picurl"]["tmp_name"])){
				$upfile=$_FILES["picurl"];
				$name=trim($upfile["name"]);
				$name=gmtime() . strstr($name, '.');
				$type=$upfile["type"];
				$size=$upfile["size"];
				$tmp_name=$upfile["tmp_name"];
				$error=$upfile["error"];

				switch($type){
					case "image/jpg": $ok = 1;
					break;
					case "image/jpeg": $ok = 1;
					break;
					case "image/png": $ok = 1;
					break;
					case "image/gif" : $ok = 1;
					break;
					default:$ok = 0;
					break;
				}

				if($ok == 0){
					$this->show_warning('上传文件类型不正确！');
					return;
				}

				if($size > 2000000){
					$this->show_warning('上传文件大小不能超过2M！');
					return;
				}
				
				if($ok == 1 && $error == 0){
					$flag = move_uploaded_file($tmp_name, $_SERVER['DOCUMENT_ROOT'] . "/data/wxfile/" . $name);
					if($flag){
						$picurl = SITE_URL . "/data/wxfile/" . $name;
					}else{
						$this->show_warning('封面图片上传失败！');
						return;						
					}
				}

			}
			$picurl = empty($picurl)? '':trim($picurl);
			$data = array(
				'wx_id' => $wx_id,	
				'title' => trim($_POST['title']),
				'allow_uin' => trim($_POST['allow_uin']),
				'description' => trim($_POST['description']),
				'content' => trim($_POST['content']),
				'picurl' => $picurl,
				'url' => trim($_POST['diy_url']),
				'is_pub' => intval($_POST['is_pub']),
				//'tw_type' => intval($_POST['tw_type']),
				//'is_default' => intval($_POST['is_default']),
				'keywords' => trim($_POST['keywords']),
				'is_subscribe' => intval($_POST['is_subscribe']),
				'add_time' => gmtime()
			);
			
			//检测标题的唯一性
			$title_arr = $this->wxtuwen_mod->find(array(
                'conditions' => "title='" . $data['title'] . "' and wx_id=" . $data['wx_id'],
                'fields' => '*'
            ));

			if(count($title_arr) > 0){
				$this->show_warning('同一公众号内，图文标题不能重复！');
                return;
			}

			 if (!$wxtw_id = $this->wxtuwen_mod->add($data))  
            {
                $this->show_warning($this->wxtuwen_mod->get_error());
                return;
            }

            if (isset($_POST['file_id']))
            {
                foreach ($_POST['file_id'] as $file_id)
                {
                    $this->_uploadedfile_mod->edit($file_id, array('item_id' => $wxtw_id));
                }
            }

            $this->show_message('操作成功！',
                'back_list',    'index.php?app=weixin_message&act=wxtw_list&wx_id=' . $wx_id,
                'continue_add', ''
            );
			


		}
		
    }

	function edit(){
		
		$wxtw_id = isset($_GET['wxtw_id']) ? intval($_GET['wxtw_id']) : 0;
		$wx_id = isset($_GET['wx_id']) ? intval($_GET['wx_id']) : 0;
        if (!$wxtw_id)
        {
            $this->show_warning('没有该图文消息！');
            return;
        }
		
		if(!IS_POST){
			$files_belong_wxtw = $this->_uploadedfile_mod->find(array(
                'conditions' => 'store_id = 0 AND belong = ' . BELONG_WXTW . ' AND item_id=' . $wxtw_id,
                'fields' => 'this.file_id, this.file_name, this.file_path',
                'order' => 'add_time DESC'
            ));
			
			$find_data     = $this->wxtuwen_mod->find($wxtw_id);
            if (empty($find_data))
            {
                $this->show_warning('没有该图文消息！');

                return;
            }
            $wxtw    =   current($find_data);
            
            $this->assign("id", $wxtw_id);
            $this->assign("belong", BELONG_WXTW);
            $this->import_resource(array('script' => 'jquery.plugins/jquery.validate.js,change_upload.js'));
            
            $this->assign('files_belong_wxtw', $files_belong_wxtw);
            $this->assign('wxtw', $wxtw);
            
            $template_name = $this->_get_template_name();
            $style_name    = $this->_get_style_name();
            $this->assign('build_editor', $this->_build_editor(array(
                'name' => 'content',
                'content_css' => SITE_URL . "/themes/mall/{$template_name}/styles/{$style_name}/css/ecmall.css"
            )));
            
			$this->assign('wx_id', $wx_id);
            $this->assign('build_upload', $this->_build_upload(array('belong' => BELONG_WXTW, 'item_id' => $wxtw_id))); 
            $this->display('weixin_message.index.html');

		} else {
			if(is_uploaded_file($_FILES["picurl"]["tmp_name"])){
				$upfile=$_FILES["picurl"];
				$name=trim($upfile["name"]);
				$name=gmtime() . strstr($name, '.');
				$type=$upfile["type"];
				$size=$upfile["size"];
				$tmp_name=$upfile["tmp_name"];
				$error=$upfile["error"];

				switch($type){
					case "image/jpg": $ok = 1;
					break;
					case "image/jpeg": $ok = 1;
					break;
					case "image/png": $ok = 1;
					break;
					case "image/gif" : $ok = 1;
					break;
					default:$ok = 0;
					break;
				}

				if($ok == 0){
					$this->show_warning('上传文件类型不正确！');
					return;
				}

				if($size > 2000000){
					$this->show_warning('上传文件大小不能超过2M！');
					return;
				}
				
				if($ok == 1 && $error == 0){
					$flag = move_uploaded_file($tmp_name, $_SERVER['DOCUMENT_ROOT'] . "/data/wxfile/" . $name);
					if($flag){
						$picurl = SITE_URL . "/data/wxfile/" . $name;
					}else{
						$this->show_warning('封面图片上传失败！');
						return;						
					}
				}

			}
			$picurl = empty($picurl)? $_POST['picurl_hide']:trim($picurl);
			$data = array(
				'wx_id' => $wx_id,	
				'title' => trim($_POST['title']),
				'allow_uin' => trim($_POST['allow_uin']),
				'description' => trim($_POST['description']),
				'content' => trim($_POST['content']),
				'picurl' => $picurl,
				'url' => trim($_POST['diy_url']),
				'is_pub' => intval($_POST['is_pub']),
				//'tw_type' => intval($_POST['tw_type']),
				//'is_default' => intval($_POST['is_default']),
				'keywords' => trim($_POST['keywords']),
				'is_subscribe' => intval($_POST['is_subscribe']),
				'update_time' => gmtime()
			);

			$this->wxtuwen_mod->edit($wxtw_id, $data);
            if ($this->wxtuwen_mod->has_error())
            {
                $this->show_warning($this->wxtuwen_mod->get_error());
                return;
            }
            
            $this->show_message('操作成功！',
                'back_list',    'index.php?app=weixin_message&act=wxtw_list&wx_id=' . $wx_id,
                'continue_add', ''
            );



		}
	}

	function drop()
    {
        $wxtw_ids = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$wxtw_ids)
        {
            $this->show_warning('没有该图文消息！');
            return;
        }
        $wxtw_ids=explode(',', $wxtw_ids);
        if (!$this->wxtuwen_mod->drop($wxtw_ids))    //删除
        {
            $this->show_warning($this->wxtuwen_mod->get_error());
            return;
        }
        $this->show_message('删除成功！');
    }

	function wxtw_list(){
		$wx_id = isset($_GET['wx_id'])? intval($_GET['wx_id']):0;
		$title = isset($_GET['title'])? trim($_GET['title']):'';
		if(empty($title)){
			$conditions = "wx_id=" . $wx_id;
		} else {
			$conditions = "title like '%" . $title . "%' and wx_id=" . $wx_id;
		}
        $page   =   $this->_get_page(10);   //获取分页信息
        $wxtws=$this->wxtuwen_mod->find(array(
            'fields'   => '*',
            'conditions'  => $conditions,
            'limit'   => $page['limit'],
            'order'   => 'wxtuwen.add_time DESC', //必须加别名
            'count'   => true   //允许统计
        ));    //显示出所有微信账号
        $page['item_count']=$this->wxtuwen_mod->getCount();   //获取统计数据
        $this->_format_page($page);
        $this->import_resource(array('script' => 'inline_edit.js'));
        $this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条
        $this->assign('wxtws', $wxtws);
        $this->display('weixin_message.list.html');
	}

	function view(){
		$wx_id = isset($_GET['wx_id'])? intval($_GET['wx_id']):0;
		$wxtw_id = isset($_GET['wxtw_id'])? intval($_GET['wxtw_id']):0;

		$wxtws_arr = $this->wxtuwen_mod->find(array(
                'conditions' => "wx_id=" . $wx_id . " and wxtw_id=" . $wxtw_id,
                'fields' => '*'
            ));
		foreach($wxtws_arr as $val){
			$wxtws = $val;
		}
		$this->assign('wxtws', $wxtws);
		$this->display('weixin_message.view.html');
	}

	/* 异步删除附件 */
    function drop_uploadedfile()
    {
        $file_id = isset($_GET['file_id']) ? intval($_GET['file_id']) : 0;
        if ($file_id && $this->_uploadedfile_mod->drop($file_id))
        {
            $this->json_result('drop_ok');
            return;
        }
        else
        {
            $this->json_error('drop_error');
            return;
        }
    }

}

?>