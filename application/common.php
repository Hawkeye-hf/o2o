<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function status($status)
{
    if($status == 1){
        $str = "<span class='label label-success radius'>正常</span>";
    }elseif ($status == 0){
        $str = "<span class='label label-danger radius'>待审</span>";
    }else{
        $str = "<span class='label label-success radius'>删除</span>";
    }
    return $str;
}
/**
 * $param $url
 * $param init $type 0 get 1 post
 * $param array $data
 */
function doCurl($url, $type=0, $data=[])
{
    //初始化curl
    $ch = curl_init();
    //初始化
    //设置选项
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //这个代表如果成功，只返回结果，不把内容输出来
    curl_setopt($ch, CURLOPT_HEADER, 0);
    if($type == 1)
    {
        //post
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //执行并获取内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        return $output;
    }
}
//商户入驻申请的文案
function bisRegister($status)
{
    if($status == 1){
        $str ="入驻申请成功";
    }elseif ($status == 0){
        $str = "待审核，审核后平台方会发送邮件通知,请留意";
    }elseif ($status == 2 ){
        $str = "非常抱歉，您提交的材料不符合条件，请重新提交";
    }else{
        $str = "该申请已被删除";
    }
    return $str;
}

function pagination($obj)
{
    if(!$obj){
        return '';
    }
    return '<div class="cl pd-5 bg-1 bk-gray mt-20 tp5-o2o">'.$obj->render().'</div>';
}