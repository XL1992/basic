<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class User extends ActiveRecord
{
    public $repass;

    public static function tableName()
    {
        return "{{%user}}";
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'useremail' => '注册邮箱',
            'userpass' => '登录密码',
            'repass' => '确认密码',
        ];
    }

    public function rules()
    {
        return [
            ['username', 'required', 'message' => '用户名不能为空', 'on' => ['reg', 'regbymail']],
            ['username', 'unique', 'message' => '该用户名已被注册', 'on' => ['reg', 'regbymail']],
            ['userpass', 'required', 'message' => '登录密码不能为空', 'on' => ['reg', 'regbymail']],
            ['repass', 'required', 'message' => '确认密码不能为空', 'on' => ['reg']],
            ['repass', 'compare', 'compareAttribute' => 'userpass', 'message' => '两次密码不一致', 'on' => ['reg']],
            ['useremail', 'required', 'message' => '邮箱不能为空', 'on' => ['reg', 'regbymail']],
            ['useremail', 'unique', 'message' => '该邮箱已被注册', 'on' => ['reg', 'regbymail']],
            ['useremail', 'email', 'message' => '邮箱格式不正确', 'on' => ['reg', 'regbymail']],
        ];
    }

    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['userid' => 'userid']);
    }

    public function reg($data, $scenario = 'reg')
    {
        $this->scenario = $scenario;
        if ($this->load($data) && $this->validate()) {
            $this->createtime = time();
            $this->userpass = md5($this->userpass);
            if ($this->save(false)) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function regByMail($data)
    {
        $this->scenario = 'regbymail';
        $data['user']['username'] = 'imooc_' . uniqid();
        $data['user']['userpass'] = uniqid();
        if ($this->load($data) && $this->validate()) {
            $mailer = Yii::$app->mailer->compose('createuser', ['userpass' => $data['User']['userpass'], 'username' => $data['User']['username']]);
            $mailer->setFrom('shop_imooc@163.com');
            $mailer->setTo($data['User']['useremail']);
            $mailer->setSubject('慕课商城-新建用户');
            if ($mailer->send() && $this->reg($data, 'regbymail')) {
                return true;
            }
        }
        return false;
    }

}