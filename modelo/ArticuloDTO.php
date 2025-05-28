<?php

class ArticuloDTO {
    
    public $id;
    public $nombre;
    public $precio;
    public $descripcion; 
    public $stock;

    public function __construct($id, $nombre, $precio, $descripcion, $stock) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->descripcion = $descripcion;
        $this->stock = $stock;
    }

    public function toJson() {
        return json_encode($this);
    }
}
?>