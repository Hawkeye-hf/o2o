<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/18
 * Time: 15:38
 */

namespace app\admin\controller;

use think\Controller;
class Bis extends Controller
{
    private $obj;
    public function _initialize()
    {
        $this ->obj = model("Bis");
    }
    /**
     * 入驻申请列表
     * @return mixed
     */
    public function apply()
    {
        $bis = $this ->obj->getBisByStatus();
        return $this->fetch('',[
            'bis' => $bis,
        ]);
    }
}