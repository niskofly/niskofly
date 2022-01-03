<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "landing_slider".
 *
 * @property int $id
 * @property string $img
 * @property string $href
 * @property int $sort
 */
class LandingSlider extends \yii\db\ActiveRecord
{
    public $image;
    public $del_img;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'landing_slider';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['href'], 'required'],
            [['sort'], 'integer'],
            [['href'], 'string', 'max' => 255],
            [['image'], 'image',  'extensions' => 'png,jpg,jpeg', 'skipOnEmpty' => true],
            [['del_img'], 'boolean'],
            [['image'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'img' => 'Img',
            'href' => 'Ссылка',
            'sort' => 'Сортировка',

            'filename' => Yii::t('app', 'Картинка'),
            'image' => Yii::t('app', 'Загрузить картинку'),
            'del_img' => Yii::t('app', 'Удалить картинку'),
        ];
    }


    public function getImageUrl()
    {
        if ($this->img) {
            return "/slider/".$this->img;
        } else {
            return "";
        }
    }

    public function getThumbUrl()
    {
        if ($this->img) {
            return "/slider/thumbs/".$this->img;
        } else {
            return "";
        }
    }
    public function upload()
    {
        if ($this->validate()) {
            $this->image->saveAs('slider/' . $this->image->baseName . '.' . $this->image->extension);
            $this->image = $this->image->baseName . '.' . $this->image->extension;
            return true;
        } else {
            return false;
        }
    }
}
