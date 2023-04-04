<?php
session_start();
include('../particular/conexion.php');
?>
<!DOCTYPE html>
<html lang="es-es">

<head>
	<meta charset="utf-8">

	<head>

	<body>
		<?php
		// Definimos el archivo exportado
		$arquivo = 'Incidentes.xls';

		// Crear la tabla HTML
		$html = '';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td colspan="4">Listado de incidentes</tr>';
		$html .= '</tr>';


		$html .= '<tr>';
		$html .= '<td><b>N°INCIDENTE</b></td>';
		$html .= '<td><b>FECHA INICIO</b></td>';
		$html .= '<td><b>USUARIO</b></td>';
		$html .= '<td><b>DESCRIPCIÓN</b></td>';
        $html .= '<td><b>ESTADO</b></td>';
		$html .= '<td><b>FECHA SOLUCIÓN</b></td>';
		$html .= '<td><b>RESOLTUTOR</b></td>';
		$html .= '</tr>';

		//Seleccionar todos los elementos de la tabla
	/* 	$result_msg_contatos = "SELECT * FROM contactos"; */
		$variable = $_POST['sql'];
		$resultado_msg_contatos = mysqli_query($datos_base, $variable);

		while ($row_msg_contatos = mysqli_fetch_assoc($resultado_msg_contatos)) {
            $fecord = date("d-m-Y", strtotime($row_msg_contatos['FECHA_INICIO']));

            $fecha = "0000-00-00";
            if($row_msg_contatos['FECHA_SOLUCION'] == $fecha)
            {
                $fec = date("d-m-Y", strtotime($row_msg_contatos['FECHA_SOLUCION']));
                $fec = "-";
                /*$fec = "-";*/
            }
            else{
                $fec = date("d-m-Y", strtotime($row_msg_contatos['FECHA_SOLUCION']));
            }
			$html .= '<tr>';
			$html .= '<td>' . $row_msg_contatos["ID_TICKET"] . '</td>';
			$html .= '<td>' . $fecord . '</td>';
            $html .= '<td>' . $row_msg_contatos["NOMBRE"]. '</td>';
			$html .= '<td>' . $row_msg_contatos["DESCRIPCION"] . '</td>';
            $html .= '<td>' . $row_msg_contatos["ESTADO"]. '</td>';
            $html .= '<td>' . $fec . '</td>';
			$html .= '<td>' . $row_msg_contatos["RESOLUTOR"] . '</td>';
			$html .= '</tr>';
		}
		// Configuración en la cabecera
		header("Expires: Mon, 26 Jul 2227 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: application/x-msexcel");
		header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
		header("Content-Description: PHP Generado Data");
		// Envia contenido al archivo
		echo $html;
		exit; ?>
	</body>
