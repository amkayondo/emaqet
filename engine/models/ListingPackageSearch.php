<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.0
 */

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class ListingPackageSearch
 * @package app\models
 */
class ListingPackageSearch extends ListingPackage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price', 'listing_days', 'promo_days', 'auto_renewal'], 'integer'],
            [['title','promo_sign'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
        $query = ListingPackage::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'auto_renewal', $this->auto_renewal])
            ->andFilterWhere(['like', 'listing_days', $this->listing_days])
            ->andFilterWhere(['like', 'promo_days', $this->promo_days])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at]);
        return $dataProvider;
    }
}
