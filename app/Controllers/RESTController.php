<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\IncomingRequest;

use App\Models\PersonalModel;

class RESTController extends ResourceController
{
    use ResponseTrait;

    function __construct()
    {
        $this->input = \Config\Services::request();
        $this->personal_model = new PersonalModel();
    }

    public function receiveRequest()
    {
        // Configuración de CORS (permite el acceso desde cualquier origen)
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With');

        $data = $this->request->getBody();
        $data = json_decode($data, true);
        $id = $data["id"];

        $instructores = $this->personal_model->recuperar_personal($id);

        $data = [
            'status' => 'success',
            'message' => $instructores,
        ];

        return $this->response->setJSON($data);
    }
}
