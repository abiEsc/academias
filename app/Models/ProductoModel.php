<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model
{

    function recuperar_productos($venta = "", $sucursales = "")
    {
        try {
            $filtro = "";
            if ($venta == "1") {
                $filtro = " AND articulo_activo = 1 ";
            }
            if ($sucursales != "") {
                $filtro = " AND sucursal_id IN ($sucursales) ";
            }
            $sql = "SELECT articulo_id, articulo_nombre, articulo_cantidad, articulo_precio, articulo_activo FROM articulo WHERE 1 $filtro";
            $sql = $this->db->query($sql);
            return $sql->getResultArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function recuperar_producto_id($producto_id)
    {
        try {
            $sql = "SELECT articulo_id, articulo_nombre, articulo_cantidad, articulo_precio, articulo_activo FROM articulo WHERE articulo_id = ?";
            $sql = $this->db->query($sql, [$producto_id]);
            return $sql->getRowArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function registrar_producto($producto, $cantidad, $precio, $accion_usuario, $accion_fecha)
    {
        try {
            $sql = "INSERT INTO articulo (articulo_nombre, articulo_cantidad, articulo_precio, accion_usuario, accion_fecha) VALUES (?, ?, ?, ?, ?)";
            $sql = $this->db->query($sql, [$producto, $cantidad, $precio, $accion_usuario, $accion_fecha]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function editar_producto($producto, $cantidad, $precio, $producto_id, $accion_usuario, $accion_fecha)
    {
        try {
            $sql = "UPDATE articulo SET articulo_nombre = ?, articulo_cantidad = ?, articulo_precio = ?, accion_usuario = ?, accion_fecha = ? WHERE articulo_id = ?";
            $sql = $this->db->query($sql, [$producto, $cantidad, $precio, $accion_usuario, $accion_fecha, $producto_id]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function eliminar_producto($producto_id, $estado)
    {
        try {
            $sql = "UPDATE articulo SET articulo_activo = ? WHERE articulo_id = ?";
            $sql = $this->db->query($sql, [$estado, $producto_id]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function registrar_venta($producto_id, $cantidad, $accion_usuario, $accion_fecha)
    {
        try {
            $sql = "INSERT INTO venta_articulo (articulo_id, venta_cantidad, accion_usuario, accion_fecha) VALUES (?, ?, ?, ?)";
            $sql = $this->db->query($sql, [$producto_id, $cantidad, $accion_usuario, $accion_fecha]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function recuperar_venta_producto_id($producto_id)
    {
        try {
            $sql = "SELECT v.venta_cantidad, a.articulo_nombre, a.articulo_precio FROM venta_articulo v INNER JOIN articulo a ON a.articulo_id = v.articulo_id WHERE v.articulo_id = ?";
            $sql = $this->db->query($sql, [$producto_id]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }



    function validar_producto($producto_id)
    {
        $response = [];

        $producto = $this->recuperar_producto_id($producto_id);

        if (!empty($producto)) {
            $response = [
                "error" => 0,
                "data" => $producto
            ];
        } else {
            $response = [
                "error" => 1,
                "data" => "El producto seleccionado no existe."
            ];
        }

        return $response;
    }
}
