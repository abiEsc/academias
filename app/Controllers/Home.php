<?php

namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\ClienteModel;
use App\Models\CursoModel;
use App\Models\GeneralModel;

class Home extends StructureController
{
    protected $productos_model;
    protected $cliente_model;
    protected $curso_model;
    protected $general_model;
    function __construct()
    {
        /*parent::__construct();
        $this->input = \Config\Services::request();
        $this->productos_model = new ProductoModel();
        $this->cliente_model = new ClienteModel();
        $this->curso_model = new CursoModel();
        $this->general_model = new GeneralModel();*/
        parent::__construct();
        #$this->input = \Config\Services::request();cambiado por causa de C3 a C4
        #$this->request = \Config\Services::request();
        $this->productos_model = new ProductoModel();
        $this->cliente_model = new ClienteModel();
        $this->curso_model = new CursoModel();
        $this->general_model = new GeneralModel();
    }

    public function index()
    {
        $lista_productos = $this->productos_model->recuperar_productos("1");
        $lista_productos = $lista_productos ? $lista_productos : [];
        $lista_galeria = $this->general_model->listar_galeria();
        $lista_galeria = is_array($lista_galeria) ? $lista_galeria : [];
        $cursos = $this->curso_model->recuperar_cursos();

        $galeria = [];

        if (count($lista_galeria) > 0) {

            foreach ($lista_galeria as $key => $item) {
                if ((file_exists("writable/uploads/" . $item["galeria_url"]))) {
                    $info = pathinfo(base_url("writable/uploads/" . $item["galeria_url"]));

                    switch ($info["extension"]) {
                        case "mp4":
                            $tipo = "1";
                            break;
                        default:
                            $tipo = "2";
                            break;
                    }

                    $galeria[$key] = [
                        "galeria_id" => $item["galeria_id"],
                        "url" => base_url("writable/uploads/" . $item["galeria_url"]),
                        "tipo" => $tipo
                    ];
                }
            }
        }

        $data["lista_galeria"] = $galeria;
        $data["lista_productos"] = $lista_productos;

        $clientes = $this->cliente_model->recuperar_cliente();

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
                    "activo" => $usuario["usuario_activo"]
                ];
            }
        }

        $data["lista_cliente"] = $lista_cliente;

        $data_session = $this->session->get();

        if (!isset($data_session["usuario"])) {
            return parent::auth("auth/login_view");
        } else {

            foreach ($cursos as $key => $curso) {
                $fechas = explode(",", $curso["curso_dias"]);
                $cursos[$key]["curso_dias"] = crear_rango($fechas);
            }

            $data["cursos"] = $cursos;




            return parent::dashboard("inicio/inicio_view", $data);
        }
    }

    public function login()
    {
        return parent::auth("auth/login_view");
    }

    public function detalle_usuario()
    {
        $usuario_id = $this->input->getPost("usuario_id");

        $cliente = $this->cliente_model->validar_cliente($usuario_id);

        if ($cliente["error"] == 0) {
            $usuario = $this->session->get();
            $lista_sucursales = $this->base_sucursal->listar_sucursales_id($usuario["usuario"]["usuario_id"]);

            $cursos = $this->cliente_model->recuperar_cursos($cliente["data"]["usuario_id"], $lista_sucursales);
            $promociones = $this->cliente_model->recuperar_cursos_promo($cliente["data"]["usuario_id"], $lista_sucursales);

            $cursos = array_merge($cursos, $promociones);

            foreach ($cursos as $key => $curso) {
                $sesion = $this->cliente_model->recuperar_sesiones($cliente["data"]["usuario_id"], $curso["paquete_id"], $curso["categoria"]);
                $cursos[$key]["sesiones"] = count($sesion);
            }

            $response = [
                "error" => 0,
                "cliente" => $cliente["data"],
                "cursos" => $cursos
            ];
        } else {
            $response = $cliente;
        }


        echo json_encode($response);
    }

    public function detalle_inscripcion()
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
            $inscripcion = $this->cliente_model->recuperar_inscripcion($curso_id, $usuario_id, $categoria);

            $response = [
                "error" => 0,
                "data" => $inscripcion
            ];
        } else {
            $response = [
                "error" => 1,
                "data" => "Datos inválidos, intente nuevamente"
            ];
        }


        echo json_encode($response);
    }

    function guardar_media()
    {

        $file = $this->request->getFile('image');

        if ($file->isValid() && !$file->hasMoved()) {
            $nombreOriginal = $file->getName();
            $ruta_destino = WRITEPATH . 'uploads';
            if ($file->move($ruta_destino, $nombreOriginal)) {
                $accion_usuario = $this->session->get();
                $accion_fecha = date('Y-m-d H:i:s');

                $this->general_model->guardar_media($nombreOriginal, $accion_usuario["usuario"]["usuario_id"], $accion_fecha);

                $response = [
                    "error" => 0,
                    "data" => "Guardado Correctamente",
                    "icono" => "success"
                ];
            } else {
                $response = [
                    "error" => 1,
                    "icono" => "error",
                    "data" => "No se pudo guardar, intente nuevamente"
                ];
            }
        }

        echo json_encode($response);
    }

    function remover_media()
    {

        $galeria_id = $this->input->getPost('galeria_id');

        $remover = $this->general_model->remover_galeria($galeria_id);

        if ($remover) {
            $response = [
                "error" => 0,
                "data" => "Se removió el ítem Correctamente",
                "icono" => "success"
            ];
        } else {
            $response = [
                "error" => 1,
                "data" => "No se pudo eliminar el elemento, intente nuevamente.",
                "icono" => "error"
            ];
        }

        echo json_encode($response);
    }
}
