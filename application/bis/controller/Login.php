<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/6
 * Time: 18:42
 */

namespace app\bis\controller;

use think\Controller;
class Login extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

}