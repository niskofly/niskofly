<?php

class UserFavoriteProducts
{
    protected $response = [
        'error' => true,
        'title' => 'Пожалуйста, авторизуйтесь',
        'message' => 'Чтобы мы могли сохранить понравившиеся товары, Вам нужно зайти в личный кабинет'
    ];
    protected $userId = null;
    protected $action = 'add';
    protected $productId = null;

    public function __construct()
    {
        global $USER;
        $this->userId = $USER->IsAuthorized() ? $USER->GetID() : null;
    }

    /**
     * Получить список ID товаров в избранном списке пользователя
     * @return array|null
     */
    public function getFavorites()
    {
        if (!$this->userId)
            return null;

        $user = CUser::GetByID($this->userId)->Fetch();
        return trim($user['UF_FAVORITES']) ? explode('|', $user['UF_FAVORITES']) : [];
    }

    /**
     * Добавить или удалить товар из избранного
     * @param null $productId
     * @return null|string
     */
    public function addOrRemoveProduct($productId = null)
    {
        if (!$productId)
            return $this->response['message'] = 'Ошибка добавления в избранное. не указан ID товара';

        $this->productId = $productId;

        $favorites = $this->getFavorites();
        if ($favorites === null)
            return null;

        if (in_array($productId, $favorites)) {
            $this->action = 'remove';
            unset($favorites[array_search($productId, $favorites)]);
        } else {
            $this->action = 'add';
            $favorites[] = $productId;
        }

        $this->saveUserFavorites($favorites);
    }

    /**
     * Сохранить новый массив избранных товаров пользователя
     * @param array $favorites
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\ArgumentTypeException
     * @throws \Bitrix\Main\NotImplementedException
     */
    public function saveUserFavorites($favorites = [])
    {
        global $USER;
        $USER->Update($this->userId, ['UF_FAVORITES' => implode('|', $favorites)]);

        $this->response = [
            'error' => false,
            'message' => '',
            'count' => count($favorites),
            'action' => $this->action,
            'eCommerceProduct' => ItemsBitrixCart::getECommerceData(['product_id' => $this->productId])
        ];
    }

    /**
     * Получить количество элементов в списке избранных товаров
     * @return bool|int
     */
    public function getCountFavorites()
    {
        $favorites = $this->getFavorites();
        return $favorites ? count($favorites) : false;
    }

    public function getResponse()
    {
        return json_encode($this->response);
    }

    /**
     * Проверить находится ли товар в списке избранного
     * @param $productId
     * @return bool
     */
    public static function checkInFavorite($productId)
    {
        global $USER;
        $userId = $USER->IsAuthorized() ? $USER->GetID() : null;
        if (!$userId)
            return false;

        /**
         * Если функция уже запрашивалась берём данные из глобального массива
         */
        $cacheKey = "USER_{$userId}_FAVORITES";
        if (isset($GLOBALS[$cacheKey]))
            $favorites = $GLOBALS[$cacheKey];
        else
            $GLOBALS[$cacheKey] = $favorites = (new self())->getFavorites();

        return in_array($productId, $favorites);
    }
}
