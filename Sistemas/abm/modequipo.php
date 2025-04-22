<?php 
error_reporting(0);
session_start();
include('../particular/conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
    $datos_base = mysqli_connect('localhost', 'root', '', 'incidentes') 
        or exit('No se puede conectar con la base de datos');

	/* sanitizar el valor recibido en $no_tic antes de meterlo en la consulta SQL. Esto es una medida de seguridad contra inyección SQL */
	$no_tic = mysqli_real_escape_string($datos_base, $no_tic);

    $sentencia = "SELECT * FROM inventario WHERE ID_WS='" . $no_tic . "'";
    $resultado = mysqli_query($datos_base, $sentencia);

    return mysqli_fetch_assoc($resultado);
}

?>
<!DOCTYPE html>
<html>
<head>
<title>MODIFICAR EQUIPO</title>
<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  

  <script>
	$(document).ready(function(){
    $("#slcusu").change(function(){
        
		if ($("#slcusu").val() == '277') {
			$("#slcarea").prop('disabled', false);
		}
		if ($("#slcusu").val() != '277') {
			$("#slcarea").prop('disabled', true);
		}
    });
    });
</script>
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
    <div id="reporteEst">   
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="../consulta/inventario.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
	<section id="Inicio">
    <div id="titulo" style="margin: 20px;">
			<h1>MODIFICAR EQUIPO</h1>
		</div>
        <div id="principalu" style="width: 97%" class="container-fluid">
                <?php 
                    $sent= "SELECT u.NOMBRE
                    FROM wsusuario w
                    JOIN usuarios u ON w.ID_USUARIO = u.ID_USUARIO
                    WHERE w.ID_WSUSU = (
                        SELECT MAX(wsub.ID_WSUSU)
                        FROM wsusuario wsub
                        WHERE wsub.ID_WS = {$consulta['ID_WS']}
                    )";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $usu = $row['NOMBRE'];

                  function obtenerValor($conexion, $tabla, $columna, $id, $esString = false) {
                      // Sanitizar el valor
                      $id = mysqli_real_escape_string($conexion, $id);
                  
                      // Si el valor es un string, se agregan las comillas en la consulta
                      if ($esString) {
                          $id = "'$id'";
                      }
                  
                      // Ejecutar la consulta
                      $sentencia = "SELECT $columna FROM $tabla WHERE $columna = $id";
                      $resultado = $conexion->query($sentencia);
                  
                      if ($resultado && $row = $resultado->fetch_assoc()) {
                          return $row[$columna];
                      } else {
                          return null;  // o valor por defecto si no existe
                      }
                  }

                  $red = obtenerValor($datos_base, 'red', 'RED', $consulta['ID_RED']);
                  $so = obtenerValor($datos_base, 'so', 'SIST_OP', $consulta['ID_SO']);
                  $est = obtenerValor($datos_base, 'estado_ws', 'ESTADO', $consulta['ID_ESTADOWS']);
                  $pro = obtenerValor($datos_base, 'proveedor', 'PROVEEDOR', $consulta['ID_PROVEEDOR']);
                  $tip = obtenerValor($datos_base, 'tipows', 'TIPOWS', $consulta['ID_TIPOWS']);
                  $mar = obtenerValor($datos_base, 'marcas', 'MARCA', $consulta['ID_MARCA']);
                  $area = obtenerValor($datos_base, 'area', 'AREA', $consulta['ID_AREA']);
                  $procedencia = obtenerValor($datos_base, 'procedencia', 'PROCEDENCIA', $consulta['ID_PROCEDENCIA']);  // si es un string pongo una coma y true

                ?>


                        <!-- MEMORIAS -->
                <!-- ///////////////////////////////// -->
                <!-- ///////////////////////////////// -->
                <?php 
                  function obtenerValorWsMem($datos_base, $tabla, $columna, $idWs, $slot, $conJoin = true, $columnaJoin = null) {
                    // Si necesitamos un JOIN, construimos la consulta con LEFT JOIN
                    if ($conJoin && $columnaJoin !== null) {
                        $sent = "SELECT $columna FROM wsmem w LEFT JOIN $tabla t ON t.$columnaJoin = w.$columnaJoin WHERE w.ID_WS = $idWs AND w.SLOT = $slot";
                    } else {
                        // Si no necesitamos JOIN, solo seleccionamos de la tabla wsmem
                        $sent = "SELECT $columna FROM wsmem WHERE ID_WS = $idWs AND SLOT = $slot";
                    }
                    
                    $resultado = $datos_base->query($sent);

                    // Verificamos si la consulta devuelve un resultado
                    if ($resultado && $row = $resultado->fetch_assoc()) {
                        return $row[$columna];  // Retorna el valor de la columna
                    } else {
                        return null;  // Retorna null si no hay resultado
                    }
                  }

                  /* SLOT 1 */
                  $mem1 = obtenerValorWsMem($datos_base, 'memoria', 'MEMORIA', $consulta['ID_WS'], 1, true, 'ID_MEMORIA');
                  $tmem1 = obtenerValorWsMem($datos_base, 'tipomem', 'TIPOMEM', $consulta['ID_WS'], 1, true, 'ID_TIPOMEM');
                  $prov1 = obtenerValorWsMem($datos_base, 'proveedor', 'PROVEEDOR', $consulta['ID_WS'], 1, true, 'ID_PROVEEDOR');
                  $marc1 = obtenerValorWsMem($datos_base, 'marcas', 'MARCA', $consulta['ID_WS'], 1, true, 'ID_MARCA');
                  $pvel1 = obtenerValorWsMem($datos_base, 'velocidad', 'FRECUENCIA_RAM', $consulta['ID_WS'], 1, true, 'ID_FRECUENCIA');
                  $fact1 = obtenerValorWsMem($datos_base, 'wsmem', 'FACTURA', $consulta['ID_WS'], 1, false);
                  $fec1 = obtenerValorWsMem($datos_base, 'wsmem', 'FECHA', $consulta['ID_WS'], 1, false);
                  $gar1 = obtenerValorWsMem($datos_base, 'wsmem', 'GARANTIA', $consulta['ID_WS'], 1, false);                       

                  /* SLOT 2 */
                  $mem2  = obtenerValorWsMem($datos_base, 'memoria', 'MEMORIA', $consulta['ID_WS'], 2, true,  'ID_MEMORIA');
                  $tmem2 = obtenerValorWsMem($datos_base, 'tipomem', 'TIPOMEM', $consulta['ID_WS'], 2, true,  'ID_TIPOMEM');
                  $prov2 = obtenerValorWsMem($datos_base, 'proveedor', 'PROVEEDOR', $consulta['ID_WS'], 2, true,  'ID_PROVEEDOR');
                  $marc2 = obtenerValorWsMem($datos_base, 'marcas', 'MARCA', $consulta['ID_WS'], 2, true,  'ID_MARCA');
                  $pvel2 = obtenerValorWsMem($datos_base, 'velocidad', 'FRECUENCIA_RAM', $consulta['ID_WS'], 2, true,  'ID_FRECUENCIA');
                  $fact2 = obtenerValorWsMem($datos_base, 'wsmem', 'FACTURA', $consulta['ID_WS'], 2, false);
                  $fec2  = obtenerValorWsMem($datos_base, 'wsmem', 'FECHA', $consulta['ID_WS'], 2, false);
                  $gar2  = obtenerValorWsMem($datos_base, 'wsmem', 'GARANTIA', $consulta['ID_WS'], 2, false);

                  /* SLOT 3 */
                  $mem3  = obtenerValorWsMem($datos_base, 'memoria', 'MEMORIA', $consulta['ID_WS'], 3, true,  'ID_MEMORIA');
                  $tmem3 = obtenerValorWsMem($datos_base, 'tipomem', 'TIPOMEM', $consulta['ID_WS'], 3, true,  'ID_TIPOMEM');
                  $prov3 = obtenerValorWsMem($datos_base, 'proveedor', 'PROVEEDOR', $consulta['ID_WS'], 3, true,  'ID_PROVEEDOR');
                  $marc3 = obtenerValorWsMem($datos_base, 'marcas', 'MARCA', $consulta['ID_WS'], 3, true,  'ID_MARCA');
                  $pvel3 = obtenerValorWsMem($datos_base, 'velocidad', 'FRECUENCIA_RAM', $consulta['ID_WS'], 3, true,  'ID_FRECUENCIA');
                  $fact3 = obtenerValorWsMem($datos_base, 'wsmem', 'FACTURA', $consulta['ID_WS'], 3, false);
                  $fec3  = obtenerValorWsMem($datos_base, 'wsmem', 'FECHA', $consulta['ID_WS'], 3, false);
                  $gar3  = obtenerValorWsMem($datos_base, 'wsmem', 'GARANTIA', $consulta['ID_WS'], 3, false);

                  /* SLOT 4 */
                  $mem4  = obtenerValorWsMem($datos_base, 'memoria', 'MEMORIA', $consulta['ID_WS'], 4, true,  'ID_MEMORIA');
                  $tmem4 = obtenerValorWsMem($datos_base, 'tipomem', 'TIPOMEM', $consulta['ID_WS'], 4, true,  'ID_TIPOMEM');
                  $prov4 = obtenerValorWsMem($datos_base, 'proveedor', 'PROVEEDOR', $consulta['ID_WS'], 4, true,  'ID_PROVEEDOR');
                  $marc4 = obtenerValorWsMem($datos_base, 'marcas', 'MARCA', $consulta['ID_WS'], 4, true,  'ID_MARCA');
                  $pvel4 = obtenerValorWsMem($datos_base, 'velocidad', 'FRECUENCIA_RAM', $consulta['ID_WS'], 4, true,  'ID_FRECUENCIA');
                  $fact4 = obtenerValorWsMem($datos_base, 'wsmem', 'FACTURA', $consulta['ID_WS'], 4, false);
                  $fec4  = obtenerValorWsMem($datos_base, 'wsmem', 'FECHA', $consulta['ID_WS'], 4, false);
                  $gar4  = obtenerValorWsMem($datos_base, 'wsmem', 'GARANTIA', $consulta['ID_WS'], 4, false);
                ?>

                         <!-- DISCOS -->
                <!-- ///////////////////////////////// -->
                <!-- ///////////////////////////////// -->

                <?php
                  function obtenerValorWsDisco($datos_base, $tabla, $columna, $idWs, $numero, $conJoin = true, $columnaJoin = null) {
                    if ($conJoin && $columnaJoin !== null) {
                        $sent = "SELECT $columna 
                                FROM discows dw 
                                LEFT JOIN $tabla t ON t.$columnaJoin = dw.$columnaJoin 
                                WHERE dw.ID_WS = $idWs AND dw.NUMERO = $numero";
                    } else {
                        $sent = "SELECT $columna 
                                FROM discows 
                                WHERE ID_WS = $idWs AND NUMERO = $numero";
                    }

                    $resultado = $datos_base->query($sent);

                    if ($resultado && $row = $resultado->fetch_assoc()) {
                        return $row[$columna];
                    } else {
                        return null;
                    }
                  }
                  /* DISCO 1 */
                  $disc1  = obtenerValorWsDisco($datos_base, 'disco', 'DISCO', $consulta['ID_WS'], 1, true, 'ID_DISCO');
                  $tdisc1 = obtenerValorWsDisco($datos_base, 'tipodisco', 'TIPOD', $consulta['ID_WS'], 1, true, 'ID_TIPOD');
                  $dprov1 = obtenerValorWsDisco($datos_base, 'proveedor', 'PROVEEDOR', $consulta['ID_WS'], 1, true, 'ID_PROVEEDOR');
                  $dfact1 = obtenerValorWsDisco($datos_base, 'discows', 'FACTURA', $consulta['ID_WS'], 1, false);
                  $dfec1  = obtenerValorWsDisco($datos_base, 'discows', 'FECHA', $consulta['ID_WS'], 1, false);
                  $dgar1  = obtenerValorWsDisco($datos_base, 'discows', 'GARANTIA', $consulta['ID_WS'], 1, false);

                  $sent= "SELECT m.MODELO, ma.MARCA
                  FROM discows dw 
                  LEFT JOIN modelo m ON m.ID_MODELO = dw.ID_MODELO
                  LEFT JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                  WHERE dw.ID_WS = ".$consulta['ID_WS']." AND dw.NUMERO = 1";
                  $resultado = $datos_base->query($sent);
                  $row = $resultado->fetch_assoc();
                  $dmod1 = $row['MODELO']." - ".$row['MARCA'];

                  /* DISCO 2 */
                  $disc2  = obtenerValorWsDisco($datos_base, 'disco', 'DISCO', $consulta['ID_WS'], 2, true, 'ID_DISCO');
                  $tdisc2 = obtenerValorWsDisco($datos_base, 'tipodisco', 'TIPOD', $consulta['ID_WS'], 2, true, 'ID_TIPOD');
                  $dprov2 = obtenerValorWsDisco($datos_base, 'proveedor', 'PROVEEDOR', $consulta['ID_WS'], 2, true, 'ID_PROVEEDOR');
                  $dfact2 = obtenerValorWsDisco($datos_base, 'discows', 'FACTURA', $consulta['ID_WS'], 2, false);
                  $dfec2  = obtenerValorWsDisco($datos_base, 'discows', 'FECHA', $consulta['ID_WS'], 2, false);
                  $dgar2  = obtenerValorWsDisco($datos_base, 'discows', 'GARANTIA', $consulta['ID_WS'], 2, false);

                  $sent= "SELECT m.MODELO, ma.MARCA
                  FROM discows dw 
                  LEFT JOIN modelo m ON m.ID_MODELO = dw.ID_MODELO
                  LEFT JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                  WHERE dw.ID_WS = ".$consulta['ID_WS']." AND dw.NUMERO = 2";
                  $resultado = $datos_base->query($sent);
                  $row = $resultado->fetch_assoc();
                  $dmod2 = $row['MODELO']." - ".$row['MARCA'];

                  /* DISCO 3 */
                  $disc3  = obtenerValorWsDisco($datos_base, 'disco', 'DISCO', $consulta['ID_WS'], 3, true, 'ID_DISCO');
                  $tdisc3 = obtenerValorWsDisco($datos_base, 'tipodisco', 'TIPOD', $consulta['ID_WS'], 3, true, 'ID_TIPOD');
                  $dprov3 = obtenerValorWsDisco($datos_base, 'proveedor', 'PROVEEDOR', $consulta['ID_WS'], 3, true, 'ID_PROVEEDOR');
                  $dfact3 = obtenerValorWsDisco($datos_base, 'discows', 'FACTURA', $consulta['ID_WS'], 3, false);
                  $dfec3  = obtenerValorWsDisco($datos_base, 'discows', 'FECHA', $consulta['ID_WS'], 3, false);
                  $dgar3  = obtenerValorWsDisco($datos_base, 'discows', 'GARANTIA', $consulta['ID_WS'], 3, false);

                  $sent= "SELECT m.MODELO, ma.MARCA
                  FROM discows dw 
                  LEFT JOIN modelo m ON m.ID_MODELO = dw.ID_MODELO
                  LEFT JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                  WHERE dw.ID_WS = ".$consulta['ID_WS']." AND dw.NUMERO = 3";
                  $resultado = $datos_base->query($sent);
                  $row = $resultado->fetch_assoc();
                  $dmod3 = $row['MODELO']." - ".$row['MARCA'];

                  /* DISCO 4 */
                  $disc4  = obtenerValorWsDisco($datos_base, 'disco', 'DISCO', $consulta['ID_WS'], 4, true, 'ID_DISCO');
                  $tdisc4 = obtenerValorWsDisco($datos_base, 'tipodisco', 'TIPOD', $consulta['ID_WS'], 4, true, 'ID_TIPOD');
                  $dprov4 = obtenerValorWsDisco($datos_base, 'proveedor', 'PROVEEDOR', $consulta['ID_WS'], 4, true, 'ID_PROVEEDOR');
                  $dfact4 = obtenerValorWsDisco($datos_base, 'discows', 'FACTURA', $consulta['ID_WS'], 4, false);
                  $dfec4  = obtenerValorWsDisco($datos_base, 'discows', 'FECHA', $consulta['ID_WS'], 4, false);
                  $dgar4  = obtenerValorWsDisco($datos_base, 'discows', 'GARANTIA', $consulta['ID_WS'], 4, false);

                  $sent= "SELECT m.MODELO, ma.MARCA
                  FROM discows dw 
                  LEFT JOIN modelo m ON m.ID_MODELO = dw.ID_MODELO
                  LEFT JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                  WHERE dw.ID_WS = ".$consulta['ID_WS']." AND dw.NUMERO = 4";
                  $resultado = $datos_base->query($sent);
                  $row = $resultado->fetch_assoc();
                  $dmod4 = $row['MODELO']." - ".$row['MARCA'];
                ?>


                        <!-- PLACA MADRE -->
                <!-- ///////////////////////////////// -->
                <!-- ///////////////////////////////// -->
                <?php
                  function obtenerDatosPlacaMadre($datos_base, $idWs) {
                    $sentencia = "
                        SELECT 
                            p.PLACAM, 
                            m.MARCA, 
                            pr.PROVEEDOR, 
                            pw.FACTURA, 
                            pw.FECHA, 
                            pw.GARANTIA, 
                            pw.NSERIE
                        FROM inventario i
                        LEFT JOIN placamws pw ON pw.ID_WS = i.ID_WS
                        LEFT JOIN placam p ON p.ID_PLACAM = pw.ID_PLACAM
                        LEFT JOIN marcas m ON m.ID_MARCA = p.ID_MARCA
                        LEFT JOIN proveedor pr ON pr.ID_PROVEEDOR = pw.ID_PROVEEDOR
                        WHERE i.ID_WS = '$idWs'
                    ";

                    $resultado = $datos_base->query($sentencia);

                    if ($resultado && $row = $resultado->fetch_assoc()) {
                        return [
                            'placam'     => $row['PLACAM'] . ' - ' . $row['MARCA'],
                            'proveedor'  => $row['PROVEEDOR'],
                            'factura'    => $row['FACTURA'],
                            'fecha'      => $row['FECHA'],
                            'garantia'   => $row['GARANTIA'],
                            'nro_serie'  => $row['NSERIE']
                        ];
                    } else {
                        return null;
                    }
                  }

                  $datosPlacaMadre = obtenerDatosPlacaMadre($datos_base, $consulta['ID_WS']);

                  if ($datosPlacaMadre) {
                      $placam     = $datosPlacaMadre['placam'];
                      $placamprov = $datosPlacaMadre['proveedor'];
                      $placamfact = $datosPlacaMadre['factura'];
                      $placamfecha = $datosPlacaMadre['fecha'];
                      $placamgar  = $datosPlacaMadre['garantia'];
                      $planro     = $datosPlacaMadre['nro_serie'];
                  }

                  ?>

                        <!-- MICRO -->
                <!-- ///////////////////////////////// -->
                <!-- ///////////////////////////////// -->
                  <?php
                  function obtenerDatosMicro($datos_base, $idWs) {
                    $sentencia = "
                        SELECT 
                            m.MICRO,
                            ma.MARCA,
                            p.PROVEEDOR,
                            mws.FACTURA,
                            mws.FECHA,
                            mws.GARANTIA,
                            mws.NSERIE
                        FROM inventario i
                        LEFT JOIN microws mws ON mws.ID_WS = i.ID_WS
                        LEFT JOIN micro m ON m.ID_MICRO = mws.ID_MICRO
                        LEFT JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                        LEFT JOIN proveedor p ON p.ID_PROVEEDOR = mws.ID_PROVEEDOR
                        WHERE i.ID_WS = '$idWs'
                    ";

                    $resultado = $datos_base->query($sentencia);

                    if ($resultado && $row = $resultado->fetch_assoc()) {
                        return [
                            'micro'      => $row['MICRO'] . ' - ' . $row['MARCA'],
                            'proveedor'  => $row['PROVEEDOR'],
                            'factura'    => $row['FACTURA'],
                            'fecha'      => $row['FECHA'],
                            'garantia'   => $row['GARANTIA'],
                            'nro_serie'  => $row['NSERIE']
                        ];
                    } else {
                        return null;
                    }
                  }

                  $datosMicro = obtenerDatosMicro($datos_base, $consulta['ID_WS']);

                  if ($datosMicro) {
                      $micro      = $datosMicro['micro'];
                      $microprov  = $datosMicro['proveedor'];
                      $microfac   = $datosMicro['factura'];
                      $microfec   = $datosMicro['fecha'];
                      $microgar   = $datosMicro['garantia'];
                      $micnro     = $datosMicro['nro_serie'];
                  }
                  ?>
                        <!-- PLACA VIDEO -->
                <!-- ///////////////////////////////// -->
                <!-- ///////////////////////////////// -->
                  <?php
                  function obtenerDatosPlacaVideo($datos_base, $idWs, $slot) {
                    $sentencia = "
                        SELECT 
                            m.MODELO,
                            pws.NSERIE,
                            p.PROVEEDOR,
                            pws.FACTURA,
                            pws.FECHA,
                            pws.GARANTIA
                        FROM inventario i
                        LEFT JOIN pvideows pws ON pws.ID_WS = i.ID_WS
                        LEFT JOIN pvideo v ON v.ID_PVIDEO = pws.ID_PVIDEO
                        LEFT JOIN modelo m ON m.ID_MODELO = v.ID_MODELO
                        LEFT JOIN proveedor p ON p.ID_PROVEEDOR = pws.ID_PROVEEDOR
                        WHERE i.ID_WS = '$idWs' AND pws.SLOT = '$slot'
                    ";

                    $resultado = $datos_base->query($sentencia);

                    if ($resultado && $row = $resultado->fetch_assoc()) {
                        return [
                            'modelo'     => $row['MODELO'],
                            'nro_serie'  => $row['NSERIE'],
                            'proveedor'  => $row['PROVEEDOR'],
                            'factura'    => $row['FACTURA'],
                            'fecha'      => $row['FECHA'],
                            'garantia'   => $row['GARANTIA']
                        ];
                    } else {
                        return null;
                    }
                  }

                  // Slot 1
                  $datosPlaca1 = obtenerDatosPlacaVideo($datos_base, $consulta['ID_WS'], 1);
                  if ($datosPlaca1) {
                      $pvmem     = $datosPlaca1['modelo'];
                      $pvnserie  = $datosPlaca1['nro_serie'];
                      $pvprov    = $datosPlaca1['proveedor'];
                      $pvfact    = $datosPlaca1['factura'];
                      $pvfec     = $datosPlaca1['fecha'];
                      $pvgar     = $datosPlaca1['garantia'];
                  }

                  // Slot 2
                  $datosPlaca2 = obtenerDatosPlacaVideo($datos_base, $consulta['ID_WS'], 2);
                  if ($datosPlaca2) {
                      $pvmem1    = $datosPlaca2['modelo'];
                      $pvnserie1 = $datosPlaca2['nro_serie'];
                      $pvprov1   = $datosPlaca2['proveedor'];
                      $pvfact1   = $datosPlaca2['factura'];
                      $pvfec1    = $datosPlaca2['fecha'];
                      $pvgar1    = $datosPlaca2['garantia'];
                  }
                  ?>
                

                <form method="POST" action="../abm/guardarmodequipo2.php">
                     <label>ID: </label>
                    <input type="text" class="id" name="id" value="<?php echo $consulta['ID_WS']?>">

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm"class="col-form-label col-xl col-lg">N° GOBIERNO: </label>
                        <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="serieg" value="<?php echo $consulta['SERIEG']?>">
                        <label id="lblForm"class="col-form-label col-xl col-lg">N° SERIE: </label>
                        <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="serialn" value="<?php echo $consulta['SERIALN']?>">
                    </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm"class="col-form-label col-xl col-lg">MAC: </label>
                        <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="mac" value="<?php echo $consulta['MAC']?>">
                        <label id="lblForm"class="col-form-label col-xl col-lg">OBSERVACIÓN: </label>
                        <textarea style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" name="obs" rows="3"><?php echo $consulta['OBSERVACION']?></textarea>
                    </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm"class="col-form-label col-xl col-lg">IP: </label>
                        <input style="margin-top: 5px"class="form-control col-form-label col-xl col-lg" type="text" name="ip" value="<?php echo $consulta['IP']?>">
                        <label id="lblForm"class="col-form-label col-xl col-lg">FACTURA: </label>
                        <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="fac" value="<?php echo $consulta['FACTURA']?>">
                    </div>


                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA: </label>
                        <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="gar" value="<?php echo $consulta['GARANTIA']?>">
                        <label id="lblForm"class="col-form-label col-xl col-lg">MASTERIZACIÓN: </label>
                        <select style="margin-top: 5px"class="form-control col-form-label col-xl col-lg" name="masterizacion">
                        <option selected value="100"><?php echo $consulta['MASTERIZADA']?></option>
                        <option value="SI">SI</option>
                            <option value ="NO">NO</option>
                        </select>
                    </div>


                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm"class="col-form-label col-xl col-lg">RIP: </label>
                        <select style="margin-top: 5px"class="form-control col-form-label col-xl col-lg" name="reserva">
                        <option selected value="200"><?php echo $consulta['RIP']?></option>
                            <option value ="NO">NO</option>
                            <option value="SI">SI</option>
                        </select>
                        <label id="lblForm"class="col-form-label col-xl col-lg">RED: </label>
                        <select style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg" name="red">
                                        <option selected value="300"><?php echo $red?></option>
                                        <?php
                                        include("../particular/conexion.php");
                                        $consulta= "SELECT * FROM red ORDER BY RED ASC";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_RED'] ?>><?php echo $opciones['RED']?></option>
                                        <?php endforeach?>
                                    </select>
                    </div>


                    <div class="form-group row" style="margin: 10px; padding:10px;">

                    <label id="lblForm"class="col-form-label col-xl col-lg">SISTEMA OPERATIVO: </label>
                        <select style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg" name="so">
                                    <option selected value="500"><?php echo $so?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM so ORDER BY SIST_OP ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_SO'] ?>><?php echo $opciones['SIST_OP']?></option>
                                    <?php endforeach?>
                                </select>      
                        <label id="lblForm"class="col-form-label col-xl col-lg">ESTADO: </label>
                        <select style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg" name="est">
                                        <option selected value="700"><?php echo $est?></option>
                                        <?php
                                        include("../particular/conexion.php");
                                        $consulta= "SELECT * FROM estado_ws ORDER BY ESTADO ASC";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_ESTADOWS'] ?>><?php echo $opciones['ESTADO']?></option>
                                        <?php endforeach?>
                                    </select>
                    </div>


                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm"class="col-form-label col-xl col-lg">PROVEEDOR: </label>
                        <select style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg" name="prov">
                                        <option selected value="800"><?php echo $pro?></option>
                                        <?php
                                        include("../particular/conexion.php");
                                        $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                        <?php endforeach?>
                                    </select>
                        <label id="lblForm"class="col-form-label col-xl col-lg">TIPO DE EQUIPO: </label>
                        <select style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg" name="tippc">
                                        <option selected value="900"><?php echo $tip?></option>
                                        <?php
                                        include("../particular/conexion.php");
                                        $consulta= "SELECT * FROM tipows ORDER BY TIPOWS ASC";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_TIPOWS'] ?>><?php echo $opciones['TIPOWS']?></option>
                                        <?php endforeach?>
                                    </select>
                    </div>


                    <div class="form-group row" style="margin: 10px; padding:10px;">            
                        <label id="lblForm"class="col-form-label col-xl col-lg">USUARIO: </label>
                        <select id="slcusu" style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg" name="usu">
                                        <option selected value="1000"><?php echo $usu?></option>
                                        <?php
                                        include("../particular/conexion.php");
                                        $consulta= "SELECT * FROM usuarios WHERE ID_ESTADOUSUARIO = 1 ORDER BY NOMBRE ASC";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_USUARIO'] ?>><?php echo $opciones['NOMBRE']?></option>
                                        <?php endforeach?>
                                    </select>
                        <label id="lblArea" style="font-size:24px;"class="col-form-label col-xl col-lg">AREA: </label>
                        <select id="slcarea" style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg" name="area" disabled>
                        <!-- falta verificar bien eñ value-->
                                        <option selected value="1100"><?php echo $area?></option>
                                        <?php
                                        include("../particular/conexion.php");
                                        $consulta= "SELECT * FROM area ORDER BY AREA ASC";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_AREA'] ?>><?php echo $opciones['AREA']?></option>
                                        <?php endforeach?>
                                    </select>
                    </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">            
                        <label id="lblForm"class="col-form-label col-xl col-lg">PROCEDENCIA:</label>
                            <select name="procedencia" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                            <option selected value="2400"><?php echo $procedencia?></option>
                                <?php
                                include("../particular/conexion.php");
                                $consulta= "SELECT * FROM procedencia ORDER BY PROCEDENCIA ASC";
                                $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                ?>
                                <?php foreach ($ejecutar as $opciones): ?> 
                                <option value= <?php echo $opciones['ID_PROCEDENCIA'] ?>><?php echo $opciones['PROCEDENCIA']?></option>
                                <?php endforeach?>
                            </select>

                        <label id="lblForm"class="col-form-label col-xl col-lg">MARCA: </label>
                        <select style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg" name="marca">
                                        <option selected value="1100"><?php echo $mar?></option>
                                        <?php
                                        include("../particular/conexion.php");
                                        $consulta= "SELECT * FROM marcas ORDER BY MARCA ASC";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_MARCA'] ?>><?php echo $opciones['MARCA']?></option>
                                        <?php endforeach?>
                                    </select>
                    </div>




