<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "sched".
 *
 * @property integer $id
 * @property string $schedule
 * @property integer $id_courses_group
 * @property string $start_date
 * @property integer $archive
 * @property integer $public
 * @property string $data
 * @property integer $user_id
 *
 * @property CoursesGroup $idCoursesGroup
 */
class Sched extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sched';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['schedule', 'id_courses_group', 'user_id','dynamicPrice'], 'required'],
            [['id_courses_group', 'archive', 'public', 'user_id','dynamicPrice'], 'integer'],
            [['start_date', 'data'], 'safe'],
            [['price_discount'], 'number'],            
            [['schedule'], 'string', 'max' => 254],
            ['archive', 'default', 'value' => 15],
            ['price_discount', 'default', 'value' => 0],
            [['id_courses_group'], 'exist', 'skipOnError' => true, 'targetClass' => CoursesGroup::className(), 'targetAttribute' => ['id_courses_group' => 'id']],
        ];
    }
    
    
    public function copySelectedRow($selection)
	{
		$result=false;				
		$model = Sched::findOne($selection);
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
            'schedule' => Yii::t('app', 'Schedule'),
            'id_courses_group' => Yii::t('app', 'Id Courses Group'),
            'start_date' => Yii::t('app', 'Дата начала'),
            'price_discount' => Yii::t('app', 'Цена со скидкой ( если 0, скидки нет)'),
            'archive' => Yii::t('app', 'Через сколько дней убирать с показа'),
            'public' => Yii::t('app', 'Опубликовать'),
            'data' => Yii::t('app', 'Data'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

	/**
	*  добавим метод возвращающий значение из поля name по связи hasOne, пригодится во вьюшках и грид вью
	*  раскомментируйте если надо 
	*/
	public function getIdCoursesGroupName()
	{
		$IdCoursesGroup = $this->idCoursesGroup;
		
		$name=CoursesGroup::find() 
            ->select(['concat_ws("-",page.name,courses.name,courses_group.name) as name'])
            ->leftJoin('sched','sched.id_courses_group=courses_group.id')
            ->leftJoin('courses','courses.id=courses_group.id_courses')
            ->leftJoin('page','page.id=courses.id_page')
            ->where('courses_group.id ='.$IdCoursesGroup->id)
            ->one();
		

		
		return $IdCoursesGroup ? $name->name : '';
	
	}
	
	
	/**
	*  добавим метод возвращающий список имен со связи hasOne , пригодится при сортировке 
	*
	*/
	public function getIdCoursesGroupList($type)
	{
			if ($type)
			{
		    $IdCoursesGroup = CoursesGroup::find()
            ->select(['courses_group.id', 'concat_ws("-",page.name,courses.name,courses_group.name) as name'])
            ->leftJoin('sched','sched.id_courses_group=courses_group.id')
            ->leftJoin('courses','courses.id=courses_group.id_courses')
            ->leftJoin('page','page.id=courses.id_page')
            ->where('sched.id is not null')
            ->all();
				
			}
			else
			{
		    $IdCoursesGroup =  CoursesGroup::find()
            ->select(['courses_group.id','concat_ws("-",page.name,courses.name,courses_group.name) as name'])
            ->leftJoin('courses','courses.id=courses_group.id_courses')
            ->leftJoin('page','page.id=courses.id_page')
            ->all();

			}
			return ArrayHelper::map($IdCoursesGroup, 'id', 'name');				
			
	}
	
	public function getLang()
	{
        $IdCoursesGroup = $this->idCoursesGroup;
        $idCourse=$IdCoursesGroup->idCourses;
        return $idCourse->LanguageName;

	}
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCoursesGroup()
    {
        return $this->hasOne(CoursesGroup::className(), ['id' => 'id_courses_group']);
    }


}
