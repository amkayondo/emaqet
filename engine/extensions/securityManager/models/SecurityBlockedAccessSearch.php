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
 * BlockedAccessSearch represents the model behind the search form about `app\extensions\securityManager\models\SecurityBlockedAccess`.
 */
class SecurityBlockedAccessSearch extends SecurityBlockedAccess
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip_address', 'expire', 'is_active', 'created_at'], 'safe'],
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
        $query = SecurityBlockedAccess::find();

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
        $query->andFilterWhere(['like', 'ip_address', $this->ip_address]);
        $query->andFilterWhere(['like', 'expire', $this->expire]);
        $query->andFilterWhere(['like', 'is_active', $this->is_active]);
        $query->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }
}
