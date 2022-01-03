<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "subscription".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $language
 */
class Subscription extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subscription';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'language'], 'required'],
            [['name', 'language'], 'string', 'max' => 64],
            ['email', 'email']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'Имя'),
            'email' => 'E-mail',
            'language' => Yii::t('app', 'Язык'),
        ];
    }

    public static function getLanguageChoices()
    {
        return [
            null => Yii::t('app', 'Выбор языка'),
            'en' => Yii::t('app', 'Английский'),
            'ru' => Yii::t('app', 'Русский')
        ];
    }

    public function sendRecord2MailChimp()
    {
        $apiKey = "8bfae446c6f07f7914f1da8fdde1fa91-us2";
        $listID = "c0d9a11641";

        $serverUrl = "https://us2.api.mailchimp.com/3.0/";
        $apiEndPoint = "lists/".$listID."/members";


        $names = explode(" ", $this->name);
        if(!isset($names[0])) $names[0] = "None";
        if(!isset($names[1])) $names[1] = "";
        $postData = array(
            "email_address" => $this->email,
            "status" => "subscribed",
            "merge_fields" => array(
                "LANG" => $this->language,
		        "FNAME" => $names[0],
                "LNAME" => $names[1]
            )
        );

        $process = curl_init($serverUrl.$apiEndPoint);
        curl_setopt($process, CURLOPT_USERPWD, "apikey:".$apiKey);
        curl_setopt($process, CURLOPT_POST, TRUE);
        curl_setopt($process, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        curl_exec($process);
        curl_close($process);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->sendRecord2MailChimp();
        parent::afterSave($insert, $changedAttributes);
    }
}
