<?php

namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\SucursalModel;

class InventarioController extends StructureController
{

    function __construct()
    {
        parent::__construct();
        $this->input = \Config\Services::request();
        $this->productos_model = new ProductoModel();
        $this->sucursal_model = new SucursalModel();
    }


    function index()
    {

        $usuario = $this->session->get();
        $sucursales = $this->sucursal_model->recuperar_sucursales($usuario["usuario"]["usuario_id"]);
        $sucursales = MapSucursal($sucursales);

        $lista_sucursales = $this->base_sucursal->listar_sucursales_id($usuario["usuario"]["usuario_id"]);


        $lista_productos = $this->productos_model->recuperar_productos("", $lista_sucursales);
        $lista_productos = $lista_productos ? $lista_productos : [];
        
        $data["lista_productos"] = $lista_productos;
        $data["sucursales"] = $sucursales;
        
        return parent::dashboard("inventario/dashboard", $data);
    }

    function registrar_producto()
    {
        $producto = $this->input->getPost("producto");
        $cantidad = $this->input->getPost("cantidad");
        $precio = $this->input->getPost("precio");

        $accion_usuario = $this->session->get();
        $accion_fecha = date('Y-m-d H:i:s');

        if (isset($_POST["producto_id"]) && $_POST["producto_id"] != "") {
            $producto_id = $this->input->getPost("producto_id");
            $registro = $this->productos_model->editar_producto($producto, $cantidad, $precio, $producto_id, $accion_usuario["usuario"]["usuario_id"], $accion_fecha);
            $mensaje = "El producto se editó correctamente";
        } else {
            $registro = $this->productos_model->registrar_producto($producto, $cantidad, $precio, $accion_usuario["usuario"]["usuario_id"], $accion_fecha);
            $mensaje = "Producto registrado correctamente";
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

    function recuperar_producto()
    {
        $producto_id = $this->input->getPost("producto_id");
        $producto = $this->productos_model->recuperar_producto_id($producto_id);
        echo json_encode($producto);
    }

    function eliminar_producto()
    {
        $response = [];

        $producto_id = $this->input->getPost("producto_id");

        $producto = $this->productos_model->validar_producto($producto_id);

        if ($producto["error"] == 1) {
            $response = [
                "error" => $producto["error"],
                "mensaje" => $producto["data"],
                "icono" => "error"
            ];
        } else {
            $this->productos_model->eliminar_producto($producto_id, 0);
            $response = [
                "error" => 0,
                "icono" => "success",
                "mensaje" => "El articulo se inactivo correctamente."
            ];
        }

        echo json_encode($response);
    }

    function reactivar_producto()
    {
        $response = [];

        $producto_id = $this->input->getPost("producto_id");

        $producto = $this->productos_model->validar_producto($producto_id);

        if ($producto["error"] == 1) {
            $response = [
                "error" => $producto["error"],
                "mensaje" => $producto["data"],
                "icono" => "error"
            ];
        } else {
            $this->productos_model->eliminar_producto($producto_id, 1);
            $response = [
                "error" => 0,
                "icono" => "success",
                "mensaje" => "El articulo se inactivo correctamente."
            ];
        }

        echo json_encode($response);
    }

    function venta_producto()
    {
        $producto_id = $this->input->getPost("producto_id");
        $cantidad = (int) $this->input->getPost("cantidad");

        if ($cantidad == "" || $cantidad == 0 || !is_int($cantidad)) {
            $response = [
                "error" => 1,
                "mensaje" => "Los valores registrados son incorrectos, por favor verifique",
                "icono" => "error"
            ];
        } else {
            $producto = $this->productos_model->validar_producto($producto_id);

            $accion_usuario = $this->session->get();
            $accion_fecha = date('Y-m-d H:i:s');

            if ($producto["error"] == 1) {
                $mensaje = $producto["data"];
            } else {
                if ($cantidad > $producto["data"]["articulo_cantidad"]) {
                    $registro = false;
                } else {
                    $accion_usuario = $this->session->get();
                    $accion_fecha = date('Y-m-d H:i:s');
                    $registro = $this->productos_model->registrar_venta($producto_id, $cantidad, $accion_usuario["usuario"]["usuario_id"], $accion_fecha);
                    $nueva_cantidad = $producto["data"]["articulo_cantidad"] - $cantidad;
                    $this->productos_model->editar_producto($producto["data"]["articulo_nombre"], $nueva_cantidad, $producto["data"]["articulo_precio"], $producto_id, $accion_usuario["usuario"]["usuario_id"], $accion_fecha);
                    $mensaje = "Se registro correctamente la venta.";
                }
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
        }




        echo json_encode($response);
    }
}
