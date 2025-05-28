<?php
require_once '../config/Database.php';

class Articulo {
    private $db;
    private $nombre;
    private $descripcion;
    private $precio;
    private $stock;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }
    public function setPrecio($precio) { $this->precio = $precio; }
    public function setStock($stock) { $this->stock = $stock; }
    

    public function create() {
        $sql = "INSERT INTO articulo (NOMBRE, DESCRIPCION, PRECIO, STOCK) VALUES (:nombre, :descripcion, :precio, :stock)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre' => $this->nombre,
            ':descripcion' => $this->descripcion,
            ':precio' => $this->precio,
            ':stock' => $this->stock
        ]);
    }
    public function get() {
        $sql = "SELECT * FROM articulo";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        // Devuelve los resultados como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id) {
    $sql = "SELECT * FROM articulo WHERE ID = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function update($id) {
    $sql = "UPDATE articulo SET NOMBRE = :nombre, DESCRIPCION = :descripcion, PRECIO = :precio, STOCK = :stock WHERE ID = :id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        ':nombre' => $this->nombre,
        ':descripcion' => $this->descripcion,
        ':precio' => $this->precio,
        ':stock' => $this->stock,
        ':id' => $id
    ]);
}


}


?>