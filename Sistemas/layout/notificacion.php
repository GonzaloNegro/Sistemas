<div class="notification-container">
    <button class="notification-button" onclick="toggleNotifications()">🔔
    <?php
        $IdRes = $row['ID_RESOLUTOR'];
        
        $cant="SELECT count(*) as cantidad FROM ticket WHERE ID_ESTADO = 4 AND ID_RESOLUTOR = '$IdRes'";
        $result = $datos_base->query($cant);
        $rowa = $result->fetch_assoc();
        $cantidad = $rowa['cantidad'];

        $cantU="SELECT count(*) as cantidadUsu FROM usuarios WHERE ID_AREA IN (100, 101) AND ID_ESTADOUSUARIO = 1;";
        $result = $datos_base->query($cantU);
        $rowa = $result->fetch_assoc();
        $cantidadUsu = $rowa['cantidadUsu'];

        if($cantidadUsu > 0){
            $conteoNotificacionUsuario = 1;
            $notificacionUsuario = "Usuarios: Hay ".$cantidadUsu." usuarios con área N/A.";
        }

        $cantTotal = $cantidad + $conteoNotificacionUsuario;
        /* $fechaActual = date('m'); */
        if($cantTotal > 0){
            echo $cantTotal;
        }
        ?> Notificaciones</button>
    <div class="notifications" id="notificationPanel">
        <ul>
            <?php
            $query = "SELECT t.ID_TICKET, t.DESCRIPCION, r.RESOLUTOR, e.ESTADO
            FROM ticket t
            INNER JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR
            INNER JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO
            WHERE t.ID_ESTADO = 4 AND t.ID_RESOLUTOR = '$IdRes'
            ORDER BY t.ID_TICKET";
            $result = $datos_base->query($query);
            while($rowa = $result->fetch_assoc()) {
                echo "<li><a href='http://localhost/GITSISTEMAS/Sistemas/Sistemas/consulta/modificacion.php?no=".$rowa['ID_TICKET']."'>&#128308; Ticket #".$rowa['ID_TICKET'].": (".$rowa['ESTADO'].") - ".$rowa['DESCRIPCION']."</a></li>";
                
                /* echo "<li><a href='http://ws43575/Sistemas/consulta/modificacion.php?no=".$rowa['ID_TICKET']."'>&#128308; Ticket #".$rowa['ID_TICKET'].": (".$rowa['ESTADO'].") - ".$rowa['DESCRIPCION']."</a></li>"; */
            }
            
            if($cantidadUsu > 0){
                echo "<li><a href='http://localhost/GITSISTEMAS/Sistemas/Sistemas/consulta/consultausuario.php'>&#128308; ".$notificacionUsuario."</a></li>";
                
                /* echo "<li><a href='http://ws43575/Sistemas/consulta/consultausuario.php'>&#128308; ".$notificacionUsuario."</a></li>"; */
            }
            ?>
        </ul>
    </div>
</div>
    
<script>
    function toggleNotifications() {
        var panel = document.getElementById("notificationPanel");
        panel.style.display = panel.style.display === "block" ? "none" : "block";
    }
</script>

<style>
    .notification-container {
        position: relative;
        display: inline-block;
        padding: 10px;
    }

    .notification-button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        font-size: 16px;
        border-radius: 5px;
    }

    .notifications {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        width: 400px;
        max-height: 400px;
        overflow-y: scroll !important;
        background: white;
        border: 1px solid #ddd;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        overflow: hidden;
        z-index: 1000;
        scrollbar-width: thin; /* Hace la barra más delgada (para Firefox) */
        scrollbar-color: #aaa #f9f9f9; /* Color de la barra y del fondo (para Firefox) */
    }

    .notifications::-webkit-scrollbar {
        width: 8px; /* Ancho de la barra de desplazamiento */
    }

    .notifications::-webkit-scrollbar-thumb {
        background-color: #aaa; /* Color del scroll */
        border-radius: 4px;
    }

    .notifications::-webkit-scrollbar-track {
        background: #f9f9f9; /* Color de fondo del scroll */
    }

    .notifications ul {
        max-height: 100%; 
        overflow-y: auto;
        padding: 0;
        margin: 0;
    }

    .notifications li {
        padding: 10px;
        border-bottom: 1px solid #ddd; /* Línea delgada gris */
        font-size: 14px;
        background: #f9f9f9;
        max-width: 100%; 
        white-space: nowrap; /* Evita el salto de línea */
        overflow: hidden; /* Oculta el texto que sobrepasa el ancho */
        text-overflow: ellipsis; /* Agrega "..." si el texto es muy largo */
    }

    .notifications li:last-child {
        border-bottom: none; /* Eliminar la línea en la última notificación */
    }

    .notifications a {
        text-decoration: none;
        color: #333;
        display: block;
        max-width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .notifications a:hover {
        background: #e9ecef;
    }

    /* Mostrar panel cuando se active */
    .notification-container.active .notifications {
        display: block;
    }
</style>