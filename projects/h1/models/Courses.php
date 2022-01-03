<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "courses".
 *
 * @property integer $id
 * @property string $name
 * @property integer $id_page
 * @property integer $week
 * @property integer $academic_hour
 * @property integer $language_id
 * @property string $data
 * @property integer $user_id
 *
 * @property Language $language
 * @property Page $idPage
 * @property CoursesGroup[] $coursesGroups
 */
class Courses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'courses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'language_id', 'user_id'], 'required'],
            [['id_page', 'week', 'academic_hour', 'language_id', 'user_id'], 'integer'],
            [['data'], 'safe'],
            [['name'], 'string', 'max' => 254],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
            [['id_page'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['id_page' => 'id']],
        ];
    }
    
    
    public function copySelectedRow($selection)
	{
		$result=false;				
		$model = Courses::findOne($selection);
		if ( $model !== null) 
		{
			$i=0;
			$names='';
			foreach($model as $key=>$value)
			{
				if ($i!=0) 
				{
					$names .= '`'.$key.'`,';				
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
            'name' => Yii::t('app', 'Name'),
            'id_page' => Yii::t('app', 'Id Page'),
            'week' => Yii::t('app', 'Week'),
            'academic_hour' => Yii::t('app', 'Academic Hour'),
            'language_id' => Yii::t('app', 'Language ID'),
            'data' => Yii::t('app', 'Data'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }


    public function getLanguageName()
    {
	         $language = $this->language;
			 return $language ? $language->name : '';
    } 

    public function getLanguageList()
	{
		    $lang = Language::find()
            ->select(['id', 'name'])
            ->distinct(true)
            ->all();

        return ArrayHelper::map($lang, 'id', 'name');
	}


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }


    public function getPageList($type)
	{
		if ($type)
		{
		    $page = Page::find()
            ->select(['page.id', 'page.name'])
            ->leftJoin('courses','courses.id_page=page.id')
            ->where('courses.id is not null')
            ->all();
		}
		else
		{
		    $page = Page::find()
            ->select(['page.id', 'page.name'])
			->distinct(true)
            ->all();
		}
        return ArrayHelper::map($page, 'id', 'name');
	}


    public function getPageName()
    {
	         $page = $this->idPage;
			 return $page ? $page->name : '';
    } 
	

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'id_page']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoursesGroups()
    {
        return $this->hasMany(CoursesGroup::className(), ['id_courses' => 'id']);
    }
}
