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
 * Class customers
 *
 * @property \App\Models\Customer $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class customers extends Section implements Initializable
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
    protected $title = 'Клиенты';

    /**
     * @var string
     */
    protected $alias = 'customers';

    protected $model = 'App\Model\Customers';
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

        $display = AdminDisplay::datatablesAsync()
            ->setDisplaySearch(true)
            ->setOrder([0, 'asc'])
            ->paginate(20);

        $display->setHtmlAttribute('class', 'table-bordered table-primary table-hover');

        //$display->with('category', 'id');
//        $display->setFilters(
//            AdminDisplayFilter::related('category')->setModel(Models\Categorie::class)
//        );

        $display->setColumns([

            AdminColumn::text('id', '#')->setWidth('30px'),

            $photo = AdminColumn::image('logo', 'Логотип')
                ->setHtmlAttribute('class', 'text-center')
                ->setWidth('100px'),

            AdminColumn::link('name', 'Клиент')
                ->setHtmlAttribute('class', 'text-center'),

//            $category = AdminColumn::text('categories.name', 'Категория')
//                ->setHtmlAttribute('class', 'hidden-sm hidden-xs hidden-md')
//                ->setWidth('150px')
//                ->setSearchCallback(function (){
//                    return 1;
//                })
//                ->append(
//                    AdminColumn::filter('category')
//                ),

        ]);

        $photo->getHeader()->setHtmlAttribute('class', 'hidden-sm hidden-xs');
        //$category->getHeader()->setHtmlAttribute('class', 'hidden-sm hidden-xs hidden-md');

        return $display;

    }


    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        return AdminForm::panel()->addBody([
            AdminFormElement::checkbox('active', 'Опубликован')->setDefaultValue(1),
            AdminFormElement::text('name', 'Клиент')->required()->setHtmlAttribute('class', 'js-input-name'),
            AdminFormElement::image('logo', 'Логотип клиента'),
            AdminFormElement::text('coordinates', 'Координыты организации')
                ->setHtmlAttribute('class', 'js-input-coordinates')
                ->setHelpText('Введите адрес в поисковое поле и передвинте метку на нужную точку')
                ->required(),
            AdminFormElement::view('admin.map'),
            AdminFormElement::text('city', 'Город')
                ->required()
                ->setHtmlAttribute('class', 'js-input-city'),
            AdminFormElement::text('address', 'Адрес огранизации')
                ->required()
                ->setHtmlAttribute('class', 'js-input-address'),
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
        return 'Добавление Клиента';
    }

    // иконка для пункта меню - шестеренка
    public function getIcon()
    {
        return 'fa  fa-address-book-o';
    }
}
