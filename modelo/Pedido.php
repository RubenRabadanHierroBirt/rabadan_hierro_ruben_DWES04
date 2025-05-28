<?php

require_once '../config/Database.php';

class Pedido {
    private $db;
    private $id;
    private $cliente;
    private $vendedor;
    private $fecha;
    private $estado;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    
    public function setID($id) { $this->id = $id; }
    public function setCliente($cliente) { $this->cliente = $cliente; }
    public function setVendedor($vendedor) { $this->vendedor = $vendedor; }
    public function setFecha($fecha) { $this->fecha = $fecha; }
    public function setEstado($estado) { $this->estado = $estado; }
    

    public function guardar() {
        $sql = "INSERT INTO pedido (CLIENTE, VENDEDOR, FECHA, ESTADO) VALUES (:cliente, :vendedor, :fecha, :estado)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':cliente' => $this->cliente,
            ':vendedor' => $this->vendedor,
            ':fecha' => $this->fecha,
            ':estado' => $this->estado
        ]);
    }
    public function get() {
        $sql = "SELECT * FROM pedido";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        // Devuelve los resultados como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $sql = "DELETE FROM pedido WHERE ID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    public function getById($id) {
        $sql = "SELECT * FROM pedido WHERE ID = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}


?>