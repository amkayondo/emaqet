<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.3
 */

namespace app\extensions\securityManager\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class SecurityBannedCustomerSearch
 * @package app\extensions\securityManager\models
 */
class SecurityBannedCustomerSearch extends SecurityBannedCustomer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_email', 'ban_reason', 'created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = SecurityBannedCustomer::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['like', 'customer_email', $this->customer_email]);
        $query->andFilterWhere(['like', 'ban_reason', $this->ban_reason]);
        $query->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }
}
