<?php

namespace App\Controllers;

class NotificacionesController extends StructureController
{

    function __construct()
    {
        $this->input = \Config\Services::request();
    }


    function index()
    {
        return parent::dashboard("notificacion/dashboard");
    }
}
