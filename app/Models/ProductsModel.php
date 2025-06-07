<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\GroceryCrud;
class ProductsModel extends Model
{
    public function products(): object
    {
        $crud = new GroceryCrud();
        $crud->displayAs('label', 'Service Name');
        $crud->displayAs('is_active', 'Status');
        $crud->columns(['label', 'is_active']);
        $crud->fields(['label', 'is_active']);
        $crud->requiredFields(['label']);
        $crud->unsetDelete();
        $crud->unsetPrint();
        $crud->unsetExport();
        $crud->setTable('Products');
        $crud->setSubject('Products');
        $output = $crud->render();
        return $output;
    }
}
