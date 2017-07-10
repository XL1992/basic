<?php
/**
 * Created by PhpStorm.
 * User: xiaolei
 * Date: 2017/6/28
 * Time: 11:15
 */
namespace app\controllers;
use yii\web\Controller;

class CartController extends Controller{
    public function actionIndex(){
        $this->layout="layout1";
        return $this->render("index");
    }
}