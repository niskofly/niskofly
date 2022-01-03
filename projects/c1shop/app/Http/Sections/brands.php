<?php

namespace App\Http\Sections;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use AdminSection;
use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Contracts\Initializable;


/**
 * Class brands
 *
 * @property \App\Models\Brand $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class brands extends Section implements Initializable
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
    protected $title = "Бренды";

    /**
     * @var string
     */
    protected $alias = "brands";

    protected $model = 'App\Model\Brand';
    public function initialize()
    {
        $this->filterMark = \App\Models\Filter::GetTypeFilter('mark');

        $this->creating(function($config, \Illuminate\Database\Eloquent\Model $model) {
            //...
        });
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        return AdminDisplay::table()
            ->setHtmlAttribute('class', 'table-primary')
            ->setApply(function ($query) {
                $query->orderBy('order', 'asc');
            })
            ->setColumns(
                AdminColumn::text('order')->setLabel('Сортировка')->setWidth('30px'),
                AdminColumn::link('name', 'Название бренда')->setWidth('100px'),
                AdminColumn::image('photo', 'Логотип')->setWidth('200px')
                //AdminColumn::text('categories_id', 'Связка с категорией')->setWidth('200px')
            )->paginate(20);
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        return AdminForm::panel()->addBody([
            AdminFormElement::number('order', 'Сортировка')->setDefaultValue(1),
            AdminFormElement::text('name', 'Название бренда')->required(),
            AdminFormElement::select('categories_id', 'Привязка к разделу','App\Models\Categorie')
                ->setDisplay('name'),
            AdminFormElement::select('filter_mark', 'Привязка к фильтру производитель')
                ->setOptions($this->filterMark),
            AdminFormElement::checkbox('active', 'Опубликован')->setDefaultValue(1),
            AdminFormElement::image('photo', 'Логотип')->required(),
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
        // remove if unused
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }

    public function getCreateTitle()
    {
        return 'Добавление бренда';
    }

    // иконка для пункта меню - шестеренка
    public function getIcon()
    {
        return 'fa  fa-product-hunt';
    }
}
