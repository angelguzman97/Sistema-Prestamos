<title>Pagos</title>
<?php include "Views/Templates/header.php"; ?>
<link href="<?php echo base_url ?>Assets\css\carrusel.css" rel="stylesheet" />
<script src="<?php echo base_url; ?>Assets/js/funcionesPagos.js"></script>
<script src="<?php echo base_url; ?>Assets/js/jquery-3.6.4.min.js"></script>
<div id="carouselExampleControlsNoTouching" class="carousel slider w-100 d-flex" data-bs-touch="false" data-bs-interval="false">
  
</div>

                
<script>
  $(document).ready(function() {
      // Obtener los datos de los clientes desde el controlador PHP
      $.getJSON(base_url + "Pagos/vistaPagos/", function(data) {
        // Crear el HTML para el slider
        var html = "";
        var count = 0;
    $.each(data, function(index, res) {
        
        // Agregar el índice al div de cliente
        html += '<div class="cliente ms-2 me-2 w-100" data-bs-touch="false" data-bs-interval="false" data-count="' + count + '">';
        count++;
        html += '<div class="carousel-inner align-items-center">';
        html += '<div class="mb-2 w-100  me-5">';
        html += '<div class="card ">';
        html += '<div class="carousel-item active card-body">';
        
        html += '<form id="frmPagos' + res.id_cliente + '" class="frmPagos" method="post">';
      
      
      ///////////////////Datos del cliente///////////////////////////      
      html += '<div for="Datos de clientes">';
      /////////////////Nombre y apellido
      html += '<div class="form-group"><input type="hidden" id="id" name="id"></input><input type="hidden" id="id_ruta" name="id_ruta" value="'+res.id_ruta+'"></input><label for="cliente" class="fw-bold">Cliente:</label>'+" "+'<output id="cliente" name="cliente" value="">'+res.cliente+" "+res.apellidos+'</output></div>';
      
      /////////////////ID  del cliente
      html += '<div class="form-group mt-2"><label for="id_cliente" class="fw-bold">ID Cliente:</label>'+" "+'<input style="border: 0; width: 100px;" id="id_cliente" name="id_cliente" value="'+res.id_cliente+'" readonly style="border: 0;"></div>';

      //////////////////Edad y teléfono del cliente
      html += '<div class="row">';
      ///////////////Edad//////////////////
      html += '<div class="col-4"><div class="form-group mt-2"><label for="edad" class="fw-bold">Edad:</label>'+" "+'<output id="edad" type="number" name="edad" placeholder="edad">'+res.edad+'</output></div></div>';
      //////////////Teléfono////////////
      html += '<div class="col-8"><div class="form-group mt-2"><label for="telefono" class="fw-bold">Teléfono:</label>'+" "+'<output id="telefono" type="text" name="telefono">'+res.telefono+'</output></div></div>';
      ///Final del row de edad y teléfono del cliente
      html += '</div>';

      /////////////////Dirección del cliente
      html += '<div class="form-group mt-2"><label for="direccion" class="fw-bold">Dirección:</label>'+" "+'<output id="direccion" name="direccion">'+res.direccion+'</output></div>';
      
      /////////////////Trabajo del cliente
      html += '<div class="form-group mt-2"><label for="trabajo" class="fw-bold">Trabajo:</label>'+" "+'<output id="trabajo" name="trabajo">'+res.trabajo+'</output></div>';
      
      /////////////////Foto del cliente
      html += '<div class="col-md-12 w-50"><div class="form-group"><label class="fw-bold">Foto</label><br><img class="img-thumbnail" id="img-preview" src ='+base_url+'Assets/img/'+res.foto+'></img></div></div>';

      /////////////////Fecha de registro del cliente
      html += '<div class="form-group"><label for="fecha_registro" class="fw-bold">Fecha de registro:</label>'+" "+'<output id="fecha_registro" class="w-50" name="fecha_registro">'+res.fecha_registro+'</output></div>';
      ///////////div de todos los datos del cliente////////////////////
      html += '</div>';
      
      ///////////div de todos los datos del préstamo del cliente////////////////////
      html += '<div for="Datos del prestamo del cliente">';
      ///////////////Cantidad del Préstamos/////
      html += '<div class="form-group mt-2">'; 
      html += '<input type="hidden" id="id_prestamo" name="id_grupo" value="'+res.id_prestamo+'">';
      html += '<label for="prestamo" class="fw-bold">Préstamo: $</label>'+" "+'<output id="total_pago" name="total_pago">'+res.total_pago+'</output></div>';
      
      html += '<div class="form-group mt-2">'; 
      html += '<input type="hidden" id="id_grupo" name="id_grupo" value="'+res.id_grupo+'">';
      html += '<label for="grupo" class="fw-bold">Grupo:</label>'+" "+'<output id="grupo" name="grupo">'+res.grupo+'</output></div>';
      
      ////////////Cuota diaria///////////////
      html += '<div class="form-group mt-2"><label for="pago diario" class="fw-bold">Cuota diaria: $</label>'+" "+'<input id="cantidad_dias" name="pago_diario" style="border: 0; width: 70px;" value="'+res.cantidad_dias+'"readonly></input></div>';

      //////////////Fecha inicial y final del préstamos//////////
      html += '<div class="form-group mt-2"><label for="fecha inicial y final" class="fw-bold">Fecha inicial y final del préstamo:</label><br>'+" "+'<output id="fecha_inicial" name="fecha_inicial">'+res.fecha_inicial+'</output>'+" "+'<label id="al" class="fw-bold" name="al">al</label>'+" "+'<input style="border: 0; width: 100px;" id="fecha_final"  name="fecha_final" value="'+res.fecha_final+'" readonly></div>';
       ///////////div de todos los datos del préstamo del cliente////////////////////
      html += '</div>';

       ///////////div de todos los datos del pago del cliente////////////////////
       html += '<div for="Datos del pago del cliente">';
       
       ///////////Saldo del cliente////////////////////
       html += '<div class="form-group fw-bold mt-2"><label for="saldo">Saldo: $</label>'+" "+'<input style="border: 0; width: 80px;" id="saldo" name="saldo" value="'+res.saldo +'" readonly ></div>';
       
       ///////////Row////////////////////
       html += '<div class="row">';
       
       ///////////Cuotas vencidas del cliente////////////////////
       html += '<div class="col-6"><div class="form-group mt-2"><label for="cuota vencida" class="fw-bold">Cuotas vencidas:</label>'+" "+'<input style="border: 0; width: 35px;" id="cuotas_vencidas" name="cuotas_vencidas" value="'+res.cuotas_vencidas+'" readonly ></div></div>';
       
       
       ///////////Días atraso del cliente////////////////////
       html += '<div class="col-6"><div class="form-group mt-2"><label for="dias_atraso" class="fw-bold">Días de atraso:</label>'+" "+'<input style="border: 0; width: 35px;" id="dias_atraso" name="dias_atraso" value="'+res.dias_atraso+'" readonly ></div></div>';

       ///////Fin del Row//////
       html += '</div>';

       
       ///////////Saldo vencido del cliente////////////////////
       html += '<div class="form-group mt-2"><label for="saldo_vencido" class="fw-bold">Saldo vencido: $</label>'+" "+'<input style="border: 0; width: 65px;" id="saldo_vencido" name="saldo_vencido" value="'+res.saldo_vencido+'" readonly ></div>';

       ///////Abonos del cliente//////
       html += '<div class="form-group mt-2"><label for="abono" class="fw-bold">Abono: $</label>'+" "+'<input style="width: 65px;" id="abono" type="number" name="abono"></div>';
       
       html +='<div class="form-group mt-2"><select id="tipo_pago" class="form-select" name="tipo_pago" style="width: 150px;" > <option value="Efectivo">Efectivo</option><option value="Transferencia">Transferencia</option></select></div>';

       ///////Fecha del pago del cliente//////
       html += `<div class="row">
                        <div class="col-6">
                            <div class="form-group mt-2">
                                <label for="fecha_pago" class="fw-bold">Fecha</label>
                                <input id="fecha_pago" style="border: 0; width: 130px;" name="fecha_pago"
                                    value="<?php date_default_timezone_set('America/Chihuahua');
                                                                                                            setlocale(LC_TIME, 'es_MX');
                                                                                                            echo date('j/n/Y'); ?>" readonly></input>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mt-2">
                                <label for="hora_pago" class="fw-bold">Hora</label>
                                <input id="hora_pago" style="border: 0; width: 100px;" name="hora_pago"
                                    value="<?php date_default_timezone_set('America/Chihuahua');
                                                                                                           echo date('h:i A'); ?>" readonly></input>
                            </div>
                        </div>
                    </div>`;

       ///////////div de todos los datos del pago del cliente////////////////////
       html += '</div>';
       
       ///////////Botones////////////////////
       html += '<div class="mt-2" style="text-align: center;"><button class="btn btn-danger btn-agregar-cuota mt-2 align-items-center" type="submit" data-id="' + res.id_cliente + '" >No pago</button>'+" ";
       
       html+=" "+'<button class="btn btn-success btn-agregar-pago mt-2 align-items-center" data-id="' + res.id_cliente + '" type="button" id="btn-agregar-pago">Agregar Pago</button></div>';

      ///////////Formulario////////////////////
      html += '</form>';
      ///////////Sexto div////////////////////
      html += '</div>';
      ///////////Quinto div////////////////////
      html += '</div>';
      ///////////Cuarto div////////////////////
      html += '</div>';
      ///////////tercer div////////////////////
      html += '</div>';
      ///////////segundo div////////////////////
      html += '</div>';

      /////////////////////////////Botones del slider////////////////////////////////
      html +='<button class="anterior carousel-control-prev text-dark me-5" style="width: 75px;" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="prev"><i class="fa-solid fa-chevron-left me-5 md-5" style="width: 75px; height:75px;" aria-hidden="true"></i><span class="visually-hidden">Previous</span></button>';

      html+='<button class="siguiente carousel-control-next text-black" style="width: 75px;" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="next"><i class="fa-solid fa-chevron-right ms-5 md-5" style="width: 75px; height:75px;" aria-hidden="true"></i> <span class="visually-hidden">Next</span></button>';

      ///////////Primer div////////////////////
      html += '</div>';
      
    });
        $(".slider").html(html);

  // Agregar eventos onclick a los botones "Registrar pago"
$(".btn-agregar-pago").click(function() {
  // Obtener los valores de los campos del formulario de pago
  var cantidad_dias = $(this).closest(".cliente").find("#cantidad_dias").val();
  var fecha_final = $(this).closest(".cliente").find("#fecha_final").val();
  var abono = $(this).closest(".cliente").find("#abono").val();
  var tipo_pago = $(this).closest(".cliente").find("#tipo_pago").val();
  var saldo = $(this).closest(".cliente").find("#saldo").val();
  var cuotas_vencidas = $(this).closest(".cliente").find("#cuotas_vencidas").val();
  var dias_atraso = $(this).closest(".cliente").find("#dias_atraso").val();
  var saldo_vencido = $(this).closest(".cliente").find("#saldo_vencido").val();
  var fecha_pago = $(this).closest(".cliente").find("#fecha_pago").val();
  var hora_pago = $(this).closest(".cliente").find("#hora_pago").val();
  var id_grupo = $(this).closest(".cliente").find("#id_grupo").val();
  var id_cliente = $(this).closest(".cliente").find("#id_cliente").val();
  var id_prestamo = $(this).closest(".cliente").find("#id_prestamo").val();
  
  // Crear un objeto JSON con los datos del pago
  var pago = {
    "fecha_final": fecha_final,
    "cantidad_dias": cantidad_dias,
    "abono": abono,
    "tipo_pago": tipo_pago,
    "saldo": saldo,
    "cuotas_vencidas": cuotas_vencidas,
    "dias_atraso": dias_atraso,
    "saldo_vencido": saldo_vencido,
    "fecha_pago": fecha_pago,
    "hora_pago": hora_pago,
    "id_grupo": id_grupo,
    "id_cliente": id_cliente,
    "id_prestamo": id_prestamo
  };
  
  // Enviar la solicitud AJAX al controlador PHP
  console.log(pago);
  $.ajax({
    url: base_url + "Pagos/registrarPago",
    type: "POST",
    dataType: "json",
    data: pago,
    success: function(response) {
      if (response.msg === 'si') {
      Swal.fire({
        title: '¡Pago registrado!',
        text: 'El pago ha sido registrado exitosamente.',
        icon: 'success',
        showConfirmButton: false,
        timer: 2000
      }).then(function() {
        location.reload(); // recargar la página después de mostrar el mensaje de éxito
      });
    }
    }
  });
});

// Agregar eventos onclick a los botones "Registrar Cuota"

$(".btn-agregar-cuota").click(function() {
  // Obtener los valores de los campos del formulario de pago
  var fecha_final = $(this).closest(".cliente").find("#fecha_final").val();
  var cantidad_dias = "";
  var abono = "";
  var tipo_pago = $(this).closest(".cliente").find("#tipo_pago").val();
  var saldo = $(this).closest(".cliente").find("#saldo").val();
  var cuotas_vencidas = $(this).closest(".cliente").find("#cuotas_vencidas").val();
  var dias_atraso = $(this).closest(".cliente").find("#dias_atraso").val();
  var saldo_vencido = $(this).closest(".cliente").find("#saldo_vencido").val();
  var fecha_pago = $(this).closest(".cliente").find("#fecha_pago").val();
  var hora_pago = $(this).closest(".cliente").find("#hora_pago").val();
  var id_grupo = $(this).closest(".cliente").find("#id_grupo").val();
  var id_cliente = $(this).closest(".cliente").find("#id_cliente").val();
  var id_prestamo = $(this).closest(".cliente").find("#id_prestamo").val();
  
  // Crear un objeto JSON con los datos del pago
  var pago = {
    "fecha_final": fecha_final,
    "cantidad_dias": cantidad_dias,
    "abono": abono,
    "tipo_pago": tipo_pago,
    "saldo": saldo,
    "cuotas_vencidas": cuotas_vencidas,
    "dias_atraso": dias_atraso,
    "saldo_vencido": saldo_vencido,
    "fecha_pago": fecha_pago,
    "hora_pago": hora_pago,
    "id_grupo": id_grupo,
    "id_cliente": id_cliente,
    "id_prestamo": id_prestamo
  };
  
  // Enviar la solicitud AJAX al controlador PHP
  console.log(pago);
  $.ajax({
    url: base_url + "Pagos/registrarCuota",
    type: "POST",
    dataType: "json",
    data: pago,
    success: function(response) {
      if (response.msg === 'si') {
      Swal.fire({
        title: '¡Cuota registrada!',
        text: 'La cuota ha sido registrada exitosamente.',
        icon: 'success',
        showConfirmButton: false,
        timer: 2000
      }).then(function() {
        location.reload(); // recargar la página después de mostrar el mensaje de éxito
      });
    }
    }
  });
});


        // Inicializar el slider
        var sliderIndex = 0;
        $(".cliente").hide();
        $(".cliente:eq(" + sliderIndex + ")").show();

        // Agregar botones para cambiar manualmente el slider
        $(".anterior").click(function() {
          if (sliderIndex > 0) {
            sliderIndex--;
            $(".cliente").hide();
            $(".cliente:eq(" + sliderIndex + ")").show();
          }
        });
        $(".siguiente").click(function() {
          if (sliderIndex < data.length - 1) {
            sliderIndex++;
            $(".cliente").hide();
            $(".cliente:eq(" + sliderIndex + ")").show();
          }
        });
      });
    });

</script>
  <?php include "Views/Templates/footer.php"; ?>
  <link href="<?php echo base_url; ?>Assets/css/styles.css" rel="stylesheet" />