
<? php
if(isset($_POST['btn2'])){
            $mej=$_POST['slcTipo'];
            $fechadesde=$_POST['fecha_desde'];
            $fechahasta=$_POST['fecha_hasta'];
            
            if (isset($_POST['fecha_desde']) & isset($_POST['fecha_hasta']) & isset($_POST['slcarea'])) {
                $area= $_POST['slcarea'];
                if ($mej==1) {
                    $fecha = date("Y-m-d");
                echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
                
                
                $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS,m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
                FROM mejoras m
                inner join wsmem w on m.ID_WS=w.ID_WS
                inner join memoria me on m.MEMORIA1=me.ID_MEMORIA
                inner join tipomem t on w.ID_TIPOMEM=t.ID_TIPOMEM
                inner join discows ds on m.ID_WS=ds.ID_WS
                inner join disco d on ds.ID_DISCO=d.ID_DISCO
                inner join tipodisco td on ds.ID_TIPOD=td.ID_TIPOD
                inner JOIN placam p on p.ID_PLACAM=m.ID_PLACAM
                inner join inventario i on m.ID_WS=i.ID_WS
                where me.ORDEN_MEMORIA>(SELECT max(me2.ORDEN_MEMORIA) from mejoras ms INNER JOIN
                                memoria me2 on ms.MEMORIA1=me2.ID_MEMORIA where m.ID_WS=ms.ID_WS and m.ID_MEJORA>ms.ID_MEJORA)
                                and i.ID_AREA=$area and M.FECHA BETWEEN '$fechadesde' AND '$fechahasta' GROUP BY m.ID_MEJORA DESC");
                }
                if ($mej==2) {
                    $fecha = date("Y-m-d");
                echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
                
                
                $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS,m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
                FROM mejoras m
                inner join wsmem w on m.ID_WS=w.ID_WS
                inner join memoria me on m.MEMORIA1=me.ID_MEMORIA
                inner join tipomem t on w.ID_TIPOMEM=t.ID_TIPOMEM
                inner join discows ds on m.ID_WS=ds.ID_WS
                inner join disco d on m.DISCO1=d.ID_DISCO
                inner join tipodisco td on ds.ID_TIPOD=td.ID_TIPOD
                inner JOIN placam p on p.ID_PLACAM=m.ID_PLACAM
                inner join inventario i on m.ID_WS=i.ID_WS
                where d.ORDEN_DISCO>(SELECT max(di.ORDEN_DISCO) from mejoras mem INNER JOIN
                                disco di on mem.DISCO1=di.ID_DISCO where m.ID_WS=mem.ID_WS and m.ID_MEJORA>mem.ID_MEJORA)
                                    or td.RANKING_TIPOD>(select td2.RANKING_TIPOD  from mejoras me2
                                    inner join discows dw on me2.ID_WS=dw.ID_WS
                                    inner join tipodisco td2 on dw.ID_TIPOD=td2.ID_TIPOD
                                    where m.ID_WS=me2.ID_WS limit 1) and i.ID_AREA=$area and M.FECHA BETWEEN '$fechadesde' AND '$fechahasta'
                        GROUP BY m.ID_MEJORA DESC");
                }}
            
            if ($fechadesde==""||$fechahasta=="" & !isset($_POST['slcarea']) ) {
                if ($mej==1) {
                    $fecha = date("Y-m-d");
                echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
                
                
                $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS,m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
                FROM mejoras m
                inner join wsmem w on m.ID_WS=w.ID_WS
                inner join memoria me on m.MEMORIA1=me.ID_MEMORIA
                inner join tipomem t on w.ID_TIPOMEM=t.ID_TIPOMEM
                inner join discows ds on m.ID_WS=ds.ID_WS
                inner join disco d on ds.ID_DISCO=d.ID_DISCO
                inner join tipodisco td on ds.ID_TIPOD=td.ID_TIPOD
                inner JOIN placam p on p.ID_PLACAM=m.ID_PLACAM
                where me.ORDEN_MEMORIA>(SELECT max(me2.ORDEN_MEMORIA) from mejoras ms INNER JOIN
                                memoria me2 on ms.MEMORIA1=me2.ID_MEMORIA where m.ID_WS=ms.ID_WS and m.ID_MEJORA>ms.ID_MEJORA)
                    GROUP BY m.ID_MEJORA DESC");
                }
                if ($mej==2) {
                    $fecha = date("Y-m-d");
                echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
                
                
                $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS,m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
                FROM mejoras m
                inner join wsmem w on m.ID_WS=w.ID_WS
                inner join memoria me on m.MEMORIA1=me.ID_MEMORIA
                inner join tipomem t on w.ID_TIPOMEM=t.ID_TIPOMEM
                inner join discows ds on m.ID_WS=ds.ID_WS
                inner join disco d on m.DISCO1=d.ID_DISCO
                inner join tipodisco td on ds.ID_TIPOD=td.ID_TIPOD
                inner JOIN placam p on p.ID_PLACAM=m.ID_PLACAM
                where d.ORDEN_DISCO>(SELECT max(di.ORDEN_DISCO) from mejoras mem INNER JOIN
                                disco di on mem.DISCO1=di.ID_DISCO where m.ID_WS=mem.ID_WS and m.ID_MEJORA>mem.ID_MEJORA)
                                    or td.RANKING_TIPOD>(select td2.RANKING_TIPOD  from mejoras me2
                                    inner join discows dw on me2.ID_WS=dw.ID_WS
                                    inner join tipodisco td2 on dw.ID_TIPOD=td2.ID_TIPOD
                                    where m.ID_WS=me2.ID_WS limit 1)
                        GROUP BY m.ID_MEJORA DESC");
                }}
            if ($fechadesde=="" & $fechahasta=="" & isset($_POST['slcarea'])) {
                $area= $_POST['slcarea'];
                if ($mej==1) {
                    $fecha = date("Y-m-d");
                echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
                
                
                $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS,m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
                FROM mejoras m
                inner join wsmem w on m.ID_WS=w.ID_WS
                inner join memoria me on m.MEMORIA1=me.ID_MEMORIA
                inner join tipomem t on w.ID_TIPOMEM=t.ID_TIPOMEM
                inner join discows ds on m.ID_WS=ds.ID_WS
                inner join disco d on ds.ID_DISCO=d.ID_DISCO
                inner join tipodisco td on ds.ID_TIPOD=td.ID_TIPOD
                inner JOIN placam p on p.ID_PLACAM=m.ID_PLACAM
                inner join inventario i on m.ID_WS=i.ID_WS
                where me.ORDEN_MEMORIA>(SELECT max(me2.ORDEN_MEMORIA) from mejoras ms INNER JOIN
                                memoria me2 on ms.MEMORIA1=me2.ID_MEMORIA where m.ID_WS=ms.ID_WS and m.ID_MEJORA>ms.ID_MEJORA)
                                and i.ID_AREA=$area    GROUP BY m.ID_MEJORA DESC");
                }
                if ($mej==2) {
                    $fecha = date("Y-m-d");
                echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
                
                
                $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS,m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
                FROM mejoras m
                inner join wsmem w on m.ID_WS=w.ID_WS
                inner join memoria me on m.MEMORIA1=me.ID_MEMORIA
                inner join tipomem t on w.ID_TIPOMEM=t.ID_TIPOMEM
                inner join discows ds on m.ID_WS=ds.ID_WS
                inner join disco d on m.DISCO1=d.ID_DISCO
                inner join tipodisco td on ds.ID_TIPOD=td.ID_TIPOD
                inner JOIN placam p on p.ID_PLACAM=m.ID_PLACAM
                inner join inventario i on m.ID_WS=i.ID_WS
                where d.ORDEN_DISCO>(SELECT max(di.ORDEN_DISCO) from mejoras mem INNER JOIN
                                disco di on mem.DISCO1=di.ID_DISCO where m.ID_WS=mem.ID_WS and m.ID_MEJORA>mem.ID_MEJORA)
                                    or td.RANKING_TIPOD>(select td2.RANKING_TIPOD  from mejoras me2
                                    inner join discows dw on me2.ID_WS=dw.ID_WS
                                    inner join tipodisco td2 on dw.ID_TIPOD=td2.ID_TIPOD
                                    where m.ID_WS=me2.ID_WS limit 1) and i.ID_AREA=$area
                        GROUP BY m.ID_MEJORA DESC");
                }}
                
            


                else {
                    if ($mej==1) {
                        $fecha = date("Y-m-d");
                    echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
                    
                    
                    $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS,m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
                    FROM mejoras m
                    inner join wsmem w on m.ID_WS=w.ID_WS
                    inner join memoria me on m.MEMORIA1=me.ID_MEMORIA
                    inner join tipomem t on w.ID_TIPOMEM=t.ID_TIPOMEM
                    inner join discows ds on m.ID_WS=ds.ID_WS
                    inner join disco d on ds.ID_DISCO=d.ID_DISCO
                    inner join tipodisco td on ds.ID_TIPOD=td.ID_TIPOD
                    inner JOIN placam p on p.ID_PLACAM=m.ID_PLACAM
                    where me.ORDEN_MEMORIA>(SELECT max(me2.ORDEN_MEMORIA) from mejoras ms INNER JOIN
                                     memoria me2 on ms.MEMORIA1=me2.ID_MEMORIA where m.ID_WS=ms.ID_WS and m.ID_MEJORA>ms.ID_MEJORA)
                                     and M.FECHA BETWEEN '$fechadesde' AND '$fechahasta'
                                        GROUP BY m.ID_MEJORA DESC");
                    }
                    if ($mej==2) {
                        $fecha = date("Y-m-d");
                    echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
                    
                    
                    $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS,m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
                    FROM mejoras m
                    inner join wsmem w on m.ID_WS=w.ID_WS
                    inner join memoria me on m.MEMORIA1=me.ID_MEMORIA
                    inner join tipomem t on w.ID_TIPOMEM=t.ID_TIPOMEM
                    inner join discows ds on m.ID_WS=ds.ID_WS
                    inner join disco d on m.DISCO1=d.ID_DISCO
                    inner join tipodisco td on ds.ID_TIPOD=td.ID_TIPOD
                    inner JOIN placam p on p.ID_PLACAM=m.ID_PLACAM
                    where d.ORDEN_DISCO>(SELECT max(di.ORDEN_DISCO) from mejoras mem INNER JOIN
                                     disco di on mem.DISCO1=di.ID_DISCO where m.ID_WS=mem.ID_WS and m.ID_MEJORA>mem.ID_MEJORA)
                                        or td.RANKING_TIPOD>(select td2.RANKING_TIPOD  from mejoras me2
                                        inner join discows dw on me2.ID_WS=dw.ID_WS
                                        inner join tipodisco td2 on dw.ID_TIPOD=td2.ID_TIPOD
                                        where m.ID_WS=me2.ID_WS limit 1)
                                        and M.FECHA BETWEEN '$fechadesde' AND '$fechahasta'
                            GROUP BY m.ID_MEJORA DESC");
                    }}
                }
    
    
		else{
        $fecha = date("Y-m-d");
		echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
        
        
        $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS,m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
        FROM mejoras m
        inner join wsmem w on m.ID_WS=w.ID_WS
        inner join memoria me on m.MEMORIA1=me.ID_MEMORIA
        inner join tipomem t on w.ID_TIPOMEM=t.ID_TIPOMEM
        inner join discows ds on m.ID_WS=ds.ID_WS
        inner join disco d on m.DISCO1=d.ID_DISCO
        inner join tipodisco td on ds.ID_TIPOD=td.ID_TIPOD
		inner JOIN placam p on p.ID_PLACAM=m.ID_PLACAM
		GROUP BY m.ID_MEJORA DESC");}