<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$frame = $this->createFrame()->begin("");
if (!empty($arResult["BANNERS"])):
    ?>
    <div class="section-intro container">
        <div data-slider-id="intro" class="swiper-container slider-intro js-slider">
            <div class="swiper-wrapper">
                <? foreach ($arResult["BANNERS"] as $content) : ?>
                    <div class="swiper-slide slider-intro__slide">
                        <?= $content ?>
                    </div>
                <? endforeach; ?>
            </div>
            <div class="section-intro__pagination">
                <div class="slider-pagination slider-pagination--intro"></div>
            </div>
        </div>
        <div class="slider-controls">
            <button type="button" class="slider-control slider-control--prev js-slider-prev">
                <svg class="icon icon-arrow-l ">
                    <use xlink:href="#arrow-l"></use>
                </svg>
            </button>
            <button type="button" class="slider-control slider-control--next js-slider-next">
                <svg class="icon icon-arrow-r ">
                    <use xlink:href="#arrow-r"></use>
                </svg>
            </button>
        </div>
    </div>

    <script>
        window.initSliders()
    </script>
<? endif;
$frame->end();
