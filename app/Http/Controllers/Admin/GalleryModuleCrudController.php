<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GalleryModuleRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class GalleryModuleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class GalleryModuleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\GalleryModule');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/gallerymodule');
        $this->crud->setEntityNameStrings('gallery module', 'gallery modules');
    }

    protected function setupListOperation()
    {
        $this->crud->setTitle('Gallery');
        $this->crud->setHeading('Gallery');
        $this->crud->setSubheading('Gallery list','list');
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
       // $this->crud->setFromDb();

       $this->crud->addColumns([
        'type','image'
       ]);

        $this->crud->addFilter([ // text filter
            'type'  => 'text',
            'name'  => 'type',
            'label' => 'Gallery Category type',
        ],
        false,
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'type', 'LIKE', "%$value%");
        });
    }

    protected function setupCreateOperation()
    {
        $this->crud->setTitle('Gallery');
        $this->crud->setHeading('Gallery');
        $this->crud->setSubheading('Add Gallery','create');
        
        $this->crud->addField([   // SimpleMDE
            'name'  => 'type',
            'label' => 'Gallery Category type',
            'type'  => 'text',
        ]);

        $this->crud->addField([   // Upload
            'name'   => 'image',
            'label'  => 'Upload Multiple Image',
            'type'   => 'upload_multiple',
            'upload' => true,
            // 'disk' => 'uploads', // if you store files in the /public folder, please ommit this; if you store them in /storage or S3, please specify it;
            // optional:
            // 'temporary' => 10 // if using a service, such as S3, that requires you to make temporary URL's this will make a URL that is valid for the number of minutes specified
            'tab' => 'Uploads',
        ]);
       // $this->crud->setValidation(GalleryModuleRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setTitle('Gallery');
        $this->crud->setHeading('Gallery');
        $this->crud->setSubheading('Edit Gallery','edit');
        $this->setupCreateOperation();
    }
}
