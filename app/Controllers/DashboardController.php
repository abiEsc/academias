<?php

namespace App\Controllers;

class DashboardController extends StructureController
{

    function __construct()
    {
        $this->input = \Config\Services::request();
    }


    function index()
    {
        return parent::dashboard("inicio/inicio_view");
    }
}
