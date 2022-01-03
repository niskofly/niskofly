<div class="b-select-equipment">
    <div class="title_light">Подберем для Вас комплект оборудования и отправим прайс-лист</div>
    <form class="form-select-equipment  js-send-price">
        {{ csrf_field() }}
        <div class="wrap-inputs">
            <div class="line-input-two">
                <input type="email" placeholder="E-mail" name="email" class="input required-input" required>
                <input type="tel" placeholder="Телефон" name="phone" class="input required-input" required>
            </div>
            <textarea placeholder="Комментарий" name="comment" class="textarea input"></textarea>
        </div>
        <button class='btn-blue' style="cursor: pointer;">Получить прайс</button>
    </form>
    <div class="privacy-policy-prompt">Согласен <a href="/privacy-policy" target="_blank">на обработку
            персональных данных</a></div>
</div>
