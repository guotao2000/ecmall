<?php
include 'jssdk.php';
class ShareApp extends MallbaseApp
{

    function __construct()
    {
        $this->ShareApp();
    }
    function ShareApp()
    {
        parent::__construct();
    }
    function index()
    {
		$jssdk = new JSSDK("wx64794ef985549154", "5dcdf5cdbc6e9e1ff23c39836df9e236");
		$signPackage = $jssdk->GetSignPackage();
		$this->assign('signPackage', $signPackage);

		//从配置文件读取出相应的图文消息
		$mod_conf = &m('conf');
		$wxtw_id = $mod_conf->db->getOne("select conf_value from ecm_conf where conf_code='duotuwen'");

		$mod_wxtw = &m('wxtuwen');
		$result = $mod_wxtw->db->getRow("select * from ecm_wxtuwen where wxtw_id=" . $wxtw_id);
		
		$this->assign('result', $result);
        $this->display('wx_share.html');
    }

	
    
}

?>
