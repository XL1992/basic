<?php
/**
 * Created by PhpStorm.
 * User: xiaolei
 * Date: 2017/6/28
 * Time: 11:06
 */

namespace app\controllers;

use yii\web\Controller;

class ProductController extends Controller
{
    public $layout = false;

    public function actionIndex()
    {
        $this->layout = "layout2";
        return $this->render("index");
    }

    public function actionDetail()
    {
        $this->layout = "layout2";
        return $this->render("detail");
    }
}