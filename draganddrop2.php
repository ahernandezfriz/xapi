<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividad Drag and Drop</title>

    <style>
        /* Estilos Globales */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9fafb;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow-x: hidden;
        }

        h2 {
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #4CAF50;
        }

        button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }

        p#feedback {
            text-align: center;
            font-size: 18px;
            margin-top: 10px;
            color: #4CAF50;
        }

        /* Contenedor Principal */
        .main-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 800px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Zonas de Drop */
        .drop-zones {
            display: flex;
            justify-content: space-around;
            width: 100%;
            margin-top: 20px;
        }

        .drop-zone-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .drop-label {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #4CAF50;
        }

        .drop-zone {
            width: 120px;
            height: 120px;
            border: 2px dashed #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f8f8;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .drop-zone.highlight {
            border-color: #4CAF50;
            background-color: rgba(76, 175, 80, 0.1);
            transform: scale(1.05);
        }

        .drop-zone.correct {
            border-color: #4CAF50;
            background-color: rgba(76, 175, 80, 0.2);
            animation: pulse 0.5s ease;
        }

        .drop-zone.incorrect {
            border-color: #FF5733;
            background-color: rgba(255, 87, 51, 0.2);
            animation: shake 0.4s ease-in-out;
        }

        /* Elementos Arrastrables */
        .draggable-items {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .drag-item {
            width: 100px;
            height: 100px;
            cursor: grab;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .drag-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        .drag-item.dragging {
            opacity: 0.5;
            transform: scale(1.1);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Animaciones */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        @keyframes shake {
            0% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
            100% { transform: translateX(0); }
        }
    </style>
</head>
<body>
    
    <!--
    <div class="container">
        <div class="draggable-items">
            <img src="img/impresora.jpg" class="drag-item" data-id="1" data-correct="zona1" draggable="true">
            <img src="img/computador.jpg" class="drag-item" data-id="2" data-correct="zona2" draggable="true">
            <img src="img/notebook.jpg" class="drag-item" data-id="3" data-correct="zona3" draggable="true">
            <img src="img/modem.jpg" class="drag-item" data-id="distractor" data-correct="none" draggable="true">
        </div>

        <div class="drop-zones">
            <div class="drop-zone-container">
                <div class="drop-label">Zona 1</div>
                <div class="drop-zone" id="zona1"></div>
            </div>
            <div class="drop-zone-container">
                <div class="drop-label">Zona 2</div>
                <div class="drop-zone" id="zona2"></div>
            </div>
            <div class="drop-zone-container">
                <div class="drop-label">Zona 3</div>
                <div class="drop-zone" id="zona3"></div>
            </div>
        </div>
    </div>
    -->
    <div class="main-container">
        <h2>Arrastra cada imagen a la zona correcta</h2>

        <!-- Zonas de Drop -->
        <div class="drop-zones">
            <div class="drop-zone-container">
                <div class="drop-label">Zona 1</div>
                <div class="drop-zone" id="zona1"></div>
            </div>
            <div class="drop-zone-container">
                <div class="drop-label">Zona 2</div>
                <div class="drop-zone" id="zona2"></div>
            </div>
            <div class="drop-zone-container">
                <div class="drop-label">Zona 3</div>
                <div class="drop-zone" id="zona3"></div>
            </div>
        </div>

        <!-- Elementos Arrastrables -->
        <div class="draggable-items" id="draggable-items-container">
            <img src="img/impresora.jpg" class="drag-item" data-id="1" data-correct="zona1" draggable="true">
            <img src="img/computador.jpg" class="drag-item" data-id="2" data-correct="zona2" draggable="true">
            <img src="img/notebook.jpg" class="drag-item" data-id="3" data-correct="zona3" draggable="true">
            <img src="img/modem.jpg" class="drag-item" data-id="distractor" data-correct="none" draggable="true">
        </div>

        <button onclick="verificarRespuestas()">Verificar</button>
        <p id="feedback"></p>
    </div>

    <script src="js/dragDrop2.js"></script>
</body>
</html>
