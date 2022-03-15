<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>NOVEDADES</title><meta charset="utf-8">
    <link rel="icon" href="imagenes/logoObrasPúblicas.png">
	<link rel="stylesheet" type="text/css" href="estilocontraseña.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<style>
			body{
			background-color: #073256;
			}
	</style>
</head>
<body>
    <h1 style="text-decoration: underline; color: #F0AD4E">NOVEDADES</h1>
    <div class="bienvenida" data-aos="zoom-in-up">
        <div class="fecha">    
            <?php  $fechaActual = date('d-m-Y');?>
            <p class="h5"><u>ULTIMA ACTUALIZACIÓN</u>: 10/03/2022</p>
        </div>
        <hr style='display: block; height: 2px;'>
        <div class="info">
            <ul class="list-unstyled">
                <li>
                    <ul>
                        <li>SIN NOVEDADES</li>
        <!--            <li>Cambio 1</li>
                        <li>Cambio 2</li>
                        <li>Cambio 3</li> -->
                    </ul>
                </li>
            </ul>
        </div>

        <div class="btn">
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
			<a id="vlv"  href="consulta.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">CERRAR</a>
		</div>	
        </div>
    </div>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>