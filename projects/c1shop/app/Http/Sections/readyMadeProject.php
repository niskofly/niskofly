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
 * Class readyMadeProject
 *
 * @property \App\Models\ReadyMadeProject $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class readyMadeProject extends Section implements Initializable
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
    protected $title = "Готовые проекты";

    /**
     * @var string
     */
    protected $alias = 'ready-made-projects';

    protected $model = 'App\Model\ReadyMadeProject';
    public function initialize()
    {
        // Добавление пункта меню и счетчика кол-ва записей в разделе
        $this->addToNavigation($priority = 10, function() {
            //return \App\Models\Article::count();
        });

        $this->creating(function($config, \Illuminate\Database\Eloquent\Model $model) {
            //...
        });
    }
    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        return AdminDisplay::table()/*->with('users')*/
        ->setHtmlAttribute('class', 'table-primary')
            ->setColumns(
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumn::link('name', 'Название проекта')->setWidth('100px'),
                AdminColumn::text(function ($query){
                    $arType = ['Российские', 'Импортные' ];
                    return $arType[$query['type']];
                }, 'Тип проекта')->setWidth('200px')
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
            AdminFormElement::text('name', 'Название проекта')->required(),
            AdminFormElement::checkbox('active', 'Опубликована')->setDefaultValue(1),
            AdminFormElement::select('type', 'Тип проекта', ['Российский', 'Импортный'])->setDefaultValue(0)->required(),
            AdminFormElement::wysiwyg('description', 'Описание проекта')->setHeight(300)->required(),
            AdminFormElement::hidden('params', 'Параметры проекта')
                ->required(),
            AdminFormElement::view('admin.params'),
            AdminFormElement::number('sort', 'Сортировка')->setDefaultValue(1),
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

    //заголовок для создания записи
    public function getCreateTitle()
    {
        return 'Добавление готового проекта';
    }

    // иконка для пункта меню - шестеренка
    public function getIcon()
    {
        return 'fa fa-check-square-o';
    }
}
