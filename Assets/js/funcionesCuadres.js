let tblCuadres, tblCuadresG;
document.addEventListener("DOMContentLoaded", function () {
  //La variable tblCaantidades es igual a nuestra datatable. Tabla de las cantidades
  tblCuadres = $("#tblCuadres").DataTable({
    ajax: {
      //Se manda al controlador Clientes y al método listarCliente
      url: base_url + "Rutas/verRutas",
      dataSrc: ''
    },
    columns: [{
      'data': 'id'
    },
    {
      'data': 'ruta'
    },
    {
      'data': 'acciones'
    }]
  });
  tblCuadresG = $("#tblCSemanal").DataTable({
    ajax: {
      //Se manda al controlador Clientes y al método listarCliente
      url: base_url + "Rutas/listarCuadresSemanales",
      dataSrc: ''
    },
    columns: [
      {
        'data': 'id'
      },
      {
        'data': 'ruta'
      },
      {
        'data': 'acciones'
      }]
  });
})

//Función para el botón editar cliente que recibe un parámetro id. Se mandará a llamar en el controlador usuario. En los botones de listar usuarios. 
function btnCuadreSemanal(id) {
  const url = base_url + 'CuadresG/cuadreSemanal/' + id;
  const http = new XMLHttpRequest();
  http.open('GET', url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      console.log(this.responseText);
      document.getElementById("id_ruta").value = res['tabla2'].id_ruta;
      document.getElementById("total_abonos").value = res['tabla2'].abonos;
      document.getElementById("total_ventas").value = res['tabla2'].ventas;
      document.getElementById("total_gastos").value = res['tabla2'].gastos;
     /* document.getElementById("caja_semanal").value = res['tabla2'].caja_final;*/
      document.getElementById("caja_semanal").value = parseFloat(res['tabla2'].abonos-res['tabla2'].ventas-res['tabla2'].gastos + parseFloat(res['tabla2'].inversion));

      let htmlHeader = `<thead class="thead table-dark"><tr>
        <th>Días</th>
        <th>Abonos</th>
        <th>Ventas</th>
        <th>Gastos</th>`;
      let htmlBody = '';
      res['tabla'].forEach(row => {
        let diaSemana;
        switch (parseInt(row.dia)) {
          case 1:
            diaSemana = 'Lunes';
            break;
          case 2:
            diaSemana = 'Martes';
            break;
          case 3:
            diaSemana = 'Miércoles';
            break;
          case 4:
            diaSemana = 'Jueves';
            break;
          case 5:
            diaSemana = 'Viernes';
            break;
          case 6:
            diaSemana = 'Sábado';
            break;
          case 7:
            diaSemana = 'Domingo';
            break;
          default:

        }  htmlBody += `<tr>
      <td>${diaSemana}</td>
      <td>${"$" + row.cobrado}</td>
      <td>${"$" + row.prestamos}</td>
      <td>${"$" + row.gastos}</td>
      </tr>`;
      });

      document.getElementById("tblCuadresG").innerHTML = htmlHeader + '<tbody>' + htmlBody + '</tbody>';
      
      $('#cuadre_semanal').modal('show');
    }
  };
}

function btnHistorialCSemanal(id) {
  const url = base_url + 'CuadresG/historialSemanal/' + id;
  const http = new XMLHttpRequest();
  http.open('GET', url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      console.log(this.responseText);

      let htmlHeader = `<thead class="thead table-dark"><tr>
        <th>Abonos</th>
        <th>Ventas</th>
        <th>Gastos</th>
        <th>Caja semanal</th>
        <th>Fecha</th>`;
      let htmlBody = '';
      res.forEach(row => {
        
        htmlBody += `<tr>
      <td>${"$" + row.total_abonos}</td>
      <td>${"$" + row.total_ventas}</td>
      <td>${"$" + row.total_gastos}</td>
      <td>${"$" + row.caja_semanal}</td>
      <td>${row.fecha_semanal}</td>
      </tr>`;
      });

      document.getElementById("tblCuadreS").innerHTML = htmlHeader + '<tbody>' + htmlBody + '</tbody>';
      
      $('#historial_cuadreS').modal('show');
    }
  };
}

function registrarCuadreS(e) {
  e.preventDefault();

  // Obtener los valores de los campos en la diapositiva actual
  const total_abonos = document.getElementById("total_abonos").value
  const total_ventas = document.getElementById("total_ventas").value
  const total_gastos = document.getElementById("total_gastos").value
  const caja_semanal = document.getElementById("caja_semanal").value
  const fecha_semanal = document.getElementById("fecha_semanal").value;
  const id_ruta = document.getElementById("id_ruta").value

  if ( total_abonos.value == "" || total_ventas.value == "" || total_gastos.value == "" || caja_semanal.value == "" || fecha_semanal.value == "" || id_ruta.value == "") {
    //SweetAlert2. Su ruta está en el footer dentro de templates de Views. Es una alerta
    Swal.fire({
      position: 'top-end',
      icon: 'error',
      title: 'Todos los campos son obligatorios',
      showConfirmButton: false,
      timer: 3000
    })

  } else { //< petición mediante AJAX usando el xml request
    //Se crea una constante que almacena la url y concatena con el controlador Usuarios y su método registrar 
    const url = base_url + "CuadresG/registrarCuadreSemanal";
    const frm = document.getElementById("frmCuadres");
    const http = new XMLHttpRequest();
    //Se crea una condición Por el método POST, se le envía una url y que se ejecuta de forma asincrona(booleana)
    http.open("POST", url, true);
    //Se envía la petición, siendo nueva con un FormData y dentro de ella la constante en este caso el frm 
    http.send(new FormData(frm));
    //////////////Temporales///////////////////
    http.onreadystatechange = function () {
      //validación. Si el estatus es igual a 200 la respuesta está lista.
      if (this.readyState == 4 && this.status == 200) {
        //Se convierte el mensaje a un JSON
        const res = JSON.parse(this.responseText);
        if (res == "si") {
          Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Cuadre semanal registrado con éxito',
            showConfirmButton: false,
            timer: 3000
          })
          //Reseteo de formulario
          frm.reset();
          //Ocultar el modal
          $("#cuadre_semanal").modal("hide");

          //Se verifica si res es igual al mensaje modificado del controlador
        } else {
          Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: res,
            showConfirmButton: false,
            timer: 3000
          })
        }
      }
    }

  }
}