<div class="accordion accordion-flush" id="accordionFlushExample" style="margin-top: 25px;">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingpm">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapsepm" aria-expanded="false" aria-controls="flush-collapsepm">
      <u>PLACA MADRE</u>
      </button>
    </h2>
    <div id="flush-collapsepm" class="accordion-collapse collapse" aria-labelledby="flush-headingpm" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">PLACA:</label> 
							    <select name="placam" style="text-transform:uppercase" class="form-control col-xl col-lg">
                      <option selected value="2000"><?php echo $placam?></option>
                      <?php
                      include("../particular/conexion.php");
                      $consulta= "SELECT p.ID_PLACAM, p.PLACAM, m.MARCA
                      FROM placam p
                      INNER JOIN marcas m ON m.ID_MARCA = p.ID_MARCA
                      ORDER BY PLACAM ASC";
                      $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                      ?>
                      <?php foreach ($ejecutar as $opciones): ?> 
                      <option value= <?php echo $opciones['ID_PLACAM'] ?>><?php echo $opciones['PLACAM'].' - '.$opciones['MARCA']?></option>
                      <?php endforeach?>
                  </select>
          <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="placamprov" style="text-transform:uppercase" class="form-control col-xl col-lg">
                      <option selected value="2001"><?php echo $placamprov?></option>
                      <?php
                      include("../particular/conexion.php");
                      $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                      $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                      ?>
                      <?php foreach ($ejecutar as $opciones): ?> 
                      <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                      <?php endforeach?>
                  </select>
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="placamfact" value="<?php echo $placamfact?>">
							<label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="placamfecha" value="<?php echo $placamfecha?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="placamgar" value="<?php echo $placamgar?>">
              <label id="lblForm"class="col-form-label col-xl col-lg">N°SERIE:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="planro" value="<?php echo $planro?>">
        </div>
      </div>
    </div>
  </div>















