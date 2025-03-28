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
		$arquivo = 'MontosLineas.xls';

		// Crear la tabla HTML
		$html = '';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td colspan="4">Listado Montos/Lineas</tr>';
		$html .= '</tr>';


		$html .= '<tr>';
		$html .= '<td><b>NÚMERO</b></td>';
		$html .= '<td><b>USUARIO</b></td>';
		$html .= '<td><b>PLAN</b></td>';
		$html .= '<td><b>PROVEEDOR</b></td>';
		$html .= '<td><b>ROAMING</b></td>';
		$html .= '<td><b>MONTO</b></td>';
		$html .= '<td><b>EXTRAS</b></td>';
		$html .= '<td><b>DESCUENTO</b></td>';
		$html .= '<td><b>FECHA DESCUENTO</b></td>';
		$html .= '<td><b>MONTO TOTAL</b></td>';
		$html .= '<td><b>ESTADO</b></td>';
		$html .= '</tr>';

		//Seleccionar todos los elementos de la tabla
	/* 	$result_msg_contatos = "SELECT * FROM contactos"; */
		$variable = $_POST['sql'];
		$resultado_msg_contatos = mysqli_query($datos_base, $variable);

		while ($row_msg_contatos = mysqli_fetch_assoc($resultado_msg_contatos)) {

            $fecha = "0000-00-00";
            if($row_msg_contatos['FECHADESCUENTO'] == $fecha)
            {
                $fec = date("d-m-Y", strtotime($row_msg_contatos['FECHADESCUENTO']));
                $fec = "-";
                /*$fec = "-";*/
            }
            else{
                $fec = date("d-m-Y", strtotime($row_msg_contatos['FECHADESCUENTO']));
            }
			$html .= '<tr>';
			$html .= '<td>' . $row_msg_contatos["NRO"] . '</td>';
            $html .= '<td>' . $row_msg_contatos["NOMBRE"]. '</td>';
            $html .= '<td>' . $row_msg_contatos["NOMBREPLAN"] . $row_msg_contatos["PLAN"] . '</td>';
			$html .= '<td>' . $row_msg_contatos["PROVEEDOR"] . '</td>';
            $html .= '<td>' . $row_msg_contatos["ROAMING"]. '</td>';
			$html .= '<td>' . '$' . $row_msg_contatos["MONTO"] . '</td>';
			$html .= '<td>' . '$' . $row_msg_contatos["EXTRAS"] . '</td>';
			$html .= '<td>' . $row_msg_contatos["DESCUENTO"] .'%' . '</td>';
			$html .= '<td>' . $fec . '</td>';
			$html .= '<td>' . '$' . $row_msg_contatos["MONTOTOTAL"] . '</td>';
			$html .= '<td>' . $row_msg_contatos["ESTADO"] . '</td>';
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
