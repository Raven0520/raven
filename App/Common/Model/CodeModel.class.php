<?php
/**
 * Created by PhpStorm.
 * User: raven
 * Date: 2017/1/5
 * Time: 05:11
 */

namespace Common\Model;

class CodeModel extends CommonModel
{
    public function _before_write(&$data, $options)
    {
        if ($data['id']){
            $content = M('content')->where(array('id'=>$_POST['content_id']))->save(array('content'=>$data['content']));
        }else{
            $content = M('content')->add(array('content'=>$data['content']));
        }
        if ($content){
            $data['summary'] = substr($data['content'],0,30);
            $data['content'] = $content;
        }else{
            return false;
        }
    }

    public function _after_select(&$result, $options)
    {
        $author = M('config')->where(array('sign'=>1,'status'=>1))->getField('id,name');
        $from   = M('config')->where(array('sign'=>2,'status'=>1))->getField('id,name');
        foreach ($result as $k => $v){
            $result[$k]['author_name'] = $author[$v['author']];
            $result[$k]['from_name']   = $from[$v['from']];
        }
    }

    public function _after_find(&$result, $options)
    {
        $content = M('content')->where(array('id'=>$result['content']))->find();
        $result['content_text'] = $content['content'];
    }
}