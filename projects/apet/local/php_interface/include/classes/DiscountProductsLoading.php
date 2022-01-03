<?

use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

Loader::includeModule("highloadblock");
CModule::IncludeModule('sale');

class DiscountProductsLoading
{
    protected $highBlocks = [
        'nomenclature' => 2, //Nomenklatura
        'stamp' => 3, //Marki
        'discount' => 4 //SkidkiNatsenki
    ];


    /**
     * Получение данных о скидках из HighBlock
     * (Процент скидки и название)
     * @return array
     */
    public function getDiscountData(): array
    {
        $hiBlockData = $this->getDataInHighBlock(4);

        $discountsData = [];

        foreach ($hiBlockData as $element) {
            $discountValue = (integer)$element['UF_ZNACHENIESKIDKINA'];
            $discountsData[$discountValue] = $element['UF_NAME'];
        }

        return $discountsData;
    }


    /**
     * Создание групп пользователей
     * @param $discountsData
     * @return array
     * @throws Exception
     */
    public function createUserGroups($discountsData): array
    {
        if (!$discountsData)
            throw new Exception("Данные не переданы");

        $group = new CGroup;

        $createGroupsID = [];

        foreach ($discountsData as $discountPercent => $discountName) {
            $arFields = [
                "ACTIVE" => "Y",
                "C_SORT" => 301,
                "NAME" => $discountName,
                "DESCRIPTION" => "Предоставление скидки в размере $discountPercent %",
                "USER_ID" => [],
                "STRING_ID" => "DISCOUNT_GROUP_$discountPercent"
            ];
            $createGroupsID[] = $group->Add($arFields);
        }

        return $createGroupsID;
    }


    /**
     * Получение пользователя по xml
     * @param $xml
     * @return array
     */
    public function getUserByXml($xml): ?array
    {
        $userData = [];

        $users = CUser::GetList(
            $by = "id", $order = "desc",
            ["ACTIVE" => 'Y', "XML_ID" => $xml],
            ['SELECT' => ['*', 'UF_*']]
        );

        while ($user = $users->GetNext())
            $userData[] = $user;

        return $userData ?: null;
    }

    /**
     * Получение данных highBlocks
     * @param $highBlockID
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function getDataInHighBlock($highBlockID): array
    {
        $resultsData = $this->getEntityInHighBlock($highBlockID)->getDataClass()::getList([
            "select" => ["*"],
            "order" => ["ID" => "ASC"],
            "filter" => []
        ]);

        $returnData = [];

        while ($resultData = $resultsData->Fetch()) {
            $returnData[] = $resultData;
        }

        return $returnData ?: [];
    }


    /**
     * Удаление записи в highBlock
     * @param $highBlockID
     * @param $deleteRecord
     * @return \Bitrix\Main\ORM\Data\DeleteResult
     * @throws Exception
     */
    public function deleteDataInHighBlock($highBlockID, $deleteRecord): \Bitrix\Main\ORM\Data\DeleteResult
    {
        $resultsData = $this->getEntityInHighBlock($highBlockID)->getDataClass();
        return $resultsData::Delete("$deleteRecord");
    }


    /**
     * Создание правила работы корзины в bitrix
     */
    public function createShoppingCartRuleInBitrix()
    {
        $fields = [
            'LID' => 's2',
            'NAME' => 'Testing111',
            'ACTIVE_FROM' => '',
            'ACTIVE_TO' => '',
            'ACTIVE' => 'Y',
            'SORT' => '100',
            'PRIORITY' => '1',
            'LAST_DISCOUNT' => 'Y',
            'LAST_LEVEL_DISCOUNT' => 'N',
            'XML_ID' => '',
            'CONDITIONS' => [
                'CLASS_ID' => 'CondGroup',
                'DATA' => [
                    'All' => 'AND',
                    'True' => 'True'
                ],
                'CHILDREN' => []
            ],
            'ACTIONS' => [
                'CLASS_ID' => 'CondGroup',
                'DATA' => [
                    'All' => 'AND'
                ],
                'CHILDREN' => [
                    0 => [
                        'CLASS_ID' => 'ActSaleBsktGrp',
                        'DATA' => [
                            'Type' => 'Discount',
                            'Value' => floatval(7),
                            'Unit' => 'Perc',
                            'Max' => 0,
                            'All' => 'AND',
                            'True' => 'True',
                        ],
                        'CHILDREN' => [
                            0 => [
                                'CLASS_ID' => 'CondIBCode',
                                'DATA' => [
                                    'logic' => 'Equal',
                                    'value' => '311'
                                ]
                            ]
                        ]
                    ]
                ]
            ],

            'USER_GROUPS' => [1, 2, 3, 4] // todo: получение id групп со скидками
        ];

        return CSaleDiscount::Add($fields);
    }


    /**
     * Создает взаимодействия с highBlock
     * @param $highBlockID
     * @return Entity\Base
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    private function getEntityInHighBlock($highBlockID): Entity\Base
    {
        $highBlock = HL\HighloadBlockTable::getById($highBlockID)->fetch();
        return HL\HighloadBlockTable::compileEntity($highBlock);
    }
}
