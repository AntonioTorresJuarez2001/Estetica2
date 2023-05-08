let paso = 1;

const cita = {
  id: "",
  nombre: "",
  fecha: "",
  hora: "",
  servicios: [],
};

//aqui se cargara todas as funciones jeje
document.addEventListener("DOMContentLoaded", function () {
  iniciarApp();
});

function iniciarApp() {
  mostrarSeccion(); // va mostrar primero seccion que desclaremos en let pasa = x;
  tabs(); //cambian cuando se presionen los tabs
  botonesPaginador(); //agrega o quita botones del paginador
  consultarAPI(); //Consulta la API del backend

  idCliente();
  nombreCliente(); //añade el nombre del cliente al objeto de cita
  seleccionarFecha(); //añade la fecha en el objeto
  seleccionarHora(); // añade la hora en el odjeto
  mostrarResumen(); // muestra el resumen
}

function mostrarSeccion() {
  // Eliminar mostrar-seccion de la sección anterior, osea que quita servicios y muestra
  //solo resumen para que no se acumulen abajo jeje
  const seccionAnterior = document.querySelector(".mostrar");
  if (seccionAnterior) {
    seccionAnterior.classList.remove("mostrar");
  }

  //mostrar seccion con el paso PASO..
  const pasoSelector = `#paso-${paso}`;
  const seccion = document.querySelector(pasoSelector);
  seccion.classList.add("mostrar");

  // Eliminar la clase de actual en el tab anterior osea que te le va quita lo blanco
  // del Nav cuando resalta
  const tabAnterior = document.querySelector(".tabs .actual");
  if (tabAnterior) {
    tabAnterior.classList.remove("actual");
  }

  //resalta el tab altual
  const tab = document.querySelector(`[data-paso="${paso}"]`);
  tab.classList.add("actual");
}

function tabs() {
  const botones = document.querySelectorAll(".tabs button");

  botones.forEach((boton) => {
    boton.addEventListener("click", function (e) {
      paso = parseInt(e.target.dataset.paso);

      mostrarSeccion();

      if (paso === 3) {
        mostrarResumen();
      }
    });
  });
}
//no sirve
function botonesPaginador() {
  const paginaAnterior = document.querySelector("#anterior");
  const paginaSiguiente = document.querySelector("#siguiente");

  if (paso === 1) {
    //solo se mantiene el siguiente en servicios
    paginaAnterior.classList.add("ocultar");
  } else if (paso === 3) {
    //solo se mantiene el anterior en resumen
    paginaAnterior.classList.remove("ocultar");
    paginaSiguiente.classList.add("ocultar");
  } else {
    //pa que se mantenga los 2 en cita
    paginaAnterior.classList.remove("ocultar");
    paginaSiguiente.classList.remove("ocultar");
  }
}

//sincronizar 2 funciones al mismo tiempo
async function consultarAPI() {
  //rl try va tratar de ejecutar el codigo.
  try {
    //aqui voy a pegar mi url API servicios
    const url = "http://localhost:3000/api/servicios";
    //el await va de la mano con async para que funcione
    const resultado = await fetch(url);
    const servicios = await resultado.json();
    mostrarServicios(servicios);
    //si no puede ejecutar el Try pasa al Catch a mostrar el error
  } catch (error) {
    console.log(error);
  }
}

function mostrarServicios(servicios) {
  servicios.forEach((servicio) => {
    const { id, nombre, precio } = servicio;

    const nombreServicio = document.createElement("P");
    nombreServicio.classList.add("nombre-servicio");
    nombreServicio.textContent = nombre;

    const precioServicio = document.createElement("P");
    precioServicio.classList.add("precio-servicio");
    precioServicio.textContent = `$${precio}`;

    const servicioDiv = document.createElement("DIV");
    servicioDiv.classList.add("servicio");
    servicioDiv.dataset.idServicio = id;
    servicioDiv.onclick = function () {
      seleccionarServicio(servicio);
    };

    servicioDiv.appendChild(nombreServicio);
    servicioDiv.appendChild(precioServicio);

    //aqui mostraremos en el html
    document.querySelector("#servicios").appendChild(servicioDiv);
  });
}

function seleccionarServicio(servicio) {
  const { id } = servicio;
  const { servicios } = cita;

  // Identificar el elemento al que se le da click
  const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

  // Comprobar si un servicio ya fue agregado
  if (servicios.some((agregado) => agregado.id === id)) {
    // Eliminarlo
    cita.servicios = servicios.filter((agregado) => agregado.id !== id);
    divServicio.classList.remove("seleccionado");
  } else {
    // Agregarlo
    cita.servicios = [...servicios, servicio];
    divServicio.classList.add("seleccionado");
  }
  // console.log(cita);
}

function idCliente() {
  //tomaremos el nombre del paso2 de html por su identifcador
  cita.id = document.querySelector("#id").value;
}

function nombreCliente() {
  //tomaremos el nombre del paso2 de html por su identifcador
  cita.nombre = document.querySelector("#nombre").value;
}

function seleccionarFecha() {
  const inputFecha = document.querySelector("#fecha");
  inputFecha.addEventListener("input", function (e) {
    //con esto sabremos el dia de la semana
    const dia = new Date(e.target.value).getUTCDay();

    if ([0].includes(dia)) {
      e.target.value = "";
      mostrarAlerta("Domingo se encuentra cerrado", "error", ".formulario");
    } else {
      cita.fecha = e.target.value;
    }
  });
}

