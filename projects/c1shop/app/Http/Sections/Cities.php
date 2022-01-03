<?php

namespace App\Http\Sections;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use AdminColumnEditable;
use AdminSection;
use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Contracts\Initializable;

class Cities extends Section implements Initializable
{
    protected $checkAccess = false;
    protected $title = 'Города';
    protected $model = 'App\Model\City';
    protected $alias = 'cities';

    public function initialize()
    {
        $this->addToNavigation($priority = 9)->setIcon('fa fa-map-marker');
    }

    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync()
            ->setDisplaySearch(true);

        $display->setHtmlAttribute('class', 'table-primary')
            ->setColumns(
                AdminColumn::link('name', 'Название')->setWidth('100px'),
                AdminColumn::text('code', 'URL')->setWidth('200px'),
                AdminColumnEditable::checkbox('is_fast')
                    ->setLabel('Быстрой выбор')
                    ->setCheckedLabel('Да')
                    ->setWidth('150px'),
                AdminColumnEditable::checkbox('published')
                    ->setLabel('Опубликован')
                    ->setCheckedLabel('Да')
                    ->setWidth('150px')
            )->setOrder(0, 'asc')
            ->paginate(20);

        return $display;
    }

    public function onEdit($id)
    {
        return AdminForm::panel()->addBody([
            AdminFormElement::text('name', 'Название')->required(),
            AdminFormElement::text('code', 'URL')->required(),
            AdminFormElement::checkbox('published', 'Опубликован')->setDefaultValue(1),
            AdminFormElement::checkbox('is_fast', 'Показывать в быстром выборе')->setDefaultValue(1),
            AdminFormElement::text('seo_part', 'SEO окончание для title и description')->required(),
        ]);
    }

    public function onCreate()
    {
        return $this->onEdit(null);
    }

    public function onDelete($id)
    {

    }
}
