<?php
require_once '../modelo/LineaPedido.php';
require_once '../modelo/Articulo.php';

class LineaPedidoController {
    private $modelo;

    public function __construct() {
        $this->modelo = new LineaPedido();
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents("php://input"), true);

            $pedidoId = $input['pedido_id'] ?? null;
            $articulos = $input['articulos'] ?? [];

            if (!$pedidoId || empty($articulos)) {
                http_response_code(400);
                echo json_encode(["error" => "Datos incompletos"]);
                return;
            }

            $articuloModel = new Articulo();

            foreach ($articulos as $item) {
                $articulo = $articuloModel->getById($item['articulo_id']);
                if (!$articulo || $articulo['STOCK'] < $item['cantidad']) {
                    http_response_code(400);
                    echo json_encode(["error" => "Artículo inválido o sin stock"]);
                    return;
                }

                $this->modelo->crear($pedidoId, $item['articulo_id'], $item['cantidad']);
                $articuloModel->updateStock($item['articulo_id'], -$item['cantidad']);
            }

            echo json_encode(["message" => "Líneas de pedido añadidas correctamente"]);
        }
    }

    public function update() {
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $input = json_decode(file_get_contents("php://input"), true);

        $pedidoId = $input['pedido_id'] ?? null;
        $articuloId = $input['articulo_id'] ?? null;
        $nuevaCantidad = $input['cantidad'] ?? null;

        if (!$pedidoId || !$articuloId || $nuevaCantidad === null) {
            http_response_code(400);
            echo json_encode(["error" => "Datos incompletos para actualizar"]);
            return;
        }

        $lineas = $this->modelo->getPorPedido($pedidoId);
        $lineaActual = null;

        foreach ($lineas as $linea) {
            if ($linea['ARTICULO_ID'] == $articuloId) {
                $lineaActual = $linea;
                break;
            }
        }

        if (!$lineaActual) {
            http_response_code(404);
            echo json_encode(["error" => "Línea no encontrada"]);
            return;
        }

        $diferencia = $nuevaCantidad - $lineaActual['CANTIDAD'];

        require_once '../modelo/Articulo.php';
        $articuloModel = new Articulo();
        $articulo = $articuloModel->getById($articuloId);

        if (!$articulo || ($articulo['STOCK'] < $diferencia && $diferencia > 0)) {
            http_response_code(400);
            echo json_encode(["error" => "Stock insuficiente"]);
            return;
        }

        // Actualiza la cantidad
        $this->modelo->actualizarCantidad($pedidoId, $articuloId, $nuevaCantidad);

        // Ajusta el stock
        $articuloModel->updateStock($articuloId, -$diferencia);

        echo json_encode(["message" => "Línea actualizada correctamente"]);
    }
}

}
