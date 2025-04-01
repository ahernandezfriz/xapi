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
    <title>Pregunta de Completar Espacio</title>
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
                "question": "La capital de Chile es ___________.",
                "answer": "Santiago",
                "interactionType": "fill-in" // Agregamos el tipo de interacción
            };

            const questionEl = document.getElementById("question");
            const optionsEl = document.getElementById("options"); // Ya no serán botones
            const feedbackEl = document.getElementById("feedback");
            const submitButton = document.getElementById("submit");
            let userAnswer = null;

            questionEl.textContent = quizData.question;

            // Crear un campo de entrada de texto para la respuesta
            const inputField = document.createElement("input");
            inputField.type = "text";
            inputField.id = "userAnswer";
            optionsEl.appendChild(inputField);

            submitButton.onclick = function () {
                const userAnswerElement = document.getElementById("userAnswer");
                if (!userAnswerElement.value.trim()) {
                    feedbackEl.textContent = "Por favor, ingresa tu respuesta.";
                    feedbackEl.className = "feedback incorrect";
                    return;
                }
                userAnswer = userAnswerElement.value.trim();
                const isCorrect = userAnswer.toLowerCase() === quizData.answer.toLowerCase(); // Comparación sin distinguir mayúsculas
                feedbackEl.textContent = isCorrect ? "¡Correcto!" : `Incorrecto. La respuesta correcta es: ${quizData.answer}`;
                feedbackEl.className = isCorrect ? "feedback correct" : "feedback incorrect";

                const resultData = {
                    question: quizData.question,
                    interactionType: quizData.interactionType,
                    selectedOption: userAnswer, // Ahora guardamos la respuesta del usuario
                    correctAnswer: quizData.answer,
                    isCorrect: isCorrect
                };
                console.log("Resultado enviado (Pregunta2.php):", resultData);
                procesarRespuesta(resultData);
            };
        });
    </script>

    <script src="js/procesarPregunta2.js"></script>
</body>
</html>