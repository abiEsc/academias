<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\CursoModel;
use App\Models\SucursalModel;

class ClienteController extends StructureController
{

    function __construct()
    {
        $this->input = \Config\Services::request();
        $this->cliente_model = new ClienteModel();
        $this->curso_model = new CursoModel();
        $this->sucursal_model = new SucursalModel();
    }


    function index()
    {
        $clientes = $this->cliente_model->recuperar_cliente();
        $paquetes = $this->curso_model->recuperar_paquetes();
        $promociones = $this->curso_model->recuperar_promociones_activas();

        $paquetes = $paquetes ? $paquetes : [];
        $promociones = $promociones ? $promociones : [];

        $lista_cliente = [];

        if ($clientes) {
            foreach ($clientes as $key => $usuario) {
                $lista_cliente[$key] = [
                    "usuario_id" => $usuario["usuario_id"],
                    "nombre_completo" => $usuario["nombre_completo"],
                    "ci" => $usuario["usuario_ci"],
                    "direccion" => $usuario["usuario_direccion"],
                    "telefono" => $usuario["usuario_telefono"],
                    "email" => $usuario["usuario_email"],
                    "activo" => $usuario["usuario_activo"],
                    "activo_detalle" => $usuario["usuario_activo"] == 1 ? "Activo" : "Inactivo",
                    "tipo" => $usuario["cliente_tipo"],
                    "tipo_detalle" => $usuario["cliente_tipo"] == 1 ? "Regular" : "Temporal"
                ];
            }
        }

        $usuario = $this->session->get();
        $sucursales = $this->sucursal_model->recuperar_sucursales($usuario["usuario"]["usuario_id"]);
        $sucursales = MapSucursal($sucursales);

        $data["lista_cliente"] = $lista_cliente;
        $data["paquetes"] = $paquetes;
        $data["promociones"] = $promociones;
        $data["sucursales"] = $sucursales;
        
        return parent::dashboard("cliente/dashboard", $data);
    }

    function registrar_cliente()
    {
        $nombre = $this->input->getPost("nombre");
        $app = $this->input->getPost("app");
        $apm = $this->input->getPost("apm");
        $ci = $this->input->getPost("ci");
        $email = $this->input->getPost("email");
        $direccion = $this->input->getPost("direccion");
        $telefono = $this->input->getPost("telefono");
        $password = hash("sha256", $app . $ci);
        $cliente_tipo = $this->input->getPost("tipo");

        $accion_usuario = $this->session->get();
        $accion_fecha = date('Y-m-d H:i:s');

        $resultado = $this->cliente_model->registrar_cliente($nombre, $app, $apm, $ci, $direccion, $telefono, $email, $password, "1", $cliente_tipo, $accion_usuario["usuario"]["usuario_id"], $accion_fecha);

        if ($resultado) {
            $response = [
                "error" => 0,
                "mensaje" => "Se registró correctamente al cliente.",
                "icono" => "success"
            ];
        } else {
            $response = [
                "error" => 1,
                "mensaje" => "Ocurrió un error inesperado, intente nuevamente por favor.",
                "icono" => "error"
            ];
        }

        echo json_encode($response);
    }

    function recuperar_cliente()
    {
        $usuario_id = $this->input->getPost("usuario_id");
        $usuario = $this->cliente_model->recuperar_cliente_id($usuario_id);
        echo json_encode($usuario);
    }

    function editar_cliente()
    {
        $usuario_id = $this->input->getPost("usuario_id");
        $nombre = $this->input->getPost("nombre");
        $app = $this->input->getPost("app");
        $apm = $this->input->getPost("apm");
        $ci = $this->input->getPost("ci");
        $email = $this->input->getPost("email");
        $direccion = $this->input->getPost("direccion");
        $telefono = $this->input->getPost("telefono");
        $cliente_tipo = $this->input->getPost("tipo");

        $resultado = $this->cliente_model->editar_cliente($nombre, $app, $apm, $ci, $direccion, $telefono, $email, $cliente_tipo, $usuario_id);

        if ($resultado) {
            $response = [
                "error" => 0,
                "mensaje" => "Se editó correctamente al cliente.",
                "icono" => "success"
            ];
        } else {
            $response = [
                "error" => 1,
                "mensaje" => "Ocurrió un error inesperado, intente nuevamente por favor.",
                "icono" => "error"
            ];
        }

        echo json_encode($response);
    }

