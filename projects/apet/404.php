<?
include_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404", "Y");

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Страница не найдена");
$APPLICATION->SetPageProperty("title", "Страница не найдена");
?>

<div class="page page--404">
    <div class="container">
        <div class="error-wrapper">
            <div class="error">
                <div class="error__image"><img src="/img/404.png" alt=""></div>
                <div class="error__title title title--second">Страница не найдена</div>
                <div class="error__description">
                    Возможно, была допущена ошибка в написании ссылки, либо страница
                    удалена. Воспользуйтесь поиском ниже или перейдите на главную
                </div>
                <div class="search">
                    <div class="search__icon">
                        <svg class="icon icon-search ">
                            <use xlink:href="#search"></use>
                        </svg>
                    </div>
                    <form action="/search/" method="get">
                        <input name="q" type="text" placeholder="Поиск по каталогу"
                               class="input input--white search__input" required>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
