<?php
namespace Admin\Controller;

use Common\Controller\CommonController;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/22
 * Time: 12:42
 */
class EmptyController extends CommonController
{

    // 主键
    protected $pk = '';
    // 数据库模型
    protected $model = '';
    // 排序
    protected $order = '';
    protected $where = array();

    protected $mark = '';

    protected function _initialize()
    {
        parent::_initialize();
        $this->where['status'] = array('neq', -1);
        $this->mark = M('Mark')->where('status=1')->getField('id,name');
        $this->assign('marks',$this->mark);
    }

    public function _empty()
    {
        $this->display('/'.CONTROLLER_NAME.'/'.ACTION_NAME);
    }

    /**
     * 数据库 增加或修改信息操作
     */
    public function add()
    {
        if (IS_POST) {
            $modal = D(CONTROLLER_NAME);
            $id = $modal->update(array_filter($_POST));
            if (false != $id) {
                $this->res['id'] = $id;
            } else {
                $this->res['status'] = 0;
                $this->res['info'] = $modal->getError();
            }
            $this->ajaxReturn($this->res);
        }
        $this->display();
    }

    /**
     * 获取需要修改的数据
     * @param int $id
     */
    public function edit($id = 0)
    {
        $this->ajaxReturn($this->info($id));
    }

    /**
     * 伪删除数据
     * @param null $id
     */
    public function delete($id = null)
    {
        IS_POST && $this->del(CONTROLLER_NAME, array('id' => $id));
    }

    /**
     * 列表数据
     */
    public function _index($where = null, $field = true, $model = CONTROLLER_NAME)
    {
        if (IS_POST) {
            '' != I('id') && $this->where['id'] = array('like', '%' . (string)I('id') . '%');
            '' != I('name') && $this->where['name'] = array('like', '%' . (string)I('name') . '%');
            '' != I('contract_type') && '' != I('contract') && $this->where[I('contract_type')] = array('like', '%' . (string)I('contract') . '%');
            $this->ajaxReturn($this->lists($model, $where ? array_merge($this->where, $where) : $this->where, $field));
        } else {
            $this->display();
        }
    }

    /**
     * 列表数据  assign
     */
    public function index($where = null, $field = true, $model = CONTROLLER_NAME)
    {
        $this->assign('index', $this->lists($model, $where ? array_merge($this->where, $where) : $this->where, $field));
        $this->display();
    }

    /**
     * 设置排序
     */
    public function ListOrder($id = null, $order = null)
    {
        IS_POST && $this->setListOrder(CONTROLLER_NAME, $order, array('id' => $id));
    }

    /**
     * 修改状态
     */
    public function Status($id = null, $status = null)
    {
        IS_POST && $this->setStatus(CONTROLLER_NAME, $status, array('id' => $id));
    }

    /**
     * 上传图片
     */
    public function imgUpload(){
        if ($_FILES['url']['error'] == 0){
            $res = D('Img')->imgUpload();
            $this->ajaxReturn($res);
        }
    }

}