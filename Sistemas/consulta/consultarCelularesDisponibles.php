<?php
	session_start();
    include('../particular/conexion.php');
    if(!isset($_SESSION['cuil'])) 
        {       
            header('Location: ../index.php'); 
            exit();
        };
        $id_usuario = $_POST['idUsuario'];
        $id_linea=$_POST['idLinea'];

        if ($id_linea!=null) {
            if ($id_linea==0 || $id_linea==null) {
                # code...
            }else {
                $sentencia =  "SELECT * FROM celular l INNER JOIN lineacelular c ON c.ID_CELULAR=l.ID_CELULAR INNER JOIN modelo m ON l.ID_MODELO=m.ID_MODELO WHERE c.ID_USUARIO=$id_usuario AND c.ID_LINEA=$id_linea";
                $resultado = mysqli_query($datos_base, $sentencia);
                $filas = mysqli_fetch_assoc($resultado);
                $id_celular=$filas['ID_CELULAR'];
                $imei=$filas['IMEI'];
                $modelo=$filas['MODELO'];
                if ($id_celular==0 || $id_celular==null) {
                    echo"<option value='' selected disabled>- SELECCIONE UNA OPCIÓN -</option>";
                }
                else {
                    
                    echo"<option value=".$id_celular." selected>".$imei." | ".$modelo."</option>";
                }
            }
        }
        else {
            echo"<option value='' selected disabled>- SELECCIONE UNA OPCIÓN -</option>";
        }



        $consulta = "SELECT * FROM celular l INNER JOIN lineacelular c ON c.ID_CELULAR=l.ID_CELULAR INNER JOIN modelo m ON l.ID_MODELO=m.ID_MODELO WHERE c.ID_USUARIO=$id_usuario AND c.ID_LINEA=0";
$ejecutar = mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));



// $options .= "<option selected disabled=''>-SELECCIONE UNA-</option>";
// foreach ($ejecutar as $linea) {
//     $options .= "<option value='" . $linea['ID_CELULAR'] . "'>".$linea['IMEI']." | ".$linea['MODELO']."</option>";
// }
// echo $options;
?>
<?php foreach ($ejecutar as $opciones): ?>
            <?php echo"<option value=".$opciones['ID_CELULAR'].">".$opciones['IMEI']." | ".$opciones['MODELO']."</option>";?>
        <?php endforeach ?>