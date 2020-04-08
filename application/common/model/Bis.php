<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/10
 * Time: 17:28
 */

namespace app\common\model;

use think\Model;
class Bis extends BaseModel
{
    /**
     * 通过状态获取商家数据
     * @parm $status
     *
     */
    public function getBisByStatus($status = 0)
    {
        $order = [
            'id' => 'desc',
        ];
        $data = [
            'status' => $status,

        ];
        $result = $this ->where($data)
            ->order($order)
            ->paginate();

        return $result;

    }
}