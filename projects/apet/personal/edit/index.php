<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Личные данные");
$APPLICATION->SetPageProperty("title", "Личные данные");

global $USER;
if (!$USER->IsAuthorized())
  LocalRedirect('/user/authorization/');

$user = CUser::GetByID($USER->GetID())->Fetch();

?>

  <div class="page page--lk-orders">
    <div class="container">

      <!-- Add breadcrumb -->
      <? $APPLICATION->IncludeComponent(
        "bitrix:breadcrumb",
        ".default",
        array()
      ); ?>

      <div class="page__title title">
        <h1 class="seo-title">
          <? $APPLICATION->ShowTitle(false); ?>
        </h1>
      </div>

      <div class="lk-sides">

        <!-- include left side bar -->
        <? include($_SERVER["DOCUMENT_ROOT"] . "/personal/parts/lk-links.php"); ?>

        <div class="lk-content">
          <div class="lk-personal">

            <div class="lk-personal__title lk-content__title">Личные данные</div>

            <?
            $photoId = $user['PERSONAL_PHOTO'];
            $photoSrc = $photoId ? CFile::GetPath($photoId) : '/img/test_image.jpg';
            $label = $photoId ? "Изменить фото" : "Добавить фото"
            ?>

            <form action="/api/user/controller-editUser.php" class="js-update-photo-form">
              <input type="hidden" name="ACTION" value="UPDATE_USER_PHOTO">
              <input type="hidden" name="OLD_USER_PHOTO" value="<?= $photoId ?>">
              <?= bitrix_sessid_post() ?>
              <label class="lk-personal__avatar">
                <input type="file" name="USER_PHOTO" style="display: none"><!-- todo: Занести в sass -->
                <span class="lk-personal__avatar-img">
                                    <img src="<?= $photoSrc ?>" class="js-update-photo-image">
                                </span>
                <span class="lk-personal__avatar-action link link--bold"><?= $label ?></span>
              </label>
            </form>

            <form action="/api/user/controller-editUser.php"
                  class="lk-personal__form form-default js-form-send">
              <?= bitrix_sessid_post() ?>
              <input type="hidden"
                     name="ACTION"
                     value="EDIT_USER_INFO">
              <input type="hidden"
                     name="USER_RESPONSE"
                     value="Ваш вопрос успешно отправлен.">
              <div data-input-group="name" class="input-group">
                <input name="NAME" type="text"
                       value="<?= $user['NAME'] . ' ' . $user['LAST_NAME'] . ' ' . $user['SECOND_NAME'] ?>"
                       placeholder="ФИО*"
                       required
                       class="input input--white">
                <div class="input-group__error"></div>
              </div>
              <div class="form-default__row">
                <div class="form-default__column">
                  <div data-input-group="phone" class="input-group">
                    <input type="tel"
                           placeholder="Телефон*"
                           value="<?= $user['PERSONAL_MOBILE'] ?>"
                           required
                           class="input js-input-phone input--white"
                           disabled>
                    <div class="input-group__error"></div>
                  </div>
                </div>
                <div class="form-default__column">
                  <div data-input-group="name" class="input-group">
                    <input name="EMAIL"
                           type="text"
                           value="<?= $user['EMAIL'] ?>"
                           placeholder="Email"
                           required class="input input--white">
                    <div class="input-group__error"></div>
                  </div>
                </div>
              </div>
              <div class="lk-personal__form-submit">
                <button class="btn" type="submit">Сохранить</button>
              </div>
            </form>

            <div class="lk-personal__title lk-content__title">Смена пароля</div>

            <form action="/api/user/controller-editUser.php"
                  class="lk-personal__form form-default js-form-send-code">
              <?= bitrix_sessid_post() ?>
              <input type="hidden"
                     name="ACTION"
                     value="EDIT_USER_PASSWORD">
              <input type="hidden"
                     name="method"
                     value="send_code">
              <input type="hidden"
                     name="USER_RESPONSE"
                     value="Ваш вопрос успешно отправлен.">
              <div class="form-default__row">
                <div class="form-default__column">
                  <div data-input-group="phone" class="input-group">
                    <input name="PASSWORD"
                           type="password"
                           placeholder="Новый пароль"
                           required
                           class="input input--white js-user-password">
                    <div class="input-group__error"></div>
                  </div>
                </div>
                <div class="form-default__column">
                  <div data-input-group="name" class="input-group">
                    <input name="PASSWORD_REPEAT"
                           type="password"
                           placeholder="Подтвердите пароль"
                           required
                           class="input input--white">
                    <div class="input-group__error"></div>
                  </div>
                </div>
              </div>
              <div class="lk-personal__form-submit">
                <button type="submit" class="btn js-btn-save-new-password">Сохранить изменения</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Подключение блока bullets из parts -->
    <? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/all-pages/footer-bullets.php") ?>
  </div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
