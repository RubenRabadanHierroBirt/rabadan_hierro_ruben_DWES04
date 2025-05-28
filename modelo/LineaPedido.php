<?php
require_once '../config/Database.php';

class LineaPedido {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function crear($pedidoId, $articuloId, $cantidad) {
        $sql = "INSERT INTO linea_pedido (PEDIDO, ARTICULO, CANTIDAD) 
                VALUES (:pedido, :articulo, :cantidad)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':pedido' => $pedidoId,
            ':articulo' => $articuloId,
            ':cantidad' => $cantidad
        ]);
    }

    public function getPorPedido($pedidoId) {
        $sql = "SELECT * FROM linea_pedido WHERE PEDIDO = :pedido";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':pedido' => $pedidoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminarPorPedido($pedidoId) {
        $sql = "DELETE FROM linea_pedido WHERE PEDIDO = :pedido";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':pedido' => $pedidoId]);
    }

    public function actualizarCantidad($pedidoId, $articuloId, $cantidad) {
    $sql = "UPDATE linea_pedido SET CANTIDAD = :cantidad 
            WHERE PEDIDO = :pedido AND ARTICULO = :articulo";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        ':cantidad' => $cantidad,
        ':pedido' => $pedidoId,
        ':articulo' => $articuloId
    ]);
}

}
?>
