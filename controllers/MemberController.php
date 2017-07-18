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
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->login($post)) {
                Yii::$app->session->setFlash('info', '登录成功');
            }
        }
        return $this->render("auth", ['model' => $model]);
    }

    public function actionReg()
    {
        $model = new User();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->regByMail($post)) {
                Yii::$app->session->setFlash('info', '电子邮件发送成功');
            }
        }
        $this->layout = 'layout2';
        return $this->render('auth', ['model' => $model]);
    }

    public function actionUserinfo()
    {
        $this->layout = false;
        $username = Yii::$app->request->get('username');
        $user = User::find()->where('username = :user',[':user'=>$username])->joinWith('profile')->one();
        return $this->render('userinfo',['model'=>$user]);
    }
}