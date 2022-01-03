<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Sched;

/**
 * SchedSearch represents the model behind the search form about `app\models\Sched`.
 */
class SchedSearch extends Sched
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_courses_group', 'archive', 'public', 'user_id'], 'integer'],
            [['schedule', 'start_date', 'data'], 'safe'],
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
        $query = Sched::find();

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
            'id_courses_group' => $this->id_courses_group,
            'start_date' => $this->start_date,
            'archive' => $this->archive,
            'public' => $this->public,
            'data' => $this->data,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'schedule', $this->schedule]);

        return $dataProvider;
    }
}
