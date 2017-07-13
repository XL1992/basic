<?php
/**
 * Created by PhpStorm.
 * User: xiaolei
 * Date: 2017/7/13
 * Time: 16:29
 */

namespace app\modules\controllers;

use yii\web\Controller;
use yii;

class CommonController extends Controller
{
    public function init(){
        if (Yii::$app->session['admin']['isLogin']!=1){
            $this->redirect(['/admin/public/login']);
        }
    }
}