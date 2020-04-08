<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/7
 * Time: 14:22
 */
function show($status,$message='',$data=[])
{
    return [
        'status' => intval($status),
        'message' => $message,
        'data' => $data,
    ];
}