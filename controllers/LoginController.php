<?php

namespace Controllers;

use Clasess\email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
  public static function login(Router $router) {
    $alertas = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $auth = new Usuario($_POST);
      $alertas = $auth->validarLogin();

      if (empty($alertas)) {
        //comprobar que exista el usuario
        $usuario = Usuario::where('email', $auth->email);

        //TALVEZ NO SEA NECESARIO 
        if ($usuario) {
          //verificar password
          if ($usuario->comprobarPasswordAndVerificado($auth->contrasena)) {
            //AUTENTIFICAR USUARIO
            session_start();

            $_SESSION['id'] = $usuario->id;
            $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
            $_SESSION['email'] = $usuario->email;
            $_SESSION['login'] = true;
            //rediccionamiento o roles de cliente o admin
            if ($usuario->administrador === "1") {
              $_SESSION['administrador'] = $usuario->administrador ?? null;
              header('Location: /admin');
            } else {
              header('Location: /cita');
            }
          }
        } else {
          Usuario::setAlerta('error', 'usuario no encontrado');
        }
      }
    }

    $alertas = Usuario::getAlertas();
    $router->render('auth/login', ['alertas' => $alertas]);
  }

  public static function logout()
  {
    session_start();

    $_SESSION = [];
     
    header('location: /');
  }

  public static function olvide(Router $router)
  {
    $alertas = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      //leer el email que el usurio puso
      $auth = new Usuario($_POST);
      $alertas = $auth->validarEmail();
      if (empty($alertas)) {
        $usuario = Usuario::where('email', $auth->email);

        if ($usuario && $usuario->confirmado === "1") {
          //generar un token
          $usuario->crearToken();
          //Guarda el nuevo token en la base de datos
          $usuario->guardar();

          //enviar email
          $email = new email($usuario->email, $usuario->nombre, $usuario->token);
          $email->enviarInstrucciones();


          //alerta que todo esta bien
          Usuario::setAlerta('exito', 'Revisa tu email');
        } else {
          Usuario::setAlerta('error', 'No hay cuenta para este correo o no esta confirmado');
        }
      }
    }
    $alertas = Usuario::getAlertas();
    $router->render('auth/olvide-password', ['alertas' => $alertas]);
  }

  public static function recuperar(Router $router)
  {
    $alertas = [];
    $error = false;

    $token = s($_GET['token']);

    //buscar usuario por su token
    $usuario = Usuario::where('token', $token);

    if (empty($usuario)) {
      Usuario::setAlerta('error', 'Token no valido');
      $error = true;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      //LEE EL NUEVO PASSWORD Y LO GUARDA EN LA BASE DE DATOS
      $contrasena = new Usuario($_POST);
      $alertas = $contrasena->validarPassword();

      if (empty($alertas)) {
        $usuario->contrasena = null;
        $usuario->contrasena = $contrasena->contrasena;
        $usuario->hashPassword();

        $usuario->token = null;

        $resulado = $usuario->guardar();

        if ($resulado) {
          header('Location: /');
        }


        // debuguear($usuario);
      }
    }

    //debuguear($usuario); 

    //pa que vengam las alertas
    $alertas = Usuario::getAlertas();
    //vista
    $router->render('auth/recuperar-password', [
      'alertas' => $alertas,
      'error' => $error

    ]);
  }

  public static function crear(Router $router)
  {
    $usuario = new Usuario();
    //alertas vacias
    $alertas = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $usuario->sincronizar($_POST);
      $alertas = $usuario->ValidarNuevaCuenta();
      //debuguear($alertas); 
      if (empty($alertas)) {
        $resulado = $usuario->existeUsuario();
        if ($resulado->num_rows) {
          $alertas = Usuario::getAlertas();
        } else {
          //HASERAR PASS   
          $usuario->hashPassword();

          //crear token
          $usuario->crearToken();

          //enviar el email
          $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
          $email->enviarConfirmacion();

          //crear usuario
          $resulado = $usuario->guardar();
          //redireccionar
          if ($resulado) {
            header('Location: /mensaje');
          }

          // debuguear($email);
          //debuguear($usuario);
        }
      }
    }
    $router->render('auth/crear-cuenta', [
      'usuario' => $usuario,
      'alertas' => $alertas
    ]);
  }
  public static function mensaje(Router $router)
  {

    $router->render('auth/mensaje');
  }

  public static function confirmar(Router $router)
  {
    $alertas = [];

    $token = s($_GET['token']);
    $usuario = Usuario::where('token', $token);
    //debuguear($usuario);

    if (empty($usuario) || $usuario->token === '') {
      //si esta vaciio muestrar error
      Usuario::setAlerta('error', 'Token no valido');
    } else {
      //user confirmado
      $usuario->confirmado = "1";
      //borra el token despues de confirmar
      $usuario->token = '';
      //guardamos
      $usuario->guardar();
      //mostrar en pantalla qur todo bien con la alerta de exito
      Usuario::setAlerta('exito', 'Cuenta confirmada correctamente');
      //debuguear($usuario);
    }
    //VA LEER ANTES DE MOSTRAR LA VISTA
    $alertas = Usuario::getAlertas();

    $router->render('auth/confirmar-cuenta', [
      'alertas' => $alertas
    ]);
  }
}
