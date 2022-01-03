<div class="product-consultation">
    <div class="product-consultation__info">
        <div class="product-consultation__title">
            Нужна консультация?
        </div>
        <div class="product-consultation__desc">
            Перезвоним и проконсультируем
        </div>
    </div>
    <div class="product-consultation__sender">
        <form class="product-consultation__form js-product-consultation-form" onsubmit="yaCounter42853119.reachGoal('otpravka_form_konsyltacia');">
            <input type="hidden" name="product" value="{{$Product->name}}">
            <input type="hidden" name="product-id" value="{{$Product->id}}">
            {{ csrf_field() }}
            <input type="text" placeholder="Ваш e-mail / телефон" name="phone" class="input required-input" required>
            <button class='btn btn-blue'>Оставить заявку</button>
        </form>
        <div class="privacy-policy-prompt">
            Согласен
            <a href="/privacy-policy" target="_blank">
                на обработкуперсональных данных
            </a>
        </div>
    </div>
</div>