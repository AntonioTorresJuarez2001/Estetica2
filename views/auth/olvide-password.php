<h1 class="descripcion-pagina">Olvide mi contraseña</h1>
<p class="descripcion-pagina">Verifica que la cuenta te pertenece colocando tu email</p>

<?php include_once __DIR__ . "/../templates/alertas.php" ?>


<form class="formulario" action="/olvide" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input 
        type="email"
        id="emai"
        placeholder="Escribe tu email"
        name="email">
        </div>

        <input type="submit" class="boton" value="Enviar Instrucciones">
    
</form>

<div class="acciones">
        <a href="/crear-cuenta">¿Eres cliente nuevo? Crea tu cuenta</a>
        <a href="/">¿Ya tienes cuenta? Inicia Sesión</a>
    </div>