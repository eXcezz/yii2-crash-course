<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Transaction;

/**
 * TransactionSearch represents the model behind the search form of `app\models\Transaction`.
 */
class TransactionSearch extends Transaction
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transaction_id', 'item_id', 'quantity_order', 'created_at', 'created_by'], 'integer'],
            [['order_id', 'txn_report', 'status'], 'safe'],
            [['total_amt'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Transaction::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'transaction_id' => $this->transaction_id,
            'item_id' => $this->item_id,
            'quantity_order' => $this->quantity_order,
            'total_amt' => $this->total_amt,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'order_id', $this->order_id])
            ->andFilterWhere(['like', 'txn_report', $this->txn_report])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
