<?php

class ArticuloDTO {
    
    public $id;
    public $nombre;
    public $precio; 
    public $stock;

    public function __construct($id, $nombre, $precio, $stock) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->stock = $stock;
    }

    public function toJson() {
        return json_encode($this);
    }
}
?>