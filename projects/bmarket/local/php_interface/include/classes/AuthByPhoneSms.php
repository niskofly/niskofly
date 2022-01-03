<?php

class AuthByPhoneSms
{
    public $phone;
    public $name;

    protected $response;
    protected $userData;

    public function __construct()
    {
        $this->response = [
            "error" => true,
            "msg" => "Произошла ошибка! Попробуйте позже."
        ];
    }

    /**
     * Точка кода для проверки на существование пользователя по номеру телефона и
     * отправка кода авторизации через смс
     *
     * @param $phone
     * @param string $name
     */
    public function sendUserAuthCode($phone, $name = null)
    {
        $this->phone = $phone;
        $this->name = $name ?: $phone;

        if (!$this->validationCheckPhone($this->phone))
            return;

        $this->userVerificationExistence();

        if ($this->userData) {
            $this->sendAuthCodeByExistingUser();
        } else {
            $this->createNewUserAndSendAuthCode();
        }
    }

    /**
     * Зарегестрировать нового пользователя и
     * отправить пользователю код авторизации
     */
    protected function createNewUserAndSendAuthCode()
    {
        $code = $this->generateCode();

        /**
         * Обрезка всех символов для отправки сообщения
         */
        $phoneClear = preg_replace('~\D+~', '', $this->phone);

        $sms = $this->sendMessage($phoneClear, $code);

        /**
         * Регистрируем пользователя с рандомными данными
         */
        if ($sms->status == "OK") {
            $password = rand(0, 9) . rand(14, 27) . rand() . rand() . rand();

            $user = new CUser;
            $userId = $user->Add([
                "NAME" => "",
                "LAST_NAME" => "",
                "LOGIN" => $phoneClear,
                "ACTIVE" => "Y",
                "PASSWORD" => $password,
                "CONFIRM_PASSWORD" => $password,
                "PERSONAL_MOBILE" => $phoneClear,
                "PERSONAL_PHONE" => $phoneClear,
                "UF_CODE" => $code
            ]);

            if ($userId) {
                $this->response = [
                    'error' => false,
                    'msg' => 'На указанный номер было выслано SMS уведомление.',
                    'phone' => $this->phone
                ];
            } else {
                $this->response = [
                    'error' => true,
                    'msg' => 'Произошла ошибка при создании пользователя. Обратитесь к администратору!',
                    'error_msg' => $user->LAST_ERROR
                ];
            }
        } else {
            $this->response = [
                'error' => true,
                'msg' => 'Произошла ошибка при отправке SMS уведомления.',
                'status' => $sms->status_text
            ];
        }
    }

    /**
     * Отправить код авторизации существующему пользователю
     */
    protected function sendAuthCodeByExistingUser()
    {
        $user = new CUser;

        $code = $this->generateCode();
        $user->Update($this->userData['ID'], ["UF_CODE" => $code]);
        $sms = $this->sendMessage($this->phone, $code);

        if ($sms->status == "OK") {
            $this->response = [
                'error' => false,
                'msg' => 'Введите SMS код в поле ниже.',
                'phone' => $this->phone
            ];
        } else {
            $this->response = [
                'error' => true,
                'msg' => 'Произошла ошибка при отправке SMS уведомления.',
                'status' => $sms->status_text
            ];
        }
    }

    /**
     * Авторизовать пользователя с контролем кода из смс
     *
     * @param $phone
     * @param $code
     */
    public function authUserBySMSCode($phone, $code)
    {
        $this->phone = $phone;

        if (!$this->validationCheckPhone($this->phone))
            return;

        $this->userVerificationExistence();

        if ($this->userData && $user_code = $this->userData['UF_CODE']) {
            if ($this->userData['UF_CODE'] == $code) {
                $user = new CUser;
                $user->Update($this->userData['ID'], ['UF_CODE' => '']);
                $user->Authorize($this->userData['ID']);

                $this->response = [
                    "error" => false,
                    "msg" => "Вы успешно авторизованы."
                ];
            } else {
                $this->response = [
                    "error" => true,
                    "msg" => "Код авторизации не совпадает с введенным значением."
                ];
            }
        }
    }

    /**
     * Валидация номера телефона по маске
     *
     * @param $phone
     * @return bool
     */
    public function validationCheckPhone($phone)
    {
        if (preg_match('/^\+[7] [\(]\d{3}[\)] \d{3}-\d{2}-\d{2}$/', $phone) != 1) {
            $this->response = [
                'error' => true,
                'msg' => 'Ошибка валидации номера телефона, введите номер в правильном формате: +7 (000) 000-00-00'
            ];
            return false;
        }

        return true;
    }

    /**
     * Проверить существование пользователя по номеру телефона,
     * Добавить параметры пользователя в $this->userData, если пользователь найден
     */
    public function userVerificationExistence()
    {
        $by = "ID";
        $order = "ASC";
        /**
         * Обрезка всех символов для отправки сообщения
         */
        $phoneClear = preg_replace('~\D+~', '', $this->phone);

        $rsUser = CUser::GetList($by, $order, ["PERSONAL_PHONE" => $phoneClear], ["SELECT" => ["UF_CODE"]]);
        if ($arUser = $rsUser->Fetch())
            $this->userData = $arUser;
    }




    /**
     * HELPERS
     */

    /**
     * Генерация кода
     *
     * @return int
     */
    protected function generateCode()
    {
        return rand(1111, 9999);
    }

    /**
     * Получить результат и статус авторизации
     *
     * @return mixed
     */
    public function getResultResponse()
    {
        return $this->response;
    }

    /**
     * Отправить результат и статус авторизации для AJAX обработчика
     */
    public function sendAjaxResultResponse()
    {
        die(json_encode($this->getResultResponse()));
    }

    /**
     * Отправка SMS сообщения
     *
     * @param $phone
     * @param $message
     * @return array|mixed|stdClass
     */
    public function sendMessage($phone, $message)
    {
        /**
         * Не отправлять СМС сообщение
         */
        if (SMSRU_KEY == 'FAKE') {
            $smsData = new stdClass();
            $smsData->status = 'OK';
            return $smsData;
        }

        $smsApi = new SMSRU(SMSRU_KEY);
        $smsData = new stdClass();
        $smsData->to = $phone;
        $smsData->text = $message;
        return $smsApi->send_one($smsData);
    }

    /**
     * Получить отформатированный номер телефона
     * @param $phone
     * @return mixed
     */
    public static function getFormattedPhone($phone)
    {
        $formatted = sprintf("+%d (%d%d%d) %d%d%d-%d%d-%d%d", ...str_split($phone));
        return $formatted ?: $phone;
    }
}
