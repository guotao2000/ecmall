<?php

/**
 *    我的推荐号
 *
 *    @author  Summer  
 *    @usage    none
 */
class My_tuijianApp extends MemberbaseApp
{
    function index()
    {
		$user_id = $this->visitor->get('user_id');
		$db = &db();
		$sql = "select * from ecm_member where user_id=" . $user_id;
		$result = $db->getAll($sql);
		foreach($result as $v){
			$res = $v;	
		}
		$this->assign('user', $res);
		
		//根据用户的uin和user_id获取该用户的推荐二维码
		$sql = "select code_img from ecm_wx_code where user_id=" . $res['user_id'] . " and is_used=1 and uin=" . $res['uin'];
		$code_img = $db->getOne($sql);
		$this->assign('code_img', $code_img);
		
		$rgoods=array_chunk($this->_get_recommended_goods(6),2,true);
		$this->assign('rgoods',$rgoods);
		
        $this->display('user_tuijian.html');
    }
	
	/* 取得推荐商品 */
    function _get_recommended_goods( $num = 4)
    {
        $goods_mod =& m('goods');

		$goods_list = $goods_mod->get_list(array(
            	'conditions' => 'if_show=1 AND closed=0 AND g.recommended = 1 ' ,
            	'fields'	 =>'s.praise_rate,s.im_qq,s.im_ww,',
            	'limit'      => $num,
        	));
		
        foreach ($goods_list as $key => $goods)
        {
            empty($goods['default_image']) && $goods_list[$key]['default_image'] = Conf::get('default_goods_image');
        }

        return $goods_list;
    }

}

?>