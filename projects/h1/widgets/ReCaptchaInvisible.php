<?php
/**
 * Исправляет поведение reCaptcha Invisible.
 * При использовании этого класса, на кнопку отправки следует добавлять в событие 'onclick' вызов grecaptcha.execute();
 *
 * User: deadie
 * Date: 10.02.2019
 */

namespace app\widgets;

use Yii;
use himiklab\yii2\recaptcha\ReCaptcha;
use yii\helpers\Html;
use yii\base\InvalidConfigException;

/**
 * Class ReCaptchaInvisible
 *
 * @package app\widgets
 */
class ReCaptchaInvisible extends ReCaptcha
{
    public function run() {
        $view = $this->view;
        if (empty($this->siteKey)) {
            /** @var ReCaptcha $reCaptcha */
            $reCaptcha = Yii::$app->reCaptcha;
            if ($reCaptcha && !empty($reCaptcha->siteKey)) {
                $this->siteKey = $reCaptcha->siteKey;
            } else {
                throw new InvalidConfigException('Required `siteKey` param isn\'t set.');
            }
        }

        $arguments = \http_build_query([
            'hl' => $this->getLanguageSuffix(),
            'render' => 'explicit',
            'onload' => 'recaptchaOnloadCallback',
        ]);

        $view->registerJsFile(
            self::JS_API_URL . '?' . $arguments,
            ['position' => $view::POS_END, 'async' => true, 'defer' => true]
        );
        $view->registerJs(
            <<<'JS'
function recaptchaOnloadCallback() {
    "use strict";
    jQuery(".g-recaptcha").each(function () {
        var reCaptcha = jQuery(this);
        if (reCaptcha.data("recaptcha-client-id") === undefined) {
            var recaptchaClientId = grecaptcha.render(reCaptcha.attr("id"), {
                "callback": function (response) {
                    if (reCaptcha.data("form-id") !== "") {
                        jQuery("#" + reCaptcha.data("input-id"), "#" + reCaptcha.data("form-id")).val(response)
                            .trigger("change");
                    } else {
                        jQuery("#" + reCaptcha.data("input-id")).val(response).trigger("change");
                    }

                    if (reCaptcha.attr("data-callback")) {
                        eval("(" + reCaptcha.attr("data-callback") + ")(response)");
                    }
                },
                "expired-callback": function () {
                    if (reCaptcha.data("form-id") !== "") {
                        jQuery("#" + reCaptcha.data("input-id"), "#" + reCaptcha.data("form-id")).val("");
                    } else {
                        jQuery("#" + reCaptcha.data("input-id")).val("");
                    }

                    if (reCaptcha.attr("data-expired-callback")) {
                        eval("(" + reCaptcha.attr("data-expired-callback") + ")()");
                    }
                },
            });
            reCaptcha.data("recaptcha-client-id", recaptchaClientId);
            
            if (reCaptcha.data("size") === "invisible") {
                reCaptcha.closest("form#"+ reCaptcha.data("form-id")).find("[aria-required='true']").on('blur', function(e) {
                    grecaptcha.execute(recaptchaClientId);
                });
            
            }
        }
    });
}
JS
            , $view::POS_END);

        if (Yii::$app->request->isAjax) {
            $view->registerJs(<<<'JS'
if (typeof grecaptcha !== "undefined") {
    recaptchaOnloadCallback();
}
JS
                , $view::POS_END
            );
        }

        $this->customFieldPrepare();
        echo Html::tag('div', '', $this->buildDivOptions());

    }
}