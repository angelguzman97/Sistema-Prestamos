let tblClientesG, tblHistoClientesG;
document.addEventListener("DOMContentLoaded", function () {
    //La variable tblClientes es igual a nuestra datatable. Tabla de los clientes
    tblClientesG = $("#tblClientesG").DataTable({
        ajax: {
            //Se manda al controlador Clientes y al método listarCliente
            url: base_url + "ClientesG/listarClientesG",
            dataSrc: ''
        },
        columns: [{
            'data': 'cliente'
        }, {
            'data': 'total_pago'
        },
        {
            'data':'saldo'
        },
        {
            'data':'ruta'
        },
        {
            'data': 'estado'
        },
        {
            'data': 'acciones'
        }]
    });

})

////////////////////Funciones Clientes//////////////////
//Funcion modal
function frmCliente() {
    //Toma el id del h5 del modal del index Usuario y sustituye el título
    document.getElementById("title").innerHTML = "Nuevo cliente";
    document.getElementById("btnAccion").innerHTML = "Registrar";

    //Se resetea el formulario para que no se muestren los datos ya registrados
    document.getElementById("frmClientes").reset();

    //Se muestra el modal
    $("#info_cliente").modal("show");
    $("#tblHistoClientesG").modal("show");

    //Se accede al id con document.getElementById() para poder limpiar los id de tipo hiden. Pasándolo vacío
    document.getElementById("id").value = "";

    //Se llama a la unción de eliminar imagen de la previsualización y así limpiar el FILES
    deleteImg();
}

