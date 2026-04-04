<?php

namespace App\Controllers;

use App\Models\PersonalModel;
use App\Models\auth\AuthModel;
use App\Models\SucursalModel;

class PersonalController extends StructureController
{

    function __construct()
    {
        $this->input = \Config\Services::request();
        $this->personal_model = new PersonalModel();
        $this->auth_model = new AuthModel();
        $this->sucursal_model = new SucursalModel();
    }


    function index()
    {
        $usuario = $this->session->get();
        $lista_sucursales = $this->sucursal_model->listar_sucursales_id($usuario["usuario"]["usuario_id"]);

        $personal = $this->personal_model->recuperar_personal();

        $lista_personal = [];
        $instructores = [];

        if (count($personal) > 0) {
            foreach ($personal as $key => $usuario) {

                $sucursales = $this->sucursal_model->listar_sucursales_id($usuario["usuario_id"]);

                if (verificarSucursales($lista_sucursales, $sucursales)) {
                    $lista_personal[$key] = [
                        "usuario_id" => $usuario["usuario_id"],
                        "rol_id" => $usuario["rol_id"],
                        "rol_nombre" => $usuario["rol_nombre"],
                        "nombre_completo" => $usuario["nombre_completo"],
                        "ci" => $usuario["usuario_ci"],
                        "direccion" => $usuario["usuario_direccion"],
                        "telefono" => $usuario["usuario_telefono"],
                        "email" => $usuario["usuario_email"],
                        "activo" => $usuario["usuario_activo"]
                    ];

                    if ($usuario["rol_id"] == "4") {
                        $instructores[$key] = [
                            "usuario_id" => $usuario["usuario_id"],
                            "rol_id" => $usuario["rol_id"],
                            "rol_nombre" => $usuario["rol_nombre"],
                            "nombre_completo" => $usuario["nombre_completo"],
                            "ci" => $usuario["usuario_ci"],
                            "direccion" => $usuario["usuario_direccion"],
                            "telefono" => $usuario["usuario_telefono"],
                            "email" => $usuario["usuario_email"],
                            "activo" => $usuario["usuario_activo"]
                        ];
                    }
                }
            }
        }

        $sucursales = $this->sucursal_model->ListarSucursales("", 1);
        $sucursales = MapSucursal($sucursales);

        $data["lista_personal"] = $lista_personal;
        $data["instructores"] = $instructores;
        $data["sucursales"] = $sucursales;

        return parent::dashboard("personal/dashboard", $data);
    }

    function registrar_personal()
    {
        $nombre = $this->input->getPost("nombre");
        $app = $this->input->getPost("app");
        $apm = $this->input->getPost("apm");
        $ci = $this->input->getPost("ci");
        $email = $this->input->getPost("email");
        $direccion = $this->input->getPost("direccion");
        $telefono = $this->input->getPost("telefono");
        $rol = $this->input->getPost("rol");
        $password = hash("sha256", $app . $ci);

        $sucursales = $this->input->getPost("sucursal_usuario");

        if (count($sucursales) <= 0) {
            $this->session->setFlashdata("notificacion", ["tipo" => "error", "mensaje" => "Debe seleccionar al menos una sucursal para asignar al usuario."]);

            return redirect()->route("Gestion-Personal");
        }

        $accion_usuario = $this->session->get();
        $accion_fecha = date('Y-m-d H:i:s');

        $usuario_id = $this->auth_model->registrar_usuario($rol, $nombre, $app, $apm, $ci, $direccion, $telefono, $email, $password);

        foreach ($sucursales as $value) {
            $this->sucursal_model->asignar_sucursales($usuario_id, $value, $accion_usuario["usuario"]["usuario_id"], $accion_fecha);
        }

        $this->session->setFlashdata("notificacion", ["tipo" => "success", "mensaje" => "Se registró correctamente al usuario"]);

        return redirect()->route("Gestion-Personal");
    }

    function recuperar_personal()
    {
        $usuario_id = $this->input->getPost("usuario_id");
        $usuario = $this->personal_model->recuperar_personal_id($usuario_id);
        $sucursales_asignadas = $this->sucursal_model->recuperar_sucursales($usuario_id);

        $result = [
            "usuario" => $usuario,
            "sucursales" => $sucursales_asignadas
        ];

        echo json_encode($result);
    }

