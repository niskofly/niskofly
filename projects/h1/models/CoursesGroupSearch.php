<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CoursesGroup;

/**
 * CoursesGroupSearch represents the model behind the search form about `app\models\CoursesGroup`.
 */
class CoursesGroupSearch extends CoursesGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_courses', 'user_id'], 'integer'],
            [['name', 'desc_name', 'desc_price_hour', 'desc_price_all', 'data'], 'safe'],
            [['price_hour', 'price_all'], 'number'],
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
        $query = CoursesGroup::find();

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
            'id' => $this->id,
            'id_courses' => $this->id_courses,
            'price_hour' => $this->price_hour,
            'price_all' => $this->price_all,
            'data' => $this->data,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'desc_name', $this->desc_name])
            ->andFilterWhere(['like', 'desc_price_hour', $this->desc_price_hour])
            ->andFilterWhere(['like', 'desc_price_all', $this->desc_price_all]);

        return $dataProvider;
    }
}
