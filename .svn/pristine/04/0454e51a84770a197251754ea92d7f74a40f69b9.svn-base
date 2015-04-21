<?php

class CouponModel extends BaseModel
{
    var $table  = 'coupon';
    var $prikey = 'coupon_id';
    var $_name  = 'coupon';
    var $_relation  = array(
        // 一种红包有多个红包编号
        'has_couponsn' => array(
            'model'         => 'couponsn',
            'type'          => HAS_MANY,
            'foreign_key'   => 'coupon_id',
            'dependent'     => true,
			'refer_key'     =>'coupon_id',
        ),
        // 一种红包只能属于一个店铺
        'belong_to_store' => array(
            'model'         => 'store',
            'type'          => BELONGS_TO,
            'foreign_key'   => 'store_id',
            'reverse'       => 'has_coupon',    
        ),
		  
        
    );
}

?>