//Función para el botón editar cliente que recibe un parámetro id. Se mandará a llamar en el controlador usuario. En los botones de listar usuarios. 
function btnInfoCliente(id) {
    //Toma el id del h5 del modal del index Usuario y sustituye el título
    document.getElementById("title").innerHTML = "Información del cliente";

    //Mostrar los datos reistrados para modificar los datos
    //Se crea una constante que almacena la url y concatena con el controlador Usuarios y su método editar y se concatena el parárametro que su colocó en dentro de la función
    const url = base_url + "ClientesG/infoCliente/" + id;
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
            console.log(res.total_pago);

                    //Se lamacena los datos obtenidos accediendo a los documents para traer los id de cada input del index o vista. Y se le agrega la propiedad value donde será igual a la respuesta o lo que traiga del objeto JSON, concatenando a lo que se desea acceder de la bd
                    document.getElementById("cliente").value = res.cliente;
                    document.getElementById("apellidos").value = res.apellidos;
                    document.getElementById("edad").value = res.edad;
                    document.getElementById("telefono").value = res.telefono;
                    document.getElementById("direccion").value = res.direccion;
                    document.getElementById("trabajo").value = res.trabajo;
                    
                    //Para mostrar también la foto del producto que se desea modificar. Se trae por su id con su atributo src. Y para evitar problemas se concatena la base_url + la carpeta donde se almacena + la respuesta  del campo de la base de datos
                    document.getElementById("img-preview").src = base_url + 'Assets/img/' + res.foto;
                    
                    document.getElementById("fecharegistro").value = res.fecha_registro;
                    document.getElementById("hora_cliente").value = res.hora_cliente;

                    document.getElementById("id").value = res.id_cliente;
                    document.getElementById("total_pago").value = res.total_pago;
                    document.getElementById("grupo").value = res.grupo;
                    document.getElementById("cantidad_dias").value = res.cantidad_dias;
                    document.getElementById("fecha_inicial").value = res.fecha_inicial;
                    document.getElementById("fecha_final").value = res.fecha_final;
                    document.getElementById("saldo").value = res.saldo;
                    document.getElementById("dias_atraso").value = res.dias_atraso;
                    document.getElementById("cuotas_vencidas").value = res.cuotas_vencidas;
                    document.getElementById("saldo_vencido").value = res.saldo_vencido;
                    if (res.total_pago == undefined && res.grupo == undefined && res.cantidad_dias == undefined && res.fecha_inicial == undefined && 
                        res.fecha_final == undefined && res.saldo == undefined && res.dias_atraso == undefined && res.cuotas_vencidas == undefined
                        && res.saldo_vencido == undefined) {
                    document.getElementById("id").value = res.id;

                    //Se lamacena los datos obtenidos accediendo a los documents para traer los id de cada input del index o vista. Y se le agrega la propiedad value donde será igual a la respuesta o lo que traiga del objeto JSON, concatenando a lo que se desea acceder de la bd
                    document.getElementById("cliente").value = res.cliente;
                    document.getElementById("apellidos").value = res.apellidos;
                    document.getElementById("edad").value = res.edad;
                    document.getElementById("telefono").value = res.telefono;
                    document.getElementById("direccion").value = res.direccion;
                    document.getElementById("trabajo").value = res.trabajo;
                    
                    //Para mostrar también la foto del producto que se desea modificar. Se trae por su id con su atributo src. Y para evitar problemas se concatena la base_url + la carpeta donde se almacena + la respuesta  del campo de la base de datos
                    document.getElementById("img-preview").src = base_url + 'Assets/img/' + res.foto;
                    
                    document.getElementById("fecharegistro").value = res.fecha_registro;
                    document.getElementById("hora_cliente").value = res.hora_cliente;

                    document.getElementById("total_pago").value = 0;
                    document.getElementById("grupo").value = 0;
                    document.getElementById("cantidad_dias").value = 0;
                    document.getElementById("fecha_inicial").value = "sin fecha";
                    document.getElementById("fecha_final").value = "sin fecha";
                    document.getElementById("saldo").value = 0;
                    document.getElementById("dias_atraso").value = 0;
                    document.getElementById("cuotas_vencidas").value = 0;
                    document.getElementById("saldo_vencido").value = 0;

                        }

        

            //Se muestra el modal
            $("#info_cliente").modal("show");
        }
    }
}
//Función para el botón editar cliente que recibe un parámetro id. Se mandará a llamar en el controlador usuario. En los botones de listar usuarios. 
function btnHistorialCliente(id) {
    const url = base_url + 'ClientesG/histoClientesG/' + id;
    const http = new XMLHttpRequest();
    http.open('GET', url, true);
    http.send();
    http.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        // console.log(this.responseText);
        let htmlHeader = `<thead class="thead table-dark w-50"><tr>
        <th>ID</th>
        <th>Pagos</th>
        <!-- <th>tipo</th> -->
        <th>C</th>
        <th>A</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th></th>
        </tr></thead>`;
        let htmlBody = '';
            res.forEach(row => {
            // if (row['tipo_pago']== "Efectivo") {   
            htmlBody+=`<tr>
            <td>${row['id']}</td>
            <td>${"$"+row['pago']}</td>
            <!-- <td>${row['tipo_pago']= `<i class="fas fa-coins" style="width:30px;"></i>`}</td> -->
            <td>${row['cuotas_vencidas']}</td>
            <td>${row['dias_atraso']}</td>
            <td>${row['fecha_pago']}</td>
            <td>${row['hora_pago']}</td>
            <td><button class="btn btn-danger" type="button" onclick="btnBorrarPagoId('${row['id']}')"><i class="fas fa-trash"></i></button></td>
            </tr>`
            // }else if (row['tipo_pago']== "Transferencia") {
            //     htmlBody+=`<tr>
            // <td>${row['id']}</td>
            // <td>${"$"+row['pago']}</td>
            // <td>${row['tipo_pago']= `<i class="far fa-credit-card" style="width:30px;"></i>`}</td>
            // <td>${row['cuotas_vencidas']}</td>
            // <td>${row['dias_atraso']}</td>
            // <td>${row['fecha_pago']}</td>
            // <td>${row['hora_pago']}</td>
            // <td><button class="btn btn-danger" type="button" onclick="btnBorrarPagoId('${row['id']}')">Borrar</button></td>
            // </tr>`
            // } if (row['tipo_pago']== "N/P") {
            //     htmlBody+=`<tr>
            // <td>${row['id']}</td>
            // <td>${"$"+row['pago']}</td>
            // <td>${row['tipo_pago']}</td>
            // <td>${row['cuotas_vencidas']}</td>
            // <td>${row['dias_atraso']}</td>
            // <td>${row['fecha_pago']}</td>
            // <td>${row['hora_pago']}</td>
            // <td><button class="btn btn-danger" type="button" onclick="btnBorrarPagoId('${row['id']}')">Borrar</button></td>
            // </tr>`
            // }
            });
        
        
        document.getElementById("tblHistoClientesG").innerHTML = htmlHeader + '<tbody>' + htmlBody + '</tbody>';
        $('#histo_cliente').modal('show');       
    }
    };
}


//Función para el botón eliminar usuarios
function btnBorrarCredito(id) {
    Swal.fire({
        title: '¿Está seguro de eliminar?',
        text: "¡Se borrará el crédito del cliente!",
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
            const url = base_url + "ClientesG/eliminarCredito/" + id;
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
                    const res = JSON.parse(this.responseText);
                        
                    //Se hace una validación
                    if (res == "ok") {
                        //Si es igual a "ok". Muestra el mensaje
                        Swal.fire(
                            '¡Eliminado!',
                            'Crédito eliminado con éxito.',
                            'success'
                        )
                        //Se llama a la variable de la tabla para recarga la página después de registrar un usuario por medio de AJAX
                        tblClientesG.ajax.reload();
                    } else {
                        //Si no es igual a "ok". Muestra el mensaje
                        Swal.fire(
                            '¡Cambiado!',
                            res,
                            'error'
                        )
                    }
                }
            }

        }
    })
}

