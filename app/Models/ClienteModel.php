<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    function recuperar_cliente_id($usuario_id)
    {
        try {
            $sql = "SELECT usuario_id, usuario_nombre, usuario_app, usuario_apm, CONCAT(usuario_nombre, ' ', usuario_app, ' ', usuario_apm) AS nombre_completo, usuario_ci, usuario_direccion, usuario_telefono, usuario_email, usuario_activo, cliente_tipo FROM cliente WHERE usuario_id = ? ORDER BY usuario_id ASC";
            $sql = $this->db->query($sql, [$usuario_id]);
            return $sql->getRowArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function recuperar_cliente()
    {
        try {
            $sql = "SELECT usuario_id, CONCAT(usuario_nombre, ' ', usuario_app, ' ', usuario_apm) AS nombre_completo, usuario_ci, usuario_direccion, usuario_telefono, usuario_email, usuario_activo, cliente_tipo FROM cliente ORDER BY usuario_id ASC";
            $sql = $this->db->query($sql);
            return $sql->getResultArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function registrar_cliente($usuario_nombre, $usuario_app, $usuario_apm, $usuario_ci, $usuario_direccion, $usuario_telefono, $usuario_email, $usuario_password, $usuario_activo, $cliente_tipo, $accion_usuario, $accion_fecha)
    {
        try {
            $sql = "INSERT INTO cliente (usuario_nombre, usuario_app, usuario_apm, usuario_ci, usuario_direccion, usuario_telefono, usuario_email, usuario_password, usuario_activo, cliente_tipo, accion_usuario, accion_fecha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $this->db->query($sql, [$usuario_nombre, $usuario_app, $usuario_apm, $usuario_ci, $usuario_direccion, $usuario_telefono, $usuario_email, $usuario_password, $usuario_activo, $cliente_tipo, $accion_usuario, $accion_fecha]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function inactivar_cliente($usuario_id)
    {
        try {
            $sql = "UPDATE cliente SET usuario_activo = 0 WHERE usuario_id = ?";
            $this->db->query($sql, [$usuario_id]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function eliminar_cliente($usuario_id)
    {
        try {
            $sql = "DELETE FROM cliente WHERE usuario_id = ?";
            $this->db->query($sql, [$usuario_id]);
        } catch (\Exception $e) {
            return false;
        }
    }

    function reactivar_cliente($usuario_id)
    {
        try {
            $sql = "UPDATE cliente SET usuario_activo = 1 WHERE usuario_id = ?";
            $this->db->query($sql, [$usuario_id]);
        } catch (\Exception $e) {
            return false;
        }
    }

    function editar_cliente($nombre, $app, $apm, $ci, $direccion, $telefono, $email, $tipo, $usuario_id)
    {
        try {
            $sql = "UPDATE cliente SET usuario_nombre = ?, usuario_app = ?, usuario_apm = ?, usuario_ci = ?, usuario_direccion = ?, usuario_telefono = ?, usuario_email = ?, cliente_tipo = ? WHERE cliente.usuario_id = ? ";
            $this->db->query($sql, [$nombre, $app, $apm, $ci, $direccion, $telefono, $email, $tipo, $usuario_id]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function registrar_inscripcion($paquete_id, $usuario_id, $saldo, $categoria, $accion_usuario, $accion_fecha)
    {
        try {
            $sql = "INSERT INTO inscripcion (paquete_id, cliente_id, inscripcion_saldo, inscripcion_categoria, accion_usuario, accion_fecha) VALUES (?, ?, ?, ?, ?, ?)";
            $this->db->query($sql, [$paquete_id, $usuario_id, $saldo, $categoria, $accion_usuario, $accion_fecha]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function auditoria_inscripcion($usuario_id, $ritmo, $categoria, $monto, $accion_usuario, $accion_fecha)
    {
        try {
            $sql = "INSERT INTO pago (cliente_id, paquete_id, paquete_categoria, pago_monto, accion_usuario, accion_fecha) VALUES (?, ?, ?, ?, ?, ?)";
            $this->db->query($sql, [$usuario_id, $ritmo, $categoria, $monto, $accion_usuario, $accion_fecha]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function recuperar_inscripcion($paquete_id, $cliente_id, $categoria)
    {
        try {
            $join = "";
            if ($categoria == 1) {
                $columns = " p.paquete_nombre, p.paquete_precio, p.paquete_cantidad_clases ";
                $join = " INNER JOIN paquete p ON p.paquete_id = i.paquete_id ";
            } else {
                $columns = " p.promocion_nombre as paquete_nombre, p.promocion_precio as paquete_precio, p.promocion_clases as paquete_cantidad_clases ";
                $join = " INNER JOIN promocion p ON p.promocion_id = i.paquete_id ";
            }




            $sql = "SELECT i.inscripcion_saldo, i.inscripcion_activo, i.inscripcion_categoria, $columns 
            FROM inscripcion i
            $join
            WHERE i.paquete_id = ? AND i.cliente_id = ? AND i.inscripcion_categoria = ?";
            $sql = $this->db->query($sql, [$paquete_id, $cliente_id, $categoria]);
            return $sql->getRowArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function actualizar_saldo($nuevo_saldo, $accion_usuario, $accion_fecha, $paquete_id, $usuario_id, $categoria)
    {
        try {
            $sql = "UPDATE inscripcion SET inscripcion_saldo = ?, accion_usuario = ?, accion_fecha = ? WHERE paquete_id = ? AND cliente_id = ? AND inscripcion_categoria = ?";
            $this->db->query($sql, [$nuevo_saldo, $accion_usuario, $accion_fecha, $paquete_id, $usuario_id, $categoria]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function registrar_sesion($usuario_id, $curso_id, $categoria, $accion_fecha, $accion_usuario)
    {
        try {
            $sql = "INSERT INTO sesion (cliente_id, paquete_id, paquete_categoria, accion_fecha, accion_usuario) VALUES (?, ?, ?, ?, ?) ";
            $this->db->query($sql, [$usuario_id, $curso_id, $categoria, $accion_fecha, $accion_usuario]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function completar_sesiones($usuario_id, $curso_id, $categoria)
    {
        try {
            $sql = "UPDATE inscripcion SET inscripcion_activo = 0 WHERE cliente_id = ? AND paquete_id = ? AND inscripcion_categoria = ?";
            $this->db->query($sql, [$usuario_id, $curso_id, $categoria]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function recuperar_cursos($usuario_id, $sucursales = "")
    {
        try {
            $filtro = "";
            if ($sucursales != "") {
                $filtro .= " AND i.sucursal_id IN ($sucursales) ";
            }
            $sql = "SELECT i.cliente_id, i.inscripcion_saldo, i.inscripcion_categoria, p.paquete_id, p.paquete_nombre, p.paquete_cantidad_clases, p.paquete_precio, i.inscripcion_activo, '1' as categoria, i.sucursal_id
            FROM inscripcion i
            INNER JOIN paquete p ON p.paquete_id = i.paquete_id
            WHERE i.cliente_id = ? AND i.inscripcion_activo = 1 AND i.inscripcion_categoria = 1 $filtro";
            $sql = $this->db->query($sql, [$usuario_id]);
            return $sql->getResultArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function recuperar_cursos_promo($usuario_id, $sucursales = "")
    {
        try {
            $filtro = "";
            if ($sucursales != "") {
                $filtro .= " AND i.sucursal_id IN ($sucursales) ";
            }
            $sql = "SELECT i.cliente_id, i.inscripcion_saldo, i.inscripcion_categoria, p.promocion_id as paquete_id, p.promocion_nombre as paquete_nombre, p.promocion_clases as paquete_cantidad_clases, p.promocion_precio as paquete_precio, i.inscripcion_activo, '2' as categoria
            FROM inscripcion i
            INNER JOIN promocion p ON p.promocion_id = i.paquete_id
            WHERE i.cliente_id = ? AND i.inscripcion_activo = 1 AND i.inscripcion_categoria = 2 $filtro";
            $sql = $this->db->query($sql, [$usuario_id]);
            return $sql->getResultArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function recuperar_sesiones($usuario_id, $paquete_id, $categoria)
    {
        try {
            $sql = "SELECT * FROM sesion WHERE cliente_id = ? AND paquete_id = ? AND paquete_categoria = ?";
            $sql = $this->db->query($sql, [$usuario_id, $paquete_id, $categoria]);
            return $sql->getResultArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function vaciar_sesiones($usuario_id)
    {
        try {
            $sql = "DELETE FROM sesion WHERE cliente_id = ?";
            $this->db->query($sql, [$usuario_id]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }




    function validar_cliente($cliente_id)
    {
        $response = [];

        $cliente = $this->recuperar_cliente_id($cliente_id);

        if (!empty($cliente)) {
            $response = [
                "error" => 0,
                "data" => $cliente
            ];
        } else {
            $response = [
                "error" => 1,
                "data" => "El cliente seleccionado no existe o tiene una cuenta inactiva"
            ];
        }

        return $response;
    }
}
