<?php
/**
 * AccessRuleUser.php - new.headin.pro
 * Initial version by: BeforyDeath
 * Initial version created on: 15.08.15 15:08
 */

namespace app\filters;

use Yii;
use yii\filters\AccessRule;

class AccessRuleUser extends AccessRule
{

    /** @inheritdoc */
    protected function matchRole($user)
    {
        if (empty($this->roles)) {
            return true;
        }

        foreach ($this->roles as $role) {
            if ($role === '?') {
                if (Yii::$app->user->isGuest) {
                    return true;
                }
            } elseif ($role === '@') {
                if (!Yii::$app->user->isGuest) {
                    return true;
                }
            } elseif ($role === 'admin') {
                if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin) {
                    return true;
                }
            }
        }

        return false;
    }
}