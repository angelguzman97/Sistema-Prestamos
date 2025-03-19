let tblPagosDia, tblReportes;
document.addEventListener("DOMContentLoaded", function () {
    //La variable tblClientes es igual a nuestra datatable. Tabla de los clientes
    tblPagosDia = $("#tblPagosDia").DataTable({
        ajax: {
            //Se manda al controlador Clientes y al método listarReportes
            url: base_url + "Reportes/listarPagosDia",
            dataSrc: ''
        },
        columns: [{
            'data': 'id'
        },
        {
            'data': 'fecha'
        },
        {
            'data': 'hora'
        },
        {
            'data': 'acciones'
        }
    ]
    });
    tblReportes = $("#tblReportes").DataTable({
        ajax: {
            //Se manda al controlador Clientes y al método listarReportes
            url: base_url + "Reportes/listarReportes",
            dataSrc: ''
        },
        columns: [{
            'data': 'id'
        },
        {
            'data': 'caja_real'
        },
        {
            'data': 'fecha_reporte'
        },
        {
            'data': 'hora_reporte'
        },
        {
            'data': 'acciones'
        }
    ]
    });

    
})




function frmCuadre() {
    //Toma el id del h5 del modal del index Usuario y sustituye el título
    document.getElementById("title").innerHTML = "Nuevo Reporte";
    document.getElementById("btnAccion").innerHTML = "Registrar";

    //Se resetea el formulario para que no se muestren los datos ya registrados
    document.getElementById("frmPagosDia").reset();

    document.getElementById("btnPDF").classList.add("d-none");

    //Se muestra el modal
    $("#nuevo_reporte").modal("show");

    //Se accede al id con document.getElementById() para poder limpiar los id de tipo hiden. Pasándolo vacío
    document.getElementById("id").value = "";
}


function registrarCuadre(e) {
    e.preventDefault();
    
    const clientes_programados = document.getElementById("clientes_programados").value;
    const clientes_visitados = document.getElementById("clientes_visitados").value;
    const clientes_pendientes = document.getElementById("clientes_pendientes").value;
    const caja_inicial = document.getElementById("caja_inicial").value;
    const cobrado = document.getElementById("cobrado").value;
    const prestamo = document.getElementById("prestamo").value;
    const caja_final = document.getElementById("caja_final").value;
    const fecha = document.getElementById("fecha");
    const hora = document.getElementById("hora");
    

    if (clientes_programados.value == "" || clientes_visitados.value == "" || clientes_pendientes.value == "" || caja_inicial.value == "" || cobrado.value == "" || prestamo.value == "" || caja_final.value == "" || fecha.value == "" || hora.value == "") {
        
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Todos los campos son obligatorios',
            showConfirmButton: false,
            timer: 3000
        })
    } 
    else {  
        const url = base_url + "Reportes/registrarPagoDia";
               
        const frm = document.getElementById("frmPagosDia");
               
        const http = new XMLHttpRequest();

        http.open("POST", url, true);

        http.send(new FormData(frm));
    
        http.onreadystatechange = function () {
            
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                console.log(this.responseText);

                if (res == "si") {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Cuadre guardado con éxito',
                        showConfirmButton: false,
                        timer: 3000
                    });
                   
                    frm.reset();
                    $("#nuevo_reporte").modal("hide");
                    tblPagosDia.ajax.reload();

                }else if (res == "modificado") {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Cuadre modificado con éxito',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    //Ocultar el modal
                    $("#nuevo_reporte").modal("hide");

                    //Se llama a la variable de la tabla para recarga la página después de registrar un usuario por medio de AJAX
                    tblPagosDia.ajax.reload();


                }else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: res,
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            }
        }
    }
}

function btnEditarCuadre(id) {
    //Toma el id del h5 del modal del index Usuario y sustituye el título
    document.getElementById("title").innerHTML = "Actualizar Reporte";
    document.getElementById("btnAccion").innerHTML = "Modificar";
    document.getElementById("btnPDF").classList.remove("d-none");
    //Mostrar los datos reistrados para modificar los datos
    //Se crea una constante que almacena la url y concatena con el controlador Usuarios y su método editar y se concatena el parárametro que su colocó en dentro de la función
    const url = base_url + "Reportes/editar/" + id;
    
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
            document.getElementById("id").value = res.id;

            //Se lamacena los datos obtenidos accediendo a los documents para traer los id de cada input del index o vista. Y se le agrega la propiedad value donde será igual a la respuesta o lo que traiga del objeto JSON, concatenando a lo que se desea acceder de la bd 
           
            document.getElementById("gastos").value = res.gastos;
            document.getElementById("tipo_gastos").value = res.tipo_gastos;
            document.getElementById("inversion").value = res.inversion;
            document.getElementById("tipo_inversion").value = res.tipo_inversion;
            document.getElementById("caja_final").value = res.caja_final;
            
            

            //Se muestra el modal
            $("#nuevo_reporte").modal("show");
        }
    }
}

function generarPDF() {
    Swal.fire({
        title: '¿Está seguro de realizar el reporte en PDF?',
        text: "¡Una vez generado el PDF ya no se podrá modificar!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí!',
        //Este botón se le agregó y es para el botón NO
        cancelButtonText: '¡No!'
    }).then((result) => {
        if (result.isConfirmed) {
            //Cambiar el estado de activo a inactivo y viceversa
            //Se crea una constante que almacena la url y concatena con el controlador Usuarios y su método eliminar y se concatena el parárametro que su colocó en dentro de la función
            const url = base_url + "Reportes/registrarReporte";
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
                    //Se parsea la respuesta y se le pasa al responseText
                    console.log(this.responseText);
                    const res = JSON.parse(this.responseText);
                    //Se hace una validación. Y como la respuesta es un arreglo hay que indicar el campo que se desea obtener
                    if (res.msg == 'ok') {
                        //Si es igual a "ok". Muestra el mensaje
                        Swal.fire(
                            '¡Mensaje!',
                            'Reporte generado.',
                            'success'
                        )
                        //Se crea una constante para crear la ruta del y generar el PDF. Indicando la ruta, el controlador, su método y su parámetro
                        const ruta = base_url + 'Reportes/generarPDF/' + res.id_reporte;
                        //Con windows.open() es para acceder a la ruta anterior
                        window.open(ruta);
                        //Recagar la página
                        setTimeout(() => {
                            window.location.reload();
                        }, 300);//<- Despúes de 3 seg. recargue la pág.
                    } else {
                        //Si no es igual a "ok". Muestra el mensaje
                        Swal.fire(
                            '¡Mensaje!',
                            res,
                            'error'
                        )
                    }
                }
            }

        }
    })
}
