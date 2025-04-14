<?php
// Configuración de las cabeceras (debe ir al principio del archivo PHP)
/*header( 'Access-Control-Allow-Credentials: true' );
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
*/
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
        .content-titulo{
            background-color: #153a63;
            padding: 10px 30px;
            margin-bottom: 30px;
        }
        .content-titulo h2{
            color: #fff;
            font-weight: 400;
            font-size: 17px;
            margin: 5px;
        }
        .container {
            display: flex;
            justify-content: center;
            flex-wrap:wrap;
            gap: 20px;
            margin-bottom:30px;
        }
        .drop-zone {
            width: 400px;
            min-height: 150px;
            border: 1px solid #d7d7d7;
            padding: 10px;
            border-radius: 5px;
            background-color: #ffffff;
            text-align: center;
        }
        .drop-zone-titulo{
            background: #e3e3e3;
            padding: 5px;
            border-radius: 5px;
            color: #000000;
            margin-bottom: 10px;
            font-weight: 700;
        }
        .drag-item {
            padding: 10px;
            margin: 5px;
            background-color: #fcdda7;
            border: 1px solid #edcc93;
            border-radius: 5px;
            color: #003966;
            cursor: grab;
            min-width: 150px;
        }

        button{
            background: #153a63;
            border: none;
            padding: 8px 20px;
            color: #fff;
            cursor:pointer;
            float: right;
            margin-right: 30px;
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
     <script src="js/xapiwrapper.min.js"></script>
</head>
<body>
    <div style="max-width: 930px; height:545px; margin: 0 auto; background: #fbfbfb;">
        <div class="content-titulo">
            <h2>Clasifica los elementos en Software o Hardware</h2>
        </div>
        

        <div class="container">
        <div id="hardware" class="drop-zone"><div class="drop-zone-titulo">Hardware</div></div>
        <div id="software" class="drop-zone"><div class="drop-zone-titulo">Software</div></div>
        </div>
        <div id="items" class="container">

        </div>
        <button onclick="verificarRespuestas()">Comprobar</button>
        <p id="feedback"></p>
    </div>
    

    <script src="js/procesarDragDrop.js"></script>
</body>
</html>