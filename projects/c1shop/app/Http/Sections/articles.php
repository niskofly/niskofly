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
class articles extends Section implements Initializable
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
    protected $title = 'Статьи Новости';

    /**
     * @var string
     */
    protected $alias = 'articles';

    protected $model = 'App\Model\article';
    public function initialize()
    {
        $this->creating(function($config, \Illuminate\Database\Eloquent\Model $model) {
            //...
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
                AdminColumn::link('name', 'Название статьи/новости')->setWidth('100px'),
                AdminColumn::text(function ($query){
                    $arType = ['Статья', 'Новость', ];
                    return $arType[$query['type']];
                }, 'Тип записи')->setWidth('200px'),
                AdminColumn::text('preview_description', 'Краткое описание')->setWidth('200px')
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
            AdminFormElement::text('name', 'Название стать/новости')->required(),
            AdminFormElement::date('date_view', 'Дата создания')->required(),
            AdminFormElement::checkbox('active', 'Опубликована'),
            AdminFormElement::select('type', 'Тип контента', ['Статья', 'Новость'])->required(),
            AdminFormElement::textarea('preview_description', 'Краткое описание')->required(),
            AdminFormElement::image('preview_image', 'Превью изображение')->required(),
            AdminFormElement::wysiwyg('full_content', 'Тело статьи/новости')->required(),
            AdminFormElement::text('seo_title', 'SEO заголовок'),
            AdminFormElement::textarea('seo_description', 'SEO описание'),
            AdminFormElement::textarea('seo_key', 'SEO ключи'),
            AdminFormElement::text('url', 'url категории')->setReadonly(1),
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
        return 'Добавление Статьи/Новости';
    }

    // иконка для пункта меню - шестеренка
    public function getIcon()
    {
        return 'fa  fa-newspaper-o';
    }
}
