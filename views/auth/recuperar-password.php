<h1 class="nombre-pagina">Recuperar contraseña</h1>
<p class="descripcion-pagina">Escribe tu nueva contraseña</p>

<?php 
//incluye alertas
include_once __DIR__ . "/../templates/alertas.php" ?>

<?php // si el token no es correcto no te dejara llenar el formulario

if($error) return null;
?>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="contrasena">Contraseña</label>
        <input type="password" id="contrasena" name="contrasena" placeholder="Escribe tu nueva contraseña">
    </div>

    <input type="submit" class="boton" value="Actualizar contraseña">



</form>

<div class="acciones">
    <a href="/">¿Ya tienes cuenta? Inicia Sesión</a>
</div>