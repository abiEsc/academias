<?php

namespace App\Controllers;

use App\Models\PersonalModel;
use App\Models\CursoModel;

class CursosController extends StructureController
{

    function __construct()
    {
        parent::__construct();
        $this->input = \Config\Services::request();
        $this->personal_model = new PersonalModel();
        $this->curso_model = new CursoModel();
    }


    function index()
    {
        $instructores = $this->personal_model->recuperar_personal("4");
        $paquetes = $this->curso_model->recuperar_paquetes();
        $cursos = $this->curso_model->recuperar_cursos();
        $promociones = $this->curso_model->recuperar_promociones();

        $paquetes = $paquetes ? $paquetes : [];

        $lista_cursos = [];

        if (count($cursos) > 0) {
            foreach ($cursos as $key => $curso) {

                $dias = explode(",", $curso["curso_dias"]);
                $semana = "";


                foreach ($dias as $dia) {
                    if ($dia > 0) {
                        $semana .= dias_numerico_literal($dia) . ", ";
                    } else {
                        $semana = "Dato Incorrecto";
                    }
                }


                $lista_cursos[$key] = [
                    "curso_id" => $curso["curso_id"],
                    "curso_nombre" => $curso["curso_nombre"],
                    "instructor_id" => $curso["instructor_id"],
                    "nombre_instructor" => $curso["nombre_instructor"],
                    "horario_ini" => $curso["horario_ini"],
                    "horario_fin" => $curso["horario_fin"],
                    "dias" => nl2br($semana)
                ];
            }
        }

        $lista_promociones = [];
        if (!empty($promociones)) {
            foreach ($promociones as $promo) {
                $lista_promociones[] = [
                    "promocion_id" => $promo["promocion_id"],
                    "promocion_nombre" => $promo["promocion_nombre"],
                    "promocion_clases" => $promo["promocion_clases"],
                    "promocion_precio" => $promo["promocion_precio"],
                    "promocion_inicio" => getFormatoFechaD_M_Y($promo["promocion_inicio"]),
                    "promocion_fin" => getFormatoFechaD_M_Y($promo["promocion_fin"]),
                    "promocion_activo" => $promo["promocion_activo"],
                ];
            }
        }



        $data["instructores"] = $instructores;
        $data["paquetes"] = $paquetes;
        $data["cursos"] = $lista_cursos;
        $data["promociones"] = $lista_promociones;

        return parent::dashboard("cursos/dashboard", $data);
    }

