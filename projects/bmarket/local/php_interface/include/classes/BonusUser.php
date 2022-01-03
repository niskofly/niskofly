<?php
\Bitrix\Main\Loader::includeModule('sale');
\Bitrix\Main\Loader::includeModule('catalog');

class BonusUser
{
    const CURRENCY = 'RUB';

    /**
     * Количество бонусов начисляемых при создании счёта
     */
    const START_BONUS_AMOUNT = 0;

    /**
     * Какой процент от стоимости заказа можно оплатить баллами
     */
    const AVAILABLE_PERCENT = 20;

    /**
     * Какой процент от стоимости товаров начисляется в качестве бонусов
     */
    const ACCRUED_PERCENT = BONUSES_PERCENT;

    /**
     * Получить счёт пользователя
     *
     * @param null $userId
     * @return array|bool|null
     */
    public static function getAccount($userId = null)
    {
        global $USER;
        $userId = $userId ? $userId : $USER->GetID();

        if (!$userId)
            return null;

        $account = CSaleUserAccount::GetByUserID($userId, self::CURRENCY);
        return $account ? $account : self::createAccount($userId);
    }

    /**
     * Создать счёт пользователя
     * CURRENCY и CURRENT_BUDGET берётся из констант класса
     *
     * @param null $userId
     * @return array|bool|null
     */
    public static function createAccount($userId = null)
    {
        global $USER;
        $userId = $userId ? $userId : $USER->GetID();

        if (!$userId)
            return null;

        $settings = [
            'USER_ID' => $userId,
            'CURRENCY' => self::CURRENCY,
            'CURRENT_BUDGET' => self::START_BONUS_AMOUNT,
            'NOTES' => 'Бонус за регистрацию'
        ];

        $accountId = CSaleUserAccount::Add($settings);
        return CSaleUserAccount::GetByID($accountId);
    }

    /**
     * Получить общее количество бонусов у пользователя
     * @param null $userId
     * @return false|float|int
     */
    public static function getNumberBonuses($userId = null)
    {
        $account = self::getAccount($userId);
        return $account ? round($account['CURRENT_BUDGET']) : 0;
    }



    /**
     *************************
     * ОПЛАТА ЗАКАЗА БАЛЛАМИ
     * ***********************
     */

    /**
     * Списать баллы со счёта
     *
     * @param $amountCharge
     * @param null $userId
     * @return null
     */
    public static function deductPointsFromAccount($amountCharge, $userId = null)
    {
        global $USER;
        $userId = $userId ? $userId : $USER->GetID();
        if (!$userId)
            return null;

        $account = self::getAccount($userId);
        if (!$account)
            return null;

        $amountCharge = ($account['CURRENT_BUDGET'] <= $amountCharge) ? $account['CURRENT_BUDGET'] : $amountCharge;
        CSaleUserAccount::UpdateAccount($userId, '-' . $amountCharge, self::CURRENCY, 'Оплата заказа бонусами');
    }

    /**
     * Получить количество баллов доступных для списания
     *
     * @param $costProducts
     * @return float|int|null
     */
    public static function getBonusAmountAvailableForWithdrawal($costProducts)
    {
        $account = BonusUser::getAccount();
        if (!$account)
            return null;

        $amountAvailable = $costProducts / 100 * self::AVAILABLE_PERCENT;
        return ($account['CURRENT_BUDGET'] <= $amountAvailable) ? (int)$account['CURRENT_BUDGET'] : (int)$amountAvailable;
    }

    /**
     * Получить количество баллов начисляемых за заказ
     *
     * @param $costProducts
     * @param bool $isRender
     * @return float|string
     */
    public static function getAccruedBonus($costProducts, $isRender = true)
    {
        $accruedBonus = $costProducts / 100 * self::ACCRUED_PERCENT;

        if (!$isRender)
            return round($accruedBonus);

        $accruedBonusFormatted = number_format($accruedBonus, 0, '.', ' ');
        return '+ ' . $accruedBonusFormatted . ' бонус' . getEncoding($accruedBonus) . ' за заказ';
    }


    /**
     * Обновить баланс бонусного счёта пользователя
     * @param $userId
     * @param $balance
     * @param string $note
     */
    public static function updateAccountBalance($userId, $balance, $note = '')
    {
        $account = self::getAccount($userId);

        if (!$account)
            return;

        $settings = [
            'USER_ID' => $userId,
            'CURRENCY' => self::CURRENCY,
            'CURRENT_BUDGET' => $balance,
            'NOTES' => $note
        ];

        CSaleUserAccount::Update($account['ID'], $settings);
    }
}
