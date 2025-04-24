let tblRutas;
document.addEventListener("DOMContentLoaded", function () {

    //La variable tblRutas es igual a nuestra datatable. Tabla de los empleados 
    //La variable tblClientes es igual a nuestra datatable. Tabla de los clientes
    tblRutas = $("#tblRutas").DataTable({
        ajax: {
            //Se manda al controlador Clientes y al método listarCliente
            url: base_url + "Rutas/listarRutas",
            dataSrc: ''
        },
        columns: [{
            'data': 'ruta'
        },
        {
            'data': 'estado'
        },
        {
            'data': 'acciones'
        }]
    });
})


//Funcion modal para registrar Ruta
function frmRuta() {
    //Toma el id del h5 del modal del index Ruta y sustituye el título
    document.getElementById("title").innerHTML = "Nueva ruta";
    document.getElementById("btnAccion").innerHTML = "Registrar";
    //Se accede al document para traer el id y se le quita una clase de bootstrap para ocultatlos con d-none que es propiedad de boostrap y así ocultar esa parte
    document.getElementById("clave_actual").classList.add("d-none");
    document.getElementById("fecha_caja").classList.add("d-none");

    //Se resetea el formulario para que no se muestren los datos ya registrados
    document.getElementById("frmRutas").reset();

    //Se muestra el modal
    $("#nueva_ruta").modal("show");

    //Se accede al id con document.getElementById() para poder limpiar los id de tipo hiden. Pasándolo vacío
    document.getElementById("id").value = "";
}

//Función para registrar y modificar rutas
function registrarRuta(e) {
    e.preventDefault();
    //Se crea la constante donde accede a los id de cada input del index o vista y los almacena en él
    const ruta = document.getElementById("ruta");
    const nombre = document.getElementById("nombre");
    const telefono = document.getElementById("telefono");

    if (ruta.value == "" || nombre.value == "" || telefono.value == "") {
        //SweetAlert2. Su ruta está en el footer dentro de templates de Views. Es una alerta
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Todos los campos son obligatorios',
            showConfirmButton: false,
            timer: 3000
        })
    } else { //< petición mediante AJAX usando el xml request
        //Se crea una constante que almacena la url y concatena con el controlador Rutas y su método registrar 
        const url = base_url + "Rutas/registrar";
        //Se crea una constante donde se almacena el id del formulario de registrar rutas
        const frm = document.getElementById("frmRutas");
        //Se crea una constante y se crea una nueva instancia del objeto XMLHttpRequest
        const http = new XMLHttpRequest();
        //Se crea una condición Por el método POST, se le envía una url y que se ejecuta de forma asincrona(booleana)
        http.open("POST", url, true);
        //Se envía la petición, siendo nueva con un FormData y dentro de ella la constante en este caso el frm 
        http.send(new FormData(frm));
        //Se verifica el estado por medio de un onreadystatechange. El onreadystatechange se va a estar ejecutando cada vez que el state change esté cambiando 
        http.onreadystatechange = function () {
            //validación. Si el estatus es igual a 200 la respuesta está lista.
            if (this.readyState == 4 && this.status == 200) {
                //Se convierte el mensaje a un JSON
                const res = JSON.parse(this.responseText);
                if (res == "si") {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Ruta registrada con éxito',
                        showConfirmButton: false,
                        timer: 3000
                    })
                    //Reseteo de formulario
                    frm.reset();
                    //Ocultar el modal
                    setTimeout(() => {
                        window.location.reload();
                    }, 300);//<- Despúes de 3 seg. recargue la pág.

                    $("#nueva_ruta").modal("hide");


                    //Se verifica si res es igual al mensaje modificado del controlador
                } else if (res == "modificado") {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Ruta modificada con éxito',
                        showConfirmButton: false,
                        timer: 3000
                    })

                    //Se llama a la variable de la tabla para recarga la página después de registrar un usuario por medio de AJAX
                    tblRutas.ajax.reload();
                    //Ocultar el modal
                    $("#nueva_ruta").modal("hide");



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


function btnEditarRuta(id) {
    //Toma el id del h5 del modal del index Usuario y sustituye el título
    document.getElementById("title").innerHTML = "Actualizar ruta";
    document.getElementById("btnAccion").innerHTML = "Modificar";

    //Mostrar los datos reistrados para modificar los datos
    //Se crea una constante que almacena la url y concatena con el controlador Usuarios y su método editar y se concatena el parárametro que su colocó en dentro de la función
    const url = base_url + "Rutas/editar/" + id;
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
            console.log(this.responseText);
            ////Se almacena los datos obtenidos accediendo a los documents para traer el id del input del index o vista. Y se le agrega la propiedad value donde será igual a la respuesta o lo que traiga del objeto JSON, concatenando a lo que se desea acceder de la bd
            document.getElementById("id").value = res.id;

            //Se lamacena los datos obtenidos accediendo a los documents para traer los id de cada input del index o vista. Y se le agrega la propiedad value donde será igual a la respuesta o lo que traiga del objeto JSON, concatenando a lo que se desea acceder de la bd 
            document.getElementById("ruta").value = res.ruta;
            document.getElementById("nombre").value = res.nombre;
            document.getElementById("telefono").value = res.telefono;
            document.getElementById("contrasena").value = res.clave;
            document.getElementById("caja").value = res.caja_inicial;
            document.getElementById("fecha_ruta").value = res.fecha_ruta;
            
            document.getElementById("img-preview").src = base_url + 'Assets/img/' + res.foto;

            document.getElementById("icon-cerrar").innerHTML = '<button class="btn btn-danger" onclick = "deleteImg();"><i class="fas fa-times"></i></button>';
            //Ocultar botón de agregar foto mientras haya foto
            document.getElementById("icon-image").classList.add("d-none");

            //Se capturan los id de los inputs ocultos y se les da el mismo valor para saber si se cambió o no o si se eliminó la foto
            document.getElementById("foto_actual").value = res.foto;


            document.getElementById("clave_actual").classList.remove("d-none");
            document.getElementById("fecha_caja").classList.remove("d-none");
            

            //Se muestra el modal
            $("#nueva_ruta").modal("show");
        } 
    }
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