    function detalle_cursos()
    {
        $usuario_id = $this->input->getPost("usuario_id");
        $usuario = $this->personal_model->validar_personal($usuario_id);
        if ($usuario["error"] == 0) {
            $cursos = $this->personal_model->obtener_cursos($usuario_id);
            $lista_cursos = [];
            foreach ($cursos as $curso) {

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

                $lista_cursos[] = [
                    "curso_id" => $curso["curso_id"],
                    "curso_nombre" => $curso["curso_nombre"],
                    "horario_ini" => $curso["horario_ini"],
                    "horario_fin" => $curso["horario_fin"],
                    "dias" => $semana
                ];
            }
            $response = [
                "error" => 0,
                "data" => $lista_cursos
            ];
        } else {
            $response = $usuario;
        }
        echo json_encode($response);
    }

    function editar_personal()
    {
        $usuario_id = $this->input->getPost("usuario_id");
        $nombre = $this->input->getPost("nombre");
        $app = $this->input->getPost("app");
        $apm = $this->input->getPost("apm");
        $ci = $this->input->getPost("ci");
        $email = $this->input->getPost("email");
        $direccion = $this->input->getPost("direccion");
        $telefono = $this->input->getPost("telefono");
        $rol = $this->input->getPost("rol");

        $sucursales = $this->input->getPost("sucursal_usuario");

        if (count($sucursales) <= 0) {
            $this->session->setFlashdata("notificacion", ["tipo" => "error", "mensaje" => "Debe seleccionar al menos una sucursal para asignar al usuario."]);

            return redirect()->route("Gestion-Personal");
        }

        $this->personal_model->editar_personal($rol, $nombre, $app, $apm, $ci, $direccion, $telefono, $email, $usuario_id);

        $accion_usuario = $this->session->get();
        $accion_fecha = date('Y-m-d H:i:s');

        $this->sucursal_model->remover_sucursales($usuario_id);
        foreach ($sucursales as $value) {
            $this->sucursal_model->asignar_sucursales($usuario_id, $value, $accion_usuario["usuario"]["usuario_id"], $accion_fecha);
        }

        $this->session->setFlashdata("notificacion", ["tipo" => "success", "mensaje" => "Se editó la información del usuario."]);

        return redirect()->route("Gestion-Personal");
    }

    function inactivar_personal()
    {

        $response = [];

        $personal_id = $this->input->getPost("personal_id");

        $personal = $this->personal_model->validar_personal($personal_id);

        if ($personal["error"] == 1) {
            $response = [
                "error" => $personal["error"],
                "mensaje" => $personal["data"],
                "icono" => "error"
            ];
        } else {
            $this->personal_model->inactivar_personal($personal_id);
            $response = [
                "error" => 0,
                "icono" => "info",
                "mensaje" => "Se inactivó la cuenta del personal seleccionado correctamente."
            ];
        }

        echo json_encode($response);
    }

    function eliminar_personal()
    {

        $response = [];

        $personal_id = $this->input->getPost("personal_id");

        $personal = $this->personal_model->validar_personal($personal_id);

        if ($personal["error"] == 1) {
            $response = [
                "error" => $personal["error"],
                "mensaje" => $personal["data"],
                "icono" => "error"
            ];
        } else {
            $this->personal_model->eliminar_personal($personal_id);
            $response = [
                "error" => 0,
                "icono" => "success",
                "mensaje" => "Se elimino definitivamente la cuenta del personal seleccionado."
            ];
        }

        echo json_encode($response);
    }

    function reactivar_personal()
    {

        $response = [];

        $personal_id = $this->input->getPost("personal_id");

        $personal = $this->personal_model->validar_personal($personal_id);

        if ($personal["error"] == 1) {
            $response = [
                "error" => $personal["error"],
                "mensaje" => $personal["data"],
                "icono" => "error"
            ];
        } else {
            $this->personal_model->reactivar_personal($personal_id);
            $response = [
                "error" => 0,
                "icono" => "success",
                "mensaje" => "Se reactivó correctamente la cuenta del personal seleccionado."
            ];
        }

        echo json_encode($response);
    }
}
