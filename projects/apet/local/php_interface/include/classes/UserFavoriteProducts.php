<?php

class UserFavoriteProducts
{
    protected $userId;
    protected $action = 'add';

    public function __construct()
    {
        global $USER;
        $this->userId = $USER->GetID();
    }

    /**
     * Получить список ID товаров в избранном списке пользователя
     * @return array|false|string[]
     * @throws Exception
     */
    public function getFavorites()
    {
        if (!$this->userId)
            throw new Exception("Пользователь не авторизирован");

        $user = CUser::GetByID($this->userId)->Fetch();
        return trim($user['UF_FAVORITES']) ? explode('|', $user['UF_FAVORITES']) : [];
    }

    /**
     * Добавить или удалить товар из избранного
     * @param null $productId
     * @return array
     * @throws Exception
     */
    public function addOrRemoveProduct($productId = null): array
    {
        if (!$productId)
            throw new Exception("Ошибка добавления в избранное. не указан ID товара");

        $favorites = $this->getFavorites();

        if ($favorites === null)
            throw new Exception("Список избранного пуст");

        if (in_array($productId, $favorites)) {
            $this->action = 'remove';
            unset($favorites[array_search($productId, $favorites)]);
        } else {
            $this->action = 'add';
            $favorites[] = $productId;
        }

        return $this->saveUserFavorites($favorites);
    }

    /**
     * Сохранить новый массив избранных товаров пользователя
     * @param array $favorites
     * @return array
     */
    public function saveUserFavorites($favorites = []): array
    {
        global $USER;
        $USER->Update($this->userId, ['UF_FAVORITES' => implode('|', $favorites)]);
        return [
            'count' => count($favorites),
            'action' => $this->action
        ];
    }

    /**
     * Получить количество элементов в списке избранных товаров
     * @return false|int
     * @throws Exception
     */
    public function getCountFavorites()
    {
        $favorites = $this->getFavorites();
        return $favorites ? count($favorites) : false;
    }

    /**
     * Проверить находится ли товар в списке избранного
     * @param $productId
     * @return bool
     * @throws Exception
     */
    public function checkInFavorite($productId): bool
    {
        if (!$this->userId)
            throw new Exception("Пользователь не авторизирован");

        /**
         * Если функция уже запрашивалась берём данные из глобального массива
         */
        $cacheKey = "USER_{$this->userId}_FAVORITES";
        if (isset($GLOBALS[$cacheKey])) {
            $favorites = $GLOBALS[$cacheKey];
        } else {
            $GLOBALS[$cacheKey] = $favorites = $this->getFavorites();
        }

        return in_array($productId, $favorites);
    }
}