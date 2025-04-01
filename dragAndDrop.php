<?php
// Configuración de las cabeceras (debe ir al principio del archivo PHP)
header( 'Access-Control-Allow-Credentials: true' );
header( 'Access-Control-Allow-Headers: Authorization, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Allow-Request-Method' );
header( 'Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE' );
header( 'Access-Control-Allow-Origin: *' );  // Permitir acceso desde cualquier origen o especifica un origen concreto
header( 'Access-Control-Expose-Headers: Link', false );
header( 'Content-Security-Policy: upgrade-insecure-requests' );
//header( 'Content-Security-Policy: form-action self; frame-src self ' . esc_url( home_url( '/' ) ) . '; frame-ancestors self ' . esc_url( home_url( '/' ) ) . ';' );
header( 'Permissions-Policy: geolocation=(), midi=(), sync-xhr=(), accelerometer=(), gyroscope=(), magnetometer=(), payment=(), camera=(), microphone=(), usb=(), fullscreen=(self)' );
header( 'Referrer-Policy: no-referrer, strict-origin-when-cross-origin' );
header( 'Strict-Transport-Security: max-age=31536000; includeSubDomains; preload' );
header( 'X-Content-Security-Policy: allow "self"' );
header( 'X-Content-Type-Options: nosniff' );
header( 'X-Frame-Options: SAMEORIGIN' );
header( 'X-Permitted-Cross-Domain-Policies: none' );
header( 'X-Powered-By: Pablo Masquiarán' );
header( 'X-XSS-Protection: 1; mode=block' );
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio de Drag and Drop</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        .container {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .drop-zone {
            width: 200px;
            min-height: 150px;
            border: 2px dashed #007bff;
            padding: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
            text-align: center;
        }
        .drag-item {
            padding: 10px;
            margin: 5px;
            background-color: #cce5ff;
            border: 1px solid #007bff;
            border-radius: 5px;
            cursor: grab;
        }
 

        .correct {
            background-color: #c8e6c9; /* Verde claro */
            border: 2px solid #2e7d32; /* Verde oscuro */
        }

        .incorrect {
            background-color: #ffcdd2; /* Rojo claro */
            border: 2px solid #c62828; /* Rojo oscuro */
        }
    </style>
</head>
<body>
    <h2>Clasifica los elementos en Software o Hardware</h2>
    <div id="items" class="container">
        <div class="drag-item" draggable="true" data-id="Mouse" data-type="hardware">Mouse</div>
        <div class="drag-item" draggable="true" data-id="Teclado" data-type="hardware">Teclado</div>
        <div class="drag-item" draggable="true" data-id="Monitor"  data-type="hardware">Monitor</div>
        <div class="drag-item" draggable="true" data-id="Word"  data-type="software">Word</div>
        <div class="drag-item" draggable="true" data-id="Excel"  data-type="software">Excel</div>
        <div class="drag-item" draggable="true"data-id="Chrome"  data-type="software">Chrome</div>
    </div>
    <div class="container">
        <div id="hardware" class="drop-zone">Hardware</div>
        <div id="software" class="drop-zone">Software</div>
    </div>
    <button onclick="verificarRespuestas()">Verificar</button>
    <p id="feedback"></p>

    <script src="js/procesarDragDrop.js"></script>
</body>
</html>