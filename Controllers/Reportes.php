<?php class Reportes extends Controller
{
    //Este constructor se hace igual en el controlador home
    public function __construct()
    {
        //Esto inicializa las sesiones
        session_start();

        //Se verifica si no se tiene una sesión activa. empty es Si no existe
        if (empty($_SESSION['activo'])) {
            //Si no se tiene una sesión activa. Se le manda mediante header la locación concatenada con la constante almacenada "base_url"
            header("location: " . base_url);
        }
        //La palabra reservada parent nos sirve para llamarla desde una clase extendida.
        //Cargar el constructor a las vistas
        parent::__construct();
    }

    //Accede al index de la carpeta Usuarios de la carpeta Views
    public function index()
    {
        $id_ruta = $_SESSION['id_ruta'];
        $data['ClientesPagos'] = $this->model->getClientesPagos($id_ruta);
        $data['ClientesPrestamos'] = $this->model->getClientesPrestamos($id_ruta);
        $this->views->getView($this, "index", $data);
    }

    public function listaReportes()
    {
        $this->views->getView($this, "listaReportes");
    }

    public function listarPagosDia()
    {
        $id_ruta = $_SESSION['id_ruta'];
        $data = $this->model->getPagosDia($id_ruta);

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['acciones'] = '<div> <button class="btn btn-primary" type="button" onclick="btnEditarCuadre(' . $data[$i]['id'] . ');" ><i class="fas fa-edit"></i></button>
        </div>';
        }

        //Mandamos el JSON a la función JS
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function listarReportes()
    {
        $id_ruta = $_SESSION['id_ruta'];
        $data = $this->model->getReportes($id_ruta);

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['caja_real'] = '<td>' . "$ " . $data[$i]['caja_real'] . ' </td>';
            $data[$i]['acciones'] = '<div><a class="btn btn-danger" href="' . base_url . "Reportes/generarPDF/" . $data[$i]['id'] . '" target="_blank"><i class="fas fa-file-pdf"></i></a></div>';
        }

        //Mandamos el JSON a la función JS
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrarPagoDia()
    {
        $clientes_programados = $_POST['clientes_programados'];
        $clientes_visitados = $_POST['clientes_visitados'];
        $clientes_pendientes = $_POST['clientes_pendientes'];
        $caja_inicial = $_POST['caja_inicial'];
        $cobrado = $_POST['cobrado'];
        $prestamo = $_POST['prestamo'];
        $gastos = $_POST['gastos'];
        $tipo_gastos = $_POST['tipo_gastos'];
        $inversion = $_POST['inversion'];
        $tipo_inversion = $_POST['tipo_inversion'];
        $caja = $_POST['caja_final']+$inversion-$gastos;
        $caja_final = $caja;
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];
        $id_ruta = $_SESSION['id_ruta'];

        date_default_timezone_set('America/Chihuahua');
        setlocale(LC_TIME, 'es_MX');

        $dia_semana = date('N');

        //Se colocó a lo último porque es para poder modificar los clientes
        $id = $_POST['id'];

        if ($id == "") {

            if ($prestamo == "") {
                $prestamo = 0;
            }
            $data = $this->model->registrarPagoRuta($clientes_programados, $clientes_visitados, $clientes_pendientes, $caja_inicial, $cobrado, $prestamo, $gastos, $tipo_gastos, $inversion, $tipo_inversion, $caja_final,  $fecha, $hora, $id_ruta);
            $data = $this->model->cajaAnterior($caja_final, $fecha, $id_ruta);
            
            //Aquí modifiqué los abonos
            if($dia_semana == 1){
                $cobrado = $_POST['cobrado'] + $caja_inicial;
                
                $this->model->registrarCuadreTmp($dia_semana, $cobrado, $prestamo, $gastos, $inversion, $caja_final, $fecha, $hora, $id_ruta);
            }else{
                $cobrado = $_POST['cobrado'];
            $this->model->registrarCuadreTmp($dia_semana, $cobrado, $prestamo, $gastos, $inversion, $caja_final, $fecha, $hora, $id_ruta);
            }

            if ($data == "ok") {
                $msg = "si";
                //Verficación de usuario existente. Viene del modelo usuario
            } else if ($data == "existe") {
                $msg = "Cuadre ya registrado";
            } else {
                $msg = "Error al registrar cuadre";
            }
        } else {

            //Se crea una variable que accede al modelo y se manda a llamar al método modificarUsuarios junto con sus parámetros en el modelo
            $data = $this->model->modificarReporte($gastos, $tipo_gastos, $inversion, $tipo_inversion, $id_ruta, $id);
            //Se hace la verificación
            if ($data == "modificado") {
                $msg = "modificado";
            } else {
                $msg = "Error al modificar reporte";
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    //Aquí se crea la función de editar indicando como parámetro que recibe un entero para que se ejecute en el index de Views/Usuarios
    public function editar(int $id)
    {
        //Se crea una ariable donde almacena el acceso al modelo usuario (UsuariosModel) llamando al método editarUser() indicando que recibe un parámetro entero, en este caso $id
        $data = $this->model->editarReporte($id);

        //Se visualiza con un echo y un JSON, donde el JSON_UNESCAPED_UNICODE es para no tener problemas con los acentos
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function registrarReporte()
    {
        $id_ruta = $_SESSION['id_ruta'];
        date_default_timezone_set('America/Chihuahua');
        setlocale(LC_TIME, 'es_MX');

        $fecha_reporte = strftime('%d de %B %Y');
        $hora_reporte = date('h:i A');
        //Aquí se accede al modelo de cajaReal, y su parámetro que es el id del usuario
        $caja_Real = $this->model->cajaReal($id_ruta);
        
        //Aquí se se indica que recibe un parámetro del modelo anterior y se le indica su ALIAS
        $data = $this->model->registrarReporteRuta($caja_Real['caja_real'], $fecha_reporte, $hora_reporte, $id_ruta);
        
        if ($data == 'ok') {
            $pagoDia = $this->model->getPagoRuta($id_ruta);
            //Se crea una variable para hacer una consulta en el modelo y así obtener el id de compra y utilizarlo en el foreach
            $id_reporte = $this->model->id_reporte();
            //Se crea un foreach para poder hacer otro registro y se crea una variable $row(Alias para la consulta del modelo antierior)
            foreach ($pagoDia as $row) {
                //Se crean las vaiables de donde se obtendrán esos parámetros que se envían al modelo
                $clientes_programados = $row['clientes_programados'];
                $clientes_visitados = $row['clientes_visitados'];
                $clientes_pendientes = $row['clientes_pendientes'];
                $caja_inicial = $row['caja_inicial'];
                $cobrado = $row['cobrado'];
                $prestamos = $row['prestamo'];
                $gastos = $row['gastos'];
                $tipo_gastos = $row['tipo_gastos'];
                $inversion = $row['inversion'];
                $tipo_inversion = $row['tipo_inversion'];
                $caja_final = $row['caja_final'];
                $fecha_cuadre = $row['fecha'];
                $hora_cuadre = $row['hora'];

                //Al id_reporte se le agrega su alias que se le colocó en el modelo
                $this->model->registrarCuadre($clientes_programados, $clientes_visitados, $clientes_pendientes, $caja_inicial, $cobrado, $prestamos, $gastos, $tipo_gastos, $inversion, $tipo_inversion, $caja_final, $fecha_cuadre, $hora_cuadre, $id_ruta, $id_reporte['id']);
    
            }
            $vaciarPagoDia = $this->model->vaciarPagoDia($_SESSION['id_ruta']);
            if ($vaciarPagoDia == 'ok') {
                //Si es un 'ok', entonces el mensaje se manda como Array. el mensaje va a ser igual a un 'ok'. Tamibén el $id de la compra y como viene de un arreglo, hay que indicar que campo es
                $msg = array('msg' => 'ok', 'id_reporte' => $id_reporte['id']);
            }
        } else {
            $msg = 'Error al realizar la compra';
        }
        echo json_encode($msg);
        die();
    }

    //Generar PDF
    public function generarPDF($id_reporte)
    {


        //Se hace una consulta para traer los datos de los productos, enviando y recibiendo el id compra
        $reporte = $this->model->getReporte($id_reporte);

        //Ese código viene desde la pág. Oficial fpdf
        //Primero se requiere el archivo fpdf.php y se le indica la ruta
        require('Libraries/fpdf/fpdf.php');
        //Este hace una extancia o heredación de la librería.
        //Se le modifca el tamaño de la hoja del pdf que se desea mostrar y se hace con un Array y dentro se indica su ancho (widht) y su alto(hight)
        $pdf = new FPDF('P', 'mm', array(80, 200));
        $pdf->AddPage();
        //Margen del PDF
        $pdf->SetMargins(5, 0, 0);
        //Se le agrega el título del PDF
        $pdf->SetTitle('Reporte de la Ruta');
        $pdf->SetFont('Arial', 'B', 14);
        //Para poder manejar los acentos en el título de las hojas del pdf se le agrega el utf8_encode('título a mostrar'). En este caso el nombre de la empresa se trajo desde la bd, así que se llama a la variable que contiene lo que trae del modelo y se indica su campo
        $pdf->Cell(65, 10, 'Reporte', 0, 1, 'C');
        //Este es para colocar una imagen de la empresa o logo. Indicando la ruta donde se encuentra esa img. Por último se le indica la posición horizontal, la posición vertical o altura, el tamaño de ancho y largo 
        //$pdf->Image(base_url . '/Assets/img/logo.png', 55, 18, 18, 18);
        //RFC
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(20, 5, 'ID Ruta:', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(20, 5, $reporte['id_ruta'], 0, 1, 'L');
        //Ruta
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(15, 5, 'Ruta:', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(20, 5, $reporte['ruta'], 0, 1, 'L');

        //Cuerpo del documento
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(18, 5, 'Folio:', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(20, 5, $id_reporte, 0, 1, 'L');
        //Salto de linea
        $pdf->Ln();

        //Color del texto
        $pdf->SetTextColor(0, 0, 255); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'

        //Encabezado
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(45, 5, 'Clientes Programados:', 0, 0, 'L');
        $pdf->SetTextColor(255, 0, 0); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 5, $reporte['clientes_programados'], 0, 1, 'L');

        $pdf->SetTextColor(0, 0, 255); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(45, 5, 'Clientes Visitados:', 0, 0, 'L');
        $pdf->SetTextColor(255, 0, 0); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 5, $reporte['clientes_visitados'], 0, 1, 'L');

        $pdf->SetTextColor(0, 0, 255); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(45, 5, 'Clientes Pendientes:', 0, 0, 'L');
        $pdf->SetTextColor(255, 0, 0); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 5, $reporte['clientes_pendientes'], 0, 1, 'L');
        
        $pdf -> Ln();
        $pdf->SetTextColor(0, 0, 255); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(25, 5, 'Caja inicial: $', 0, 0, 'L');
        $pdf->SetTextColor(255, 0, 0); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 5, number_format($reporte['caja_inicial'], 2, '.', ','), 0, 1, 'L');

        $pdf->Ln();

        $pdf->SetTextColor(0, 0, 255); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(20, 5, 'Abonos: $', 0, 0, 'L');
        $pdf->SetTextColor(255, 0, 0); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 5, number_format($reporte['cobrado'], 2, '.', ','), 0, 1, 'L');

        $pdf->SetTextColor(0, 0, 255); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(20, 5, 'Ventas: $', 0, 0, 'L');
        $pdf->SetTextColor(255, 0, 0); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 5, number_format($reporte['prestamos'], 2, '.', ','), 0, 1, 'L');

        $pdf->Ln();

        $pdf->SetTextColor(0, 0, 255); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(18, 5, 'Gastos: $', 0, 0, 'L');
        $pdf->SetTextColor(255, 0, 0); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 5, number_format($reporte['gastos'], 2, '.', ','), 0, 1, 'L');
        $pdf->SetTextColor(255, 200, 0); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetTextColor(255, 200, 0);
        // Obtener el valor de $reporte['tipo_gastos']
        $tipoGastos = $reporte['tipo_gastos'];

        // Convertir el texto en un array de elementos de lista
        $listaGastos = explode("\n", $tipoGastos);
        // Mostrar cada elemento de la lista en una celda separada
        foreach ($listaGastos as $gasto) {
            $pdf->MultiCell(0, 5, $gasto, 0, 'L');
        }
        
        $pdf->Ln();

        $pdf->SetTextColor(0, 0, 255); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(22, 5, 'Inversion: $', 0, 0, 'L');
        $pdf->SetTextColor(255, 0, 0); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 5, number_format($reporte['inversion'], 2, '.', ','), 0, 1, 'L');
        $pdf->SetTextColor(255, 200, 0); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetTextColor(255, 200, 0);
        // Obtener el valor de $reporte['tipo_gastos']
        $tipoInversion = $reporte['tipo_inversion'];

        // Convertir el texto en un array de elementos de lista
        $listaInversion = explode("\n", $tipoInversion);
        
        foreach ($listaInversion as $inversion) {
            $pdf->MultiCell(0, 5, $inversion, 0, 'L');
        }

        $pdf->Ln(); // Salto de línea opcional después de la lista

        
        if ($reporte['caja_anterior']==0) {
            
        $pdf->SetTextColor(0, 0, 255); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(22, 5, 'Se retira todo de la caja menor', 0, 1, 'L');
        $pdf->SetTextColor(255, 0, 0); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', '', 11);

            $pdf->Cell(10, 5, "$".number_format($reporte['caja_real'], 2, '.', ','), 0, 1, 'L');
        }else{

        $pdf->SetTextColor(0, 0, 255); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(22, 5, 'Caja real $:', 0, 0, 'L');
        $pdf->SetTextColor(255, 0, 0); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 5, number_format($reporte['caja_real'], 2, '.', ','), 0, 1, 'L');
        }

        $pdf->Ln(); // Salto de línea opcional después de la lista

        $pdf->SetTextColor(0, 0, 255); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(20, 5, 'Fecha:', 0, 0, 'L');
        $pdf->SetTextColor(255, 0, 0); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 5, $reporte['fecha_reporte'], 0, 1, 'L');

        $pdf->SetTextColor(0, 0, 255); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(20, 5, 'Hora:', 0, 0, 'L');
        $pdf->SetTextColor(255, 0, 0); //Para que se les aplique esos métodos a los encabezados se les agrega un TRUE después de 'L'
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 5, $reporte['hora_reporte'], 0, 1, 'L');


        $pdf->Output();
    }
}
