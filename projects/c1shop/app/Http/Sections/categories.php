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
 * Class categories
 *
 * @property \App\Models\Categorie $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class categories extends Section implements Initializable
{
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;

    protected $model = '\App\Models\Categorie';

    public function initialize()
    {
        $this->creating(function ($config, \Illuminate\Database\Eloquent\Model $model) {
            //...
        });
    }

    /**
     * @var string
     */
    protected $title = 'Главные категории';

    /**
     * @var string
     */
    protected $alias = 'categories';

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
                AdminColumn::text('url', 'Ссылка на категорию')->setWidth('200px')
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
                AdminFormElement::text('name', 'Название категории')->required(),
                AdminFormElement::checkbox('active', 'Активность'),
                AdminFormElement::select('show_filters', 'Показывать блок с фильтрами',['Нет', 'Да'])
                    ->setHelpText('На странице бренда всегда показываются фильтры по главным категориям')
                    ->required(),
                AdminFormElement::select('show_in_nav', 'Показывать в боковом меню',['Нет', 'Да'])->required(),
                AdminFormElement::text('logotype', 'SVG логотип - меню'),
                AdminFormElement::text('longIcon', 'SVG логотип - карточки'),
                AdminFormElement::multiselect('binding_filters', 'Какие фильтры показывать в разделе')->setOptions([
                    'mark' =>'Марка',
                    'type' => 'Тип оборудования',
                    'loading' => 'Загрузка',
                    'revers' => 'Реверс барабана',
                    'width_area' => 'Ширина зоны глажения',
                    'performance' => 'Производительность, кг/ч',
                    'series' => 'Серия',
                    'solvent' => 'Растворитель',
                    ])
                    ->mutateValue(function ($value){
                        return serialize($value);
                    })->setHelpText('На странице бренда показываются только фильтры по главным категориям'),
                AdminFormElement::wysiwyg('description', 'Описание категории')->setHeight(400),
                AdminFormElement::wysiwyg('top_description', 'Описание категории (над фильтром)')->setHeight(400),

            ]),
            'Настройки для направления деятельности' => new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::select('napravlenie_id', 'Привязка к направлению деятельности', Models\Napravlenie::class)->setDisplay('name'),
                AdminFormElement::image('img', 'Изображение'),
            ]),
            'SEO' => new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::text('seo_h1', 'Заголовок первого уровня')->setHelpText('Выводится в теле страницы'),
                AdminFormElement::text('seo_h2', 'Заголовок второго уровня')->setHelpText('Выводится в теле страницы'),
                AdminFormElement::text('seo_title', 'SEO заголовок'),
                AdminFormElement::textarea('seo_description', 'SEO описание'),
                AdminFormElement::textarea('seo_key', 'SEO ключи'),
                AdminFormElement::text('seo_title_brand', 'SEO заголовок для фильтра бренда')->setHelpText('#BRAND# заменятся на название марки "Krebe (Словения)"'),
                AdminFormElement::text('seo_description_brand', 'SEO описание для фильтра бренда'),
                AdminFormElement::text('url', 'url категории')->setReadonly(1),
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
        return 'Добавление главной категории';
    }

    // иконка для пункта меню - шестеренка
    public function getIcon()
    {
        return 'fa  fa-list';
    }

}
