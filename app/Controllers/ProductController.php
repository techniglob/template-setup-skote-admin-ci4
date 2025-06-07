<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MasterModel;
use App\Models\ProductsModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProductController extends BaseController
{
    private $ProductsModel = NULL;
    public function __construct()
    {
        $this->ProductsModel = new ProductsModel();
    }
    public function products()
    {
        $output = $this->ProductsModel->products();
        return portalView('Common/index', (array)$output);
    }
}
