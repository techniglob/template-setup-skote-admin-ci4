<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\GroceryCrud;

class MasterModel extends Model
{
    public function services(): object
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
        $crud->setTable('services');
        $crud->setSubject('Services');
        $output = $crud->render();
        return $output;
    }
}
