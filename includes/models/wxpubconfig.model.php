<?php

/* 微公众平台商家接口 Wxpubconfig */

class WxpubconfigModel extends BaseModel {

    var $table = 'wx_pub_config';
    var $prikey = 'wx_id';
    
    //检查公众账号的唯一性
    function unique($account='') {
        return $this->getOne("select wx_id from {$this->table} where account='$account'");
    }

}

?>