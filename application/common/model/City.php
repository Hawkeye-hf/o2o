<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/7
 * Time: 11:53
 */

namespace app\common\model;

use think\Model;
class City extends Model
{
    public function getNormalCitysByParentId($parentId=0)
    {
        $data = [
            'status' => 1,
            'parent_id' => $parentId,
        ];
        //排序
        $order = [
            'id' => 'desc',
        ];
        return $this->where($data)
            ->order($order)
            ->select();
    }
}