<?php

return array(
    'dashboard' => array(
        'text'      => Lang::get('dashboard'),
        'subtext'   => Lang::get('offen_used'),
        'default'   => 'welcome',
        'children'  => array(
            'welcome'   => array(
                'text'  => Lang::get('welcome_page'),
                'url'   => 'index.php?act=welcome',
            ),
            'aboutus'   => array(
                'text'  => Lang::get('aboutus_page'),
                'url'   => 'index.php?act=aboutus',
            ),
            'base_setting'  => array(
                'parent'=> 'setting',
                'text'  => Lang::get('base_setting'),
                'url'   => 'index.php?app=setting&act=base_setting',
            ),
            'user_manage' => array(
                'text'  => Lang::get('user_manage'),
                'parent'=> 'user',
                'url'   => 'index.php?app=user',
            ),
            'store_manage'  => array(
                'text'  => Lang::get('store_manage'),
                'parent'=> 'store',
                'url'   => 'index.php?app=store',
            ),
            'goods_manage'  => array(
                'text'  => Lang::get('goods_manage'),
                'parent'=> 'goods',
                'url'   => 'index.php?app=goods',
            ),
            'order_manage' => array(
                'text'  => Lang::get('order_manage'),
                'parent'=> 'trade',
                'url'   => 'index.php?app=order'
            ),
			
        ),
    ),
    // 设置
    'setting'   => array(
        'text'      => Lang::get('setting'),
        'default'   => 'base_setting',
        'children'  => array(
            'base_setting'  => array(
                'text'  => Lang::get('base_setting'),
                'url'   => 'index.php?app=setting&act=base_setting',
            ),
            'region' => array(
                'text'  => Lang::get('region'),
                'url'   => 'index.php?app=region',
            ),
            'payment' => array(
                'text'  => Lang::get('payment'),
                'url'   => 'index.php?app=payment',
            ),
            'theme' => array(
                'text'  => Lang::get('theme'),
                'url'   => 'index.php?app=theme',
            ),
            'waptheme' => array(
                'text'  => Lang::get('waptheme'),
                'url'   => 'index.php?app=waptheme',
            ),
            'template' => array(
                'text'  => Lang::get('template'),
                'url'   => 'index.php?app=template',
            ),
            'mailtemplate' => array(
                'text'  => Lang::get('noticetemplate'),
                'url'   => 'index.php?app=mailtemplate',
            ),
            //增加微信公众平台管理菜单 by Summer 2014-12-08 14:53 begin
            'weixinmanage' => array(
                'text'  => Lang::get('wxpubnummanage'),
                'url'   => 'index.php?app=weixin_config',
            ),
            //end
        ),
    ),
    // 商品
    'goods' => array(
        'text'      => Lang::get('goods'),
        'default'   => 'goods_manage',
        'children'  => array(
            'gcategory' => array(
                'text'  => Lang::get('gcategory'),
                'url'   => 'index.php?app=gcategory',
            ),
            'brand' => array(
                'text'  => Lang::get('brand'),
                'url'   => 'index.php?app=brand',
            ),
            'goods_manage' => array(
                'text'  => Lang::get('goods_manage'),
                'url'   => 'index.php?app=goods',
            ),
			'price_manage' => array(
			'text'  => '价格管理',
			 'url'   => 'index.php?app=price',
			),
			'tags_manage' => array(
				'text'  => '标签管理',
				'url'   => 'index.php?app=tags',
				),
            'show_manage' => array(
            'text'  =>'名存架管理',
            'url'   => 'index.php?app=show',
              ),
			'wxgoods_manage' => array(
				'text'  => '微信描述',
				'url'   => 'index.php?app=wxgoods',
				),

			// tyioocom 
			'props_manage' => array(
			   'text' => Lang::get('props_manage'),
			   'url'  => 'index.php?app=props',
			),
			// end			
            'recommend_type' => array(
                'text'  => LANG::get('recommend_type'),
                'url'   => 'index.php?app=recommend'
            ),
			'couponadmin' => array(
                'text'  => '红包管理',
                'url'   => 'index.php?app=couponadmin'
            ),

        ),
    ),
    // 店铺
    'store'     => array(
        'text'      => Lang::get('store'),
        'default'   => 'store_manage',
        'children'  => array(
            'sgrade' => array(
                'text'  => Lang::get('sgrade'),
                'url'   => 'index.php?app=sgrade',
            ),
            'scategory' => array(
                'text'  => Lang::get('scategory'),
                'url'   => 'index.php?app=scategory',
            ),
			//by cengnlaeng
			'ultimate_store'     =>array(
				'text'  => Lang::get('ultimate_store'),
                'url'   => 'index.php?app=ultimate_store',
			),
			//end
            'store_manage'  => array(
                'text'  => Lang::get('store_manage'),
                'url'   => 'index.php?app=store',
            ),
			 'storeads_manage'  => array(
                'text'  => '店铺广告位管理',
                'url'   => 'index.php?app=storeads',
            ),
        ),
    ),
    // 会员
    'user' => array(
        'text'      => Lang::get('user'),
        'default'   => 'user_manage',
        'children'  => array(
            'user_manage' => array(
                'text'  => Lang::get('user_manage'),
                'url'   => 'index.php?app=user',
            ),
            'admin_manage' => array(
                'text' => Lang::get('admin_manage'),
                 'url'   => 'index.php?app=admin',
             ),
             'user_notice' => array(
                'text' => Lang::get('user_notice'),
                'url'  => 'index.php?app=notice',
             ),
			  'muin' => array(
                'text' => '推荐号修改',
                'url'  => 'index.php?app=muin',
             ),
        ),
    ),
    // 交易
    'trade' => array(
        'text'      => Lang::get('trade'),
        'default'   => 'order_manage',
        'children'  => array(
            'order_manage' => array(
                'text'  => Lang::get('order_manage'),
                'url'   => 'index.php?app=order'
            ),
        ),
    ),
    // 网站
    'website' => array(
        'text'      => Lang::get('website'),
        'default'   => 'acategory',
        'children'  => array(
            'acategory' => array(
                'text'  => Lang::get('acategory'),
                'url'   => 'index.php?app=acategory',
            ),
		    'conf' => array(
                'text'  => '配置文件',
                'url'   => 'index.php?app=conf',
            ),
			'zhuanti' => array(
				'text'  => '专题管理',
				'url'   => 'index.php?app=zhuanti',
			),
			'area' => array(
					'text'  => '区块管理',
					'url'   => 'index.php?app=area',
					),
			'fileuploads' => array(
				'text'  => '文件管理',
				'url'   => 'index.php?app=file',
			),
            'article' => array(
                'text'  => Lang::get('article'),
                'url'   => 'index.php?app=article',
            ),
            'partner' => array(
                'text'  => Lang::get('partner'),
                'url'   => 'index.php?app=partner',
            ),
            'navigation' => array(
                'text'  => Lang::get('navigation'),
                'url'   => 'index.php?app=navigation',
            ),
            'db' => array(
                'text'  => Lang::get('db'),
                'url'   => 'index.php?app=db&amp;act=backup',
            ),
            'groupbuy' => array(
                'text' => Lang::get('groupbuy'),
                'url'  => 'index.php?app=groupbuy',
            ),
            'consulting' => array(
                'text'  =>  LANG::get('consulting'),
                'url'   => 'index.php?app=consulting',
            ),
            'share_link' => array(
                'text'  =>  LANG::get('share_link'),
                'url'   => 'index.php?app=share',
            ),
            'promotion_manage' => array(
                'text'  =>  '档期管理',
                'url'   => 'index.php?app=promote',
            ),
            'zhekou_promotion' => array(
                'text'  =>  '折扣促销',
                'url'   => 'index.php?app=discount',
            ),
			'mjmz_promotion' => array(
				'text'  =>  '满减满赠',
				'url'   => 'index.php?app=gift',
			),
            'zhekou_promotion' => array(
                'text'  =>  '促销活动',
                'url'   => 'index.php?app=_ms_promotion',
            ),
        ),
    ),
    // 扩展
    'extend' => array(
        'text'      => Lang::get('extend'),
        'default'   => 'plugin',
        'children'  => array(
            'plugin' => array(
                'text'  => Lang::get('plugin'),
                'url'   => 'index.php?app=plugin',
            ),
            'module' => array(
                'text'  => Lang::get('module'),
                'url'   => 'index.php?app=module&act=manage',
            ),
            'widget' => array(
                'text'  => Lang::get('widget'),
                'url'   => 'index.php?app=widget',
            ),
        ),
    ),
);

?>
