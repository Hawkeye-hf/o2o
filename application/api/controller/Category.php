<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/7
 * Time: 14:48
 */

namespace app\api\controller;

use think\Controller;
class Category extends Controller
{
    private $obj;
    public function _initialize()
    {
        $this ->obj = model("Category");
    }

    public function getCategoryByParentId()
    {
        $id = input('post.id');
        if(!intval($id))
        {
            $this->error('ID不合法');
        }
        //通过id获取二级城市
        $categorys = $this->obj->getNormalCategoryByParentId($id);
        if(!$categorys)
        {
            return show(0,'error');
        }
        return show(1,'success',$categorys);

    }
}