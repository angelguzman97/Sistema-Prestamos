let tblCantidades;
document.addEventListener("DOMContentLoaded", function (){
//La variable tblCaantidades es igual a nuestra datatable. Tabla de las cantidades
 tblCantidades = $("#tblCantidades").DataTable({
    ajax: {
        //Se manda al controlador Clientes y al método listarCliente
        url: base_url + "Cantidades/listarCantidad",
        dataSrc: ''
    },
    columns: [{
        'data': 'cantidad'
    },
    {
        'data': 'estado'
    },
    {
        'data': 'acciones'
    }]
});
})


////////////////////Funciones Cantidades//////////////////
//Funcion modal
function frmCantidad() {
    //Toma el id del h5 del modal del index Usuario y sustituye el título
    document.getElementById("title").innerHTML = "Nueva cantidad";
    document.getElementById("btnAccion").innerHTML = "Registrar";

    //Se resetea el formulario para que no se muestren los datos ya registrados
    document.getElementById("frmCantidades").reset();

    //Se muestra el modal
    $("#nueva_cantidad").modal("show");

    //Se accede al id con document.getElementById() para poder limpiar los id de tipo hiden. Pasándolo vacío
    document.getElementById("id").value = "";
}

//Función para registrar y modificar cliente
function registrarCantidad(e) {
    e.preventDefault();
    //Se crea la constante donde accede a los id de cada input del index o vista y los almacena en él
    const cantidad = document.getElementById("cantidad");

    if (cantidad.value == "") {
        //SweetAlert2. Su ruta está en el footer dentro de templates de Views. Es una alerta
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Coloque el nombre la cantidad',
            showConfirmButton: false,
            timer: 3000
        })
    } else { //< petición mediante AJAX usando el xml request
        //Se crea una constante que almacena la url y concatena con el controlador Usuarios y su método registrar 
        const url = base_url + "Cantidades/registrar";
        //Se crea una constante donde se almacena el id del formulario de registrar usuarios
        const frm = document.getElementById("frmCantidades");
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
                        title: 'Cantidad registrada con éxito',
                        showConfirmButton: false,
                        timer: 3000
                    })
                    //Reseteo de formulario
                    frm.reset();
                    //Ocultar el modal
                    $("#nueva_cantidad").modal("hide");

                    //Se llama a la variable de la tabla para recarga la página después de registrar un usuario por medio de AJAX
                    tblCantidades.ajax.reload();

                    //Se verifica si res es igual al mensaje modificado del controlador
                } else if (res == "modificado") {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Cantidad modificado con éxito',
                        showConfirmButton: false,
                        timer: 3000
                    })

                    //Ocultar el modal
                    $("#nueva_cantidad").modal("hide");

                    //Se llama a la variable de la tabla para recarga la página después de registrar un usuario por medio de AJAX
                    tblCantidades.ajax.reload();


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

//Función para el botón editar caja que recibe un parámetro id. Se mandará a llamar en el controlador cajas. En los botones de listar cajas. 
function btnEditarCantidad(id) {
    //Toma el id del h5 del modal del index Usuario y sustituye el título
    document.getElementById("title").innerHTML = "Actualizar cantidad";
    document.getElementById("btnAccion").innerHTML = "Modificar";

    //Mostrar los datos reistrados para modificar los datos
    //Se crea una constante que almacena la url y concatena con el controlador Usuarios y su método editar y se concatena el parárametro que su colocó en dentro de la función
    const url = base_url + "Cantidades/editar/" + id;
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
            document.getElementById("cantidad").value = res.cantidad;
            //Se muestra el modal
            $("#nueva_cantidad").modal("show");
        }
    }
}

//Función para el botón eliminar cajas
function btnEliminarCantidad(id) {
    Swal.fire({
        title: '¿Está seguro de eliminar?',
        text: "¡La cantidad no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
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
            const url = base_url + "Cantidades/eliminar/" + id;
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
                            'Cantidad eliminada con éxito.',
                            'success'
                        )
                        //Se llama a la variable de la tabla para recarga la página después de registrar un usuario por medio de AJAX
                        tblCantidades.ajax.reload();   
                    }else{
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

//Función para el botón reingresar caja y secrea una función similar en el controlador cajas
function btnReingresarCantidad(id) {
    Swal.fire({
        title: '¿Está seguro de reingresar?',
        text: "¡La cantidad no se reingresará de forma permanente, solo cambiará el estado a activo!",
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
            const url = base_url + "Cantidades/reingresar/" + id;
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
                            'Cantidad reingresada con éxito.',
                            'success'
                        )
                        //Se llama a la variable de la tabla para recarga la página después de registrar un usuario por medio de AJAX
                        tblCantidades.ajax.reload();   
                    }else{
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