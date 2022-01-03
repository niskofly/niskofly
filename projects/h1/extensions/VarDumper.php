<?php

/**
 * VarDumper.php - GSN
 * Initial version by: BeforyDeath
 * Initial version created on: 03.11.14 2:39
 */

namespace app\extensions;

class VarDumper
{
    public static function dump($data)
    {
        \yii\helpers\VarDumper::dump($data, 10, true);
    }
}