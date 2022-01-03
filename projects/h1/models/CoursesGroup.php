<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "courses_group".
 *
 * @property integer $id
 * @property string $name
 * @property string $desc_name
 * @property integer $id_courses
 * @property string $price_hour
 * @property string $desc_price_hour
 * @property string $price_all
 * @property string $desc_price_all
 * @property string $data
 * @property integer $user_id
 *
 * @property Courses $idCourses
 * @property Sched[] $scheds
 */
class CoursesGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'courses_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'user_id'], 'required'],
            [['id_courses', 'user_id'], 'integer'],
            [['price_hour', 'price_all'], 'number'],
            [['data'], 'safe'],
            [['name', 'desc_name', 'desc_price_hour', 'desc_price_all'], 'string', 'max' => 254],
            [['id_courses'], 'exist', 'skipOnError' => true, 'targetClass' => Courses::className(), 'targetAttribute' => ['id_courses' => 'id']],
        ];
    }
    
    
    public function copySelectedRow($selection)
	{
		$result=false;				
		$model = CoursesGroup::findOne($selection);
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
            'desc_name' => Yii::t('app', 'Desc Name'),
            'id_courses' => Yii::t('app', 'Id Courses'),
            'price_hour' => Yii::t('app', 'Price Hour'),
            'desc_price_hour' => Yii::t('app', 'Desc Price Hour'),
            'price_all' => Yii::t('app', 'Price All'),
            'desc_price_all' => Yii::t('app', 'Desc Price All'),
            'data' => Yii::t('app', 'Data'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

	/**
	*  добавим метод возвращающий значение из поля name по связи hasOne, пригодится во вьюшках и грид вью
	*  раскомментируйте если надо 
	*/
	public function getIdCoursesName()
	{
		$IdCourses = $this->idCourses;
		return $IdCourses ? $IdCourses->name : '';
	
	}
	
	
	/**
	*  добавим метод возвращающий список имен со связи hasOne , пригодится при сортировке 
	*
	*/
	public function getIdCoursesList($type)
	{
			if($type)
			{
		    $IdCourses = Courses::find()
            ->select(['courses.id', 'courses.name'])
            ->leftJoin('courses_group','courses_group.id_courses=courses.id')
            ->where('courses_group.id is not null')
            ->all();
			}
			else
			{
		    $IdCourses =  Courses::find()
            ->select(['id', 'name'])
            ->distinct(true)
            ->all();

			}
			return ArrayHelper::map($IdCourses, 'id', 'name');
			
	}
	
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCourses()
    {
        return $this->hasOne(Courses::className(), ['id' => 'id_courses']);
    }

	/**
	*  добавим метод возвращающий значение из поля name по связи hasOne, пригодится во вьюшках и грид вью
	*  раскомментируйте если надо 
	*/
	/*
	public function getSchedsName()
	{
		$Scheds = $this->Scheds;
		return $Scheds ? $Scheds->name : '';
	
	}
	*/
	
	
	/**
	*  добавим метод возвращающий список имен со связи hasOne , пригодится при сортировке 
	*
	*/
	/*
	public function getSchedsList()
	{
			
		    $Scheds =  тут_имя_класса_модели::find()
            ->select(['id', 'name'])
            ->distinct(true)
            ->all();

			return ArrayHelper::map($Scheds, 'id', 'name');
			
	}
	*/
	
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheds()
    {
        return $this->hasMany(Sched::className(), ['id_courses_group' => 'id']);
    }


}
