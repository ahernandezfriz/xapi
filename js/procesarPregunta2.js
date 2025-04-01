// Configuración de xAPI

//const username = "1d1851feeb1c0568654c4b6fbdd8195253718d552ca71f1af8ab3940e16a4fb6";
//const password = "f718950afdb18fb31a425072b4dfa8240fb8df570436facf40a942e17fc6bac5";

const username= 'KLcGUfRtvVFQFEMUXcE';
const password= '_Wx46NC9J_BT-4yUmMA';

const xapiConfig = {
    endpoint: 'https://cloud.scorm.com/lrs/VHZKZQF1QN/sandbox/statement/',
    user: username,
    password: password,
    headers: {
        'Content-Type': 'application/json',
        'X-Experience-API-Version': '1.0.3',
        'Accept': 'application/json',
        'Cache-Control': 'no-cache',
        'Authorization': 'Basic ' + btoa(username + ':' + password)
    }
};

// Inicializar la configuración de xAPIWrapper
ADL.XAPIWrapper.changeConfig(xapiConfig);

// Función que procesa la respuesta y la envía a xAPI
function procesarRespuesta(resultData) {
    console.log("Resultado en (procesarPregunta2.js):", resultData);

    // Declaración xAPI
    const statement = {
        actor: {
            mbox: "mailto:ariel@example.com", // Reemplaza con el email real del usuario
            name: "Ariel",
            objectType: "Agent"
        },
        verb: {
            id: "http://adlnet.gov/expapi/verbs/answered",
            display: { "en-US": "answered" }
        },
        object: {
            id: "http://example.com/quiz/" + encodeURIComponent(resultData.question),
            definition: {
                name: { "en-US": resultData.question },
                description: { "en-US": "Pregunta de completar el espacio en blanco en el cuestionario." },
                type: "http://adlnet.gov/expapi/activities/cmi.interaction",
                interactionType: "fill-in", // Especificamos el tipo de interacción
                correctResponsesPattern: [resultData.correctAnswer] // La respuesta correcta esperada
            },
            objectType: "Activity"
        },
        result: {
            response: resultData.selectedOption, // La respuesta que el usuario ingresó
            success: resultData.isCorrect,
            completion: true,
            score: {
                raw: resultData.isCorrect ? 100 : 0,
                min: 0,
                max: 100
            }
        }
    };

    // Enviar declaración xAPI al LRS
    ADL.XAPIWrapper.sendStatement(statement, function (err, xhr) {
        if (err) {
            console.error("Error al enviar a xAPI:", err);
        } else {
            console.log("Declaración xAPI enviada con éxito:", statement);
        }
    });
}