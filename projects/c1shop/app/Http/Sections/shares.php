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


class shares extends Section implements Initializable
{
    protected $checkAccess = false;

    protected $title = 'Акции';

    protected $alias = 'shares';

    protected $model = 'App\Model\share';
    public function initialize()
    {
        $this->creating(function($config, \Illuminate\Database\Eloquent\Model $model) {
        });
        $this->setRedirect(['create' => 'display', 'edit' => 'display']);

        $this->filterMark = Models\Filter::GetTypeFilter('mark');
        $this->filterType = Models\Filter::GetTypeFilter('type');
        $this->filterAction = Models\Filter::GetTypeFilter('action');
        $this->filterSeries = Models\Filter::GetTypeFilter('series');
        $this->Products = Models\Product::GetAllProducts();
        //dd($this->Products);
    }

    public function onDisplay()
    {
        return AdminDisplay::table()
        ->setHtmlAttribute('class', 'table-primary')
            ->setColumns(
                AdminColumn::text('sort', 'Сортировка')
                    ->setHtmlAttribute('class', 'hidden-sm hidden-xs foobar')
                    ->setWidth('50px'),
                AdminColumn::link('name', 'Название акции'),
                AdminColumn::text('preview_description', 'Краткое описание'),
                AdminColumn::custom('Закреплена', function ($instance) {
                    return $instance->is_pinned ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
                })->setHtmlAttribute('class', 'text-center')->setWidth('50px')
            )->paginate(20);
    }

    public function onEdit($id)
    {
        return AdminForm::panel()->addBody([
            AdminFormElement::text('name', 'Название акции')->required(),
            AdminFormElement::checkbox('active', 'Опубликована'),
            AdminFormElement::checkbox('is_pinned', 'Закреплена ')
                ->setHelpText('Если нет ни одной закреплённой записи, выводится первая по списку активная акция')
                ->setDefaultValue(0),
            AdminFormElement::number('sort', 'Значение сортировки'),
            AdminFormElement::textarea('preview_description', 'Краткое описание')->required(),
            AdminFormElement::image('new_design_image', 'Изображение для нового типа слайдера')
                ->setHelpText('Изображение для слайдера задаётся отдельно')
                ->required(),
            AdminFormElement::image('preview_image', 'Превью изображение')->required(),
            AdminFormElement::wysiwyg('full_content', 'Тело статьи/новости')->required(),

            AdminFormElement::multiselect('by_product', 'Привязка к конкретному товару')
                ->setOptions($this->Products)
                ->mutateValue(function ($value){
                    if($value == null){
                        return null;
                    }
                    return serialize($value);
                }),

            AdminFormElement::select('product_category', 'Привязка к Разделу каталога','App\Models\Categorie')
                ->setDisplay('name')
                ->setHelpText('Логика работы "ИЛИ"'),

            AdminFormElement::select('product_mark', 'Привязка к Марке')
                ->setOptions($this->filterMark)
                ->setHelpText('Логика работы "ИЛИ"'),

            AdminFormElement::select('product_action', 'Привязка к Направлению деятельности')
                ->setOptions($this->filterAction)
                ->setHelpText('Логика работы "ИЛИ"'),


            AdminFormElement::select('product_type', 'Привязка к Типу оборудования')
                ->setOptions($this->filterType)
                ->setHelpText('Логика работы "ИЛИ"'),


            AdminFormElement::text('seo_title', 'SEO заголовок'),
            AdminFormElement::textarea('seo_description', 'SEO описание'),
            AdminFormElement::textarea('seo_key', 'SEO ключи'),
            AdminFormElement::text('url', 'url категории')->setReadonly(1),
            AdminFormElement::text('id', 'ID')->setReadonly(1),
            AdminFormElement::text('created_at')->setLabel('Создано')->setReadonly(1),

        ]);
    }

    public function onCreate()
    {
        return $this->onEdit(null);
    }

    public function getCreateTitle()
    {
        return 'Добавление Акции';
    }

    public function getIcon()
    {
        return 'fa  fa-percent';
    }

    public function onDelete($id)
    {
        // remove if unused
    }

}
