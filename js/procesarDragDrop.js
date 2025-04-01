document.addEventListener("DOMContentLoaded", () => {
    // Selecciona todos los elementos arrastrables y las zonas de destino
    const itemsContainer = document.getElementById("items");
    const dropZones = document.querySelectorAll(".drop-zone");

    console.log("Items:", items);
    console.log("Drop Zones:", dropZones);


     // Datos de los elementos arrastrables
     const dragItemsData = [
        { id: "Mouse", type: "hardware" },
        { id: "Teclado", type: "hardware" },
        { id: "Monitor", type: "hardware" },
        { id: "Word", type: "software" },
        { id: "Excel", type: "software" },
        { id: "Chrome", type: "software" }
    ];

     // Función para mezclar elementos aleatoriamente
     function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }

     // Crear elementos arrastrables de forma dinámica
     const shuffledItems = shuffleArray(dragItemsData);

     shuffledItems.forEach(itemData => {
         const item = document.createElement("div");
         item.className = "drag-item";
         item.draggable = true;
         item.dataset.id = itemData.id;
         item.dataset.type = itemData.type;
         item.innerText = itemData.id;

         // Evento de inicio de arrastre
         item.addEventListener("dragstart", (event) => {
             event.dataTransfer.setData("text/plain", JSON.stringify({
                 id: event.target.dataset.id,
                 type: event.target.dataset.type
             }));
         });

         itemsContainer.appendChild(item);
     });

        // Agregar eventos a las zonas de destino
    dropZones.forEach(zone => {
        zone.addEventListener("dragover", (event) => {
            event.preventDefault();
        });

        zone.addEventListener("drop", (event) => {
            event.preventDefault();
            const data = JSON.parse(event.dataTransfer.getData("text/plain"));
            const draggedItem = document.querySelector(`.drag-item[data-id="${data.id}"]`);

            if (draggedItem) {
                event.target.appendChild(draggedItem);
            } else {
                console.error("Elemento no encontrado:", data);
            }
        });
    });
});



// Función para verificar si los elementos fueron colocados correctamente
function verificarRespuestas() {
    const correctAnswers = {
        "hardware": ["Mouse", "Teclado", "Monitor"],
        "software": ["Word", "Excel", "Chrome"]
    };

    let results =[];

        let allCorrect = true;

        document.querySelectorAll(".drop-zone").forEach(zone => {
            const zoneId = zone.id;
            const itemsInZone = Array.from(zone.children).map(item => item.dataset.id);

            itemsInZone.forEach(itemId => {
                const isCorrect = correctAnswers[zoneId].includes(itemId);

                results.push({
                    item: itemId,
                    category: zoneId,
                    correct: isCorrect
                });

                const item = document.querySelector(`.drag-item[data-id="${itemId}"]`);

                if (item) {
                    item.classList.add(isCorrect ? "correct" : "incorrect");
                }

                if (!isCorrect) allCorrect = false;
            });
        });


         // Imprime los resultados en la consola para depuración
         console.log("Resultados de la verificación:", results);
    console.log("Resultados de la verificación:", results.every(r => r.correct));

        document.getElementById("feedback").innerText = allCorrect ? "¡Todo correcto!" : "Algunas respuestas son incorrectas.";
    
    // Envía los resultados a xAPI

    //enviarA_xAPI(results);
}

// Función para enviar los resultados a un LRS usando xAPI
function enviarA_xAPI(results) {

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

    const statement = {
        "actor": {
            "mbox": "mailto:usuario@example.com", // Correo del usuario (puede ser dinámico)
            "name": "Usuario",
            "objectType": "Agent"
        },
        "verb": {
            "id": "http://adlnet.gov/expapi/verbs/completed", // Acción realizada
            "display": { "en-US": "completed" }
        },
        "object": {
            "id": "http://example.com/drag-and-drop", // Identificador único del ejercicio
            "definition": {
                "name": { "en-US": "Drag and Drop Exercise" },
                "description": { "en-US": "Ejercicio de drag and drop" }
            }
        },
        "result": {
            "success": results.every(r => r.correct), // Indica si todas las respuestas fueron correctas
            "response": JSON.stringify(results) // Guarda los resultados en formato JSON
        }
    };
    
    // Envía la declaración a xAPI usando xAPIWrapper
    ADL.XAPIWrapper.sendStatement(statement);
}

