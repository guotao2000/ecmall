<?php

/* 微公众平台商家接口 Wxcode */

class WxcodeModel extends BaseModel {

    var $table = 'wx_code';
    var $prikey = 'code_id';
    
    //取得二维码列表
    function getAllInfo($wx_id) {
        return $this->getAll("select * from {$this->table} where wx_id=" . $wx_id . " order by code_id desc");
    }
	

}

?>