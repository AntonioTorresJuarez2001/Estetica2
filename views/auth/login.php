<h1 class="nombre-pagina">Iniciar sesión</h1>
<p class="descripcion-pagina">¡Hola! Para seguir, ingresa tu e‑mail de usuario</p>

<?php include_once __DIR__ . "/../templates/alertas.php" ?>


<form class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Coloca tu email" name="email"
         />
    </div>
    <div class="campo">
        <label for="contrasena">Contraseña</label>
        <input type="password" id="contrasena" placeholder="contrasena" name="contrasena" />
    </div>

    <input type="submit" class="boton" value="Iniciar Sesion">

    <div class="acciones">
        <a href="/crear-cuenta">¿Eres cliente nuevo? Crea tu cuenta</a>
        <a href="/olvide">Olvide mi contraseña</a>
    </div>







    </div>

</form>