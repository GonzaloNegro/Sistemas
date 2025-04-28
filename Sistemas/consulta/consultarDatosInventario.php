<?php 
	session_start();
    error_reporting(0);
    include('../particular/conexion.php');
    if(!isset($_SESSION['cuil'])) 
        {       
            header('Location: ../index.php'); 
            exit();
        };
        if (isset($_POST['idWs'])) {
            $id_ws = $_POST['idWs'];
            // Asegúrate de que estás utilizando $id_ws correctamente en la consulta y devuelve datos.
        }
        $equipo = $_POST['idWs'];
        
        $sql = "SELECT SERIEG FROM inventario WHERE ID_WS='$equipo'";
        $resultado = $datos_base->query($sql);
        $row = $resultado->fetch_assoc();
        $serg = $row['SERIEG'];
?>
        <section id="movimientos" style="display:flex;gap:100px;flex-direction:column;">
		<div id="grilla">
            <h2 style="color:#00519C;font-size: 20px;font-weight: bold;">Movimientos equipo <?php echo $serg;?></h2>
		<?php
		    function colorear($v1, $v2, $v3){
                if($v1 != $v2){
                    $v3 = "#258900";
                }else{
                    $v3 = "#000000";
                }
                return $v3;
            }
				echo "<table width=100%>
						<thead>
							<tr>
                                <th><p class=g>FECHA</p></th>
								<th><p class=g style='text-align:left;'>USUARIO</p></th>
								<th><p class=g style='text-align:left;'>ÁREA</p></th>
								<th><p class=g style='text-align:left;'>ESTADO</p></th>
                                <th><p class=g style='text-align:left;'>MARCA</p></th>
                                <th><p class=g style='text-align:left;'>S.O.</p></th>
                                <th><p class=g style='text-align:left;'>MASTER</p></th>
                                <th><p class=g>MAC</p></th>
                                <th><p class=g style='text-align:left;'>RIP</p></th>
                                <th><p class=g>IP</p></th>
                                <th><p class=g style='text-align:left;'>RED</p></th>
							</tr>
						</thead>";
        //SERVIDOR QUE MUESTRA UNA TABLA CON LAS NOVEDADES DE UN CASO DETERMINADO
        $consultar=mysqli_query($datos_base, "SELECT m.ID_WS, m.FECHA, u.NOMBRE, a.AREA, e.ESTADO, ma.MARCA, s.SIST_OP, m.MASTERIZADA, m.MAC, m.RIP, m.IP, r.RED
        FROM movimientos m 
        LEFT JOIN usuarios AS u ON u.ID_USUARIO = m.ID_USUARIO
        LEFT JOIN area AS a ON a.ID_AREA = m.ID_AREA
        LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = m.ID_ESTADOWS
        LEFT JOIN marcas AS ma ON ma.ID_MARCA = m.ID_MARCA
        LEFT JOIN so AS s ON s.ID_SO = m.ID_SO
        LEFT JOIN red AS r ON r.ID_RED = m.ID_RED
        WHERE m.ID_WS = $equipo
        ORDER BY m.FECHA ASC");
        while($listar = mysqli_fetch_array($consultar))
        {
            $fecord = date("d-m-Y", strtotime($listar['FECHA']));
            
            $colornom = "#000000";
            $colorare = "#000000";
            $colorest = "#000000";
            $colormar = "#000000";
            $colorsis = "#000000";
            $colormas = "#000000";
            $colormac = "#000000";
            $colorrip = "#000000";
            $colorip = "#000000";
            $colorred = "#000000";

            echo" 
                <tr>
                    <td><h4 style='font-size:12px;'>".$fecord."</h4></td>


                    <td><h4 style='font-size:12px;text-align:left;'><font color=".colorear($nom, $listar['NOMBRE'], $colornom)."'>".$listar['NOMBRE']."</font></h4></td>

                    <td><h4 style='font-size:12px;text-align:left;'><font color=".colorear($are, $listar['AREA'], $colorare)."'>".$listar['AREA']."</font></h4></td>

                    <td><h4 style='font-size:12px;text-align:left;'><font color=".colorear($est, $listar['ESTADO'], $colorest)."'>".$listar['ESTADO']."</font></h4></td>

                    <td><h4 style='font-size:12px;text-align:left;'><font color=".colorear($mar, $listar['MARCA'], $colormar)."'>".$listar['MARCA']."</font></h4></td>

                    <td><h4 style='font-size:12px;text-align:left;'><font color=".colorear($sis, $listar['SIST_OP'], $colorsis)."'>".$listar['SIST_OP']."</font></h4></td>

                    <td><h4 style='font-size:12px;text-align:left;'><font color=".colorear($mas, $listar['MASTERIZADA'], $colormas)."'>".$listar['MASTERIZADA']."</font></h4></td>

                    <td><h4 style='font-size:12px;'><font color=".colorear($mac, $listar['MAC'], $colormac)."'>".$listar['MAC']."</font></h4></td>

                    <td><h4 style='font-size:12px;text-align:left;'><font color=".colorear($rip, $listar['RIP'], $colorrip)."'>".$listar['RIP']."</font></h4></td>

                    <td><h4 style='font-size:12px;'><font color=".colorear($ip, $listar['IP'], $colorip)."'>".$listar['IP']."</font></h4></td>

                    <td><h4 style='font-size:12px;text-align:left;'><font color=".colorear($red, $listar['RED'], $colorred)."'>".$listar['RED']."</font></h4></td>
                </tr>";

            $nom = $listar['NOMBRE'];
            $are = $listar['AREA'];
            $est = $listar['ESTADO'];
            $mar = $listar['MARCA'];
            $sis = $listar['SIST_OP'];
            $mas = $listar['MASTERIZADA'];
            $mac = $listar['MAC'];
            $rip = $listar['RIP'];
            $ip = $listar['IP'];
            $red = $listar['RED'];
        }
    echo "</table>";?>
    </div>
    <div id="grillamov">
        <h2 style="color:#00519C;font-size: 20px;font-weight: bold;">Mejoras equipo <?php echo $serg;?></h2>
		<?php
            function colorear2($v1, $v2, $v3){
                if($v1 != $v2){
                    $v3 = "#258900";
                }else{
                    $v3 = "#000000";
                }
                return $v3;
            }
				echo "<table width=100%>
						<thead>
							<tr>
                                <th><p>FECHA</p></th>
								<th><p style='text-align:left;'>PLACA MADRE</p></th>
								<th><p style='text-align:left;'>MICRO</p></th>
                                <th><p style='text-align:left;'>PLACAS VIDEO</p></th>
                                <th><p class=g>MEMORIAS</p></th>
                                <th><p class=g>DISCOS</p></th>
							</tr>
						</thead>";
                        $consultar=mysqli_query($datos_base, "SELECT m.ID_WS, m.FECHA, p.PLACAM, mi.MICRO, m.MEMORIA1, m.TIPOMEM1, m.FRECUENCIA1, m.MEMORIA2, m.TIPOMEM2, m.FRECUENCIA2, m.MEMORIA3, m.TIPOMEM3, m.FRECUENCIA3, m.MEMORIA4, m.TIPOMEM4, m.FRECUENCIA4, DISCO1, TIPOD1, DISCO2, TIPOD2, DISCO3, TIPOD3, DISCO4, TIPOD4
                        FROM mejoras m
                        LEFT JOIN placam AS p ON p.ID_PLACAM = m.ID_PLACAM
                        LEFT JOIN micro AS mi ON mi.ID_MICRO = m.ID_MICRO
                        WHERE m.ID_WS = $equipo
                        ORDER BY m.FECHA ASC");
						while($listar = mysqli_fetch_array($consultar))
						{
                            $f = $listar['FECHA'];

                            /* MEMORIAS */
                            $sqli = "SELECT MEMORIA
                            FROM memoria
                            WHERE ID_MEMORIA = '$listar[MEMORIA1]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$mem1 = $row2['MEMORIA'];

                            $sqli = "SELECT MEMORIA
                            FROM memoria
                            WHERE ID_MEMORIA = '$listar[MEMORIA2]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$mem2 = $row2['MEMORIA'];

                            $sqli = "SELECT MEMORIA
                            FROM memoria
                            WHERE ID_MEMORIA = '$listar[MEMORIA3]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$mem3 = $row2['MEMORIA'];

                            $sqli = "SELECT MEMORIA
                            FROM memoria
                            WHERE ID_MEMORIA = '$listar[MEMORIA4]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$mem4 = $row2['MEMORIA'];


                            /* TIPO MEMORIAS */
                            $sqli = "SELECT TIPOMEM
                            FROM tipomem
                            WHERE ID_TIPOMEM = '$listar[TIPOMEM1]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$tmem1 = $row2['TIPOMEM'];

                            $sqli = "SELECT TIPOMEM
                            FROM tipomem
                            WHERE ID_TIPOMEM = '$listar[TIPOMEM2]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$tmem2 = $row2['TIPOMEM'];

                            $sqli = "SELECT TIPOMEM
                            FROM tipomem
                            WHERE ID_TIPOMEM = '$listar[TIPOMEM3]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$tmem3 = $row2['TIPOMEM'];

                            $sqli = "SELECT TIPOMEM
                            FROM tipomem
                            WHERE ID_TIPOMEM = '$listar[TIPOMEM4]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$tmem4 = $row2['TIPOMEM'];


                            /* DISCOS */
                            $sqli = "SELECT DISCO
                            FROM disco
                            WHERE ID_DISCO = '$listar[DISCO1]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$disc1 = $row2['DISCO'];

                            $sqli = "SELECT DISCO
                            FROM disco
                            WHERE ID_DISCO = '$listar[DISCO2]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$disc2 = $row2['DISCO'];

                            $sqli = "SELECT DISCO
                            FROM disco
                            WHERE ID_DISCO = '$listar[DISCO3]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$disc3 = $row2['DISCO'];

                            $sqli = "SELECT DISCO
                            FROM disco
                            WHERE ID_DISCO = '$listar[DISCO4]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$disc4 = $row2['DISCO'];


                            /* TIPO DISCO */
                            $sqli = "SELECT TIPOD
                            FROM tipodisco
                            WHERE ID_TIPOD = '$listar[TIPOD1]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$tdisc1 = $row2['TIPOD'];

                            $sqli = "SELECT TIPOD
                            FROM tipodisco
                            WHERE ID_TIPOD = '$listar[TIPOD1]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$tdisc2 = $row2['TIPOD'];

                            $sqli = "SELECT TIPOD
                            FROM tipodisco
                            WHERE ID_TIPOD = '$listar[TIPOD3]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$tdisc3 = $row2['TIPOD'];

                            $sqli = "SELECT TIPOD
                            FROM tipodisco
                            WHERE ID_TIPOD = '$listar[TIPOD4]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$tdisc4 = $row2['TIPOD'];




                            
                            $colorp = "#000000";
                            $colormi = "#000000";
                            $colorme = "#000000";
                            $colord = "#000000";


                            $fecord = date("d-m-Y", strtotime($f));
						    echo" 
								<tr>
                                    <td><h4 style='font-size:12px; text-align: center;'>".$fecord."</h4></td>

                                    <td><h4 style='font-size:12px; text-align: left; color:".colorear2($pm, $listar['PLACAM'], $colorp)."'>".$listar['PLACAM']."</h4></td>

                                    <td><h4 style='font-size:12px; text-align: left;color:".colorear2($m, $listar['MICRO'], $colormi)."'>".$listar['MICRO']."</h4></td>

                                    <td><h4 style='font-size:12px; text-align: left;'>".'-'."</h4></td>




                                    <td><h4 style='font-size:12px; text-align: center;color:'>
                                    <font color=".colorear2($mee1, $mem1, $colorme).">".$mem1.'</font> - 
                                    <font color="'.colorear2($tmee1, $tmem1, $colorme).'">'.$tmem1.'</font> <br> 

                                    <font color="'.colorear2($mee2, $mem2, $colorme).'">'.$mem2.'</font> - 
                                    <font color="'.colorear2($tmee2, $tmem2, $colorme).'">'.$tmem2.'</font> <br> 

                                    <font color="'.colorear2($mee3, $mem3, $colorme).'">'.$mem3.'</font> - 
                                    <font color="'.colorear2($tmee3, $tmem3, $colorme).'">'.$tmem3.'</font> <br> 

                                    <font color="'.colorear2($mee4, $mem4, $colorme).'">'.$mem4.'</font> - 
                                    <font color="'.colorear2($tmee3, $tmem3, $colorme).'">'.$tmem4."</font></h4></td>



                                    <td><h4 style='font-size:12px; text-align: center;color:'>
                                    <font color=".colorear2($d1, $disc1, $colord).">".$disc1.'</font> - 
                                    <font color="'.colorear2($td1, $tdisc1, $colord).'">'.$tdisc1.'</font> <br> 

                                    <font color="'.colorear2($d2, $disc2, $colord).'">'.$disc2.'</font> - 
                                    <font color="'.colorear2($td2, $tdisc2, $colord).'">'.$tdisc2.'</font> <br> 

                                    <font color="'.colorear2($d3, $disc3, $colord).'">'.$disc3.'</font> - 
                                    <font color="'.colorear2($td3, $tdisc3, $colord).'">'.$tdisc3.'</font> <br> 

                                    <font color="'.colorear2($d4, $disc4, $colord).'">'.$disc4.'</font> - 
                                    <font color="'.colorear2($td4, $tdisc4, $colord).'">'.$tdisc4."</font></h4></td>
								</tr>";

                                $pm = $listar['PLACAM'];
                                $m = $listar['MICRO'];
                                $mee1 = $mem1;
                                $mee2 = $mem2;
                                $mee3 = $mem3;
                                $mee4 = $mem4;
                                $tmee1 = $tmem1;
                                $tmee2 = $tmem2;
                                $tmee3 = $tmem3;
                                $tmee4 = $tmem4;

                                $d1 = $disc1;
                                $d2 = $disc2;
                                $d3 = $disc3;
                                $d4 = $disc4;
                                $td1 = $tdisc1;
                                $td2 = $tdisc2;
                                $td3 = $tdisc3;
                                $td4 = $tdisc4;
						}
					echo "</table>";
			?>
		</div>
</section>