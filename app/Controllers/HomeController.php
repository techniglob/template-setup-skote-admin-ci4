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
}
