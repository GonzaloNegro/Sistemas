<?php
    //Trae la linea actual que tiene asignado el celular y las lineas disponibles
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
                $sentencia =  "SELECT l.ID_LINEA, l.NRO
                    FROM celular c
                    LEFT JOIN lineacelular lc 
                        ON c.ID_CELULAR = lc.ID_CELULAR
                    LEFT JOIN linea l 
                        ON lc.ID_LINEA = l.ID_LINEA
                    WHERE c.ID_CELULAR = $id_celular
                    AND lc.ID_LINEACELULAR = (
                            SELECT MAX(lc2.ID_LINEACELULAR)
                            FROM lineacelular lc2
                            WHERE lc2.ID_CELULAR = c.ID_CELULAR
                        )";
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

        
        //OBTIENE LAS LINEAS DISPONIBLES DE UN USUARIO
        $consulta= "SELECT lc.ID_LINEA, l.NRO
            FROM lineacelular lc
            JOIN linea l ON lc.ID_LINEA = l.ID_LINEA
            JOIN (
                SELECT ID_LINEA, MAX(ID_LINEACELULAR) AS ultima
                FROM lineacelular
                GROUP BY ID_LINEA
            ) t ON lc.ID_LINEA = t.ID_LINEA AND lc.ID_LINEACELULAR = t.ultima
            WHERE lc.ID_USUARIO = $id_usuario
            AND lc.ID_CELULAR = 0;";
        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
        
        
        ?>
        
        <?php foreach ($ejecutar as $opciones): ?>
            <?php echo"<option value=".$opciones['ID_LINEA'].">".$opciones['NRO']."</option>";?>
        <?php endforeach ?>