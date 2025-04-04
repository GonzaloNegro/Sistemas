<?php 
session_start();
include('../particular/conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: ../particular/Inicio.php'); 
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT ID_RESOLUTOR, CUIL, RESOLUTOR, ID_PERFIL FROM resolutor WHERE CUIL='$iduser'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
	<title>INVENTARIO EQUIPOS</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymus"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloconsulta.css">
    <script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
    <!--BUSCADOR SELECT-->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<!--FIN BUSCADOR SELECT-->
	<!--Estilo bootstrap para select2-->
	<link rel="stylesheet" href="/path/to/select2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
    <script>
	function ok(){
        Swal.fire({
                    title: "Equipo cargado correctamente.",
                    icon: "success",
                    showConfirmButton: true,
                    showCancelButton: false,
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
                        window.location.href='abmequipos.php';


                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info')
                    }
                })
        }	

	function no(){
        Swal.fire({
                    title: "El equipo ya está registrado",
                    icon: "error",
                    showConfirmButton: true,
                    showCancelButton: false,
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
                        window.location.href='agregarequipo.php';


                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info')
                    }
                })
        }

    function okMod(){
        Swal,fire(  {title: "Equipo modificado correctamente",
                icon: "success",
                showConfirmButton: true,
                showCancelButton: false,
                })
                .then((confirmar) => {
                if (confirmar) {
                    window.location.href='abmequipos.php';
                }
                }
                );
        }
    function noMod(){
        Swal.fire(  {title: "El equipo ingresado ya está registrado",
                icon: "error",
                })
                .then((confirmar) => {
                if (confirmar) {
                    window.location.href='abmequipos.php';
                }
                }
                );
        }	


    //Funcion que va mostrando que filtros se van utilizando
    function mostrarFiltros(){
        const busqueda = $("#buscar");
        const area = $("#area");
        const reparticion = $("#reparticion");
        const orden = $("#orden"); 
        const tipows = $("#tipows"); 
        const so = $("#so"); 
        const micro = $("#micro"); 
        const estado = $("#estado");
        
        const filtros = $("#filtrosUsados");
        // Vaciar el div antes de agregar nuevos filtros
        filtros.empty();

        
        filtros.append();
        
        if (busqueda.val() != '') {
            filtros.append(`<li style="color:blue; margin-left: 15px;"><u>BÚSQUEDA</u>: ${busqueda.val()}</li>`);
        }
        
        if (area.val() != '') {
            filtros.append(`<li style="color:blue; margin-left: 15px;"><u>AREA</u>: ${$("#area option:selected").text()}</li>`);
        }
        if (reparticion.val() != '') {
            filtros.append(`<li style="color:blue; margin-left: 15px;"><u>REPARTICION</u>: ${$("#reparticion option:selected").text()}</li>`);
        }
        if (tipows.val() != '') {
            filtros.append(`<li style="color:blue; margin-left: 15px;"><u>TIPO WS</u>: ${$("#tipows option:selected").text()}</li>`);
        }if (so.val() != '') {
            filtros.append(`<li style="color:blue; margin-left: 15px;"><u>S.O.</u>: ${$("#so option:selected").text()}</li>`);
        }if (micro.val() != '') {
            filtros.append(`<li style="color:blue; margin-left: 15px;"><u>MICRO</u>: ${$("#micro option:selected").text()}</li>`);
        }if (estado.val() != '') {
            filtros.append(`<li style="color:blue; margin-left: 15px;"><u>ESTADO</u>: ${$("#estado option:selected").text()}</li>`);
        }
        if (orden.val() != '') {
            filtros.append(`<li style="color:blue; margin-left: 15px;"><u>ORDEN</u>: ${$("#orden option:selected").text()}</li>`);
        }

        filtros.show();
    }
    </script>
             <script>
                //Cargar datos en la tabla
        $(document).ready(function () {
            function cargarDatos(pagina = 1) {
                // Obtener valor del formulario
                const busqueda = $("#buscar").val();
                const area = $("#area").val();
                const reparticion = $("#reparticion").val();
                const orden = $("#orden").val(); 
                const tipows = $("#tipows").val(); 
                const so = $("#so").val(); 
                const micro = $("#micro").val(); 
                const estado = $("#estado").val();
                //Obtener los datos de la tabla de usuarios
                $.ajax({
                    url: "paginador_inventario.php", // Archivo PHP
                    type: "GET",
                    data: { 
                            pagina: pagina,
                            busqueda: busqueda,
                            area: area,
                            reparticion: reparticion,
                            orden: orden,
                            tipows: tipows,
                            so: so,
                            micro: micro,
                            estado: estado,
                             },
                    dataType: "json",
                    //Respuesta obtenida de paginador.php
                    success: function (respuesta) {
                        //Cargamos el nro de incidentes obtenidos en label
                        
                        const lblUsuarios = $("#nroInventario").text("Resultados Encontrados: "+respuesta.totalInventario); 

                        //Cargamos la consulta sql utilizada en el value del input del formulario para generar el excel
                        

                         const inputExcel = $("#excel");
                         inputExcel.val(respuesta.query);

                        // Poblar la tabla
                        const tabla = $("#tabla-datos");
                        tabla.empty();
                        respuesta.datos.forEach(fila => {
                            let estado = fila.ESTADO;  // Este valor lo obtienes de tu lógica o de una variable
                            let color;

                            if (estado === "EN USO") {
                            color = "green";  // Si el estado es "en uso", el color será verde
                            } else if(estado === "BAJA") {
                            color = "red";  // Si el estado no es "baja", el color será rojo
                            } else if(estado === "S/A - STOCK") {
                            color = "blue";  // Si el estado no es "solucionado", el color será rojo
                            }
                            
                            tabla.append(`<tr>
                                <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>${fila.REPA}</h4></td>
                                <td><h4 style='font-size:14px;text-align:left;margin-left: 5px;'>${fila.AREA}</h4></td>
                                <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>${fila.NOMBRE}</h4></td>
                                <td><h4 style='max-width:180px;font-size:14px; text-align:left;margin-left: 5px;'>${fila.SERIEG}</h4></td>
                                <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>${fila.SIST_OP}</h4></td>
                                <td><h4 style='font-size:14px;text-align:left;margin-left: 5px;'>${fila.MICRO}</h4></td>
                                <td><h4 style='font-size:14px;text-align:left;margin-left: 5px;'>${fila.TIPOWS}</h4></td>
                                <td><h4 style='font-size:14px;text-align:left;margin-left: 5px;'>${fila.OBSERVACION}</h4></td>
                                <td><h4 style='color:${color};font-size:14px;text-align:left;margin-left: 5px;'>${fila.ESTADO}</h4></td>
                                <td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary'  target='_blank' href=consultadetalleinv.php?no=${fila.ID_WS} target=new class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
                                <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
                                <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                                </svg></a>
                                <a class='btn btn-sm btn-outline-danger' target='_blank' href=../equipos/${fila.SERIEG}.pdf target=new><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-filetype-pdf' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM1.6 11.85H0v3.999h.791v-1.342h.803c.287 0 .531-.057.732-.173.203-.117.358-.275.463-.474a1.42 1.42 0 0 0 .161-.677c0-.25-.053-.476-.158-.677a1.176 1.176 0 0 0-.46-.477c-.2-.12-.443-.179-.732-.179Zm.545 1.333a.795.795 0 0 1-.085.38.574.574 0 0 1-.238.241.794.794 0 0 1-.375.082H.788V12.48h.66c.218 0 .389.06.512.181.123.122.185.296.185.522Zm1.217-1.333v3.999h1.46c.401 0 .734-.08.998-.237a1.45 1.45 0 0 0 .595-.689c.13-.3.196-.662.196-1.084 0-.42-.065-.778-.196-1.075a1.426 1.426 0 0 0-.589-.68c-.264-.156-.599-.234-1.005-.234H3.362Zm.791.645h.563c.248 0 .45.05.609.152a.89.89 0 0 1 .354.454c.079.201.118.452.118.753a2.3 2.3 0 0 1-.068.592 1.14 1.14 0 0 1-.196.422.8.8 0 0 1-.334.252 1.298 1.298 0 0 1-.483.082h-.563v-2.707Zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638H7.896Z'/></svg></a>
                                </td>
                            </tr>`);
                        });

                        // Crear los botones de paginación
                        const paginador = $("#paginador");
                        paginador.empty();
                        
                        
                        const totalPaginas = respuesta.totalPaginas;
                    const paginaActual = respuesta.pagina;

                    // Función para agregar un botón
                    function agregarBoton(pagina, texto, activo = false, desactivado = false) {
                        paginador.append(`
                            <li class="page-item ${activo ? 'active' : ''} ${desactivado ? 'disabled' : ''}">
                                <button class="page-link btn-pagina" data-pagina="${pagina}" ${desactivado ? 'disabled' : ''}>
                                    ${texto}
                                </button>
                            </li>
                        `);
                    }

                    // Botón "Anterior"
                    agregarBoton(paginaActual - 1, '&laquo; Anterior', false, paginaActual === 1);

                    // Primera página
                    agregarBoton(1, '1', paginaActual === 1);

                    // Puntos suspensivos si la página actual está lejos de la primera
                    if (paginaActual > 4) {
                        paginador.append('<li class="page-item disabled"><span class="page-link">...</span></li>');
                    }

                    // Páginas cercanas a la actual
                    for (let i = Math.max(2, paginaActual - 2); i <= Math.min(totalPaginas - 1, paginaActual + 2); i++) {
                        agregarBoton(i, i, paginaActual === i);
                    }

                    // Puntos suspensivos si la página actual está lejos de la última
                    if (paginaActual < totalPaginas - 3) {
                        paginador.append('<li class="page-item disabled"><span class="page-link">...</span></li>');
                    }

                    // Última página
                    agregarBoton(totalPaginas, totalPaginas, paginaActual === totalPaginas);

                    // Botón "Siguiente"
                    agregarBoton(paginaActual + 1, 'Siguiente &raquo;', false, paginaActual === totalPaginas);
                    ////
                    }
                });
            }

            // Manejar el evento del formulario de filtro
            $("#btnForm").on("click", function (e) {
                //e.preventDefault(); // Evitar recarga de la página
                cargarDatos(1); // Cargar datos desde la primera página con el filtro aplicado
                mostrarFiltros();
            });

            // Cargar la página inicial
            cargarDatos();

            // Evento para cambiar de página
            $(document).on("click", ".btn-pagina", function () {
                const pagina = $(this).data("pagina");
                cargarDatos(pagina);
            });
        });
    </script>
    <script>
        //Limpiar campos de formulario
        function Limpiar(){
            window.location.href='../consulta/inventario.php';
        }
    </script>
