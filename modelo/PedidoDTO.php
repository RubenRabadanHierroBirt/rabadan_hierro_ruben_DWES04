<?php

class PedidoDTO {
    
    public $cliente;
    public $vendedor;
    public $fecha;
    public $estado;

    public function __construct($cliente, $vendedor, $fecha, $estado) {
        $this->cliente = $cliente;
        $this->vendedor = $vendedor;
        $this->fecha = $fecha;
        $this->estado = $estado;
    }

    public function toJson() {
        return json_encode($this);
    }
}
?>