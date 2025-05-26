<?php
require_once '../modelo/Vendedor.php';
require_once '../modelo/VendedorDTO.php';

class VendedorController {
    
    private $vendedorModel;

    public function __construct() {
        $this->vendedorModel = new Vendedor();
    }
    
    public function get() {
        $vendedores = $this->vendedorModel->get();

        if (!$vendedores || count($vendedores) === 0) {
            echo json_encode(["error" => "No hay vendedores disponibles"]);
            return;
        }

        $vendedoresDTO = array_map(function ($vendedor) {
            return new VendedorDTO(
                $vendedor['ID'],
                $vendedor['NOMBRE'],
                $vendedor['EMAIL'],
                $vendedor['TELEFONO']
            );
        }, $vendedores);

        echo json_encode($vendedoresDTO);
    }

    
    public function create() {
       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $inputJSON = file_get_contents("php://input");
        $inputData = json_decode($inputJSON, true); 
        $nombre = $inputData['nombre'] ?? '';
        $email = $inputData['email'] ?? '';
        $telefono = $inputData['telefono'] ?? 0;

        $vendedor = new Vendedor();
        $vendedor->setNombre($nombre);
        $vendedor->setEmail($email);
        $vendedor->setTelefono($telefono);

        if ($vendedor->guardar()) {
            echo json_encode(["mensaje" => "Vendedor creado correctamente"]);
        } else {
            echo json_encode(["error" => "Error al guardar el vendedor"]);
        }
        } else {
            echo json_encode(["error" => "Método no permitido"]);
        }
    }
}
