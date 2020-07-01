<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleTagsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ArticleTagsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ArticleTagsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\ArticleTags');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/articletags');
        $this->crud->setEntityNameStrings('articletags', 'article_tags');
    }

    protected function setupListOperation()
    {
        $this->crud->setTitle('Article Tags');
        $this->crud->setHeading('Article Tags');
        $this->crud->setSubheading('Article Tags list','list');
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
    }

    protected function setupCreateOperation()
    {
        $this->crud->setTitle('Article Tags');
        $this->crud->setHeading('Article Tags');
        $this->crud->setSubheading('Add Tag','create');

        $this->crud->setValidation(ArticleTagsRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setTitle('Article Tags');
        $this->crud->setHeading('Article Tags');
        $this->crud->setSubheading('Edit Tag','edit');
        $this->setupCreateOperation();
    }
}
