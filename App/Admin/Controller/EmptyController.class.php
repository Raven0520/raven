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
    protected $model = '';
    protected $where = array();

    public function _empty(){
        $this->display(ACTION_NAME);
    }

    /**
     * 数据库 增加或修改信息操作
     */
    public function add(){
        if (IS_POST){
            $modal = D(CONTROLLER_NAME);
            $id    = $modal->update(array_filter($_POST));
            if (false != $id){
                $this->res['id'] = $id;
            }else {
                $this->res['info'] = $modal->getError();
            }
            $this->ajaxReturn($this->res);
        }
    }
}