<div class="widget-reviews">
    <div class="title_bold">
        Отзывы наших клиентов
    </div>
    <div class="b-slider-controll">
        <button data-slider="reviews_slider" class="b-slidercontroll__btn_prev js-prev-banner">
            <svg class="icon icon-31 ">
                <use xlink:href="#31"></use>
            </svg>
        </button>
        <button data-slider="reviews_slider" class="b-slidercontroll__btn_next js-next-banner">
            <svg class="icon icon-32 ">
                <use xlink:href="#32"></use>
            </svg>
        </button>
    </div>
    <div class="b-slider reviews-slider js-popup-gallery--dark">
        <div class="b-slider__content  js-b-reviews-content ">

            @foreach($reviews as $review)
                <div class="b-slider__item">
                    <div class="reviews-card">
                        <div class="reviews-card__left">
                            <div class="reviews-card__name">
                                <img src="{{asset('/img/reviews-chat.png')}}" alt="">
                                {{$review->author}}
                            </div>
                            <div class="reviews-card__company">
                                {{$review->company}}
                            </div>
                            <div class="reviews-card__curt">
                                {{str_limit($review->curt_text, 98)}}
                            </div>
                        </div>
                        <div class="reviews-card__right">
                            <a href="{{asset($review->file)}}" class="reviews-card__show js-popup-photo">
                                <img src="{{asset('/img/reviews-show-full.svg')}}" alt="">
                                <span>Смотреть весь отзыв ›
                            </span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>