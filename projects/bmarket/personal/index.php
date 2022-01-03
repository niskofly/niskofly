<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
global $USER;

if (!$USER->IsAuthorized())
    LocalRedirect('/auth/');

global $USER;
$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->Fetch();

$numberBonuses = BonusUser::getNumberBonuses();

$birthDay = $arUser['PERSONAL_BIRTHDAY'] ?
    preg_replace('/(\d{2}).(\d{2}).(\d{4})/', '$3-$2-$1', $arUser['PERSONAL_BIRTHDAY']) :
    '';
?>
<div class="page page--lk">
    <div class="section-header container">
        <div class="title">
            <?= $APPLICATION->ShowTitle(false) ?>
        </div>
    </div>
    <? include($_SERVER['DOCUMENT_ROOT'] . '/personal/includes/menu.php') ?>

    <div class="section-personal container">
        <div class="section-personal__wrapper">
            <div class="section-personal__points">
                <div class="section-personal__points-title">Ваши баллы</div>
                <div class="user-points">
                    <?= $numberBonuses ?>
                </div>
            </div>

            <form action="/api/personal/update-profile.php"
                  class="form form--personal-edit js-form-send">
                <?= bitrix_sessid_post() ?>
                <input type="hidden" name="ACTION" value="UPDATE_USER_INFO">
                <input type="hidden" name="USER_RESPONSE" value="Информация обновлена">
                <div class="form__title">Личные данные</div>
                <div class="input-groups">
                    <div class="input-group js-group-label">
                        <div class="input-group__wrapper">
                            <label class="input-group__label">Ваши ФИО</label>
                            <input name="NAME"
                                   type="text"
                                   required
                                   value="<?= $USER->GetFullName() ?>"
                                   class="input js-group-label__input">
                        </div>
                        <div class="input-group__error"></div>
                    </div>

                    <div class="input-group js-group-label">
                        <div class="input-group__wrapper">
                            <label class="input-group__label">Телефон</label>
                            <input type="tel"
                                   disabled="disabled"
                                   value="<?= AuthByPhoneSms::getFormattedPhone($arUser["PERSONAL_MOBILE"]) ?>"
                                   class="input js-group-label__input js-input-phone">
                        </div>
                        <div class="input-group__error"></div>
                    </div>

                    <div class="input-group js-group-label">
                        <div class="input-group__wrapper">
                            <label class="input-group__label">Эл. почта</label>
                            <input name="EMAIL"
                                   type="email"
                                   required
                                   value="<?= $USER->GetEmail() ?>"
                                   class="input js-group-label__input">
                        </div>
                        <div class="input-group__error"></div>
                    </div>

                    <div class="input-group js-group-label">
                        <div class="input-group__wrapper">
                            <label class="input-group__label">Дата рождения</label>
                            <input name="BIRTHDAY"
                                   type="date"
                                   value="<?= $birthDay ?>"
                                   class="input js-group-label__input">
                        </div>
                        <div class="input-group__error"></div>
                    </div>
                </div>
                <div class="form__actions">
                    <button type="submit" class="btn btn--transparent">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
