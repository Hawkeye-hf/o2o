<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/30
 * Time: 13:20
 */
namespace app\admin\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
    public function test()
    {
        //print_r(\Map::getLngLat('北京昌平沙河地铁'));
        //sendMail('email address','邮件的标题','发送成功');
    }
    public function map(){
        return \Map::staticimage('地址');
    }
    public function welcome()
    {
        \phpmailer\Email::send('956110217@qq.com','1996-08-22','阿富汗那可就就是');
        return '发送邮件成功';
        //return '欢迎登陆后台';
    }
}