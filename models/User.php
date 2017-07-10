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
    public function attributeLabels(){
        return [
            'username'=>'用户名',
            'useremail'=>'注册邮箱',
            'userpass'=>'登录密码',
            'repass'=>'确认密码',
        ];
    }

    public function rules()
    {
        return [
            ['username','required','message'=>'用户名不能为空','on'=>['useradd']],
            ['username','unique','message'=>'该用户名已被注册','on'=>['useradd']],
            ['userpass','required','message'=>'登录密码不能为空','on'=>['useradd']],
            ['repass','required','message'=>'确认密码不能为空','on'=>['useradd']],
            ['repass','compare','compareAttribute'=>'userpass','message'=>'两次密码不一致','on'=>['useradd']],
            ['useremail','required','message'=>'邮箱不能为空','on'=>['useradd']],
            ['useremail','unique','message'=>'该邮箱已被注册','on'=>['useradd']],
            ['useremail','email','message'=>'邮箱格式不正确','on'=>['useradd']],
        ];
    }
    public function getProfile(){
        return $this->hasOne(Profile::className(),['userid'=>'userid']);
    }

    public function reg($data)
    {
        $this->scenario = 'useradd';
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

}