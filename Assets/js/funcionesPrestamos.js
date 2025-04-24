let tblPrestamos, tblPrestamosTemp;
document.addEventListener("DOMContentLoaded", function () {
    //La variable tblClientes es igual a nuestra datatable. Tabla de los clientes
    tblPrestamosTemp = $("#tblPrestamosTemp").DataTable({
        ajax: {
            //Se manda al controlador Clientes y al método listarCliente
            url: base_url + "Prestamos/listarPrestamoTemp",
            dataSrc: ''
        },
        columns: [{
            'data': 'cliente'
        },
        {
            'data': 'cantidad'
        },
        {
            'data': 'total_pago'
        },
        {
            'data': 'acciones'
        }]
    });

    tblPrestamos = $("#tblPrestamos").DataTable({
        ajax: {
            //Se manda al controlador Clientes y al método listarCliente
            url: base_url + "Prestamos/listarPrestamo",
            dataSrc: ''
        },
        columns: [{
            'data': 'cliente'
        },
        {
            'data': 'cantidad'
        },
        {
            'data': 'total_pago'
        },
        {
            'data': 'acciones'
        }]
    });
})

////////////////////Funciones Clientes//////////////////
//Funcion modal
function frmPrestamo() {
    //Toma el id del h5 del modal del index Usuario y sustituye el título
    document.getElementById("title").innerHTML = "Nuevo Crédito";
    document.getElementById("btnAccion").innerHTML = "Registrar";

    //Se resetea el formulario para que no se muestren los datos ya registrados
    document.getElementById("frmPrestamos").reset();

    //Se muestra el modal
    $("#nuevo_prestamo").modal("show");

    //Se accede al id con document.getElementById() para poder limpiar los id de tipo hiden. Pasándolo vacío
    document.getElementById("id").value = "";
}


function calcularTotal() {
    var credito = document.getElementById("credito");
    var porcentaje = document.getElementById("porcentaje");
    var plazo = document.getElementById("plazo");
    var total = document.getElementById("total");
    var cantidad_dia = document.getElementById("cantidad_dia");
    
    var cantidad = credito.options[credito.selectedIndex].text.replace("$ ", "");
    var porcentajeValor = porcentaje.value / 100;
    var plazoPago = parseInt(plazo.value);
    var totalValor = parseFloat(cantidad) * (1 + porcentajeValor);
    var costoDiarioValor = totalValor / plazoPago;
    
    total.value = "$ " + totalValor.toFixed(2);
    cantidad_dia.value ="$ " + costoDiarioValor.toFixed(2);
    
    const fechaInicio = new Date();
    const fechaUltimoPago = new Date(fechaInicio.setDate(fechaInicio.getDate() + plazoPago));
    fechaUltimoPago.setDate(fechaUltimoPago.getDate() - 0); // Restamos un día para obtener la fecha del último pago
    const options = { day: 'numeric', month: 'numeric', year: 'numeric' };
    const fechaFormato = fechaUltimoPago.toLocaleDateString('es-MX', options);
    document.getElementById('fecha_final').value = fechaFormato;
  }
  
  document.addEventListener('DOMContentLoaded', function () {
    var plazoSelect = document.getElementById('plazo');
    plazoSelect.addEventListener('change', function () {
      calcularTotal();
    });
  });


