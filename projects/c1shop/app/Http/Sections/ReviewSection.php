<?php

namespace App\Http\Sections;

use SleepingOwl\Admin\Section;
use AdminColumnEditable;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Contracts\Initializable;

use App\Models;


class ReviewSection extends Section implements Initializable
{
    protected $checkAccess = false;

    protected $title = 'Отзывы';

    public function initialize()
    {
        $this->addToNavigation($priority = 7, function() {
        });
    }

    public function onDisplay()
    {
        return AdminDisplay::table()
        ->setHtmlAttribute('class', 'table-primary')
            ->setColumns(
                AdminColumn::link('company', 'Комания')->setWidth('300px'),
                AdminColumn::text('curt_text', 'Краткое содержание')->setWidth('500px'),
                AdminColumn::text( function ($query){
                    return $query['published'] ? "Да" : "Нет";
                }, 'Опубликован')->setWidth('200px'),
                AdminColumn::text('order')->setLabel('Сортировка')
            )->setApply(function ($query) {
                $query->orderBy('order', 'asc');
            })
            ->paginate(20);
    }

    public function onEdit($id)
    {
        return AdminForm::panel()->addBody([
            AdminFormElement::text('author', 'Автор')->required(),
            AdminFormElement::text('company', 'Комания')->required(),
            AdminFormElement::file('file', 'Файл')->required(),
            AdminFormElement::textarea('curt_text', 'Краткое содержание')->required(),
            AdminFormElement::checkbox('published', 'Опубликована')->setDefaultValue(1),
            AdminFormElement::number('order', 'Сортировка')
                ->setHelpText('Направление сортировки от меньшего к большему')
                ->setDefaultValue(500)
        ]);
    }


    public function onCreate()
    {
        return $this->onEdit(null);
    }

    public function onDelete($id)
    {
        // todo: remove if unused
    }


    public function getIcon()
    {
        return 'fa  fa-comments-o';
    }
}
