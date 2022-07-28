<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../estilos/estilomodificacion.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>

<script type="text/javascript">
			function modificar(){	
				swal(  {title: "Se ha modificado su incidente correctamente",
							icon: "success",
							showConfirmButton: true,
							showCancelButton: false,
							})
							.then((confirmar) => {
							if (confirmar) {
								window.location.href='consulta.php';
						}
						}
						);
			}	
			</script>
			<script type="text/javascript">
			function solucionar(){
				swal(  {title: "Se ha solucionado su incidente correctamente",
							icon: "success",
							showConfirmButton: true,
							showCancelButton: false,
							})
							.then((confirmar) => {
							if (confirmar) {
								window.location.href='consulta.php';
						}
						}
						);
			}	
			</script>
			<script type="text/javascript">
			function anular(){
				swal(  {title: "Se ha anulado su incidente correctamente",
							icon: "success",
							showConfirmButton: true,
							showCancelButton: false,
							})
							.then((confirmar) => {
							if (confirmar) {
								window.location.href='consulta.php';
						}
						}
						);
			}	
			</script>


<?php
				if(isset($_GET['mod'])){
					
					/*echo "<h3>Incidente cargado</h3>";*/?>
					<script>modificar();</script>
					<?php		
				}
		
				if(isset($_GET['sol'])){
					/*echo "<h3>Incidente cargado</h3>";*/?>
					<script>solucionar();</script>
					<?php			
				}

				if(isset($_GET['an'])){
					/*echo "<h3>Incidente cargado</h3>";*/?>
					<script>anular();</script>
					<?php			
				}
			?>
</body>
</html>