function registrarPrestamo(e) {
    e.preventDefault();
    
    const cliente = document.getElementById("cliente");
    const cantidad = document.getElementById("credito");
    const porcentaje = document.getElementById("porcentaje").value;
    const total = document.getElementById("total").value;
    const plazo = document.getElementById("plazo").value;
    const cantidad_dia = document.getElementById("cantidad_dia").value;
    const fecha_inicio = document.getElementById("fecha_inicio").value;
    const fecha_final = document.getElementById("fecha_final").value;
    const hora_prestamo = document.getElementById("hora_prestamo").value;
    const grupo = document.getElementById("grupo").value;
    const id = document.getElementById("id").value;
    calcularTotal();
    console.log("id cliente", cliente);
    console.log("Cantidad:", cantidad);
    console.log("Total: ", total);
    console.log("Plazo:", plazo);
    console.log("Cantidad dia:",cantidad_dia);
    console.log("Inicio: ",fecha_inicio);
    console.log("Final: ",fecha_final);
    console.log("Hora: ",hora_prestamo);
    console.log("id_grupo:", grupo);
    console.log("id:", id);
    if (cliente.value == "" || cantidad.value == "" || porcentaje.value == "" || total.value == "" || plazo.value == "" || cantidad_dia.value == "" || fecha_inicio.value == "" || fecha_final.value == "" || hora_prestamo.value == "" || grupo.value == "") {
        
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Todos los campos son obligatorios',
            showConfirmButton: false,
            timer: 3000
        })
    } else {  
        const url = base_url + "Prestamos/registrar";
        
        const frm = document.getElementById("frmPrestamos");
        
        const http = new XMLHttpRequest();

        http.open("POST", url, true);
        
        http.send(new FormData(frm));
        
        ///Permanente
        http.onreadystatechange = function () {
            
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                console.log(this.responseText);
                if (res == "si") {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Crédito registrado con éxito',
                        showConfirmButton: false,
                        timer: 3000
                    })
                    frm.reset();
                    
                    $("#nuevo_prestamo").modal("hide");

                    tblPrestamosTemp.ajax.reload();

                    
                } else if (res == "modificado") {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Crédito modificado con éxito',
                        showConfirmButton: false,
                        timer: 3000
                    })

                    
                    $("#nuevo_prestamo").modal("hide");

                    tblPrestamosTemp.ajax.reload();

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
function btnEditarPrestamo(id) {
    //Toma el id del h5 del modal del index Usuario y sustituye el título
    document.getElementById("title").innerHTML = "Crédito del cliente";
    document.getElementById("btnAccion").innerHTML = "Modificar";
    
    //Mostrar los datos reistrados para modificar los datos
    //Se crea una constante que almacena la url y concatena con el controlador Usuarios y su método editar y se concatena el parárametro que su colocó en dentro de la función
    const url = base_url + "Prestamos/editar/" + id;
    //Se crea una constante y se crea una nueva instancia del objeto XMLHttpRequest
    const http = new XMLHttpRequest();
    //Se crea una condición Por el método GET, que se recibe lo que contiene la url y que se ejecuta de forma asincrona(booleana)
    http.open("GET", url, true);
    //Se envía la petición, siendo nueva con un FormData y dentro de ella la constante en este caso el frm 
    http.send();
    //Se verifica el estado por medio de un onreadystatechange. El onreadystatechange se va a estar ejecutando cada vez que el state change esté cambiando 
    http.onreadystatechange = function () {
        //validación. Si el estatus es igual a 200 la respuesta está lista.
        if (this.readyState == 4 && this.status == 200) {
            //Se convierte el mensaje a un JSON
            console.log(this.responseText);
            const res = JSON.parse(this.responseText);
            ////Se almacena los datos obtenidos accediendo a los documents para traer el id del input del index o vista. Y se le agrega la propiedad value donde será igual a la respuesta o lo que traiga del objeto JSON, concatenando a lo que se desea acceder de la bd
            document.getElementById("id").value = res.id;
            document.getElementById("id_ruta").value = res.id_ruta;

            //Se lamacena los datos obtenidos accediendo a los documents para traer los id de cada input del index o vista. Y se le agrega la propiedad value donde será igual a la respuesta o lo que traiga del objeto JSON, concatenando a lo que se desea acceder de la bd 
            document.getElementById("cliente").value = res.id_cliente;
            document.getElementById("porcentaje").value = res.porcentaje;
            document.getElementById("total").value = "$"+""+res.total_pago;
            document.getElementById("plazo").value = res.plazo;
            document.getElementById("cantidad_dia").value = "$"+""+res.cantidad_dias;
            document.getElementById("fecha_inicio").value = res.fecha_inicial;
            document.getElementById("fecha_final").value = res.fecha_final;
            document.getElementById("hora_prestamo").value = res.hora_prestamo;
            document.getElementById("grupo").value = res.id_grupo;
            document.getElementById("saldo").value = res.saldo;

            //Se muestra el modal
            $("#nuevo_prestamo").modal("show");
        }
    }
}

