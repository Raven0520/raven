<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/9
 * Time: 13:58
 */

namespace Admin\Controller;


class CodeController extends EmptyController
{
    public function _before_add(){
        $author = $this->select('Config',array('sign'=>1,'status'=>1));
        $from   = $this->select('Config',array('sign'=>2,'status'=>1));

        $this->assign('author',$author);
        $this->assign('from',$from);
    }
}