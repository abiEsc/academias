<?php

namespace App\Controllers;

use App\Models\SucursalModel;

class SucursalesController extends StructureController
{

    function __construct()
    {
        $this->input = \Config\Services::request();
        $this->sucursal_model = new SucursalModel();
    }


    function index()
    {
        $sucursales = $this->sucursal_model->ListarSucursales();
        $sucursales = MapSucursal($sucursales);
        $data["sucursales"] = $sucursales;

        return parent::dashboard("sucursales/dashboard", $data);
    }

    function recuperar_sucursal()
    {
        $sucursal_id = $this->input->getPost("sucursal_id");
        $sucursal = $this->sucursal_model->ListarSucursales($sucursal_id);
        echo json_encode($sucursal);
    }

    function registrar_sucursal()
    {
        $sucursal_nombre = $this->input->getPost("sucursal_nombre");
        $sucursal_activo = $this->input->getPost("sucursal_activo");

        $accion_usuario = $this->session->get();
        $accion_fecha = date('Y-m-d H:i:s');
        $registro = true;

        if (isset($_POST["sucursal_id"]) && $_POST["sucursal_id"] != "") {
            $sucursal_id = $this->input->getPost("sucursal_id");
            if ($sucursal_id == 1) {
                $sucursal_activo = 1;
            }
            $registro = $this->sucursal_model->EditarSucursal($sucursal_id, $sucursal_nombre, $sucursal_activo, $accion_usuario["usuario"]["usuario_id"], $accion_fecha);
            $mensaje = "La sucursal se editó correctamente";
        } else {
            $registro = $this->sucursal_model->RegistrarSucursal($sucursal_nombre, $sucursal_activo, $accion_usuario["usuario"]["usuario_id"], $accion_fecha);
            $mensaje = "La sucursal se registró correctamente";
        }

        if ($registro) {
            $response = [
                "error" => 0,
                "mensaje" => $mensaje,
                "icono" => "success"
            ];
        } else {
            $response = [
                "error" => 1,
                "mensaje" => "Ocurrio un error, por favor intente nuevamente",
                "icono" => "warning"
            ];
        }


        echo json_encode($response);
    }

    
}