    function registro_curso()
    {
        $curso = $this->input->getPost("curso");

        $instructor_id = $this->input->getPost("instructor");

        $horario_ini = $this->input->getPost("inicio");
        $horario_fin = $this->input->getPost("fin");

        $dias = $this->input->getPost("semana");
        $dias = implode(",", $dias);

        $accion_usuario = $this->session->get();
        $accion_fecha = date('Y-m-d H:i:s');

        if (isset($_POST["curso_id"]) && $_POST["curso_id"] != "") {
            $curso_id = $this->input->getPost("curso_id");
            $registro = $this->curso_model->editar_curso($curso, $curso_id, $instructor_id, $horario_ini, $horario_fin, $dias, $accion_usuario["usuario"]["usuario_id"], $accion_fecha);
            $mensaje = "El ritmo se editó correctamente";
        } else {
            $registro = $this->curso_model->registrar_curso($curso, $instructor_id, $horario_ini, $horario_fin, $dias, $accion_usuario["usuario"]["usuario_id"], $accion_fecha);
            $mensaje = "Ritmo registrado correctamente";
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

    function recuperar_curso()
    {
        $curso_id = $this->input->getPost("curso_id");
        $curso = $this->curso_model->validar_curso($curso_id);
        echo json_encode($curso);
    }

    function eliminar_curso()
    {
        $curso_id = $this->input->getPost("curso_id");
        $this->curso_model->eliminar_curso($curso_id);
        $response = [
            "error" => 0,
            "icono" => "success",
            "mensaje" => "Se elimino definitivamente el ritmo seleccionado."
        ];
        echo json_encode($response);
    }

    function registro_paquete()
    {

        $paquete = $this->input->getPost("paquete");
        $cantidad_clases = $this->input->getPost("cantidad_clases");
        $paquete_precio = $this->input->getPost("paquete_precio");

        $accion_usuario = $this->session->get();
        $accion_fecha = date('Y-m-d H:i:s');

        if (isset($_POST["paquete_id"]) && $_POST["paquete_id"] != "") {
            $paquete_id = $this->input->getPost("paquete_id");
            $registro = $this->curso_model->editar_paquete($paquete_id, $paquete, $cantidad_clases, $paquete_precio, $accion_usuario["usuario"]["usuario_id"], $accion_fecha);
            $mensaje = "El paquete se editó correctamente";
        } else {
            $registro = $this->curso_model->registrar_paquete($paquete, $cantidad_clases, $paquete_precio, $accion_usuario["usuario"]["usuario_id"], $accion_fecha);
            $mensaje = "El paquete se registró correctamente";
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

    function recuperar_paquete()
    {
        $paquete_id = $this->input->getPost("paquete_id");
        $tipo = $this->input->getPost("tipo");

        switch ($tipo) {
            case "regulares":
                $paquete = $this->curso_model->validar_paquete($paquete_id);
                break;
            case "promocion":
                $paquete = $this->curso_model->validar_promocion($paquete_id);
                if($paquete["data"]["promocion_activo"] == 0){
                    $paquete = [
                        "error" => 1,
                        "data" => "La promoción seleccionada no se encuentra disponible."
                    ];
                }
                break;
            default:
                $paquete = [
                    "error" => 1,
                    "data" => "Seleccione una opción válida."
                ];
                break;
        }

        echo json_encode($paquete);
    }

    function eliminar_paquete()
    {
        $paquete_id = $this->input->getPost("paquete_id");

        $inscritos = $this->curso_model->verificar_inscritos_paquete($paquete_id);

        if (count($inscritos) > 0) {
            $response = [
                "error" => 1,
                "icono" => "error",
                "mensaje" => "Existen alumnos inscritos, no se puede eliminar el paquete seleccionado."
            ];
        } else {
            $this->curso_model->eliminar_paquete($paquete_id);
            $response = [
                "error" => 0,
                "icono" => "success",
                "mensaje" => "Se elimino definitivamente el paquete seleccionado."
            ];
        }

        echo json_encode($response);
    }

    function registrar_promocion()
    {
        $promocion = $this->input->getPost("promocion");
        $cantidad_clases = $this->input->getPost("cantidad_clases");
        $promocion_precio = $this->input->getPost("promocion_precio");
        $promocion_ini = $this->input->getPost("promo_ini");
        $promocion_fin = $this->input->getPost("promo_fin");

        $accion_usuario = $this->session->get();
        $accion_fecha = date('Y-m-d H:i:s');

        if (isset($_POST["promocion_id"]) && $_POST["promocion_id"] != "") {
            $promocion_id = $this->input->getPost("promocion_id");
            $registro = $this->curso_model->editar_promocion($promocion_id, $promocion, $cantidad_clases, $promocion_precio, $promocion_ini, $promocion_fin, $accion_usuario["usuario"]["usuario_id"], $accion_fecha);
            $mensaje = "La promoción se editó correctamente";
        } else {
            $registro = $this->curso_model->registrar_promocion($promocion, $cantidad_clases, $promocion_precio, $promocion_ini, $promocion_fin, $accion_usuario["usuario"]["usuario_id"], $accion_fecha);
            $mensaje = "La promoción se registró correctamente";
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

    function recuperar_promocion()
    {
        $promocion_id = $this->input->getPost("promocion_id");
        $promocion = $this->curso_model->validar_promocion($promocion_id);
        echo json_encode($promocion);
    }


    function editar_promocion()
    {
        $promocion_id = $this->input->getPost("promocion_id");
        $estado = $this->input->getPost("estado");
        $promocion = $this->curso_model->validar_promocion($promocion_id);

        $result = [
            "error" => 0,
            "data" => ""
        ];

        if ($promocion["error"] == 1) {
            $result = [
                "error" => 1,
                "data" => $promocion["data"]
            ];
        } else {
            if ($estado == 1) {
                $icono = "success";
                $mensaje = "Se reactivó la promoción correctamente.";
            } else {
                $icono = "info";
                $mensaje = "Se inactivó la promoción correctamente.";
            }
            $result = [
                "error" => 0,
                "icono" => $icono,
                "mensaje" => $mensaje
            ];
            $this->curso_model->cambiar_estado($promocion_id, $estado);
        }

        echo json_encode($result);
    }
}
