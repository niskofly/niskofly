<?php
/**
 * main.php - new.headin.pro
 * Initial version by: BeforyDeath
 * Initial version created on: 14.08.15 11:40
 */

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\widgets\LanguageWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"><?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title><?php $this->head() ?>

    <!--[if lt IE 9]>
    <!--<script src="js/html5shiv.js"></script>--><!--<script src="js/respond.min.js"></script>--><![endif]-->
</head>
<body>
<?php $this->beginBody() ?>
<section class="conf">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?= LanguageWidget::widget(); ?>
                <ul class="signjoin text-right">
                    <li class="signin">
                        <a href="<?= Url::toRoute('/user/settings/profile') ?>"><?= Yii::$app->user->identity->username ?></a>
                    </li>
                    <li class="join">
                        <a data-method="post" href="<?= Url::toRoute('/user/security/logout') ?>"><?= Yii::t('app', 'Выход') ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>


<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#top-menu">
                <span class="sr-only">Открыть навигацию</span> <span class="icon-bar"></span>
                <span class="icon-bar"></span> <span class="icon-bar"></span>
            </button>
            <a href="/" class="navbar-brand" style="font-size: 24px; color: #fefefe;"><img src="/images/home.png" alt=""></a>
        </div>
        <div class="collapse navbar-collapse" id="top-menu">
            <ul class="nav navbar-nav">
                <li><a href="<?= Url::toRoute('/dashboard') ?>"><?= Yii::t('app', 'Панель управления') ?></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <?= Yii::t('app', 'Тесты') ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= Url::toRoute('/dashboard/test') ?>"><?= Yii::t('app', 'Список тестов') ?></a></li>
                        <li><a href="<?= Url::toRoute('/dashboard/testquestion') ?>"><?= Yii::t('app', 'Вопросы') ?></a></li>
                        <li><a href="<?= Url::toRoute('/dashboard/testanswer') ?>"><?= Yii::t('app', 'Ответы на вопросы') ?></a></li>
                        <li><a href="<?= Url::toRoute('/dashboard/testlogic') ?>"><?= Yii::t('app', 'Логика тестов') ?></a></li>
                        <li><a href="<?= Url::toRoute('/dashboard/test-level-name') ?>"><?= Yii::t('app', 'Уровни теста') ?></a></li>

                    </ul>
                </li>
                <li><a href="<?= Url::toRoute('/dashboard/news') ?>"><?= Yii::t('app', 'Новости') ?></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <?= Yii::t('app', 'Каталог услуг') ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
<!--
                        <li><a href="<?= Url::toRoute('/dashboard/catalogsection') ?>"><?= Yii::t('app', 'Разделы') ?></a></li>
                        <li><a href="<?= Url::toRoute('/dashboard/service') ?>"><?= Yii::t('app', 'Уровни') ?></a></li>
                        <li><a href="<?= Url::toRoute('/dashboard/schedule') ?>"><?= Yii::t('app', 'Расписание') ?></a></li>
-->
                        <li><a href="<?= Url::toRoute('/dashboard/page-holyhope') ?>"><?= Yii::t('app', 'Расписание holyhope') ?></a></li>

                        <li><a href="<?= Url::toRoute('/dashboard/courses') ?>"><?= Yii::t('app', ' Курсы') ?></a></li>
                        <li><a href="<?= Url::toRoute('/dashboard/courses-full') ?>"><?= Yii::t('app', ' Курсы заполнение') ?></a></li>
                        <li><a href="<?= Url::toRoute('/dashboard/coursesgroup') ?>"><?= Yii::t('app', 'Группы для курсов') ?></a></li>
                        <li><a href="<?= Url::toRoute('/dashboard/sched') ?>"><?= Yii::t('app', 'Расписание') ?></a></li>
                        <li><a href="<?= Url::toRoute('/dashboard/orders') ?>"><?= Yii::t('app', 'Заказы') ?></a></li>
                        <li><a href="<?= Url::toRoute('/dashboard/dynamicprice') ?>"><?= Yii::t('app', 'Динамические скидки') ?></a></li>
                        <li><a href="<?= Url::toRoute('/dashboard/autopay') ?>"><?= Yii::t('app', 'Автоплатежи') ?></a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <?= Yii::t('app', 'Обратная связь') ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= Url::toRoute('/dashboard/subscriptions') ?>"><?= Yii::t('app', 'Подписки') ?></a></li>
                        <li><a href="<?= Url::toRoute('/dashboard/feedback') ?>"><?= Yii::t('app', 'Обратная связь') ?></a></li>
                        <li><a href="<?= Url::toRoute('/dashboard/review') ?>"><?= Yii::t('app', 'Отзывы') ?></a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <?= Yii::t('app', 'Администрирование') ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= Url::toRoute('/dashboard/page') ?>"><?= Yii::t('app', 'Страницы') ?></a></li>
                        <li><a href="<?= Url::toRoute('/dashboard/language') ?>"><?= Yii::t('app', 'Языки') ?></a></li>
                        <li><a href="<?= Url::toRoute('/user/admin') ?>"><?= Yii::t('app', 'Пользователи') ?></a></li>
                        <li><a href="<?= Url::toRoute('/dashboard/log') ?>"><?= Yii::t('app', 'Логи') ?></a></li>
                        <li><a href="<?= Url::toRoute('/dashboard/landing-slider') ?>"><?= Yii::t('app', 'Школы слайдер') ?></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]) ?>
                <?= $content ?>
            </div>
        </div>
    </div>
</section>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