function btnPago(id) {
    //Toma el id del h5 del modal del index Usuario y sustituye el título
    document.getElementById("title").innerHTML = "Información del cliente";

    //Mostrar los datos reistrados para modificar los datos
    //Se crea una constante que almacena la url y concatena con el controlador Usuarios y su método editar y se concatena el parárametro que su colocó en dentro de la función
    const url = base_url + "Prestamos/infoCliente/" + id;
    //Se crea una constante y se crea una nueva instancia del objeto XMLHttpRequest
    const http = new XMLHttpRequest();
    //Se crea una condición Por el método GET, que se recibe lo que contiene la url y que se ejecuta de forma asincrona(booleana)
    http.open("GET", url, true);
    //Se envía la petición, siendo nueva con un FormData y dentro de ella la constante en este caso el frm 
    http.send();
    //Se verifica el estado por medio de un onreadystatechange. El onreadystatechange se va a estar ejecutando cada vez que el state change esté cambiando 
    http.onreadystatechange = function () {
        //validación. Si el estatus es igual a 200 la respuesta está lista.
        if (this.readyState == 4 && this.status == 200) {
            //Se convierte el mensaje a un JSON
            const res = JSON.parse(this.responseText);
            ////Se almacena los datos obtenidos accediendo a los documents para traer el id del input del index o vista. Y se le agrega la propiedad value donde será igual a la respuesta o lo que traiga del objeto JSON, concatenando a lo que se desea acceder de la bd
            document.getElementById("id_cliente").value = res.id_cliente;
            document.getElementById("id_prestamo").value = res.id_prestamo;
            document.getElementById("id_grupo").value = res.id_grupo;
            document.getElementById("id_saldo")

            //Se lamacena los datos obtenidos accediendo a los documents para traer los id de cada input del index o vista. Y se le agrega la propiedad value donde será igual a la respuesta o lo que traiga del objeto JSON, concatenando a lo que se desea acceder de la bd
            document.getElementById("clientes").value = res.cliente;
            document.getElementById("apellidos").value = res.apellidos;
            document.getElementById("total_pagos").value = res.total_pago;
            document.getElementById("grupos").value = res.grupo;
            document.getElementById("cantidad_dias").value = res.cantidad_dias;
            document.getElementById("fecha_inicial").value = res.fecha_inicial;
            document.getElementById("fecha_finals").value = res.fecha_final;
            document.getElementById("saldo1").value = res.saldo;
            document.getElementById("saldo_vencido").value = res.saldo_vencido;

            //Se muestra el modal
            $("#info_cliente").modal("show");
        }
    }
}

function adelantarPagos(e) {
    e.preventDefault();
    
    const pago = document.getElementById("pago").value;
    const tipo_pago = document.getElementById("tipo_pago").value;
    const saldo = document.getElementById("saldo1").value;
    const id_cliente = document.getElementById("id_cliente").value
    const id_prestamo = document.getElementById("id_prestamo").value
    const id_grupo = document.getElementById("id_grupo").value;
    const saldo_vencido = document.getElementById("saldo_vencido").value;
    const fecha_pago = document.getElementById("fecha_pago");
    const hora_pago = document.getElementById("hora_pago");

    if (id_cliente == "" || id_prestamo == "" || id_grupo == "" || pago == "" || tipo_pago == "" || fecha_pago == "" || hora_pago == "" || saldo == "" || saldo_vencido == "") {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Todos los campos son obligatorios',
            showConfirmButton: false,
            timer: 3000
        })
    } else {  
        const url = base_url + "Prestamos/registrarPagosAdelanto";
        
        const frm = document.getElementById("frmAdelantoPagos");
        
        const http = new XMLHttpRequest();

        http.open("POST", url, true);
        
        http.send(new FormData(frm));
        
        ///Permanente
        http.onreadystatechange = function () {
            
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                console.log(this.responseText);
                if (res == "si") {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Pago registrado con éxito',
                        showConfirmButton: false,
                        timer: 3000
                    })
                
                    frm.reset();
                    
                    $("#info_cliente").modal("hide");

                    tblPrestamos.ajax.reload();

                    
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
