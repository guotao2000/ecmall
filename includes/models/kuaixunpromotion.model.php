<?php

/*快讯促销*/
class KuaixunpromotionModel extends BaseModel
{
    var $table  = 'kuaixun_promotion';
    var $prikey = 'kuaixun_id';
    
    //检查快讯标题唯一性
    function unique($kuaixun_name = '') {
        return $this->getOne("select kuaixun_id from {$this->table} where kuaixun_name='$kuaixun_name'");
    }
    
}

?>