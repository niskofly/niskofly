<?php

class CookieFieldHandler
{
  protected $cookieField;

  public function __construct($field)
  {
    $this->cookieField = $field;
  }

  /**
   * Добавление элемента в cookie
   * @param $idElement
   */
  public function addElement($idElement)
  {
    $elementsCookie = $this->getElements();

    if (!in_array($idElement, $elementsCookie)) {
      $elementsCookie[] = $idElement;
      setcookie($this->cookieField, json_encode($elementsCookie), strtotime("+365 day"), "/");
      return [
        'count' => count($elementsCookie),
        'action' => 'add'
      ];
    }

    return false;
  }

  /**
   * Удаление элемента из cookie
   * @param $idElement
   */
  public function deleteElement($idElement)
  {
    $elementsCookie = $this->getElements();
    $elementsUpdate = [];

    foreach ($elementsCookie as $elementCookieProduct) {
      if ($elementCookieProduct === $idElement)
        continue;

      $elementsUpdate[] = $elementCookieProduct;
    }

    setcookie($this->cookieField, json_encode($elementsUpdate), strtotime("+365 day"), "/");
    return [
      'count' => count($elementsUpdate),
      'action' => 'remove'
    ];
  }

  /**
   * Получение число элементов
   */
  public function getCountElements()
  {
    return count($this->getElements());
  }

  /**
   * Получение данных из cookie в json виде
   * @return mixed
   */
  public function getElements()
  {
    return json_decode($_COOKIE[$this->cookieField]);
  }

  /**
   * Удаление всех элементов
   */
  public function deleteAllElements(): bool
  {
    return setcookie($this->cookieField, null, null, "/");
  }
}
