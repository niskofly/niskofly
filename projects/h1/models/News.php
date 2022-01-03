<?php
/**
 * Created by PhpStorm.
 * User: scriptosaur
 * Date: 06.11.15
 * Time: 12:42
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\StringHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $date
 * @property string $name
 * @property string $name_ru
 * @property string $name_en
 * @property string $announce
 * @property string $announce_ru
 * @property string $announce_en
 * @property string $text
 * @property string $text_ru
 * @property string $text_en
 * @property string $image
 * @property string $filename
 */
/**
 * @var UploadedFile image attribute
 */
class News extends ActiveRecord
{
    public $image;
    public $del_img;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'name_ru', 'name_en', 'text_ru', 'text_en'], 'required'],
            [['date', 'image'], 'safe'],
            [['image'], 'image',  'extensions' => 'png,jpg,jpeg', 'skipOnEmpty' => true],
            [['del_img'], 'boolean'],
            [['name', 'name_ru', 'name_en'], 'string', 'max' => 256],
            [['announce', 'announce_ru', 'announce_en'], 'string', 'max' => 2048],
            [['text', 'text_ru', 'text_en'], 'string', 'max' => 65535],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }


    public function upload()
    {
        if ($this->validate()) {
            $this->image->saveAs('news/' . $this->image->baseName . '.' . $this->image->extension);
            $this->image = $this->image->baseName . '.' . $this->image->extension;
            return true;
        } else {
            return false;
        }
    }

    public function getImageUrl()
    {
        if ($this->filename) {
            return "/news/".$this->filename;
        } else {
            return "";
        }
    }

    public function getThumbUrl()
    {
        if ($this->filename) {
            return "/news/thumbs/".$this->filename;
        } else {
            return "";
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => Yii::t('app', 'Дата'),
            'filename' => Yii::t('app', 'Картинка'),
            'image' => Yii::t('app', 'Загрузить картинку'),
            'del_img' => Yii::t('app', 'Удалить картинку'),
            'name' => Yii::t('app', 'Заголовок'),
            'name_ru' => Yii::t('app', 'Заголовок'),
            'name_en' => Yii::t('app', 'Заголовок'),
            'announce' => Yii::t('app', 'Анонс'),
            'announce_ru' => Yii::t('app', 'Анонс'),
            'announce_en' => Yii::t('app', 'Анонс'),
            'text' => Yii::t('app', 'Текст'),
            'text_ru' => Yii::t('app', 'Текст'),
            'text_en' => Yii::t('app', 'Текст'),
        ];
    }

    public function getName()
    {
        $lang = Language::getCurrent();
        return trim($this->getAttribute("name_".$lang->alias));
    }

    public function getAnnounce($strict=false)
    {
        $lang = Language::getCurrent();
        $announce = trim($this->getAttribute("announce_".$lang->alias));
        if ($strict || strlen($announce) > 0) {
            return $announce;
        } else {
            return StringHelper::truncateWords($this->getText(), 20, '…');
        }
    }

    public function getText()
    {
        $lang = Language::getCurrent();
        return trim($this->getAttribute("text_".$lang->alias));
    }

}
