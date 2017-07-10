<?php
/**
 * Created by PhpStorm.
 * User: xiaolei
 * Date: 2017/6/28
 * Time: 15:58
 */

namespace app\controllers;

use yii\web\Controller;

class OrderController extends Controller
{
    public function actionIndex()
    {
        $this->layout = "layout2";

        return $this->render("index");
    }

    public function actionCheck()
    {
        $this->layout = "layout1";
        return $this->render("check");
    }


}