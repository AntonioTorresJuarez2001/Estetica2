<h1 class="nombre-pagina">Crear cuenta</h1>
<p class="descripcion-pagina">Para crear tu cuenta necesitamos algunos datos</p>


<?php 
//incluye alertas
include_once __DIR__ . "/../templates/alertas.php" ?>

<form class="formulario" method="POST" action="/crear-cuenta">
    <div class="campo">
        <label for="nombre">Nombre</label>
         <input type="text"
                id="nombre"
                name="nombre" 
                placeholder="Ingresa tu nombre"
                value = "<?php echo s($usuario->nombre); ?>" >
                

    </div>

    <div class="campo">
    <label for="apellido">Apellido Paterno</label>
         <input type="text"
                id="apellido"  
                name="apellido" 
                placeholder="Ingresa tu apellido paterno"
                value="<?php echo s($usuario->apellido); ?>"
                 >
                
    </div>

    <div class="campo">
    <label for="apellidoM">Apellido Materno</label>
         <input type="text"
                id="apellidoM"
                name="apellidoM" 
                placeholder="Ingresa tu apellido materno"
                value = "<?php echo s($usuario->apellidoM); ?>" >
                
    </div>

    

    <div class="campo">
    <label for="telefono">Telefono</label>
         <input type="tel"
                id="telefono"
                name="telefono" 
                placeholder="Ingresa tu numero"
                value = "<?php echo s($usuario->telefono); ?>" >
                
    </div>

    <div class="campo">
    <label for="email">Email</label>
         <input type="email"
                id="email"
                name="email" 
                placeholder="Ingresa tu email"
                value = "<?php echo s($usuario->email); ?>" >
                
    </div>

    <div class="campo">
    <label for="contrasena">Contraseña</label>
         <input type="password"
                id="contrasena"
                name="contrasena" 
                placeholder="Coloca una contraseña"
                value="<?php echo s($usuario->contrasena); ?>">
                
    </div>

    <input type="submit" value="Crear Cuenta" class="boton">

    

</form>

<div class="acciones">
        <a href="/">¿Ya tienes cuenta? Inicia Sesión</a>
    </div>
