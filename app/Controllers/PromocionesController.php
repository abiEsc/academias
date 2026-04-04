<?php

namespace App\Controllers;

use App\Models\CursoModel;

class PromocionesController extends StructureController
{

    function __construct()
    {
        $this->input = \Config\Services::request();
        $this->curso_model = new CursoModel();
    }

    function index()
    {
        $promociones = $this->curso_model->recuperar_promociones_activas();
        $cursos = $this->curso_model->recuperar_cursos();
        $paquetes = $this->curso_model->recuperar_paquetes();

        $fecha_actual = date('Y-m-d');

        $lista_promociones = [];
        if (!empty($promociones)) {
            foreach ($promociones as $promo) {
                if (strtotime($fecha_actual) <= strtotime($promo["promocion_fin"])) {
                    $color = generarColorAleatorio();
                    $lista_promociones[] = [
                        "promocion_id" => $promo["promocion_id"],
                        "promocion_nombre" => $promo["promocion_nombre"],
                        "promocion_clases" => $promo["promocion_clases"],
                        "promocion_precio" => $promo["promocion_precio"],
                        "promocion_inicio" => getFormatoFechaD_M_Y($promo["promocion_inicio"]),
                        "promocion_fin" => getFormatoFechaD_M_Y($promo["promocion_fin"]),
                        "promocion_activo" => $promo["promocion_activo"],
                        "color" => $color
                    ];
                }
            }
        }

        $lista_cursos = [];

        if (count($cursos) > 0) {
            foreach ($cursos as $key => $curso) {
                $color = generarColorAleatorio();

                $dias = explode(",", $curso["curso_dias"]);
                $semana = "";


                foreach ($dias as $dia) {
                    if ($dia > 0) {
                        $semana .= dias_numerico_literal($dia) . ", ";
                    } else {
                        $semana = "Dato Incorrecto";
                    }
                }

                $semana = rtrim($semana, ", ");


                $lista_cursos[$key] = [
                    "curso_id" => $curso["curso_id"],
                    "curso_nombre" => $curso["curso_nombre"],
                    "instructor_id" => $curso["instructor_id"],
                    "nombre_instructor" => $curso["nombre_instructor"],
                    "horario_ini" => $curso["horario_ini"],
                    "horario_fin" => $curso["horario_fin"],
                    "dias" => nl2br($semana),
                    "color" => $color
                ];
            }
        }

        $lista_paquetes = [];

        if (count($paquetes) > 0) {
            foreach ($paquetes as $key => $paquete) {

                $color = generarColorAleatorio();

                $lista_paquetes[$key] = [
                    "paquete_id" => $paquete["paquete_id"],
                    "paquete_nombre" => $paquete["paquete_nombre"],
                    "paquete_clases" => $paquete["paquete_cantidad_clases"],
                    "paquete_precio" => $paquete["paquete_precio"],
                    "color" => $color
                ];
            }
        }

        $data["promociones"] = $lista_promociones;
        $data["cursos"] = $lista_cursos;
        $data["paquetes"] = $lista_paquetes;

        return parent::dashboard("promocion/dashboard", $data);
    }
}
