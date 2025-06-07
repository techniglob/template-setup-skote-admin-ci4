<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\GroceryCrud;

class MasterModel extends Model
{
    public function categories():object
    {
        $crud = new GroceryCrud();
        $crud->displayAs('name', 'Category');
        $crud->displayAs('description', 'Description');
        $crud->displayAs('is_active', 'Status');
        $crud->columns(['name','description','is_active']);
        $crud->fields(['name', 'description', 'is_active']);
        $crud->requiredFields(['label']);
        $crud->unsetDelete();
        $crud->unsetPrint();
        $crud->unsetExport();
        $crud->setTable('categories');
        $crud->setSubject('Category', 'Categories');
        $output = $crud->render();
        return $output;
    }

    public function products():object
    {
        $crud = new GroceryCrud();
        $crud->displayAs('name', 'Category');
        $crud->displayAs('description', 'Description');
        $crud->displayAs('is_active', 'Status');
        $crud->displayAs('price', 'Price');
        $crud->displayAs('stock_quantity', 'Stock Quantity');
        $crud->displayAs('category_id', 'Category ID');
        $crud->displayAs('image', 'Image');
        $crud->displayAs('care_instructions', 'Care Instructions');
        $crud->displayAs('plant_type', 'Plant Type');
        $crud->displayAs('height', 'Height');
        $crud->columns(['name','description', 'price', 'stock_quantity', 'category_id ', 'image', 'care_instructions', 'plant_type', 'height','is_active']);
        $crud->fields(['name', 'description', 'is_active']);
        $crud->requiredFields(['name']);
        $crud->unsetDelete();
        $crud->unsetPrint();
        $crud->unsetExport();
        $crud->setTable('products');
        $crud->setSubject('Products', 'Products');
        $output = $crud->render();
        return $output;
    }
}
