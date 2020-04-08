<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/11
 * Time: 14:56
 *
 * BaseModel  公共的Model层
 */

namespace app\common\model;


use think\Model;

class BaseModel extends Model
{
    protected $autoWriteTimestamp = true;  //插入当前时间
    public function add($data)
    {
        $data['status'] = 0;
        $this->save($data);
        return $this->id;
    }
}