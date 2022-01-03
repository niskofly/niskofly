<?php


class UserOrderProfiles
{
    protected $response;
    protected $USER_ID;

    public function __construct()
    {
        global $USER;
        $this->USER_ID = $USER->GetID();

        $this->response = [
            'error' => true,
            'message' => 'Ошибка выполнения',
        ];
    }

    /**
     * Создание пользовательского профиля
     * @param $data
     * @param $file
     * @return array
     */
    public function createProfile($data, $file): array
    {
        if (!$data)
            return $this->response = [
                'error' => true,
                'message' => 'Ошибка получаемых данных'
            ];

        $typeUser = $data['TYPE_USER_PROFILE'];

        $userProfile = [
            "NAME" => "Профиль" . " " . date("d.m.Y H:i:s"),
            "USER_ID" => $this->USER_ID,
            "PERSON_TYPE_ID" => $typeUser
        ];
        $userProfileId = (new CSaleOrderUserProps)->Add($userProfile);

        foreach ($data['CREATE_DATA'] as $propId => $value) {
            $arFields = array(
                "USER_PROPS_ID" => $userProfileId,
                "ORDER_PROPS_ID" => $propId,
                "NAME" => $value,
                "VALUE" => $value,
            );
            (new CSaleOrderUserPropsValue)->Add($arFields);
        }

        if ($file) {
            $fileArray = AddElementFromBitrix::getSavedFileArray($file);

            foreach ($fileArray as $key => $arFile) {
                $userData = [
                    'USER_PROFILE_ID' => $userProfileId,
                    'PROPERTY_ID' => (integer)explode("_", $key)[1],
                ];
                $fileData = [
                    'FILE' => $arFile
                ];
                $this->loadingUserFile($userData, $fileData);
            }
        }

        if ($userProfileId)
            return $this->response = [
                'error' => false,
                'message' => 'Профиль' . ' ' . $userProfileId . ' ' . 'успешно создан'
            ];
        else
            return $this->response = [
                'error' => true,
                'message' => 'Ошибка при создании профиля'
            ];
    }

    /**
     * Получение пользовательских профилей
     * @return array|null
     */
    public function getProfiles(): ?array
    {
        global $USER;
        $aUserProfiles = [];
        $aUserProfilesValue = [];

        $userProfiles = CSaleOrderUserProps::GetList(
            ["DATE_UPDATE" => "ASC"],
            ["USER_ID" => $USER->GetID()],
            false,
            false,
            []
        );

        while ($userProfile = $userProfiles->Fetch()) {
            $userProfilesValue = CSaleOrderUserPropsValue::GetList(
                ["ID" => "ASC"],
                ["USER_PROPS_ID" => $userProfile['ID']],
                false,
                false,
                ["NAME", "VALUE", "CODE", "PROP_ID"]
            );

            while ($userProfileValue = $userProfilesValue->Fetch())
                $aUserProfilesValue[$userProfileValue["CODE"]] =
                    $userProfileValue['PROP_TYPE'] == 'FILE'
                        ?
                        [
                            'FILE_NAME' => $userProfileValue['NAME'],
                            'FILE_ID' => unserialize($userProfileValue['VALUE'])[0],
                            'PROP_ID' => $userProfileValue['PROP_ID'],
                            'FILE_PATH' => CFile::GetPath(array_values(unserialize($userProfileValue['VALUE']))[0])
                        ]
                        : $userProfileValue;

            $aUserProfiles[] = [
                'PROFILE_INFO' => $userProfile,
                'PROFILE_VALUE' => $aUserProfilesValue,
            ];
        }

        if ($aUserProfiles)
            return $aUserProfiles;
        else
            return null;
    }

    /**
     * Удаление пользовательского профиля
     * @param $profileId
     * @return array
     */
    public function deleteProfile($profileId): array
    {
        $resultDelete = (new CSaleOrderUserProps)->Delete($profileId);
        if ($resultDelete)
            return $this->response = [
                'error' => false,
                'message' => 'Удаление профиля' . ' ' . $profileId . ' ' . 'выполнено'
            ];
        else
            return $this->response = [
                'error' => true,
                'message' => 'Ошибка удаление профиля'
            ];
    }

    /**
     * Изменение пользовательского профиля
     * @param $data
     * @return array
     */
    public function editProfile($data): array
    {
        if (!$data)
            return $this->response = [
                'error' => true,
                'message' => 'Данные не переданы'
            ];

        foreach ($data['PROPERTIES'] as $key => $val) {
            $userProfileId = $data['PROFILE_ID'];
            $getUserProfileId = $this->getUserProfileId($userProfileId, $key);
            $arFields = array(
                "ID" => $getUserProfileId,
                "USER_PROPS_ID" => $userProfileId,
                "ORDER_PROPS_ID" => $key,
                "VALUE" => $val,
            );
            $resultUpdate = (new CSaleOrderUserPropsValue)->Update($getUserProfileId, $arFields);
            if ($resultUpdate)
                return $this->response = [
                    'error' => false,
                    'message' => 'Элемент изменен'
                ];
            else
                return $this->response = [
                    'error' => true,
                    'message' => 'Ошибка при изменении элемента'
                ];
        }
    }

    /**
     * Загрузка файла в профиль пользователя
     * @param $data
     * @param $file
     * @return array
     */
    public function loadingUserFile($data, $file): array
    {
        if (!$data && !$file['FILE']['tmp_name'])
            return $this->response = [
                'error' => true,
                'message' => 'Данные не переданы'
            ];

        $fileParams = [
            "name" => $file['FILE']['name'],
            "size" => $file['FILE']['size'],
            "tmp_name" => $file['FILE']['tmp_name'],
            "type" => $file['FILE']['type'],
        ];

        $fileId = CFile::SaveFile($fileParams, "/sale/order/properties");

        $userProfileId = $data['USER_PROFILE_ID'];
        $getUserProfileId = $this->getUserProfileId($userProfileId, $data['PROPERTY_ID']);

        $resultUpdate = (new CSaleOrderUserPropsValue)->Update(
            $getUserProfileId,
            array(
                "ID" => $getUserProfileId,
                "USER_PROPS_ID" => $userProfileId,
                "ORDER_PROPS_ID" => $data['PROPERTY_ID'],
                "VALUE" => serialize([0 => $fileId])
            )
        );
        if ($resultUpdate)
            return $this->response = [
                'error' => false,
                'message' => 'Файл успешно' . ' ' . $resultUpdate . ' ' . 'изменен'
            ];
        else
            return $this->response = [
                'error' => true,
                'message' => 'Ошибка изменения файла'
            ];
    }

    /**
     * Получение id элемента изменения
     * @param $userProfileId
     * @param $propId
     * @return mixed
     */
    public function getUserProfileId($userProfileId, $propId)
    {
        $userProfiles = CSaleOrderUserPropsValue::GetList(
            ["ID" => "ASC"],
            ["USER_PROPS_ID" => $userProfileId, "ORDER_PROPS_ID" => $propId],
            false,
            false,
            ["ID"]
        );

        while ($userProfile = $userProfiles->Fetch()) {
            return $userProfile["ID"];
        }
    }

    /**
     * Получить результат работы
     * @return array
     */
    public function getResultResponse(): array
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