<!-- <h1 style="font-size: 32px; color: #5c6f82; text-decoration: underline;">MICROPROCESADOR</h1> -->

<div class="accordion accordion-flush" id="accordionFlushExample" style="margin-top: 25px;">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingmi">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapsemi" aria-expanded="false" aria-controls="flush-collapsepmi">
      <u>MICROPROCESADOR</u>
      </button>
    </h2>
    <div id="flush-collapsemi" class="accordion-collapse collapse" aria-labelledby="flush-headingmi" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MICRO:</label> 
							    <select name="micro" style="text-transform:uppercase" class="form-control col-xl col-lg">
                    <option selected value="2100"><?php echo $micro?></option>
                    <?php
                    include("../particular/conexion.php");
                    $consulta= "SELECT m.ID_MICRO, m.MICRO, ma.MARCA 
                    FROM micro m
                    INNER JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                    ORDER BY MICRO ASC";
                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                    ?>
                    <?php foreach ($ejecutar as $opciones):?> 
                    <option value= <?php echo $opciones['ID_MICRO'] ?>><?php echo $opciones['MICRO'].' - '.$opciones['MARCA']?></option>
                    <?php endforeach?>
                  </select>
          <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="microprov" style="text-transform:uppercase" class="form-control col-xl col-lg">
                    <option selected value="2101"><?php echo $microprov?></option>
                    <?php
                    include("../particular/conexion.php");
                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?> 
                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                    <?php endforeach?>
                  </select>
        </div>

     
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="microfac" value="<?php echo $microfac?>">
							<label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="microfec" value="<?php echo $microfec?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="microgar" value="<?php echo $microgar?>">
              <label id="lblForm"class="col-form-label col-xl col-lg">N°SERIE:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="micnro" value="<?php echo $micnro?>">
        </div>
      </div>
    </div>
  </div> 









