<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticlesRequest;
use App\Http\Requests\ArticlesUpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use DB;

/**
 * Class ArticlesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ArticlesCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Articles');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/articles');
        $this->crud->setEntityNameStrings('Article', 'Articles');
    }

    protected function setupListOperation()
    {
        $this->crud->setTitle('Articles/Blog');
        $this->crud->setHeading('Articles/Blog');
        $this->crud->setSubheading('Articles/Blog list','list');
        

        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        
        $this->crud->addColumns([
            [
                'name'           => 'title',
                'type'           => 'text',
                'label'          => 'Title',
                // 'fake' => true,
            ],
            [   // Date
                'name'       => 'date',
                'label'      => 'Date',
                'type'       => 'date',
                'attributes' => [
                    'pattern'     => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
                    'placeholder' => 'yyyy-mm-dd',
                ],
                'format' => 'DD-MM-YYYY'
                // 'wrapperAttributes' => ['class' => 'col-md-6'],
            ],
            [   // Textarea
                'name'  => 'quote',
                'label' => 'Quote',
                'type'  => 'textarea',
            ],  
            [   // CKEditor
                'name'  => 'content',
                'label' => 'Content',
                'type'  => 'ckeditor',
                // 'tab'   => 'Big texts',
            ],
            [       // Select_Multiple = n-n relationship
                'label' => "Category",
                'type' => 'select',
                'name' => 'category_id', // the db column for the foreign key
                'entity' => 'ArticleCategory', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\Models\ArticleCategory",
                // optional
                'options'   => (function ($query) {
                     return $query->orderBy('name', 'ASC')->get();
                 }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
            ],
            [
                'name'           => 'status',
                'type'           => 'radio',
                'label'          => 'Status',
                'options' => ["PUBLISHED" => "PUBLISHED", "DRAFT" => "DRAFT"],
                'default' => "PUBLISHED",
                'inline'      => true,
            ],
            [
                'name'           => 'author',
                'type'           => 'text',
                'label'          => 'Author',
                // 'fake' => true,
            ],
            [
                'name'  => 'featured', // The db column name
                'key'   => 'check',
                'label' => 'Featured', // Table column heading
                'type'  => 'check',
            ]
        ]);
          //  $this->crud->setFromDb();  
          $this->addCustomCrudFilters();
          $this->crud->enableExportButtons();
    }


      public function show($id)
        {
             // get the info for that entry
            $this->data['entry'] = $this->crud->getEntry($id);
            $this->data['crud'] = $this->crud;
               

      $Results =  DB::table("articles")
        ->join('articles_category', 'articles.category_id', '=', 'articles_category.id')
        ->where('articles.id',$id)
        ->select('articles_category.name as category_name','articles.*')
        ->first();    
            
            $this->data['records'] = $Results;           
            return view('crud::details_row.Articles', $this->data);
           }

    protected function setupCreateOperation()
    {
        $this->crud->setTitle('Articles/Blog');
        $this->crud->setHeading('Articles/Blog');
        $this->crud->setSubheading('Add Article/Blog','create');

        $this->crud->addField([
            'name'           => 'title',
            'type'           => 'text',
            'label'          => 'Title',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'slug',
            'type'           => 'text',
            'label'          => 'Slug',
            'hint' => 'Will be automatically generated from your Title, if left empty.',
            // 'disabled' => 'disabled'
        ]);

        $this->crud->addField([   // Date
            'name'       => 'date',
            'label'      => 'Date',
            'type'       => 'date',
            'attributes' => [
                'pattern'     => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
                'placeholder' => 'yyyy-mm-dd',
            ],
            // 'wrapperAttributes' => ['class' => 'col-md-6'],
        ]);

        $this->crud->addField([   // Textarea
            'name'  => 'quote',
            'label' => 'Quote',
            'type'  => 'textarea',
        ]);
        $this->crud->addField([   // CKEditor
            'name'  => 'content',
            'label' => 'Content',
            'type'  => 'ckeditor',
            // 'tab'   => 'Big texts',
        ]); 
        $this->crud->addField([   // Textarea
            'name'  => 'short_content',
            'label' => 'Short Content',
            'type'  => 'textarea',
        ]);
        // $this->crud->addField([   // CKEditor
        //     'name'  => 'column1',
        //     'label' => 'Column1',
        //     'type'  => 'ckeditor',
        //     // 'tab'   => 'Big texts',
        // ]);   
        // $this->crud->addField([   // CKEditor
        //     'name'  => 'column2',
        //     'label' => 'Column2',
        //     'type'  => 'ckeditor',
        //     // 'tab'   => 'Big texts',
        // ]);
        $this->crud->addField([
            'name'           => 'banner_image',
            'type'           => 'upload',
            'label'          => 'Banner Image',
            'upload' => true,
            // 'disk' => 'public',
        ]);

        $this->crud->addField([
            'name'           => 'media_type',
            'type'           => 'radio',
            'label'          => 'Media Type',
            'options' => ["image" => "image", "video" => "video"],
            'default' => "image",
            'inline'      => true,
        ]);  

        $this->crud->addField([
            'name'           => 'image',
            'type'           => 'upload',
            'label'          => 'Image',
            'upload' => true,
            // 'disk' => 'public',
        ]);

        // $this->crud->addField([
        //     'name'           => 'video',
        //     'type'           => 'upload',
        //     'label'          => 'Upload Video',
        //     'upload' => true,
        //     // 'disk' => 'public',
        // ]);

        $this->crud->addField([
            'name'           => 'video',
            'type'           => 'text',
            'label'          => 'Video url',
            // 'fake' => true,
        ]);

        $this->crud->addField([       // Select_Multiple = n-n relationship
            'label' => "Category",
            'type' => 'select',
            'name' => 'category_id', // the db column for the foreign key
            'entity' => 'ArticleCategory', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\ArticleCategory",
            // optional
            'options'   => (function ($query) {
                 return $query->orderBy('name', 'ASC')->get();
             }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
            ]);

         $this->crud->addField([
                'name'           => 'status',
                'type'           => 'radio',
                'label'          => 'Status',
                'options' => ["PUBLISHED" => "PUBLISHED", "DRAFT" => "DRAFT"],
                'default' => "PUBLISHED",
                'inline'      => true,
            ]);   

         $this->crud->addField([
                'name'           => 'author',
                'type'           => 'text',
                'label'          => 'Author',
                // 'fake' => true,
            ]);   
         $this->crud->addField([
            'name'           => 'column1_image',
            'type'           => 'upload',
            'label'          => 'Column1 image',
            'upload' => true,
            // 'disk' => 'public',
        ]);
	    $this->crud->addField([
            'name'           => 'column1_title',
            'type'           => 'text',
            'label'          => 'Column1 title',
            // 'fake' => true,
        ]);   
       	$this->crud->addField([   // CKEditor
	        'name'  => 'column1_description',
	        'label' => 'Column1 description',
	        'type'  => 'ckeditor',
	        // 'tab'   => 'Big texts',
        ]);   
        $this->crud->addField([
            'name'           => 'column2_image',
            'type'           => 'upload',
            'label'          => 'Column2 image',
            'upload' => true,
            // 'disk' => 'public',
        ]);
	    $this->crud->addField([
            'name'           => 'column2_title',
            'type'           => 'text',
            'label'          => 'Column2 title',
            // 'fake' => true,
        ]);   
       	$this->crud->addField([   // CKEditor
	        'name'  => 'column2_description',
	        'label' => 'Column2 description',
	        'type'  => 'ckeditor',
	        // 'tab'   => 'Big texts',
        ]);   

        $this->crud->setValidation(ArticlesRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setTitle('Articles/Blog');
        $this->crud->setHeading('Articles/Blog');
        $this->crud->setSubheading('Edit Article/Blog','edit');

        $this->crud->addField([
            'name'           => 'title',
            'type'           => 'text',
            'label'          => 'Title',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'slug',
            'type'           => 'text',
            'label'          => 'Slug',
            'hint' => 'Will be automatically generated from your Title, if left empty.',
            // 'attributes'    => ['disabled'=>'disabled'],
            // 'disabled' => 'disabled'
        ]);

        $this->crud->addField([   // Date
            'name'       => 'date',
            'label'      => 'Date',
            'type'       => 'date',
            'attributes' => [
                'pattern'     => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
                'placeholder' => 'yyyy-mm-dd',
            ],
            // 'wrapperAttributes' => ['class' => 'col-md-6'],
        ]);

        $this->crud->addField([   // Textarea
            'name'  => 'quote',
            'label' => 'Quote',
            'type'  => 'textarea',
        ]);

        $this->crud->addField([   // CKEditor
            'name'  => 'content',
            'label' => 'Content',
            'type'  => 'ckeditor',
            // 'tab'   => 'Big texts',
        ]);    
         $this->crud->addField([   // Textarea
            'name'  => 'short_content',
            'label' => 'Short Content',
            'type'  => 'textarea',
        ]);
        // $this->crud->addField([   // CKEditor
        //     'name'  => 'column1',
        //     'label' => 'Column1',
        //     'type'  => 'ckeditor',
        //     // 'tab'   => 'Big texts',
        // ]);   
        // $this->crud->addField([   // CKEditor
        //     'name'  => 'column2',
        //     'label' => 'Column2',
        //     'type'  => 'ckeditor',
        //     // 'tab'   => 'Big texts',
        // ]);
        $this->crud->addField([
            'name'           => 'banner_image',
            'type'           => 'upload',
            'label'          => 'Banner Image',
            'upload' => true,
            // 'disk' => 'public',
        ]);

        $this->crud->addField([
            'name'           => 'media_type',
            'type'           => 'radio',
            'label'          => 'Media Type',
            'options' => ["image" => "image", "video" => "video"],
            'default' => "image",
            'inline'      => true,
        ]);  

        $this->crud->addField([
            'name'           => 'image',
            'type'           => 'upload',
            'label'          => 'Image',
            'upload' => true,
            // 'disk' => 'public',
        ]);

        $this->crud->addField([
            'name'           => 'video',
            'type'           => 'text',
            'label'          => 'Video url',
            // 'fake' => true,
        ]);

        $this->crud->addField([       // Select_Multiple = n-n relationship
            'label' => "Category",
            'type' => 'select',
            'name' => 'category_id', // the db column for the foreign key
            'entity' => 'ArticleCategory', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\ArticleCategory",
            // optional
            'options'   => (function ($query) {
                 return $query->orderBy('name', 'ASC')->get();
             }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
            ]);

         $this->crud->addField([
                'name'           => 'status',
                'type'           => 'radio',
                'label'          => 'Status',
                'options' => ["PUBLISHED" => "PUBLISHED", "DRAFT" => "DRAFT"],
                'default' => "PUBLISHED",
                'inline'      => true,
            ]);   

         $this->crud->addField([
                'name'           => 'author',
                'type'           => 'text',
                'label'          => 'Author',
                // 'fake' => true,
            ]);  
            $this->crud->addField([
            'name'           => 'column1_image',
            'type'           => 'upload',
            'label'          => 'Column1 image',
            'upload' => true,
            // 'disk' => 'public',
        ]);
	    $this->crud->addField([
            'name'           => 'column1_title',
            'type'           => 'text',
            'label'          => 'Column1 title',
            // 'fake' => true,
        ]);   
       	$this->crud->addField([   // CKEditor
	        'name'  => 'column1_description',
	        'label' => 'Column1 description',
	        'type'  => 'ckeditor',
	        // 'tab'   => 'Big texts',
        ]);   
        $this->crud->addField([
            'name'           => 'column2_image',
            'type'           => 'upload',
            'label'          => 'Column2 image',
            'upload' => true,
            // 'disk' => 'public',
        ]);
	    $this->crud->addField([
            'name'           => 'column2_title',
            'type'           => 'text',
            'label'          => 'Column2 title',
            // 'fake' => true,
        ]);   
       	$this->crud->addField([   // CKEditor
	        'name'  => 'column2_description',
	        'label' => 'Column2 description',
	        'type'  => 'ckeditor',
	        // 'tab'   => 'Big texts',
        ]);    
         // $this->crud->setValidation(ArticlesUpdateRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
        // $this->setupCreateOperation();
    }

    public function addCustomCrudFilters()
    {

        $this->crud->addFilter([ // add a "simple" filter called Draft
            'type'  => 'simple',
            'name'  => 'featured',
            'label' => 'Featured',
        ],
        false, // the simple filter has no values, just the "Draft" label specified above
        function () { // if the filter is active (the GET parameter "draft" exits)
            $this->crud->addClause('where', 'featured', '1');
        });

        $this->crud->addFilter([ // select2 filter
            'name' => 'category_id',
            'type' => 'select2',
            'label'=> 'Category',
        ], function () {
            return \App\Models\ArticleCategory::all()->keyBy('id')->pluck('name', 'id')->toArray();
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'category_id', $value);
        });

        $this->crud->addFilter([ // text filter
            'type'  => 'text',
            'name'  => 'title',
            'label' => 'Title',
        ],
        false,
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'title', 'LIKE', "%$value%");
        });

        $this->crud->addFilter([ // date filter
            'type'  => 'date',
            'name'  => 'date',
            'label' => 'Date',
        ],
        false,
        function ($value) { // if the filter is active, apply these constraints
            $this->crud->addClause('where', 'date', '=', $value);
        });

        $this->crud->addFilter([ // dropdown filter
            'name' => 'status',
            'type' => 'dropdown',
            'label'=> 'Status',
        ], ["PUBLISHED" => "PUBLISHED", "DRAFT" => "DRAFT"], function ($value) {
            // if the filter is active
            $this->crud->addClause('where', 'status', $value);
        });

        $this->crud->addFilter([ // text filter
            'type'  => 'text',
            'name'  => 'author',
            'label' => 'Author Name',
        ],
        false,
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'author', 'LIKE', "%$value%");
        });

   }

}
