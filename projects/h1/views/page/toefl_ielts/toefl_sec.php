<div class="toefl_cont w-container">
    <div class="head_span toefllogo w-clearfix" style="white-space: nowrap;">
        <div class="h1"><?= Yii::t('app', 'Что такое'); ?>
            <img class="toefl" src="/images/page/Screen-Shot-2017-02-03-at-01.46.45.png" width="158">?</div>
    </div>

    <div class="lead">
        <?= Yii::t('app', 'TOEFL – это экзамен, оценивающий Ваш уровень знаний в академическом английском языке. Тест состоит из комплексных заданий'); ?>:
    </div>

    <div class="toefl_slider_wr w-hidden-main w-hidden-medium w-hidden-small w-slider"
         data-animation="slide"
         data-duration="500" data-hide-arrows="1" data-infinite="1">

        <div class="w-slider-mask">
            <div class="toefl_slide w-slide">
                <?= $this->render("_toefl_listening"); ?>
            </div>

            <div class="toefl_slide w-slide">
                <?= $this->render("_toefl_speaking"); ?>
            </div>
            <div class="toefl_slide w-slide">
                <?= $this->render("_toefl_writing"); ?>
            </div>
        </div>

        <div class="toefl_slider_arrow w-slider-arrow-left">
            <div class="w-icon-slider-left"></div>
        </div>
        <div class="toefl_slider_arrow w-slider-arrow-right">
            <div class="w-icon-slider-right"></div>
        </div>
        <div class="toefl_slider_nav w-round w-slider-nav w-slider-nav-invert"></div>
    </div>

    <div class="toefl_row_wr w-row">
        <div class="toefl_row w-col w-col-4 w-hidden-tiny">
            <?= $this->render("_toefl_listening"); ?>
        </div>
        <div class="toefl_row w-col w-col-4">
            <?= $this->render("_toefl_speaking"); ?>
        </div>
        <div class="toefl_row w-col w-col-4">
            <?= $this->render("_toefl_writing"); ?>
        </div>
    </div>

    <a class="button w-button" href="#Fees"><span class="icon_cta"></span> <?= Yii::t('app', 'Цены на курсы'); ?></a>
    <a class="blue button gray_outline w-button" href="#schedule"><span class="icon_cta"></span> <?= Yii::t('app', 'Посмотреть расписание'); ?></a>

</div>