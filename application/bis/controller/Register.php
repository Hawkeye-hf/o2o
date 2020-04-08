<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/6
 * Time: 18:51
 */

namespace app\bis\controller;

use think\Controller;
class Register extends Controller
{
    public function index()
    {
        //获取一级城市的数据
        $citys = model('City')->getNormalCitysByParentId();
        //获取一级栏目的数据
        $categorys = model('Category')->getNormalCategoryByParentId();
        return $this->fetch('',[
            'citys' => $citys,
            'categorys' => $categorys,
        ]);
    }

    public function add()
    {
        if(!request()->isPost())
        {
            $this->error('请求错误');
        }
        //获取表单的值
        $data = input('post.');
        //检验数据
        $validate = validate('Bis');
        if(!$validate->scene('add')->check($data)){
            //$this->error($validate->getError());
        }
        //获取经纬度
        $lnglat = \Map::getLngLat($data['address']);
        if(empty($lnglat)||$lnglat['status']!=0||$lnglat['result']['precise']!=1){
            $this->error('无法获取数据，或者匹配的地址不精准');
        }
        //判定提交的用户是否存在
        $accountResult = Model('BisAccount')->get(['username'=>$data['username']]);
        if($accountResult){
            $this->error('该用户存在，请重新分配');
        }
        //商户基本信息入库
        $bisData = [
            'name' => $data['name'],
            'city_id' => $data['city_id'],
            'city_path' => empty($data['se_city_id'])?$data['city_id']:$data['city_id'].','.$data['se_city_id'],
            'logo' => $data['logo'],
            'licence_logo' => $data['licence_logo'],
            'descrciption' => empty($data['descrciption']) ? '': $data['descrciption'],
            'bank_info' => $data['bank_info'],
            'bank_user' => $data['bank_user'],
            'bank_name' => $data['bank_name'],
            'faren' => $data['faren'],
            'faren_tel' => $data['faren_tel'],
            'email' => $data['email'],
        ];
        $bisId = model('Bis')->add($bisData);
//        echo $bisId;
//        exit;
        //总店的相关信息校验
        $data['cat'] = '';
        if(!empty($data['se_category_id'])){
            $data['cat'] = implode('|',$data['se_category_id']);
        }
        //总店的相关信息入库
        $locationData = [
            'bis_id' =>$bisId,
            'name' => $data['name'],
            'logo' => $data['logo'],
            'tel' => $data['tel'],
            'contact' => $data['contact'],
            'category_id' => $data['category_id'],
            'category_path' => $data['category_path'],
            'city_id' => $data['cit_id'],
            'city_path' =>empty($data['se_city_id']) ? $data['city_id'] : $data['city_id']. ','.$data['city_id']. ',' . $data['se_city_id'],
            'api_address' =>$data['address'],
            'open_time' => $data['open_time'],
            'content' => empty($data['content']) ? '' : $data['content'],
            'is_main' => 1,//代表的是总店信息
            'xpoint' => empty($lnglat['result']['location']['lng']) ? '' :$lnglat['result']['location']['lng'],
            'ypoint' => empty($lnglat['result']['location']['lat']) ? '' :$lnglat['result']['location']['lat'],
        ];
        $localtionId = model('BisLocaltion')->add($locationData);

         //账户相关信息校验
         //自动生成密码加盐字符串
         $data['code'] = mt_rand(100,10000);
         $accounData = [
             'bis_id' => $bisId,
             'username' => $data['username'],
             'code' => $data['code'],
             'password' => md5($data['password'].$data['code']),
             'is_main' =>1, //代表是总管理员
         ];
        $accountId = ('BisAccound')->add($accounData);
        if(!$accountId) {
            $this->error('申请失败');
        }
        //发送邮件
        $url =request()->domain().url('bis/register/waiting',['id=>bisId']);
        $title = "o2o入驻申请通知";
        $content = "您提交的入驻申请需等待平台方审核，您可以通过点击链接<a href='".$url."' target='_bank'>查看链接</a> 查看审核状态";
        \phpmailer\Email::send($data['email'],$title,$content);

        $this->success('申请成功',url('register/waiting',['id'=>$bisId]));
    }
    public function waiting($id)
    {
        if(empty($id)){
            $this->error('error');
        }
        $detail = mdel('Bis')->get($id);

        return $this->fetch('',[
            'detail' => $detail,

        ]);
    }
}