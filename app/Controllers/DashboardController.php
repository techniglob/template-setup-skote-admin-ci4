<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function index()
    {
        // show_404();
        // echo base_url(); die;
        return portalView('dashboard/index');
    }
}
