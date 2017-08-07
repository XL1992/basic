<?php
/**
 * Created by PhpStorm.
 * User: xiaolei
 * Date: 2017/8/7
 * Time: 14:31
 */

namespace app\modules\controllers;

use yii\web\Controller;
use Yii;
use app\modules\controllers\CommonController;

class CategoryController extends CommonController
{
    public function actionList()
    {
        $this->layout = 'layout1';
        return $this->render('cates');
    }

    public function actionAdd()
    {
        $this->layout = 'layout1';
        return $this->render('add');
    }
}