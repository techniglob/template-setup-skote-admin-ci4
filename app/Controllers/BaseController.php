<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

    /**
    * @author Pritam Khan | pritamkhanofficial@gmail.com
    * 
    * 
    */
   
   
   public function generateFlash($alert = array())
   {
       if(array_key_exists('type',$alert)){
         session()->setFlashdata('type', $alert['type']);
       }else{
         session()->setFlashdata('type', "success");
       }
   
       if(array_key_exists('title',$alert)){
         session()->setFlashdata('title', $alert['title']);
       }else{
         session()->setFlashdata('title', "Success");
       }
       if(array_key_exists('message',$alert)){
         session()->setFlashdata('message', $alert['message']);
       }else{
         session()->setFlashdata('message', NULL);
       }
   }


   public function fileHandle($crud = NULL, $field = NULL, $file_type = NULL){
      if(!is_null($crud)){
          switch ($file_type) {
            case 'image':
              $accept = ".jpg, .jpeg, .png";
              break;
            case 'document':
              $accept = ".pdf, .doc, .docx";
              break;
            case 'video':
              $accept = ".mp4";
              break;
            
            default:
              $accept = NULL;
              break;
          }
        $crud->callbackColumn($field, array($this, 'showFile'));
        $crud->callbackAddField(
          $field,
          function () use ($accept,$field) {
              return  '<input id="field-' .$field. '" type="file" class="form-control  " accept="' . $accept . '" name="' .$field. '" value="">';
          }
      );

      $crud->callbackEditField(
        $field,
        function ($data)  use ($accept,$field) {
            $path = base_url() . 'uploads/' . $data;

            $html = $this->showFile($data);
            $html .= '<input id="field-image" type="file" class="form-control mt-2" accept="' . $accept . '" name="' . $field . '" value="">';

            $html .= '<input id="field-image" type="hidden" class="form-control" name="file_hidden" value="' . $data . '">';
            return $html;
        }
      );

      $crud->callbackBeforeInsert(
        function ($cbData) use ($field) {
            $toUpload = $this->request->getFile($field);
            if (isset($toUpload)) {
                $image = UploadFile($toUpload);
                $cbData->data[$field] = $image;

                return $cbData;
            }
        }
      );

      $crud->callbackBeforeUpdate(
        function ($cbData)  use ($field) {
            $toUpload = $this->request->getFile($field);

            $file_hidden = $this->request->getVar('file_hidden');

            if (isset($toUpload)) {
                $image = UploadFile($toUpload, null, $file_hidden);
                $cbData->data[$field] = $image;
            } else {
                $cbData->data[$field] = $file_hidden;
            }
            $cbData->data['updated_by'] = getUserData()->id;
            $cbData->data['updated_at'] = \getCurrentDate();
            return $cbData;
        }
      );
      $crud->fieldType('created_by', 'hidden', getUserData()->id);
      $crud->fieldType('updated_at', 'hidden', null);
      $crud->fieldType('updated_by', 'hidden', null);
      return $crud;
      }

      return $crud;
   }

   public function showFile($value)
    {
      $path = "No File";
        if(!empty($value)){
          $url = base_url('uploads/');
        $type = pathinfo($value)['extension'];
        // die($type);
        $icon = '';
        if($type === 'pdf'){
            $icon = '<i class=" fas fa-file-pdf text-danger  fs-1  "></i>';
        }elseif($type === 'xls' || $type === 'xlsx'){
            $icon = '<i class="fas fa-file-excel text-success  fs-1  "></i>';
        }elseif($type === 'doc' || $type === 'docx'){
            $icon = '<i class=" fas fa-file-word  text-primary   fs-1  "></i>';
        }elseif($type === 'txt'){
                $icon = '<i class="fas fa-images fs-1"></i>';
        }else{
            $icon = '<i class="fas fa-images"></i>';
        }
        
        // $icon = $type;
        if($type == 'pdf' or $type == 'xls' or $type == 'xlsx' or $type == 'doc' or $type == 'docx' or $type == 'txt'){

            $path = '<a target="_new" href="'.$url . $value.'"> '. $icon .' </a>';
        }elseif($type == 'png' or $type == 'jpg' or $type == 'jpeg' or $type == 'bmp' or $type == 'webp' or $type == 'gif'){
            $path = '<img src=' . $url . $value . ' height="100" width="100">'; 
        }
        }
        
        
         return $path;
    }
}
