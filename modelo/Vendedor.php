<?php

require_once '../config/Database.php';

class Vendedor {
    private $db;
    private $nombre;
    private $email;
    private $telefono;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setEmail($email) { $this->email = $email; }
    public function setTelefono($telefono) { $this->telefono = $telefono; }
    

    public function guardar() {
        $sql = "INSERT INTO vendedor (NOMBRE, EMAIL, TELEFONO) VALUES (:nombre, :email, :telefono)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre' => $this->nombre,
            ':email' => $this->email,
            ':telefono' => $this->telefono,
        ]);
    }
    public function get() {
        $sql = "SELECT * FROM vendedor";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM vendedor WHERE ID = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}


?>