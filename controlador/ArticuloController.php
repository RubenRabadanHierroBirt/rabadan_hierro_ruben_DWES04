<?php
require_once '../modelo/Articulo.php';
require_once '../modelo/ArticuloDTO.php';

class ArticuloController {

    private $articuloModel;

    public function __construct() {
        $this->articuloModel = new Articulo();
    }
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inputJSON = file_get_contents("php://input");
            $inputData = json_decode($inputJSON, true);
            $nombre = $inputData['nombre'] ?? '';
            $descripcion = $inputData['descripcion'] ?? '';
            $precio = $inputData['precio'] ?? 0;
            $stock = $inputData['stock'] ?? 0;

            $articulo = new Articulo();
            $articulo->setNombre($nombre);
            $articulo->setDescripcion($descripcion);
            $articulo->setPrecio($precio);
            $articulo->setStock($stock);

            if ($articulo->create()) {
                echo json_encode(["mensaje" => "Artículo creado correctamente"]);
            } else {
                echo json_encode(["error" => "Error al guardar el artículo"]);
            }
        } else {
            echo json_encode(["error" => "Método no permitido"]);
        }
    }
    public function get(){
        $articulos = $this->articuloModel->get();

        if (!$articulos) {
            echo json_encode(["error" => "No hay artículos disponibles"]);
            return;
        }

        $articulosDTO = array_map(function ($articulo) {
            return new ArticuloDTO($articulo['ID'], $articulo['NOMBRE'], $articulo['DESCRIPCION'], $articulo['PRECIO'], $articulo['STOCK']);
        }, $articulos);

        echo json_encode($articulosDTO);
    }
    public function getById($id) {
        $articulo = $this->articuloModel->getById($id);

        if ($articulo) {
            echo json_encode($articulo);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Artículo no encontrado"]);
        }
    }
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $inputJSON = file_get_contents("php://input");
            $inputData = json_decode($inputJSON, true);

            $nombre = $inputData['nombre'] ?? '';
            $descripcion = $inputData['descripcion'] ?? '';
            $precio = $inputData['precio'] ?? 0;
            $stock = $inputData['stock'] ?? 0;

            $articulo = $this->articuloModel->getById($id);

            if (!$articulo) {
                http_response_code(404);
                echo json_encode(["error" => "Artículo no encontrado"]);
                return;
            }

            $articuloObj = new Articulo();
            //$articuloObj->setId($id);
            $articuloObj->setNombre($nombre);
            $articuloObj->setDescripcion($descripcion);
            $articuloObj->setPrecio($precio);
            $articuloObj->setStock($stock);

            if ($articuloObj->update($id)) {
                $dto = new ArticuloDTO($id, $nombre, $descripcion, $precio, $stock);
                echo json_encode($dto);
            } else {
                echo json_encode(["error" => "Error al actualizar el artículo"]);
            }
        } else {
            http_response_code(405);
            echo json_encode(["error" => "Método no permitido"]);
        }
    }


}