<?php include('../layout/inventario.php'); ?>
		<style>
			#h2{
	              text-align: left;	
	              font-family: TrasandinaBook;
	              font-size: 16px;
	              color: #edf0f5;
	              margin-left: 10px;
	              margin-top: 5px;;
               
				}
        </style>
 <section id="consulta">
		<div id="titulo">
			<h1>INVENTARIO DE EQUIPOS</h1>
		</div>
        <!-- <form method="POST" action="./inventario.php" class="contFilter--name"> -->
            <div class="filtros">
                <div class="filtros-listado">
                    <div>
                        <label class="form-label">Usuario/N°WS/Observación</label>
                        <input type="text" style="text-transform:uppercase;" id ="buscar" name="buscar"  placeholder="Buscar" class="form-control largo">
                    </div>
                    <div>
                        <label class="form-label">Área</label>
                        <select id="area" name="area" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT a.ID_AREA, a.AREA, r.REPA FROM area a inner join reparticion r on a.ID_REPA=r.ID_REPA ORDER BY AREA ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_AREA']?>"><?php echo $opciones['AREA']?> - <?php echo $opciones['REPA']?></option>
                                <?php endforeach ?>
                        </select>
                        <!--BUSCADOR-->
						<!--Agregar {theme: 'bootstrap4',} dentro de select-->
						<script>
							$('#area').select2({theme: 'bootstrap4',});
						</script>
                        <!--BUSCADOR-->
                        <script>
							$(document).ready(function(){
								$('#area').change(function(){
									buscador='b='+$('#area').val();
									$.ajax({
										type: 'post',
										url: 'Controladores/session.php',
										data: buscador,
										success: function(r){
											$('#tabla').load('Componentes/Tabla.php');
										}
									})
								})
							})
						</script>
                    </div>
                    <div>
                        <label class="form-label">Repartición</label>
                        <select id="reparticion" name="reparticion" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM reparticion ORDER BY REPA ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_REPA']?>"><?php echo $opciones['REPA']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Sistema Operativo</label>
                        <select id="so" name="so" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM so ORDER BY SIST_OP ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_SO']?>"><?php echo $opciones['SIST_OP']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Micro</label>
                        <select id="micro" name="micro" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM micro ORDER BY MICRO ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_MICRO']?>"><?php echo $opciones['MICRO']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Tipo</label>
                        <select id="tipows" name="tipows" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM tipows ORDER BY TIPOWS ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_TIPOWS']?>"><?php echo $opciones['TIPOWS']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Estado</label>
                        <select id="estado" name="estado" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM estado_ws ORDER BY ESTADO ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_ESTADOWS']?>"><?php echo $opciones['ESTADO']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Orden</label>
                        <select id="orden" name="orden" class="form-control largo">
                            <?php if ($_POST["orden"] != ''){ ?>
                                <option value="<?php echo $_POST["orden"]; ?>">
                                    <?php 
                            if ($_POST["orden"] == '1'){echo 'ORDENAR POR USUARIO';} 
                            if ($_POST["orden"] == '2'){echo 'ORDENAR POR AREA';} 
                            if ($_POST["orden"] == '3'){echo 'ORDENAR POR REPARTICIÓN';}
                            if ($_POST["orden"] == '4'){echo 'ORDENAR POR SISTEMA OPERATIVO';} 
                            if ($_POST["orden"] == '5'){echo 'ORDENAR POR MICRO';}
                            if ($_POST["orden"] == '6'){echo 'ORDENAR POR TIPO';}
                            if ($_POST["orden"] == '7'){echo 'ORDENAR POR ESTADO';}
                            ?>
                            </option>
                            <?php } ?>
                            <option value="">SIN ORDEN</option>
                            <option value="1">ORDENAR POR USUARIO</option>
                            <option value="2">ORDENAR POR AREA</option>
                            <option value="3">ORDENAR POR REPARTICIÓN</option>
                            <option value="4">ORDENAR POR SISTEMA OPERATIVO</option>
                            <option value="5">ORDENAR POR MICRO</option>
                            <option value="6">ORDENAR POR TIPO</option>
                            <option value="7">ORDENAR POR ESTADO</option>
                        </select>
                    </div>

                    <div style="display:flex;justify-content: flex-end;">
                        <input class="btn btn-danger" id="btnLimpiar" name="Limpiar" onclick="Limpiar()" value="Limpiar">
                        <input type="submit" class="btn btn-success" id="btnForm" name="busqueda" value="Buscar">
                    </div>
                </div>
                <div class="filtros-listadoParalelo">
                    <div>
                        <button class="btn btn-success" style="font-size: 20px;"><a href="agregarequipo.php" style="text-decoration:none !important;color:white;" target="_blank">Agregar nuevo equipo</a></button>
                    </div>
                    <div class="export">
                        Exportar a: <button type="submit" form="formu" style="border:none; background-color:transparent;"><i class="fa-solid fa-file-excel fa-2x" style="color: #1f5120;"></i>&nbspCSV</button>
                    </div>
                </div>
            </div>
        

    
   
        <div class="principal-info">
            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM inventario";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $total = $row6['total'];
            ?>
            <div class="col-md-3">
                <div class="card-counter primary">
                    <div class="card-pri">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <span class="count-numbers"><?php echo $total;?></span>
                    </div>
                    <div class="card-sec">
                        <span class="count-name">Equipos Registrados</span>
                    </div>
                </div>
            </div>

            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM inventario WHERE ID_ESTADOWS = 1";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $activo = $row6['total'];
            ?>
            <div class="col-md-3">
                <div class="card-counter success">
                    <div class="card-pri">
                        <i class="fa-sharp fa-solid fa-arrow-up"></i>
                        <span class="count-numbers"><?php echo $activo;?></span>
                    </div>
                    <div class="card-sec">
                        <span class="count-name">Equipos Activos</span>
                    </div>
                </div>
            </div>


            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM inventario WHERE ID_ESTADOWS = 2";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $inactivos = $row6['total'];
            ?>
            <div class="col-md-3">
                <div class="card-counter danger">
                    <div class="card-pri">
                        <i class="fa-sharp fa-solid fa-arrow-down"></i>
                        <span class="count-numbers"><?php echo $inactivos;?></span>
                    </div>
                    <div class="card-sec">
                        <span class="count-name">Equipos Inactivos</span>
                    </div>
                </div>
            </div>
        </div>
        <?php
        echo"<div class=filtrado>
        <label style='color:blue; margin-left: 15px; margin-bottom:20px;' id='nroInventario'>Resultados Encontrados:</label>
        ";    ?>

        <div id="filtrosUsados" style="display:none;">
            <h2>Filtrado por:</h2>
                <ul></ul>
            </div>
    </div>                        
    <table class="table_id" style="width: 98%; margin: 0 auto;">
        <thead>
            <tr>
                <th><p style="text-align:left; margin-left: 5px;">REPARTICIÓN</p></th>
                <th><p style="text-align:left; margin-left: 5px;">ÁREA</p></th>
                <th><p style="text-align:left; margin-left: 5px;">USUARIO</p></th>
                <th><p style="text-align:left; margin-left: 5px;">N° WS</p></th>
                <th><p style="text-align:left; margin-left: 5px;">S.O.</p></th>
                <th><p style="text-align:left; margin-left: 5px;">MICRO</p></th>
                <th><p style="text-align:center;">TIPO</p></th>
                <th><p style="text-align:left; margin-left: 5px;width:220px;">OBSERVACION</p></th>
                <th><p style="text-align:center;">ESTADO</p></th>
                <th><p>MAS DETALLES</p></th>
            </tr>
        </thead>
        <tbody id="tabla-datos"></tbody>

        </table>                      
        
		</div>
        <form id="formu" action="../exportar/ExcelInventario.php" method="POST">
            <input type="text" id="excel" name="sql" class="valorPeque" readonly="readonly" value="">
        </form>
        <?php
            if(isset($_GET['okMod'])){
                ?>
                <script>okMod();</script>
                <?php			
            }

            if(isset($_GET['noMod'])){
                ?>
                <script>noMod();</script>
                <?php			
            }

            if(isset($_GET['ok'])){
                ?>
                <script>ok();</script>
                <?php			
            }

            if(isset($_GET['no'])){
                ?>
                <script>no();</script>
                <?php			
            }
        ?>
	</section>
	<footer id="footer_pag"><div class="pagination justify-content-center mt-3" id="paginador"></div></footer>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
  		AOS.init();
	</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script>
		const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
		const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
	</script>
	
</body>
</html>