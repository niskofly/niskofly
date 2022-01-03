<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'js/fancybox/source/jquery.fancybox.css',
        'css/style.css',
    ];
    public $js = [
        'js/jquery.raty.js',
        'js/fancybox/source/jquery.fancybox.pack.js',

        'js/jquery.inputmask.min.js',
        'js/jquery.inputmask-multi.min.js',
        'js/script.js',
        'js/autopay.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
