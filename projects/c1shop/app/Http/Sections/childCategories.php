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

use DB;

/**
 * Class childCategories
 *
 * @property \App\Models\ChildCategorie $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class childCategories extends Section implements Initializable
{
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;


    protected $table = 'App\Models\ChildCategorie';

    public function initialize()
    {
        $this->creating(function($config, \Illuminate\Database\Eloquent\Model $model) {
            //...
        });
        $this->filterType = Models\Filter::GetTypeFilter('type');
    }

    /**
     * @var string
     */
    protected $title = 'Дочерние категории';

    /**
     * @var string
     */
    protected $alias = 'child_category';

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        return AdminDisplay::table()/*->with('users')*/
        ->setHtmlAttribute('class', 'table-primary')
            ->setColumns(
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumn::link('name', 'Название категории')->setWidth('200px'),
                AdminColumn::text(
                    function ($query){
                        return  DB::table('categories')->where('id', '=', $query["parent_category"])->value('name');
                    },
                    'Родительская категория')->setWidth('500px')
            )->paginate(20);
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $form = AdminForm::panel();

        $tabs = AdminDisplay::tabbed([
            'Информация' => new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::checkbox('active', 'Активность'),
                AdminFormElement::select('type', 'Тип оборудования запчасти')->setOptions($this->filterType),
                AdminFormElement::text('name', 'Название категории')->required(),
                AdminFormElement::text('url', 'url категории')
                    ->setReadonly(1)
                    ->setHelpText('Генерируется на основе url выбранного фильтра Тип оборудования запчасти'),
                AdminFormElement::select('parent_category', 'Родительская категории', '\App\Models\Categorie')->setDisplay('name')->setSortable(false),
                AdminFormElement::wysiwyg('description', 'Описание категории')->setHeight(400),
                AdminFormElement::wysiwyg('top_description', 'Описание категории (над фильтром)')->setHeight(400),
            ]),
            'SEO' => new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::text('seo_title', 'SEO заголовок'),
                AdminFormElement::text('seo_h1', 'Заголовок первого уровня'),
                AdminFormElement::text('seo_h2', 'Заголовок второго уровня'),
                AdminFormElement::textarea('seo_description', 'SEO описание'),
                AdminFormElement::textarea('seo_key', 'SEO ключи'),
            ]),

        ]);
        $form->addElement($tabs);
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
        return 'Добавление дочерней категории';
    }

    // иконка для пункта меню - шестеренка
    public function getIcon()
    {
        return 'fa  fa-list-ol';
    }

}
