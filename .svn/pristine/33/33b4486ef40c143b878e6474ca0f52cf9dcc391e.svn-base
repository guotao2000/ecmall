<?php

/**
 *    文章管理控制器
 *
 *    @author    Hyber
 *    @usage    none
 */
class FileApp extends BackendApp
{
    var $_file_mod;
    var $_uploadedfile_mod;
	

    function __construct()
    {
		$this->FileApp();
    }

	function FileApp()
    {
        parent::BackendApp();

		$this->_file_mod =& m('file');
        $this->_uploadedfile_mod = &m('uploadedfile');
    }

    /**
     *    文章索引
     *
     *    @author    Hyber
     *    @return    void
     */
    function index()
	{
		$db=&db();
		
		$condition = '';
		if(!empty($_GET['filename'])){
			$_GET['filename'] = trim($_GET['filename']);
			$condition .= " and filename like '%" . $_GET['filename'] ."%' ";
		}

		$page   =   $this->_get_page(10);   //获取分页信息
		//找出所有的文章
		$page['item_count']=$db->getOne('select count(id) from ecm_upload');   //获取统计数据
		//dump($page['item_count']);
		$this->_format_page($page);
		$result = $db->getAll("select * from ecm_upload where 1=1 " . $condition . " limit {$page['limit']}");
		$this->assign('uploads',$result);
		$this->assign('page_info',$page);   //将分页信息传递给视图，用于形成分页条
		$this->display('file.index.html');
    }
     /**
     *    新增文章
     *
     *    @author    Hyber
     *    @return    void
     */
    function add()
    {
		//echo ROOT_PATH;
		if(!IS_POST){
			
			$this->display('file.form.html');	
		}else{
			
				$upload_path = '/upload/';
				if(!file_exists($upload_path))
					mkdir($upload_path);
				foreach($_FILES['file']['name'] as $key=>$value){
					$name=$value;
					$pos = strrpos($name,'.');
					$ext = substr($name,$pos+1);
					$filename = $key.gmtime().'.'.$ext;
					$time=gmtime();
				//dump($_FILES["file"]["tmp_name"][$key]);
				move_uploaded_file($_FILES["file"]["tmp_name"][$key],ROOT_PATH."/upload/".$filename);	
					$data['uploadPath'] = $upload_path;
					$data['filename'] = $upload_path.$filename;
					if(!strlen($ext))
					{
						$this->show_warning("文件不存在！");
						return;
					}
				
					$data['time'] = $time;
					if (!$file_id = $this->_file_mod->add($data))  //获取file_id
					{
						$this->show_warning($this->_file_mod->get_error());

						return;
					}
				}
				
				
				$this->show_message('上传文件成功！',
					'back_list',    'index.php?app=file',
					'continue_add', 'index.php?app=file&amp;act=add'
					);
		}
			
        
    }
     /**
     *    编辑文章
     *
     *    @author    Hyber
     *    @return    void
     */
    function edit()
    {
		$file_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
		
		if (!$file_id)
        {
			$this->show_warning('没有这个文件');
            return;
        }

         if (!IS_POST)
        {
			$find_data     = $this->_file_mod->find($file_id);
            if (empty($find_data))
            {
                $this->show_warning('no_such_article');

                return;
            }
			
			$file    =   current($find_data);
			//dump($file);
			$file['filename'] = basename($file['filename']);
			$this->assign('file', $file);
            
			$this->display('file.form.html');
        }
        else
        {
			//dump($_POST);
            $data = array();
			$upload_path = '/upload/';
            $data['filename'] =  $upload_path.$_POST['filename'];
            if (!empty($_POST['id']))
            {
                $data['id']        =   $_POST['id'];
            }


			$rows=$this->_file_mod->edit($file_id, $data);
			if ($this->_file_mod->has_error())
            {
				$this->show_warning($this->_file_mod->get_error());

                return;
            }
			$oldname=ROOT_PATH.$upload_path.$_POST['oldname'];
			$newname=ROOT_PATH.$data['filename'];
			//dump($oldname);
			rename($oldname,$newname);

			$this->show_message('文件修改成功！',
				'back_list',        'index.php?app=file',
				'再次修改',    'index.php?app=file&amp;act=edit&amp;id=' . $file_id);
        }
    }

   
    function drop()
    {
		//dump($_REQUEST);
		$file_ids = isset($_GET['id']) ? trim($_GET['id']) : '';
		//dump($file_ids);
		if (!$file_ids)
        {
            $this->show_warning('no_such_article');

            return;
        }
		$file_ids=explode(',', $file_ids);
		foreach ($file_ids as $key=>$value){
			$upload =& m('file'); 
			$db=&db();
			$result = $db->getRow("select * from ecm_upload where id=$value");
			if($result){
				$path=ROOT_PATH.$result['filename'];
              if(file_exists($path))				
			  {unlink($path);}
			}
			if (!$upload->drop("$value"))    //删除
			{
				$this->show_warning($this->_file_mod->get_error());
				return ;
			}
		}
		
		
		$this->show_message('删除文件成功！');
    }

   

}

?>