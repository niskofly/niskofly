<?php

namespace App\Http\Sections;

use Illuminate\Database\Eloquent\Model;
use App\Models\Brochure;
use App\Models\BrochureType;
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
 * Class Brochure
 *
 * @property \App\Models\Brochure $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class brochures extends Section implements Initializable
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
    protected $title = "Рекламные проспекты";

    /**
     * @var string
     */
    protected $alias = "brochures";

    protected $model = 'App\Model\Brochure';
    public function initialize()
    {
        $this->addToNavigation($priority = 10, function () {
            //return \App\Models\CompletedProject::count();
        });
        $this->creating(function($config, Model $model) {
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
            ->setColumns(
                AdminColumn::link('name', 'Название'),
                AdminColumn::image('img', 'Логотип'),
                AdminColumn::text('type_id', 'Тип документа')->setName(function($model) {
                    $type = $model->getType($model->type_id);
                    return ($type !== null) ? $type->name : '<span class="text-gray">-не указан-</span>';
                })
            )->paginate(20);
    }

    /**
     * @param $id
     *
     * @return \SleepingOwl\Admin\Form\FormPanel
     * @throws \SleepingOwl\Admin\Exceptions\Form\Element\SelectException
     */
    public function onEdit($id)
    {
        return AdminForm::panel()->addBody([
            AdminFormElement::text('name', 'Название')->required(),
            AdminFormElement::checkbox('active', 'Опубликован')->setDefaultValue(1),
            AdminFormElement::select('type_id', 'Тип документа', false)
                            ->setModelForOptions(BrochureType::class)
                            ->setDisplay('name')
                            ->nullable(),
            AdminFormElement::image('img', 'Изображение')->required(),
            AdminFormElement::file('file', 'Документ')->required()
        ]);
    }

    /**
     * @return \SleepingOwl\Admin\Form\FormPanel
     * @throws \SleepingOwl\Admin\Exceptions\Form\Element\SelectException
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

    /**
     * Иконка для пункта меню.
     *
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-star';
    }
}