function seleccionarHora() {
  const inputHora = document.querySelector("#hora");
  inputHora.addEventListener("input", function (e) {
    const horaCita = e.target.value;
    //separa el split ejem; ("hola",  "mundo")
    const hora = horaCita.split(":")[0];
    if (hora < 10 || hora > 19) {
      e.target.value = "";
      mostrarAlerta("Hora No Válida", "error", ".formulario");
    } else {
      cita.hora = e.target.value;

      // console.log(cita);
    }
  });
}

function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {
  // Previene que se generen más de 1 alerta
  const alertaPrevia = document.querySelector(".alerta");
  if (alertaPrevia) {
    alertaPrevia.remove();
  }

  // Scripting para crear la alerta
  const alerta = document.createElement("DIV");
  alerta.textContent = mensaje;
  alerta.classList.add("alerta");
  alerta.classList.add(tipo);

  const referencia = document.querySelector(elemento);
  referencia.appendChild(alerta);

  if (desaparece) {
    // Eliminar la alerta
    setTimeout(() => {
      alerta.remove();
    }, 3000);
  }
}

function mostrarResumen() {
  const resumen = document.querySelector(".contenido-resumen");

  //limpiar el contenido del resumen
  while (resumen.firstChild) {
    resumen.removeChild(resumen.firstChild);
  }

  if (Object.values(cita).includes("") || cita.servicios.length === 0) {
    mostrarAlerta("Falta algo", "error", ".contenido-resumen", false);
    return;
  }
  //formatear el div de resumen
  const { nombre, fecha, hora, servicios } = cita;

  const nombreCliente = document.createElement("P");
  nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

  //hacer que la fecha se vea mas amigable
  const fechaObj = new Date(fecha);
  const mes = fechaObj.getMonth();
  const dia = fechaObj.getDate() + 2;
  const year = fechaObj.getFullYear();

  const fechaUTC = new Date(Date.UTC(year, mes, dia));
  //aqui se acomoda 27 de noviembre del 2021
  const opciones = {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  };
  const fechaAmigable = fechaUTC.toLocaleDateString("es-MX", opciones);

  const fechaCita = document.createElement("P");
  fechaCita.innerHTML = `<span>Fecha:</span> ${fechaAmigable}`;

  const horaCita = document.createElement("P");
  horaCita.innerHTML = `<span>Hora:</span> ${hora} Horas`;

  //encabezado de servicios - solo agrega "resumen de los servicios" arriba
  const encabezadoServicios = document.createElement("h3");
  encabezadoServicios.textContent = "Resumen de los servicios";
  resumen.appendChild(encabezadoServicios);

  //mostrando los servicios
  servicios.forEach((servicio) => {
    const { id, precio, nombre } = servicio;
    const contenedorServicio = document.createElement("DIV");
    contenedorServicio.classList.add("contenedor-servicio");

    const textoServicio = document.createElement("P");
    textoServicio.textContent = nombre;

    const precioServicio = document.createElement("P");
    precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;

    contenedorServicio.appendChild(textoServicio);
    contenedorServicio.appendChild(precioServicio);

    //el appenchil los muestra ya todo jejej
    resumen.appendChild(contenedorServicio);
  });
  //solo agrega como titulo de "Resumen cita'
  const encabezadoServiciosdelcliente = document.createElement("h3");
  encabezadoServiciosdelcliente.textContent = "Resumen de la cita";
  resumen.appendChild(encabezadoServiciosdelcliente);

  // Boton para Crear una cita

  //se crear el botom
  const botonReservar = document.createElement("BUTTON");
  //se le da la clase de boton
  botonReservar.classList.add("boton");
  //la letra que lleva el boton
  botonReservar.textContent = "Reservar Cita";
  //cuando le demos clic le asociomos la funcion de reservarCita
  botonReservar.onclick = reservarCita;

  resumen.appendChild(nombreCliente);
  resumen.appendChild(fechaCita);
  resumen.appendChild(horaCita);
  resumen.appendChild(botonReservar);
}


async function reservarCita() {
    
  const { nombre, fecha, hora, servicios, id } = cita;

  const idServicios = servicios.map( servicio => servicio.id );
  // console.log(idServicios);

  const datos = new FormData();
  
  datos.append('fecha', fecha);
  datos.append('hora', hora );
  datos.append('usuarioId', id);
  datos.append('servicios', idServicios);

  // console.log([...datos]);

  try {
      // Petición hacia la api
      const url = 'http://localhost:3000/api/citas'
      const respuesta = await fetch(url, {
          method: 'POST',
          body: datos
      });

      const resultado = await respuesta.json();
      console.log(resultado);
      
      if(resultado.resultado) {
          Swal.fire({
              icon: 'success',
              title: 'Cita Creada',
              text: 'Tu cita fue creada correctamente',
              button: 'OK'
          }).then( () => {
              setTimeout(() => {
                  window.location.reload();
              }, 3000);
          })
      }
  } catch (error) {
      Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Hubo un error al guardar la cita'
      })
  }

  
  // console.log([...datos]);

}