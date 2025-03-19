let tblPagos, tblPagosHoy;
document.addEventListener("DOMContentLoaded", function (){
//La variable tblCaantidades es igual a nuestra datatable. Tabla de las cantidades
tblPagos = $("#tblPagos").DataTable({
    ajax: {
        //Se manda al controlador Clientes y al método listarCliente
        url: base_url + "Pagos/listarPago",
        dataSrc: ''
    },
    columns: [{
        'data': 'id_cliente'
    },
    {
        'data': 'cliente'
    },
    {
        'data': 'total_pago'
    },
    {
        'data': 'saldo'
    },
    {
        'data': 'acciones'
    }]
});
tblPagosHoy = $("#tblPagosHoy").DataTable({
    ajax: {
        //Se manda al controlador Clientes y al método listarPagoHoy
        url: base_url + "Pagos/listarPagoHoy",
        dataSrc: '',
        
    },
    columns: [
    {
        'data': 'cliente'
    },
    {
        'data': 'total_pago'
    },
    {
        'data': 'saldo'
    },
    {
        'data':'pagos'
    },
    {
        'data': 'fecha_final'
    },
    {
        'data': 'hora_pago'
    }]
});
});

function registrarPago(e) {
  e.preventDefault();

  // Obtener la diapositiva actual
//   const currentSlide = $('.slide.active');

  // Obtener los valores de los campos en la diapositiva actual
  const id_cliente = document.getElementById("id_cliente").value;
  const id_prestamo = document.getElementById("id_prestamo").value;
  const cantidad_dias = document.getElementById("cantidad_dias").value;
  const abono = document.getElementById("abono");
  const fecha_pago = document.getElementById("fecha_pago");
  const hora_pago = document.getElementById("hora_pago");

  if (id_cliente.value == "" || id_prestamo.value == "" || cantidad_dias.value == "" || abono.value == "" || fecha_pago.value == "" || hora_pago.value == "") {
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
      const url = base_url + "Pagos/registrar";
      const frm = document.getElementById("frmPagos");
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
              console.log(res.responseText);
              if (res == "si") {
                  Swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      title: 'Pago registrado con éxito',
                      showConfirmButton: false,
                      timer: 3000
                  })

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

//Función para el botón editar cliente que recibe un parámetro id. Se mandará a llamar en el controlador usuario. En los botones de listar usuarios. 
function btnHistorialCliente(id) {
    const url = base_url + 'Pagos/histoClientesG/' + id;
    const http = new XMLHttpRequest();
    http.open('GET', url, true);
    http.send();
    http.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        console.log(this.responseText);
        let htmlHeader = `<thead class="thead table-dark"><tr>
        <th>ID</th>
        <th>Pagos</th>
        <th></th>
        <th>Cuotas</th>
        <th>Atrasos</th>
        <th>Fecha</th>
        <th>Hora</th>
        </tr></thead>`;
        let htmlBody = '';
            res.forEach(row => { if (row['tipo_pago']== "Efectivo") {   
                htmlBody+=`<tr>
                <td>${row['id']}</td>
                <td>${"$"+row['pago']}</td>
                <td>${row['tipo_pago']= `<i class="fas fa-coins" style="width:30px; color:"></i>`}</td>
                <td>${row['cuotas_vencidas']}</td>
                <td>${row['dias_atraso']}</td>
                <td>${row['fecha_pago']}</td>
                <td>${row['hora_pago']}</td>
                </tr>`
              }else if (row['tipo_pago']== "Transferencia") {
                  htmlBody+=`<tr>
                <td>${row['id']}</td>
                <td>${"$"+row['pago']}</td>
                <td>${row['tipo_pago']= `<i class="far fa-credit-card" style="width:30px;"></i>`}</td>
                <td>${row['cuotas_vencidas']}</td>
                <td>${row['dias_atraso']}</td>
                <td>${row['fecha_pago']}</td>
                <td>${row['hora_pago']}</td>
                </tr>`
              } if (row['tipo_pago']== "N/P") {
                  htmlBody+=`<tr>
                <td>${row['id']}</td>
                <td>${"$"+row['pago']}</td>
                <td>${row['tipo_pago']}</td>
                <td>${row['cuotas_vencidas']}</td>
                <td>${row['dias_atraso']}</td>
                <td>${row['fecha_pago']}</td>
                <td>${row['hora_pago']}</td>
                </tr>`
              }
            });
          
          
        document.getElementById("tblHistoClientesG").innerHTML = htmlHeader + '<tbody>' + htmlBody + '</tbody>';
        $('#histo_cliente').modal('show');       
      }
    };
}
