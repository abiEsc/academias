<?php

namespace App\Models\auth;

use CodeIgniter\Model;

class AuthModel extends Model
{

    function registrar_usuario($rol_id, $usuario_nombre, $usuario_app, $usuario_apm, $usuario_ci, $usuario_direccion, $usuario_telefono, $usuario_email, $usuario_password)
    {
        try {
            $sql = "INSERT INTO usuario (rol_id, usuario_nombre, usuario_app, usuario_apm, usuario_ci, usuario_direccion, usuario_telefono, usuario_email, usuario_password, usuario_activo) VALUES (?,?,?,?,?,?,?,?,?,?)";
            $this->db->query($sql, [$rol_id, $usuario_nombre, $usuario_app, $usuario_apm, $usuario_ci, $usuario_direccion, $usuario_telefono, $usuario_email, $usuario_password, "1"]);
            return $this->db->insertID();
        } catch (\Exception $e) {
            //throw $th;
        }
    }

    function iniciar_sesion($correo, $password)
    {
        try {
            $sql = "SELECT usuario_id, rol_id, CONCAT(usuario_nombre, ' ', usuario_app, ' ', usuario_apm) AS nombre_completo, usuario_ci, usuario_direccion, usuario_telefono, usuario_email, usuario_activo, usuario_password FROM usuario WHERE usuario_email = ? AND usuario_password = ? AND usuario_activo = 1;";
            $sql = $this->db->query($sql, [$correo, $password]);
            return $sql->getRowArray();
        } catch (\Exception $e) {
            //throw $th;
        }
    }

    function iniciar_sesion_cliente($correo, $password)
    {
        try {
            $sql = "SELECT usuario_id, CONCAT(usuario_nombre, ' ', usuario_app, ' ', usuario_apm) AS nombre_completo, usuario_ci, usuario_direccion, usuario_telefono, usuario_email, usuario_activo, cliente_tipo FROM cliente WHERE usuario_email = ? AND usuario_password = ? AND usuario_activo = 1";
            $sql = $this->db->query($sql, [$correo, $password]);
            return $sql->getRowArray();
        } catch (\Exception $e) {
            //throw $th;
        }
    }

    function obtener_datos_menu($rol_usuario, $usuario_id)
    {
        try {
            $sql = "SELECT m.menu_nombre, m.menu_descripcion, m.menu_enlace, m.menu_icono 
                FROM usuario u
                INNER JOIN rol_menu rm ON rm.rol_id = u.rol_id
                INNER JOIN menu m ON m.menu_id = rm.menu_id
                WHERE u.rol_id = ? AND u.usuario_id = ?";
            $sql = $this->db->query($sql, [$rol_usuario, $usuario_id]);
            return $sql->getResultArray();
        } catch (\Exception $e) {
            //throw $th;
        }
    }

    function obtener_datos_menu_cliente($rol_usuario, $usuario_id)
    {
        try {
            $sql = "SELECT m.menu_nombre, m.menu_descripcion, m.menu_enlace, m.menu_icono 
                FROM cliente u
                INNER JOIN rol_menu rm ON rm.rol_id = ?
                INNER JOIN menu m ON m.menu_id = rm.menu_id
                WHERE u.usuario_id = ? AND u.cliente_tipo = 1";
            $sql = $this->db->query($sql, [$rol_usuario, $usuario_id]);
            return $sql->getResultArray();
        } catch (\Exception $e) {
            //throw $th;
        }
    }
}
