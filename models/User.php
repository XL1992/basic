<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class User extends ActiveRecord
{
    public $repass;
    public $loginname;
    public $rememberMe;

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
            'loginname' => '用户名/电子邮箱',
        ];
    }

    public function rules()
    {
        return [
            ['username', 'required', 'message' => '用户名不能为空', 'on' => ['reg', 'regbymail', 'update']],
            ['username', 'unique', 'message' => '该用户名已被注册', 'on' => ['reg', 'regbymail', 'update']],
            ['userpass', 'required', 'message' => '登录密码不能为空', 'on' => ['reg', 'regbymail']],
            ['repass', 'required', 'message' => '确认密码不能为空', 'on' => ['reg']],
            ['repass', 'compare', 'compareAttribute' => 'userpass', 'message' => '两次密码不一致', 'on' => ['reg']],
            ['useremail', 'required', 'message' => '邮箱不能为空', 'on' => ['reg', 'regbymail', 'update']],
            ['useremail', 'unique', 'message' => '该邮箱已被注册', 'on' => ['reg', 'regbymail', 'update']],
            ['useremail', 'email', 'message' => '邮箱格式不正确', 'on' => ['reg', 'regbymail', 'update']],
            ['loginname', 'required', 'message' => '登录名不能为空', 'on' => ['login']],
            ['userpass', 'required', 'message' => '密码不能为空', 'on' => ['login']],
            ['userpass', 'validatePass', 'on' => ['login']],
        ];
    }

    public function validatePass()
    {
        if (!$this->hasErrors()) {
            $loginname = "username";
            if (preg_match('/@/', $this->loginname)) {
                $loginname = "useremail";
            }
            $data = self::find()->where($loginname . '= :loginname and userpass = :userpass', [':loginname' => $this->loginname, ':userpass' => md5($this->userpass)])->one();
            if (is_null($data)) {
                $this->addError('userpass', '用户名或密码错误');
            }
        }
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
            $trans = Yii::$app->db->beginTransaction();
            try {
                if ($this->save(false)) {
                    $userid = $this->find()->select('userid')->where('useremail = :useremail', [':useremail' => $data['User']['useremail']])->one();
                    if (!empty($userid)) {
                        $profile = new Profile();
                        $a = Profile::find()->where('userid = :userid', [':userid' => $userid['userid']])->one();
                        if (!empty($a)) {
                            throw new \Exception();
                        }
                        $profile->userid = $userid['userid'];
                        $profile->createtime = time();
                        $profileAdd = $profile->insert();
                    }
                    if (empty($profileAdd)) {
                        throw new \Exception();
                    }
                }
                $trans->commit();
                return true;
            } catch (\Exception $e) {
                if (Yii::$app->db->getTransaction()) {
                    $trans->rollBack();
                }
            }
        }
        return false;
    }

    public function regByMail($data)
    {
        $this->scenario = 'regbymail';
        $data['User']['username'] = 'imooc_' . uniqid();
        $data['User']['userpass'] = uniqid();
        if ($this->load($data) && $this->validate()) {
            $mailer = Yii::$app->mailer->compose('createuser', ['username' => $data['User']['username'], 'userpass' => $data['User']['userpass']]);
            $mailer->setFrom('shop_imooc@163.com');
            $mailer->setTo($data['User']['useremail']);
            $mailer->setSubject('慕课商城-新建用户');
            if ($mailer->send() && $this->reg($data, 'regbymail')) {
                return true;
            }
        }
        return false;
    }

    public function login($data)
    {
        $this->scenario = 'login';
        if ($this->load($data) && $this->validate()) {
            $lifetime = $this->rememberMe ? 24 * 3600 : 0;
            $session = Yii::$app->session;
            session_set_cookie_params($lifetime);
            $session['user'] = [
                'loginname' => $this->loginname,
                'isLogin' => '1',
            ];
            return (bool)$session['isLogin'];
        }
        return false;
    }

    public function updateInfo($data)
    {
        $this->scenario = 'update';
        if ($this->load($data) && $this->validate()) {
            $this->findone('userid = :userid',[':userid'=>$data['User']['userid']]);
            $this->createtime = time();
            $this->username = $data['User']['username'];
            $this->useremail = $data['User']['useremail'];
            $this->update();
            return true;
//            $trans = Yii::$app->db->beginTransaction();
//            try {
//                if ($this->)
//            } catch (\Exception $e) {
//                if (Yii::$app->db->getTransaction()) {
//
//                }
//            }
        }
        return false;
    }
}