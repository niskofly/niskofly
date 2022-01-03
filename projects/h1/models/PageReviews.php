<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "page_reviews".
 *
 * @property int $review_id
 * @property int $page_id
 *
 * @property Page $page
 * @property Review $review
 */
class PageReviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page_reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['review_id', 'page_id'], 'required'],
            [['review_id', 'page_id'], 'integer'],
            [['review_id', 'page_id'], 'unique', 'targetAttribute' => ['review_id', 'page_id']],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
            [['review_id'], 'exist', 'skipOnError' => true, 'targetClass' => Review::className(), 'targetAttribute' => ['review_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'review_id' => 'Review ID',
            'page_id' => 'Page ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReview()
    {
        return $this->hasOne(Review::className(), ['id' => 'review_id']);
    }

    /**
     * @return bool
     */
    static function setPageReviews($pages, $review_id)
    {
        PageReviews::deleteAll(['review_id' => $review_id]);
        if ($pages != '') {
            $transaction = Yii::$app->db->beginTransaction();
            foreach ($pages as $page_id) {
                $pageReviews = new PageReviews();
                $pageReviews->page_id = $page_id;
                $pageReviews->review_id = $review_id;

                if (!$pageReviews->save()) {
                    $transaction->rollBack();
                    return false;
                }
            }
            $transaction->commit();
        }
        return true;
    }


    static function getAllPageReviews($review_id){
        $pageReviews = PageReviews::find()->select('page_id')->where(['review_id' => $review_id])->asArray()->all();
        $result = [];
        foreach ($pageReviews as $pageReview){
            $result[] = $pageReview['page_id'];
        }
        return $result;
    }

}
