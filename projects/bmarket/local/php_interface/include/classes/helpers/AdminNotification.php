<?php

class AdminNotification
{
    protected $emails = [
        'v.ivan.korkin@gmail.com',
        'info@sopressmash.ru'
    ];
    protected $fields = [];
    protected $siteName = 'sopressmash.ru';
    protected $fromEmail = 'info@sopressmash.ru';
    protected $response = [
        'error' => true,
        'message' => 'Ошибка при отправке формы, попробуйте позже'
    ];

    /**
     * Список переменных для пиьсма
     */
    protected $fieldLabels = [
        'THEME' => 'Тема',
        'COMMENT' => 'Комментарий',
        'USER_INFO' => 'Информация о пользователе',
        'MESSAGE' => 'Текст сообщения',
        'ADD_ELEMENT_MESSAGE' => 'Больше информации',
        'NAME' => 'Имя',
        'PHONE' => 'Номер телефона',
        'EMAIL' => 'E-mail',
        'QUESTION' => 'Вопрос',
        'CITY' => 'Город',
        'REQUEST_URL' => 'URL страницы отправки',
        'INTEREST_PRODUCT' => "Интересующий товар"
    ];

    public function __construct($fields = [])
    {
        $this->fields = $fields;
    }

    public function setEmails($emails)
    {
        $this->emails = $emails;
    }

    /**
     * Отправить подготовленное сообщение администратору
     */
    public function send()
    {
        $message = $this->getMessage();
        $subject = $this->fields['THEME'] . " (Сайт - {$this->siteName})";
        $isSuccess = false;

        $headers = 'From: "' . $this->siteName . '" <' . $this->fromEmail . '>' . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html;charset=\"utf-8\" \r\n";

        if (is_array($this->emails))
            foreach ($this->emails as $email)
                $isSuccess = mail($email, $subject, $message, $headers);
        else
            $isSuccess = mail($this->emails, $subject, $message, $headers);

        if ($isSuccess)
            $this->response = [
                'error' => false,
                'message' => $this->fields['USER_RESPONSE'] ?: 'Ваша сообщение успешно отправлено'
            ];
    }

    public function checkRecaptcha()
    {
        $recaptchaResponse = $this->fields['g-recaptcha-response'];
        $isRecaptchaError = !isset($recaptchaResponse) || !trim($recaptchaResponse);

        $captchaResult = $this->getCaptcha($recaptchaResponse);
        if ($captchaResult->success != true || $captchaResult->score < 0.5)
            $isRecaptchaError = true;

        if ($isRecaptchaError) {
            $this->response = [
                'error' => true,
                'message' => 'Ошибка проверки Captcha.'
            ];
            $this->sendAjaxResultResponse();
        }
    }

    protected function getCaptcha($recaptchaResponse)
    {
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . RECAPTCHA_SECRET_KEY . "&response={$recaptchaResponse}");
        return json_decode($response);
    }

    /**
     * Подготовить контент сообщения к отправке
     * @return string
     */
    protected
    function getMessage()
    {
        $message = "";

        foreach ($this->fieldLabels as $variable => $label)
            $message .= $this->getStringMessage($variable, $label);

        return $message;
    }

    /**
     * Склеить описание и значение параметра
     * @param $variable
     * @param $label
     * @return string
     */
    protected
    function getStringMessage($variable, $label)
    {
        if (!array_key_exists($variable, $this->fields))
            return "";

        if (!$text = htmlspecialchars($this->fields[$variable]))
            return "";

        if ($label)
            $message = "<p><strong>" . $label . "</strong>: " . $text . "</p>";
        else
            $message = "<p>" . $text . "</p>";

        return $message;
    }

    /**
     * Получить результат работы
     * @return mixed
     */
    public
    function getResultResponse()
    {
        return $this->response;
    }

    /**
     * Отправить результат работы для AJAX обработчика
     */
    public
    function sendAjaxResultResponse()
    {
        die(json_encode($this->getResultResponse()));
    }
}

