<h1 class="nombre-pagina">Crear Nueva cita</h1>
<p class="text-center" class="descripcion-pagina">Elige tus servicios e ingresa tus datos</p class="text-center">

<?php 
include_once __DIR__ . '/../templates/barra.php';
?>

<div class="app">

    <div id="app">
        <nav class="tabs">
            <button class="actual" type="button" data-paso="1">Servicios</button>
            <button type="button" data-paso="2">Informacion cita</button>
            <button type="button" data-paso="3">Resumen</button>
        </nav>
    </div>

    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuacion</p class="text-center">
        <div id="servicios" class="listado-servicios"></div>
    </div>

    <div id="paso-2" class="seccion">
        <h2>Tus datos y cita</h2>
        <p class="text-center">Coloca tus datos y fecha de cita</p class="text-center">
        <p class="text-center">Horario de atencion de Lunes a Sabado con horario de 10 Am a 8 Pm</p class="text-center">
        
        <form class="formulario">
            <div class="campo">
                <label for="nombre">Tu Nombre</label>
                <input type="text" id="nombre" placeholder="Tu nombre" value="<?php echo $nombre; ?>" disabled>
            </div>
            <div class="campo">
                <label for="nombre">Fecha</label>
                <input type="date" id="fecha"
                min="<?php echo date('Y-M-d');?>" >
            </div>

            <div class="campo">
                <label for="hora">Hora</label>
                <input type="time" id="hora">
            </div>
            <input type="hidden" id="id" value="<?php echo $id; ?>">


        </form>

    </div>

    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p class="text-center">Verifica la informacion</p class="text-center">
    </div>

    <div class="paginacion">
      <button class="boton" id="anterior">
            <-Anteior </button>
                <button class="boton" id="siguiente"> Siguente-></button>
    </div>

</div>

<?php
   echo $script = "
   <script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
   <script src='build/js/app.js'></script>
   
    ";
   ?>