<?php

namespace Model;

class CitaServicio extends ActiveRecord {
    protected static $tabla = 'citasservicios';
    protected static $columnasDB = ['citaId', 'id', 'servicioId'];

    public $citaId;
    public $id; 
    public $servicioId;

    public function __construct($args = [])
    {
        $this->citaId = $args['citaId'] ?? '';
       $this->id = $args['id'] ?? null;
       $this->servicioId = $args['servicioId'] ?? ''; 
    }
}