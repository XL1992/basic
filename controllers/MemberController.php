<?php
/**
 * Created by PhpStorm.
 * User: xiaolei
 * Date: 2017/6/28
 * Time: 16:03
 */

namespace app\controllers;

use yii\web\Controller;

class MemberController extends Controller
{
    public function actionAuth()
    {
        $this->layout = "layout2";
        return $this->render("auth");
    }
}