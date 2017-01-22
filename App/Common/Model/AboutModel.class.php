<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/22
 * Time: 11:41
 */

namespace Common\Model;


class AboutModel extends CommonModel
{
    protected function _before_write(&$data)
    {
        $img_data = array(
            'name' => $_POST['name'],
            'url'  => $_POST['url'],
        );
        $img_id = M('about')->where('id=1')->getField('img');
        0 != $img_id && $img_data['id'] = $img_id;
        D('Img')->update($img_data);
        $data['img'] = $img_id;
    }

    protected function _after_select(&$result, $options)
    {
        foreach ($result as $k => $v){
            $img = M('img')->where(array('id'=>$v['img']))->getField('id,url,name');
            $result[$k]['name'] = $img[$v['img']]['name'];
            $result[$k]['url']  = $img[$v['img']]['url'];
        }
    }

    protected function _after_find(&$result, $options)
    {
        $img = M('img')->where(array('id'=>$result['img']))->getField('id,url,name');
        $result['name'] = $img[$result['img']]['name'];
        $result['url']  = $img[$result['img']]['url'];
    }
}