<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CategorySearch represents the model behind the search form about `app\models\Category`.
 */
class PageSearch extends Page
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
  //          [['language_id', 'name', 'alias', 'active'], 'required'],
            [['parent_id', 'catalog_section_id', 'language_id', 'active','sort'], 'integer'],
            [['before_content', 'content', 'after_content', 'aside'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['image'], 'image',  'extensions' => 'png,jpg,jpeg', 'skipOnEmpty' => true],
            [['del_img'], 'boolean'],
            [['name', 'alias'], 'string', 'max' => 128],
            [['block2_1_head','block2_2_head','block2_3_head','block3_head','block4_1_head','block4_2_head'],'string'],
            [['block2_1_desc','block2_2_desc','block2_3_desc','block4_1_desc','block4_2_desc'],'string'],
            [['meta_title', 'meta_description', 'meta_keywords'], 'string', 'max' => 256],
            [['show_feedback_form'], 'boolean']
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
     
    public  function searchById($id)
    {
	    
	    
    }
     
    public function search($params)
    {
        $query = Page::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'forcePageParam' => false,
                'pageSizeParam' => false,
                'pageSize' => 30
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'language_id'=>$this->language_id,

        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['=', 'sort', $this->sort]);


        return $dataProvider;
    }
}