//Función para el botón eliminar rutas
function btnRetirarCaja(id) {
    Swal.fire({
        title: '¿Está seguro de retirar la caja?',
        text: "¡Ya no aparecerá la caja anterior!",
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
            //Se crea una constante que almacena la url y concatena con el controlador Rutas y su método eliminar y se concatena el parárametro que su colocó en dentro de la función
            const url = base_url + "Rutas/retirarCaja/" + id;
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
                    console.log(this.responseText);
                    //Se hace una validación
                    if (res == "ok") {
                        //Si es igual a "ok". Muestra el mensaje
                        Swal.fire(
                            '¡Retirado!',
                            'Caja retirada con éxito.',
                            'success'
                        )
                        //Se llama a la variable de la tabla para recarga la página después de registrar un ruta por medio de AJAX
                        tblRutas.ajax.reload();
                    } else {
                        //Si no es igual a "ok". Muestra el mensaje
                        Swal.fire(
                            '¡Retirado!',
                            res,
                            'error'
                        )
                    }
                }
            }

        }
    })


}

//Función para el botón eliminar rutas
function btnEliminarUser(id) {
    Swal.fire({
        title: '¿Está seguro de desactivar?',
        text: "¡La ruta solo cambiará el estado a inactivo!",
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
            //Se crea una constante que almacena la url y concatena con el controlador Rutas y su método eliminar y se concatena el parárametro que su colocó en dentro de la función
            const url = base_url + "Rutas/eliminar/" + id;
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
                            'Ruta eliminado con éxito.',
                            'success'
                        )
                        //Se llama a la variable de la tabla para recarga la página después de registrar un ruta por medio de AJAX
                        tblRutas.ajax.reload();
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


//Función para el botón reingresar rutas y secrea una función similar en el controlador rutas
function btnReingresarUser(id) {
    Swal.fire({
        title: '¿Está seguro de reingresar?',
        text: "¡La ruta solo cambiará el estado a activo!",
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
            //Se crea una constante que almacena la url y concatena con el controlador Rutas y su método eliminar y se concatena el parárametro que su colocó en dentro de la función
            const url = base_url + "Rutas/reingresar/" + id;
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
                            'Ruta reingresado con éxito.',
                            'success'
                        )
                        //Se llama a la variable de la tabla para recarga la página después de registrar un ruta por medio de AJAX
                        tblRutas.ajax.reload();
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

///////////////////Lista de clientes de las rutas///////////////////////
//Función para el botón editar cliente que recibe un parámetro id. Se mandará a llamar en el controlador usuario. En los botones de listar usuarios. 
function btnListaCliente(id) {
    const url = base_url + 'Rutas/listaClientes/' + id;
    const http = new XMLHttpRequest();
    http.open('GET', url, true);
    http.send();
    http.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        console.log(this.responseText);
        let htmlHeader = `<thead class="thead table-dark"><tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Estado</th>
        <th>Fecha</th>
        </tr></thead>`;
        let htmlBody = '';
            res.forEach(row => {
                if (row['estado']==1) {
                    
                    htmlBody+=`<tr>
                    <td>${row['id']}</td>
                    <td>${row['cliente']}</td>
                    <td>${row['estado']='<span class="badge bg-success">Activo</span>'}</td>
                    <td>${row['fecha_registro']}</td>
                    </tr>`
                }else{
                    htmlBody+=`<tr>
                    <td>${row['id']}</td>
                    <td>${row['cliente']}</td>
                    <td>${row['estado']='<span class="badge bg-danger">Inactivo</span>'}</td>
                    <td>${row['fecha_registro']}</td>
                    </tr>`
                }
            });
        
          
        document.getElementById("tblListaClientes").innerHTML = htmlHeader + '<tbody>' + htmlBody + '</tbody>';
        $('#lista_cliente').modal('show');       
      }
    };
}

function btnListaReporte(id) {
    const url = base_url + 'Rutas/listaReportes/' + id;
    const http = new XMLHttpRequest();
    http.open('GET', url, true);
    http.send();
    http.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        console.log(this.responseText);
        let htmlHeader = `<thead class="thead table-dark"><tr>
        <th>ID</th>
        <th>Caja real</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th></th>
        </tr></thead>`;
        let htmlBody = '';
            res.forEach(row => {
                    
                    htmlBody+=`<tr>
                    <td>${row['id']}</td>
                    <td>${"$ "+row['caja_real']}</td>
                    <td>${row['fecha_reporte']}</td>
                    <td>${row['hora_reporte']}</td>
                    <td><a class="btn btn-danger" href="${base_url+"Reportes/generarPDF/"+row['id']}" target="_blank"><i class="fas fa-file-pdf"></i></a></td>
                    </tr>`
            });
        
          
        document.getElementById("tblListaReportes").innerHTML = htmlHeader + '<tbody>' + htmlBody + '</tbody>';
        $('#lista_reporte').modal('show');       
      }
    };
}