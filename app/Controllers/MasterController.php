<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MasterModel;

class MasterController extends BaseController
{
    private $masterModel = NULL;
    public function __construct()
    {
        $this->masterModel = new MasterModel();
    }
    public function categories()
    {
        $output = $this->masterModel->categories();
        return portalView('Common/index', (array)$output);
        
    }

    public function products()
    {
        $output = $this->masterModel->products();
        return portalView('Common/index', (array)$output);
    }
}
