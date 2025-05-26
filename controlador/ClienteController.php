<?php
require_once '../modelo/Cliente.php';
require_once '../modelo/ClienteDTO.php';

class ClienteController {
    
    private $clienteModel;

    public function __construct() {
        $this->clienteModel = new Cliente();
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inputJSON = file_get_contents("php://input");
            $inputData = json_decode($inputJSON, true); 
            $nombre = $inputData['nombre'] ?? '';
            $email = $inputData['email'] ?? '';
            $telefono = $inputData['telefono'] ?? 0;
            $direccion = $inputData['direccion'] ?? 0;

            $cliente = new Cliente();
            $cliente->setNombre($nombre);
            $cliente->setEmail($email);
            $cliente->setTelefono($telefono);
            $cliente->setDireccion($direccion);

            if ($cliente->create()) {
                echo json_encode(["mensaje" => "Cliente creado correctamente"]);
            } else {
                echo json_encode(["error" => "Error al guardar el cliente"]);
            }
        } else {
            echo json_encode(["error" => "Método no permitido"]);
        }
    }
    public function get() {
        $clientes = $this->clienteModel->get();

        if (!$clientes || count($clientes) === 0) {
            echo json_encode(["error" => "No hay clientes disponibles"]);
            return;
        }

        $clientesDTO = array_map(function ($cliente) {
            return new ClienteDTO(
                $cliente['ID'],
                $cliente['NOMBRE'],
                $cliente['EMAIL'],
                $cliente['DIRECCION'],
            );
        }, $clientes);

        echo json_encode($clientesDTO);
    }

   public function getById($id) {
    $cliente = $this->clienteModel->getById($id);

    if ($cliente) {
        $clienteDTO = new ClienteDTO(
            $cliente['ID'],
            $cliente['NOMBRE'],
            $cliente['EMAIL'],
            $cliente['DIRECCION']
        );
        echo json_encode($clienteDTO);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Cliente no encontrado"]);
    }
}


    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $inputJSON = file_get_contents("php://input");
            $inputData = json_decode($inputJSON, true);

            $nombre = $inputData['nombre'] ?? '';
            $email = $inputData['email'] ?? '';
            $telefono = $inputData['telefono'] ?? '';
            $direccion = $inputData['direccion'] ?? '';

            $clienteExistente = $this->clienteModel->getById($id);

            if (!$clienteExistente) {
                http_response_code(404);
                echo json_encode(["error" => "Cliente no encontrado"]);
                return;
            }

            $cliente = new Cliente();
            $cliente->setId($id);
            $cliente->setNombre($nombre);
            $cliente->setEmail($email);
            $cliente->setTelefono($telefono);
            $cliente->setDireccion($direccion);

            if ($cliente->update()) {
                $dto = new ClienteDTO($id, $nombre, $email);
                echo json_encode($dto);
            } else {
                echo json_encode(["error" => "Error al actualizar el cliente"]);
            }
        } else {
            http_response_code(405);
            echo json_encode(["error" => "Método no permitido"]);
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $cliente = $this->clienteModel->getById($id);

            if (!$cliente) {
                http_response_code(404);
                echo json_encode(["error" => "Cliente no encontrado"]);
                return;
            }

            $clienteObj = new Cliente();
            $clienteObj->setId($id);

            if ($clienteObj->delete()) {
                echo json_encode(["mensaje" => "Cliente eliminado correctamente"]);
            } else {
                echo json_encode(["error" => "Error al eliminar el cliente"]);
            }
        } else {
            http_response_code(405);
            echo json_encode(["error" => "Método no permitido"]);
        }
    }



}
