<?php

namespace App\Models;

use CodeIgniter\Model;

class ReporteModel extends Model
{

    function reporte_ventas($fecha_inicial, $fecha_final, $sucursal)
    {
        try {
            $sql = "SELECT va.venta_id, va.venta_cantidad, va.accion_fecha, a.articulo_nombre, a.articulo_precio, CONCAT(u.usuario_nombre, ' ', u.usuario_app, ' ', u.usuario_apm) AS usuario_venta, va.venta_cantidad*a.articulo_precio as total
            FROM venta_articulo va
            INNER JOIN articulo a ON va.articulo_id = a.articulo_id AND a.sucursal_id IN (?)
            INNER JOIN usuario u ON va.accion_usuario = u.usuario_id
            WHERE va.accion_fecha BETWEEN ? AND ?";
            $sql = $this->db->query($sql, [$sucursal, $fecha_inicial, $fecha_final]);
            return $sql->getResultArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function reporte_clientes($tipo_reporte_cliente, $fecha_ini, $fecha_fin, $cliente_id)
    {
        try {
            switch ($tipo_reporte_cliente) {
                case "1":
                    $sql = "SELECT s.sesion_id, CONCAT(u.usuario_nombre, ' ', u.usuario_app, ' ', u.usuario_apm) AS accion_usuario, CONCAT(c.usuario_nombre, ' ', c.usuario_app, ' ', c.usuario_apm) AS cliente_nombre, s.accion_fecha, p.paquete_nombre, p.paquete_cantidad_clases
                    FROM sesion s 
                    INNER JOIN cliente c ON s.cliente_id = c.usuario_id
                    INNER JOIN usuario u ON s.accion_usuario = u.usuario_id
                    INNER JOIN paquete p ON s.paquete_id = p.paquete_id
                    WHERE s.cliente_id = ? AND s.accion_fecha BETWEEN ? AND ? ORDER BY s.paquete_id ASC";
                    break;
                case "2":
                    $sql = "SELECT p.pago_id, p.accion_fecha, p.pago_monto, CONCAT(u.usuario_nombre, ' ', u.usuario_app, ' ', u.usuario_apm) AS accion_usuario, CONCAT(c.usuario_nombre, ' ', c.usuario_app, ' ', c.usuario_apm) AS cliente_nombre, pa.paquete_nombre, pa.paquete_cantidad_clases, pa.paquete_precio
                    FROM pago p
                    INNER JOIN cliente c ON p.cliente_id = c.usuario_id
                    INNER JOIN usuario u ON p.accion_usuario = u.usuario_id
                    INNER JOIN paquete pa ON p.paquete_id = pa.paquete_id
                    WHERE p.cliente_id = ? AND p.accion_fecha BETWEEN ? AND ? ORDER BY p.pago_id ASC";
                    break;
                default:
                    return [];
                    break;
            }

            $sql = $this->db->query($sql, [$cliente_id, $fecha_ini, $fecha_fin]);
            return $sql->getResultArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function reporte_promocion($tipo_reporte_promo, $fecha_ini, $fecha_fin, $promo)
    {
        try {
            switch ($tipo_reporte_promo) {
                case "1":
                    $sql = "SELECT p.promocion_id, p.promocion_nombre, p.promocion_clases, p.promocion_precio, p.promocion_inicio, p.promocion_fin, CASE
                        WHEN p.promocion_activo = 1 THEN 'activo'
                        WHEN p.promocion_activo = 0 THEN 'inactivo'
                        ELSE 'desconocido'
                    END AS estado, CONCAT(u.usuario_nombre, ' ', u.usuario_app, ' ', u.usuario_apm) AS accion_usuario, p.accion_fecha
                    FROM promocion p
                    INNER JOIN usuario u ON p.accion_usuario = u.usuario_id
                    WHERE p.accion_fecha BETWEEN ? AND ? ORDER BY p.promocion_activo DESC";
                    break;
                case "2":
                    $sql = "SELECT p.*, i.*, c.*, CONCAT(u.usuario_nombre, ' ', u.usuario_app, ' ', u.usuario_apm) AS usuario_inscripcion, CONCAT(c.usuario_nombre, ' ', c.usuario_app, ' ', c.usuario_apm) AS cliente_nombre, i.accion_fecha as fecha_inscrito, p.promocion_precio - i.inscripcion_saldo AS saldo_pendiente
                    FROM inscripcion i
                    INNER JOIN promocion p ON p.promocion_id = i.paquete_id
                    INNER JOIN cliente c ON c.usuario_id = i.cliente_id
                    INNER JOIN usuario u ON i.accion_usuario = u.usuario_id
                    WHERE i.paquete_id = $promo AND i.inscripcion_categoria = 2 AND i.accion_fecha BETWEEN ? AND ?";
                    break;
                default:
                    return [];
                    break;
            }

            $sql = $this->db->query($sql, [$fecha_ini, $fecha_fin]);
            return $sql->getResultArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function reporte_instructor($instructor_id)
    {
        try {
            $sql = "SELECT c.*, CONCAT(u.usuario_nombre, ' ', u.usuario_app, ' ', u.usuario_apm) AS instructor_nombre
            FROM curso c
            INNER JOIN usuario u ON c.instructor_id = u.usuario_id
            WHERE c.instructor_id = ?";
            $sql = $this->db->query($sql, [$instructor_id]);
            return $sql->getResultArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function reporte_paquete($paquete_id)
    {
        try {
            $sql = "SELECT p.*, i.*, c.*, CONCAT(u.usuario_nombre, ' ', u.usuario_app, ' ', u.usuario_apm) AS accion_usuario
            FROM paquete p
            INNER JOIN inscripcion i ON p.paquete_id = i.paquete_id
            INNER JOIN usuario u ON p.accion_usuario = u.usuario_id
            INNER JOIN cliente c ON c.cliente_id = i.cliente_id
            WHERE p.paquete_id = ?";
            $sql = $this->db->query($sql, [$paquete_id]);
            return $sql->getResultArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function reporte_inscritos($paquete_id, $sucursal)
    {
        try {
            $sql = "SELECT p.*, i.*, c.*, CONCAT(c.usuario_nombre, ' ', c.usuario_app, ' ', c.usuario_apm) AS cliente_nombre, i.accion_fecha AS fecha_inscrito, i.accion_usuario, CONCAT_WS(' ', u.usuario_nombre, u.usuario_app, u.usuario_apm) AS usuario_inscripcion, p.paquete_precio - i.inscripcion_saldo AS saldo_pendiente
            FROM inscripcion i
            INNER JOIN cliente c ON c.usuario_id = i.cliente_id
            INNER JOIN paquete p ON p.paquete_id = i.paquete_id
            INNER JOIN usuario u ON u.usuario_id = i.accion_usuario
            WHERE i.paquete_id = ? AND i.inscripcion_categoria = 1 AND i.sucursal_id IN (?)";
            $sql = $this->db->query($sql, [$paquete_id, $sucursal]);
            return $sql->getResultArray();
        } catch (\Exception $e) {
            return false;
        }
    }
}
