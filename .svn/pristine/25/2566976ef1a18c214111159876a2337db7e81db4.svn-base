<?php

/**
 *    银联在线支付方式插件
 *
 *    @author   fang yong
 *    @usage    none
 *    @QQ       313536145
 */
 
 
 /*
 开发联调环境
前台支付：http://58.246.226.99/UpopWeb/api/Pay.action 
后台交易：http://58.246.226.99/UpopWeb/api/BSPay.action  
查询请求：http://58.246.226.99/UpopWeb/api/Query.action 
商户代码 100000000610100
商户简称 填写网站名称
商户密钥 88888888       
信用卡卡号：6212341111111111111，年份：12，月份：12，CVN2：123，
短信验证码短信验证码测试环境不校验，可随便输6位数字。

以这个信息配置，测试

6212341111111111111
 
 */

class UnionpayPayment extends BasePayment
{
    var $_gateway   = 'https://unionpaysecure.com/api/Pay.action'; //生产网关
    var $_code      =   'unionpay';
   
    function get_payform($order_info)
    {

        $params = array(
            /* 基本信息 */
            'merId'             => $this->_config['unionpay_account'],//收款账号
            'orderNumber'             => $order_info['order_sn'],//订单号
			'charset'                 =>"UTF-8",
			'version'                 =>'1.0.0',
			'orderTime'               =>date('YmdHis'),	   // 交易时间
			'customerIp'              =>real_ip(),
			'backEndUrl'         => $this->_create_notify_url($order_info['order_id']),
			'frontEndUrl'         =>$this->_create_return_url($order_info['order_id']),
			'merAbbr'           =>'请修改为自己的网站名称',
			'orderAmount'		=> floatval($order_info['order_amount']) * 100,
			'orderCurrency'		=> '156',   //交易人民币代码
			'transType'         =>'01',
			'signMethod'        =>'md5',
			'origQid'           => '',
			'acqCode'           => '',
			'merCode'           => '',
			'commodityUrl'      => '',
			'commodityName'     => '',
			'commodityUnitPrice'=> '',
			'commodityQuantity' => '',
			'commodityDiscount' => '',
			'transferFee'       => '',
			'customerName'      => '',
			'defaultPayType'    => '',
			'defaultBankNumber' => '',
			'transTimeout'      => '',
			'merReserved'       => '',
			'signature'     => ''
        );
		//$params['signMethod'] = $this->_greatemd5($params);
		$security_key =$this->_config['unionpay_key'];
		$params['signature']    =$this->sign($params,$security_key, 'md5');
        return $this->_create_payform('POST', $params);
    }
	
	
	   /**
     *    返回通知结果
     *
     *    @author    Garbin
     *    @param     array $order_info
     *    @param     bool  $strict
     *    @return    array
     */
	function verify_notify($order_info, $strict = false)
    {
        if (empty($order_info))
        {
            $this->_error('order_info_empty');

            return false;
        }

        /* 初始化所需数据 */
        $notify =   $this->_get_notify();

        /* 验证通知是否可信 */
        //$sign_result = $this->_verify_sign($notify,$security_key, 'md5');
		
		//提取服务器端的签名
        if (!isset($notify['signature']) || !isset($notify['signMethod'])) 
		{
           throw new Exception('No signature Or signMethod set in notify data!');
        }
		
		$this->signature = $notify['signature'];
        $this->signMethod= $notify['signMethod'];
		
        unset($notify['signature']);
        unset($notify['signMethod']);
		$security_key =$this->_config['unionpay_key']; //取得秘钥信息
		//验证签名
		$signature =$this->sign($notify,$security_key, $this->signMethod);
		
		if ($signature != $this->signature)
        {
            /* 若本地签名与网关签名不一致，说明签名不可信 */
            $this->_error('sign_inconsistent');
            return false;
        }
		   
		   /*----------本地验证开始----------*/
        /* 验证与本地信息是否匹配 */
        /* 这里不只是付款通知，有可能是发货通知，确认收货通知 */

		if ($order_info['order_sn'] != $notify['orderNumber'])
			{
				/* 通知中的订单与欲改变的订单不一致 */
				$this->_error('order_inconsistent');
				return false;
			}
		if (floatval($order_info['order_amount']) * 100 != $notify['orderAmount'])
			{
				/* 支付的金额与实际金额不一致 */
				$this->_error('price_inconsistent');

				return false;
			}
			// 如果未支付成功。
		if ($notify['respCode']!= '00') 
           {
             return false;
           }

        /*----------通知验证结束----------*/
		
        //至此，说明通知是可信的，订单也是对应的，可信的

        /* 按通知结果返回相应的结果 */
		
        if($notify['respCode']=='00')
			{ 
				$order_status = ORDER_ACCEPTED;
			}else{
			   
				$order_status = ORDER_SHIPPED;
			}
        return array(
            'target'    =>  $order_status,
        );
    }
	

	/**
	* 签名信息
	*/
	function sign($params,$security_key,$sign_method)
    {   
        if (strtolower($sign_method) == "md5") 
        {  
            ksort($params);
            $sign_str = "";
            $sign_ignore_params=array('signMethod','signature');
			
            foreach ($params as $key => $val)
            {
                if (in_array($key,$sign_ignore_params)) 
                {
                    continue;
                }
                $sign_str .= sprintf("%s=%s&", $key, $val);
            }
           return md5($sign_str . md5($security_key));
        }
        else 
        {
            exit("Unknown sign_method set in quickpay_conf");
        }
    }
	
	/**
     *    验证签名是否可信
     *
     *    @author    Garbin
     *    @param     array $notify
     *    @return    bool
     */
    function _verify_sign($notify,$sign_method)
    {   
        $local_sign = $this->sign($notify,'88888888', 'md5');

        return $local_sign;
    }

}

?>