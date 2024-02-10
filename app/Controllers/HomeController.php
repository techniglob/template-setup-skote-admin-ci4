<?php

namespace App\Controllers;
use App\Libraries\GroceryCrud;
use App\Models\WebsiteModel;


class HomeController extends BaseController
{
    public $websiteModel = NULL;
    public function __construct(Type $var = null) {
        $this->websiteModel = new WebsiteModel();
    }
    
    public function Slider(){
        $crud = new GroceryCrud();
        $crud->displayAs('image','Slider');
        $crud->displayAs('is_active','Status');
        $crud->where("deleted_at", NULL);
        $crud->columns(['image', 'is_active']);
        $crud->fields(['image', 'is_active','created_by','updated_at','updated_by']);
        $this->fileHandle($crud, 'image','image');
        // $crud->unsetDelete();
        // $crud->unsetAdd();
        if ($crud->getState() === 'delete') {
            
            $result = $this->websiteModel->softDelete('sliders', $crud->getStateInfo()->primary_key);
            // getPrint($result);
            if($result){
                return $this->response->setJSON([
                    'success'=>true,
                    'success_message'=>"<p>Your data has been successfully deleted from the database.</p>",
                ]);
            }
            
        }
        $crud->unsetPrint();
        $crud->unsetExport();
        /* $crud->callbackBeforeUpdate(function ($stateParameters) {
            return $this->saveLogData('edit','state',$stateParameters->data);
        }); */
        $crud->setTable('sliders');
        $crud->setSubject('Slider');
        $output = $crud->render();
        return view('common', (array)$output);
    }
    public function Documents(){
        $crud = new GroceryCrud();
        $crud->displayAs('file','Document File');
        $crud->displayAs('doc_type','Document Type');
        $crud->displayAs('is_active','Status');
        $crud->where("deleted_at", NULL);
        $crud->columns(['title','file', 'doc_type', 'is_active']);
        $crud->fields(['title','file', 'doc_type', 'is_active','created_by','updated_at','updated_by']);
        $crud->fieldType('doc_type', 'dropdown', [
            'NOTICE' => 'Notice',
            'TENDER' => 'Tender',
            'NE' => 'News / Events',
            'ARS' => 'Anti Ragging Section',
            'MENU' => 'Nav Menu'
        ]);
        $this->fileHandle($crud, 'file','document');

        if ($crud->getState() === 'delete') {
            
            $result = $this->websiteModel->softDelete('documents', $crud->getStateInfo()->primary_key);
            if($result){
                return $this->response->setJSON([
                    'success'=>true,
                    'success_message'=>"<p>Your data has been successfully deleted from the database.</p>",
                ]);
            }
            
        }
        $crud->unsetPrint();
        $crud->unsetExport();
        $crud->setTable('documents');
        $crud->setSubject('Document');
        $output = $crud->render();
        return view('common', (array)$output);
    }

    public function Gallery(){
        $crud = new GroceryCrud();
        $crud->displayAs('image','Gallery Image');
        $crud->displayAs('is_active','Status');
        $crud->where("deleted_at", NULL);
        $crud->columns(['title','image', 'is_active']);
        $crud->fields(['title','image', 'is_active','created_by','updated_at','updated_by']);
        $this->fileHandle($crud, 'image','image');

        if ($crud->getState() === 'delete') {
            
            $result = $this->websiteModel->softDelete('gallery', $crud->getStateInfo()->primary_key);
            if($result){
                return $this->response->setJSON([
                    'success'=>true,
                    'success_message'=>"<p>Your data has been successfully deleted from the database.</p>",
                ]);
            }
            
        }
        $crud->unsetPrint();
        $crud->unsetExport();
        $crud->setTable('gallery');
        $crud->setSubject('Gallery');
        $output = $crud->render();
        return view('common', (array)$output);
    }

    public function aboutHospital(){
        
        $webModel = new WebsiteModel();
        $crud = new GroceryCrud();
        $crud->displayAs('history_and_heritage','History and Heritage');
        $crud->displayAs('description','About');
        $crud->displayAs('is_active','Status');
        // $crud->where("deleted_at", NULL);
        $crud->columns(['affiliated_to','vice_chancellor', 'registrar', 'year_of_affiliation']);
        $crud->fields(['affiliated_to','vice_chancellor', 'registrar', 'year_of_affiliation','description', 'history_and_heritage', 'map', 'address', 'created_by','updated_by']);
        $crud->setTexteditor(['description', 'history_and_heritage','address']);
        // $crud->setFieldUpload(['file', 'is_active','created_by']);
        $crud->callbackColumn('file', array($this, 'showFile'));
        $crud->fieldType('created_by', 'hidden', getUserData()->id);
        $crud->fieldType('updated_by', 'hidden', getUserData()->id);
        /* $crud->callbackAfterInsert(function ($stateParameters) {
            return $this->saveLogData('add','state',$stateParameters->data);
        }); */
        
        $crud->callbackBeforeUpdate(
            function ($cbData) {    
                $cbData->data['updated_by'] = \getUserData()->id;
 
                return $cbData;
            }
        );


        $crud->unsetDelete();
        if($webModel->getCountAboutHospital() >= 1){

            $crud->unsetAdd();
        }
        $crud->unsetPrint();
        $crud->unsetExport();
        /* $crud->callbackBeforeUpdate(function ($stateParameters) {
            return $this->saveLogData('edit','state',$stateParameters->data);
        }); */
        $crud->setTable('about_hospital');
        $crud->setSubject('About Hospital');
        $output = $crud->render();
        return view('common', (array)$output);
    }
}