<!-- <h1 style="font-size: 32px; color: #5c6f82; text-decoration: underline;">PLACA DE VIDEO</h1> -->

<div class="accordion accordion-flush" id="accordionFlushExample" style="margin-top: 25px;">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingpl">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapsepl" aria-expanded="false" aria-controls="flush-collapsepl">
      <u>1°&nbspPLACA DE VIDEO</u>
      </button>
    </h2>
    <div id="flush-collapsepl" class="accordion-collapse collapse" aria-labelledby="flush-headingpl" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
            <label id="lblForm" class="col-form-label col-xl col-lg">N° SERIE:</label> 
            <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="pvnserie" value="<?php echo $pvnserie?>">
            <label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
            <input type="date" class="form-control col-xl col-lg" name="pvfec" value="<?php echo $pvfec?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="pvfact" value="<?php echo $pvfact?>">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="pvgar" value="<?php echo $pvgar?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">PLACA:</label> 
							    <select name="pvmem" style="text-transform:uppercase" class="form-control col-xl col-lg">
                  <option selected value="2200"><?php echo $pvmem?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT m.MODELO, me.MEMORIA, t.TIPOMEM, p.ID_PVIDEO
                                    FROM pvideo p
                                    LEFT JOIN modelo m ON m.ID_MODELO = p.ID_MODELO
                                    LEFT JOIN memoria me ON me.ID_MEMORIA = p.ID_MEMORIA
                                    LEFT JOIN tipomem t ON t.ID_TIPOMEM = p.ID_TIPOMEM
                                    LEFT JOIN tipop ti ON ti.ID_TIPOP = m.ID_TIPOP
                                    WHERE ti.ID_TIPOP = 15
                                    ORDER BY m.MODELO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PVIDEO'] ?>><?php echo $opciones['MODELO']." - ".$opciones['MEMORIA']." - ".$opciones['TIPOMEM']?></option>
                                    <?php endforeach?>
                                </select>
          <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="pvprov" style="text-transform:uppercase" class="form-control col-xl col-lg">
                  <option selected value="2201"><?php echo $pvprov?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
        </div>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingpl1">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapsepl1" aria-expanded="false" aria-controls="flush-collapsepl1">
      <u>2°&nbspPLACA DE VIDEO</u>
      </button>
    </h2>
    <div id="flush-collapsepl1" class="accordion-collapse collapse" aria-labelledby="flush-headingpl1" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">N° SERIE:</label> 
          <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="pvnserie1" value="<?php echo $pvnserie1?>">
          <label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
          <input type="date" class="form-control col-xl col-lg" name="pvfec1" value="<?php echo $pvfec1?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
          <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="pvfact1" value="<?php echo $pvfact1?>">
					<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
          <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="pvgar1" value="<?php echo $pvgar1?>">
      </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">PLACA:</label> 
							    <select name="pvmem1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                  <option selected value="2300"><?php echo $pvmem1?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT m.MODELO, me.MEMORIA, t.TIPOMEM, p.ID_PVIDEO
                                    FROM pvideo p
                                    LEFT JOIN modelo m ON m.ID_MODELO = p.ID_MODELO
                                    LEFT JOIN memoria me ON me.ID_MEMORIA = p.ID_MEMORIA
                                    LEFT JOIN tipomem t ON t.ID_TIPOMEM = p.ID_TIPOMEM
                                    LEFT JOIN tipop ti ON ti.ID_TIPOP = m.ID_TIPOP
                                    WHERE ti.ID_TIPOP = 15
                                    ORDER BY m.MODELO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PVIDEO'] ?>><?php echo $opciones['MODELO']." - ".$opciones['MEMORIA']." - ".$opciones['TIPOMEM']?></option>
                                    <?php endforeach?>
                                </select>
          <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="pvprov1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                  <option selected value="2301"><?php echo $pvprov1?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
      </div>
        </div>
      </div>
    </div>
  </div>
