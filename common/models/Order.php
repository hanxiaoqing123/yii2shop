<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "shop_order".
 *
 * @property string $orderid
 * @property string $userid
 * @property string $addressid
 * @property string $amount
 * @property string $status
 * @property string $expressid
 * @property string $expressno
 * @property string $tradeno
 * @property string $tradeext
 * @property string $createtime
 * @property string $updatetime
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'addressid', 'status', 'expressid', 'createtime'], 'integer'],
            [['amount'], 'number'],
            [['tradeext'], 'string'],
            [['updatetime'], 'safe'],
            [['expressno'], 'string', 'max' => 50],
            [['tradeno'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'orderid' => 'Orderid',
            'userid' => 'Userid',
            'addressid' => 'Addressid',
            'amount' => 'Amount',
            'status' => 'Status',
            'expressid' => 'Expressid',
            'expressno' => 'Expressno',
            'tradeno' => 'Tradeno',
            'tradeext' => 'Tradeext',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
        ];
    }
}
