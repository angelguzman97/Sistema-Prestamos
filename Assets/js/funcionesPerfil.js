function modificarPerfil(e) {
    e.preventDefault();
    
    //< petición mediante AJAX usando el xml request
        //Se crea una constante que almacena la url y concatena con el controlador Usuarios y su método registrar 
        const url = base_url + "Perfil/editarPerfil";
        //Se crea una constante donde se almacena el id del formulario de registrar usuarios
        const frm = document.getElementById("frmPerfil");
        //Se crea una constante y se crea una nueva instancia del objeto XMLHttpRequest
        const http = new XMLHttpRequest();
        //Se crea una condición Por el método POST, se le envía una url y que se ejecuta de forma asincrona(booleana)
        http.open("POST", url, true);
        http.send(new FormData(frm));
        //Se verifica el estado por medio de un onreadystatechange. El onreadystatechange se va a estar ejecutando cada vez que el state change esté cambiando 
        http.onreadystatechange = function () {
            //validación. Si el estatus es igual a 200 la respuesta está lista.
            if (this.readyState == 4 && this.status == 200) {
                //Se convierte el mensaje a un JSON
                console.log(this.responseText);
                const res = JSON.parse(this.responseText);
                if (res == "modificado") {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Perfil modificado con éxito',
                        showConfirmButton: false,
                        timer: 3000,
                    }).then(function() {
                        setTimeout(function() {
                            window.location.reload();
                        }); // se espera 3 segundos para recargar la página
                    });
                    
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