    function registrar_inscripcion()
    {
        $cliente_id = $this->input->getPost("usuario_id_ins");
        $paquete_id = $this->input->getPost("sel_paquete");
        $saldo = $this->input->getPost("saldo");
        $accion_usuario = $this->session->get();
        $accion_fecha = date('Y-m-d H:i:s');
        $tipo = $this->input->getPost("tipo");

        switch ($tipo) {
            case 'regulares':
                $categoria = 1;
                break;
            case "promocion":
                $paquete = $this->curso_model->validar_promocion($paquete_id);
                if ($paquete["data"]["promocion_activo"] == 0 || (strtotime(date('Y-m-d')) > strtotime($paquete["data"]["promocion_fin"]))) {
                    $response = [
                        "error" => 1,
                        "icono" => "info",
                        "mensaje" => "La promoción seleccionada no se encuentra disponible."
                    ];
                    echo json_encode($response);
                    exit();
                }
                $categoria = 2;
                break;
            default:
                $response = [
                    "error" => 1,
                    "mensaje" => "Debe seleccionar un paquete válido para la inscripción.",
                    "icono" => "info"
                ];
                echo json_encode($response);
                exit();
                break;
        }

        $inscripcion = $this->cliente_model->recuperar_inscripcion($paquete_id, $cliente_id, $categoria);

        if (!empty($inscripcion)) {
            $response = [
                "error" => 1,
                "mensaje" => "El cliente ya se encuentra inscrito a este paquete.",
                "icono" => "info"
            ];
        } else {
            $resultado = $this->cliente_model->registrar_inscripcion($paquete_id, $cliente_id, $saldo, $categoria, $accion_usuario["usuario"]["usuario_id"], $accion_fecha);

            $this->cliente_model->auditoria_inscripcion($cliente_id, $paquete_id, $categoria, $saldo, $accion_usuario["usuario"]["usuario_id"], $accion_fecha);

            if ($resultado) {
                $response = [
                    "error" => 0,
                    "mensaje" => "Se realizó la inscripción correctamente.",
                    "icono" => "success"
                ];
            } else {
                $response = [
                    "error" => 1,
                    "mensaje" => "Ocurrió un error inesperado, intente nuevamente por favor.",
                    "icono" => "error"
                ];
            }
        }



        echo json_encode($response);
    }

    function actualizar_saldo()
    {
        $usuario_id = $this->input->getPost("usuario_id_s");
        $curso_id = $this->input->getPost("curso_id_s");
        $deposito = $this->input->getPost("deposito");
        $categoria = $this->input->getPost("categoria");

        $accion_usuario = $this->session->get();
        $accion_fecha = date('Y-m-d H:i:s');

        $cliente = $this->cliente_model->validar_cliente($usuario_id);
        $curso = $this->curso_model->validar_paquete($curso_id);

        if ($cliente["error"] == 0 && $curso["error"] == 0) {

            $inscripcion = $this->cliente_model->recuperar_inscripcion($curso_id, $usuario_id, $categoria);

            $nuevo_saldo = $deposito + $inscripcion["inscripcion_saldo"];

            $resultado = $this->cliente_model->actualizar_saldo($nuevo_saldo, $accion_usuario["usuario"]["usuario_id"], $accion_fecha, $curso_id, $usuario_id, $categoria);

            $this->cliente_model->auditoria_inscripcion($usuario_id, $curso_id, $categoria, $deposito, $accion_usuario["usuario"]["usuario_id"], $accion_fecha);

            if ($resultado) {
                $response = [
                    "error" => 0,
                    "icono" => "success",
                    "mensaje" => "Se registró el pago correctamente."
                ];
            } else {
                $response = [
                    "error" => 1,
                    "icono" => "error",
                    "mensaje" => "Ocurrió un evento inesperado, por favor intente nuevamente."
                ];
            }
        } else {
            $response = [
                "error" => 1,
                "icono" => "error",
                "mensaje" => "Datos inválidos, intente nuevamente"
            ];
        }


        echo json_encode($response);
    }

