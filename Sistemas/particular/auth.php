<?php
function verificarPerfil($row, $permitidos = []) {
    // si no está en la lista de perfiles permitidos, redirige
    if (!in_array($row['ID_PERFIL'], $permitidos)) {
        header("Location: ../consulta/consulta.php?forbidden");
        exit();
    }
}
