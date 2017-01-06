<?php
namespace Common\Model;

use Think\Model\RelationModel;
use Think\Upload;

/**
 * Created by PhpStorm.
 * User: raven
 * Date: 2016/12/1
 * Time: 04:21
 */
class CommonModel extends RelationModel
{
    protected $_auto = array(
        array('create_time', NOW_TIME, 1),
        array('edit_time', NOW_TIME, 2)
    );

    /**
     * 更新信息
     * @return boolean 更新状态
     */
    public function update($data = null)
    {
        $data = empty($data) ? $_POST : $data;
        $data = $this->create($data);
        if (!$data) {
            return false;
        }
        return empty ($data [$this->pk]) ? $this->add() : $this->save();
    }

    /**
     * 更新信息
     * @return boolean 更新状态
     */
    public function _update($data = null)
    {
        $data = empty($data) ? $_POST : $data;
        '自动编号' == $data['id'] && $data['id'] = '';
        $data = $this->create($data);
        if (!$data) {
            return false;
        }
        if (empty($data[$this->pk])) {
//            $data['id'] = RandomID(); 添加随机ID
            $this->add($data);
        } else {
            $this->save();
        }
        return $data['id'];
    }

    /**
     * 通用上传图片方法
     */
    public function imgUpload()
    {
        $res = array('status' => 1);
        $upload = new Upload();
        $upload->maxSize = 3145728;
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
        $upload->rootPath = 'Public/';
        $upload->savePath = 'Upload/';
        $info = $upload->upload();

        if (!$info) {
            $res['info'] = $upload->getError();
        } else {// 上传成功
            $res['info'] = '上传成功';
            $res['url'] = $upload->rootPath . $info['url']['savepath'] . $info['url']['savename'];
        }
        return $res;
    }
}