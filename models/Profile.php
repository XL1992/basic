<?php
/**
 * Created by PhpStorm.
 * User: xiaolei
 * Date: 2017/7/7
 * Time: 16:14
 */

namespace app\models;
use yii\db\ActiveRecord;

class Profile extends ActiveRecord{
    public static function tableName(){
        return "{{%profile}}";
    }
}