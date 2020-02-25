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
 * SecurityLogSearch represents the model behind the search form about `app\extensions\securityManager\models\SecurityLog`.
 */
class SecurityLogSearch extends SecurityLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['log_type'], 'integer'],
            [['ip_address', 'username', 'password', 'country', 'city', 'created_at'], 'safe'],
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
        $query = SecurityLog::find();

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
        $query->andFilterWhere([
            'log_type' => $this->log_type,
        ]);

        // grid filtering conditions
        $query->andFilterWhere(['like', 'ip_address', $this->ip_address]);
        $query->andFilterWhere(['like', 'username', $this->username]);
        $query->andFilterWhere(['like', 'password', $this->password]);
        $query->andFilterWhere(['like', 'country', $this->country]);
        $query->andFilterWhere(['like', 'city', $this->city]);
        $query->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }
}
