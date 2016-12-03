<?php
namespace Common\Controller;
use Think\Controller;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/22
 * Time: 12:40
 */
class CommonController extends Controller
{

    // 主键
    protected $pk = '';
    //protected $pkss = '';
    // 分页参数
    protected $pages = array();
    protected $model = '';

    protected $res = array('status' => 1, 'info' => '操作成功');

    protected function _initialize()
    {

    }

    /**
     * 查询单条数据
     * @param $id
     * @param bool $field field=true 查询全部字段
     * @param mixed|string $model 传入控制器名称
     * @param null $name
     * @return mixed
     */
    protected function find($id, $field = true, $model = CONTROLLER_NAME, $where = array(), $name = null)
    {
        $pk = M($model)->getPk();
        $map = array();
        if (is_numeric($id) && !$name) {
            $map[$pk] = $id;
        } else {
            $map[$name] = $id;
        }
        $info = D($model)->field($field)->where($map)->where($where)->find();
        if (is_string($field) && 1 == count(explode(',', $field))) {
            return $info[$field];
        }
        return $info;
    }
}