<?php
include('config.php'); 
// Array predefinido de páginas y sus palabras clave
$paginas = [
    [
        'nombre' => 'Consulta -> Página principal',
        'url' => URL_RAIZ . 'consulta/consulta.php',
        'palabras_clave' => ['inicio', 'home', 'principal', 'consulta', 'incidentes']
    ],
    [
        'nombre' => 'Abm -> Altas/Bajas/Modificaciones',
        'url' => URL_RAIZ . 'abm/abm.php',
        'palabras_clave' => ['abm', 'alta', 'baja', 'modificar', 'modificacion']
    ],
    [
        'nombre' => 'Inventario -> Equipos',
        'url' => URL_RAIZ . 'consulta/inventario.php',
        'palabras_clave' => ['equipos', 'ws', 'maquinas', 'inventario','pc','notebooks']
    ],
    [
        'nombre' => 'Impresoras',
        'url' => URL_RAIZ . 'consulta/impresoras.php',
        'palabras_clave' => ['impresoras', 'laser', 'periferico']
    ],
    [
        'nombre' => 'Contraseña -> Modificar',
        'url' => URL_RAIZ . 'particular/contraseña.php',
        'palabras_clave' => ['contraseña', 'clave', 'password']
    ],
    [
        'nombre' => 'Reportes (todos)',
        'url' => URL_RAIZ . 'reportes/tiporeporte.php',
        'palabras_clave' => ['reportes', 'informe']
    ],
    [
        'nombre' => 'Reportes -> Equipos',
        'url' => URL_RAIZ . 'reportes/reporteinventario.php',
        'palabras_clave' => ['reportes', 'informe', 'equipos', 'inventario', 'ws','pc','notebooks']
    ],
    [
        'nombre' => 'Reportes -> Periéricos',
        'url' => URL_RAIZ . 'reportes/reporteperifericos.php',
        'palabras_clave' => ['reportes', 'informe', 'perifericos','impresoras','monitores','scanners','otros']
    ],
    [
        'nombre' => 'Reportes -> Inventario General',
        'url' => URL_RAIZ . 'reportes/relevamientoinventario.php',
        'palabras_clave' => ['reportes', 'informe','general','equipos','monitores','notebooks','impresoras','pc','tickeadoras','scanners']
    ],
    [
        'nombre' => 'Reportes -> Impresoras',
        'url' => URL_RAIZ . 'reportes/reporteimpresora.php',
        'palabras_clave' => ['reportes', 'informe','impresoras','laser','periferico']
    ],
    [
        'nombre' => 'Reportes -> Datos PC',
        'url' => URL_RAIZ . 'reportes/reporteequipo.php',
        'palabras_clave' => ['reportes', 'informe', 'equipos', 'inventario', 'ws','pc','notebooks', 'sistema', 'operativo', 'microprocesador', 'componentes']
    ],
    [
        'nombre' => 'Reportes -> Planes',
        'url' => URL_RAIZ . 'consulta/reportePlanesTelefonia.php',
        'palabras_clave' => ['reportes', 'informe','planes','claro','personal']
    ],
    [
        'nombre' => 'Reportes -> Líneas',
        'url' => URL_RAIZ . 'consulta/reporteLineasTelefonia.php',
        'palabras_clave' => ['reportes', 'informe', 'lineas', 'telefono']
    ]
];

// Si se hace una solicitud AJAX para buscar sugerencias
if (!empty($_GET['ajax']) && !empty($_GET['q'])) {
    $busqueda = strtolower(trim($_GET['q']));
    $resultados = [];

    foreach ($paginas as $pagina) {
$match = false;

// Buscar en el nombre
if (stripos($pagina['nombre'], $busqueda) !== false) {
    $match = true;
    } else {
        // Buscar en palabras clave (parcial)
        foreach ($pagina['palabras_clave'] as $palabra) {
            if (stripos($palabra, $busqueda) !== false) {
                $match = true;
                break;
            }
        }
    }

    if ($match) {
        $resultados[] = $pagina;
    }
    }

    header('Content-Type: application/json');
    echo json_encode($resultados);
    exit;
}
?>

<!-- Campo de búsqueda -->
<div class="buscador-container">
    <input type="text" id="buscador-input" placeholder="Buscar página..." autocomplete="off">
    <ul id="sugerencias-lista" class="sugerencias"></ul>
</div>

<!-- Estilos básicos -->
<style>
.buscador-container {
    position: relative;
    width: 280px;
    margin-right: 20px;
}

#buscador-input {
    width: 100%;
    padding: 8px !important;
    font-size: 16px !important;
    border-radius: 8px !important; /* Esto hará que sea redondeado */
    border: 1px solid #ccc !important;
}

#buscador-input::placeholder {
    color: #999; /* Gris tenue */
    opacity: 1; /* Para asegurar que sea visible */
    font-style: Verdana;
}

.sugerencias {
    position: absolute;
    border: 1px solid #ccc;
    border-top: none;
    max-height: 200px;
    overflow-y: auto;
    list-style: none;
    margin: 0;
    padding: 0;
    background: white;
    z-index: 1000;
    width: 100%;
    display: none;
    color: black;
}

.sugerencias li {
    padding: 10px;
    cursor: pointer;
    border-bottom: 1px solid #eee;
}

.sugerencias li:hover {
    background-color: #f0f0f0;
}
</style>

<!-- Script de autocompletado -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById('buscador-input');
    const lista = document.getElementById('sugerencias-lista');

    // Ruta absoluta del archivo PHP que devuelve los resultados
    const urlBase = '/Sistemas/Sistemas/particular/busqueda-dinamica.php';

    input.addEventListener('input', function () {
        const termino = input.value.trim();

        if (termino.length < 1) {
            lista.style.display = 'none';
            return;
        }

        // Llamada AJAX para buscar coincidencias
        fetch(`${urlBase}?ajax=1&q=${encodeURIComponent(termino)}`)
            .then(response => {
                if (!response.ok) throw new Error("Error en la respuesta del servidor.");
                return response.json();
            })
            .then(data => {
                lista.innerHTML = '';
                if (data.length === 0) {
                    const item = document.createElement('li');
                    item.textContent = 'No se encontraron resultados.';
                    lista.appendChild(item);
                    lista.style.display = 'block';
                    return;
                }

                data.forEach(pagina => {
                    const item = document.createElement('li');
                    item.textContent = pagina.nombre;
                    item.setAttribute('data-url', pagina.url);
                    item.addEventListener('click', () => {
                        window.location.href = pagina.url;
                    });
                    lista.appendChild(item);
                });

                lista.style.display = 'block';
            })
            .catch(error => {
                console.error('Error en la búsqueda:', error);
                lista.innerHTML = '<li>Error al cargar resultados.</li>';
                lista.style.display = 'block';
            });
    });

    // Ocultar sugerencias al hacer clic fuera del buscador
    document.addEventListener('click', function (e) {
        if (!document.querySelector('.buscador-container').contains(e.target)) {
            lista.style.display = 'none';
        }
    });
});
</script>