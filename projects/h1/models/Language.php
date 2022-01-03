<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "language".
 *
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property string $local
 * @property integer $default
 *
 * @property Page[] $pages
 */
class Language extends ActiveRecord
{
    static $current = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'language';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'alias', 'local'], 'required'],
            [['default'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['alias'], 'string', 'max' => 3],
            [['local'], 'string', 'max' => 6]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'alias' => 'Alias',
            'local' => 'Local',
            'default' => 'Default',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['language_id' => 'id']);
    }



    static function getCurrent()
    {
        if( self::$current === null ){
            self::$current = self::getDefaultLang();
        }
        return self::$current;
    }

    static function setCurrent($alias = null)
    {
        $language = self::getLangByUrl($alias);
        self::$current = ($language === null) ? self::getDefaultLang() : $language;
        Yii::$app->language = self::$current->local;
        
    }

    static function getDefaultLang()
    {
        $defaultLang = Language::find()->where('`default` = :default', [':default' => 1])->one();
        if($defaultLang) {
            return $defaultLang;
        } else {
            return Language::find()->one();
        }
    }

    static function getLangByUrl($alias = null)
    {
        if ($alias === null) {
            return null;
        } else {
            $language = Language::find()->where('alias = :alias', [':alias' => $alias])->one();
            if ( $language === null ) {
                return null;
            }else{
                return $language;
            }
        }
    }
}