</div>













<!-- <h1 style="font-size: 32px; color: #5c6f82; text-decoration: underline;">MEMORIAS</h1> -->

<div class="accordion accordion-flush" id="accordionFlushExample" style="margin-top: 25px;">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading1">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse1" aria-expanded="false" aria-controls="flush-collapse1">
      <u>1°&nbspMEMORIA</u>
      </button>
    </h2>
    <div id="flush-collapse1" class="accordion-collapse collapse" aria-labelledby="flush-heading1" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
      <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">CAPACIDAD:</label> 
				  <select name="mem1" style="text-transform:uppercase" class="form-control col-xl col-lg">
            <option selected value="1200"><?php echo $mem1?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM memoria ORDER BY MEMORIA ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MEMORIA'] ?>><?php echo $opciones['MEMORIA']?></option>
                                    <?php endforeach?>
                                </select>
					<label id="lblForm"class="col-form-label col-xl col-lg">TIPO:</label>
          <select name="tmem1" style="text-transform:uppercase" class="form-control col-xl col-lg">
              <option selected value="1201"><?php echo $tmem1?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM tipomem ORDER BY TIPOMEM ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOMEM'] ?>><?php echo $opciones['TIPOMEM']?></option>
                                    <?php endforeach?>
                                </select>
     </div>
     <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="prov1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1202"><?php echo $prov1?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="fact1" value="<?php echo $fact1?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MARCA:</label> 
							    <select name="marc1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1203"><?php echo $marc1?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM marcas ORDER BY MARCA ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MARCA'] ?>><?php echo $opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="fec1" value="<?php echo $fec1?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="gar1" value="<?php echo $gar1?>">
              <label id="lblForm" class="col-form-label col-xl col-lg">VELOCIDAD:</label> 
							    <select name="pvel1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                    <option selected value="1204"><?php echo $pvel1?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM velocidad ORDER BY FRECUENCIA_RAM ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_FRECUENCIA'] ?>><?php echo $opciones['FRECUENCIA_RAM']?></option>
                                    <?php endforeach?>
                                </select>
        </div>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading2">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse2" aria-expanded="false" aria-controls="flush-collapse2">
      <u>2°&nbspMEMORIA</u>
      </button>
    </h2>
    <div id="flush-collapse2" class="accordion-collapse collapse" aria-labelledby="flush-heading2" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
      <div class="form-group row" style="margin: 10px; padding:10px;">
                            <label id="lblForm" class="col-form-label col-xl col-lg">CAPACIDAD:</label> 
							    <select name="mem2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                <option selected value="1300"><?php echo $mem2?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM memoria ORDER BY MEMORIA ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MEMORIA'] ?>><?php echo $opciones['MEMORIA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">TIPO:</label>
                            <select name="tmem2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                            <option selected value="1301"><?php echo $tmem2?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM tipomem ORDER BY TIPOMEM ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOMEM'] ?>><?php echo $opciones['TIPOMEM']?></option>
                                    <?php endforeach?>
                                </select>
                        </div>
                        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="prov2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1302"><?php echo $prov2?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="fact2" value="<?php echo $fact2?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MARCA:</label> 
							    <select name="marc2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1303"><?php echo $marc2?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM marcas ORDER BY MARCA ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MARCA'] ?>><?php echo $opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="fec2" value="<?php echo $fec2?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="gar2" value="<?php echo $gar2?>">
              <label id="lblForm" class="col-form-label col-xl col-lg">VELOCIDAD:</label> 
							    <select name="pvel2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                  <option selected value="1304"><?php echo $pvel2?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM velocidad ORDER BY FRECUENCIA_RAM ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_FRECUENCIA'] ?>><?php echo $opciones['FRECUENCIA_RAM']?></option>
                                    <?php endforeach?>
                                </select>
        </div>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading3">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse3" aria-expanded="false" aria-controls="flush-collapse3">
      <u>3°&nbspMEMORIA</u>
      </button>
    </h2>
    <div id="flush-collapse3" class="accordion-collapse collapse" aria-labelledby="flush-heading3" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
      <div class="form-group row" style="margin: 10px; padding:10px;">
                            <label id="lblForm" class="col-form-label col-xl col-lg">CAPACIDAD:</label> 
							    <select name="mem3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                <option selected value="1400"><?php echo $mem3?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM memoria ORDER BY MEMORIA ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MEMORIA'] ?>><?php echo $opciones['MEMORIA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">TIPO:</label>
                            <select name="tmem3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                            <option selected value="1401"><?php echo $tmem3?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM tipomem ORDER BY TIPOMEM ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOMEM'] ?>><?php echo $opciones['TIPOMEM']?></option>
                                    <?php endforeach?>
                                </select>
                        </div>
                        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="prov3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1402"><?php echo $prov3?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="fact3" value="<?php echo $fact3?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MARCA:</label> 
							    <select name="marc3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1403"><?php echo $marc3?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM marcas ORDER BY MARCA ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MARCA'] ?>><?php echo $opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="fec3" value="<?php echo $fec3?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="gar3" value="<?php echo $gar3?>">
              <label id="lblForm" class="col-form-label col-xl col-lg">VELOCIDAD:</label> 
							    <select name="pvel3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                  <option selected value="1404"><?php echo $pvel3?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM velocidad ORDER BY FRECUENCIA_RAM ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_FRECUENCIA'] ?>><?php echo $opciones['FRECUENCIA_RAM']?></option>
                                    <?php endforeach?>
                                </select>
        </div> 
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading4">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse4" aria-expanded="false" aria-controls="flush-collapse4">
      <u>4°&nbspMEMORIA</u>
      </button>
    </h2>
    <div id="flush-collapse4" class="accordion-collapse collapse" aria-labelledby="flush-heading4" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
      <div class="form-group row" style="margin: 10px; padding:10px;">
                            <label id="lblForm" class="col-form-label col-xl col-lg">CAPACIDAD:</label> 
							    <select name="mem4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                <option selected value="1500"><?php echo $mem4?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM memoria ORDER BY MEMORIA ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MEMORIA'] ?>><?php echo $opciones['MEMORIA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">TIPO:</label>
                            <select name="tmem4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                            <option selected value="1501"><?php echo $tmem4?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM tipomem ORDER BY TIPOMEM ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOMEM'] ?>><?php echo $opciones['TIPOMEM']?></option>
                                    <?php endforeach?>
                                </select>
                        </div>
                        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="prov4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1502"><?php echo $prov4?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="fact4" value="<?php echo $fact4?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MARCA:</label> 
							    <select name="marc4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1503"><?php echo $marc4?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM marcas ORDER BY MARCA ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MARCA'] ?>><?php echo $opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="fec4" value="<?php echo $fec4?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="gar4" value="<?php echo $gar4?>">
              <label id="lblForm" class="col-form-label col-xl col-lg">VELOCIDAD:</label> 
							    <select name="pvel4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                  <option selected value="1504"><?php echo $pvel4?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM velocidad ORDER BY FRECUENCIA_RAM ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_FRECUENCIA'] ?>><?php echo $opciones['FRECUENCIA_RAM']?></option>
                                    <?php endforeach?>
                                </select>
        </div>
      </div>
    </div>
  </div>
