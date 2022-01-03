<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use AdminSection;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use SleepingOwl\Admin\Contracts\Initializable;


use App\Models;

/**
 * Class product
 *
 * @property \App\Models\Part $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class parts extends Section implements Initializable
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
    protected $title = 'Запчасти';

    /**
     * @var string
     */
    protected $alias = 'parts';

    protected $model = 'App\Model\Part';

    protected $filterMark;

    public function initialize()
    {
        // Добавление пункта меню и счетчика кол-ва записей в разделе
        $this->addToNavigation($priority = 1, function () {

        });

        $this->creating(function ($config, \Illuminate\Database\Eloquent\Model $model) {
            //...
        });

        $this->filterMark = Models\Filter::GetTypeFilter('mark');
        $this->filterType = Models\Filter::GetTypeFilter('type');
        /*$this->filterLoading = Models\Filter::GetTypeFilter('loading');
        $this->filterRevers = Models\Filter::GetTypeFilter('revers');
        $this->filterWidthArea = Models\Filter::GetTypeFilter('width_area');
        $this->filterPerformance = Models\Filter::GetTypeFilter('performance');
        $this->filterAction = Models\Filter::GetTypeFilter('action');
        $this->filterSeries = Models\Filter::GetTypeFilter('series');
        $this->filterSolvent = Models\Filter::getTypeFilter('solvent');*/

    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync()
            ->setDisplaySearch(true)
            ->setOrder([0, 'asc'])
            ->paginate(20);

        $display->setHtmlAttribute('class', 'table-info table-hover');

        //$display->with('category', 'id');

        $display->setFilters(
            AdminDisplayFilter::related('category')->setModel(Models\Categorie::class)->setTitle(function ($value) {
                $category = Models\Categorie::find($value);
                return $category->name;
            })
        );

        $display->setColumns([

            AdminColumn::text('sort', 'SORT')
                ->setHtmlAttribute('class', 'hidden-sm hidden-xs foobar')
                ->setWidth('10px'),

            $photo = AdminColumn::image('photo', 'Фото')
                ->setHtmlAttribute('class', 'hidden-sm hidden-xs foobar')
                ->setWidth('100px'),

            AdminColumn::link('name', 'Название Товара')
                ->setWidth('200px'),
/*
            $category = AdminColumn::text('categorie.name', 'Категория')
                ->setHtmlAttribute('class', 'hidden-sm hidden-xs hidden-md')
                ->setWidth('150px')
                ->setSearchCallback(function () {
                    return 1;
                })
                ->append(
                    AdminColumn::filter('category')
                ),*/
           /* AdminColumn::lists('category_parts.name', 'Дополнительные категории')
                ->setSearchCallback(function () {
                    return 1;
                })->setWidth('200px'),*/


            AdminColumn::datetime('updated_at', 'Дата изменения')
                ->setWidth('150px')
                ->setHtmlAttribute('class', 'text-center')
                ->setFormat('d.m.Y'),

        ]);

        /*$photo->getHeader()->setHtmlAttribute('class', 'hidden-sm hidden-xs');
        $category->getHeader()->setHtmlAttribute('class', 'hidden-sm hidden-xs hidden-md');*/

        return $display;

    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */


    public function onEdit($id)
    {
        $parentCategory = Models\Categorie::get()->map(function ($item) {
            return $item['name'];
        })->toArray();


        $form = AdminForm::panel();

        $form->addHeader([
            /*AdminFormElement::checkbox('block_to_yml', 'Не добавлять в выгрузку YML')->setDefaultValue(0),*/
            AdminFormElement::columns()
                ->addColumn([
                    AdminFormElement::checkbox('active', 'Опубликовано')->setDefaultValue(1),
                ], 1)
                ->addColumn([
                    AdminFormElement::number('sort', 'Сортировка')->setDefaultValue(100)->required(),
                ], 1)
                ->addColumn([
                    AdminFormElement::text('name', 'Название товара')->required(),
                ], 4)
                ->addColumn([
                    AdminFormElement::multiselect(
                        'category_parts',
                        'Дополнительные категории',
                        array())
                        ->setModelForOptions(Models\ChildCategorie::class)
                        ->setDisplay('name')
                        ->required(),

                    AdminFormElement::select('category_id', 'Категория', 'App\Models\Categorie')
                        ->setDisplay('name')
                        ->setSortable(false)
                        ->required(),

                ], 4)
                ->addColumn([
                    AdminFormElement::multiselect(
                        'additional_parts',
                        'Сопутствующие товары',
                        array())
                        ->setModelForOptions(Models\Part::class)
                        ->setDisplay('name')
                        ->nullable(),

                ], 12)
                ->addColumn([
                    AdminFormElement::multiselect(
                        'part_mark',
                        'Подходик к маркам',
                        array())
                        ->setModelForOptions(Models\Filter::class)
                        ->setDisplay('name')
                        ->setLoadOptionsQueryPreparer(function($element, $query) {
                            return $query
                                ->where('type_filter', 'mark');
                            })
                        ->nullable(),

                ], 12)->addColumn([
                    AdminFormElement::multiselect(
                        'part_product',
                        'Товыры к которым подходит',
                        array())
                        ->setModelForOptions(Models\Product::class)
                        ->setDisplay('name')
                        ->nullable(),
                ], 12),
        ]);


        $tabs = AdminDisplay::tabbed([
            'Карточка товара' => new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::image('photo', 'Фото товара')->mutateValue(function ($value) {
                    if ($value) {
                        $img = \Intervention\Image\Facades\Image::make($value);
                        $img->fit(220, 150, function ($constraint) {
                            $constraint->upsize();
                        });
                        $img->save('images/uploads/crop/small/' . $img->basename);

                        $img = \Intervention\Image\Facades\Image::make($value);
                        $img->fit(445, 355, function ($constraint) {
                            $constraint->upsize();
                        });
                        $img->save('images/uploads/crop/medium/' . $img->basename);
                    }

                    //$img->save('images/uploads/crop/bar.jpg');
                    return $value;
                }),
                AdminFormElement::images('photos', 'Фотографии товара')->storeAsComaSeparatedValue(),
                AdminFormElement::text('article', 'Артикул'),
                AdminFormElement::wysiwyg('coming_list', 'Подходит к товарам')->setHeight(200),
                AdminFormElement::wysiwyg('description', 'Описание товара')->setHeight(700),
                AdminFormElement::view('admin.params'),

                /*AdminFormElement::text('loading_view', 'Величина загрузки для краткого описания'),
                AdminFormElement::text('width_area_view', 'Ширина вала для краткого описания'),*/
                AdminFormElement::number('actual_price', 'Актуальная цена на товар'),
                AdminFormElement::number('old_price', 'Старая цена на товар'),
            ]),
           /* 'Дополнительная информация (NEW)' => new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::columns()
                    ->addColumn([
                        AdminFormElement::file('load_file', 'Рекламный проспект')
                    ], 2)->addColumn([
                        AdminFormElement::file('file_guide', 'Руководство по эксплуатации')
                    ], 2)
                    ->addColumn([
                        AdminFormElement::file('file_price_list', 'Прайс лист')
                    ], 2)->addColumn([
                        AdminFormElement::file('file_kit_mounting', 'Комплект - Монтажный')
                    ], 2)
                    ->addColumn([
                        AdminFormElement::file('file_kit_service', 'Комплект - Сервисный')
                    ], 2)
                    ->addColumn([
                        AdminFormElement::file('file_kit_repair', 'Комплект - Ремонтный')
                    ], 2),
                AdminFormElement::images('certificates', 'Сертификаты')->storeAsComaSeparatedValue(),
                AdminFormElement::view('admin.videos', [], function (Models\Product $model) {
                    $model->videos = $_POST['videos'];
                }),
            ]),*/
            'Параметры фильтрации' => new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::columns()
                    ->addColumn([
                        AdminFormElement::select('in_stock', 'Наличие на складе', ['Под заказ', 'На складе', 'Товар в наличии и готов к отправке']),
                        AdminFormElement::select('type', 'Тип оборудования')->required()
                            ->setOptions($this->filterType),
                        AdminFormElement::select('mark', 'Mарка')->required()
                            ->setOptions($this->filterMark),
                       /* AdminFormElement::select('loading', 'Загрузка')
                            ->setOptions($this->filterLoading),
                        AdminFormElement::select('series', 'Серия')
                            ->setOptions($this->filterSeries),
                    ], 4)->addColumn([
                        AdminFormElement::select('width_area', 'Ширина зоны глажения')
                            ->setOptions($this->filterWidthArea),
                        AdminFormElement::select('performance', 'Производительность')
                            ->setOptions($this->filterPerformance),
                        AdminFormElement::multiselect('napravlenie', 'Направления деятельности', Models\Napravlenie::class)->setDisplay('name'),
                        AdminFormElement::select('revers', 'Реверс барабана')
                            ->setOptions($this->filterRevers),
                        AdminFormElement::select('solvent', 'Растворитель')
                                        ->setOptions($this->filterSolvent)->nullable(),*/
                    ], 4)
            ]),
            'SEO' => new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::text('seo_key', 'Ключи'),
                AdminFormElement::text('seo_title', 'Заголовок'),
                AdminFormElement::textarea('seo_description', 'Описание'),
            ]),
        ]);

        $form->addElement($tabs);

        $form->addBody([
            AdminFormElement::text('url', 'url товара')->required()->setReadonly(1),
            AdminFormElement::text('id', 'ID')->setReadonly(1),
            AdminFormElement::text('created_at')->setLabel('Создано')->setReadonly(1),
        ]);

        return $form;
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
        $this->model->removeFilesOnDelete($id);
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
        return 'Добавление товара';
    }

    // иконка для пункта меню - шестеренка
    public function getIcon()
    {
        return 'fa  fa-shopping-basket';
    }
}
