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
		$arquivo = 'Usuarios.xls';

		// Crear la tabla HTML
		$html = '';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td colspan="4">Listado de Usuarios</tr>';
		$html .= '</tr>';


		$html .= '<tr>';
		$html .= '<td><b>USUARIO</b></td>';
		$html .= '<td><b>CUIL</b></td>';
		$html .= '<td><b>ÁREA</b></td>';
		$html .= '<td><b>REPARTICIÓN</b></td>';
        $html .= '<td><b>INTERNO</b></td>';
		$html .= '<td><b>ESTADO</b></td>';
		$html .= '</tr>';

		//Seleccionar todos los elementos de la tabla
	/* 	$result_msg_contatos = "SELECT * FROM contactos"; */
		$variable = $_POST['sql'];
		$resultado_msg_contatos = mysqli_query($datos_base, $variable);

		while ($row_msg_contatos = mysqli_fetch_assoc($resultado_msg_contatos)) {
			$html .= '<tr>';
			$html .= '<td>' . $row_msg_contatos["NOMBRE"] . '</td>';
			$html .= '<td>' . $row_msg_contatos["CUIL"] . '</td>';
            $html .= '<td>' . $row_msg_contatos["AREA"]. '</td>';
			$html .= '<td>' . $row_msg_contatos["REPA"] . '</td>';
            $html .= '<td>' . $row_msg_contatos["INTERNO"]. '</td>';
			$html .= '<td>' . $row_msg_contatos["ACTIVO"] . '</td>';
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
