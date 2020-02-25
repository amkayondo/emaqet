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
 * SecurityInappropriateReportSearch represents the model behind the search form about `app\extensions\securityManager\models\SecurityInappropriateReport`.
 */
class SecurityInappropriateReportSearch extends SecurityInappropriateReport
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['listing_id', 'status'], 'integer'],
            [['report_reason', 'report_notes', 'updated_by', 'created_at', 'updated_at'], 'safe'],
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
        $query = SecurityInappropriateReport::find();

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
        $query->andFilterWhere(['like', 'listing_id', $this->listing_id]);
        $query->andFilterWhere(['like', 'status', $this->status]);
        $query->andFilterWhere(['like', 'report_reason', $this->report_reason]);
        $query->andFilterWhere(['like', 'report_notes', $this->report_notes]);
        $query->andFilterWhere(['like', 'updated_by', $this->updated_by]);
        $query->andFilterWhere(['like', 'created_at', $this->created_at]);
        $query->andFilterWhere(['like', 'updated_at', $this->updated_at]);

        return $dataProvider;
    }
}