</div>








                        

<!-- <h1 style="font-size: 32px; color: #5c6f82; text-decoration: underline;">DISCOS</h1> -->

<div class="accordion accordion-flush" id="accordionFlushExample" style="margin-top: 25px;">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
      <u>1°&nbspDISCO</u>
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">SLOT DISCO 1:</label>
                            <select name="disc1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                            <option selected value="1600"><?php echo $disc1?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM disco ORDER BY DISCO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_DISCO'] ?>><?php echo $opciones['DISCO']?></option>
                                    <?php endforeach?>
                                </select>
                            <label id="lblForm"class="col-form-label col-xl col-lg">TIPO DISCO 1:</label>
                            <select name="tdisc1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                            <option selected value="1601"><?php echo $tdisc1?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM tipodisco ORDER BY TIPOD ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOD'] ?>><?php echo $opciones['TIPOD']?></option>
                                    <?php endforeach?>
                                </select>
                        </div>
                        <div class="form-group row" style="margin: 10px; padding:10px;">
            <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="dprov1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1602"><?php echo $dprov1?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="dfact1" value="<?php echo $dfact1?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MODELO:</label> 
							    <select name="dmod1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1603"><?php echo $dmod1?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT m.ID_MODELO, m.MODELO, ma.MARCA 
                                    FROM modelo m
                                    INNER JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                                    WHERE m.ID_TIPOP = 14
                                    ORDER BY m.MODELO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MODELO'] ?>><?php echo $opciones['MODELO']." - ".$opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
                                <label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="dfec1" value="<?php echo $dfec1?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="dgar1" value="<?php echo $dgar1?>">
        </div> 
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
      <u>2°&nbspDISCO</u>
      </button>
    </h2>
    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
      <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">SLOT DISCO 2:</label>
                            <select name="disc2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                            <option selected value="1700"><?php echo $disc2?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM disco ORDER BY DISCO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_DISCO'] ?>><?php echo $opciones['DISCO']?></option>
                                    <?php endforeach?>
                                </select>
                            <label id="lblForm"class="col-form-label col-xl col-lg">TIPO DISCO 2:</label>
                            <select name="tdisc2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                            <option selected value="1701"><?php echo $tdisc2?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM tipodisco ORDER BY TIPOD ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOD'] ?>><?php echo $opciones['TIPOD']?></option>
                                    <?php endforeach?>
                                </select>
                        </div>
                        <div class="form-group row" style="margin: 10px; padding:10px;">
            <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="dprov2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1702"><?php echo $dprov2?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="dfact2" value="<?php echo $dfact2?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MODELO:</label> 
							    <select name="dmod2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1703"><?php echo $dmod2?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT m.ID_MODELO, m.MODELO, ma.MARCA 
                                    FROM modelo m
                                    INNER JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                                    WHERE m.ID_TIPOP = 14
                                    ORDER BY m.MODELO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MODELO'] ?>><?php echo $opciones['MODELO']." - ".$opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
                                <label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="dfec2" value="<?php echo $dfec2?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="dgar2" value="<?php echo $dgar2?>">
        </div> 
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
      <u>3°&nbspDISCO</u>
      </button>
    </h2>
    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
      <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">SLOT DISCO 3:</label>
                            <select name="disc3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                            <option selected value="1800"><?php echo $disc3?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM disco ORDER BY DISCO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_DISCO'] ?>><?php echo $opciones['DISCO']?></option>
                                    <?php endforeach?>
                                </select>
                            <label id="lblForm"class="col-form-label col-xl col-lg">TIPO DISCO 3:</label>
                            <select name="tdisc3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                            <option selected value="1801"><?php echo $tdisc4?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM tipodisco ORDER BY TIPOD ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOD'] ?>><?php echo $opciones['TIPOD']?></option>
                                    <?php endforeach?>
                                </select>
                        </div>
                        <div class="form-group row" style="margin: 10px; padding:10px;">
            <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="dprov3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1802"><?php echo $dprov3?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="dfact3" value="<?php echo $dfact3?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MODELO:</label> 
							    <select name="dmod3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1803"><?php echo $dmod3?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT m.ID_MODELO, m.MODELO, ma.MARCA 
                                    FROM modelo m
                                    INNER JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                                    WHERE m.ID_TIPOP = 14
                                    ORDER BY m.MODELO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MODELO'] ?>><?php echo $opciones['MODELO']." - ".$opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
                                <label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="dfec3" value="<?php echo $dfec3?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="dgar3" value="<?php echo $dgar3?>">
        </div> 
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
      <u>4°&nbspDISCO</u>
      </button>
    </h2>
    <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
      <div class="form-group row" style="margin: 10px; padding:10px;">
			<label id="lblForm"class="col-form-label col-xl col-lg">SLOT DISCO 4:</label>
                            <select name="disc4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                            <option selected value="1900"><?php echo $disc4?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM disco ORDER BY DISCO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_DISCO'] ?>><?php echo $opciones['DISCO']?></option>
                                    <?php endforeach?>
                                </select>
                            <label id="lblForm"class="col-form-label col-xl col-lg">TIPO DISCO 4:</label>
                            <select name="tdisc4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                            <option selected value="1901"><?php echo $tdisc4?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM tipodisco ORDER BY TIPOD ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOD'] ?>><?php echo $opciones['TIPOD']?></option>
                                    <?php endforeach?>
                                </select>
                        </div>
                        <div class="form-group row" style="margin: 10px; padding:10px;">
            <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="dprov4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                  <option selected value="1902"><?php echo $dprov4?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="dfact4" value="<?php echo $dfact4?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MODELO:</label> 
							    <select name="dmod4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1903"><?php echo $dmod4?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT m.ID_MODELO, m.MODELO, ma.MARCA 
                                    FROM modelo m
                                    INNER JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                                    WHERE m.ID_TIPOP = 14
                                    ORDER BY m.MODELO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MODELO'] ?>><?php echo $opciones['MODELO']." - ".$opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
                                <label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="dfec4" value="<?php echo $dfec4?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="dgar4" value="<?php echo $dgar4?>">
        </div> 
      </div>
    </div>
  </div>
</div>

                    <div class="form-group row justify-content-end" style="margin: 10px; padding:10px;">
					    <input style="width:20%" onClick="enviarFormulario(this.form)"class="col-3 button" type="button" value="MODIFICAR" class="button">
				    </div>
                </form>
	    </div>
	</section>
  <script>
      function enviarFormulario(formulario){
        // var formulario = document.getElementById('form_carga');
        Swal.fire({
                        title: "Esta seguro de modificar este equipo?",
                        icon: "warning",
                        showConfirmButton: true,
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: "Cancelar",
                        customClass:{
                            actions: 'reverse-button'
                        }
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            formulario.submit();
                            


                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
      }
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
        <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>