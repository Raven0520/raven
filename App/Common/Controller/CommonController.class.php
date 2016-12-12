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
    protected function info($id, $field = true, $model = CONTROLLER_NAME, $where = array(), $name = null)
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

    /**
     * 分页列表数据
     * @param $model
     * @param array $where
     * @param string $order
     * @param bool $field
     * @return mixed
     */

    protected function lists($model = CONTROLLER_NAME, $where = array('status' => array('egt', 0)), $field = true, $order = '', $pages = '')
    {
        $options = array();
        $REQUEST = (array)I('request');
        //如果有定义模型，则实例化定义的模型
        if (is_string($model)){
            $model = D($model);
        }

        //暂时不懂
        $OPT = new \ReflectionProperty($model,'options');
        $OPT-> setAccessible(true);

        $pk = $model->getPk(); //获取数据库主键
        if (null == $order){
        }elseif (isset($REQUEST['_order']) && isset($REQUEST['_field']) && in_array(strtolower($REQUEST['_order']),array('desc','asc'))){
            $options['order'] = '`' . $REQUEST['_field'] . '`' . $REQUEST['_order'];
        }elseif ($order === '' && empty($options['order']) && !empty($pk)){
            $options['order'] = $pk . 'desc';
        }elseif ($order){
            $options['order'] = $order;
        }
        unset($REQUEST['_order'],$REQUEST['_field']);

        if (!empty($where)){
            $options['where'] = $where;
        }
        $options = array_merge((array)$OPT->getValue($model),$options);
        $model->setProperty('options',$options);

        if (IS_POST && $pages) {
            $pages = $this->pages;
            if ($pages['rows']) {
                $listRows = $pages['rows'];
            } else {
                $listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 20;
            }
            $total = $model->where($options['where'])->count();
            $options['limit'] = ($pages['page'] > 0 ? $listRows * ($pages['page'] - 1) : 0) . ',' . $listRows;
            $model->setProperty('options', $options);
            $data['total'] = $total;
            $data['rows'] = $model->field($field)->relation(true)->select();
            return $data;
        } else if ($pages) {
            $total = $model->where($options['where'])->count();
            if (isset($REQUEST['r'])) {
                $listRows = (int)$REQUEST['r'];
            } else {
                $listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : $pages;
            }
            $page = new \Think\Page($total, $listRows);
            if ($total > $listRows) {
                $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
            }
            $p = $page->show();
            $this->assign('_page', $p ? $p : '');
            $this->assign('_total', $total);
            $options['limit'] = $page->firstRow . ',' . $page->listRows;
            $model->setProperty('options', $options);
        }
        return $model->field($field)->relation(true)->select();
    }
    /*protected function lists($model = CONTROLLER_NAME, $where = array('status' => array('egt', 0)), $field = true, $order = '', $pages = 20)
    {
        $options = array();
        $REQUEST = (array)I('request.');
        if (is_string($model)) {
            $model = D($model);
        }
        $OPT = new \ReflectionProperty($model, 'options');
        $OPT->setAccessible(true);

        //dump($OPT);
        $pk = $model->getPk();
        if (null == $order) {
        } elseif (isset($REQUEST['_order']) && isset($REQUEST['_field']) && in_array(strtolower($REQUEST['_order']), array('desc', 'asc'))) {
            $options['order'] = '`' . $REQUEST['_field'] . '` ' . $REQUEST['_order'];
        } elseif ($order === '' && empty($options['order']) && !empty($pk)) {
            $options['order'] = $pk . ' desc';
        } elseif ($order) {
            $options['order'] = $order;
        }
        unset($REQUEST['_order'], $REQUEST['_field']);

        if (!empty($where)) {
            $options['where'] = $where;
        }
        $options = array_merge((array)$OPT->getValue($model), $options);
        $model->setProperty('options', $options);
        if (IS_POST && $pages) {
            $pages = $this->pages;
            if ($pages['rows']) {
                $listRows = $pages['rows'];
            } else {
                $listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 20;
            }
            $total = $model->where($options['where'])->count();
            $options['limit'] = ($pages['page'] > 0 ? $listRows * ($pages['page'] - 1) : 0) . ',' . $listRows;
            $model->setProperty('options', $options);
            $data['total'] = $total;
            $data['rows'] = $model->field($field)->relation(true)->select();
            return $data;
        } else if ($pages) {
            $total = $model->where($options['where'])->count();
            if (isset($REQUEST['r'])) {
                $listRows = (int)$REQUEST['r'];
            } else {
                $listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : $pages;
            }
            $page = new \Think\Page($total, $listRows);
            if ($total > $listRows) {
                $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
            }
            $p = $page->show();
            $this->assign('_page', $p ? $p : '');
            $this->assign('_total', $total);
            $options['limit'] = $page->firstRow . ',' . $page->listRows;
            $model->setProperty('options', $options);
        }
        return $model->field($field)->relation(true)->select();
    }*/

    /**
     * 列表数据，不带分页
     * @param mixed|string $model
     * @param array $where
     * @param string $order
     * @param bool $field
     * @return mixed
     */
    protected function select($model = CONTROLLER_NAME, $where = array(), $field = true, $order = '')
    {
        return $this->lists($model, $where, $field, $order, false);
    }
}