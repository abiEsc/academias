<?php

namespace App\Models;

use CodeIgniter\Model;

class CursoModel extends Model
{

    function recuperar_curso_id($curso_id)
    {
        try {
            $sql = "SELECT c.curso_id, c.curso_nombre, c.horario_ini, c.horario_fin, CONCAT(u.usuario_nombre, ' ', u.usuario_app, ' ', u.usuario_apm) AS nombre_instructor, c.instructor_id, c.curso_dias FROM curso c
            INNER JOIN usuario u ON u.usuario_id = c.instructor_id
            WHERE c.curso_id = ?";
            $sql = $this->db->query($sql, [$curso_id]);
            return $sql->getRowArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function recuperar_cursos()
    {
        try {
            $sql = "SELECT c.curso_id, c.curso_nombre, c.horario_ini, c.horario_fin, CONCAT(u.usuario_nombre, ' ', u.usuario_app, ' ', u.usuario_apm) AS nombre_instructor, c.instructor_id, c.curso_dias FROM curso c
            INNER JOIN usuario u ON u.usuario_id = c.instructor_id";
            $sql = $this->db->query($sql);
            return $sql->getResultArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function registrar_curso($curso, $instructor, $horario_ini, $horario_fin, $dias, $accion_usuario, $accion_fecha)
    {
        try {
            $sql = "INSERT INTO curso (curso_nombre, instructor_id, horario_ini, horario_fin, curso_dias, accion_usuario, accion_fecha) VALUES (?, ?, ?, ?, ?, ?, ?) ";
            $sql = $this->db->query($sql, [$curso, $instructor, $horario_ini, $horario_fin, $dias, $accion_usuario, $accion_fecha]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function editar_curso($curso,  $curso_id, $instructor, $horario_ini, $horario_fin, $dias, $accion_usuario, $accion_fecha)
    {
        try {
            $sql = "UPDATE curso SET curso_nombre = ?, instructor_id = ?, horario_ini = '$horario_ini', horario_fin = '$horario_fin', curso_dias = ?, accion_usuario = ?, accion_fecha = ? WHERE curso_id = ? ";
            $sql = $this->db->query($sql, [$curso, $instructor, $dias, $accion_usuario, $accion_fecha, $curso_id]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function eliminar_curso($curso_id)
    {
        try {
            $sql = "DELETE FROM curso WHERE curso_id = ?";
            $this->db->query($sql, [$curso_id]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function recuperar_paquete_id($paquete_id)
    {
        try {
            $sql = "SELECT paquete_id, paquete_nombre, paquete_cantidad_clases, paquete_precio FROM paquete WHERE paquete_id = ?";
            $sql = $this->db->query($sql, [$paquete_id]);
            return $sql->getRowArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function recuperar_paquetes()
    {
        try {
            $sql = "SELECT paquete_id, paquete_nombre, paquete_cantidad_clases, paquete_precio FROM paquete";
            $sql = $this->db->query($sql);
            return $sql->getResultArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function registrar_paquete($paquete, $cantidad_clases, $paquete_precio, $accion_usuario, $accion_fecha)
    {
        $response = true;
        try {
            $sql = "INSERT INTO paquete (paquete_nombre, paquete_cantidad_clases, paquete_precio, accion_usuario, accion_fecha) VALUES (?, ?, ?, ?, ?) ";
            $sql = $this->db->query($sql, [$paquete, $cantidad_clases, $paquete_precio, $accion_usuario, $accion_fecha]);
        } catch (\Exception $e) {
            $response = false;
        }
        return $response;
    }

    function editar_paquete($paquete_id, $paquete, $cantidad_clases, $paquete_precio, $accion_usuario, $accion_fecha)
    {
        try {
            $sql = "UPDATE paquete SET paquete_nombre = ?, paquete_cantidad_clases = ?, paquete_precio = ?, accion_usuario = ?, accion_fecha = ? WHERE paquete_id = ? ";
            $sql = $this->db->query($sql, [$paquete, $cantidad_clases, $paquete_precio, $accion_usuario, $accion_fecha, $paquete_id]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function verificar_inscritos_paquete($paquete_id)
    {
        try {
            $sql = "SELECT paquete_id FROM inscripcion WHERE paquete_id = ?";
            $sql = $this->db->query($sql, [$paquete_id]);
            return $sql->getResultArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function eliminar_paquete($paquete_id)
    {
        try {
            $sql = "DELETE FROM paquete WHERE paquete_id = ?";
            $this->db->query($sql, [$paquete_id]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function recuperar_promociones()
    {
        try {
            $sql = "SELECT * FROM promocion";
            $sql = $this->db->query($sql);
            return $sql->getResultArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function recuperar_promociones_activas()
    {
        try {
            $sql = "SELECT * FROM promocion WHERE promocion_activo = 1";
            $sql = $this->db->query($sql);
            return $sql->getResultArray();
        } catch (\Exception $e) {
            return false;
        }
    }


    function registrar_promocion($promocion, $cantidad_clases, $promocion_precio, $promocion_ini, $promocion_fin, $accion_usuario, $accion_fecha)
    {
        $response = true;
        try {
            $sql = "INSERT INTO promocion (promocion_nombre, promocion_clases, promocion_precio, promocion_inicio, promocion_fin, accion_usuario, accion_fecha) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $sql = $this->db->query($sql, [$promocion, $cantidad_clases, $promocion_precio, $promocion_ini, $promocion_fin, $accion_usuario, $accion_fecha]);
        } catch (\Exception $e) {
            $response = false;
        }
        return $response;
    }

    function editar_promocion($promocion_id, $promocion, $cantidad_clases, $promocion_precio, $promocion_ini, $promocion_fin, $accion_usuario, $accion_fecha)
    {
        try {
            $sql = "UPDATE promocion SET promocion_nombre = ?, promocion_clases = ?, promocion_precio = ?, promocion_inicio = ?, promocion_fin = ?, accion_usuario = ?, accion_fecha = ? WHERE promocion_id = ?";
            $sql = $this->db->query($sql, [$promocion, $cantidad_clases, $promocion_precio, $promocion_ini, $promocion_fin, $accion_usuario, $accion_fecha, $promocion_id]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function recuperar_promocion_id($promocion_id)
    {
        try {
            $sql = "SELECT * FROM promocion WHERE promocion_id = ?";
            $sql = $this->db->query($sql, [$promocion_id]);
            return $sql->getRowArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function cambiar_estado($promocion_id, $estado)
    {
        try {
            $sql = "UPDATE promocion SET promocion_activo = ? WHERE promocion_id = ?";
            $this->db->query($sql, [$estado, $promocion_id]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function validar_curso($curso_id)
    {
        $response = [];

        $curso = $this->recuperar_curso_id($curso_id);

        if (!empty($curso)) {
            $response = [
                "error" => 0,
                "data" => $curso
            ];
        } else {
            $response = [
                "error" => 1,
                "data" => "El curso seleccionado no existe"
            ];
        }

        return $response;
    }

    function validar_paquete($paquete_id)
    {
        $response = [];

        $paquete = $this->recuperar_paquete_id($paquete_id);

        if (!empty($paquete)) {
            $response = [
                "error" => 0,
                "data" => $paquete
            ];
        } else {
            $response = [
                "error" => 1,
                "data" => "El paquete seleccionado no existe"
            ];
        }

        return $response;
    }

    function validar_promocion($promocion_id)
    {
        $response = [];

        $promocion = $this->recuperar_promocion_id($promocion_id);

        if (!empty($promocion)) {
            $response = [
                "error" => 0,
                "data" => $promocion
            ];
        } else {
            $response = [
                "error" => 1,
                "data" => "La promoción seleccionada no existe."
            ];
        }

        return $response;
    }
}
