<?php

return array(
    'code'      => 'unionpay',
    'name'      => Lang::get('unionpay'),
    'desc'      => Lang::get('unionpay_desc'),
    'is_online' => '1',
    'author'    => 'yonguo',
    'website'   => 'https://online.unionpay.com/',
    'version'   => '1.0',
    'currency'  => Lang::get('unionpay_currency'),
    'config'    => array(
        'unionpay_account'   => array(        //账号
            'text'  => Lang::get('unionpay_account'),
            'desc'  => Lang::get('unionpay_account_desc'),
            'type'  => 'text',
        ),
        'unionpay_key'       => array(        //密钥
            'text'  => Lang::get('unionpay_key'),
            'desc'  => Lang::get('unionpay_key_desc'),
            'type'  => 'text',
        )
    ),
);

?>