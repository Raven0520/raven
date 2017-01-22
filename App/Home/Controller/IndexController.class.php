<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends EmptyController
{
    public function index()
    {
        $code = $this->select('Code',$this->where,'id,title,create_time','create_time desc');
        $about = $this->info(1,true,'About');

        $this->assign('About',$about);
        $this->assign('Code',$code);
        $this->display();
    }
}