    function detalle_sesion()
    {
        $usuario_id = $this->input->getPost("usuario_id");
        $curso_id = $this->input->getPost("curso_id");
        $categoria = $this->input->getPost("categoria");

        $cliente = $this->cliente_model->validar_cliente($usuario_id);
        if ($categoria == 1) {
            $curso = $this->curso_model->validar_paquete($curso_id);
        } else {
            $curso = $this->curso_model->validar_promocion($curso_id);
        }

        if ($cliente["error"] == 0 && $curso["error"] == 0) {
            $sesiones = $this->cliente_model->recuperar_sesiones($usuario_id, $curso_id, $categoria);

            $cantidad_clases = "";
            if ($categoria == 1) {
                $cantidad_clases = $curso["data"]["paquete_cantidad_clases"];
            } else {
                $cantidad_clases = $curso["data"]["promocion_clases"];
            }

            if (count($sesiones) < $cantidad_clases) {
                $resultado = [
                    "error" => 0,
                    "icono" => "success",
                    "mensaje" => "Dentro del limite de sesiones"
                ];
            } else {
                $resultado = [
                    "error" => 1,
                    "icono" => "info",
                    "mensaje" => "El cliente ya completo las sesiones correspondientes al paquete seleccionado."
                ];
            }
        } else {
            $resultado = [
                "error" => 1,
                "icono" => "error",
                "mensaje" => "Datos incorrectos, intente nuevamente."
            ];
        }

        echo json_encode($resultado);
    }

    function registrar_sesion()
    {
        $usuario_id = $this->input->getPost("usuario_id");
        $curso_id = $this->input->getPost("curso_id");
        $categoria = $this->input->getPost("categoria");

        $cliente = $this->cliente_model->validar_cliente($usuario_id);

        if ($categoria == 1) {
            $curso = $this->curso_model->validar_paquete($curso_id);
        } else {
            $curso = $this->curso_model->validar_promocion($curso_id);
        }

        if ($cliente["error"] == 0 && $curso["error"] == 0) {

            $accion_usuario = $this->session->get();
            $accion_fecha = date('Y-m-d H:i:s');

            $sesiones = $this->cliente_model->recuperar_sesiones($usuario_id, $curso_id, $categoria);

            $cantidad_clases = "";
            if ($categoria == 1) {
                $cantidad_clases = $curso["data"]["paquete_cantidad_clases"];
            } else {
                $cantidad_clases = $curso["data"]["promocion_clases"];
            }

            if (count($sesiones) >= $cantidad_clases) {
                $respuesta = $this->cliente_model->completar_sesiones($usuario_id, $curso_id, $categoria);
            }

            $respuesta = $this->cliente_model->registrar_sesion($usuario_id, $curso_id, $categoria, $accion_fecha, $accion_usuario["usuario"]["usuario_id"]);


            if ($respuesta) {
                $response = [
                    "error" => 0,
                    "mensaje" => "Sesión registrada correctamente.",
                    "icono" => "success"
                ];
            } else {
                $response = [
                    "error" => 0,
                    "mensaje" => "Ocurrio un evento inesperado, intente nuevamente por favor.",
                    "icono" => "error"
                ];
            }
        } else {

            $response = [
                "error" => 0,
                "icono" => "info",
                "mensaje" => "Datos incorrectos, intente nuevamente."
            ];
        }

        echo json_encode($response);
    }

    function inactivar_cliente()
    {

        $response = [];

        $cliente_id = $this->input->getPost("usuario_id");

        $cliente = $this->cliente_model->validar_cliente($cliente_id);

        if ($cliente["error"] == 1) {
            $response = [
                "error" => $cliente["error"],
                "mensaje" => $cliente["data"],
                "icono" => "error"
            ];
        } else {
            $this->cliente_model->inactivar_cliente($cliente_id);
            $response = [
                "error" => 0,
                "icono" => "info",
                "mensaje" => "Se inactivó la cuenta del cliente seleccionado correctamente."
            ];
        }

        echo json_encode($response);
    }

    function eliminar_cliente()
    {

        $response = [];

        $usuario_id = $this->input->getPost("usuario_id");

        $cliente = $this->cliente_model->validar_cliente($usuario_id);

        if ($cliente["error"] == 1) {
            $response = [
                "error" => $cliente["error"],
                "mensaje" => $cliente["data"],
                "icono" => "error"
            ];
        } else {
            $this->cliente_model->eliminar_cliente($usuario_id);
            $response = [
                "error" => 0,
                "icono" => "success",
                "mensaje" => "Se elimino definitivamente la cuenta del cliente seleccionado."
            ];
        }

        echo json_encode($response);
    }

    function reactivar_cliente()
    {

        $response = [];

        $usuario_id = $this->input->getPost("usuario_id");

        $cliente = $this->cliente_model->validar_cliente($usuario_id);

        if ($cliente["error"] == 1) {
            $response = [
                "error" => $cliente["error"],
                "mensaje" => $cliente["data"],
                "icono" => "error"
            ];
        } else {
            $this->cliente_model->reactivar_cliente($usuario_id);
            $response = [
                "error" => 0,
                "icono" => "success",
                "mensaje" => "Se reactivó correctamente la cuenta del cliente seleccionado."
            ];
        }

        echo json_encode($response);
    }
}
