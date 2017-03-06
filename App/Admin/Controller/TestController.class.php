<?php
/**
 * Created by PhpStorm.
 * User: raven
 * Date: 2017/2/23
 * Time: 下午11:36
 */

namespace Admin\Controller;


class TestController extends EmptyController
{
    public function index()
    {
        dump(C());
    }
}