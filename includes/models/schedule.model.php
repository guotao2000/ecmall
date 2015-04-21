<?php

/*促销档期 schedule*/
class ScheduleModel extends BaseModel
{
    var $table  = 'schedule';
    var $prikey = 'schedule_id';
    
    //检查档期标题唯一性
    function unique($schedule_name = '') {
        return $this->getOne("select schedule_id from {$this->table} where schedule_name='$schedule_name'");
    }
    
}

?>