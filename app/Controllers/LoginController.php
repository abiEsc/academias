<?php

namespace App\Controllers;

use App\Models\auth\AuthModel;

class LoginController extends StructureController
{
    protected $input;
    protected $auth_model;
    function __construct()
    {
        $this->input = \Config\Services::request();
        $this->auth_model = new AuthModel();
    }

    function inicio_sesion()
    {
        unset($_SESSION["menu"]);
        $correo = $this->input->getPost("email");
        $password = $this->input->getPost("password");
        $password = hash("sha256", $password);

        $usuario = $this->auth_model->iniciar_sesion($correo, $password);
        $cliente = $this->auth_model->iniciar_sesion_cliente($correo, $password);

        

        if (isset($usuario)) {
            // Se guarda la informacion de usuario en sesion
            $data["usuario"] = $usuario;
            // Se recupera los menus disponibles para el usuario
            $data["menu"] = $this->auth_model->obtener_datos_menu($usuario["rol_id"], $usuario["usuario_id"]);

            $this->session->set($data);

            return redirect()->route("Inicio");
        } elseif (isset($cliente)) {
            if ($cliente["cliente_tipo"] == 1) {
                $data["usuario"] = $cliente;
                $data["usuario"]["rol_id"] = 5;
                $data["menu"] = $this->auth_model->obtener_datos_menu_cliente(5, $cliente["usuario_id"]);

                $this->session->set($data);

                return redirect()->route("Inicio");
            } else {
                $respuesta = [
                    "error" => 1,
                    "mensaje" => "Credenciales Inválidas, intente nuevamente"
                ];
                return parent::auth("auth/login_view", $respuesta);
            }
        } else {
            $respuesta = [
                "error" => 1,
                "mensaje" => json_encode($cliente)
            ];
            return parent::auth("auth/login_view", $respuesta);
        }
    }

    function logout()
    {
        $this->session->remove("usuario");
        return redirect()->route("Inicio-De-Sesion");
    }
}
