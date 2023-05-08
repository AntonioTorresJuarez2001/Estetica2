<?php

namespace Model;

class Usuario extends ActiveRecord
{
    protected static $tabla = 'usuario';
    protected static $columnasDB = [
        'id', 'nombre', 'apellido', 'telefono',
        'email', 'administrador', 'confirmado', 'token', 'apellidoM', 'contrasena'
    ];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;
    public $email;
    public $administrador;
    public $confirmado;
    public $token;
    public $apellidoM;
    public $contrasena;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->administrador = $args['administrador'] ?? 0;
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
        $this->apellidoM = $args['apellidoM'] ?? '';
        $this->contrasena = $args['contrasena'] ?? '';
    }

    //Mensajes de validacion para crear cuenta
    public function ValidarNuevaCuenta()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'Nombre del cliente obligatorio';
        }

        if (!$this->apellido) {
            self::$alertas['error'][] = 'Apellido Paterno del cliente obligatorio';
        }
        if (!$this->apellidoM) {
            self::$alertas['error'][] = 'Apellido Materno del cliente obligatorio';
        }

        if (!$this->telefono) {
            self::$alertas['error'][] = 'Telefono del cliente obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'E-mail del cliente obligatorio';
        }

        if (!$this->contrasena) {
            self::$alertas['error'][] = 'ingrese una contrasena obligatorio';
        }

        if (strlen($this->contrasena) < 8) {
            self::$alertas['error'][] = 'La contrasena debe contener almenos 6';
        }

        return self::$alertas;
    }

    public function  validarLogin()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if (!$this->contrasena) {
            self::$alertas['error'][] = 'contrasena es obligatorio';
        }

        return self::$alertas;
    }

    public function validarEmail()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        return self::$alertas;
    }

    public function validarPassword ()
    {
        if (!$this->contrasena){
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }
        if (strlen($this->contrasena) < 6){
            self::$alertas['error'][] = 'La contraseña debe tener almenos 6 caracters';
        }
        return self::$alertas;
    }


    //REVISA SI EL USUARIO EXISTE
    public function existeUsuario()
    {
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);

        if ($resultado->num_rows) {
            self::$alertas['error'][] = 'El usuario ya esta registrado';
        }

        return $resultado;
    }

    public function hashPassword()
    {
        $this->contrasena = password_hash($this->contrasena, PASSWORD_BCRYPT);
    }

    public function crearToken()
    {
        $this->token = uniqid();
    }
     
    //ojo en esta funcion 
    public function comprobarPasswordAndVerificado($contrasena)
    {
        $resultado = password_verify($contrasena, $this->contrasena);
        
       if(!$this->confirmado){
         self::$alertas ['error'][] = 'Cuenta no confirmada';
        } else {
            return true;
         }
    }
}