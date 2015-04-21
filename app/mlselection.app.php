<?php

/* 多级选择：地区选择，分类选择 */
class MlselectionApp extends MallbaseApp
{
    function index()
    {
        in_array($_GET['type'], array('region', 'gcategory','newregion','gcategoryyxw')) or $this->json_error('invalid type');
        $pid = empty($_GET['pid']) ? 0 : $_GET['pid'];

        switch ($_GET['type'])
        {
            case 'region':
                $mod_region =& m('region');
                $regions = $mod_region->get_list($pid);
                foreach ($regions as $key => $region)
                {
                    $regions[$key]['region_name'] = htmlspecialchars($region['region_name']);
                }
                $this->json_result(array_values($regions));
                break;
            case 'gcategory':
                $mod_gcategory =& m('gcategory');
                $cates = $mod_gcategory->get_list($pid, true);
                foreach ($cates as $key => $cate)
                {
                    $cates[$key]['cate_name'] = htmlspecialchars($cate['cate_name']);
                }
                $this->json_result(array_values($cates));
                break;
            case 'newregion':
                $mod_region =& m('region');
                $regions = $mod_region->newget_parents($pid);
                foreach ($regions as $key => $region)
                {
                    $regions[$key]['region_name'] = htmlspecialchars($region['region_name']);
                }
                $this->json_result(array_values($regions));
                break;
			 case 'gcategoryyxw':
                $mod_gcategory =& m('gcategory');
                $cates = $mod_gcategory->get_listyxw($pid, 0,1);
                foreach ($cates as $key => $cate)
                {
                    $cates[$key]['cate_name'] = htmlspecialchars($cate['cate_name']);
                }
                $this->json_result(array_values($cates));
                break;
        }
    }
    
    //添加配送区域
    function add(){
        $db = &db();
        $aid = empty($_GET['aid']) ? 0 : $_GET['aid'];
        $storeid=empty($_GET['id']) ? 0 : $_GET['id'];
        $sqlsplit="select area_peisong from ecm_store where store_id=".$storeid;
        $aids=split(',',$db->getOne($sqlsplit));
        $aidt=0;
        foreach ($aids as $value) {
            if($value==$aid)
            {
                $aidt=1;
            }
        }
        
        if($aid!= 0 && $storeid!= 0&&$aidt==0)
        {
            $sql="update ecm_store set area_peisong=concat_ws(',',area_peisong,'".$aid."') where store_id=".$storeid;
           
            echo $db->query($sql);
            
        }else {
            echo "0";
        }
        
    }
    //更新配送区域
    function update(){
        $db = &db();
        $aids = empty($_POST['aids']) ? 0 : $_POST['aids'];
        $storeid=empty($_GET['id']) ? 0 : $_GET['id'];
    
    
        if( $storeid!= 0)
        {
            $sql="update ecm_store set area_peisong='".$aids."' where store_id=".$storeid;
             
            echo $db->query($sql);
    
        }else {
            echo "0";
        }
    
    }
    //获取配送区域id及名称到复选框
    function  getarea()
    {
        $db = &db();
        //$aid = empty($_GET['aid']) ? 0 : $_GET['aid'];
        $storeid=empty($_GET['id']) ? 0 : $_GET['id'];
        $sqlsplit="select area_peisong from ecm_store where store_id=".$storeid;
        $aids=split(',',$db->getOne($sqlsplit));
        $keyvalue=array();
        unset($aids[0]);
        foreach ($aids as $aid)
        {
            $sqlname="select region_name from ecm_region where region_id=".$aid;
            $keyvalue[$aid]=$db->getOne($sqlname);
        }
        foreach ($keyvalue as $k => $v) {
            
            echo "<input type=\"checkbox\" checked=\"true\" value=\"".$k."\" name=\"aids\">".$v;
        }
    }
	//获取分类列表checkbox
	    function getcates()
	    {
			
        $db = &db();
        $aids=split(',',$_POST['aids']);
        $keyvalue=array();
		
		unset($aids[0]);
		//print_r($aids);
	   // exit();
        foreach ($aids as $aid)
        {
			//if(empty($aid)||is_null($aid)){}
            $sqlname="select cate_name from ecm_gcategory where cate_id=".$aid;
            $keyvalue[$aid]=$db->getOne($sqlname);
			
        }
        foreach ($keyvalue as $k => $v) {
            
            echo "<input type=\"checkbox\" checked=\"true\" value=\"".$k."\" name=\"aids\">".$v;
			
        }
    }
}

?>