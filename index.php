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
    <title>Pregunta de Selección Múltiple</title>
    <link rel="stylesheet" href="css/style.css"></link>
    <script src="js/xapiwrapper.min.js"></script>
    
</head>
<body>
    <div class="container">
        <h2 id="question"></h2>
        <div id="options"></div>
        <button id="submit" class="submit-button">Responder</button>
        <p id="feedback" class="feedback"></p>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const quizData = {
                "question": "¿Cuál es el lenguaje de programación usado para la web?",
                "options": ["Python", "JavaScript", "C++", "Java"],
                "answer": "JavaScript"
            };

            const questionEl = document.getElementById("question");  // COntenedor Pregunta
            const optionsEl = document.getElementById("options");    // Contenedor Opciones
            const feedbackEl = document.getElementById("feedback");  // COntenedor Feedback
            const submitButton = document.getElementById("submit");  // Boton enviar
            let selectedOption = null;

            questionEl.textContent = quizData.question;
            
            // Mezclar las opciones de forma aleatoria
            const shuffledOptions = quizData.options.sort(() => Math.random() - 0.5);

            shuffledOptions.forEach(option => {
                const button = document.createElement("button");
                button.textContent = option;
                button.className = "option-button";
                button.onclick = function () {
                    document.querySelectorAll(".option-button").forEach(btn => btn.classList.remove("selected"));
                    button.classList.add("selected");
                    selectedOption = option;
                };
                optionsEl.appendChild(button);
            });

            // Validar que se seleccionar
            submitButton.onclick = function () {
                if (!selectedOption) {
                    feedbackEl.textContent = "Por favor, selecciona una opción.";
                    feedbackEl.className = "feedback incorrect";
                    return;
                }
                const isCorrect = selectedOption === quizData.answer;
                feedbackEl.textContent = isCorrect ? "¡Muy bien!" : "Incorrecto";
                feedbackEl.className = isCorrect ? "feedback correct" : "feedback incorrect";
                
                // Enviar datos a la consola (simulación de envío a backend)
                const resultData = {
                    question: quizData.question,
                    options: quizData.options,
                    selectedOption: selectedOption,
                    correctAnswer: quizData.answer,
                    isCorrect: isCorrect
                };
                console.log("Resultado enviado (en el Index):", resultData);

                // Llamar a la función para procesar la respuesta y enviar a xAPI
                procesarRespuesta(resultData);
            };
        });
    </script>


        <script src="js/procesarPregunta.js"></script>
</body>
</html>