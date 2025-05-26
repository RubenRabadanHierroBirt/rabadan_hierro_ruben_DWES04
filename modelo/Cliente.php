<?php
require_once '../config/Database.php';

class Cliente {
    private $db;
    private $nombre;
    private $email;
    private $telefono;
    private $direccion;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setEmail($email) { $this->email = $email; }
    public function setTelefono($telefono) { $this->telefono = $telefono; }
    public function setDireccion($direccion) { $this->direccion = $direccion; }
    

    public function create() {
        $sql = "INSERT INTO cliente (NOMBRE, EMAIL, TELEFONO, DIRECCION) VALUES (:nombre, :email, :telefono, :direccion)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre' => $this->nombre,
            ':email' => $this->email,
            ':telefono' => $this->telefono,
            ':direccion' => $this->direccion
        ]);
    }
    public function get() {
        $sql = "SELECT * FROM cliente";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM cliente WHERE ID = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


}


?>