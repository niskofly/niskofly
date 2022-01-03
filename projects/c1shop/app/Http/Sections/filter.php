<?php

namespace App\Http\Sections;

use SleepingOwl\Admin\Contracts\DisplayInterface;
use SleepingOwl\Admin\Contracts\FormInterface;
use SleepingOwl\Admin\Section;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Contracts\Initializable;

use App\Models;

/**
 * Class Articles
 *
 * @property \App\Models\Article $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class filter extends Section implements Initializable
{
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Фильтры каталога';

    /**
     * @var string
     */
    protected $alias = 'filters';

    protected $model = 'App\Model\Filter';
    public function initialize()
    {
        $this->creating(function($config, \Illuminate\Database\Eloquent\Model $model) {
            //...
        });
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        return AdminDisplay::datatablesAsync()
            ->setHtmlAttribute('class', 'table-info table-hover')
            ->setColumns(
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumn::link('name', 'Значение фильтра')->setWidth('70px'),
                AdminColumn::text('type_filter','Для сортировки по типу')->setWidth('100px'),
                AdminColumn::text(function ($query) {
                    return $this->arTypeFilters[$query['type_filter']];
                }, 'Тип фильтра')->setWidth('200px')
            //AdminColumn::text('preview_description', 'Краткое описание')->setWidth('200px')
            )->paginate(20);
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    protected $arTypeFilters = [
        'mark' =>'Марка',
        'type' => 'Тип оборудования',
        'loading' => 'Загрузка',
        'revers' => 'Реверс барабана',
        'width_area' => 'Ширина зоны глажения',
        'performance' => 'Производительность, кг/ч',
        'action' => 'Направление деятельности',
        'series' => 'Серия',
        'solvent' => 'Растворитель',
    ];

    public function onEdit($id)
    {
        return AdminForm::panel()->addBody([
            AdminFormElement::text('name', 'Значение фильтра')->required(),
            AdminFormElement::checkbox('active', 'Активен')->setDefaultValue(1),
            AdminFormElement::select('type_filter', 'Тип фильтра',
                $this->arTypeFilters)
                ->required(),
            AdminFormElement::select('binding_category', 'Привязка к разделу','App\Models\Categorie')
                ->setDisplay('name')
                ->setHelpText('Если выбран Тип фильтра - Тип оборудования, нужно выполнить привязку к категории'),
            AdminFormElement::text('help', 'Подсказка'),
            AdminFormElement::text('custom_value', 'url фильтра редактируемое')
                ->setHelpText('Если значение не задано, то оно генерируется автоматически'),
            AdminFormElement::text('value', 'url представление фильтра')->setReadonly(1),
            AdminFormElement::text('id', 'ID')->setReadonly(1),
            AdminFormElement::text('created_at')->setLabel('Создано')->setReadonly(1),

        ]);
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }

    /**
     * @return void
     */
    public function onDelete($id)
    {
        // todo: remove if unused
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // todo: remove if unused
    }

    //заголовок для создания записи
    public function getCreateTitle()
    {
        return 'Добавление пункта фильтра';
    }

    // иконка для пункта меню - шестеренка
    public function getIcon()
    {
        return 'fa  fa-filter';
    }
}
