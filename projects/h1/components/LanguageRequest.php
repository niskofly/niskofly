<?php
/**
 * LanguageRequest.php - new.headin.pro
 * Initial version by: BeforyDeath
 * Initial version created on: 22.08.15 14:14
 */

namespace app\components;

use app\models\Language;
use yii\base\InvalidConfigException;
use yii\web\Request;

class LanguageRequest extends Request
{
    private $language_url;

    public function getLangUrl()
    {
        if ($this->language_url === null) {
            $this->language_url = $this->getUrl();

            $url_list = explode('/', $this->language_url);

            $language_url = isset($url_list[1]) ? $url_list[1] : null;

            Language::setCurrent($language_url);

            if ($language_url !== null && $language_url === Language::getCurrent()->alias &&
                strpos($this->language_url, Language::getCurrent()->alias) === 1
            ) {
                $this->language_url = substr($this->language_url, strlen(Language::getCurrent()->alias) + 1);
            }
        }
        return $this->language_url;
    }

    protected function resolvePathInfo()
    {
        $pathInfo = $this->getLangUrl();
        if (($pos = strpos($pathInfo, '?')) !== false) {
            $pathInfo = substr($pathInfo, 0, $pos);
        }

        $scriptUrl = $this->getScriptUrl();
        $baseUrl = $this->getBaseUrl();
        if (strpos($pathInfo, $scriptUrl) === 0) {
            $pathInfo = substr($pathInfo, strlen($scriptUrl));
        } elseif ($baseUrl === '' || strpos($pathInfo, $baseUrl) === 0) {
            $pathInfo = substr($pathInfo, strlen($baseUrl));
        } elseif (isset($_SERVER['PHP_SELF']) && strpos($_SERVER['PHP_SELF'], $scriptUrl) === 0) {
            $pathInfo = substr($_SERVER['PHP_SELF'], strlen($scriptUrl));
        } else {
            throw new InvalidConfigException('Unable to determine the path info of the current request.');
        }

        if ($pathInfo[0] === '/') {
            $pathInfo = substr($pathInfo, 1);
        }

        return (string)$pathInfo;
    }
}