<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonalModel extends Model
{

    function recuperar_personal_id($usuario_id)
    {
        try {
            $sql = "SELECT u.usuario_id, u.rol_id, u.usuario_nombre, u.usuario_app, u.usuario_apm, CONCAT(u.usuario_nombre, ' ', u.usuario_app, ' ', u.usuario_apm) AS nombre_completo, u.usuario_ci, u.usuario_direccion, u.usuario_telefono, u.usuario_email, u.usuario_activo, r.rol_nombre, r.rol_id FROM usuario u
            INNER JOIN rol r ON r.rol_id = u.rol_id WHERE u.usuario_id = ? ORDER BY u.usuario_id ASC";
            $sql = $this->db->query($sql, [$usuario_id]);
            return $sql->getRowArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function recuperar_personal($tipo_rol = "")
    {
        try {
            $filtro = "";
            if ($tipo_rol != "") {
                $filtro = " AND u.rol_id = $tipo_rol AND u.usuario_activo = 1 ";
            }
            $sql = "SELECT u.usuario_id, u.rol_id, u.usuario_nombre, u.usuario_app, u.usuario_apm, CONCAT(u.usuario_nombre, ' ', u.usuario_app, ' ', u.usuario_apm) AS nombre_completo, u.usuario_ci, u.usuario_direccion, u.usuario_telefono, u.usuario_email, u.usuario_activo, r.rol_nombre FROM usuario u
            INNER JOIN rol r ON r.rol_id = u.rol_id " . $filtro . " ORDER BY u.usuario_id ASC";
            $sql = $this->db->query($sql);
            return $sql->getResultArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function inactivar_personal($usuario_id)
    {
        try {
            $sql = "UPDATE usuario SET usuario_activo = 0 WHERE usuario_id = ?";
            $this->db->query($sql, [$usuario_id]);
        } catch (\Exception $e) {
            return false;
        }
    }

    function eliminar_personal($usuario_id)
    {
        try {
            $sql = "DELETE FROM usuario WHERE usuario_id = ?";
            $this->db->query($sql, [$usuario_id]);
        } catch (\Exception $e) {
            return false;
        }
    }

    function reactivar_personal($usuario_id)
    {
        try {
            $sql = "UPDATE usuario SET usuario_activo = 1 WHERE usuario_id = ?";
            $this->db->query($sql, [$usuario_id]);
        } catch (\Exception $e) {
            return false;
        }
    }

    function editar_personal($rol, $nombre, $app, $apm, $ci, $direccion, $telefono, $email, $usuario_id)
    {
        try {
            $sql = "UPDATE usuario SET rol_id = ?, usuario_nombre = ?, usuario_app = ?, usuario_apm = ?, usuario_ci = ?, usuario_direccion = ?, usuario_telefono = ?, usuario_email = ? WHERE usuario.usuario_id = ? ";
            $this->db->query($sql, [$rol, $nombre, $app, $apm, $ci, $direccion, $telefono, $email, $usuario_id]);
        } catch (\Exception $e) {
            return false;
        }
    }

    function obtener_cursos($usuario_id)
    {
        try {
            $sql = "SELECT c.curso_id, c.curso_nombre, c.horario_ini, c.horario_fin, c.curso_dias FROM curso c
            INNER JOIN usuario u ON u.usuario_id = c.instructor_id
            WHERE c.instructor_id = ?";
            $sql = $this->db->query($sql, [$usuario_id]);
            return $sql->getResultArray();
        } catch (\Exception $e) {
            return false;
        }
    }


    function validar_personal($personal_id)
    {
        $response = [];

        $personal = $this->recuperar_personal_id($personal_id);

        if (!empty($personal)) {
            $response = [
                "error" => 0,
                "data" => $personal
            ];
        } else {
            $response = [
                "error" => 1,
                "data" => "El usuario seleccionado no existe o tiene una cuenta inactiva"
            ];
        }

        return $response;
    }
}