//Función para el botón eliminar usuarios
function btnEliminarCliente(id) {
    Swal.fire({
        title: '¿Está seguro de eliminar?',
        text: "¡El cliente no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
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
            const url = base_url + "Clientes/eliminar/" + id;
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
                    const res = JSON.parse(this.responseText);

                    //Se hace una validación
                    if (res == "ok") {
                        //Si es igual a "ok". Muestra el mensaje
                        Swal.fire(
                            '¡Cambiado!',
                            'Cliente eliminado con éxito.',
                            'success'
                        )
                        //Se llama a la variable de la tabla para recarga la página después de registrar un usuario por medio de AJAX
                        tblClientesG.ajax.reload();
                    } else {
                        //Si no es igual a "ok". Muestra el mensaje
                        Swal.fire(
                            '¡Cambiado!',
                            res,
                            'error'
                        )
                    }
                }
            }

        }
    })
}

//Función para el botón reingresar usuarios y secrea una función similar en el controlador usuarios
function btnReingresarCliente(id) {
    Swal.fire({
        title: '¿Está seguro de reingresar?',
        text: "¡El usuario no se reingresará de forma permanente, solo cambiará el estado a activo!",
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
            const url = base_url + "Clientes/reingresar/" + id;
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
                    const res = JSON.parse(this.responseText);
                    console.log(res.responseText);

                    //Se hace una validación
                    if (res == "ok") {
                        //Si es igual a "ok". Muestra el mensaje
                        Swal.fire(
                            '¡Cambiado!',
                            'Cliente reingresado con éxito.',
                            'success'
                        )
                        //Se llama a la variable de la tabla para recarga la página después de registrar un usuario por medio de AJAX
                        tblClientesG.ajax.reload();
                    } else {
                        //Si no es igual a "ok". Muestra el mensaje
                        Swal.fire(
                            '¡Cambiado!',
                            res,
                            'error'
                        )
                    }
                }
            }

        }
    })
}

//Función para previsualizar fotos del producto. Esta función se llama en el index o donde se desea previsualizar una foto
function preview(e) {
    //Se almacena en una constante url. Indicando el indice donde se encuentra [0]
    const url = e.target.files[0];
    //Se almacena en una constante urlTmp (URL Temporal) dentro de esa constante, se crea una URL objeto con la palabra reservada createObjectURL. Donde se le pasa a la url o constante anterior .
    const urlTmp = URL.createObjectURL(url);
    //Se accede a la etiqueta mediante su id junto con su atributo src. Y se le pasa a la urlTmp (Constante anterior). 
    document.getElementById("img-preview").src = urlTmp;

    //Se accede a la etiqueta mediante su id y se le agrega una clase de bootstrap .add("d-none") para que oculte el botón después de mostrar la imagen. 
    document.getElementById("icon-image").classList.add("d-none");

    //Se accede a la etiqueta span mediante su id  y se le agrega un boton con código HTML (innerHTML). Y para mostrar el mombre la imagen después del botón se le coloca el ${} y dentro de ello se le coloca la constante url indicándole que se requiere el indice nombre['name']
    document.getElementById("icon-cerrar").innerHTML = `<button class="btn btn-danger" onclick = "deleteImg();"><i class="fas fa-times"></i></button>
    ${url['name']}`;
}

//Función del botón para que desaparezca la imagen que se previsualiza
function deleteImg() {
    //primero se limpia la imagen. Enviándole un vacío
    document.getElementById("icon-cerrar").innerHTML = '';

    //Se accede a la etiqueta mediante su id y se le agrega una clase de bootstrap .remove("d-none") para que quite la clase que se agregó y aparezca el botón después de quitar la imagen. 
    document.getElementById("icon-image").classList.remove("d-none");

    //Se accede a la etiqueta mediante su id junto con su atributo src. Y se le pasa un vacío para quitar la imagen previsualizada. 
    document.getElementById("img-preview").src = '';

    //Se accede a la etiqueta input por su id con el value, y se le pasa un vacío para que no guarde en la base de datos
    document.getElementById("imagen").value = '';

    //Se accede a la etiqueta input oculto por su id con el value, y se le pasa un vacío para comprobar que se quitó
    document.getElementById("foto_actual").value = '';
}


function btnBorrarPagoId(id) {
    Swal.fire({
        title: '¿Está seguro de eliminar?',
        text: "¡Se borrará el pago del cliente!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí!',
        cancelButtonText: '¡No!'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "ClientesG/eliminarPagoID/" + id;

            fetch(url)
                .then(response => response.json())
                .then(res => {
                    if (res === "ok") {
                        Swal.fire(
                            '¡Eliminado!',
                            'Pago eliminado con éxito.',
                            'success'
                        );
                        tblClientesG.ajax.reload();
                    } else {
                        Swal.fire(
                            '¡Error!',
                            res,
                            'error'
                        );
                    }
                    
                })
                .catch(error => {
                    Swal.fire(
                        '¡Ups!',
                        'Hubo un error al intentar eliminar el pago.',
                        'error'
                    );
                    console.error('Error:', error);
                });
        }
    });
    
}
