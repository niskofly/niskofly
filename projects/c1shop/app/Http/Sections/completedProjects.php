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

/**
 * Class completedProjects
 *
 * @property \App\Models\CompletedProject $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class completedProjects extends Section implements Initializable
{
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $model = '\App\Models\CompletedProject';

    public function initialize()
    {
        // Добавление пункта меню и счетчика кол-ва записей в разделе
        $this->addToNavigation($priority = 10, function() {
            //return \App\Models\CompletedProject::count();
        });

        $this->creating(function($config, \Illuminate\Database\Eloquent\Model $model) {
            //...
        });
    }

    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Реализ. проекты';

    /**
     * @var string
     */
    protected $alias = 'completed_project';

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        return AdminDisplay::table()/*->with('users')*/
        ->setHtmlAttribute('class', 'table-primary')
            ->setColumns(
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumn::link('name', 'Название проекта')->setWidth('200px')
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
            AdminFormElement::wysiwyg('description', "Описание"),
            AdminFormElement::images('photos', 'Фотографии')->required()->storeAsComaSeparatedValue(),
            AdminFormElement::text('id', 'ID')->setReadonly(1),
            AdminFormElement::text('created_at')->setLabel('Создано')->setReadonly(1),

        ]);
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return AdminForm::panel()->addBody([
            AdminFormElement::text('name', 'Название настройки')->required(),
            AdminFormElement::images('photos', 'Фотографии проекта')->required()->storeAsComaSeparatedValue(),
        ]);
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
        return 'Добавление реализованного проекта';
    }

    // иконка для пункта меню - шестеренка
    public function getIcon()
    {
        return 'fa fa-check-square-o';
    }
}
