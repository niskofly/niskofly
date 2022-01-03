<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
/*
use app\models\CatalogSection;
use app\models\Service;
use app\models\Schedule;
*/
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $language_id
 * @property string $name
 * @property string $alias
 * @property string $before_content
 * @property string $content
 * @property integer $catalog_section_id
 * @property string $after_content
 * @property string $aside
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $created_at
 * @property string $updated_at
 * @property integer $active
 * @property boolean $show_feedback_form
 * @property integer $sort
 *
 * @property Language $language
 * @property Page $parent
 * @property Page[] $pages
 *
 *
 *
 */
class Page extends ActiveRecord
{
//    public function behaviors()
//    {
//        return [
//            TimestampBehavior::className(),
//        ];
//    }

    public $image;
    public $del_img;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('CURRENT_TIMESTAMP()'),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['language_id', 'name', 'alias', 'active'], 'required'],
            [['parent_id', 'catalog_section_id', 'language_id', 'active','sort'], 'integer'],
            [['before_content', 'content', 'after_content', 'aside'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['image'], 'image',  'extensions' => 'png,jpg,jpeg', 'skipOnEmpty' => true],
            [['del_img'], 'boolean'],
            [['name', 'alias'], 'string', 'max' => 128],
            [['block2_1_head','block2_2_head','block2_3_head','block3_head','block4_1_head','block4_2_head'],'string'],
            [['block2_1_desc','block2_2_desc','block2_3_desc','block4_1_desc','block4_2_desc','hrefs','h1'],'string'],
            [['meta_title', 'meta_description', 'meta_keywords'], 'string', 'max' => 256],
            [['show_feedback_form'], 'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'language_id' => 'Language',
            'name' => 'Name',
            'alias' => 'Alias',
            'filename' => 'Image',
            'image' => 'Upload image',
            'del_img' => 'Delete image',
            'before_content' => 'Before Content or new Page Block1',
            'content' => 'Content',
            'aside' => 'Aside',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'active' => 'Active',
            'show_feedback_form' => 'Show Feedback Form',
            'catalog_section_id' => 'Schedule',
            'after_content' => 'after content or Review head in new page',
            'h1'=>'H1',
            'sort' => 'Сортировка'

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getLanguageList()
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

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getParentName()
    {
	         $parent = $this->parent;
			 return $parent ? $parent->name : '';
    }

    public function getParent()
    {
        return $this->hasOne(Page::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getPageList()
    {
       $page = Page::find()
            ->select(['id', 'name'])
            ->where('id in (select parent_id from page)')
            ->all();

        return ArrayHelper::map($page, 'id', 'name');
    }

    public function getPages()
    {
        return $this->hasMany(Page::className(), ['parent_id' => 'id']);
    }

    static public function TreeMenu($categories, $language, $parent_id = 0, $alias = '', $current_level = 0, $level = 10)
    {
        $result = [];
        foreach ($categories as $category) {
            $current_level_locl = $current_level;
            if ($category['parent_id'] == $parent_id) {

                if ($current_level_locl < $level){
                    $current_level_locl++;
                    $child = self::TreeMenu($categories, $language, $category['id'], $alias . '/' . $category['alias'] , $current_level_locl, $level);

                    if (!empty($child)) {
                        $menu = [
                            'label' => $category['name'],
                            'url' => '/' . $language . $alias . '/' . $category['alias'],
//                        'url' => '#' ,
                            //    'dropDownOptions'=>['class'=>'dropdown-menu'],
                            'items' => $child
                        ];
                    } else {
                        $menu = [
                            'label' => $category['name'],
                            'url' => '/' . $language . $alias . '/' . $category['alias'],
//                        'items'=>['label'=>''],
                        ];
                    }
                    $result[] = $menu;
                }

            }
        }
        return $result;
    }

    static public function TreeArray($categories, $root = 0)
    {
        $result = [];
        foreach ($categories as $key => $category) {
            if ($category['parent_id'] == $root) {
                $category['parent_id'] = 0;
                $category['name_level'] = '- ' . $category['name'];
                $category['level'] = 0;
                $category['url'] = $category['alias'];

                $value = $category;

                unset($categories[$key]);
                $child = self::hasChild($category['id'], $categories, $level = '', $category['url'], 0);

                $result[$category['id']] = $value;
                if (!empty($child)) $result = $result + $child;
            }
        }
        return $result;
    }

    static private function hasChild($parent_id, $categories, $level = '', $url = '', $count = 0)
    {
        $result = [];
        $level .= '-- ';
        $count++;
        foreach ($categories as $key => $category) {
            if ($category['parent_id'] == $parent_id) {
                $category['name_level'] = $level . $category['name'];
                $category['level'] = $count;

                if (empty($category['url']))
                    $category['url'] = $url . '/' . $category['alias'];

                $value = $category;
                unset($categories[$key]);
                $child = self::hasChild($category['id'], $categories, $level, $category['url'], $count);

                $result[$category['id']] = $value;
                if (!empty($child)) $result = $result + $child;
            }
        }
        return $result;
    }


    public function copySelectedRow($selection)
	{
		$result=false;
		$model = Page::findOne($selection);
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




    static public function selected($page)
    {
        $result = [];
        foreach ($page as $key => $value) {
            $result[$key] = $value['name_level'];
        }
        return $result;
    }

    static public function setKeyUrl($array)
    {
        $result = [];
        foreach ($array as $value) {
            $result[$value['url']] = $value;
        }

        return $result;
    }

    public function getHomeLink()
    {
        $url = "/";
        $lang = Language::find()->where(
            'id = :id',
            [
                ':id' => $this->language_id
            ]
        )->one();
        if(isset($lang->alias)){
            $url .= $lang->alias;
        }
//        Yii::$app->homeUrl = $url;
        return $url;
    }

    public function getPath($this_link=False)
    {
        $path = array();
        $url = $this->getHomeLink();

        if(isset($this->parent_id)){
            $parent_id = $this->parent_id;
            do {
                $p = $this::find()->where(
                    'id = :id',
                    [
                        ':id' => $parent_id
                    ]
                )->one();
                array_unshift($path,
                    array(
                        'label' => $p->name,
                        'alias' => $p->alias
                    )
                );
                $parent_id = $p->parent_id;
            } while (isset($p->parent_id));
        }
        foreach ($path as $k => $p) {
            $url .= "/".$p['alias'];
            $path[$k]['url'] = $url;
        }

        if ($this_link) {
            $url .= "/".$this->alias;
            array_unshift($path, array(
                'label' => $this->name,
                'alias' => $this->alias,
                'url' => $url
            ));
        } else {
            $path[] = $this->name;
        }
        return $path;
    }

    public function getAbsoluteUrl() {
        $url = "";
        if(isset($this->parent_id)){
            $parent_id = $this->parent_id;
            do {
                $p = $this::find()->where(
                    'id = :id',
                    [
                        ':id' => $parent_id
                    ]
                )->one();
                $parent_id = $p->parent_id;
                $url = "/".$p->alias.$url;
            } while (isset($p->parent_id));
            $url .= "/" . $this->alias;
        }
        return $this->getHomeLink().$url;
    }

    public function getPageMainSection() {
        $type = '';
        $url = explode('/', trim(Yii::$app->request->url, '/'));
        if(isset($url[1])){
            $type = $url[1];
        }
        return $type;
    }

    public function getContentPreview() {
        $ct = strip_tags($this->content);
        $b = substr($ct, 0, 300);
        $t = substr($ct, 300);
        $s = strpos($t, " ");
        $vt = substr($t, 0, $s);
        return $b . $vt . "…";
    }

    public function getImageUrl()
    {
        if ($this->image_url) {
            return "/page/".$this->image_url;
        } else {
            return "";
        }
    }
   /*
    public function getPageReview($lang_id)
    {
	   $model=Review::find()
	   ->select(['name','text',"DATE_FORMAT(reviews.date,'%d.%m.%Y') as data"])
	   ->where(['page_id'=>$this->id,'language_id'=>$lang_id])
	   ->limit(3)
	   ->orderBy('id desc')
	   ->all();
	   return $model;
    }*/

    public function getCatalogSection()
    {
        if ($this->catalog_section_id) {
            $obj = CatalogSection::findOne($this->catalog_section_id);
            $r = array();
            $r['name'] = $obj->name;
            $r['title_service'] = $obj->getServiceTitle();
            $r['title_price'] = $obj->getPriceTitle();
            $r['services'] = [];
            $obServices = Service::find(['section' => $obj->id])->all();
            foreach($obServices as $srvObj){
                $r['services'][] = [
                    'name' => $srvObj->getName(),
                    'price' => $srvObj->price
                ];
            }
            return $r;
        } else {
            return null;
        }
    }


    public function getSched()
    {

        $data = null;
        if ($this->id) {
            $holyhopes = PageHolyhope::getHolyhopeListById($this->id);
            if (empty($holyhopes)) {
                $command = (new \yii\db\Query())
                    ->select(['courses.name as course_name', 'courses_group.name as group_name', 'sched.schedule', 'courses.week', 'courses.academic_hour', 'date_format(sched.start_date,"%d.%m.%Y") as start_date', 'courses_group.price_all', 'sched.id', '(if (sched.price_discount>0,sched.price_discount,if(sched.dynamicprice=1,
                            (
                            select
                             discount from dynamicPrice
                             where
                             daysBefore <= (to_days(sched.start_date)-to_days(now())) and active=1
                            order by daysBefore desc limit 1
                            
                            ),0)))
                            as `price_discount`'])
                    ->from('sched')
                    ->leftJoin('courses_group', 'courses_group.id=sched.id_courses_group')
                    ->leftJoin('courses', 'courses.id=courses_group.id_courses')
                    ->where('courses.id_page=' . $this->id . ' and public=1 and now() < date_add(sched.start_date,interval sched.archive day)')
                    ->orderBy(['sched.start_date' => SORT_ASC,])
                    ->createCommand();

                // show the SQL staecho $command->sql;
                // show the parameters to be bound
                //		print_r($command->params);

                // returns all rows of the query result
                $data = $command->queryAll();


                /*

                        $data=Sched::find()
                        ->select(['courses.name as course_name','courses_group.name as group_name','sched.schedule','concat_ws("",courses.week," weeks,",courses.academic_hour," a/h*") as duration','sched.start_date','courses_group.price_all'])
                //	    ->with('courses_group')
                        ->leftJoin('courses_group','courses_group.id=sched.id_courses_group')
                        ->leftJoin('courses','courses.id=courses_group.id_courses')
                        ->where('courses.id_page='.$this->id)
                        ->all();

                */

                return $data;
            } else {


    $request = [
        'types' => 'Group,MiniGroup',
        'dateFrom' => date('Y-m-d', strtotime('now') - 2),
        'queryDays' => "true",
        'queryFiscalInfo' => "true",
        'authkey' => 'w3yxL8yT5Tw5jJb4JerIdPX6XW7gvocgcq7MQuA0hBI2yhSFx2DM1UMHqPvVh5ln',
        'culture' => 'ru-RU',
    ];
    $schedule = [];
    include('../holyhope-api/holyhope-timetable.php');
    foreach ($Response["EdUnits"] as $holyhope) {
        if (in_array($holyhope['Id'], $holyhopes)) {
            $schedule[] = $holyhope;
        }
    }

    return $schedule;
    //die(var_dump($schedule));

}
}
    }
    public function getSchedAll(){
        $request = [
            'types' => 'Group,MiniGroup',
            'dateFrom' => date('Y-m-d', strtotime('now') - 2),
            'queryDays' => "true",
            'queryFiscalInfo' => "true",
            'authkey' => 'w3yxL8yT5Tw5jJb4JerIdPX6XW7gvocgcq7MQuA0hBI2yhSFx2DM1UMHqPvVh5ln',
            'culture' => 'ru-RU',
        ];
        $ids_current = PageHolyhope::getHolyhopeListAll();
        $schedule = [];

        include('../holyhope-api/holyhope-timetable.php');
        foreach ($Response["EdUnits"] as $holyhope) {
            
                if ( in_array($holyhope['Id'], $ids_current)){
                    $schedule[] = $holyhope;
                }

        }
        return $schedule;
    }

    public function getGroup()
    {
	    $data=null;
	    if ($this->id)
	    {
	    $data=CoursesGroup::find()
	    ->leftJoin('courses','courses.id=courses_group.id_courses')
		->where('courses.id_page='.$this->id)
		->all();
		}

		return $data;

    }

    public function getSchedule()
    {
        if ($this->catalog_section_id) {
            $obj = CatalogSection::findOne($this->catalog_section_id);
            $r = array();
            $obSchedule = Schedule::find(['section_id' => $obj->id])->all();
            foreach($obSchedule as $record) {
                $r[] = [
                    'id' => $record->id,
                    'level' => $record->getLevel(),
                    'start_dates' => $record->getStartDates(),
                    'schedule' => $record->getSchedule(),
                    'price' => $record->price
                ];
            }
            return $r;
        } else {
            return null;
        }
    }

    static function getAllPages(){
        return Page::find()->all();
    }


    public function getPageReviews()
   {
       return $this->hasMany(PageReviews::className(), ['page_id' => 'id']);
   }

   public function getItems()
   {
       return $this->hasMany(Review::className(), ['id' => 'review_id'])
           ->via('pageReviews');
   }

}
