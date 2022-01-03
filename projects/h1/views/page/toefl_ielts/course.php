<h2 class="fees h1"><?= Yii::t('app', 'Стоимость курсов'); ?></h2>

<div class="fees lead">
    <?= Yii::t('app', 'Представленные ниже цены распространняются на курсы по подготовке к  IELTS и TOEFL'); ?>
</div>


<div class="price toefl_slider_wr w-hidden-main w-hidden-medium w-hidden-small w-slider"
     data-animation="slide" data-duration="500" data-hide-arrows="1" data-infinite="1">
    <div class="w-slider-mask">

        <div class="price toefl_slide w-slide">
            <div class="price_div price_div_left slider" data-ix="show-modal-join">
                <?= $this->render("_toefl_group"); ?>
            </div>
        </div>

        <div class="price toefl_slide w-slide">
            <div class="price_div price_middle_div">
                <div class="price_div_head purple slider" data-ix="show-modal-join">
                    <?= $this->render("_toefl_small_group"); ?>
                </div>
            </div>
        </div>

        <div class="price toefl_slide w-slide">
            <div class="price_div price_div_right slider" data-ix="show-modal-join">
                <?= $this->render("_toefl_private_group"); ?>
            </div>
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


<div class="fees_row_wr w-row">
    <div class="fees_row w-col w-col-4 w-col-medium-4 w-col-small-4" data-ix="show-modal-join">
        <div class="price_div price_div_left w-preserve-3d" data-ix="price-left">
            <?= $this->render("_toefl_group"); ?>
        </div>
    </div>
    <div class="fees_row w-col w-col-4 w-col-medium-4 w-col-small-4" data-ix="show-modal-join">
        <div class="price_div price_middle_div">
            <?= $this->render("_toefl_small_group"); ?>
        </div>
    </div>
    <div class="fees_row w-col w-col-4 w-col-medium-4 w-col-small-4" data-ix="show-modal-join">
        <div class="price_div price_div_right w-preserve-3d" data-ix="price-right">
            <?= $this->render("_toefl_private_group"); ?>
        </div>
    </div>
</div>
<p style="clear: both;"></p>
<a class="button gray_outline red w-button" href="#schedule">
    <span class="icon_cta"></span> <?= Yii::t('app', 'Посмотреть расписание'); ?>
</a>