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
class SeoFilters extends Section implements Initializable
{
    protected $checkAccess = false;

    protected $title = 'Статьи для фильтра';

    protected $alias = 'seo-filters';

    protected $model = 'App\Model\SeoFilter';

    public function initialize()
    {
        $this->addToNavigation($priority = 10, function () {
        });

        $this->filterMark = Models\Filter::GetTypeFilter('mark');
        $this->filterType = Models\Filter::GetTypeFilter('type');
        $this->filterSeries = Models\Filter::GetTypeFilter('series');
        $this->filterLoading = Models\Filter::GetTypeFilter('loading');
        $this->filterWidthArea = Models\Filter::GetTypeFilter('width_area');
        $this->filterPerformance = Models\Filter::GetTypeFilter('performance');
        $this->filterSolvent = Models\Filter::GetTypeFilter('solvent');
    }

    public function onDisplay()
    {
        return AdminDisplay::table()
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns(
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumn::text('categories.name', 'Раздел')->setWidth('30px'),
                AdminColumn::link('name', 'Название статьи')->setWidth('100px')
            )->paginate(20);
    }

    public function onEdit($id)
    {
        return AdminForm::panel()->addBody([
            AdminFormElement::text('name', 'Название'),
            AdminFormElement::checkbox('active', 'Опубликовано'),
            AdminFormElement::select('category', 'Категория', 'App\Models\Categorie')
                ->setDisplay('name')
                ->setSortable(false),
            AdminFormElement::select('mark', 'Mарка')
                ->setOptions($this->filterMark),

            AdminFormElement::select('type', 'Тип оборудования')
                ->setOptions($this->filterType),

            AdminFormElement::select('series', 'Серия')
                ->setOptions($this->filterSeries),

            AdminFormElement::select('loading', 'Загрузка')
                ->setOptions($this->filterLoading),

            AdminFormElement::select('width_area', 'Ширина зоны глажения')
                ->setOptions($this->filterWidthArea),

            AdminFormElement::select('performance', 'Производительность, кг/ч')
                ->setOptions($this->filterPerformance),

            AdminFormElement::select('solvent', 'Растворители')
                            ->setOptions($this->filterSolvent),

            AdminFormElement::text('seo_h1', 'Заголовок h1'),
            AdminFormElement::text('seo_h2', 'Заголовок h2'),
            AdminFormElement::wysiwyg('description', 'Тело статьи')->setHeight(900),

        ]);
    }

    public function onCreate()
    {
        return $this->onEdit(null);
    }

    public function onDelete($id)
    {

    }

    public function getIcon()
    {
        return 'fa fa-newspaper-o';
    }
}
