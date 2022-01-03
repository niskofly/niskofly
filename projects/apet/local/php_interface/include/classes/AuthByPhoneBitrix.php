<?php
/**
 * Регистрации и авторизации, изменение и восстановление пароля
 * пользователей на сайте.
 */

class AuthByPhoneBitrix
{
    public $phone;
    protected $userData;

    /**
     * Регистрация пользователя
     * @param $data
     * @return int|mixed|string
     * @throws Exception
     */
    public function registrationUser($data)
    {
        $this->validationCheckPhone($data['phone']);

        $data['phone'] = $this->removingSymbols($data['phone']);
        $this->checkUserAuth($data['phone']);

        $dataUserProfile = $this->sendSmsCodeUser($data['phone']);

        return (new CUser())->Add([
            "NAME" => "no-name",
            "LAST_NAME" => "no-last-name",
            "LOGIN" => $dataUserProfile['PHONE_BY_SMS'],
            "EMAIL" => $dataUserProfile['EMAIL'],
            "ACTIVE" => "Y",
            "PASSWORD" => $dataUserProfile['CODE'],
            "CONFIRM_PASSWORD" => $dataUserProfile['CODE'],
            "PERSONAL_MOBILE" => $data['phone'],
            "PERSONAL_PHONE" => $data['phone'],
            "PHONE_NUMBER" => $data['phone'],
            "UF_CODE" => $dataUserProfile['CODE'],
        ]);
    }

    /**
     * Авторизация пользователя
     * @param $data
     * @return bool
     * @throws Exception
     */
    public function authorizationUser($data): bool
    {
        if (!$data['code'])
            throw new Exception("Код не введен");

        $this->validationCheckPhone($data['phone']);

        $data['phone'] = $this->removingSymbols($data['phone']);
        $this->userVerificationExistence($data['phone']);

        if ($this->userData && $this->userData['UF_CODE']) {
            if ($this->userData['UF_CODE'] == $data['code'])
                return (new CUser())->Authorize($this->userData["ID"], $data['remember']);
            else
                throw new Exception("Код введен не верно");
        }
    }

    /**
     * Обновление кода доступа к профилю пользователя
     * @param $data
     * @return string
     * @throws Exception
     */
    public function updateUserProfileAccessCode($data): string
    {
        if (!$data)
            throw new Exception("Данные не переданы");

        $this->validationCheckPhone($data['phone']);

        $data['phone'] = $this->removingSymbols($data['phone']);
        $codeSend = $this->sendSmsCodeUser($data['phone']);
        $this->userVerificationExistence($data['phone']);
        $updateCodeResult = (new CUser)->Update($this->userData['ID'], ["UF_CODE" => $codeSend['CODE']]);

        if ($updateCodeResult)
            return 'Код доступа успешно изменен и выслан на указанный телефон';
        else
            throw new Exception("Ошибка восстановления доступа к профилю");
    }

    /**
     * Изменение пароля в личном кабинете
     * @param $data
     * @return string
     * @throws Exception
     */
    public function changePassword($data): string
    {
        global $USER;
        $userData = CUser::GetByID($USER->GetID())->Fetch();

        switch ($data['method']) {
            case 'send_code':
                if (!$data['PASSWORD'] && !$data['PASSWORD_REPEAT'])
                    throw new Exception("Данные не переданы");

                if ($data['PASSWORD'] != $data['PASSWORD_REPEAT'])
                    throw new Exception("Введенные пароли не совпадают");

                $userPhone = $userData['PERSONAL_PHONE'];

                $codeSend = $this->sendSmsCodeUser($userPhone);
                $this->userVerificationExistence($userPhone);

                $updateCodeResult = (new CUser)->Update($this->userData['ID'], ["UF_CODE" => $codeSend['CODE']]);

                if ($updateCodeResult)
                    return "Код подтверждения отправлен";
                else
                    throw new Exception("Ошибка отправки кода");
                break;

            case 'check_code':
                if (!$data['code'])
                    throw new Exception("Данные не переданы");

                if ($userData['UF_CODE'] != $data['code'])
                    throw new Exception("Код введен не верно");

                $resultChange = (new CUser())->Update(
                    $userData['ID'],
                    ['PASSWORD' => $data['USER_NEW_PASSWORD'], 'UF_CODE' => $data['USER_NEW_PASSWORD']]
                );

                if ($resultChange)
                    return "Пароль изменен успешно";
                else
                    throw new Exception("Произошла ошибка при смене пароля");
                break;
        }
    }

