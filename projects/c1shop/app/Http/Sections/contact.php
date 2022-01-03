<?php

namespace App\Http\Sections;

use AdminColumnEditable;
use SleepingOwl\Admin\Contracts\DisplayInterface;
use SleepingOwl\Admin\Contracts\FormInterface;
use SleepingOwl\Admin\Section;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Contracts\Initializable;

use App\Models;

class contact extends Section implements Initializable
{
    protected $checkAccess = false;
    protected $title = 'Контакты';
    protected $alias = 'contacts';
    protected $model = 'App\Model\Contact';

    public function initialize()
    {
        $this->addToNavigation($priority = 10)->setIcon('fa  fa-id-card-o');
    }

    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync()
            ->setDisplaySearch(true);

        $display->setHtmlAttribute('class', 'table-primary')
            ->setColumns(
                AdminColumn::link('city', 'Город')->setWidth('100px'),
                AdminColumn::text('coordinates', 'Координаты')->setWidth('100px'),
                AdminColumn::text('phone_text', 'Текст контактов'),
                AdminColumn::text('address', 'Адрес'),
                AdminColumnEditable::checkbox('published')
                    ->setLabel('Опубликован')
                    ->setCheckedLabel('Да')
                    ->setWidth('150px'),
                AdminColumnEditable::checkbox('is_branch')
                                   ->setLabel('Филиал')
                                   ->setCheckedLabel('Да')
                                   ->setWidth('150px')
            )->setOrder(1, 'asc')
            ->paginate(50);

        return $display;
    }

    public function onEdit($id)
    {
        return AdminForm::panel()->addBody([
            AdminFormElement::checkbox('published', 'Опубликован')->setDefaultValue(1),
            AdminFormElement::checkbox('is_branch', 'Филиал')->setDefaultValue(0),
            AdminFormElement::textarea('phone_text', 'Контактные данные')
                ->setDefaultValue('<span>Имя</span>
                                    <span>Тел.: <a href="tel:бесплатный звонок ">бесплатный звонок  </a>(бесплатный звонок по РФ)</span>
                                    <span>Тел./факс:
                                    <a href="tel:дополнительный номер"> дополнительный номер</a>
                                    </span>')
                ->required(),
            AdminFormElement::text('time', 'Время работы'),
            AdminFormElement::text('email', 'Почта'),
            AdminFormElement::text('skype', 'Skype'),
            AdminFormElement::text('coordinates', 'Координаты организации ')
                ->setHtmlAttribute('class', 'js-input-coordinates')
                ->setHelpText('Введите адрес в поисковое поле и передвинте метку на нужную точку')
                ->required(),
            AdminFormElement::view('admin.map-non-name', $data = ['namePoint' => 'Офис']),
            AdminFormElement::text('city', 'Город')
                ->required()
                ->setHtmlAttribute('class', 'js-input-city'),
            AdminFormElement::text('address', 'Адрес огранизации')
                ->required()
                ->setHtmlAttribute('class', 'js-input-address'),
            AdminFormElement::text('transport_company', 'Транспортная компания'),
            AdminFormElement::text('id', 'ID')->setReadonly(1),
            AdminFormElement::text('created_at')->setLabel('Создано')->setReadonly(1),
        ]);
    }

    public function onCreate()
    {
        return $this->onEdit(null);
    }

    public function onDelete($id)
    {
    }

    public function getCreateTitle()
    {
        return 'Добавление Контактов';
    }
}
