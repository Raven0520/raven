<?php
namespace Common\Controller;
use Think\Auth;
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

    protected $res = array('status' => 1, 'info' => 'Complete!');
    protected $auth = false;

    protected $user = '';

    protected function _initialize()
    {
        //注册菜单拦
        $where = array('sort_id' => 0 , 'menu_status' => 1);
        if (CONTROLLER_NAME == 'AuthGroup'){
            $where['menu_status'] = array('neq',-1);
        }
        for ($i = 1; $i < 4; $i++){
            $where['modal'] = $i;
            $modal[$i] = D('AuthRule')->where($where)->order('list_order')->select();
            foreach ($modal[$i] as $k => $v){
                $name = 'second' . $modal[$i][$k]['id'];
                $modal[$i][$k]['second'] = $name;
                $sec_where = array('sort_id' => $modal[$i][$k]['id'], 'menu_status' => 1);
                'AuthGroup' == CONTROLLER_NAME && $sec_where['menu_status'] = array('neq',-1);
                $data = $this->select('AuthRule',$sec_where,$field = true, $order = 'list_order');
                $this->assign($name,$data);
            }
            $this->assign('modal'.$i,$modal[$i]);
        }
        $this->user = session('user');
        $this->assign('user',$this->user);
        //判断用户是否有权限
        $auth = new Auth();
        $action = ACTION_NAME;
        if ($action == 'Status' || $action == 'ListOrder'){
            $action = 'edit';
        }
        $this->auth = $auth->check('/'.CONTROLLER_NAME.'/'.$action,$this->user['id']);
//        echo '/'.CONTROLLER_NAME.'/'.ACTION_NAME;exit();
        1 == $this->user['id'] && $this->auth = true;
        if ($this->auth == false){
            if (empty($this->user)){
                return redirect('/login');
            }
            return redirect('/Login/PermissionDenied');
        }
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

    protected function setListOrder($model,$order,$where = array(),$msg = array('success' => '排序成功','error'=>'排序失败')){
        $data['list_order'] = $order;
        $data['edit_time'] = time();
        $this->editRow($model,$data,$where,$msg);
    }

    protected function setStatus($model,$status,$where = array(), $msg = array('success' => '设置成功','error' => '设置失败')){
        0 == $status ? $data['status'] = 1 : $data['status'] = 0;
        $data['edit_time'] = time();
        $this->editRow($model,$data,$where,$msg);
    }

    /**
     * 修改表中的数据
     * @param $model
     * @param $data
     * @param $where
     * @param $msg
     */
    final protected function editRow($model = CONTROLLER_NAME, $data, $where, $msg)
    {
        $id = array_unique((array)I('id', 0));
        $id = is_array($id) ? implode(',', $id) : $id;
        $fields = M($model)->getDbFields();
        if (in_array('id', $fields) && !empty($id)) {
            $where = array_merge(array('id' => array('in', $id)), (array)$where);
        }
        $msg = array_merge(array('success' => '操作成功！', 'error' => '操作失败！', 'url' => '', 'ajax' => IS_AJAX), (array)$msg);
        if (M($model)->where($where)->save($data) !== false) {
            $this->success($msg['success'], $msg['url'], $msg['ajax']);
        } else {
            $this->error($msg['error'], $msg['url'], $msg['ajax']);
        }
    }

    /**
     * 删除数据
     * @param $model
     * @param array $where
     * @param array $msg
     */
    protected function del($model, $where = array(), $msg = array('success' => '删除成功！', 'error' => '删除失败！'))
    {
        $data['status'] = -1;
        $this->editRow($model, $data, $where, $msg);
    }
}