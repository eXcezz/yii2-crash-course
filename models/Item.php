<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "item".
 *
 * @property int $item_id
 * @property string $item_name
 * @property int|null $quantity
 * @property float|null $price
 * @property string|null $description
 * @property int|null $created_at
 * @property int|null $created_by
 *
 * @property User $createdBy
 * @property Transaction[] $transactions


 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item';
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
            [['item_name'], 'required'],
            [['quantity', 'created_at', 'created_by'], 'integer'],
            [['price'], 'number'],
            [['description'], 'string'],
            [['item_name'], 'string', 'max' => 1024],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'item_id' => 'Item ID',
            'item_name' => 'Item Name',
            'quantity' => 'Quantity',
            'price' => 'Price',
            'description' => 'Description',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * Gets query for [[Transactions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transaction::className(), ['item_id' => 'item_id']);
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
     * My add on
     */

}
