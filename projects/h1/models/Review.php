<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "reviews".
 *
 * @property integer $id
 * @property string $date
 * @property string $name
 * @property integer $rating
 * @property string $text
 */
class Review extends ActiveRecord
{
	public $data;

	public $pages = [];
/*
    public function behaviors()
    {
        return [
            [
                 'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date',
                'updatedAtAttribute' => false,
                'value' => new Expression('CURRENT_TIMESTAMP()'),
            ]
        ];
    }
*/


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'text'], 'required'],
            [['rating','language_id','page_id'], 'integer'],
            [['text'], 'string'],
            [['date'],'default','value' => date('Y-m-d')],
            [['date'],'date','format' => 'php:Y-m-d'],
            [['name'], 'string', 'max' => 255],
            [['pages'],'each','rule' => ['string']],
        ];
    }


    public function getDate() {
        return $this->date? date('d.m.Y', $this->date) : '';
    }

    public function setDate($date) {
        $this->date= $date ? date('Y-m-d',$date) : null;
    }
    

    public function getPageName()
    {
        $page = $this->page;

        return $page ? $page->name : '';
    }


	public static function getPagesList()
	{
		        $page = Page::find()
            ->select(['id', 'name'])
            ->distinct(true)
            ->all();

//			print_r($page);
        return ArrayHelper::map($page, 'id', 'name');
	}



	
	
    public static function getPageList()
    {
        // Выбираем только те категории, у которых есть дочерние категории
        $page = Review::find()
            ->select(['c.id', 'c.name'])
            ->join('JOIN', 'page c', 'reviews.page_id = c.id')
            ->distinct(true)
            ->all();

//			print_r($page);
        return ArrayHelper::map($page, 'id', 'name');
        
    }
    

    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }


	public static function getLanguageList()
	{
		    $lang = Language::find()
            ->select(['id', 'name'])
            ->distinct(true)
            ->all();

        return ArrayHelper::map($lang, 'id', 'name');
	}


    public function getLanguageName()
    {
        $language = $this->language;

        return $language ? $language->name : '';
    }


    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }


    public function copySelectedRow($selection)
	{
		$result=false;				
		$model = Review::findOne($selection);
		if ( $model !== null) 
		{
			$i=0;
			foreach($model as $key=>$value)
			{
				if ($i!=0) 
				{
					$names .= $key.',';				
				}
				$i++;
			}
			$names = substr($names, 0, -1);
			$sql='insert into '.$model->tableName().' ('.$names.')
				  Select
				  '.$names.'
				  from '.$model->tableName().'
				  where id='.$selection[0];
			$result = Yii::$app->db->createCommand($sql)->execute();
		}  
		return $result;
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'date' => Yii::t('app', 'Дата'),
            'name' => Yii::t('app', 'Имя'),
            'rating' => Yii::t('app', 'Оценка'),
            'text' => Yii::t('app', 'Текст'),
            'page_id'=>Yii::t('app', 'Страница'),
            'language_id'=>Yii::t('app', 'Язык'),
        ];
    }

    public function getAnnounce()
    {
        return StringHelper::truncateWords($this->text, 26, '…');
    }
}
