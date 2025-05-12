<?php 
error_reporting(0);
session_start();
include('../particular/conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
    $datos_base = mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');

	$no_tic = mysqli_real_escape_string($datos_base, $no_tic);

    $sentencia = "SELECT * FROM periferico WHERE ID_PERI='" . $no_tic . "'";
    $resultado = mysqli_query($datos_base, $sentencia);

    return mysqli_fetch_assoc($resultado);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>MODIFICAR IMPRESORA</title>
    <link rel="icon" href="../imagenes/logoInfraestructura.png">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
</head>
<body>
<script>
function enviar_formulario(formulario){
        	
				Swal.fire({
                        title: "Esta seguro de guardar esta impresora?",
                        icon: "warning",
                        showConfirmButton: true,
                        showCancelButton: true,
              confirmButtonColor: '#198754',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar',
                cancelButtonText: "Cancelar",
                reverseButtons: true,
                        customClass:{
                            actions: 'reverse-button'
                        }
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            formulario.submit()


                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
			
		}
				
		</script>
<main>
    <div id="reporteEst">   
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="../consulta/impresoras.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
	<section id="Inicio">
    <div id="titulo">
			<h1>MODIFICAR IMPRESORA</h1>
		</div>
        <div id="principalu" style="width: 97%" class="container-fluid">

                        <!--  CONSULTA DE DATOS -->
                        <?php 
                        include("../particular/conexion.php");
                        function obtenerCampoPorId($conexion, $tabla, $campo, $id_nombre, $id_valor) {
                            $id_valor = (int)$id_valor;
                        
                            $sql = "SELECT $campo FROM $tabla WHERE $id_nombre = $id_valor";
                            $resultado = $conexion->query($sql);
                        
                            if ($resultado && $fila = $resultado->fetch_assoc()) {
                                return $fila[$campo];
                            }
                            return null;
                        }

                        $tip = obtenerCampoPorId($datos_base, 'tipop', 'TIPO', 'ID_TIPOP', $consulta['ID_TIPOP']);
                        $proc = obtenerCampoPorId($datos_base, 'procedencia', 'PROCEDENCIA', 'ID_PROCEDENCIA', $consulta['ID_PROCEDENCIA']);
                        $prov = obtenerCampoPorId($datos_base, 'proveedor', 'PROVEEDOR', 'ID_PROVEEDOR', $consulta['ID_PROVEEDOR']);
                        $est = obtenerCampoPorId($datos_base, 'estado_ws', 'ESTADO', 'ID_ESTADOWS', $consulta['ID_ESTADOWS']);
                        

                        $sent= "SELECT ep.ID_WS, i.SERIEG
                        FROM equipo_periferico ep
                        LEFT JOIN inventario i ON i.ID_WS = ep.ID_WS
                        WHERE ep.ID_PERI = $consulta[ID_PERI]
                        ORDER BY ep.ID_EQUIPO_PERIFERICO DESC
                        LIMIT 1";
                        $resultado = $datos_base->query($sent);
                        $row = $resultado->fetch_assoc();
                        $ws = $row['ID_WS'];
                        $equip = $row['SERIEG'];

                        $sent= "SELECT u.NOMBRE
                        FROM wsusuario ws
                        LEFT JOIN usuarios u ON u.ID_USUARIO = ws.ID_USUARIO
                        WHERE ws.ID_WS = $ws
                        ORDER BY ws.ID_WSUSU DESC
                        LIMIT 1";
                        $resultado = $datos_base->query($sent);
                        $row = $resultado->fetch_assoc();
                        $usu = $row['NOMBRE'];

                        $sent= "SELECT mo.MODELO, ma.MARCA 
                        FROM modelo mo
                        INNER JOIN marcas ma ON ma.ID_MARCA = mo.ID_MARCA
                        WHERE mo.ID_MODELO = $consulta[ID_MODELO]";
                        $resultado = $datos_base->query($sent);
                        $row = $resultado->fetch_assoc();
                        $mod = $row['MODELO']." - ".$row['MARCA'];?>
                        <!--  CONSULTA DE DATOS -->

                <form method="POST" action="./modificados.php">
                    <div class="form-group row">
                        <label id="lblForm"class="col-form-label col-xl col-lg">ID:</label>
                        <input type="text" class="id" name="id" value="<?php echo $consulta['ID_PERI']?>" style="background-color:transparent;" readonly>
                    </div>

                    <div class="form-group row">
                        <label id="lblForm"class="col-form-label col-xl col-lg">N° GOBIERNO: </label>
                        <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="serieg" value="<?php echo $consulta['SERIEG']?>">
                    </div>

                    <div class="form-group row">
                        <label id="lblForm"class="col-form-label col-xl col-lg">N° SERIE: </label>
                        <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="serie" value="<?php echo $consulta['SERIE']?>">
                    </div>
                    
                    <div class="form-group row">
                        <label id="lblForm"class="col-form-label col-xl col-lg">MAC: </label>
                        <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="mac" value="<?php echo $consulta['MAC']?>">
                    </div>
                    <div class="form-group row">
                        <label id="lblForm"class="col-form-label col-xl col-lg">OBSERVACIÓN: </label>
                        <textarea style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" name="obs" rows="3"><?php echo $consulta['OBSERVACION']?></textarea>
                    </div>
                    
                    <div class="form-group row">
                        <label id="lblForm"class="col-form-label col-xl col-lg">IP: </label>
                        <input style="margin-top: 5px"class="form-control col-form-label col-xl col-lg" type="text" name="ip" value="<?php echo $consulta['IP']?>">
                    </div>
                    <div class="form-group row">
                        <label id="lblForm"class="col-form-label col-xl col-lg">FACTURA: </label>
                        <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="factura" value="<?php echo $consulta['FACTURA']?>">
                    </div>
                    
                    <div class="form-group row">
                        <label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA: </label>
                        <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="garantia" value="<?php echo $consulta['GARANTIA']?>">
                    </div>

                    <div class="form-group row">
                        <label id="lblForm"class="col-form-label col-xl col-lg">RIP: </label>
                        <select name="rip" style="margin-top: 5px"class="form-control col-form-label col-xl col-lg">
                        <option selected value="100"><?php echo $consulta['RIP']?></option>
                        <option value ="NO">NO</option>
                        <option value="SI">SI</option>
                        </select>
                    </div>

                    <div class="form-group row">
                        <label id="lblForm"class="col-form-label col-xl col-lg">MODELO:</label>
                        <select name="modelo" style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg">
                        <option selected value="200"><?php echo $mod?></option>
                        <?php
                        include("../particular/conexion.php");
                        $consulta= "SELECT m.ID_MODELO, m.MODELO, ma.MARCA
                        FROM modelo m
                        INNER JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                        INNER JOIN tipop t ON t.ID_TIPOP = m.ID_TIPOP
                        WHERE (m.ID_TIPOP = 1 OR m.ID_TIPOP = 2 OR m.ID_TIPOP = 3 OR m.ID_TIPOP = 4 OR m.ID_TIPOP = 10 OR m.ID_TIPOP = 13) ORDER BY MODELO ASC";
                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?> 
                        <option value= <?php echo $opciones['ID_MODELO'] ?>><?php echo $opciones['MODELO']." - ".$opciones['MARCA']?></option>
                        <?php endforeach?>
                        </select>
                    </div>
                    
                    <div class="form-group row">
                        <label id="lblForm"class="col-form-label col-xl col-lg">ESTADO: </label>
                        <select name="estado" style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg">
                        <option selected value="300"><?php echo $est?></option>
                        <?php
                        include("conexion.php");
                        $consulta= "SELECT * FROM estado_ws ORDER BY ESTADO ASC";
                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?> 
                        <option value= <?php echo $opciones['ID_ESTADOWS'] ?>><?php echo $opciones['ESTADO']?></option>
                        <?php endforeach?>
                        </select>
                    </div>
                                    
                    <div class="form-group row">
                        <label id="lblForm"class="col-form-label col-xl col-lg">PROVEEDOR: </label>
                        <select name="prov" style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg">
                        <option selected value="400"><?php echo $prov?></option>
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

                    <div class="form-group row">
                        <label id="lblForm"class="col-form-label col-xl col-lg">TIPO DE IMPRESORA: </label>
                        <select name="tipop" style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg">
                        <option selected value="500"><?php echo $tip?></option>
                        <?php
                        include("../particular/conexion.php");
                        $consulta= "SELECT * FROM tipop WHERE ID_TIPOP = 1 OR ID_TIPOP = 2 OR ID_TIPOP = 3 OR ID_TIPOP = 4 OR ID_TIPOP = 10 OR ID_TIPOP = 13 ORDER BY TIPO ASC";
                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?> 
                        <option value= <?php echo $opciones['ID_TIPOP'] ?>><?php echo $opciones['TIPO']?></option>
                        <?php endforeach?>
                        </select>
                    </div>

                    <div class="form-group row">
                        <label id="lblForm"class="col-form-label col-xl col-lg">EQUIPO AL CUÁL ESTÁ ASIGNADO: </label>
                        <select name="equip" style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg">
                        <option selected value="600"><?php echo $usu." - ".$equip?></option>
                        <?php
                        $consulta= "SELECT u.NOMBRE, i.SERIEG, w.ID_WS, i.ID_TIPOWS
                        FROM wsusuario w
                        INNER JOIN usuarios u ON u.ID_USUARIO = w.ID_USUARIO
                        INNER JOIN inventario i ON i.ID_WS = w.ID_WS
                        WHERE u.ID_ESTADOUSUARIO = 1 
                        AND w.ID_WS <> 0 
                        AND w.ID_USUARIO <> 277
                        AND i.ID_TIPOWS = 1 /* PC */
                        ORDER BY u.NOMBRE ASC";
                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?> 
                        <option value= <?php echo $opciones['ID_WS'] ?>><?php echo $opciones['NOMBRE']." - ".$opciones['SERIEG']?></option>
                        <?php endforeach?>
                        </select>
                    </div>

                    <div class="form-group row">     
                        <label id="lblForm"class="col-form-label col-xl col-lg">PROCEDENCIA: </label>
                        <select name="proc" style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg" required>
                        <option selected value="800"><?php echo $proc?></option>
                        <?php
                        include("../particular/conexion.php");
                        $consulta= "SELECT * FROM procedencia ORDER BY PROCEDENCIA ASC";
                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?> 
                        <option value= <?php echo $opciones['ID_PROCEDENCIA'] ?>><?php echo $opciones['PROCEDENCIA']?></option>
                        <?php endforeach?>
                        </select>
                    </div>
                    <!--/////////////////////////////////////MOTIVO///////////////////////////////////////////-->
                    <!--/////////////////////////////////////MOTIVO///////////////////////////////////////////-->
                    <div class="form-group row justify-content-end">
					    <input onClick="enviar_formulario(this.form)" style="width:20%"class="btn btn-success" type="button" name="modImpresora" value="MODIFICAR" class="button">
				    </div>
                </form>
	    </div>
	</section>
    </main>
	<footer>
		<div class="footer">
			<div class="container-fluid">
				<div class="row">
					<img src="../imagenes/cba-logo.png" class="img-fluid">
				</div>
			</div>
		</div>
    </footer>
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
</body>
</html>