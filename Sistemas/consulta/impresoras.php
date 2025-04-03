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
	<title>INVENTARIO IMPRESORAS</title><meta charset="utf-8">
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
    <script>
                //Funcion que va mostrando que filtros se van utilizando
                function mostrarFiltros(){
                    const busqueda = $("#buscar");
                    const area = $("#area");
                    const reparticion = $("#reparticion");
                    const tipop = $("#tipop");
                    const impresora = $("#impresora");
                    const marca = $("#marca");
                    const estado = $("#estado");
                    const orden = $("#orden"); 
                    
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
                    if (tipop.val() != '') {
                        filtros.append(`<li style="color:blue; margin-left: 15px;"><u>TIPO P</u>: ${$("#tipop option:selected").text()}</li>`);
                    }if (impresora.val() != '') {
                        filtros.append(`<li style="color:blue; margin-left: 15px;"><u>IMPRESORA</u>: ${$("#impresora option:selected").text()}</li>`);
                    }if (marca.val() != '') {
                        filtros.append(`<li style="color:blue; margin-left: 15px;"><u>MARCA</u>: ${$("#marca option:selected").text()}</li>`);
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
                    const tipop = $("#tipop").val();
                    const impresora = $("#impresora").val();
                    const marca = $("#marca").val();
                    const estado = $("#estado").val();
                    const orden = $("#orden").val(); 
                //Obtener los datos de la tabla de usuarios
                $.ajax({
                    url: "paginador_impresoras.php", // Archivo PHP
                    type: "GET",
                    data: { 
                            pagina: pagina,
                            busqueda: busqueda,
                            area: area,
                            reparticion: reparticion,
                            orden: orden,
                            tipop: tipop,
                            impresora: impresora,
                            marca: marca,
                            estado: estado,
                             },
                    dataType: "json",
                    //Respuesta obtenida de paginador.php
                    success: function (respuesta) {
                        //Cargamos el nro de incidentes obtenidos en label
                        
                        const lblUsuarios = $("#nroImpresoras").text("Resultados Encontrados: "+respuesta.totalImpresoras); 

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
                            
                            if(fila.SERIEG === "" || fila.SERIEG === "0"){
                                fila.SERIEG = "-"
                            }
                            let usuario = fila.NOMBRE;
                            if(!usuario){
                                usuario = "NO ASIGNADO";
                            }
                            tabla.append(`<tr>
                                <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>${fila.MODELO}</h4></td>
                                <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>${usuario}</h4></td>
                                <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>${fila.AREA}</h4></td>
                                <td><h4 style='max-width:180px;font-size:14px; text-align:left;margin-left: 5px;'>${fila.REPA}</h4></td>
                                <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>${fila.SERIEG}</h4></td>
                                <td><h4 style='font-size:14px;text-align:left;margin-left: 5px;'>${fila.TIPO}</h4></td>
                                <td><h4 style='font-size:14px;text-align:left;margin-left: 5px;'>${fila.MARCA}</h4></td>
                                <td><h4 style='color:${color};font-size:14px;text-align:left;margin-left: 5px;'>${fila.ESTADO}</h4></td>
                                <td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary'  target='_blank' href=consultadetalleimp.php?no=${fila.ID_PERI} target=new class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
                                <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
                                <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                                </svg></a>
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
            window.location.href='../consulta/impresoras.php';
        }
    </script>
  <section id="consulta">
		<div id="titulo">
			<h1>INVENTARIO DE IMPRESORAS</h1>
		</div>
            <div class="filtros">
                <div class="filtros-listado">
                    <div>
                        <label class="form-label">Usuario/Serieg</label>
                        <input type="text" style="text-transform:uppercase;" id="buscar" name="buscar"  placeholder="Buscar" class="form-control largo">
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
                        <label class="form-label">Impresora</label>
                        <select id="impresora" name="impresora" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * 
                            FROM modelo
                            WHERE ID_TIPOP = 1 OR ID_TIPOP = 2 OR ID_TIPOP = 3 OR ID_TIPOP = 4 OR ID_TIPOP = 10 OR ID_TIPOP = 13
                            ORDER BY MODELO ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_MODELO']?>"><?php echo $opciones['MODELO']?></option>
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
                            if ($_POST["orden"] == '2'){echo 'ORDENAR POR SERIEG';} 
                            if ($_POST["orden"] == '3'){echo 'ORDENAR POR AREA';}
                            if ($_POST["orden"] == '4'){echo 'ORDENAR POR IMPRESORA';} 
                            if ($_POST["orden"] == '5'){echo 'ORDENAR POR MARCA';}
                            if ($_POST["orden"] == '6'){echo 'ORDENAR POR TIPO';}
                            if ($_POST["orden"] == '7'){echo 'ORDENAR POR ESTADO';}
                            ?>
                            </option>
                            <?php } ?>
                            <option value="">SIN ORDEN</option>
                            <option value="1">ORDENAR POR USUARIO</option>
                            <option value="2">ORDENAR POR SERIEG</option>
                            <option value="3">ORDENAR POR AREA</option>
                            <option value="4">ORDENAR POR IMPRESORA</option>
                            <option value="5">ORDENAR POR MARCA</option>
                            <option value="6">ORDENAR POR TIPO</option>
                            <option value="7">ORDENAR POR ESTADO</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Marca</label>
                        <select id="marca" name="marca" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM marcas ORDER BY MARCA ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_MARCA']?>"><?php echo $opciones['MARCA']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Tipo</label>
                        <select id="tipop" name="tipop" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM tipop 
                            WHERE ID_TIPOP = 1 OR ID_TIPOP = 2 OR ID_TIPOP = 3 OR ID_TIPOP = 4 OR ID_TIPOP = 10 OR ID_TIPOP = 13
                            ORDER BY TIPO ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_TIPOP']?>"><?php echo $opciones['TIPO']?></option>
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
                    <div style="display:flex;justify-content: flex-end;">
                    <input class="btn btn-danger" id="btnLimpiar" name="Limpiar" onclick="Limpiar()" value="Limpiar">
                        <input type="submit" class="btn btn-success" id="btnForm" name="busqueda" value="Buscar">
                    </div>
                </div>
                    
                <div class="filtros-listadoParalelo">
                    <div>
                        <button class="btn btn-success" style="font-size: 20px;"><a href="../abm/agregarimpresora.php" style="text-decoration:none !important;color:white;" target="_blank">Agregar nueva impresora</a></button>
                    </div>
                    <div class="export">
                        Exportar a: <button type="submit" form="formu" style="border:none; background-color:transparent;"><i class="fa-solid fa-file-excel fa-2x" style="color: #1f5120;"></i>&nbspCSV</button>
                    </div>
                </div>
            </div>
        
    
    <div class="principal-info">
            <?php 
                // $sql6 = "SELECT COUNT(*) AS total FROM periferico WHERE ID_TIPOP =  1 OR ID_TIPOP =  2 OR ID_TIPOP =  3 OR ID_TIPOP =  4 OR ID_TIPOP =  10 OR ID_TIPOP = 13";
                $sql6 = "SELECT COUNT(*) AS total FROM periferico WHERE TIPOP =  'IMPRESORA'";
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
                $sql6 = "SELECT COUNT(*) AS total FROM periferico WHERE (ID_TIPOP =  1 OR ID_TIPOP =  2 OR ID_TIPOP =  3 OR ID_TIPOP =  4 OR ID_TIPOP =  10 OR ID_TIPOP = 13) AND ID_ESTADOWS = 1";
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
                $sql6 = "SELECT COUNT(*) AS total FROM periferico WHERE (ID_TIPOP =  1 OR ID_TIPOP =  2 OR ID_TIPOP =  3 OR ID_TIPOP =  4 OR ID_TIPOP =  10 OR ID_TIPOP = 13) AND ID_ESTADOWS = 2";
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
        <label style='color:blue; margin-left: 15px; margin-bottom:20px;' id='nroImpresoras'>Resultados Encontrados:</label>
        ";    ?>

        <div id="filtrosUsados" style="display:none;">
            <h2>Filtrado por:</h2>
                <ul></ul>
            </div>
    </div>  

    <table class="table_id" style="width: 98%; margin: 0 auto;">
        <thead>
            <tr>
                <th><p style="text-align:left; margin-left: 5px;">IMPRESORA</p></th>
                <th><p style="text-align:left; margin-left: 5px;">USUARIO</p></th>
                <th><p style="text-align:left; margin-left: 5px;">ÁREA</p></th>
                <th><p style="text-align:left; margin-left: 5px;">REPARTICIÓN</p></th>
                <th><p style="text-align:left; margin-left: 5px;">SERIEG</p></th>
                <th><p style="text-align:left; margin-left: 5px;">TIPO</p></th>
                <th><p style="text-align:left; margin-left: 5px;">MARCA</p></th>
                <th><p style="text-align:left; margin-left: 5px;">ESTADO</p></th>
                <th><p>MAS DETALLES</p></th>
            </tr>
        </thead>
        <tbody id="tabla-datos"></tbody>
        </table>      
        
		</div>
        <form id="formu" action="../exportar/ExcelImpresoras.php" method="POST">
            <input type="text" id="excel" name="sql" class="valorPeque" readonly="readonly" value="<?php echo $query;?>">
        </form>
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
	<script src="../js/script.js"></script>
</body>
</html>