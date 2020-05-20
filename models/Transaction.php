<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Html;
use Yii\helpers\ArrayHelper;



/**
 * This is the model class for table "transaction".
 *
 * @property int $transaction_id
 * @property string|null $order_id
 * @property int|null $item_id
 * @property int|null $quantity_order
 * @property float|null $total_amt
 * @property string|null $txn_report
 * @property string $status
 * @property int|null $created_at
 * @property int|null $created_by
 *
 * @property Item $item
 * @property User $createdBy
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * add on for auto datetime and who created form
     */
    public function behaviors()
    {
        return [
            [
                'class' =>TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'quantity_order', 'created_at', 'created_by'], 'integer'],
            [['total_amt'], 'number'],
            [['txn_report'], 'string'],
            [['status'], 'required'],
            [['order_id'], 'string', 'max' => 55],
            [['status'], 'string', 'max' => 1024],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item_id' => 'item_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'transaction_id' => 'Transaction ID',
            'order_id' => 'Order ID',
            'item_id' => 'Item',
            'quantity_order' => 'Quantity Order',
            'total_amt' => 'Total Amt',
            'txn_report' => 'Txn Report',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * Gets query for [[Item]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['item_id' => 'item_id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * Mine
     */
}
