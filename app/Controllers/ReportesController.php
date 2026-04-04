<?php

namespace App\Controllers;

use App\Models\ReporteModel;
use App\Models\ClienteModel;
use App\Models\PersonalModel;
use App\Models\CursoModel;
use App\Models\SucursalModel;

class ReportesController extends StructureController
{

    function __construct()
    {
        $this->input = \Config\Services::request();
        $this->reporte_model = new ReporteModel();
        $this->cliente_model = new ClienteModel();
        $this->personal_model = new PersonalModel();
        $this->curso_model = new CursoModel();
        $this->sucursal_model = new SucursalModel();
    }


    function index()
    {
        $usuario = $this->session->get();
        $sucursales = $this->sucursal_model->recuperar_sucursales($usuario["usuario"]["usuario_id"]);
        $lista_sucursales = $this->sucursal_model->listar_sucursales_id($usuario["usuario"]["usuario_id"]);


        $lista_clientes = $this->cliente_model->recuperar_cliente();
        $instructores = $this->personal_model->recuperar_personal("4");
        $lista_instructores = [];

        if (count($instructores) > 0) {
            foreach ($instructores as $key => $usuario) {

                $sucursales_user = $this->sucursal_model->listar_sucursales_id($usuario["usuario_id"]);

                if (verificarSucursales($lista_sucursales, $sucursales_user)) {
                    $lista_instructores[$key] = [
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

        $paquetes = $this->curso_model->recuperar_paquetes();
        $promociones = $this->curso_model->recuperar_promociones();



        $sucursales = MapSucursal($sucursales);


        $data["lista_clientes"] = $lista_clientes;
        $data["instructores"] = $lista_instructores;
        $data["paquetes"] = $paquetes;
        $data["promociones"] = $promociones;
        $data["sucursales"] = $sucursales;

        return parent::dashboard("reportes/dashboard", $data);
    }

    function generar_reporte()
    {
        $tipo_reporte = $this->input->getPost("tipo_reporte");
        $sucursal = $this->input->getPost("sucursal");

        if ($sucursal == "-100") {
            $usuario = $this->session->get();
            $sucursal = $this->sucursal_model->listar_sucursales_id($usuario["usuario"]["usuario_id"]);
        }

        switch ($tipo_reporte) {
            case 1:
                $fecha_ini = $this->input->getPost("fecha_ini");
                $fecha_fin = $this->input->getPost("fecha_fin");
                $reporte = $this->reporte_model->reporte_ventas($fecha_ini[0], $fecha_fin[0], $sucursal);
                $data_reporte = [];
                if (count($reporte) > 0) {
                    foreach ($reporte as $key => $info) {
                        $data_reporte[$key] = [
                            "producto" => $info["articulo_nombre"],
                            "cantidad" => $info["venta_cantidad"],
                            "precio" => $info["articulo_precio"],
                            "total" => $info["total"],
                            "usuario" => $info["usuario_venta"],
                            "fecha" => $info["accion_fecha"]
                        ];
                    }
                }
                $vista = "reportes/reporte_venta";
                break;
            case 2:
                $fecha_ini = $this->input->getPost("fecha_ini");
                $fecha_fin = $this->input->getPost("fecha_fin");
                $cliente_id = $this->input->getPost("cliente_id");
                $tipo_reporte_cliente = $this->input->getPost("tipo_reporte_cliente");
                $data_reporte = $this->reporte_model->reporte_clientes($tipo_reporte_cliente, $fecha_ini[1], $fecha_fin[1], $cliente_id);

                switch ($tipo_reporte_cliente) {
                    case '1':
                        $vista = "reportes/reporte_cliente_asistencia";
                        break;
                    case "2":
                        $vista = "reportes/reporte_cliente_pago";
                        break;
                    default:
                        $vista = "reportes/dashboard";
                        break;
                }
                break;
            case 3:
                $fecha_ini = $this->input->getPost("fecha_ini");
                $fecha_fin = $this->input->getPost("fecha_fin");
                $tipo_reporte_promo = $this->input->getPost("tipo_reporte_promo");

                $promo = $this->input->getPost("sel_promo");

                $data_reporte = $this->reporte_model->reporte_promocion($tipo_reporte_promo, $fecha_ini[2], $fecha_fin[2], $promo);

                switch ($tipo_reporte_promo) {
                    case '1':
                        $vista = "reportes/reporte_promo_lista";
                        break;
                    case "2":
                        $vista = "reportes/reporte_promo_inscritos";
                        break;
                    default:
                        $vista = "reportes/dashboard";
                        break;
                }

                break;
            case 4:
                $instructor = $this->input->getPost("instructor");
                $data_reporte = $this->reporte_model->reporte_instructor($instructor);
                $vista = "reportes/reporte_instructor";

                foreach ($data_reporte as $key => $item) {
                    $dias = explode(",", $item["curso_dias"]);
                    $semana = "";


                    foreach ($dias as $dia) {
                        if ($dia > 0) {
                            $semana .= dias_numerico_literal($dia) . ", ";
                        } else {
                            $semana = "Dato Incorrecto";
                        }
                    }

                    $data_reporte[$key]["dias"] = $semana;
                }
                break;
            case 5:
                $paquete = $this->input->getPost("sel_paquete");
                $data_reporte = $this->reporte_model->reporte_inscritos($paquete, $sucursal);
                $vista = "reportes/reporte_paquete";
                break;
            default:
                $vista = "reportes/dashboard";
                break;
        }

        $data["reporte"] = $data_reporte;

        return view($vista, $data);
    }
}
