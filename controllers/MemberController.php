<?php
/**
 * Created by PhpStorm.
 * User: xiaolei
 * Date: 2017/6/28
 * Time: 16:03
 */

namespace app\controllers;
use yii\web\Controller;
use app\models\User;
use Yii;
class MemberController extends Controller
{
    public function actionAuth()
    {
        $this->layout = "layout2";
        $model = new User();

        return $this->render("auth",['model'=>$model]);
    }

    public function actionReg(){
        $model = new User();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if ($model->regByMail($post)){
            }
        }
    }
}