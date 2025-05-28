<?php
require_once '../modelo/Pedido.php';
require_once '../modelo/PedidoDTO.php';

class PedidoController {
    
    private $pedidoModel;

    public function __construct() {
        $this->pedidoModel = new Pedido();
    }

    public function get() {
    require_once '../modelo/LineaPedido.php';
    $lineaModel = new LineaPedido();
    $pedidos = $this->pedidoModel->get();

    if (!$pedidos || count($pedidos) === 0) {
        echo json_encode(["error" => "No hay pedidos disponibles"]);
        return;
    }

    $pedidosDTO = array_map(function ($pedido) use ($lineaModel) {
    $lineas = $lineaModel->getPorPedido($pedido['ID']);
    $dto = new PedidoDTO(
        $pedido['CLIENTE'],
        $pedido['VENDEDOR'],
        $pedido['FECHA'],
        $pedido['ESTADO'],
        $lineas
    );
    return $dto->toArray();
    }, $pedidos);

    echo json_encode($pedidosDTO);
    }


    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inputJSON = file_get_contents("php://input");
            $inputData = json_decode($inputJSON, true);
            $clienteId = $inputData['cliente'] ?? '';
            $vendedorId = $inputData['vendedor'] ?? '';
            $fecha = $inputData['fecha'] ?? 0;
            $estado = $inputData['estado'] ?? 0;


            // Verificar cliente
            require_once '../modelo/Cliente.php';
            $clienteModel = new Cliente();
            $cliente = $clienteModel->getById($clienteId);
            if (!$cliente) {
                http_response_code(404);
                echo json_encode(["error" => "Cliente no encontrado"]);
                return;
            }

            // Verificar vendedor
            require_once '../modelo/Vendedor.php';
            $vendedorModel = new Vendedor();
            $vendedor = $vendedorModel->getById($vendedorId);
            if (!$vendedor) {
                http_response_code(404);
                echo json_encode(["error" => "Vendedor no encontrado"]);
                return;
            }

            $pedido = new Pedido();
            $pedido->setCliente($clienteId);
            $pedido->setVendedor($vendedorId);
            $pedido->setFecha($fecha);
            $pedido->setEstado($estado);

            if ($pedido->guardar()) {
                echo json_encode(["mensaje" => "Pedido creado correctamente"]);
            } else {
                echo json_encode(["error" => "Error al guardar el pedido"]);
            }
        } else {
            echo json_encode(["error" => "Método no permitido"]);
        }
    }

   public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $pedidoExistente = $this->pedidoModel->getById($id);

            if (!$pedidoExistente) {
                http_response_code(404);
                echo json_encode(["error" => "Pedido no encontrado"]);
                return;
            }

            // Valida que la fecha del pedido sea posterior
            $fechaPedido = new DateTime($pedidoExistente['FECHA']);
            $fechaActual = new DateTime();

            if ($fechaPedido <= $fechaActual) {
                http_response_code(403);
                echo json_encode(["error" => "El pedido no puede eliminarse porque la fecha no es futura"]);
                return;
            }

            // Validar que el estado sea 'pendiente'
            if (strtolower($pedidoExistente['ESTADO']) !== 'pendiente') {
                http_response_code(403);
                echo json_encode(["error" => "Solo se pueden eliminar pedidos con estado 'pendiente'"]);
                return;
            }

            if ($this->pedidoModel->delete($id)) {
                echo json_encode(["mensaje" => "Pedido y sus líneas eliminados correctamente"]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Error al eliminar el pedido"]);
            }
        } else {
            http_response_code(405);
            echo json_encode(["error" => "Método no permitido"]);
        }
    }


    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $pedidoExistente = $this->pedidoModel->getById($id);

            if (!$pedidoExistente) {
                http_response_code(404);
                echo json_encode(["error" => "Pedido no encontrado"]);
                return;
            }

            // Verificar que el pedido tenga menos de 5 días
            $fechaPedido = new DateTime($pedidoExistente['FECHA']);
            $fechaActual = new DateTime();
            $diferencia = $fechaActual->diff($fechaPedido)->days;

            if ($diferencia > 5) {
                http_response_code(403);
                echo json_encode(["error" => "El pedido no puede ser modificado porque tiene más de 5 días"]);
                return;
            }

            $inputJSON = file_get_contents("php://input");
            $inputData = json_decode($inputJSON, true);

            $cliente = $inputData['cliente'] ?? $pedidoExistente['CLIENTE'];
            $vendedor = $inputData['vendedor'] ?? $pedidoExistente['VENDEDOR'];
            $fecha = $inputData['fecha'] ?? $pedidoExistente['FECHA'];
            $estado = $inputData['estado'] ?? $pedidoExistente['ESTADO'];

            $pedido = new Pedido();
            $pedido->setId($id);
            $pedido->setCliente($cliente);
            $pedido->setVendedor($vendedor);
            $pedido->setFecha($fecha);
            $pedido->setEstado($estado);

            if ($pedido->update()) {
                $dto = new PedidoDTO($cliente, $vendedor, $fecha, $estado);
                echo json_encode($dto);
            } else {
                echo json_encode(["error" => "Error al actualizar el pedido"]);
            }
        } else {
            http_response_code(405);
            echo json_encode(["error" => "Método no permitido"]);
        }
    }

}
