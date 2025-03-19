//Función para ingresar al login
function frmLogin(e) {
    e.preventDefault();
    const ruta = document.getElementById("ruta");
    const clave = document.getElementById("clave");

    if (ruta.value == "") {
        clave.classList.remove("is-invalid");
        ruta.classList.add("is-invalid");
        ruta.focus();
    } else if (clave.value == "") {
        ruta.classList.remove("is-invalid");
        clave.classList.add("is-invalid");
        clave.focus();
    } else { //< petición mediante AJAX usando el xml request
        //Se crea una constante que almacena la url y concatena con el controlador Usuario y su método validar 
        const url = base_url + 'Rutas/validar';
        //Se crea una constante donde se almacena el id del formulario
        const frm = document.getElementById("frmLogin");
        //Se crea una constante y se crea una nueva instancia del  XMLHttpRequest
        const http = new XMLHttpRequest();
        //Acede mediante un método, una url y de forma asincrona(booleana)
        http.open("POST", url, true);
        //Se envía la petición, siendo nueva con un FormData y dentro de ella la constante en este caso el frm 
        http.send(new FormData(frm));
        //Se verifica el estado por medio de un onreadystatechange. El onreadystatechange se va a estar ejecutando cada vez que el state change esté cambiando 
        http.onreadystatechange = function () {
            //validación. Si el estatus es igual a 200 la respuesta está lista.
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                if (res == "ok") {
                    //Si res es igual a "ok" se manda al index del controlador
                    window.location = base_url + "Perfil";
                } else {
                    //Llamamos el id de la alerta y le quitamos la clase para que se muestre
                    document.getElementById("alerta").classList.remove("d-none");
                    document.getElementById("alerta").innerHTML = res;
                }
            }
        }

    }
}