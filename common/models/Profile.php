<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "shop_profile".
 *
 * @property string $id 主键ID
 * @property string $truename 真实姓名
 * @property int $age 年龄
 * @property string $sex 性别
 * @property string $birthday 生日
 * @property string $nickname 昵称
 * @property string $company 公司
 * @property string $userid 用户的ID
 * @property string $createtime 创建时间
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['age', 'userid', 'createtime'], 'integer'],
            [['sex'], 'string'],
            [['birthday'], 'safe'],
            [['truename', 'nickname'], 'string', 'max' => 32],
            [['company'], 'string', 'max' => 100],
            [['userid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'truename' => 'Truename',
            'age' => 'Age',
            'sex' => 'Sex',
            'birthday' => 'Birthday',
            'nickname' => 'Nickname',
            'company' => 'Company',
            'userid' => 'Userid',
            'createtime' => 'Createtime',
        ];
    }
}
