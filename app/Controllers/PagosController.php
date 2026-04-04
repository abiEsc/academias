<?php

namespace App\Controllers;

class PagosController extends StructureController
{

    function __construct()
    {
        $this->input = \Config\Services::request();
    }


    function index()
    {
        return parent::dashboard("pagos/dashboard");
    }
}
