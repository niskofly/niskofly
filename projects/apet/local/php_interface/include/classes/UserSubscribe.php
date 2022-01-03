<?php


class UserSubscribe
{
  protected $USER_ID;
  protected $IBLOCK_ID;
  protected $email;

  public function __construct($IBLOCK_ID = null)
  {
    global $USER;
    $this->USER_ID = $USER->GetID();

    $this->IBLOCK_ID = $IBLOCK_ID;
  }

  /**
   * @param $email
   * @return string
   * @throws Exception
   */
  public function addSubscribeEmail($email): string
  {
    global $USER;
    if (!$USER->IsAuthorized())
      throw new Exception("Требуется авторизация");

    if (!$email)
      throw new Exception("Для оформления подписки нe обходимо указать email");

    $this->email = $email;

    if (!$this->checkSubscribeEmail($this->email)) {
      $this->createSubscribe($this->email);
      return "Подписка на товар добавлена в личный кабинет";
    } else {
      throw new Exception("На данный email имеется подписка");
    }
  }

  /**
   * Создание подписки пользователя
   * @param $email
   */
  public function createSubscribe($email)
  {
    $handler = new AddElementFromBitrix($this->IBLOCK_ID);
    $updatesForm = [
      "NAME" => "Дата: " . date("d.m.Y H:i:s"),
      "PREVIEW_TEXT" => 'Оформление подписки',
      "PROPERTY_VALUES" => [
        "EMAIL" => $email,
        "DATE" => date("d.m.Y H:i:s"),
        "USER" => $this->USER_ID,
        "SITE_NAME" => CSite::GetByID(SITE_ID)->Fetch()['NAME']
      ],
    ];
    $handler->insert($updatesForm, 'Подписка успешно оформлена');
  }

  /**
   * Проверка на существование
   * подписки у пользователя
   * @param $email
   * @return array
   */
  public function checkSubscribeEmail($email): array
  {
    $arFilter = [
      "IBLOCK_ID" => $this->IBLOCK_ID,
      "PROPERTY_EMAIL" => $email,
      "PROPERTY_USER" => $this->USER_ID,
      "ACTIVE" => "Y",
    ];
    $resultUser = [];
    $res = CIBlockElement::GetList([], $arFilter, false, false, ["ID"]);
    while ($ar_fields = $res->Fetch()) {
      $resultUser[] = $ar_fields;
    }
    return $resultUser;
  }
}
