<?php
	session_start();
    include('../particular/conexion.php');
    if(!isset($_SESSION['cuil'])) 
        {       
            header('Location: ../index.php'); 
            exit();
        };
        $id_usuario = $_POST['idUsuario'];
        $id_celular=$_POST['idCelular'];

        if ($id_celular!=null) {
            if ($id_celular==0 || $id_celular==null) {
                # code...
            }else {
                $sentencia =  "SELECT l.ID_LINEA, l.NRO FROM celular c left join lineacelular lc on c.ID_CELULAR=lc.ID_CELULAR left join linea l on lc.ID_LINEA=l.ID_LINEA WHERE c.ID_CELULAR=$id_celular";
                $resultado = mysqli_query($datos_base, $sentencia);
                $filas = mysqli_fetch_assoc($resultado);
                $id_linea=$filas['ID_LINEA'];/*7*/
                $nro=$filas['NRO'];/*8*/
                if ($id_linea==0 || $id_linea==null) {
                    echo"<option value='' selected disabled>- SELECCIONE UNA OPCIÓN -</option>";
                }
                else {
                    
                    echo"<option value=".$id_linea." selected>".$nro."</option>";
                }
            }
        }
        else {
            echo"<option value='' selected disabled>- SELECCIONE UNA OPCIÓN -</option>";
        }

        

        $consulta= "SELECT lc.ID_LINEA, l.NRO FROM lineacelular lc left join linea l on lc.ID_LINEA=l.ID_LINEA WHERE lc.ID_USUARIO=$id_usuario and lc.ID_CELULAR=0";
        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
        
        
        ?>
        
        <?php foreach ($ejecutar as $opciones): ?>
            <?php echo"<option value=".$opciones['ID_LINEA'].">".$opciones['NRO']."</option>";?>
        <?php endforeach ?>