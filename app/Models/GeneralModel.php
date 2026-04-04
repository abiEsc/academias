<?php

namespace App\Models;

use CodeIgniter\Model;

class GeneralModel extends Model
{
    function guardar_media($nombreOriginal, $accion_usuario, $accion_fecha)
    {
        try {
            $sql = "INSERT INTO galeria (galeria_url, accion_usuario, accion_fecha) VALUES (?, ?, ?)";
            $sql = $this->db->query($sql, [$nombreOriginal, $accion_usuario, $accion_fecha]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function listar_galeria()
    {
        try {
            $sql = "SELECT * FROM galeria";
            $sql = $this->db->query($sql);
            return $sql->getResultArray();
        } catch (\Exception $e) {
            return false;
        }
    }

    function remover_galeria($galeria_id)
    {
        try {
            $sql = "DELETE FROM galeria WHERE galeria.galeria_id = ?";
            $sql = $this->db->query($sql, [$galeria_id]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
