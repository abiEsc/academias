<?php

namespace App\Models;

use CodeIgniter\Model;

class SucursalModel extends Model
{
    function ListarSucursales($sucursal_id = "", $estado = "")
    {
        try {
            $filtro = "";
            if ($sucursal_id != "") {
                $filtro .= " AND sucursal_id = $sucursal_id ";
            }

            if ($estado != "") {
                $filtro .= " AND sucursal_activo = $estado ";
            }

            $sql = "SELECT * FROM estructura_sucursal WHERE 1 $filtro";
            $sql = $this->db->query($sql);
            return $sql->getResultArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function EditarSucursal($sucursal_id, $sucursal_nombre, $sucursal_activo, $accion_usuario, $accion_fecha)
    {
        try {
            $sql = "UPDATE estructura_sucursal SET sucursal_nombre = ?, sucursal_activo = ?, accion_usuario = ?, accion_fecha = ? WHERE sucursal_id = ?";
            $this->db->query($sql, [$sucursal_nombre, $sucursal_activo, $accion_usuario, $accion_fecha, $sucursal_id]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function RegistrarSucursal($sucursal_nombre, $sucursal_activo, $accion_usuario, $accion_fecha)
    {
        try {
            $sql = "INSERT INTO estructura_sucursal(sucursal_nombre, sucursal_activo, accion_usuario, accion_fecha) VALUES (?, ?, ?, ?)";
            $this->db->query($sql, [$sucursal_nombre, $sucursal_activo, $accion_usuario, $accion_fecha]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function remover_sucursales($usuario_id)
    {
        try {
            $sql = "DELETE FROM usuario_sucursal WHERE usuario_id = ?";
            $this->db->query($sql, [$usuario_id]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function asignar_sucursales($usuario_id, $sucursal_id, $accion_usuario, $accion_fecha)
    {
        try {
            $sql = "INSERT INTO usuario_sucursal(usuario_id, sucursal_id, accion_usuario, accion_fecha) VALUES (?, ?, ?, ?)";
            $this->db->query($sql, [$usuario_id, $sucursal_id, $accion_usuario, $accion_fecha]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function recuperar_sucursales($usuario_id)
    {
        try {
            $sql = "SELECT s.sucursal_nombre, s.sucursal_id, s.sucursal_activo
            FROM usuario_sucursal us
            INNER JOIN estructura_sucursal s ON s.sucursal_id = us.sucursal_id AND s.sucursal_activo = 1
            WHERE us.usuario_id = ?";
            $sql = $this->db->query($sql, [$usuario_id]);
            return $sql->getResultArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function listar_sucursales_id($usuario_id)
    {
        $sucursales = $this->recuperar_sucursales($usuario_id);

        $lista_sucursales = "";
        foreach ($sucursales as $value) {
            $lista_sucursales .= $value["sucursal_id"] . ",";
        }
        $lista_sucursales = rtrim($lista_sucursales, ",");

        return $lista_sucursales;
    }
}
