<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleCategoryRequest;
use App\Http\Requests\ArticleCategoryUpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ArticleCategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ArticleCategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\ArticleCategory');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/articlecategory');
        $this->crud->setEntityNameStrings('Article Category', 'Article Categories');
    }

    protected function setupListOperation()
    {

        $this->crud->setTitle('Article Category');
        $this->crud->setHeading('Article Category');
        $this->crud->setSubheading('Article Category list','list');
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
        $this->crud->addFilter([ // text filter
            'type'  => 'text',
            'name'  => 'name',
            'label' => 'Name',
        ],
        false,
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'name', 'LIKE', "%$value%");
        });
        $this->crud->enableExportButtons();
    }

    protected function setupCreateOperation()
    {

        $this->crud->setTitle('Article Category');
        $this->crud->setHeading('Article Category');
        $this->crud->setSubheading('Add Category','create');

        $this->crud->addField([
            'name'           => 'name',
            'type'           => 'text',
            'label'          => 'Name',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'slug',
            'type'           => 'text',
            'label'          => 'Slug',
            'hint' => 'Will be automatically generated from your Name, if left empty.',
            // 'disabled' => 'disabled'
        ]);

        $this->crud->setValidation(ArticleCategoryRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setTitle('Article Category');
        $this->crud->setHeading('Article Category');
        $this->crud->setSubheading('Edit Category','edit');

         $this->crud->addField([
            'name'           => 'name',
            'type'           => 'text',
            'label'          => 'Name',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'slug',
            'type'           => 'text',
            'label'          => 'Slug',
            'hint' => 'Will be automatically generated from your Name, if left empty.',
            'attributes'    => ['disabled'=>'disabled'],
            // 'disabled' => 'disabled'
        ]);
        $this->crud->setValidation(ArticleCategoryUpdateRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
        // $this->setupCreateOperation();
    }
}
