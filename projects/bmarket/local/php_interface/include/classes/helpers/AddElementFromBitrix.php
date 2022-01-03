<?php

use Bitrix\Main\Loader;

class AddElementFromBitrix
{
    public $newElementId = null;

    protected $IBLOCK_ID = null;
    protected $response = null;

    public function __construct($IBLOCK_ID = null)
    {
        $this->IBLOCK_ID = $IBLOCK_ID;
        $this->response = [
            'error' => true,
            'msg' => 'Некорректные данные'
        ];
        Loader::includeModule('iblock');
    }

    /**
     * Обработка добавления элемента
     *
     * @param $arData
     * @param string $msg
     */
    public function insert($arData, $msg = "Ваше сообщение успешно отправленно")
    {
        $arFields = array(
            "ACTIVE" => "Y",
            "DATE_CREATE" => date("d.m.Y H:i:s"),
            "IBLOCK_ID" => $this->IBLOCK_ID
        );

        if ((!array_key_exists('CODE', $arData) || !$arData['CODE']) && $arData['NAME'])
            $arData['CODE'] = getUrlByStr($arData['NAME']);

        $arFields = array_merge($arFields, $arData);
        $this->insertBD($arFields, $msg);
    }

    /**
     * Добавить запись в базу данных
     *
     * @param $arFields
     * @param $msg
     */
    protected function insertBD($arFields, $msg)
    {
        $oElement = new CIBlockElement();

        if ($newElementId = $oElement->Add($arFields, false, false, true)) {
            $this->newElementId = $newElementId;
            $this->response = [
                'error' => false,
                'msg' => $msg
            ];
        } else {
            $this->response = [
                'error' => true,
                'msg' => $oElement->LAST_ERROR
            ];
        }
    }

    /**
     * Отправить уведомление о добавлении нового элемента
     *
     * @param $arData
     */
    public function sendAdminNotification($arData)
    {
        if (!$this->response['error'])
            (new AdminNotification($arData))->send();
    }




    /**
     ***********
     *  HELPERS
     ***********
     */

    /**
     * Получить массив описывающй файл для сохранения в Bitrix
     * Нужно для множественой загрузки файлов
     *
     * @param $arFile
     * @return array|bool|null
     */
    public static function getSavedFileArray($arFile)
    {
        $result = $arFile;

        /**
         * Загружается несколько файлов
         */
        if (is_array($arFile['name'])) {
            $result = [];

            for ($i = 0; $i < count($arFile['name']); $i++) {
                foreach (array_keys($arFile) as $key) {
                    $result[$i][$key] = $arFile[$key][$i];
                }
            }
        }

        return $result;
    }

    /**
     * Получить результат работы
     *
     * @return mixed
     */
    public function getResultResponse()
    {
        return $this->response;
    }

    /**
     * Отправить результат работы для AJAX обработчика
     */
    public function sendAjaxResultResponse()
    {
        die(json_encode($this->getResultResponse()));
    }
}

