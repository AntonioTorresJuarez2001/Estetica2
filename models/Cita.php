<?php
 
 namespace Model;

 class Cita extends ActiveRecord {
    //config BD 
    protected static $tabla = 'citas';
    protected static $columnasDB = ['fecha','hora','id','usuarioId'];

    public $fecha;
    public $hora;
    public $id;
    public $usuarioId;

    public function __construct($args = [])
    {
        $this->fecha = $args['fecha'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->id = $args['id'] ?? null;
        $this->usuarioId = $args['usuarioId'] ?? '';
    }
 }