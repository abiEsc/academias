<?php

namespace App\Controllers;

use App\Models\SucursalModel;

class StructureController extends BaseController
{

    protected $base_sucursal;

    public function __construct()
    {
        $this->base_sucursal = new SucursalModel();
    }

    protected function dashboard($view, $data = [])
    {
        $this->ActualizarPromociones();
        if (!isset($_SESSION["usuario"])) {
            $this->session->remove("usuario");
            return redirect()->route("Inicio-De-Sesion");
        } else {
            return view("shared/head") . view("shared/menu") . view($view, $data) . view("shared/footer");
        }
    }

    protected function auth($view, $data = [])
    {
        $this->ActualizarPromociones();
        return view("shared/head") . view($view, $data);
    }

    private function ActualizarPromociones()
    {
        $fecha_actual = date('Y-m-d');
        $promociones = $this->curso_model->recuperar_promociones();
        if (!empty($promociones)) {
            foreach ($promociones as $promo) {
                if (strtotime($fecha_actual) > strtotime($promo["promocion_fin"])) {
                    $this->curso_model->cambiar_estado($promo["promocion_id"], 0);
                }
            }
        }
    }
}
