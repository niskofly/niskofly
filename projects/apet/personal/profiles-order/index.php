<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Профили заказа");
$APPLICATION->SetPageProperty("title", "Профили заказа");

global $USER;
if (!$USER->IsAuthorized())
  LocalRedirect('/user/authorization/');
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

      <!-- get user profiles data -->
      <? $userProfiles = new UserOrderProfiles(); ?>

      <div class="lk-content">
        <div class="lk-profile">
          <div class="lk-profile__list js-profile-list">
            <? if ($userProfiles->getProfiles()): ?>
              <div class="lk-profile__head">
                <!-- Name profile -->
                <div class="lk-profile__title lk-content__title">профили заказов</div>
              </div>
              <? foreach ($userProfiles->getProfiles() as $userProfileId => $userProfile): ?>
                <? if ($userProfile['PROFILE_INFO']['PERSON_TYPE_ID'] == 1): ?>
                  <button
                    type="button"
                    class="lk-profile__open js-profile-open"
                    data-section=".js-profile-<?= $userProfile["PROFILE_INFO"]["ID"] ?>">
                    <span><?= $userProfile["PROFILE_INFO"]["NAME"] ?></span>
                    <span class="lk-arrow">
																	<svg class="icon icon-right ">
																		<use xlink:href="#right"></use>
																	</svg>
																</span></button>
                <? else: ?>
                  <button
                    type="button"
                    class="lk-profile__open js-profile-open"
                    data-section=".js-profile-<?= $userProfile["PROFILE_INFO"]["ID"] ?>">
                    <span><?= $userProfile["PROFILE_INFO"]["NAME"] ?></span>
                    <span class="lk-arrow">
																	<svg class="icon icon-right ">
																		<use xlink:href="#right"></use>
																	</svg>
																</span></button>
                <? endif; ?>
              <? endforeach; ?>
            <? else: ?>
              <div class="lk-profile__head">
                <div class="lk-profile__title lk-content__title">Профиль отсутствует:(</div>
              </div>
            <? endif; ?>
          </div>
          <? if ($userProfiles->getProfiles()): ?>
            <? foreach ($userProfiles->getProfiles() as $userProfileId => $userProfile): ?>
              <? if ($userProfile['PROFILE_INFO']['PERSON_TYPE_ID'] == 1): ?>
                <div class="lk-profile__section js-profile-<?= $userProfile["PROFILE_INFO"]["ID"] ?>">

                  <div class="lk-profile__head">
                    <button
                      type="button"
                      class="lk-arrow lk-profile__back js-profile-close"
                      data-section=".js-profile-<?= $userProfile["PROFILE_INFO"]["ID"] ?>">
                      <svg class="icon icon-left ">
                        <use xlink:href="#left"></use>
                      </svg>
                    </button>
                    <!-- Name profile -->
                    <div class="lk-profile__title lk-content__title"><?= $userProfile["PROFILE_INFO"]["NAME"] ?></div>
                    <!-- Button is delete profile -->
                    <form action="/api/user/controller-profiles.php"
                          class="js-form-sender lk-profile__form-remove">
                      <?= bitrix_sessid_post() ?>
                      <input type="hidden"
                             name="ACTION"
                             value="DELETE">
                      <input type="hidden"
                             name="PROFILE_ID"
                             value="<?= $userProfile["PROFILE_INFO"]["ID"] ?>">
                      <button type="submit" class="lk-profile__delete link link--bold">Удалить
                        профиль
                      </button>
                    </form>
                  </div>

                  <!-- Main input blocks -->
                  <form action="/api/user/controller-profiles.php"
                        class="lk-profile__form form-default js-form-send js-profile-form-send">
                    <?= bitrix_sessid_post() ?>
                    <input type="hidden"
                           name="ACTION"
                           value="UPDATE">
                    <input type="hidden"
                           name="PROFILE_ID"
                           value="<?= $userProfile["PROFILE_INFO"]["ID"] ?>">
                    <!-- Name input block -->
                    <div data-input-group="name" class="input-group js-profile-input-group">
                      <input name="PROPERTIES[1]"
                             value="<?= $userProfile["PROFILE_VALUE"]["FIO"]["VALUE"] ?>"
                             type="text"
                             placeholder="ФИО*"
                             required
                             class="input input--white">
                      <div class="input-group__error"></div>
                    </div>

                    <div class="form-default__row">
                      <div class="form-default__column">
                        <!-- Phone input block -->
                        <div data-input-group="phone"
                             class="input-group js-profile-input-group">
                          <input name="PROPERTIES[2]"
                                 type="tel"
                                 value="<?= $userProfile["PROFILE_VALUE"]["PHONE"]["VALUE"] ?>"
                                 placeholder="Телефон*"
                                 required
                                 class="input js-input-phone input--white">
                          <div class="input-group__error"></div>
                        </div>
                      </div>
                      <div class="form-default__column">
                        <!-- Email input block -->
                        <div data-input-group="name" class="input-group">
                          <input name="PROPERTIES[3]"
                                 type="text"
                                 value="<?= $userProfile["PROFILE_VALUE"]["EMAIL"]["VALUE"] ?>"
                                 placeholder="Email" required class="input input--white">
                          <div class="input-group__error"></div>
                        </div>
                      </div>
                    </div>
                    <!-- Address input block -->
                    <div data-input-group="name" class="input-group">
                      <input name="PROPERTIES[4]"
                             type="text"
                             value="<?= $userProfile["PROFILE_VALUE"]["ADDRESS"]["VALUE"] ?>"
                             placeholder="Адрес доставки"
                             required
                             class="input input--white">
                      <div class="input-group__error"></div>
                    </div>
                    <!-- CheckBox input block -->
                    <div class="form-default__send lk-profile__form-sender">
                      <div class="form-default__consent">
                        <label class="checkbox">
                          <input name="consent"
                                 type="checkbox"
                                 value="Y"
                                 checked
                                 class="js-form-consent">
                          <span class="checkbox__indicator">
																				<svg class="icon icon-check ">
																					<use xlink:href="#check"></use>
																				</svg>
																			</span>
                          <span class="checkbox__description">Согласен на обработку
																					<a href="#" target="_blank"
                                             class="link"> персональных данных</a>
																			</span>
                        </label>
                      </div>
                      <button type="submit" class="btn"><span>Сохранить изменения</span>
                      </button>
                    </div>
                  </form>
                </div>
              <? else: ?>
                <div class="lk-profile__section js-profile-<?= $userProfile["PROFILE_INFO"]["ID"] ?>">

                  <div class="lk-profile__head">
                    <button
                      type="button"
                      class="lk-arrow lk-profile__back js-profile-close"
                      data-section=".js-profile-<?= $userProfile["PROFILE_INFO"]["ID"] ?>">
                      <svg class="icon icon-left ">
                        <use xlink:href="#left"></use>
                      </svg>
                    </button>
                    <div class="lk-content__title"><?= $userProfile["PROFILE_INFO"]["NAME"] ?></div>
                    <form action="/api/user/controller-profiles.php"
                          class="js-form-sender lk-profile__form-remove">
                      <?= bitrix_sessid_post() ?>
                      <input type="hidden"
                             name="ACTION"
                             value="DELETE">
                      <input type="hidden"
                             name="PROFILE_ID"
                             value="<?= $userProfile["PROFILE_INFO"]["ID"] ?>">
                      <button type="submit" class="lk-profile__delete link link--bold">
                        Удалить профиль
                      </button>
                    </form>
                  </div>

                  <form
                    action="/api/user/controller-profiles.php"
                    class="lk-profile__form form-default js-form-send js-profile-form-send">
                    <?= bitrix_sessid_post() ?>
                    <input
                      type="hidden"
                      name="ACTION"
                      value="UPDATE">
                    <input
                      type="hidden"
                      name="PROFILE_ID"
                      value="<?= $userProfile["PROFILE_INFO"]["ID"] ?>">
                    <div class="lk-profile__form-wrapper">
                      <div data-input-group="name" class="input-group">
                        <input name="PROPERTIES[5]"
                               type="text"
                               value="<?= $userProfile["PROFILE_VALUE"]["FIO"]["VALUE"] ?>"
                               placeholder="ФИО*"
                               required
                               class="input input--white">
                        <div class="input-group__error"></div>
                      </div>
                      <div class="form-default__row">
                        <div class="form-default__column">
                          <div data-input-group="phone" class="input-group">
                            <input name="PROPERTIES[6]"
                                   type="tel"
                                   placeholder="Телефон*"
                                   value="<?= $userProfile["PROFILE_VALUE"]["PHONE"]["VALUE"] ?>"
                                   required
                                   class="input js-input-phone input--white">
                            <div class="input-group__error"></div>
                          </div>
                        </div>
                        <div class="form-default__column">
                          <div data-input-group="name" class="input-group">
                            <input name="PROPERTIES[7]"
                                   type="text"
                                   value="<?= $userProfile["PROFILE_VALUE"]["EMAIL"]["VALUE"] ?>"
                                   placeholder="Email"
                                   required
                                   class="input input--white">
                            <div class="input-group__error"></div>
                          </div>
                        </div>
                      </div>
                      <div data-input-group="name" class="input-group">
                        <input name="PROPERTIES[8]"
                               type="text"
                               value="<?= $userProfile["PROFILE_VALUE"]["NAME-ORGANIZATION"]["VALUE"] ?>"
                               placeholder="Название организации"
                               required class="input input--white">
                        <div class="input-group__error"></div>
                      </div>
                      <div class="form-default__row">
                        <div class="form-default__column">
                          <div data-input-group="phone" class="input-group">
                            <input name="PROPERTIES[9]"
                                   type="text"
                                   placeholder="ИНН"
                                   value="<?= $userProfile["PROFILE_VALUE"]["INN"]["VALUE"] ?>"
                                   required
                                   class="input input--white">
                            <div class="input-group__error"></div>
                          </div>
                        </div>
                        <div class="form-default__column">
                          <div data-input-group="name" class="input-group">
                            <input name="PROPERTIES[10]"
                                   type="text"
                                   value="<?= $userProfile["PROFILE_VALUE"]["KPP"]["VALUE"] ?>"
                                   placeholder="КПП"
                                   required
                                   class="input input--white">
                            <div class="input-group__error"></div>
                          </div>
                        </div>
                      </div>
                      <div data-input-group="name" class="input-group">
                        <input name="PROPERTIES[11]"
                               type="text"
                               value="<?= $userProfile["PROFILE_VALUE"]["LEGAL-ADDRESS"]["VALUE"] ?>"
                               placeholder="Юридический адрес"
                               required
                               class="input input--white">
                        <div class="input-group__error"></div>
                      </div>
                      <div class="form-default__row">
                        <div class="form-default__column">
                          <div data-input-group="phone" class="input-group">
                            <input name="PROPERTIES[12]"
                                   type="text"
                                   placeholder="ОГРН"
                                   value="<?= $userProfile["PROFILE_VALUE"]["OGRN"]["VALUE"] ?>"
                                   required
                                   class="input input--white">
                            <div class="input-group__error"></div>
                          </div>
                        </div>
                        <div class="form-default__column">
                          <div data-input-group="name" class="input-group">
                            <input name="PROPERTIES[13]"
                                   type="text"
                                   value="<?= $userProfile["PROFILE_VALUE"]["BANK"]["VALUE"] ?>"
                                   placeholder="Банк"
                                   required
                                   class="input input--white">
                            <div class="input-group__error"></div>
                          </div>
                        </div>
                      </div>
                      <div class="form-default__row">
                        <div class="form-default__column form-default__column--three">
                          <div data-input-group="phone" class="input-group">
                            <input name="PROPERTIES[14]"
                                   type="text"
                                   placeholder="Расчетный счет"
                                   value="<?= $userProfile["PROFILE_VALUE"]["CHECKING-ACCOUNT"]["VALUE"] ?>"
                                   required
                                   class="input input--white">
                            <div class="input-group__error"></div>
                          </div>
                        </div>
                        <div class="form-default__column form-default__column--three">
                          <div data-input-group="name" class="input-group">
                            <input name="PROPERTIES[15]"
                                   type="text"
                                   value="<?= $userProfile["PROFILE_VALUE"]["CORRESPONDENCE-ACCOUNT"]["VALUE"] ?>"
                                   placeholder="Корреспонденский счет"
                                   required
                                   class="input input--white">
                            <div class="input-group__error"></div>
                          </div>
                        </div>
                        <div class="form-default__column form-default__column--three">
                          <div data-input-group="name" class="input-group">
                            <input name="PROPERTIES[16]"
                                   type="text"
                                   value="<?= $userProfile["PROFILE_VALUE"]["BIK"]["VALUE"] ?>"
                                   placeholder="БИК"
                                   required
                                   class="input input--white">
                            <div class="input-group__error"></div>
                          </div>
                        </div>
                      </div>
                      <div class="form-default__row">
                        <div class="form-default__column">
                          <div data-input-group="phone" class="input-group">
                            <input name="PROPERTIES[17]"
                                   type="text"
                                   placeholder="Руководитель организации"
                                   value="<?= $userProfile["PROFILE_VALUE"]["HEAD-ORGANIZATION"]["VALUE"] ?>"
                                   required
                                   class="input input--white">
                            <div class="input-group__error"></div>
                          </div>
                        </div>
                        <div class="form-default__column">
                          <div data-input-group="name" class="input-group">
                            <input name="PROPERTIES[18]"
                                   type="text"
                                   value="<?= $userProfile["PROFILE_VALUE"]["ADDRESS"]["VALUE"] ?>"
                                   placeholder="Адрес доставки"
                                   required
                                   class="input input--white">
                            <div class="input-group__error"></div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Файлы профиля -->
                    <div class="lk-content__title lk-profile__title">
                      Загрузите необходимые документы
                    </div>
                    <div class="lk-cards">
                      <? /* Получение массива с файлами */
                      $fileParams = ['SCAN_INN', 'SCAN_KPP', 'SCAN_OGRN', 'SCAN_STATUTE',
                        'LICENSEL', 'TEMPLATE_LETTER'];
                      $fileData = [];
                      //dump($userProfile);
                      foreach ($userProfile['PROFILE_VALUE'] as $code => $value) {
                        if (in_array($code, $fileParams)) {
                          $fileData[$code] = $value;
                        }
                      }
                      ?>
                      <? foreach ($fileData as $code => $value): ?>
                        <? if ($code != 'TEMPLATE_LETTER'): ?>
                          <div class="lk-card <?= $value['FILE_PATH'] ? 'lk-card--load' : '' ?>">
                            <div class="lk-card__title">
                              <?= $value['FILE_NAME'] ?>
                            </div>
                            <div class="lk-card__btn-wrapper">
                                                            <span>
                                                                    <?= $value['FILE_PATH'] ? 'Файл загружен' : 'Файла не найдено' ?>
                                                            </span>
                              <label class="lk-card__btn js-user-file-loading"
                                     data-user-profile-id="<?= $userProfile['PROFILE_INFO']['ID'] ?>"
                                     data-property-id="<?= $value['PROP_ID'] ?>">
                                <input type="file" name="FILE" hidden>
                                <svg class="icon icon-plus ">
                                  <use xlink:href="#plus"></use>
                                </svg>
                              </label>
                            </div>
                          </div>
                        <? else: ?>
                          <div class="lk-card lk-card--download">
                            <? if ($value['FILE_PATH']): ?>
                              <a href="<?= $value['FILE_PATH'] ?>"
                                 class="lk-card__link"
                                 target="_blank">
                                Скачать шаблон письмо отказ
                              </a>
                            <? else: ?>
                              <p>Шаблон письма не найден</p>
                            <? endif; ?>
                          </div>
                        <? endif; ?>
                      <? endforeach; ?>
                      <!--<div class="lk-card">
<div class="lk-card__title">Скан ИНН*</div>
<div class="lk-loader__wrapper">
<div class="lk-loader">
<div class="lk-loader__percent">60%</div>
<div class="lk-loader__outer">
<div class="lk-loader__inner"></div>
</div>
<div class="lk-loader__status">Загружается ...</div>
</div>
</div>
</div>-->
                      <!--<div class="lk-card lk-card--error">
<div class="lk-card__title">Скан КПП*</div>
<div class="lk-loader__wrapper">
<div class="lk-loader">
<div class="lk-loader__percent">60%</div>
<div class="lk-loader__outer">
<div class="lk-loader__inner"></div>
</div>
<div class="lk-loader__status">Произошла ошибка.
<a href="#" class="lk-loader__status-link">
    Попробуйте еще</a></div>
</div>
</div>
</div>-->
                      <!--<div class="lk-card lk-card--load">
<div class="lk-card__title">Скан УСТАВ*</div>
<div class="lk-card__btn-wrapper">
<button class="lk-card__btn">
<svg class="icon icon-plus ">
<use xlink:href="#plus"></use>
</svg>
</button>
</div>
</div>-->
                      <!--<div class="lk-card lk-card--load">
<div class="lk-card__title">
Лицензия на фармацевтическую дея-ть/Письмо-отказ*
</div>
<div class="lk-card__btn-wrapper">
<button class="lk-card__btn">
<svg class="icon icon-plus ">
<use xlink:href="#plus"></use>
</svg>
</button>
</div>
</div>-->
                      <!--<div class="lk-card lk-card--download">
<a href="#" class="lk-card__link">
Скачать шаблон письмо отказ</a></div>-->
                    </div>

                    <div class="form-default__send lk-profile__form-sender">
                      <div class="form-default__consent">
                        <label class="checkbox">
                          <input name="consent" type="checkbox" value="Y" checked
                                 class="js-form-consent">
                          <span class="checkbox__indicator">
																										<svg class="icon icon-check ">
																											<use xlink:href="#check"></use>
																										</svg></span>
                          <span class="checkbox__description">Согласен на обработку
																									<a href="#"
                                                     target="_blank"
                                                     class="link"> персональных данных</a></span>
                        </label>
                      </div>
                      <button type="submit" class="btn"><span>Сохранить изменения</span>
                      </button>
                    </div>
                  </form>
                </div>
              <? endif; ?>
            <? endforeach; ?>
          <? endif; ?>

          <!-- Форма добавления физического лица todo: Сделать стили формы (display: none)-->
          <div class="lk-profile__section js-physical-form">

            <div class="lk-profile__head">
              <div class="lk-profile__title lk-content__title">Создание профиля</div>
              <button
                class="lk-profile__close js-close-physical-form js-profile-close"
                data-section=".js-physical-form">
                <span class="lk-profile__delete link link--bold">Закрыть</span>
              </button>
            </div>

            <form action="/api/user/controller-profiles.php"
                  class="lk-profile__form form-default js-form-send">
              <?= bitrix_sessid_post() ?>
              <input type="hidden"
                     name="ACTION"
                     value="CREATE">
              <input type="hidden"
                     name="TYPE_USER_PROFILE"
                     value="1">

              <div data-input-group="name" class="input-group">
                <input name="CREATE_DATA[1]"
                       type="text"
                       value=""
                       placeholder="ФИО*"
                       aria-label=""
                       required
                       class="input input--white">
                <div class="input-group__error"></div>
              </div>
              <div class="form-default__row">
                <div class="form-default__column">
                  <div data-input-group="phone" class="input-group">
                    <input name="CREATE_DATA[2]"
                           type="tel"
                           placeholder="Телефон*"
                           value=""
                           aria-label=""
                           required
                           class="input js-input-phone input--white">
                    <div class="input-group__error"></div>
                  </div>
                </div>
                <div class="form-default__column">
                  <div data-input-group="name" class="input-group">
                    <input name="CREATE_DATA[3]"
                           type="text"
                           value=""
                           placeholder="Email"
                           aria-label=""
                           required
                           class="input input--white">
                    <div class="input-group__error"></div>
                  </div>
                </div>
              </div>
              <div data-input-group="name" class="input-group">
                <input name="CREATE_DATA[4]"
                       type="text"
                       value=""
                       placeholder="Адрес доставки"
                       aria-label=""
                       required
                       class="input input--white">
                <div class="input-group__error"></div>
              </div>
              <div class="form-default__send lk-profile__form-sender">
                <div class="form-default__consent">
                  <label class="checkbox">
                    <input name="consent" type="checkbox" value="Y" checked
                           class="js-form-consent"><span class="checkbox__indicator">
                                                       <svg class="icon icon-check ">
                                                         <use xlink:href="#check"></use>
                                                       </svg></span>
                    <span class="checkbox__description">
                                                        Согласен на обработку
                                                        <a href="#" target="_blank"
                                                           class="link"> персональных данных</a></span>
                  </label>
                </div>
                <button type="submit" class="btn"><span>Создать профель</span></button>
              </div>
            </form>
          </div>


          <!-- Форма юридического лица физического лица todo: Сделать стили формы (display: none)-->
          <div class="lk-profile__section js-legal-form">

            <div class="lk-profile__head">
              <div class="lk-content__title">Создание профиля</div>
              <button
                class="lk-profile__close js-close-legal-form js-profile-close"
                data-section=".js-legal-form">
                <span class="lk-profile__delete link link--bold">Закрыть</span>
              </button>
            </div>

            <form action="/api/user/controller-profiles.php"
                  class="lk-profile__form form-default js-form-send">
              <?= bitrix_sessid_post() ?>
              <input type="hidden"
                     name="ACTION"
                     value="CREATE">
              <input type="hidden"
                     name="TYPE_USER_PROFILE"
                     value="2">

              <div class="lk-profile__form-wrapper">

                <div data-input-group="name" class="input-group">
                  <input name="CREATE_DATA[5]"
                         type="text"
                         value=""
                         placeholder="ФИО*"
                         required
                         aria-label=""
                         class="input input--white">
                  <div class="input-group__error"></div>
                </div>
                <div class="form-default__row">
                  <div class="form-default__column">
                    <div data-input-group="phone" class="input-group">
                      <input name="CREATE_DATA[6]"
                             type="tel"
                             placeholder="Телефон*"
                             value=""
                             required
                             aria-label=""
                             class="input js-input-phone input--white">
                      <div class="input-group__error"></div>
                    </div>
                  </div>
                  <div class="form-default__column">
                    <div data-input-group="name" class="input-group">
                      <input name="CREATE_DATA[7]"
                             type="text"
                             value=""
                             placeholder="Email"
                             required
                             aria-label=""
                             class="input input--white">
                      <div class="input-group__error"></div>
                    </div>
                  </div>
                </div>
                <div data-input-group="name" class="input-group">
                  <input name="CREATE_DATA[8]"
                         type="text"
                         value=""
                         placeholder="Название организации"
                         required
                         aria-label=""
                         class="input input--white">
                  <div class="input-group__error"></div>
                </div>
                <div class="form-default__row">
                  <div class="form-default__column">
                    <div data-input-group="phone" class="input-group">
                      <input name="CREATE_DATA[9]"
                             type="text"
                             placeholder="ИНН"
                             value=""
                             required
                             aria-label=""
                             class="input input--white">
                      <div class="input-group__error"></div>
                    </div>
                  </div>
                  <div class="form-default__column">
                    <div data-input-group="name" class="input-group">
                      <input name="CREATE_DATA[10]"
                             type="text"
                             value=""
                             aria-label=""
                             placeholder="КПП" required class="input input--white">
                      <div class="input-group__error"></div>
                    </div>
                  </div>
                </div>
                <div data-input-group="name" class="input-group">
                  <input name="CREATE_DATA[11]"
                         type="text"
                         value=""
                         placeholder="Юридический адрес"
                         required
                         aria-label=""
                         class="input input--white">
                  <div class="input-group__error"></div>
                </div>
                <div class="form-default__row">
                  <div class="form-default__column">
                    <div data-input-group="phone" class="input-group">
                      <input name="CREATE_DATA[12]"
                             type="text"
                             placeholder="ОГРН"
                             value=""
                             required
                             aria-label=""
                             class="input input--white">
                      <div class="input-group__error"></div>
                    </div>
                  </div>
                  <div class="form-default__column">
                    <div data-input-group="name" class="input-group">
                      <input name="CREATE_DATA[13]"
                             type="text"
                             value=""
                             placeholder="Банк"
                             required
                             aria-label=""
                             class="input input--white">
                      <div class="input-group__error"></div>
                    </div>
                  </div>
                </div>
                <div class="form-default__row">
                  <div class="form-default__column form-default__column--three">
                    <div data-input-group="phone" class="input-group">
                      <input name="CREATE_DATA[14]"
                             type="text"
                             placeholder="Расчетный счет"
                             value=""
                             required
                             aria-label=""
                             class="input input--white">
                      <div class="input-group__error"></div>
                    </div>
                  </div>
                  <div class="form-default__column form-default__column--three">
                    <div data-input-group="name" class="input-group">
                      <input name="CREATE_DATA[15]"
                             type="text"
                             value=""
                             placeholder="Корреспонденский счет"
                             required
                             aria-label=""
                             class="input input--white">
                      <div class="input-group__error"></div>
                    </div>
                  </div>
                  <div class="form-default__column form-default__column--three">
                    <div data-input-group="name" class="input-group">
                      <input name="CREATE_DATA[16]"
                             type="text"
                             value=""
                             placeholder="БИК"
                             required
                             aria-label=""
                             class="input input--white">
                      <div class="input-group__error"></div>
                    </div>
                  </div>
                </div>
                <div class="form-default__row">
                  <div class="form-default__column">
                    <div data-input-group="phone" class="input-group">
                      <input name="CREATE_DATA[17]"
                             type="text"
                             placeholder="Руководитель организации"
                             value=""
                             required
                             aria-label=""
                             class="input input--white">
                      <div class="input-group__error"></div>
                    </div>
                  </div>
                  <div class="form-default__column">
                    <div data-input-group="name" class="input-group">
                      <input name="CREATE_DATA[18]"
                             type="text"
                             value=""
                             placeholder="Адрес доставки"
                             required
                             aria-label=""
                             class="input input--white">
                      <div class="input-group__error"></div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="lk-content__title lk-profile__title">Загрузите необходимые документы</div>

              <div class="lk-cards">
                <div class="lk-card lk-card--load">
                  <div class="lk-card__title">Скан ИНН*</div>
                  <div class="lk-card__btn-wrapper">
                    <label class="lk-card__btn">
                      <input type="hidden" name="CREATE_DATA[19]" value="Скан ИНН*">
                      <input type="file" name="FILE_19" multiple="multiple" hidden>
                      <svg class="icon icon-plus ">
                        <use xlink:href="#plus"></use>
                      </svg>
                    </label>
                  </div>
                </div>

                <div class="lk-card lk-card--load">
                  <div class="lk-card__title">Скан КПП*</div>
                  <div class="lk-card__btn-wrapper">
                    <label class="lk-card__btn">
                      <input type="hidden" name="CREATE_DATA[20]" value="Скан ИНН*">
                      <input type="file" name="FILE_20" multiple="multiple" hidden>
                      <svg class="icon icon-plus ">
                        <use xlink:href="#plus"></use>
                      </svg>
                    </label>
                  </div>
                </div>

                <div class="lk-card lk-card--load">
                  <div class="lk-card__title">Скан ОГРН*</div>
                  <div class="lk-card__btn-wrapper">
                    <label class="lk-card__btn">
                      <input type="hidden" name="CREATE_DATA[21]" value="Скан ОГРН*">
                      <input type="file" name="FILE_21" multiple="multiple" hidden>
                      <svg class="icon icon-plus ">
                        <use xlink:href="#plus"></use>
                      </svg>
                    </label>
                  </div>
                </div>

                <div class="lk-card lk-card--load">
                  <div class="lk-card__title">Скан УСТАВ*</div>
                  <div class="lk-card__btn-wrapper">
                    <label class="lk-card__btn">
                      <input type="hidden" name="CREATE_DATA[22]" value="Скан УСТАВ*">
                      <input type="file" name="FILE_22" multiple="multiple" hidden>
                      <svg class="icon icon-plus ">
                        <use xlink:href="#plus"></use>
                      </svg>
                    </label>
                  </div>
                </div>

                <div class="lk-card lk-card--load">
                  <div class="lk-card__title">Лицензия</div>
                  <div class="lk-card__btn-wrapper">
                    <label class="lk-card__btn">
                      <input type="hidden" name="CREATE_DATA[23]" value="Лицензия">
                      <input type="file" name="FILE_23" multiple="multiple" hidden>
                      <svg class="icon icon-plus ">
                        <use xlink:href="#plus"></use>
                      </svg>
                    </label>
                  </div>
                </div>
                <!--                                    <div class="lk-card">
                                                        <div class="lk-card__title">Скан ИНН*</div>
                                                        <div class="lk-loader__wrapper">
                                                            <div class="lk-loader">
                                                                <div class="lk-loader__percent">60%</div>
                                                                <div class="lk-loader__outer">
                                                                    <div class="lk-loader__inner"></div>
                                                                </div>
                                                                <div class="lk-loader__status">Загружается ...</div>
                                                            </div>
                                                        </div>
                                                    </div>-->
                <!--                           <div class="lk-card lk-card--error">
                                               <div class="lk-card__title">Скан КПП*</div>
                                               <div class="lk-loader__wrapper">
                                                   <div class="lk-loader">
                                                       <div class="lk-loader__percent">60%</div>
                                                       <div class="lk-loader__outer">
                                                           <div class="lk-loader__inner"></div>
                                                       </div>
                                                       <div class="lk-loader__status">Произошла ошибка.<a href="#"
                                                                                                          class="lk-loader__status-link">
                                                               Попробуйте еще</a></div>
                                                   </div>
                                               </div>
                                           </div>-->
                <!--        <div class="lk-card lk-card--load">
                            <div class="lk-card__title">Скан УСТАВ*</div>
                            <div class="lk-card__btn-wrapper">
                                <button class="lk-card__btn">
                                    <svg class="icon icon-plus ">
                                        <use xlink:href="#plus"></use>
                                    </svg>
                                </button>
                            </div>
                        </div>-->
                <!--                <div class="lk-card lk-card--load">
                                    <div class="lk-card__title">Лицензия на фармацевтическую дея-ть/ Письмо-отказ*
                                    </div>
                                    <div class="lk-card__btn-wrapper">
                                        <button class="lk-card__btn">
                                            <svg class="icon icon-plus ">
                                                <use xlink:href="#plus"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>-->
                <!--    <div class="lk-card lk-card--download">
                        <a href="#" class="lk-card__link">
                            Скачать
                            шаблон письмо-отказ</a>
                    </div>-->
              </div>
              <div class="form-default__send lk-profile__form-sender">
                <div class="form-default__consent">
                  <label class="checkbox">
                    <input name="consent" type="checkbox" value="Y" checked
                           class="js-form-consent">
                    <span class="checkbox__indicator">
                                              <svg class="icon icon-check ">
                                                <use xlink:href="#check"></use>
                                              </svg>
                                            </span>
                    <span class="checkbox__description">
                                                Согласен на обработку
                                                <a href="#" target="_blank" class="link"> персональных данных</a>
                                            </span>
                  </label>
                </div>
                <button type="submit" class="btn"><span>Сохранить изменения</span></button>
              </div>
            </form>
          </div>

          <div class="lk-profile__add js-profile-list">
            <div class="lk-profile__add-header">
              <div class="lk-profile__add-title">Добавить новый профиль</div>
            </div>
            <div class="lk-profile__add-buttons">
              <!-- Открытие формы добавления физического профиля пользователя -->
              <button
                type="button"
                class="lk-profile__add-btn js-profile-open"
                data-section=".js-physical-form">
                <div class="lk-profile__add-icon">
                  <svg class="icon icon-plus ">
                    <use xlink:href="#plus"></use>
                  </svg>
                </div>
                <span>Для физлица</span>
              </button>
              <!-- Открытие формы добавления юридического профиля пользователя -->
              <!-- info: Временно скрыто
              <button
                      type="button"
                      class="lk-profile__add-btn js-profile-open"
                      data-section=".js-legal-form">
                  <div class="lk-profile__add-icon">
                      <svg class="icon icon-plus ">
                          <use xlink:href="#plus"></use>
                      </svg>
                  </div>
                  <span>Для юрлица</span>
              </button>
              -->
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Подключение блока bullets из parts -->
  <? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/all-pages/footer-bullets.php") ?>

</div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
