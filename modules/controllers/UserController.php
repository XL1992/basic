<?php
/**
 * Created by PhpStorm.
 * User: xiaolei
 * Date: 2017/7/7
 * Time: 14:19
 */

namespace app\modules\controllers;

use yii\data\Pagination;
use yii\web\Controller;
use Yii;
use app\models\User;
use app\models\Profile;

class UserController extends Controller
{
    public function actionReg()
    {
        $this->layout = 'layout1';
        $model = new User();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->reg($post)) {
                Yii::$app->session->setFlash('info', '添加成功');
            } else {
                Yii::$app->session->setFlash('info', '添加失败');
            }
        }
        $model->userpass = '';
        $model->repass = '';
        return $this->render('reg', ['model' => $model]);
    }

    public function actionUsers()
    {
        $this->layout = 'layout1';
        $model = User::find()->joinWith('profile');
        $count = $model->count();
        $pageSize = Yii::$app->params['pageSize']['user'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $users = $model->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render('users', ['users' => $users, 'pager' => $pager]);
    }
}