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
 * Class sertificate
 *
 * @property \App\Models\Sertificate $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class sertificate extends Section implements Initializable
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
    protected $title = 'Сертификаты';

    /**
     * @var string
     */
    protected $alias = 'sertificates';

    protected $model = '\App\Models\Sertificate';

    public function initialize()
    {

        $this->addToNavigation($priority = 10, function() {
            //return \App\Models\CompletedProject::count();
        });

        $this->creating(function($config, \Illuminate\Database\Eloquent\Model $model) {

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
                AdminColumn::link('name', 'Сертификат')->setWidth('200px'),
                AdminColumn::image('photo', 'Изображение сертификата')->setWidth('200px')
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
            AdminFormElement::checkbox('active', 'Опубликована')->setDefaultValue(1),
            AdminFormElement::text('name', 'Название проекта')->required(),
            AdminFormElement::image('photo', 'Фотография')->required(),
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
        return 'Добавление сертификата';
    }

    // иконка для пункта меню - шестеренка
    public function getIcon()
    {
        return 'fa  fa-certificate';
    }

}
