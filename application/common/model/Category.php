<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/30
 * Time: 14:53
 */

namespace app\common\model;

use think\Model;

class Category extends Model
{
    protected $autoWriteTimestamp = true;  //插入当前时间
    public function add($data)
    {
        $data['status'] = 1;
        //$data['create_time'] = time();
        return $this->save($data);
    }
    public function getNormalFirstCategory()
    {
        $data = [
            'status' => 1,
            'parent_id' => 0,
        ];
        //排序
        $order = [
            'id' => 'desc',
        ];
        return $this->where($data)
            ->order($order)
            ->select();
    }
    public function getFirstCategorys($parentId = 0)
    {
        $data=[
            'parent_id' => $parentId,
            'status' => ['neq',-1],  //neq -1 不等于-1
        ];
        $order=[
            'listorder' => 'desc',
            'id' => 'desc',
        ];
        $result = $this->where($data)
            ->order($order)
            ->paginate();
        //echo $this->getLastSql(); //TP5自带的一个查看是否是想要的数据验证方法

        return $result;
    }

    public function getNormalCategoryByParentId($parentId=0)
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