    /**
     * Отправка существующего кода доступа
     * @param $data
     * @return string
     * @throws Exception
     */
    public function sendingExistingAccessCode($data): string
    {
        $this->userVerificationExistence($data['phone']);

        $data['phone'] = $this->removingSymbols($data['phone']);
        $sms = $this->sendMessage($data['phone'], $this->userData['UF_CODE']);

        if ($sms->status)
            return "Код отправлен повторно";
        else
            throw new Exception("Ошибка отправления");
    }

    /**
     * Проверка на наличие пользователя
     * @param $phone
     * @throws Exception
     */
    protected function checkUserAuth($phone){
        $by = "ID";
        $order = "ASC";
        $rsUser = CUser::GetList($by, $order, ["PERSONAL_PHONE" => $phone], ["SELECT" => ["UF_CODE"]]);
        if ($arUser = $rsUser->Fetch())
            throw new Exception("Пользователь уже имеется в системе");
    }

    /**
     * Получить пользователя
     * @param $phone
     * @throws Exception
     */
    protected function userVerificationExistence($phone)
    {
        $by = "ID";
        $order = "ASC";
        $rsUser = CUser::GetList($by, $order, ["PERSONAL_PHONE" => $phone], ["SELECT" => ["UF_CODE"]]);
        if ($arUser = $rsUser->Fetch())
            $this->userData = $arUser;
        else
            throw new Exception("Пользователь не найден");
    }

    /**
     * Отправка кода доступа пользователю
     * @param $phone
     * @return array
     * @throws Exception
     */
    protected function sendSmsCodeUser($phone): array
    {
        $code = $this->generateCode();
        $phoneBySms = $this->removingSymbols($phone);
        $sms = $this->sendMessage($phoneBySms, $code);
        $email = "user-" . date('ymd') . "@" . $_SERVER['HTTP_HOST'];
        if ($sms == 'OK')
            return [
                'CODE' => $code,
                'PHONE_BY_SMS' => $phoneBySms,
                'EMAIL' => $email
            ];
        else
            throw new Exception("Не удалось отправить сообщение");
    }

    /**
     * Проверка телефонного номера
     * @param $phone
     * @return bool
     * @throws Exception
     */
    protected function validationCheckPhone($phone): bool
    {
        if (!$phone)
            throw new Exception("Номер не введен");

        if (preg_match('/^\+[7] [\(]\d{3}[\)] \d{3}-\d{2}-\d{2}$/', $phone) != 1)
            throw new Exception("Ошибка валидации номера телефона, введите номер в правильном формате: +7 (000) 000-00-00");

        return true;
    }

    /**
     * Получение случайного числа (кода)
     * @return int
     */
    protected function generateCode(): int
    {
        return rand(99999, 9999999);
    }

    /**
     * Удаление лишних символов в
     * введенном пользователем номере
     * @param $phone
     * @return string|string[]|null
     */
    protected function removingSymbols($phone)
    {
        return preg_replace('~\D+~', '', $phone);
    }

    /**
     * Отправка sms на номер пользователя
     * @param $phone
     * @param $message
     * @return stdClass|string
     */
    protected function sendMessage($phone, $message)
    {
        $smsApi = new SMSRU(SMS_KEY);
        $smsData = new stdClass();
        $smsData->to = $phone;
        $smsData->text = $message;
        $sms = $smsApi->send_one($smsData);
        return $sms->status;
    }
}
